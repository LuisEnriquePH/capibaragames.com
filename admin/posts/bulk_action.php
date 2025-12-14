<?php
require '../includes/auth.php';
require '../../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCSRF();
    
    $action = $_POST['action'] ?? '';
    $ids = $_POST['ids'] ?? [];
    
    if (empty($ids) || !is_array($ids)) {
        header('Location: index.php?error=no_selection');
        exit;
    }
    
    // Sanitize IDs
    $ids = array_map('intval', $ids);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    switch ($action) {
        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM posts WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $message = count($ids) . ' post(s) eliminado(s)';
            break;
            
        case 'publish':
            $stmt = $pdo->prepare("UPDATE posts SET status = 'published' WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $message = count($ids) . ' post(s) publicado(s)';
            break;
            
        case 'draft':
            $stmt = $pdo->prepare("UPDATE posts SET status = 'draft' WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $message = count($ids) . ' post(s) convertido(s) a borrador';
            break;
            
        default:
            header('Location: index.php?error=invalid_action');
            exit;
    }
    
    header('Location: index.php?success=' . urlencode($message));
    exit;
}

header('Location: index.php');
exit;
?>
