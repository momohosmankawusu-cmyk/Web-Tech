<?php
/**
 * signup.php – User Registration Page
 * Handles form display and POST processing.
 * Passwords are stored as bcrypt hashes (PASSWORD_DEFAULT).
 */

require_once 'config/session.php';
require_once 'config/database.php';

requireGuest(); // Redirect to dashboard if already logged in

$pageTitle  = 'Sign Up – Django Girls Sierra Leone';
$errors     = [];
$formData   = ['full_name' => '', 'username' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitise inputs
    $full_name = trim(htmlspecialchars($_POST['full_name'] ?? ''));
    $username  = trim(htmlspecialchars($_POST['username']  ?? ''));
    $email     = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password  = $_POST['password']  ?? '';
    $confirm   = $_POST['confirm']   ?? '';

    $formData = compact('full_name', 'username', 'email');

    // ── Validation ──────────────────────────────────────────────────────────
    if (empty($full_name)) $errors[] = 'Full name is required.';
    if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    // ── Database checks ─────────────────────────────────────────────────────
    if (empty($errors)) {
        $db = getDB();

        $stmt = $db->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Username or email is already registered.';
        }
    }

    // ── Insert user ─────────────────────────────────────────────────────────
    if (empty($errors)) {
        $db   = getDB();
        $hash = password_hash($password, PASSWORD_DEFAULT); // Bcrypt hashing

        $stmt = $db->prepare(
            'INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$full_name, $username, $email, $hash]);

        flashMessage('success', 'Account created! Please log in.');
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="Create your Django Girls Sierra Leone account.">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require_once 'partials/header.php'; ?>

<main class="page-center">
    <div class="card" role="main">
        <h1 class="card-title">Create Account</h1>
        <p class="card-subtitle">Join the Django Girls Sierra Leone community</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <span>&#9888;</span>
                <div><?= implode('<br>', $errors) ?></div>
            </div>
        <?php endif; ?>

        <form id="signup-form" action="signup.php" method="POST" novalidate>

            <!-- Full Name -->
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <div class="input-wrap">
                    <span class="icon">&#128100;</span>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        placeholder="Your full name"
                        value="<?= htmlspecialchars($formData['full_name']) ?>"
                        required
                        autocomplete="name"
                    >
                </div>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <span class="icon">&#64;</span>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Choose a username"
                        value="<?= htmlspecialchars($formData['username']) ?>"
                        required
                        autocomplete="username"
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <span class="icon">&#9993;</span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        value="<?= htmlspecialchars($formData['email']) ?>"
                        required
                        autocomplete="email"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="icon">&#128274;</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimum 6 characters"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <div class="input-wrap">
                    <span class="icon">&#128275;</span>
                    <input
                        type="password"
                        id="confirm"
                        name="confirm"
                        placeholder="Repeat your password"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="signup-btn">
                &#127775; Create My Account
            </button>
        </form>

        <div class="card-link">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>
