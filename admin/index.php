<?php
require 'includes/auth.php';
require '../includes/db.php';

$pageTitle = 'Dashboard';

// Get statistics
try {
    $totalPosts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
    $totalGames = $pdo->query("SELECT COUNT(*) FROM games")->fetchColumn();
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
} catch (PDOException $e) {
    $totalPosts = 0;
    $totalGames = 0;
    $totalUsers = 0;
}

include 'includes/header-admin.php';
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">Panel de Control</h1>
    <p class="text-base-content/60">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Posts Stat -->
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="stat-title">Posts</div>
            <div class="stat-value text-primary"><?php echo $totalPosts; ?></div>
            <div class="stat-desc">Total de artículos</div>
        </div>
    </div>

    <!-- Games Stat -->
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <div class="stat-title">Games</div>
            <div class="stat-value text-secondary"><?php echo $totalGames; ?></div>
            <div class="stat-desc">Total de juegos</div>
        </div>
    </div>

    <!-- Users Stat -->
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Users</div>
            <div class="stat-value text-accent"><?php echo $totalUsers; ?></div>
            <div class="stat-desc">Total de usuarios</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-4">Acciones Rápidas</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Posts Card -->
        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
            <div class="card-body items-center text-center">
                <div class="text-6xl mb-4">✍️</div>
                <h3 class="card-title">Blog Posts</h3>
                <p>Publicar nuevas entradas o editar las existentes.</p>
                <div class="card-actions justify-center mt-4">
                    <a href="posts/index.php" class="btn btn-primary">Gestionar Blog</a>
                </div>
            </div>
        </div>

        <!-- Games Card -->
        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
            <div class="card-body items-center text-center">
                <div class="text-6xl mb-4">🎮</div>
                <h3 class="card-title">Juegos</h3>
                <p>Añadir nuevos proyectos a tu portafolio.</p>
                <div class="card-actions justify-center mt-4">
                    <a href="games/index.php" class="btn btn-secondary">Gestionar Juegos</a>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
            <div class="card-body items-center text-center">
                <div class="text-6xl mb-4">👥</div>
                <h3 class="card-title">Usuarios</h3>
                <p>Gestionar accesos y roles.</p>
                <div class="card-actions justify-center mt-4">
                    <a href="users/index.php" class="btn btn-accent">Gestionar Usuarios</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer-admin.php'; ?>