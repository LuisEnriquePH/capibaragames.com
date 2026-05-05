<?php
session_start();

// Include CSRF protection functions
require_once __DIR__ . '/csrf.php';

// Cabeceras de Seguridad HTTP
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Si no hay variable de sesión 'user_id', redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/login.php");
    exit;
}
?>
