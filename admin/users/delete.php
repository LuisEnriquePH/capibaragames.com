<?php
require '../includes/auth.php';
require '../../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Protección: obtener usuario a borrar
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        if ($user) {
            // No permitir borrarse a sí mismo
            if ($user['username'] === $_SESSION['username']) {
                die("No puedes borrarte a ti mismo.");
            }

            $stmtDelete = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmtDelete->execute(['id' => $id]);
        }
        
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
