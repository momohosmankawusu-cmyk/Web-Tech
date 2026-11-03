<?php
/**
 * login.php – User Authentication Page
 * Verifies credentials and creates a secure session.
 */

require_once 'config/session.php';
require_once 'config/database.php';

requireGuest(); // Redirect if already logged in

$pageTitle = 'Login – Django Girls Sierra Leone';
$error     = '';
$username  = '';

// Show flash success from signup redirect
$successMsg = getFlash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter your username and password.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['joined']    = $user['created_at'];

            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username / email or password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="Log in to your Django Girls Sierra Leone account.">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require_once 'partials/header.php'; ?>

<main class="page-center">
    <div class="card" role="main">
        <h1 class="card-title">Welcome Back &#128075;</h1>
        <p class="card-subtitle">Sign in to your Django Girls Sierra Leone account</p>

        <?php if ($successMsg): ?>
            <div class="alert alert-success" role="alert">
                <span>&#10003;</span>
                <span><?= htmlspecialchars($successMsg) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error" role="alert">
                <span>&#9888;</span>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form id="login-form" action="login.php" method="POST" novalidate>

            <!-- Username / Email -->
            <div class="form-group">
                <label for="login-username">Username or Email</label>
                <div class="input-wrap">
                    <span class="icon">&#128100;</span>
                    <input
                        type="text"
                        id="login-username"
                        name="username"
                        placeholder="Enter username or email"
                        value="<?= htmlspecialchars($username) ?>"
                        required
                        autocomplete="username"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="login-password">Password</label>
                <div class="input-wrap">
                    <span class="icon">&#128274;</span>
                    <input
                        type="password"
                        id="login-password"
                        name="password"
                        placeholder="Your password"
                        required
                        autocomplete="current-password"
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="login-btn">
                &#128275; Sign In
            </button>
        </form>

        <div class="divider">or</div>

        <div class="card-link">
            Don't have an account? <a href="signup.php">Sign up for free</a>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>
