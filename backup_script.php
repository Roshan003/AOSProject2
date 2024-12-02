<?php
// backup_script.php

$source_dir = '/var/www/html/nas/uploads';  // Source files to backup
$backup_dir = '/var/www/html/nas/uploads'; // Backup location

// Get the current timestamp
$timestamp = date("Y-m-d_H-i-s");
$backup_file = $backup_dir . "/backup_" . $timestamp . ".tar.gz";

// Create a tar.gz archive of the source directory
$command = "tar -czf $backup_file $source_dir";

if (shell_exec($command)) {
    echo "<p>Backup successful. Backup file created: $backup_file</p>";
} else {
    echo "<p>Backup failed.</p>";
}
