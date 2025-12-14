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
            <h1 class="page-header__title">GESTIONAR POSTS</h1>
            <a href="create.php" class="btn btn--accent">Nuevo Artículo</a>
        </div>

        <!-- Search and Filters -->
        <div class="admin-filters mb-2">
            <input type="search" 
                   id="search-posts" 
                   class="admin-search-input" 
                   placeholder="🔍 Buscar por título..."
                   onkeyup="filterTable(this, 'posts-table')">
            
            <select id="status-filter" class="admin-filter-select" onchange="filterByStatus()">
                <option value="">Todos los estados</option>
                <option value="published">Publicados</option>
                <option value="draft">Borradores</option>
            </select>
        </div>

        <?php if (empty($posts)): ?>
            <p class="text-center text-light-grey">No hay artículos creados aún.</p>
        <?php else: ?>
            <!-- Bulk Actions Form -->
            <form id="bulk-form" method="POST" action="bulk_action.php">
                <?php csrfField(); ?>
                
                <div class="bulk-actions-bar mb-2">
                    <input type="checkbox" id="select-all" onclick="selectAll(this, 'bulk-checkbox')" title="Seleccionar todos">
                    <select name="action" class="admin-filter-select" required>
                        <option value="">Acción masiva...</option>
                        <option value="delete">🗑️ Borrar seleccionados</option>
                        <option value="publish">✅ Publicar</option>
                        <option value="draft">📝 Convertir a borrador</option>
                    </select>
                    <button type="submit" class="btn btn--primary admin-btn-sm">Aplicar</button>
                </div>
                
                <div class="table-responsive">
                <table class="admin-table" id="posts-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <?php
                            $label = ($post['status'] === 'published') ? 'Publicado' : 'Borrador';
                            $modifier = ($post['status'] === 'published') ? 'status-badge--published' : 'status-badge--draft';
                            ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?php echo $post['id']; ?>" class="bulk-checkbox"></td>
                                <td class="text-light-grey"><?php echo $post['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                </td>
                                <td class="text-grey">Admin</td>
                                <td>
                                    <span class="status-badge <?php echo $modifier; ?>"><?php echo $label; ?></span>
                                </td>
                                <td class="text-grey"><?php echo date("d/m/Y", strtotime($post['created_at'])); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $post['id']; ?>" class="text-highlight mr-2">Editar</a>
                                    <a href="delete.php?id=<?php echo $post['id']; ?>&csrf_token=<?php echo htmlspecialchars(generateCSRFToken()); ?>" class="text-white" data-delete-confirm data-item-name="<?php echo htmlspecialchars($post['title']); ?>">Borrar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </form>
        <?php endif; ?>
    </main>

    <script src="../js/admin.js"></script>
    <script>
        // Status filter function
        function filterByStatus() {
            const statusFilter = document.getElementById('status-filter').value.toLowerCase();
            const table = document.getElementById('posts-table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                if (!statusFilter) {
                    row.style.display = '';
                } else {
                    const statusBadge = row.querySelector('.status-badge').textContent.toLowerCase();
                    row.style.display = statusBadge.includes(statusFilter.replace('published', 'publicado').replace('draft', 'borrador')) ? '' : 'none';
                }
            });
        }
    </script>
</body>
</html>
