<?php
session_start();
include 'db.php';

// Check if user is logged in and if they are an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='alert alert-danger'>You need to be an admin to access this page. Please <a href='logout.php'>log out</a> and log back in as an admin.</div>";
    exit(); // Stop further script execution
}

// Check if the ID is passed via GET
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>User ID not found.</div>";
    exit();
}

$user_id = $_GET['id'];

// Delete the user from the database
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    echo "<div class='alert alert-success'>User deleted successfully.</div>";
    echo "<a href='user_management.php' class='btn btn-primary'>Go back to user list</a>";
} else {
    echo "<div class='alert alert-danger'>Error deleting user.</div>";
}
?>
