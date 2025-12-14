<?php
require 'includes/auth.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Capibara Admin</title>
    
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/pages.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-page">

    <!-- Admin Header Reusing Components -->
    <header class="header admin-header">
        <div class="header__container admin-header__container">
            <div class="header__logo">
                <span class="header__logo-text text-highlight">CAPIBARA ADMIN</span>
            </div>
            
            <button class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="header__nav d-flex align-center admin-nav-gap">
                <span class="text-white fs-1">Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="../index.php" target="_blank" class="btn btn--secondary admin-btn-sm">Ver Web</a>
                <a href="logout.php" class="btn btn--primary admin-btn-sm">Salir</a>
            </nav>
        </div>
    </header>

    <main class="post-container max-w-1000">
        <h1 class="page-header__title mb-2 text-center">PANEL DE CONTROL</h1>
        
        <div class="games-grid">
            <!-- Card: Manage Posts -->
            <article class="card">
                <div class="card__body justify-center">
                    <span class="admin-dashboard-icon">✍️</span>
                    <h2 class="card__title">BLOG POSTS</h2>
                    <p class="mb-2 text-light-grey">Publicar nuevas entradas o editar las existentes.</p>
                    <a href="posts/index.php" class="btn btn--accent w-100">GESTIONAR BLOG</a>
                </div>
            </article>

            <!-- Card: Manage Games -->
            <article class="card">
                <div class="card__body justify-center">
                    <span class="admin-dashboard-icon">🎮</span>
                    <h2 class="card__title">JUEGOS</h2>
                    <p class="mb-2 text-light-grey">Añadir nuevos proyectos a tu portafolio.</p>
                    <a href="games/index.php" class="btn btn--accent w-100">GESTIONAR JUEGOS</a>
                </div>
            </article>

            <!-- Card: Manage Users -->
            <article class="card">
                <div class="card__body justify-center">
                    <span class="admin-dashboard-icon">👥</span>
                    <h2 class="card__title">USUARIOS</h2>
                    <p class="mb-2 text-light-grey">Gestionar accesos y roles.</p>
                    <a href="users/index.php" class="btn btn--accent w-100">GESTIONAR USUARIOS</a>
                </div>
            </article>
        </div>
    </main>
    
    <script src="../admin/js/admin.js"></script>
    <script>
        document.getElementById('mobile-menu').addEventListener('click', function() {
            document.querySelector('.header__nav').classList.toggle('active');
        });
    </script>

</body>
</html>