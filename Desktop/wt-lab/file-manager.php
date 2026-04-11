<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$userName = $_SESSION['user_name'];
$uploads_dir = "uploads/";

// Get list of files in uploads directory
$files = [];
if (is_dir($uploads_dir)) {
    $dir_contents = scandir($uploads_dir);
    foreach ($dir_contents as $file) {
        if ($file !== '.' && $file !== '..' && is_file($uploads_dir . $file)) {
            $file_path = $uploads_dir . $file;
            $file_info = [
                'name' => $file,
                'size' => filesize($file_path),
                'modified' => filemtime($file_path),
                'extension' => strtolower(pathinfo($file, PATHINFO_EXTENSION))
            ];
            $files[] = $file_info;
        }
    }
    // Sort files by modification time (newest first)
    usort($files, function($a, $b) {
        return $b['modified'] - $a['modified'];
    });
}

// Function to format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Function to get file icon based on extension
function getFileIcon($extension) {
    $icons = [
        'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️', 'gif' => '🖼️',
        'pdf' => '📄', 'doc' => '📝', 'docx' => '📝',
        'txt' => '📄', 'zip' => '📦', 'rar' => '📦'
    ];
    return isset($icons[$extension]) ? $icons[$extension] : '📄';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager - Blood Donation Camp</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .file-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            overflow: hidden;
        }

        .file-table th, .file-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .file-table th {
            background: #ff4d6d;
            color: white;
            font-weight: bold;
        }

        .file-table tr:hover {
            background: rgba(255, 77, 109, 0.1);
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            transition: background 0.3s;
        }

        .download-btn {
            background: #28a745;
            color: white;
        }

        .download-btn:hover {
            background: #218838;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .upload-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(255, 77, 109, 0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            min-width: 120px;
            margin: 5px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #ff4d6d;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
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

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">

        <!-- Welcome Message -->
        <div class="auth-card" style="margin-bottom: 20px;">
            <h2>Welcome to File Manager, <?php echo htmlspecialchars($userName); ?>!</h2>
            <p>Manage your uploaded files securely. Upload, download, and delete files as needed.</p>
        </div>

        <!-- File Statistics -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($files); ?></div>
                <div class="stat-label">Total Files</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $total_size = 0;
                    foreach ($files as $file) {
                        $total_size += $file['size'];
                    }
                    echo formatFileSize($total_size);
                    ?>
                </div>
                <div class="stat-label">Total Size</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $image_count = 0;
                    foreach ($files as $file) {
                        if (in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif'])) {
                            $image_count++;
                        }
                    }
                    echo $image_count;
                    ?>
                </div>
                <div class="stat-label">Images</div>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-section">
            <h3>📤 Upload New File</h3>
            <a href="upload.php" class="auth-btn" style="display: inline-block; margin-top: 10px;">Choose File to Upload</a>
        </div>

        <!-- Files List -->
        <div class="auth-card">
            <h2>📁 Your Files</h2>

            <?php if (empty($files)): ?>
                <p style="text-align: center; color: #666; margin: 40px 0;">
                    No files uploaded yet. <a href="upload.php">Upload your first file</a>.
                </p>
            <?php else: ?>
                <table class="file-table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Size</th>
                            <th>Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td>
                                    <?php echo getFileIcon($file['extension']); ?>
                                    <?php echo htmlspecialchars($file['name']); ?>
                                </td>
                                <td><?php echo formatFileSize($file['size']); ?></td>
                                <td><?php echo date('M d, Y H:i', $file['modified']); ?></td>
                                <td class="file-actions">
                                    <a href="download.php?file=<?php echo urlencode($file['name']); ?>"
                                       class="action-btn download-btn">Download</a>
                                    <a href="delete.php?file=<?php echo urlencode($file['name']); ?>"
                                       class="action-btn delete-btn"
                                       onclick="return confirm('Are you sure you want to delete this file?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>