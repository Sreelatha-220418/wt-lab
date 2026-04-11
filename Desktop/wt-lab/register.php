<?php
session_start();
require "connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Donor - Blood Donation Camp</title>
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
            <h2>Register as Blood Donor</h2>

            <?php if($successMessage): ?>
                <div class="success"><?= $successMessage ?></div>
            <?php endif; ?>

            <?php if($errorMessage): ?>
                <div class="error"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST" action="connect.php">
                <input type="hidden" name="register_donor" value="1">

                <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($userName); ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($userEmail); ?>" readonly>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="number" name="age" placeholder="Age" min="18" max="65" required>

                <select name="blood_group" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>

                <textarea name="address" placeholder="Address" rows="3" required></textarea>

                <div class="btn-group">
                    <button type="submit" class="auth-btn">Register as Donor</button>
                </div>
            </form>

            <div class="switch-link">
                <a href="profile.php">Back to Profile</a>
            </div>
        </div>
    </div>

</body>
</html>