<?php
/**
 * logout.php – Securely Ends the User Session
 *
 * Steps taken:
 * 1. Start the session.
 * 2. Unset all session variables.
 * 3. Delete the session cookie.
 * 4. Destroy the session on the server.
 * 5. Redirect to login.
 */

session_start();

// 1. Unset all session variables
$_SESSION = [];

// 2. Delete the session cookie if it exists
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// 3. Destroy the session on the server
session_destroy();

// 4. Redirect to login page
header('Location: login.php');
exit;
