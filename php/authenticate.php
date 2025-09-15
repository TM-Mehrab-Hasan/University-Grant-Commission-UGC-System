<?php
session_start();
include('db_connection.php');  // Ensure this path matches where `db_connection.php` is located

// Check if login form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query to find user with the provided username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and password matches
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../admin/admin_universities.php");
            } else {
                header("Location: ../views/index.html");
            }
            exit;
        } else {
            // Password incorrect
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: ../login.php");
            exit;
        }
    } else {
        // Username not found
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
