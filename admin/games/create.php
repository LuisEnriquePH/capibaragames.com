<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../includes/upload.php';
require '../../includes/db.php';

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
            $success = "Juego añadido exitosamente. <a href='index.php'>Volver a la lista</a>";
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
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
    <title>Nuevo Juego - Capibara Admin</title>
    
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
        <h1 class="page-header__title mb-2 text-center">NUEVO JUEGO</h1>

        <?php if ($error): ?>
            <p class="text-center text-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="text-center text-green mb-2"><?php echo $success; ?></p>
        <?php else: ?>

        <form action="create.php" method="POST" class="contact-form" enctype="multipart/form-data">
            <?php csrfField(); ?>
            <div class="form__group">
                <label class="form__label">Título del Juego</label>
                <input type="text" name="title" class="form__input" required placeholder="Ej: Cyber Capibara 2077">
            </div>

            <div class="form__group">
                <label class="form__label">Descripción Corta</label>
                <textarea name="description" class="form__textarea" rows="4" placeholder="De qué trata el juego..."></textarea>
            </div>

            <div class="form__group">
                <label class="form__label">Imagen de Portada (Subir Archivo)</label>
                <input type="file" name="image_file" class="form__input" accept="image/*">
            </div>

            <div class="form__group">
                <label class="form__label">O pegar URL de Imagen (Opcional)</label>
                <input type="text" name="image_url" class="form__input" placeholder="https://...">
            </div>

            <div class="form__group">
                <label class="form__label">Enlace a Itch.io</label>
                <input type="url" name="itchio_url" class="form__input" placeholder="https://tu-usuario.itch.io/tu-juego">
            </div>

            <div class="form__group">
                <label class="form__label">Fecha de Lanzamiento</label>
                <input type="date" name="release_date" class="form__input" required>
            </div>

            <button type="submit" class="btn btn--accent w-100">PUBLICAR JUEGO</button>
        </form>

        <?php endif; ?>
    </main>

</body>
</html>
