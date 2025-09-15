<?php
session_start();
include('../php/db_connection.php'); // Include the database connection

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare and execute query to insert data into contact_messages table
        $query = "INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['error'] = "Failed to send your message. Please try again later.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "All fields are required!";
    }

    $conn->close();
    header("Location: contact.php");
    exit();
}
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
        <h2>Get in Touch</h2>

        <!-- Display success or error messages -->
        <div id="message-area">
            <?php
            if (isset($_SESSION['success'])) {
                echo "<p style='color:green;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
                unset($_SESSION['error']);
            }
            ?>
        </div>

        <p>If you have any questions or need further information, please reach out to us using the form below:</p>

        <!-- Contact Form -->
        <form action="contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="message">Message:</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </main>
</body>
</html>
