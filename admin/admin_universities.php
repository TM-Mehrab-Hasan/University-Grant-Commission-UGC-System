<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include('../php/db_connection.php');

// Initialize variables
$message = '';
$search = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $departments = trim($_POST['departments']);
        $subjects = trim($_POST['subjects']);
        $global_ranking = trim($_POST['global_ranking']);

        $query = "INSERT INTO universities (name, departments, subjects, global_ranking) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $departments, $subjects, $global_ranking);

        if ($stmt->execute()) {
            $message = "University added successfully!";
        } else {
            $message = "Error adding university: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['university_id'];
        $name = trim($_POST['name']);
        $departments = trim($_POST['departments']);
        $subjects = trim($_POST['subjects']);
        $global_ranking = trim($_POST['global_ranking']);

        $query = "UPDATE universities SET name=?, departments=?, subjects=?, global_ranking=? WHERE university_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $name, $departments, $subjects, $global_ranking, $id);

        if ($stmt->execute()) {
            $message = "University updated successfully!";
        } else {
            $message = "Error updating university: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['university_id'];

        $query = "DELETE FROM universities WHERE university_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "University deleted successfully!";
        } else {
            $message = "Error deleting university: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Handle search functionality
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM universities WHERE name LIKE ? OR global_ranking LIKE ? ORDER BY global_ranking";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM universities ORDER BY global_ranking";
    $result = $conn->query($query);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Universities</title>
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
    <h2>Edit Universities Section</h2>
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
    <?php if ($message): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="search-bar">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by Name or Ranking" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">🔍</button>
        </form>
    </div>

    <button onclick="togglePopup()">Add New University</button>
    <div id="popupForm" class="popup-form">
        <h2>Add New University</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="departments">Departments:</label>
            <textarea name="departments" required></textarea>

            <label for="subjects">Subjects:</label>
            <textarea name="subjects" required></textarea>

            <label for="global_ranking">Global Ranking:</label>
            <input type="number" name="global_ranking" required>

            <button type="submit" name="add">Add University</button>
            <button type="button" onclick="togglePopup()">Close</button>
        </form>
    </div>

    <h2>Manage Universities</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <form method="POST">
            <input type="hidden" name="university_id" value="<?php echo $row['university_id']; ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            
            <label>Departments:</label>
            <textarea name="departments" required><?php echo htmlspecialchars($row['departments']); ?></textarea>
            
            <label>Subjects:</label>
            <textarea name="subjects" required><?php echo htmlspecialchars($row['subjects']); ?></textarea>
            
            <label>Global Ranking:</label>
            <input type="number" name="global_ranking" value="<?php echo $row['global_ranking']; ?>" required>
            
            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this university?');">Delete</button>
        </form>
        <hr>
    <?php endwhile; ?>
</main>
</body>
</html>