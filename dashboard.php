<?php
/**
 * dashboard.php – User Dashboard
 * Displays personalised information for the authenticated user.
 */

require_once 'config/session.php';
require_once 'config/database.php';

requireLogin(); // Redirects to login.php if not authenticated

$pageTitle = 'Dashboard – Django Girls Sierra Leone';

// Pull fresh user data from database
$db   = getDB();
$stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    // Session refers to a deleted user – clear and redirect
    session_destroy();
    header('Location: login.php');
    exit;
}

// Avatar initial from first letter of full name
$initial  = strtoupper(mb_substr($user['full_name'], 0, 1));
$joinDate = date('d F Y', strtotime($user['created_at']));
$memberDays = (int) round((time() - strtotime($user['created_at'])) / 86400);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="Your personal Django Girls Sierra Leone dashboard.">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require_once 'partials/header.php'; ?>

<main>
    <div class="dashboard-wrap">

        <!-- Welcome Banner -->
        <section class="welcome-banner" aria-labelledby="welcome-heading">
            <div class="avatar-circle" aria-hidden="true"><?= htmlspecialchars($initial) ?></div>
            <div class="welcome-text">
                <h1 id="welcome-heading">
                    Hello, <?= htmlspecialchars($user['full_name']) ?>! &#128075;
                </h1>
                <p>Welcome back to your Django Girls Sierra Leone dashboard. Keep learning and building! &#127881;</p>
            </div>
        </section>

        <!-- Stats Grid -->
        <section class="stats-grid" aria-label="Account statistics">

            <div class="stat-card">
                <div class="stat-icon">&#128197;</div>
                <div class="stat-label">Member Since</div>
                <div class="stat-value" style="font-size:17px;"><?= $joinDate ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">&#127381;</div>
                <div class="stat-label">Days as Member</div>
                <div class="stat-value"><?= $memberDays ?> day<?= $memberDays !== 1 ? 's' : '' ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">&#127775;</div>
                <div class="stat-label">Account Status</div>
                <div class="stat-value"><span class="badge">Active</span></div>
            </div>

        </section>

        <!-- Profile Information -->
        <section class="info-card" aria-label="Profile information">
            <h2>&#128101; Profile Information</h2>

            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-val"><?= htmlspecialchars($user['full_name']) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-val">@<?= htmlspecialchars($user['username']) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Email Address</span>
                <span class="info-val"><?= htmlspecialchars($user['email']) ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">User ID</span>
                <span class="info-val">#<?= (int) $user['id'] ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Joined</span>
                <span class="info-val"><?= $joinDate ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-val"><span class="badge">&#9679; Active Member</span></span>
            </div>
        </section>

        <!-- Logout button -->
        <div style="margin-top: 32px; text-align: right;">
            <a href="logout.php" class="btn btn-danger" style="width:auto; padding: 12px 32px;" id="logout-btn">
                &#128682; Log Out Securely
            </a>
        </div>

    </div>
</main>

<?php require_once 'partials/footer.php'; ?>










