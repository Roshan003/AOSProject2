<?php
// Including the navbar
include 'navbar.php';

// Get disk usage in GB
$disk_total_space = disk_total_space("/");
$disk_free_space = disk_free_space("/");
$disk_used_space = $disk_total_space - $disk_free_space;
$disk_used_gb = number_format($disk_used_space / (1024 ** 3), 2); // Convert to GB
$disk_free_gb = number_format($disk_free_space / (1024 ** 3), 2); // Convert to GB

// Get CPU usage in percentage
$cpu_usage = sys_getloadavg()[0]; // 1-minute load average

// Fetch system logs (limiting to avoid large output)
$logs = file_get_contents('/var/log/syslog');
$logs_preview = substr($logs, 0, 1000); // Preview first 1000 characters for better readability
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Monitoring</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>System Monitoring</h2>

        <div class="system-stats">
            <p><strong>Disk Usage:</strong> <?php echo $disk_used_gb; ?> GB used / <?php echo $disk_free_gb; ?> GB free</p>
            <p><strong>CPU Usage:</strong> <?php echo number_format($cpu_usage, 2); ?>% (1-minute load average)</p>
            <p><strong>Logs:</strong></p>
            <pre><?php echo htmlspecialchars($logs_preview); ?></pre>
        </div>
    </div>
</body>
</html>
