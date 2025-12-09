<?php
// api/youtube.php

// --- CONFIGURACIÓN SEGURA ---
// Esta llave vive en el servidor, nadie la puede ver desde el navegador.
$apiKey = 'AIzaSyBh__OJjHnj5qV09Yf7z8HOxO_NHbbD2E0'; 
$channelId = 'UCU6_Ax2E_EX3ZVekN7_yAjw'; // Ejemplo: UCzE-q9Gg...

// Archivo donde guardaremos la copia temporal (Caché)
$cacheFile = 'youtube_cache.json';
$cacheTime = 3600; // 1 hora (3600 segundos)

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite que tu JS lo lea

// 1. ESTRATEGIA DE CACHÉ
// Si el archivo existe Y es reciente (menos de 1 hora), úsalo.
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
    echo file_get_contents($cacheFile);
    exit;
}

// 2. SI EL CACHÉ EXPIRÓ, CONSULTAR A GOOGLE
$apiUrl = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId={$channelId}&maxResults=1&key={$apiKey}";

// Usamos CURL para mayor compatibilidad profesional
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Si estás en local y te da error de SSL, descomenta la siguiente línea (solo para dev):
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 3. VALIDACIÓN Y GUARDADO
if ($httpCode === 200) {
    // Guardamos la respuesta fresca en el caché
    file_put_contents($cacheFile, $response);
    echo $response;
} else {
    // Si Google falla (ej. cuota excedida), intentamos mostrar el caché viejo como respaldo
    if (file_exists($cacheFile)) {
        echo file_get_contents($cacheFile);
    } else {
        // Si no hay nada, devolvemos error
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo conectar con YouTube', 'details' => $response]);
    }
}
?>
