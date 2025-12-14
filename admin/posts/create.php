<?php
require '../includes/auth.php';
require '../includes/upload.php';
require '../../includes/db.php';

$pageTitle = 'Nuevo Post';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    requireCSRF();

    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $content = $_POST['content'];
    $image_url = trim($_POST['image_url']);
    $status = $_POST['status'];

    // Manejo de Subida de Imagen Segura
    try {
        $uploadedPath = uploadImage('image_file', '../../assets/uploads/posts/', 'assets/uploads/posts/');
        if ($uploadedPath) {
            $image_url = $uploadedPath;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    // Generar Slug simple
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    if (!$error && !empty($title) && !empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (title, slug, excerpt, content, image_url, status) VALUES (:title, :slug, :excerpt, :content, :image_url, :status)");
            $stmt->execute([
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'image_url' => $image_url,
                'status' => $status
            ]);
            $success = "Artículo creado exitosamente. <a href='index.php' class='link link-primary'>Volver a la lista</a>";
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    } else if (!$error) {
        $error = "El título y el contenido son obligatorios.";
    }
}

include '../includes/header-admin.php';
?>

<!-- EasyMDE CSS -->
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Nuevo Artículo</h1>
        <p class="text-base-content/60">Crear un nuevo post para el blog</p>
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
        <form id="post-form" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php csrfField(); ?>
            
            <!-- Title -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Título *</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Título del artículo" 
                    class="input input-bordered w-full"
                    required
                />
            </div>

            <!-- Excerpt -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Extracto</span>
                    <span class="label-text-alt">Breve descripción para vista previa</span>
                </label>
                <textarea 
                    name="excerpt" 
                    class="textarea textarea-bordered h-20" 
                    placeholder="Resumen breve del artículo..."
                ></textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Imagen Destacada</span>
                </label>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="image_url" 
                            id="post-image"
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
                <div id="post-image-preview" class="mt-4"></div>
            </div>

            <!-- Status -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Estado</span>
                </label>
                <select name="status" class="select select-bordered w-full">
                    <option value="draft">Borrador</option>
                    <option value="published">Publicado</option>
                </select>
            </div>

            <!-- Content Editor -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Contenido *</span>
                    <span class="label-text-alt">Markdown soportado</span>
                </label>
                <div class="border border-base-300 rounded-lg overflow-hidden">
                    <textarea id="content-editor" name="content"></textarea>
                </div>
                <label class="label">
                    <span class="label-text-alt">El contenido se guarda automáticamente cada 30 segundos</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="card-actions justify-end pt-4 border-t">
                <a href="index.php" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar Artículo
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EasyMDE JS -->
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

<script>
// Image preview function
function previewImage(input) {
    const preview = document.getElementById('post-image-preview');
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
            // Update the URL field with filename for reference
            document.getElementById('post-image').value = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize EasyMDE
var easyMDE = new EasyMDE({ 
    element: document.getElementById('content-editor'),
    spellChecker: false,
    autosave: {
        enabled: true,
        uniqueId: "create_post_content",
    },
    uploadImage: true,
    imageUploadEndpoint: "upload_image.php",
    imagePathAbsolute: false,
    imageCSRFToken: null,
    imageTexts: {
        sbInit: "Arrastra archivos aquí o haz click para subir",
        sbOnDragEnter: "¡Suelta la imagen!",
        sbOnDragLeave: "Arrastra archivos aquí",
        sbProgress: "Subiendo... (#progress#)",
        sbOnDrop: "Subiendo...",
        fail: "Error al subir imagen."
    },
    sideBySideFullscreen: false,
    previewClass: "editor-preview",
});

// Asegurar que el contenido se envíe correctamente
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('content-editor').value = easyMDE.value();
});

// Enable autosave for this form
const autosave = new AutoSave('post-form', 'draft_post_create', 30000);
</script>

<?php include '../includes/footer-admin.php'; ?>
