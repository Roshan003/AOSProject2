<?php
    include 'db.php';

    // Get file ID from URL
    if (isset($_GET['id'])) {
        $fileId = $_GET['id'];

        // Fetch file details from database
        $sql = "SELECT * FROM files WHERE id = $fileId";
        $result = $conn->query($sql);
        $file = $result->fetch_assoc();
        
        // Delete the file from the server
        unlink($file['file_path']);
        
        // Delete the record from the database
        $sql = "DELETE FROM files WHERE id = $fileId";
        $conn->query($sql);
        
        header("Location: files.php");
    }
?>
