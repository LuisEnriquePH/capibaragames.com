<?php
session_start();
require '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Buscar usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Capibara Admin</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { max-width: 400px; width: 100%; margin: 20px; }
    </style>
</head>
<body>

    <article class="card login-card">
        <div class="card__header">
            <span class="badge badge--game">ADMIN</span>
        </div>
        <div class="card__body">
            <h2 class="card__title text-highlight mb-2">INICIAR SESIÓN</h2>
            
            <?php if($error): ?>
                <p class="text-center" style="color: #ff6b6b; margin-bottom: 1rem;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div style="margin-bottom: 1rem; text-align: left;">
                    <label style="display: block; margin-bottom: 5px; color: var(--c-green-main); font-family: var(--f-title);">Usuario</label>
                    <input type="text" name="username" style="width: 100%; padding: 10px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;" required>
                </div>
                
                <div style="margin-bottom: 2rem; text-align: left;">
                    <label style="display: block; margin-bottom: 5px; color: var(--c-green-main); font-family: var(--f-title);">Contraseña</label>
                    <input type="password" name="password" style="width: 100%; padding: 10px; background: #333; border: 1px solid #555; color: white; border-radius: 4px;" required>
                </div>

                <button type="submit" class="btn btn--accent w-100">ENTRAR</button>
            </form>
        </div>
    </article>

</body>
</html>
