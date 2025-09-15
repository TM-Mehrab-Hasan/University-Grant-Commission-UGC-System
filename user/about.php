<?php
session_start();
include('../php/db_connection.php');

// Fetch all entries from the About section
$query = "SELECT * FROM about_section"; 
$result = $conn->query($query);
$about_content = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Assuming 'content' contains the actual text you want to display
        $about_content .= "<p><strong>{$row['id']}. </strong>" . htmlspecialchars($row['content']) . "</p><hr>";
    }
} else {
    $about_content = "No content available in the about section.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Grants Commission System for Ranking</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>University Grants Commission System for Ranking</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="universities.php">Affiliated Universities</a>
            <a href="news.php">News</a>
            <a href="resource.php">Resources</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="../php/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>About Us</h2>
        <div>
            <?php echo $about_content; ?>
        </div>
    </main>
</body>
</html>
