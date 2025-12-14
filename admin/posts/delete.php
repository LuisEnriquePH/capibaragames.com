<?php
require '../includes/auth.php';
require '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // 1. Obtener imagen para borrarla
        $stmt = $pdo->prepare("SELECT image_url FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();

        // 2. Borrar archivo físico si existe
        if ($post && !empty($post['image_url'])) {
            $filePath = '../../' . $post['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // 3. Borrar registro de BD
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Redirigir de vuelta a la lista
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
