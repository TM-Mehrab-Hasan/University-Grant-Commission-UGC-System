<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include('../php/db_connection.php');

// Initialize feedback and search variables
$feedback = "";
$search = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $link = $_POST['link'];
        $query = "INSERT INTO resources (title, description, link) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $description, $link);

        if ($stmt->execute()) {
            $feedback = "Resource added successfully!";
        } else {
            $feedback = "Error adding resource.";
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['resource_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $link = $_POST['link'];
        $query = "UPDATE resources SET title=?, description=?, link=? WHERE resource_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $title, $description, $link, $id);

        if ($stmt->execute()) {
            $feedback = "Resource updated successfully!";
        } else {
            $feedback = "Error updating resource.";
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['resource_id'];
        $query = "DELETE FROM resources WHERE resource_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $feedback = "Resource deleted successfully!";
        } else {
            $feedback = "Error deleting resource.";
        }
        $stmt->close();
    }
}

// Handle search functionality
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM resources WHERE title LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM resources ORDER BY created_at DESC";
    $result = $conn->query($query);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Resources</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <script>
        function togglePopup() {
            document.getElementById("popupForm").classList.toggle("show");
        }
    </script>
    <style>
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        .popup-form.show {
            display: block;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 8px;
            width: 250px;
        }
        .search-bar button {
            padding: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>University Grants Commission System for Ranking</h1>
        <h2>Edit Resource Section</h2>

        <nav>
            <ul>
                <li><a href="admin_index.php">Home</a></li>
                <li><a href="admin_universities.php">Manage Universities</a></li>
                <li><a href="admin_resources.php">Manage Resources</a></li>
                <li><a href="admin_news.php">Manage News</a></li>
                <li><a href="admin_about.php">Manage About</a></li> 
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if ($feedback): ?>
            <p class="alert alert-success"><?php echo $feedback; ?></p>
        <?php endif; ?>
        
        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by Title" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">🔍</button>
            </form>
        </div>

        <!-- Add New Resource Button (opens the popup) -->
        <button onclick="togglePopup()">Add New Resource</button>
        
        <!-- Popup Form for Adding Resource -->
        <div id="popupForm" class="popup-form">
            <h2>Add New Resource</h2>
            <form method="POST">
                <label for="title">Title:</label>
                <input type="text" name="title" required>

                <label for="description">Description:</label>
                <input type="text" name="description" required>

                <label for="link">Link:</label>
                <input type="url" name="link" required>

                <button type="submit" name="add">Add Resource</button>
                <button type="button" onclick="togglePopup()">Close</button>
            </form>
        </div>

        <!-- Display Existing Resources -->
        <h2>Update or Delete Existing Resources</h2>
        <?php while($row = $result->fetch_assoc()): ?>
            <form method="POST">
                <input type="hidden" name="resource_id" value="<?php echo $row['resource_id']; ?>">

                <label>Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

                <label>Description:</label>
                <input type="text" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                
                <label>Link:</label>
                <input type="url" name="link" value="<?php echo htmlspecialchars($row['link']); ?>" required>

                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this resource?');">Delete</button>
            </form>
            <hr>
        <?php endwhile; ?>
    </main>
</body>
</html>
