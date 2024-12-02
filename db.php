<?php
$servername = "localhost";
$username = "nas_user"; // Make sure this is correct
$password = "new_password"; // Make sure this matches the password you set
$dbname = "nas_server_db";  // Ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
