<?php
session_start();
include('db_connection.php'); // Adjust the path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']); // Ensure this matches your database column name

    // Prepare SQL statement to prevent SQL injection
    $query = "INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $message); // Make sure the parameters match
        if ($stmt->execute()) {
            // Email sending logic
            $to = "mehrabratul210524@gmail.com";
            $subject = "New Contact Message";
            $body = "Name: $name\nEmail: $email\nMessage: $message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                $_SESSION['success'] = "Message sent successfully!";
            } else {
                $_SESSION['error'] = "Failed to send email.";
            }
        } else {
            $_SESSION['error'] = "Failed to record message in database.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Database error.";
    }

    header("Location: ../contact.php"); // Redirect back to contact page
    exit;
}

$conn->close();
?>
