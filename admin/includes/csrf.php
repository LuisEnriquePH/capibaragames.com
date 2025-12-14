<?php
/**
 * CSRF Protection Helper
 * Generates and validates CSRF tokens to prevent Cross-Site Request Forgery attacks
 */

/**
 * Generate or retrieve existing CSRF token for current session
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token matches session token
 * @param string $token Token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && 
           isset($token) && 
           hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Output hidden CSRF input field for forms
 */
function csrfField() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCSRFToken()) . '">';
}

/**
 * Require valid CSRF token or die with error
 * Call this at the start of POST/DELETE handlers
 */
function requireCSRF() {
    $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
    if (!verifyCSRFToken($token)) {
        http_response_code(403);
        die('Error de seguridad: Token CSRF inválido. Por favor recarga la página e intenta de nuevo.');
    }
}
?>
