<?php
/**
 * Endpoint para subir imágenes vía AJAX desde EasyMDE
 */
require '../includes/auth.php';
require '../includes/upload.php';

header('Content-Type: application/json');

try {
    // Verificar si hay archivo
    if (!isset($_FILES['image'])) {
        throw new Exception('No se recibió ninguna imagen.');
    }

    // Usar la función de upload segura existente
    // Guardamos en assets/uploads/posts/
    $publicPath = uploadImage('image', '../../assets/uploads/posts/', 'assets/uploads/posts/');

    if ($publicPath) {
        // EasyMDE espera: { "data": { "filePath": "<url>" } }
        echo json_encode([
            'data' => [
                'filePath' => '../../' . $publicPath // Ruta relativa desde admin/posts/
            ]
        ]);
    } else {
        throw new Exception('Error desconocido al subir la imagen.');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
