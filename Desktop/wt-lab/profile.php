<?php
session_start();
require "db.php";

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];

$successMessage = "";
$errorMessage = "";

// Get user's donor status
$userDonor = findDonor($userEmail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Blood Donation Camp</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <!-- Navbar -->
    <header>
        <h1>🩸 Blood Donation Camp</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="file-manager.php">File Manager</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>My Profile</h2>

            <?php if($successMessage): ?>
                <div class="success"><?= $successMessage ?></div>
            <?php endif; ?>

            <?php if($errorMessage): ?>
                <div class="error"><?= $errorMessage ?></div>
            <?php endif; ?>

            <div class="profile-info">
                <h3>Welcome, <?php echo htmlspecialchars($userName); ?>!</h3>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>

                <?php if($userDonor): ?>
                    <div class="donor-status">
                        <h4>🩸 Donor Information</h4>
                        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($userDonor['blood_group']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($userDonor['phone']); ?></p>
                        <p><strong>Age:</strong> <?php echo $userDonor['age']; ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst($userDonor['status']); ?></p>
                        <p><strong>Registration Date:</strong> <?php echo date('M d, Y', strtotime($userDonor['registration_date'])); ?></p>
                    </div>
                <?php else: ?>
                    <p>You haven't registered as a donor yet.</p>
                    <a href="register.php" class="auth-btn">Register as Donor</a>
                <?php endif; ?>
            </div>

            <div class="btn-group">
                <a href="index.php" class="auth-btn" style="background: #666;">Back to Home</a>
            </div>
        </div>
    </div>

</body>
</html>