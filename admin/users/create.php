<?php
require '../includes/auth.php';
require '../includes/upload.php';
require '../../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    requireCSRF();
    
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        try {
            // Verificar si existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($stmt->fetchColumn() > 0) {
                $error = "El nombre de usuario ya existe.";
            } else {
                // Hashear password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
                $stmt->execute([
                    'username' => $username,
                    'password' => $hashed_password,
                    'role' => $role
                ]);
                $success = "Usuario creado exitosamente. <a href='index.php'>Volver a la lista</a>";
            }
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario - Capibara Admin</title>
    
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
                <a href="index.php" class="btn btn--secondary admin-btn-sm">Cancelar</a>
            </nav>
        </div>
    </header>

    <main class="post-container max-w-600">
        <h1 class="page-header__title mb-2 text-center">NUEVO USUARIO</h1>

        <?php if ($error): ?>
            <p class="text-center text-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="text-center text-green mb-2"><?php echo $success; ?></p>
        <?php else: ?>

        <form action="create.php" method="POST" class="contact-form">
            <?php csrfField(); ?>
            <div class="form__group">
                <label class="form__label">Usuario</label>
                <input type="text" name="username" class="form__input" required placeholder="Ej: editor1">
            </div>

            <div class="form__group">
                <label class="form__label">Contraseña</label>
                <input type="password" name="password" class="form__input" required placeholder="******">
            </div>

            <div class="form__group">
                <label class="form__label">Rol</label>
                <select name="role" class="form__input bg-dark-input">
                    <option value="editor">Editor</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn--accent w-100">CREAR USUARIO</button>
        </form>

        <?php endif; ?>
    </main>

</body>
</html>
