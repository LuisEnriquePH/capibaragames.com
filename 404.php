<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    $pageTitle = "404 - Página no encontrada | Capibara Games";
    $metaDescription = "Lo sentimos, la página que buscas no existe.";
    ?>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    
    <!-- Fonts -->\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Jersey+10&family=Roboto:wght@300;400;700&display=swap\" rel=\"stylesheet\">
    
    <!-- CSS -->
    <link rel=\"stylesheet\" href=\"css/base.css\">
    <link rel=\"stylesheet\" href=\"css/layout.css\">
    <link rel=\"stylesheet\" href=\"css/components.css\">
    <link rel=\"stylesheet\" href=\"css/utilities.css\">
</head>
<body>
    <div class=\"post-container text-center\" style=\"min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;\">
        <h1 class=\"text-green-main\" style=\"font-size: 8rem; margin-bottom: 0;\">404</h1>
        <h2 class=\"text-white fs-4 mb-2\">¡Ups! Página no encontrada</h2>
        <p class=\"text-light-grey fs-2 mb-3\">Parece que esta página se perdió en el ciberespacio.</p>
        <div style=\"display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;\">
            <a href=\"index.php\" class=\"btn btn--accent\">Ir al inicio</a>
            <a href=\"blog.php\" class=\"btn btn--secondary\">Ver Blog</a>
            <a href=\"games.php\" class=\"btn btn--secondary\">Ver Juegos</a>
        </div>
    </div>
</body>
</html>
