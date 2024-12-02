<?php
    include 'db.php';

    // Get the file ID from URL
    if (isset($_GET['id'])) {
        $fileId = $_GET['id'];

        // Fetch file details from database
        $sql = "SELECT * FROM files WHERE id = $fileId";
        $result = $conn->query($sql);
        $file = $result->fetch_assoc();

        // Get the file path
        $filePath = $file['filepath'];
        $filename = $file['filename'];

        // Set headers to download the file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
    }
?>
