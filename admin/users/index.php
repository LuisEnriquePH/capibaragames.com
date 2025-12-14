<?php
require '../includes/auth.php';
require '../../includes/db.php';

$pageTitle = 'Users';

// Obtener usuarios
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Gestionar Usuarios</h1>
        <p class="text-base-content/60">Total: <?php echo count($users); ?> usuarios</p>
    </div>
    <a href="create.php" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Usuario
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
                id="search-users" 
                placeholder="Buscar usuario..." 
                class="input input-bordered w-full"
                onkeyup="filterTable(this, 'users-table')"
            />
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="overflow-x-auto">
    <table id="users-table" class="table table-zebra w-full">
        <thead>
            <tr>
                <th class="w-16">ID</th>
                <th>Usuario</th>
                <th class="hidden md:table-cell">Rol</th>
                <th class="hidden md:table-cell">Registro</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr class="hover">
                <td>
                    <span class="text-base-content/60">#<?php echo $u['id']; ?></span>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-10">
                                <span class="text-sm"><?php echo strtoupper(substr($u['username'], 0, 2)); ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold">
                                <?php echo htmlspecialchars($u['username']); ?>
                                <?php if($u['username'] === $_SESSION['username']): ?>
                                    <span class="badge badge-sm badge-primary ml-2">TÚ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="hidden md:table-cell">
                    <?php if($u['role'] === 'admin'): ?>
                        <span class="badge badge-primary gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Admin
                        </span>
                    <?php else: ?>
                        <span class="badge badge-ghost gap-2">
                            Usuario
                        </span>
                    <?php endif; ?>
                </td>
                <td class="hidden md:table-cell">
                    <div class="text-sm">
                        <?php echo date('d/m/Y', strtotime($u['created_at'])); ?>
                    </div>
                    <div class="text-xs text-base-content/60">
                        <?php echo date('H:i', strtotime($u['created_at'])); ?>
                    </div>
                </td>
                <td class="text-right">
                    <div class="flex gap-2 justify-end">
                        <a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-ghost" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <?php if($u['username'] !== $_SESSION['username']): ?>
                            <form method="POST" action="delete.php?id=<?php echo $u['id']; ?>" style="display: inline;" 
                                  onsubmit="return confirmDelete('<?php echo htmlspecialchars($u['username'], ENT_QUOTES); ?>')">
                                <?php csrfField(); ?>
                                <button type="submit" class="btn btn-sm btn-error btn-outline" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="btn btn-sm btn-disabled" title="No puedes eliminarte a ti mismo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Confirm delete function
function confirmDelete(username) {
    return confirm(`¿Estás seguro de que quieres eliminar al usuario "${username}"?`);
}
</script>

<?php include '../includes/footer-admin.php'; ?>
