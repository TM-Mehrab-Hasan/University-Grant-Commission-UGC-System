<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include('../php/db_connection.php');

// Initialize feedback messages
$feedback = "";
$search = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $query = "INSERT INTO news (title, content) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $title, $content);
        
        if ($stmt->execute()) {
            $feedback = "News item added successfully!";
        } else {
            $feedback = "Error adding news item.";
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['news_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $query = "UPDATE news SET title=?, content=? WHERE news_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $content, $id);
        
        if ($stmt->execute()) {
            $feedback = "News item updated successfully!";
        } else {
            $feedback = "Error updating news item.";
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['news_id'];
        $query = "DELETE FROM news WHERE news_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $feedback = "News item deleted successfully!";
        } else {
            $feedback = "Error deleting news item.";
        }
        $stmt->close();
    }
}

// Handle search functionality
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM news WHERE title LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM news ORDER BY created_at DESC";
    $result = $conn->query($query);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage News</title>
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
        <h2>Edit News Section</h2>
        
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
            <p style="color: green;"><?php echo $feedback; ?></p>
        <?php endif; ?>

        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by Title" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">🔍</button>
            </form>
        </div>

        <button onclick="togglePopup()">Add New News</button>
        <div id="popupForm" class="popup-form">
            <h2>Add New News Item</h2>
            <form method="POST">
                <label for="title">Title:</label>
                <input type="text" name="title" required>

                <label for="content">Content:</label>
                <textarea name="content" required></textarea>

                <button type="submit" name="add">Add News</button>
                <button type="button" onclick="togglePopup()">Close</button>
            </form>
        </div>

        <h2>Update or Delete Existing News</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <form method="POST">
                <input type="hidden" name="news_id" value="<?php echo $row['news_id']; ?>">
                <label>Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

                <label>Content:</label>
                <textarea name="content" required><?php echo htmlspecialchars($row['content']); ?></textarea>

                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this news item?');">Delete</button>
            </form>
            <hr>
        <?php endwhile; ?>
    </main>
</body>
</html>
