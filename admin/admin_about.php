<?php
session_start();
include('../php/db_connection.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch current About section content
$query = "SELECT content FROM about_section WHERE id = 1";
$result = $conn->query($query);
$about_content = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $about_content = $row['content'];
} else {
    $about_content = "About content not available.";
}

// Update content if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_content = $_POST['content'];
    $update_query = "UPDATE about_section SET content = ? WHERE id = 1";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("s", $new_content);
    if ($stmt->execute()) {
        $_SESSION['success'] = "About section updated successfully."; // Set success message
    } else {
        $_SESSION['error'] = "Error updating the about section."; // Set error message
    }
    $stmt->close();
    header("Location: admin_about.php"); // Redirect to the same page to see the updated content
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit About Section</title>
    <link rel="stylesheet" href="../css/admin_style.css"> <!-- Updated to new CSS file -->
</head>
<body>
    <header>
        <h1>University Grants Commission System for Ranking</h1>
        <h2>Edit About Section</h2>
        
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
        <?php
        // Display any success or error messages
        if (isset($_SESSION['success'])) {
            echo "<p style='color:green;'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form method="POST">
            <label for="content">About Content:</label>
            <textarea name="content" rows="10" required><?php echo htmlspecialchars($about_content); ?></textarea>
            <button type="submit">Update</button>
        </form>
    </main>

    <footer>
        <p><center>&copy; <?php echo date("Y"); ?> University Grants Commission System for Ranking</center></p>
    </footer>
</body>
</html>
