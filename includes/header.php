<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // SEO: Dynamic meta tags
    $pageTitle = isset($pageTitle) ? $pageTitle : "Capibara Games - Desarrollo Indie de Videojuegos";
    $metaDescription = isset($metaDescription) ? $metaDescription : "Portfolio de desarrollo indie de videojuegos por Capibara Games. Descubre nuestros proyectos, devlogs y contenido sobre creación de juegos.";
    $currentUrl = "https://capibaragames.com/" . basename($_SERVER['PHP_SELF']);
    ?>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($currentUrl); ?>">
    
    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($currentUrl); ?>">
    <meta property="og:site_name" content="Capibara Games">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- CSS with cache-busting -->
    <link rel="stylesheet" href="css/base.css?v=<?php echo filemtime('css/base.css'); ?>">
    <link rel="stylesheet" href="css/layout.css?v=<?php echo filemtime('css/layout.css'); ?>">
    <link rel="stylesheet" href="css/components.css?v=<?php echo filemtime('css/components.css'); ?>">
    <link rel="stylesheet" href="css/pages.css?v=<?php echo filemtime('css/pages.css'); ?>">
    <link rel="stylesheet" href="css/utilities.css?v=<?php echo filemtime('css/utilities.css'); ?>">
</head>
<body>

    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">Saltar al contenido principal</a>

    <header class="header">
        <div class="header__container">
            <a href="index.php" class="header__logo">
                <img src="assets/uploads/images/Logotipo.png" alt="Capibara Games Logo" class="logo-img">
                <span class="logo-text">CAPIBARA GAMES</span>
            </a>

            <!-- Botón Menú Hamburguesa (Móvil) -->
            <button class="menu-toggle" aria-label="Abrir menú">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="header__nav" id="main-nav">
                <ul class="nav__list">
                    <?php $paginaActual = basename($_SERVER['PHP_SELF']); ?>
                    
                    <li>
                        <a href="about.php" class="nav__link <?php echo ($paginaActual == 'about.php') ? 'active' : ''; ?>">ABOUT</a>
                    </li>
                    <li>
                        <a href="blog.php" class="nav__link <?php echo ($paginaActual == 'blog.php' || $paginaActual == 'post.php') ? 'active' : ''; ?>">BLOG</a>
                    </li>
                    <li>
                        <a href="contact.php" class="nav__link <?php echo ($paginaActual == 'contact.php') ? 'active' : ''; ?>">CONTACTO</a>
                    </li>
                    <li>
                        <a href="games.php" class="nav__link <?php echo ($paginaActual == 'games.php') ? 'active' : ''; ?>">GAMES</a>
                    </li>
                </ul>
            </nav>

            <div class="header__social">
                <a href="https://www.youtube.com/@CapibaraGamesDev" target="_blank" class="social-link" title="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/></svg>
                </a>
                <a href="https://itch.io" target="_blank" class="social-link" title="Itch.io">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16"><path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/><path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.492V4.02c0 .418.323.748.735.776a8.5 8.5 0 0 0 4.02 0c.412-.028.735-.358.735-.776v-1.4a.5.5 0 0 1 .62-.492l1.932.518a.5.5 0 0 1 .354.613a11.02 11.02 0 0 1-.731 3.25a.5.5 0 0 1-.689.155l-.887-.514a.5.5 0 0 0-.279-.117l-.89.049a2.4 2.4 0 0 1-1.67-.327l-.375-.245a.5.5 0 0 0-.48 0l-.375.245a2.4 2.4 0 0 1-1.67.327l-.89-.049a.5.5 0 0 0-.279.117l-.887.514a.5.5 0 0 1-.689-.155A11.02 11.02 0 0 1 3.05 3.26zM8 9.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7"/></svg>
                </a>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.querySelector('.menu-toggle');
            const nav = document.querySelector('.header__nav');
            
            if (menuToggle && nav) {
                menuToggle.addEventListener('click', () => {
                    nav.classList.toggle('active');
                });
            }
        });
    </script>