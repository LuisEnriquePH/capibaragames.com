<?php
require '../includes/auth.php';
require '../../includes/db.php';

// Obtener juegos
$stmt = $pdo->query("SELECT * FROM games ORDER BY release_date DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Juegos - Capibara Admin</title>
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/components.css">
    <link rel="stylesheet" href="../../css/pages.css">
    <link rel="stylesheet" href="../../css/utilities.css">
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body class="admin-page">

    <header class="header admin-header">
        <div class="header__container admin-header__container">
            <div class="header__logo">
                <a href="../index.php" class="header__logo-text text-highlight">CAPIBARA ADMIN</a>
            </div>
            <nav class="header__nav d-flex align-center admin-nav-gap">
                <a href="../index.php" class="btn btn--secondary admin-btn-sm">← Volver al Panel</a>
                <a href="../logout.php" class="btn btn--primary admin-btn-sm">Salir</a>
            </nav>
        </div>
    </header>

    <main class="post-container max-w-1000">
        <div class="admin-page-header">
            <h1 class="page-header__title m-0">JUEGOS PUBLICADOS</h1>
            <a href="create.php" class="btn btn--accent w-auto">+ NUEVO JUEGO</a>
        </div>

        <?php if (empty($games)): ?>
            <p class="text-center text-light-grey">No hay juegos en el portafolio aún.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Img</th>
                            <th>Título</th>
                            <th>Lanzamiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($games as $game): ?>
                            <tr>
                                <td>
                                    <?php if($game['image_url']): ?>
                                        <img src="<?php echo htmlspecialchars($game['image_url']); ?>" alt="Thumb" class="admin-thumb">
                                    <?php else: ?>
                                        <span>📷</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($game['title']); ?></strong>
                                </td>
                                <td class="text-grey"><?php echo date("d/m/Y", strtotime($game['release_date'])); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $game['id']; ?>" class="text-highlight mr-2">Editar</a>
                                    <a href="delete.php?id=<?php echo $game['id']; ?>" class="text-white" onclick="return confirm('¿Seguro que quieres eliminar este juego?');">Borrar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>
