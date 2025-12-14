<?php
require '../includes/auth.php';
require '../../includes/db.php';

$pageTitle = 'Posts';

// Obtener posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Gestionar Posts</h1>
        <p class="text-base-content/60">Total: <?php echo count($posts); ?> artículos</p>
    </div>
    <a href="create.php" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Artículo
    </a>
</div>

<!-- Search and Filters -->
<div class="card bg-base-100 shadow-md mb-6">
    <div class="card-body p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="input-group w-full">
                    <span class="bg-base-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input 
                        type="search" 
                        id="search-posts" 
                        placeholder="Buscar por título..." 
                        class="input input-bordered w-full"
                        onkeyup="filterTable(this, 'posts-table')"
                    />
                </div>
            </div>
            
            <!-- Status Filter -->
            <div class="w-full md:w-64">
                <select id="status-filter" class="select select-bordered w-full" onchange="filterByStatus()">
                    <option value="">Todos los estados</option>
                    <option value="published">Publicados</option>
                    <option value="draft">Borradores</option>
                </select>
            </div>
        </div>
    </div>
</div>

<?php if (empty($posts)): ?>
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>No hay artículos creados aún.</span>
    </div>
<?php else: ?>
    <!-- Bulk Actions Form -->
    <form id="bulk-form" method="POST" action="bulk_action.php">
        <?php csrfField(); ?>
        
        <!-- Bulk Actions Bar -->
        <div class="card bg-base-100 shadow-md mb-4">
            <div class="card-body p-4">
                <div class="flex flex-col sm:flex-row flex-wrap gap-4 items-start sm:items-center">
                    <label class="label cursor-pointer gap-2">
                        <input 
                            type="checkbox" 
                            id="select-all" 
                            class="checkbox checkbox-primary"
                            onclick="selectAll(this, 'bulk-checkbox')"
                            title="Seleccionar todos"
                        />
                        <span class="label-text font-medium">Seleccionar todos</span>
                    </label>
                    
                    <div class="flex-1 min-w-[200px]">
                        <select name="action" class="select select-bordered w-full" required>
                            <option value="">Acción masiva...</option>
                            <option value="delete">🗑️ Borrar seleccionados</option>
                            <option value="publish">✅ Publicar</option>
                            <option value="draft">📝 Convertir a borrador</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-accent">Aplicar</button>
                </div>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="overflow-x-auto">
            <table id="posts-table" class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th class="w-12">
                            <span class="sr-only">Checkbox</span>
                        </th>
                        <th>Título</th>
                        <th class="hidden md:table-cell">Estado</th>
                        <th class="hidden md:table-cell">Fecha</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr class="hover" data-status="<?php echo htmlspecialchars($post['status']); ?>">
                        <td>
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="ids[]" 
                                    value="<?php echo $post['id']; ?>" 
                                    class="checkbox checkbox-sm bulk-checkbox"
                                />
                            </label>
                        </td>
                        <td>
                            <div class="font-semibold">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </div>
                            <?php if (!empty($post['excerpt'])): ?>
                                <div class="text-sm text-base-content/60 truncate max-w-md">
                                    <?php echo htmlspecialchars(substr($post['excerpt'], 0, 80)); ?>...
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="hidden md:table-cell">
                            <?php if ($post['status'] === 'published'): ?>
                                <span class="badge badge-success gap-2">
                                    ✓ Publicado
                                </span>
                            <?php else: ?>
                                <span class="badge badge-warning gap-2">
                                    📝 Borrador
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="hidden md:table-cell">
                            <div class="text-sm">
                                <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                            </div>
                            <div class="text-xs text-base-content/60">
                                <?php echo date('H:i', strtotime($post['created_at'])); ?>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="edit.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-ghost" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="delete.php?id=<?php echo $post['id']; ?>" style="display: inline;" 
                                      onsubmit="return confirmDelete('<?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?>')">
                                    <?php csrfField(); ?>
                                    <button type="submit" class="btn btn-sm btn-error btn-outline" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
<?php endif; ?>

<script>
// Filter by status function
function filterByStatus() {
    const filter = document.getElementById('status-filter').value;
    const rows = document.querySelectorAll('#posts-table tbody tr');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        if (filter === '' || status === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Confirm delete function
function confirmDelete(title) {
    return confirm(`¿Estás seguro de que quieres eliminar "${title}"?`);
}
</script>

<?php include '../includes/footer-admin.php'; ?>
