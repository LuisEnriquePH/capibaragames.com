<?php
require '../includes/auth.php';
require '../includes/upload.php';
require '../../includes/db.php';

$pageTitle = 'Nuevo Juego';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    requireCSRF();

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);
    $itchio_url = trim($_POST['itchio_url']);
    $release_date = $_POST['release_date'];

    // Manejo de Subida de Imagen Segura
    try {
        $uploadedPath = uploadImage('image_file', '../../assets/uploads/games/', 'assets/uploads/games/');
        if ($uploadedPath) {
            $image_url = $uploadedPath;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    if (!$error && !empty($title) && !empty($release_date)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO games (title, description, image_url, itchio_url, release_date) VALUES (:title, :description, :image_url, :itchio_url, :release_date)");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'image_url' => $image_url,
                'itchio_url' => $itchio_url,
                'release_date' => $release_date
            ]);
            $success = "Juego añadido exitosamente. <a href='index.php' class='link link-primary'>Volver a la lista</a>";
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    } else if (!$error) {
        $error = "El título y la fecha son obligatorios.";
    }
}

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Nuevo Juego</h1>
        <p class="text-base-content/60">Añadir un nuevo juego al portafolio</p>
    </div>
    <a href="index.php" class="btn btn-ghost">
        ← Volver
    </a>
</div>

<!-- Messages -->
<?php if ($error): ?>
    <div class="alert alert-error mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo $error; ?></span>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo $success; ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php csrfField(); ?>
            
            <!-- Title -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Título del Juego *</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Ej: Cyber Capibara 2077" 
                    class="input input-bordered w-full"
                    required
                />
            </div>

            <!-- Description -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Descripción</span>
                    <span class="label-text-alt">Breve descripción del juego</span>
                </label>
                <textarea 
                    name="description" 
                    class="textarea textarea-bordered h-24" 
                    placeholder="De qué trata el juego..."
                ></textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Imagen de Portada</span>
                </label>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="image_url" 
                            id="game-image"
                            placeholder="URL de la imagen o sube un archivo" 
                            class="input input-bordered w-full"
                        />
                    </div>
                    <label for="image-file-input" class="btn btn-outline cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Subir Imagen
                    </label>
                    <input 
                        type="file" 
                        name="image_file" 
                        id="image-file-input"
                        accept="image/*" 
                        class="hidden"
                        onchange="previewImage(this)"
                    />
                </div>
                <!-- Image Preview -->
                <div id="game-image-preview" class="mt-4"></div>
            </div>

            <!-- Itch.io URL -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Enlace a Itch.io</span>
                </label>
                <input 
                    type="url" 
                    name="itchio_url" 
                    placeholder="https://tu-usuario.itch.io/tu-juego" 
                    class="input input-bordered w-full"
                />
            </div>

            <!-- Release Date -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Fecha de Lanzamiento *</span>
                </label>
                <input 
                    type="date" 
                    name="release_date" 
                    class="input input-bordered w-full"
                    required
                />
            </div>

            <!-- Submit Button -->
            <div class="card-actions justify-end pt-4 border-t">
                <a href="index.php" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Publicar Juego
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview function
function previewImage(input) {
    const preview = document.getElementById('game-image-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="relative inline-block">
                    <img src="${e.target.result}" class="max-w-xs rounded-lg shadow-lg" alt="Preview">
                    <div class="mt-2 text-sm text-success">✓ Imagen seleccionada: ${input.files[0].name}</div>
                </div>
            `;
            document.getElementById('game-image').value = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../includes/footer-admin.php'; ?>
