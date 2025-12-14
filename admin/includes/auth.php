<?php
session_start();

// Si no hay variable de sesión 'user_id', redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/login.php");
    exit;
}
?>
