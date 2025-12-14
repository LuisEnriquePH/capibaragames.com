<?php
require '../includes/auth.php';
require '../includes/upload.php';
require '../../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $success = "Artículo creado exitosamente. <a href='index.php'>Volver a la lista</a>";
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    } else {
        $error = "El título y el contenido son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Post - Capibara Admin</title>
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/components.css">
    <link rel="stylesheet" href="../../css/pages.css">
    <link rel="stylesheet" href="../../css/utilities.css">
    <link rel="stylesheet" href="../../css/admin.css">

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <style>
        /* Estilos para el editor y preview */
        .editor-preview {
            background-color: var(--c-bg-dark) !important;
            color: var(--c-light-grey) !important;
            font-family: var(--f-body);
            line-height: 1.8;
            padding: 2rem !important;
        }
        .editor-preview h1, .editor-preview h2, .editor-preview h3 {
            font-family: var(--f-title);
            color: var(--c-white);
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }
        .editor-preview a { color: var(--c-highlight); text-decoration: underline; }
        .editor-preview blockquote { border-left-color: var(--c-green-main); color: var(--c-grey); padding-left: 1rem; }
        .editor-preview code { background: rgba(255,255,255,0.1); padding: 0.2rem 0.4rem; border-radius: 4px; color: var(--c-accent); }
        .editor-toolbar { border-color: #444; background: #222; opacity: 1; }
        .editor-toolbar i { color: #ccc; }
        .editor-toolbar i:hover { color: white; background: #444; }
        .CodeMirror { border-color: #444; background: #1a1a1a; color: #ddd; }
        .CodeMirror-cursor { border-left: 1px solid white; }
    </style>
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
        <h1 class="page-header__title mb-2 text-center">NUEVO ARTÍCULO</h1>

        <?php if ($error): ?>
            <p class="text-center text-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="text-center text-green mb-2"><?php echo $success; ?></p>
        <?php else: ?>

        <form action="create.php" method="POST" class="contact-form" enctype="multipart/form-data">
            <div class="form__group">
                <label class="form__label">Título</label>
                <input type="text" name="title" class="form__input" required placeholder="Ej: Mi primer devlog">
            </div>

            <div class="form__group">
                <label class="form__label">Extracto (Resumen corto)</label>
                <textarea name="excerpt" class="form__textarea" rows="3" placeholder="Un breve resumen para la tarjeta del blog..."></textarea>
            </div>

            <div class="form__group">
                <label class="form__label">Imagen de Portada (Subir Archivo)</label>
                <input type="file" name="image_file" class="form__input" accept="image/*">
            </div>

            <div class="form__group">
                <label class="form__label">O pegar URL de Imagen (Opcional)</label>
                <input type="text" name="image_url" class="form__input" placeholder="assets/uploads/images/...">
            </div>

            <div class="form__group">
                <label class="form__label">Estado</label>
                <select name="status" class="form__input form-select-dark">
                    <option value="draft">Borrador</option>
                    <option value="published">Publicado</option>
                </select>
            </div>

            <div class="form__group">
                <label class="form__label">Contenido</label>
                <div class="editor-wrapper">
                    <textarea id="content-editor" name="content"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn--accent w-100">GUARDAR ARTÍCULO</button>
        </form>

        <?php endif; ?>
    </main>

    <!-- EasyMDE JS -->
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
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
                sbOnDropped: "Subiendo...",
                fail: "Error al subir imagen."
            },
            sideBySideFullscreen: false,
            previewClass: "editor-preview", // Usar nuestra clase personalizada
        });

        // Asegurar que el contenido se envíe correctamente
        document.querySelector('form').addEventListener('submit', function() {
            // Actualiza el textarea original con el valor del editor
            document.getElementById('content-editor').value = easyMDE.value();
        });
    </script>
</body>
</html>
