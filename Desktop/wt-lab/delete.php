<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$message = "";

if (isset($_GET['file'])) {
    $file = "uploads/" . basename($_GET['file']); // Use basename for security

    if (file_exists($file) && is_file($file)) {
        // Security check: ensure file is within uploads directory
        $real_path = realpath($file);
        $uploads_path = realpath("uploads/");

        if (strpos($real_path, $uploads_path) === 0) {
            if (unlink($file)) {
                $message = "File deleted successfully.";
            } else {
                $message = "Error deleting file. Please try again.";
            }
        } else {
            $message = "Access denied: Invalid file path.";
        }
    } else {
        $message = "File not found or already deleted.";
    }
} else {
    $message = "No file specified for deletion.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete File - Blood Donation Camp</title>
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
            <h2>File Deletion Result</h2>

            <div class="success">
                <?= $message ?>
            </div>

            <div class="btn-group">
                <a href="file-manager.php" class="auth-btn">Back to File Manager</a>
            </div>
        </div>
    </div>

</body>
</html>