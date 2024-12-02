<?php
// restore_script.php

if (isset($_FILES['backup_file'])) {
    $backup_file = $_FILES['backup_file']['tmp_name']; // Get the uploaded file
    $restore_dir = '/var/www/html/nas/uploads/';      // Directory to restore files to

    // Check if the uploaded file is a tar.gz archive
    if (pathinfo($backup_file, PATHINFO_EXTENSION) == 'gz') {
        // Command to restore the backup
        $command = "tar -xzf $backup_file -C $restore_dir";
        if (shell_exec($command)) {
            echo "<p>Restore successful. Files have been restored to $restore_dir</p>";
        } else {
            echo "<p>Restore failed. Please try again.</p>";
        }
    } else {
        echo "<p>Invalid file type. Only .tar.gz files are allowed.</p>";
    }
}
?>
