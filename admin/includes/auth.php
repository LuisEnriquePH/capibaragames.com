<?php
session_start();

// Include CSRF protection functions
require_once __DIR__ . '/csrf.php';

// Si no hay variable de sesión 'user_id', redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/login.php");
    exit;
}
?>
