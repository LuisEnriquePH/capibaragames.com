<?php
require '../includes/auth.php';
require '../includes/upload.php';
require '../../includes/db.php';


$error = '';
$success = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener datos actuales
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = :id");
$stmt->execute(['id' => $id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$game) {
    die("Juego no encontrado.");
}

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
            // Si la imagen está vacía (ni subida ni URL), mantenemos la anterior (opcional, aunque aquí parece que se sobreescribe)
            // Mejor lógica: si $image_url está vacío, no lo actualizamos O asumimos que el usuario lo borró.
            // En este caso, el usuario ve el valor actual en el input, así que si lo deja, se envía.
            
            $sql = "UPDATE games SET title = :title, description = :description, image_url = :image_url, itchio_url = :itchio_url, release_date = :release_date WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'image_url' => $image_url,
                'itchio_url' => $itchio_url,
                'release_date' => $release_date,
                'id' => $id
            ]);
            
            // Recargar datos
            $stmt = $pdo->prepare("SELECT * FROM games WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $game = $stmt->fetch(PDO::FETCH_ASSOC);

            $success = "Juego actualizado correctamente.";
        } catch (PDOException $e) {
            $error = "Error al actualizar: " . $e->getMessage();
        }
    } else {
        $error = "El título y la fecha son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Juego - Capibara Admin</title>
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/components.css">
    <link rel="stylesheet" href="../../css/pages.css">
    <link rel="stylesheet" href="../../css/utilities.css">
</head>
<body class="admin-page">

    <header class="header admin-header">
        <div class="header__container admin-header__container">
            <div class="header__logo">
                <a href="../index.php" class="header__logo-text text-highlight">CAPIBARA ADMIN</a>
            </div>
            <nav class="header__nav d-flex align-center admin-nav-gap">
                <a href="index.php" class="btn btn--secondary admin-btn-sm">Cancelar</a>
            </nav>
        </div>
    </header>

    <main class="post-container max-w-800">
        <h1 class="page-header__title mb-2 text-center">EDITAR JUEGO</h1>

        <?php if ($error): ?>
            <p class="text-center text-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="text-center text-green mb-2"><?php echo $success; ?></p>
        <?php endif; ?>

        <form id="admin-form" action="edit.php?id=<?php echo $game['id']; ?>" method="POST" class="contact-form" enctype="multipart/form-data">
            <?php csrfField(); ?>
            <div class="form__group">
                <label class="form__label">Título del Juego</label>
                <input type="text" name="title" class="form__input" required value="<?php echo htmlspecialchars($game['title']); ?>">
            </div>


            <div class="form__group">
                <label class="form__label">Descripción Corta</label>
                <textarea name="description" class="form__textarea" rows="4"><?php echo htmlspecialchars($game['description']); ?></textarea>
            </div>

            <div class="form__group">
                <label class="form__label">Actualizar Portada (Subir Nuevo)</label>
                <input type="file" name="image_file" class="form__input" accept="image/*">
            </div>

            <div class="form__group">
                <label class="form__label">O pegar URL de Imagen</label>
                <input type="text" name="image_url" class="form__input" value="<?php echo htmlspecialchars($game['image_url']); ?>">
                <?php if($game['image_url']): ?>
                    <p class="text-light-grey fs-12 mt-1">Actual: <?php echo htmlspecialchars($game['image_url']); ?></p>
                <?php endif; ?>
            </div>

            <div class="form__group">
                <label class="form__label">Enlace a Itch.io</label>
                <input type="url" name="itchio_url" class="form__input" value="<?php echo htmlspecialchars($game['itchio_url']); ?>">
            </div>

            <div class="form__group">
                <label class="form__label">Fecha de Lanzamiento</label>
                <input type="date" name="release_date" class="form__input" required value="<?php echo htmlspecialchars($game['release_date']); ?>">
            </div>

            <button type="submit" class="btn btn--accent w-100">ACTUALIZAR JUEGO</button>
        </form>
    </main>

    <script src="../js/admin.js"></script>
</body>
</html>
