<?php
require '../includes/auth.php';
require '../../includes/db.php';

$error = '';
$success = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener datos
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuario no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($username)) {
        try {
            if (!empty($password)) {
                // Actualizar todo inc password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id";
                $params = [
                    'username' => $username,
                    'password' => $hashed_password,
                    'role' => $role,
                    'id' => $id
                ];
            } else {
                // Solo actualizar info, mantener password
                $sql = "UPDATE users SET username = :username, role = :role WHERE id = :id";
                $params = [
                    'username' => $username,
                    'role' => $role,
                    'id' => $id
                ];
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            // Recargar
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $success = "Usuario actualizado correctamente.";
        } catch (PDOException $e) {
            $error = "Error al actualizar: " . $e->getMessage();
        }
    } else {
        $error = "El usuario es obligatorio.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Capibara Admin</title>
    
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/components.css">
    <link rel="stylesheet" href="../../css/pages.css">
    <link rel="stylesheet" href="../../css/utilities.css">
</head>
<body>

    <header class="header" style="padding: 1rem 0; background: var(--c-bg-card); border-bottom: 2px solid var(--c-accent-purple);">
        <div class="header__container" style="justify-content: space-between;">
            <div class="header__logo">
                <a href="../index.php" class="header__logo-text text-highlight">CAPIBARA ADMIN</a>
            </div>
            <nav class="header__nav d-flex align-center" style="gap: 20px;">
                <a href="index.php" class="btn btn--secondary" style="font-size: 1rem; padding: 5px 10px;">Cancelar</a>
            </nav>
        </div>
    </header>

    <main class="post-container" style="max-width: 600px;">
        <h1 class="page-header__title mb-2 text-center">EDITAR USUARIO</h1>

        <?php if ($error): ?>
            <p class="text-center" style="color: #ff6b6b; margin-bottom: 1rem;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="text-center text-green mb-2"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="edit.php?id=<?php echo $user['id']; ?>" method="POST" class="contact-form">
            <div class="form__group">
                <label class="form__label">Usuario</label>
                <input type="text" name="username" class="form__input" required value="<?php echo htmlspecialchars($user['username']); ?>">
            </div>

            <div class="form__group">
                <label class="form__label">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" class="form__input" placeholder="Dejar en blanco para no cambiar">
            </div>

            <div class="form__group">
                <label class="form__label">Rol</label>
                <select name="role" class="form__input" style="background:var(--c-bg-dark); color:white;">
                    <option value="editor" <?php if($user['role'] == 'editor') echo 'selected'; ?>>Editor</option>
                    <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn--accent w-100">ACTUALIZAR USUARIO</button>
        </form>
    </main>

</body>
</html>
