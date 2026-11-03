<?php
/**
 * index.php – Home / Landing Page
 * Redirects authenticated users straight to the dashboard.
 */

require_once 'config/session.php';

$pageTitle = 'Django Girls Sierra Leone – Welcome';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="Django Girls Sierra Leone – empowering women in technology through coding and community.">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Hero section extra styles */
        .hero {
            min-height: calc(100vh - 86px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 24px;
        }
        .hero-badge {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(233,30,140,0.15);
            border: 1px solid rgba(233,30,140,0.4);
            color: #f472b6;
            margin-bottom: 28px;
            animation: fadeSlideUp 0.4s ease both;
        }
        .hero h1 {
            font-size: clamp(38px, 6vw, 72px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff 30%, #f472b6 65%, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeSlideUp 0.5s 0.1s ease both;
        }
        .hero p {
            font-size: 18px;
            color: #c4b5d8;
            max-width: 560px;
            margin: 0 auto 40px;
            line-height: 1.7;
            animation: fadeSlideUp 0.5s 0.2s ease both;
        }
        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeSlideUp 0.5s 0.3s ease both;
        }
        .hero-actions .btn { width: auto; padding: 14px 36px; }
        .hero-logo {
            margin-bottom: 40px;
            animation: fadeSlideUp 0.4s ease both;
        }
        .hero-logo img {
            height: 80px;
            filter: drop-shadow(0 0 20px rgba(233,30,140,0.5));
        }
        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            opacity: 0.18;
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 { width: 400px; height: 400px; background: #e91e8c; top: -100px; left: -100px; }
        .orb-2 { width: 300px; height: 300px; background: #6d28d9; bottom: -80px; right: -80px; animation-delay: -4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }
    </style>
</head>
<body>

<!-- Background orbs -->
<div class="orb orb-1" aria-hidden="true"></div>
<div class="orb orb-2" aria-hidden="true"></div>

<header class="site-header" role="banner">
    <a href="index.php" class="logo" aria-label="Home">
        <img src="assets/django_girls_logo.jpg" alt="Django Girls Logo">
    </a>
    <nav class="header-nav" aria-label="Site navigation">
        <a href="login.php">Login</a>
        <a href="signup.php" class="btn-nav">Sign Up</a>
    </nav>
</header>

<main>
    <section class="hero" aria-labelledby="hero-heading">
        <div class="hero-logo">
            <img src="assets/django_girls_logo.jpg" alt="Django Girls Sierra Leone Logo">
        </div>
        <span class="hero-badge">&#127462;&#127473; Sierra Leone Chapter</span>
        <h1 id="hero-heading">Empowering Women<br>Through Code</h1>
        <p>Join our community and take your first step into the world of web development. Learn, build, and connect with amazing people across Sierra Leone.</p>
        <div class="hero-actions">
            <a href="signup.php" class="btn btn-primary">Get Started Free</a>
            <a href="login.php" class="btn btn-outline">Sign In</a>
        </div>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>
