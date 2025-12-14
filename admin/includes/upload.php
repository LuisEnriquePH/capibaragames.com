<?php
/**
 * Procesa la subida de una imagen de forma segura.
 * 
 * @param string $inputName Nombre del input file en $_FILES
 * @param string $targetDir Directorio donde guardar (relativo al script que llama o absoluto)
 * @return string|null Retorna la ruta relativa del archivo guardado o null si no hubo subida
 * @throws Exception Si hay un error de validación o movimiento
 */
function uploadImage($inputName, $targetDirBase, $publicPathBase) {
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$inputName];

    // 1. Validar MIME Type real (no confiar en $_FILES['type'])
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowedMimes = [
        'image/jpeg', 
        'image/png', 
        'image/gif', 
        'image/webp'
    ];

    if (!in_array($mime, $allowedMimes)) {
        throw new Exception("Formato de archivo no inváulido: " . $mime . ". Solo se permiten JPG, PNG, GIF o WEBP.");
    }

    // 2. Sanitizar extensión
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowedExts)) {
        throw new Exception("Extensión no permitida.");
    }

    // 3. Generar nombre seguro y único
    $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    
    // Asegurar que el directorio existe
    if (!is_dir($targetDirBase)) {
        mkdir($targetDirBase, 0755, true);
    }

    $targetPath = $targetDirBase . $fileName;

    // 4. Mover archivo
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $publicPathBase . $fileName;
    } else {
        throw new Exception("Error interno al guardar la imagen.");
    }
}
?>
