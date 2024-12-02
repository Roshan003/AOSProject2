<?php
    include 'db.php';
    session_start();
    include 'navbar.php';  // Include the centralized navbar

    // Upload File
    if (isset($_POST['upload'])) {
        $file = $_FILES['fileToUpload'];
        $filename = $_FILES['fileToUpload']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($filename);

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            if (isset($_SESSION['user_id'])) {
                $uploaded_by = $_SESSION['user_id'];
            } else {
                echo "<p>You need to be logged in to upload a file.</p>";
                exit();
            }

            $sql = "INSERT INTO files (filename, filepath, uploaded_by) VALUES ('$filename', '$target_file', '$uploaded_by')";
            if ($conn->query($sql) === TRUE) {
                header("Location: files.php");
                exit();
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error uploading file. Please try again.</p>";
        }
    }

    // Create Folder
    if (isset($_POST['create_folder'])) {
        $folder_name = $_POST['folder_name'];
        $folder_path = "uploads/" . $folder_name;

        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
            echo "<p>Folder '$folder_name' created successfully.</p>";
        } else {
            echo "<p>Folder already exists.</p>";
        }
    }

    // Rename Folder
    if (isset($_POST['rename_folder'])) {
        $old_name = $_POST['old_name'];
        $new_name = $_POST['new_name'];
        $old_path = "uploads/" . $old_name;
        $new_path = "uploads/" . $new_name;

        if (is_dir($old_path)) {
            rename($old_path, $new_path);
            echo "<p>Folder renamed successfully.</p>";
        } else {
            echo "<p>Folder not found.</p>";
        }
    }

    // Delete Folder
    if (isset($_GET['delete_folder'])) {
        $folder_name = $_GET['delete_folder'];
        $folder_path = "uploads/" . $folder_name;

        if (is_dir($folder_path)) {
            rmdir($folder_path); // Remove empty folder
            echo "<p>Folder deleted successfully.</p>";
        } else {
            echo "<p>Folder not found.</p>";
        }
    }

    // Get Files
    $sql = "SELECT * FROM files";
    $result = $conn->query($sql);

    // Get Folders (only directories)
    $folders = array_filter(scandir("uploads"), function($item) {
        return is_dir("uploads/" . $item) && $item != "." && $item != "..";
    });
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management</title>
    <style>
        /* Reset basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        input[type="file"], input[type="text"] {
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .folder-list, .file-list {
            margin-top: 30px;
        }

        .folder-item, .file-item {
            background-color: #ecf0f1;
            padding: 15px;
            margin: 8px 0;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-delete, .btn-download {
            background-color: #e74c3c;
            border-radius: 4px;
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-download {
            background-color: #2ecc71;
        }

        .btn-delete:hover, .btn-download:hover {
            background-color: #c0392b;
        }

        .btn-download {
            background-color: #27ae60;
        }

        .folder-item p, .file-item p {
            font-size: 16px;
            color: #2c3e50;
        }

        h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #34495e;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>File Management</h2>

        <!-- Upload File Form -->
        <form action="files.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <button type="submit" name="upload">Upload File</button>
        </form>

        <!-- Create Folder Form -->
        <form action="files.php" method="POST">
            <input type="text" name="folder_name" placeholder="Folder Name" required>
            <button type="submit" name="create_folder">Create Folder</button>
        </form>

        <!-- Rename Folder Form -->
        <form action="files.php" method="POST">
            <input type="text" name="old_name" placeholder="Old Folder Name" required>
            <input type="text" name="new_name" placeholder="New Folder Name" required>
            <button type="submit" name="rename_folder">Rename Folder</button>
        </form>

        <!-- Folder List -->
        <div class="folder-list">
            <h3>Folders</h3>
            <?php
                foreach ($folders as $folder) {
                    echo "<div class='folder-item'>";
                    echo "<p>$folder</p>";
                    echo "<a href='files.php?delete_folder=$folder' class='btn-delete'>Delete Folder</a>";
                    echo "</div>";
                }
            ?>
        </div>

        <!-- File List -->
        <div class="file-list">
            <h3>Files</h3>
            <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='file-item'>";
                    echo "<p>" . $row['filename'] . "</p>";
                    echo "<a href='download.php?id=" . $row['id'] . "' class='btn-download'>Download</a>";
                    echo "<a href='delete.php?id=" . $row['id'] . "' class='btn-delete'>Delete</a>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>
