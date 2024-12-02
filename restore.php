<?php
if (isset($_POST['restore'])) {
    // Check if a file was uploaded
    if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] == 0) {
        $backupFile = $_FILES['backupFile']['tmp_name'];
        
        // Get the file extension to validate it's a tar.gz file
        $fileExtension = pathinfo($_FILES['backupFile']['name'], PATHINFO_EXTENSION);

        if ($fileExtension === 'gz') {
            // Safe location to extract files (ensure this folder has proper permissions)
            $extractTo = 'uploads/';

            // Sanitize the file path and prevent path traversal vulnerabilities
            $sanitizedFileName = basename($_FILES['backupFile']['name']);

            // Command to restore files with sudo (if needed)
            $restoreCommand = "sudo tar -xzf $backupFile -C $extractTo/";

            // Execute the restore command
            exec($restoreCommand, $output, $status);

            if ($status === 0) {
                echo "<p>Backup restored successfully!</p>";
            } else {
                echo "<p>Error restoring backup. Please check the server logs.</p>";
            }
        } else {
            echo "<p>Invalid file type. Please upload a .tar.gz backup file.</p>";
        }
    } else {
        echo "<p>No file uploaded or error during upload. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Backup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Restore Backup</h2>
        <form action="restore.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="backupFile" required>
            <button type="submit" name="restore" class="btn">Restore Backup</button>
        </form>
    </div>
</body>
</html>
