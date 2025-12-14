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
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS matching current design exactly -->
    <style>
        :root {
            --c-bg-dark: #333333;
            --c-bg-card: #222222;
            --c-green-main: #85D13E;
            --c-green-light: #93DB46;
            --c-green-dark: #57B82;
            --c-accent-purple: #4B0082;
            --c-highlight: #FFD700;
            --c-white: #FEFFFE;
            --c-black: #000000;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
            background-attachment: fixed;
            color: var(--c-white);
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        /* Header styling to match current */
        .header-custom {
            position: sticky;
            top: 0;
            background: linear-gradient(90deg, rgba(10, 10, 10, 0.98) 0%, rgba(26, 26, 46, 0.98) 100%);
            border-bottom: 2px solid var(--c-accent-purple);
            padding: 1.5rem 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .logo-text {
            font-family: "Jersey 10", sans-serif;
            font-size: 1.8rem;
            color: var(--c-white);
            text-shadow: 3px 3px 0px var(--c-black);
        }
        
        .nav-link {
            font-family: "Jersey 10", sans-serif;
            font-size: 1.5rem;
            color: var(--c-white);
            transition: all 0.3s;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: var(--c-green-main);
            text-shadow: 0 0 10px rgba(133, 209, 62, 0.3);
        }
        
        .social-icon {
            color: var(--c-green-main);
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            color: var(--c-highlight);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:left-0 bg-green-500 text-black px-4 py-2 z-50">
        Saltar al contenido principal
    </a>

    <header class="header-custom">
        <div class="max-w-7xl mx-auto px-5 flex justify-between items-center flex-wrap">
            <!-- Logo -->
            <a href="index.php" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity">
                <img src="assets/uploads/images/Logotipo.png" alt="Capibara Games Logo" class="h-20 w-20">
                <span class="logo-text hidden sm:inline">CAPIBARA GAMES</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:block">
                <ul class="flex gap-8">
                    <?php $paginaActual = basename($_SERVER['PHP_SELF']); ?>
                    
                    <li>
                        <a href="about.php" class="nav-link <?php echo ($paginaActual == 'about.php') ? 'active' : ''; ?>">
                            ABOUT
                        </a>
                    </li>
                    <li>
                        <a href="blog.php" class="nav-link <?php echo ($paginaActual == 'blog.php' || $paginaActual == 'post.php') ? 'active' : ''; ?>">
                            BLOG
                        </a>
                    </li>
                    <li>
                        <a href="contact.php" class="nav-link <?php echo ($paginaActual == 'contact.php') ? 'active' : ''; ?>">
                            CONTACTO
                        </a>
                    </li>
                    <li>
                        <a href="games.php" class="nav-link <?php echo ($paginaActual == 'games.php') ? 'active' : ''; ?>">
                            GAMES
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Social Links & Mobile Menu -->
            <div class="flex items-center gap-4">
                <!-- Social Links (Desktop) -->
                <div class="hidden sm:flex gap-4">
                    <a href="https://www.youtube.com/@CapibaraGamesDev" 
                       target="_blank" 
                       class="social-icon"
                       title="YouTube"
                       aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
                        </svg>
                    </a>
                    <a href="https://itch.io" 
                       target="_blank" 
                       class="social-icon"
                       title="Itch.io"
                       aria-label="Itch.io">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/>
                            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.492V4.02c0 .418.323.748.735.776a8.5 8.5 0 0 0 4.02 0c.412-.028.735-.358.735-.776v-1.4a.5.5 0 0 1 .62-.492l1.932.518a.5.5 0 0 1 .354.613a11.02 11.02 0 0 1-.731 3.25a.5.5 0 0 1-.689.155l-.887-.514a.5.5 0 0 0-.279-.117l-.89.049a2.4 2.4 0 0 1-1.67-.327l-.375-.245a.5.5 0 0 0-.48 0l-.375.245a2.4 2.4 0 0 1-1.67.327l-.89-.049a.5.5 0 0 0-.279.117l-.887.514a.5.5 0 0 1-.689-.155A11.02 11.02 0 0 1 3.05 3.26zM8 9.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7"/>
                        </svg>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button 
                    id="mobile-menu-btn"
                    class="lg:hidden flex flex-col gap-1.5 p-2.5 cursor-pointer border-none bg-transparent"
                    aria-label="Abrir menú">
                    <span class="block w-7 h-0.5 transition-all duration-300" style="background-color: var(--c-green-main);"></span>
                    <span class="block w-7 h-0.5 transition-all duration-300" style="background-color: var(--c-green-main);"></span>
                    <span class="block w-7 h0.5 transition-all duration-300" style="background-color: var(--c-green-main);"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <nav id="mobile-menu" class="lg:hidden hidden w-full mt-4 border-t" style="background: linear-gradient(135deg, rgba(18, 18, 28, 0.95), rgba(30, 30, 46, 0.9)); border-color: #333;">
            <ul class="flex flex-col">
                <li>
                    <a href="about.php" 
                       class="block py-4 px-5 nav-link text-center border-b hover:bg-black/20 <?php echo ($paginaActual == 'about.php') ? 'active' : ''; ?>"
                       style="border-color: #333;">
                        ABOUT
                    </a>
                </li>
                <li>
                    <a href="blog.php" 
                       class="block py-4 px-5 nav-link text-center border-b hover:bg-black/20 <?php echo ($paginaActual == 'blog.php' || $paginaActual == 'post.php') ? 'active' : ''; ?>"
                       style="border-color: #333;">
                        BLOG
                    </a>
                </li>
                <li>
                    <a href="contact.php" 
                       class="block py-4 px-5 nav-link text-center border-b hover:bg-black/20 <?php echo ($paginaActual == 'contact.php') ? 'active' : ''; ?>"
                       style="border-color: #333;">
                        CONTACTO
                    </a>
                </li>
                <li>
                    <a href="games.php" 
                       class="block py-4 px-5 nav-link text-center border-b hover:bg-black/20 <?php echo ($paginaActual == 'games.php') ? 'active' : ''; ?>"
                       style="border-color: #333;">
                        GAMES
                    </a>
                </li>
                <!-- Social in mobile -->
                <li class="flex justify-center gap-6 py-4">
                    <a href="https://www.youtube.com/@CapibaraGamesDev" target="_blank" class="social-icon" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.180.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
                        </svg>
                    </a>
                    <a href="https://itch.io" target="_blank" class="social-icon" aria-label="Itch.io">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z"/>
                            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.492V4.02c0 .418.323.748.735.776a8.5 8.5 0 0 0 4.02 0c.412-.028.735-.358.735-.776v-1.4a.5.5 0 0 1 .62-.492l1.932.518a.5.5 0 0 1 .354.613a11.02 11.02 0 0 1-.731 3.25a.5.5 0 0 1-.689.155l-.887-.514a.5.5 0 0 0-.279-.117l-.89.049a2.4 2.4 0 0 1-1.67-.327l-.375-.245a.5.5 0 0 0-.48 0l-.375.245a2.4 2.4 0 0 1-1.67.327l-.89-.049a.5.5 0 0 0-.279.117l-.887.514a.5.5 0 0 1-.689-.155A11.02 11.02 0 0 1 3.05 3.26zM8 9.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
