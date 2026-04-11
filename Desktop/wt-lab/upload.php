<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$message = "";

if(isset($_POST['upload'])) {
    $target_dir = "uploads/";
    $file_name = $_FILES['myfile']['name'];

    // Security checks
    if(empty($file_name)) {
        $message = "Please select a file to upload.";
    } else {
        // Check file size (limit to 10MB)
        if($_FILES['myfile']['size'] > 10000000) {
            $message = "File is too large. Maximum size is 10MB.";
        } else {
            // Check file type (allow common file types)
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if(!in_array($file_extension, $allowed_types)) {
                $message = "File type not allowed. Allowed types: " . implode(', ', $allowed_types);
            } else {
                // Generate unique filename to prevent overwrites
                $unique_name = time() . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $unique_name;

                if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_file)) {
                    $message = "File uploaded successfully as: " . $unique_name;
                } else {
                    $message = "Error uploading file. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File - Blood Donation Camp</title>
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
            <h2>Upload File</h2>

            <?php if($message): ?>
                <div class="success"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div style="margin: 20px 0;">
                    <input type="file" name="myfile" required style="width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px;">
                </div>

                <div class="btn-group">
                    <button type="submit" name="upload" class="auth-btn">Upload File</button>
                </div>
            </form>

            <div class="switch-link">
                <a href="file-manager.php">Back to File Manager</a>
            </div>

            <div style="margin-top: 20px; font-size: 12px; color: #666;">
                <strong>Allowed file types:</strong> JPG, PNG, GIF, PDF, DOC, DOCX, TXT, ZIP, RAR<br>
                <strong>Maximum file size:</strong> 10MB
            </div>
        </div>
    </div>

</body>
</html>