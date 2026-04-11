<?php
session_start();
require "connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood - Blood Donation Camp</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <!-- Navbar -->
    <header>
        <h1>🩸 Blood Donation Camp</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Request Blood</h2>

            <?php if($successMessage): ?>
                <div class="success"><?= $successMessage ?></div>
            <?php endif; ?>

            <?php if($errorMessage): ?>
                <div class="error"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST" action="connect.php">
                <input type="hidden" name="request_blood" value="1">

                <input type="text" name="patient_name" placeholder="Patient Name" required>

                <select name="blood_group" required>
                    <option value="">Select Required Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>

                <input type="number" name="units_needed" placeholder="Units Needed" min="1" max="10" required>
                <input type="text" name="hospital" placeholder="Hospital Name" required>
                <input type="text" name="contact_person" placeholder="Contact Person" required>
                <input type="tel" name="contact_phone" placeholder="Contact Phone" required>

                <select name="urgency" required>
                    <option value="">Select Urgency Level</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>

                <div class="btn-group">
                    <button type="submit" class="auth-btn">Submit Request</button>
                </div>
            </form>

            <div class="switch-link">
                <a href="index.php">Back to Home</a>
            </div>
        </div>
    </div>

</body>
</html>