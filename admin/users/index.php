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
<body>

    <header class="header admin-header">
        <div class="header__container admin-header__container">
            <div class="header__logo">
                <a href="../index.php" class="header__logo-text text-highlight">CAPIBARA ADMIN</a>
            </div>
            <nav class="header__nav d-flex align-center" style="gap: 20px;">
                <a href="../index.php" class="btn btn--secondary" style="font-size: 1rem; padding: 5px 10px;">← Volver al Panel</a>
                <a href="../logout.php" class="btn btn--primary" style="font-size: 1rem; padding: 5px 10px;">Salir</a>
            </nav>
        </div>
    </header>

    <main class="post-container" style="max-width: 1000px;">
        <div class="admin-page-header">
            <h1 class="page-header__title m-0">USUARIOS DEL SISTEMA</h1>
            <a href="create.php" class="btn btn--accent" style="width: auto;">+ NUEVO USUARIO</a>
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
                                <span style="text-transform: capitalize; color: var(--c-highlight);"><?php echo $u['role']; ?></span>
                            </td>
                            <td class="text-grey"><?php echo date("d/m/Y", strtotime($u['created_at'])); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $u['id']; ?>" class="text-highlight" style="margin-right: 10px;">Editar</a>
                                <?php if($u['username'] !== $_SESSION['username']): ?>
                                    <a href="delete.php?id=<?php echo $u['id']; ?>" class="text-white" onclick="return confirm('¿Seguro que quieres eliminar a este usuario?');">Borrar</a>
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
