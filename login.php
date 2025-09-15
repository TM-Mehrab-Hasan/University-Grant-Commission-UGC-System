<?php
session_start();
include('php/db_connection.php'); // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Prepare the SQL statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Check the password as plain text
            if ($password === $user['password']) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect based on user role
                if ($user['role'] == 'admin') {
                    header("Location: /ugc/admin/admin_index.php"); // Admin dashboard
                } else {
                    header("Location: /ugc/user/index.html"); // User dashboard
                }
                exit; // Ensure no further code is executed after redirect
            } else {
                $_SESSION['error'] = "Invalid credentials."; // Incorrect password
            }
        } else {
            $_SESSION['error'] = "User not found."; // Username doesn't exist
        }
    } else {
        $_SESSION['error'] = "Database query error."; // Error preparing statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Grants Commission Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="login-container">
        <div class="login-card">
            <h1>University Grants Commission System</h1>
            <h2>Login</h2>

            <?php
            // Display any error messages set in the session
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']); // Clear the error after displaying
            }
            ?>

            <form method="POST" action="login.php" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="login-links">
                <p>Don't have an account? <a href="register.php">Sign up here</a>.</p>
                <p><a href="forgot_password.php">Forgot your password?</a></p>
            </div>
        </div>
    </main>
</body>
</html>
