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

// Fetch the user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If the user doesn't exist, show an error
if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}

$user = $result->fetch_assoc();

// Initialize message variable
$message = '';

// Handle form submission to update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update the user's data in the database
    $update_sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssi', $username, $role, $user_id);
    if ($update_stmt->execute()) {
        $message = "<div class='alert alert-success'>User updated successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error updating user.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit User</h1>
        </header>

        <main>
            <!-- Display success or error message -->
            <?php echo $message; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="user_management.php" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
</body>
</html>
