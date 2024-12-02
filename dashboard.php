<?php
// Start session
session_start();
include 'navbar.php';  // Include the centralized navbar

// Check if the user is logged in by checking if 'username' session variable is set
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If user is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    </header>

    <main>
        <h2>Welcome to your NAS server! From here, you can manage files, users, system monitoring, and more.</h2>
        
        <!-- Link to File Management -->
        <a href="files.php" class="redirect-btn">Go to File Management</a>
    </main>

    <style>
        /* Style for the body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Header styling */
        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        /* Main section styling */
        main {
            margin: 50px auto;
            width: 80%;
            max-width: 800px;
        }

        main h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
        }

        /* Style for the link button */
        .redirect-btn {
            display: inline-block;
            padding: 15px 30px;
            background-color: #007BFF;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect */
        .redirect-btn:hover {
            background-color: #0056b3;
        }

        /* Button active state */
        .redirect-btn:active {
            background-color: #003d82;
        }

    </style>
</body>
</html>
