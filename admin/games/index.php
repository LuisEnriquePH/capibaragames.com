<?php
require '../includes/auth.php';
require '../../includes/db.php';

$pageTitle = 'Games';

// Obtener juegos
$stmt = $pdo->query("SELECT * FROM games ORDER BY release_date DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Gestionar Juegos</h1>
        <p class="text-base-content/60">Total: <?php echo count($games); ?> juegos</p>
    </div>
    <a href="create.php" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Juego
    </a>
</div>

<!-- Search -->
<div class="card bg-base-100 shadow-md mb-6">
    <div class="card-body p-4">
        <div class="input-group w-full">
            <span class="bg-base-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input 
                type="search" 
                id="search-games" 
                placeholder="Buscar juego por título..." 
                class="input input-bordered w-full"
                onkeyup="filterTable(this, 'games-table')"
            />
        </div>
    </div>
</div>

<?php if (empty($games)): ?>
    <div class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>No hay juegos en el portafolio aún.</span>
    </div>
<?php else: ?>
    <!-- Games Table -->
    <div class="overflow-x-auto">
        <table id="games-table" class="table table-zebra w-full">
            <thead>
                <tr>
                    <th class="w-24">Imagen</th>
                    <th>Título</th>
                    <th class="hidden md:table-cell">Fecha Lanzamiento</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game): ?>
                <tr class="hover">
                    <td>
                        <?php if($game['image_url']): ?>
                            <div class="avatar">
                                <div class="w-16 rounded">
                                    <img src="../../<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded w-16">
                                    <span class="text-2xl">🎮</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="font-semibold">
                            <?php echo htmlspecialchars($game['title']); ?>
                        </div>
                        <?php if (!empty($game['description'])): ?>
                            <div class="text-sm text-base-content/60 truncate max-w-md">
                                <?php echo htmlspecialchars(substr($game['description'], 0, 60)); ?>...
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="hidden md:table-cell">
                        <div class="text-sm">
                            <?php echo date('d/m/Y', strtotime($game['release_date'])); ?>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex gap-2 justify-end">
                            <a href="edit.php?id=<?php echo $game['id']; ?>" class="btn btn-sm btn-ghost" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="delete.php?id=<?php echo $game['id']; ?>" style="display: inline;" 
                                  onsubmit="return confirmDelete('<?php echo htmlspecialchars($game['title'], ENT_QUOTES); ?>')">
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
<?php endif; ?>

<script>
// Confirm delete function
function confirmDelete(title) {
    return confirm(`¿Estás seguro de que quieres eliminar "${title}"?`);
}
</script>

<?php include '../includes/footer-admin.php'; ?>
