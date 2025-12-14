<?php
require '../includes/auth.php';
require '../includes/csrf.php';
require '../../includes/db.php';

if (isset($_GET['id'])) {
    // Verify CSRF token
    requireCSRF();

    $id = $_GET['id'];
    
    try {
        // 1. Obtener imagen para borrarla
        $stmt = $pdo->prepare("SELECT image_url FROM games WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $game = $stmt->fetch();

        // 2. Borrar archivo físico si existe
        if ($game && !empty($game['image_url'])) {
            $filePath = '../../' . $game['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // 3. Borrar registro de BD
        $stmt = $pdo->prepare("DELETE FROM games WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit;
}
?>
