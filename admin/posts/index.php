<?php
require '../includes/auth.php';
require '../../includes/db.php';

// Obtener posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Posts - Capibara Admin</title>
    
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
            <h1 class="page-header__title m-0">POSTS DEL BLOG</h1>
            <a href="create.php" class="btn btn--accent w-auto">+ NUEVO ARTÍCULO</a>
        </div>

        <?php if (empty($posts)): ?>
            <p class="text-center text-light-grey">No hay artículos creados aún.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td class="text-grey">#<?php echo $post['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                </td>
                                <td>
                                    <?php 
                                        $status = $post['status'] ?? 'draft'; 
                                        $modifier = ($status === 'published') ? 'status-badge--published' : 'status-badge--draft';
                                        $label = ($status === 'published') ? 'Publicado' : 'Borrador';
                                    ?>
                                    <span class="status-badge <?php echo $modifier; ?>"><?php echo $label; ?></span>
                                </td>
                                <td class="text-grey"><?php echo date("d/m/Y", strtotime($post['created_at'])); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $post['id']; ?>" class="text-highlight mr-2">Editar</a>
                                    <a href="delete.php?id=<?php echo $post['id']; ?>&csrf_token=<?php echo htmlspecialchars(generateCSRFToken()); ?>" class="text-white" data-delete-confirm data-item-name="<?php echo htmlspecialchars($${file##*/}['title'] ?? $${file##*/}['username'] ?? 'elemento'); ?>"('¿Seguro que quieres borrar este artículo?');">Borrar</a>
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
