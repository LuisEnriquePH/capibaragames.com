<?php
// includes/db.php

// Configuración de credenciales
// (Deben coincidir con el usuario que creamos en la terminal)
$host = 'localhost';
$dbname = 'capibara_db';
$username = 'admin_capibara';
$password = 'capibara123'; // <--- Si cambiaste la clave en la terminal, cámbiala aquí

try {
    // Creamos la conexión usando PDO (Seguro y Moderno)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Avisar si hay error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Traer datos como array asociativo
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

} catch (\PDOException $e) {
    // Si falla la conexión, matamos el proceso con un mensaje
    // (En producción, esto debería registrarse en un log, no mostrarse al usuario)
    die("Error crítico de conexión: " . $e->getMessage());
}
?>