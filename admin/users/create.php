<?php
require '../includes/auth.php';
require '../../includes/db.php';

$pageTitle = 'Nuevo Usuario';

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
                $success = "Usuario creado exitosamente. <a href='index.php' class='link link-primary'>Volver a la lista</a>";
            }
        } catch (PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Nuevo Usuario</h1>
        <p class="text-base-content/60">Crear un nuevo usuario en el sistema</p>
    </div>
    <a href="index.php" class="btn btn-ghost">
        ← Volver
    </a>
</div>

<!-- Messages -->
<?php if ($error): ?>
    <div class="alert alert-error mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo $error; ?></span>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo $success; ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
    <div class="card-body">
        <form method="POST" class="space-y-6">
            <?php csrfField(); ?>
            
            <!-- Username -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Nombre de Usuario *</span>
                </label>
                <input 
                    type="text" 
                    name="username" 
                    placeholder="Ej: editor1" 
                    class="input input-bordered w-full"
                    required
                />
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Contraseña *</span>
                    <span class="label-text-alt">Mínimo 6 caracteres</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="••••••••" 
                    class="input input-bordered w-full"
                    minlength="6"
                    required
                />
            </div>

            <!-- Role -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Rol *</span>
                </label>
                <select name="role" class="select select-bordered w-full">
                    <option value="editor">Editor</option>
                    <option value="admin">Administrador</option>
                </select>
                <label class="label">
                    <span class="label-text-alt text-warning">⚠️ Los administradores tienen acceso total al panel</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="card-actions justify-end pt-4 border-t">
                <a href="index.php" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer-admin.php'; ?>
