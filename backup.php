<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Backup and Restore System</h2>

        <div class="action-container">
            <!-- Backup Section -->
            <div class="action-box">
                <h3>Backup Files</h3>
                <p>Create a backup of your files and system configurations.</p>
                <form method="post" action="backup.php">
                    <button type="submit" name="backup" class="btn">Create Backup</button>
                </form>
            </div>

            <!-- Restore Section -->
            <div class="action-box">
                <h3>Restore Files</h3>
                <p>Restore files from a previous backup.</p>
                <form method="post" action="backup.php" enctype="multipart/form-data">
                    <label for="backup_file">Choose a Backup:</label>
                    <input type="file" name="backup_file" id="backup_file" required>
                    <button type="submit" name="restore" class="btn">Restore Backup</button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['backup'])) {
            // Trigger the backup script
            include('backup_script.php');
        }

        if (isset($_POST['restore'])) {
            // Trigger the restore script
            include('restore_script.php');
        }
        ?>
    </div>

</body>
</html>
