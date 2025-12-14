<!DOCTYPE html>
<html lang="es" data-theme="capibara-admin">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Admin'; ?> - Capibara Admin</title>
    
    <!-- Tailwind CSS + DaisyUI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Tailwind Config with Capibara Brand Colors -->
    <script>
        tailwind.config = {
            daisyui: {
                themes: [
                    {
                        "capibara-admin": {
                            "primary": "#85D13E",        // Capibara Green Main
                            "primary-content": "#000000",
                            
                            "secondary": "#FFD700",      // Yellow Highlight
                            "secondary-content": "#000000",
                            
                            "accent": "#4B0082",         // Purple Accent
                            "accent-content": "#ffffff",
                            
                            "neutral": "#222222",        // Card background
                            "neutral-content": "#FEFFFE",
                            
                            "base-100": "#333333",       // Grey dark background
                            "base-200": "#222222",       // Darker grey
                            "base-300": "#1a1a1a",       // Even darker
                            "base-content": "#FEFFFE",   // White text
                            
                            "info": "#3b82f6",
                            "success": "#85D13E",
                            "warning": "#FFD700",
                            "error": "#ef4444",
                        },
                    },
                ],
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #333333;
        }
        
        /* Card backgrounds matching brand */
        .card {
            background-color: #222222;
            border: 1px solid rgba(133, 209, 62, 0.2);
        }
        
        /* Custom scrollbar with green accent */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #222222;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #85D13E 0%, #93DB46 100%);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #57B82B 0%, #85D13E 100%);
        }
        
        /* Green gradient buttons matching brand */
        .btn-primary {
            background: linear-gradient(135deg, #85D13E 0%, #93DB46 100%);
            border: none;
            color: #000000;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #57B82B 0%, #85D13E 100%);
        }
        
        /* Navbar with subtle green accent */
        .navbar {
            background-color: #222222;
            border-bottom: 2px solid rgba(133, 209, 62, 0.3);
        }
    </style>
</head>
<body class="bg-base-200 min-h-screen">

    <?php
    // Determine base path for navigation
    $isInSubfolder = (basename(dirname($_SERVER['PHP_SELF'])) !== 'admin');
    $basePath = $isInSubfolder ? '../' : '';
    $publicPath = $isInSubfolder ? '../../' : '../';
    ?>

    <!-- Admin Navbar -->
    <div class="navbar bg-base-100 shadow-lg">
        <div class="navbar-start">
            <div class="dropdown">
                <button tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="<?php echo $basePath; ?>index.php">📊 Dashboard</a></li>
                    <li><a href="<?php echo $basePath; ?>posts/index.php">✍️ Posts</a></li>
                    <li><a href="<?php echo $basePath; ?>games/index.php">🎮 Games</a></li>
                    <li><a href="<?php echo $basePath; ?>users/index.php">👥 Users</a></li>
                </ul>
            </div>
            <a href="<?php echo $basePath; ?>index.php" class="btn btn-ghost text-xl font-bold">
                🎮 Capibara Admin
            </a>
        </div>
        
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="<?php echo $basePath; ?>index.php">📊 Dashboard</a></li>
                <li><a href="<?php echo $basePath; ?>posts/index.php">✍️ Posts</a></li>
                <li><a href="<?php echo $basePath; ?>games/index.php">🎮 Games</a></li>
                <li><a href="<?php echo $basePath; ?>users/index.php">👥 Users</a></li>
            </ul>
        </div>
        
        <div class="navbar-end gap-2">
            <div class="dropdown dropdown-end">
                <button tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                    <div class="bg-neutral text-neutral-content rounded-full w-10">
                        <span class="text-xl"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></span>
                    </div>
                </button>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li class="menu-title"><?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><a href="<?php echo $publicPath; ?>index.php" target="_blank">🌐 Ver Sitio</a></li>
<li>
                        <form action="<?php echo $basePath; ?>logout.php" method="POST" class="w-full p-0">
                            <?php csrfField(); ?>
                            <button type="submit" class="text-error w-full text-left py-2 px-4 hover:bg-base-200">🚪 Salir</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto p-4 md:p-8">
