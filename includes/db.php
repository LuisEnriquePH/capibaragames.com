<?php
// includes/db.php

// Función simple para leer el .env (si no usas una librería como phpdotenv)
function cargarEnv($ruta) {
    if (!file_exists($ruta)) {
        throw new Exception("El archivo .env no existe");
    }
    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineas as $linea) {
        if (strpos(trim($linea), '#') === 0) continue;
        list($nombre, $valor) = explode('=', $linea, 2);
        $_ENV[trim($nombre)] = trim($valor);
    }
}

// Cargar las variables (ajusta la ruta según donde esté includes respecto al .env)
// Si includes está dentro de una carpeta, bajamos un nivel con ".."
cargarEnv(__DIR__ . '/../.env');

$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Para desarrollo local de diseño: no rompemos la página si falla la BD
     $pdo = null;
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>