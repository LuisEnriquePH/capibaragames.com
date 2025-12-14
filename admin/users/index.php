<?php
require '../includes/auth.php';
require '../../includes/db.php';

// Obtener usuarios
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Capibara Admin</title>
    
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
            <h1 class="page-header__title m-0">USUARIOS DEL SISTEMA</h1>
            <a href="create.php" class="btn btn--accent w-auto">+ NUEVO USUARIO</a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>#<?php echo $u['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($u['username']); ?></strong>
                                <?php if($u['username'] === $_SESSION['username']): ?>
                                    <span class="badge-self">(TÚ)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-highlight text-capitalize"><?php echo $u['role']; ?></span>
                            </td>
                            <td class="text-grey"><?php echo date("d/m/Y", strtotime($u['created_at'])); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $u['id']; ?>" class="text-highlight mr-2">Editar</a>
                                <?php if($u['username'] !== $_SESSION['username']): ?>
                                    <a href="delete.php?id=<?php echo $u['id']; ?>&csrf_token=<?php echo htmlspecialchars(generateCSRFToken()); ?>" class="text-white" data-delete-confirm data-item-name="<?php echo htmlspecialchars($${file##*/}['title'] ?? $${file##*/}['username'] ?? 'elemento'); ?>"('¿Seguro que quieres eliminar a este usuario?');">Borrar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
