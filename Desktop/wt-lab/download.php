<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

if (isset($_GET['file'])) {
    $file = "uploads/" . basename($_GET['file']); // Use basename for security

    if (file_exists($file) && is_file($file)) {
        // Security check: ensure file is within uploads directory
        $real_path = realpath($file);
        $uploads_path = realpath("uploads/");

        if (strpos($real_path, $uploads_path) === 0) {
            // Get file information
            $file_name = basename($file);
            $file_size = filesize($file);
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Set appropriate MIME types
            $mime_types = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt' => 'text/plain',
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed'
            ];

            $content_type = isset($mime_types[$file_extension]) ? $mime_types[$file_extension] : 'application/octet-stream';

            // Set headers for download
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . $file_size);
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Clear output buffer
            if (ob_get_level()) {
                ob_clean();
            }

            // Read and output file
            readfile($file);
            exit();
        } else {
            die("Access denied: Invalid file path.");
        }
    } else {
        die("File does not exist or is not accessible.");
    }
} else {
    die("No file specified for download.");
}
?>