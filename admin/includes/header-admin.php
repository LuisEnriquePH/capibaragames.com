<!DOCTYPE html>
<html lang="es" data-theme="light">
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
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
                    <li><a href="<?php echo $basePath; ?>logout.php" class="text-error">🚪 Salir</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto p-4 md:p-8">
