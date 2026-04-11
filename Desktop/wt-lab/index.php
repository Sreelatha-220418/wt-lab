<?php
session_start();
require "db.php";

// Check if user is logged in
$userLoggedIn = isset($_SESSION['user_email']);
$userName = $userLoggedIn ? $_SESSION['user_name'] : '';

// Get donor count from database
$donorCount = countDonors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Camp</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <!-- Background Image -->
    <img src="blood.jpg" alt="background">

    <!-- Navbar -->
    <header>
        <h1>🩸 Blood Donation Camp</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if($userLoggedIn): ?>
                <a href="file-manager.php">File Manager</a>
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="auth.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>Save Lives, Donate Blood ❤️</h2>
        <p>Your one donation can save up to 3 lives</p>

        <!-- Donor Count -->
        <p id="donorCount">Total Donors: <?php echo $donorCount; ?></p>

        <?php if($userLoggedIn): ?>
            <p>Welcome back, <?php echo htmlspecialchars($userName); ?>!</p>
            <a href="register.php" class="btn">Register as Donor</a>
        <?php else: ?>
            <a href="auth.php" class="btn">Become a Donor</a>
        <?php endif; ?>
    </section>

    <!-- Info Section -->
    <section class="info">
        <div class="card">
            <h3>Why Donate?</h3>
            <p>Blood donation helps save millions of lives every year.</p>
        </div>

        <div class="card">
            <h3>Who Can Donate?</h3>
            <p>Healthy individuals aged 18–65 can donate blood safely.</p>
        </div>

        <div class="card">
            <h3>Need Blood?</h3>
            <p>Find donors quickly and easily through our platform.</p>
            <?php if($userLoggedIn): ?>
                <a href="request.php" class="btn-small">Request Blood</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2026 Blood Donation Camp | Save Lives ❤️</p>
    </footer>

    <!-- JavaScript -->
    <script src="index.js"></script>

</body>
</html>