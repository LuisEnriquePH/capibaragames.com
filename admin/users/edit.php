<?php
require '../includes/auth.php';
require '../../includes/db.php';

$pageTitle = 'Editar Usuario';

$error = '';
$success = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Obtener datos actuales
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuario no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    requireCSRF();
    
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = trim($_POST['password']);

    if (!empty($username)) {
        try {
            // Verificar si el nuevo username ya existe (excepto el actual)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username AND id != :id");
            $stmt->execute(['username' => $username, 'id' => $id]);
            if ($stmt->fetchColumn() > 0) {
                $error = "El nombre de usuario ya existe.";
            } else {
                // Si hay nueva contraseña, hashearla
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'username' => $username,
                        'password' => $hashed_password,
                        'role' => $role,
                        'id' => $id
                    ]);
                } else {
                    // Sin cambiar la contraseña
                    $sql = "UPDATE users SET username = :username, role = :role WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'username' => $username,
                        'role' => $role,
                        'id' => $id
                    ]);
                }
                
                $success = "Usuario actualizado exitosamente. <a href='index.php' class='link link-primary'>Volver a la lista</a>";
                
                // Reload data
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $error = "Error al actualizar: " . $e->getMessage();
        }
    } else {
        $error = "El nombre de usuario es obligatorio.";
    }
}

include '../includes/header-admin.php';
?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Editar Usuario</h1>
        <p class="text-base-content/60">ID: <?php echo $user['id']; ?></p>
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
                    value="<?php echo htmlspecialchars($user['username']); ?>"
                    placeholder="Ej: editor1" 
                    class="input input-bordered w-full"
                    required
                />
            </div>

            <!-- Password -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Nueva Contraseña</span>
                    <span class="label-text-alt">Dejar en blanco para mantener la actual</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="••••••••" 
                    class="input input-bordered w-full"
                    minlength="6"
                />
            </div>

            <!-- Role -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Rol *</span>
                </label>
                <select name="role" class="select select-bordered w-full">
                    <option value="editor" <?php echo ($user['role'] === 'editor') ? 'selected' : ''; ?>>Editor</option>
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer-admin.php'; ?>
