<?php
require 'includes/auth.php'; // Ensures user is logged in and loads CSRF helper

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCSRF();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
} else {
    // Prevent accidental logout via GET
    header("Location: index.php");
    exit;
}
?>
