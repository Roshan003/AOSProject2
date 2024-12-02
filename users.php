<?php
session_start();
include 'db.php';
include 'navbar.php'; // Include the navbar layout

// Check if user is logged in and if they are an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Show an error message and ask the user to log out
    echo "<div class='alert alert-danger'>You need to be an admin to access this page. Please <a href='logout.php'>log out</a> and log back in as an admin.</div>";
    exit();  // Stop further script execution
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset all elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and container */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            color: #343a40;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            background-color: #343a40;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Main content */
        header h1 {
            text-align: center;
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
        }

        main h2 {
            margin-top: 30px;
            font-size: 1.5rem;
            color: #343a40;
            margin-bottom: 15px;
        }

        .actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }

        .actions .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .actions .btn:hover {
            background-color: #0056b3;
        }

        /* User Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            background-color: #ffffff;
            font-size: 14px;
        }

        table td a {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        table td .btn-warning {
            background-color: #f39c12;
        }

        table td .btn-danger {
            background-color: #e74c3c;
        }

        table td .btn-warning:hover {
            background-color: #e67e22;
        }

        table td .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Table row hover effect */
        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Alerts */
        .alert {
            margin: 20px 0;
            padding: 10px;
            font-size: 1.2rem;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Manage Users</h1>
        </header>

        <main>
            <h2>User List</h2>

            <div class="actions">
                <a href="register.php" class="btn btn-primary">Create New User</a>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
