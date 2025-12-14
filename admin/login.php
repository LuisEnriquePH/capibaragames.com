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
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Capibara Admin</title>
    
    <!-- Tailwind CSS + DaisyUI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="avatar placeholder mb-4">
                    <div class="bg-primary text-primary-content rounded-full w-20">
                        <span class="text-3xl">🎮</span>
                    </div>
                </div>
                <h2 class="card-title text-3xl font-bold justify-center mb-2">
                    Capibara Admin
                </h2>
                <p class="text-base-content/60">Iniciar sesión en el panel</p>
            </div>

            <!-- Error Alert -->
            <?php if($error): ?>
                <div class="alert alert-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login.php" method="POST" class="space-y-4">
                <!-- Username -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Usuario</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Ingresa tu usuario" 
                        class="input input-bordered w-full" 
                        required 
                        autofocus
                    />
                </div>

                <!-- Password -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Contraseña</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        class="input input-bordered w-full" 
                        required
                    />
                </div>

                <!-- Submit Button -->
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Iniciar Sesión
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="divider text-xs">Capibara Games</div>
            <div class="text-center">
                <a href="../index.php" class="link link-primary text-sm">
                    ← Volver al sitio
                </a>
            </div>
        </div>
    </div>

</body>
</html>
