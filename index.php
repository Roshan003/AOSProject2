<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup and Restore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="backup-restore.php">Backup and Restore</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Backup and Restore</h2>

        <!-- Backup Form -->
        <form action="backup.php" method="POST">
            <button type="submit" class="btn">Backup Now</button>
        </form>

        <!-- Restore Form -->
        <form action="restore.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="backupFile" required>
            <button type="submit" class="btn">Restore Backup</button>
        </form>
    </div>
</body>
</html>
