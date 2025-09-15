<?php
session_start();
include('php/db_connection.php'); // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'user'; // Default role
    $security_question = trim($_POST['security_question']);
    $security_answer = trim($_POST['security_answer']);

    // Initialize an array to hold error messages
    $error_messages = [];
    
    // Check for empty fields
    if (empty($username) || empty($password) || empty($security_question) || empty($security_answer)) {
        $error_messages[] = "All fields are required.";
    }

    // Password complexity check
    if (strlen($password) < 8 || strlen($password) > 32) {
        $error_messages[] = "Password must be between 8 and 32 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $error_messages[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $error_messages[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $error_messages[] = "Password must include at least one number.";
    }
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $error_messages[] = "Password must include at least one special character.";
    }

    // If there are any error messages, store them in session and show to the user
    if (!empty($error_messages)) {
        $_SESSION['error'] = implode("<br>", $error_messages);
    } else {
        // Insert user into the database without hashing the password
        $query = "INSERT INTO users (username, password, role, security_question, security_answer) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $username, $password, $role, $security_question, $security_answer);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - University Grants Commission System for Ranking</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <h1>University Grants Commission System</h1>
            <h2>Register</h2>
            
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['success'])) {
                echo "<p class='success-message'>".$_SESSION['success']."</p>";
                unset($_SESSION['success']);
            }
            ?>
            
            <form method="POST" action="register.php" class="register-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required placeholder="Enter a secure password">
                </div>

                <div class="form-group">
                    <label for="security_question">Security Question:</label>
                    <select name="security_question" required>
                        <option value="" disabled selected>Select a security question</option>
                        <option value="What is your birth name?">What is your birth name?</option>
                        <option value="What is your birth place?">What is your birth place?</option>
                        <option value="What is the name of your favourite subject?">What is the name of your favourite subject?</option>
                        <option value="What is your favorite country for foreign studies?">What is your favorite country for foreign studies?</option>
                        <option value="What is your favourite university?">What is your favourite university?</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="security_answer">Security Answer:</label>
                    <input type="text" name="security_answer" required placeholder="Enter your answer">
                </div>

                <button type="submit" class="register-btn">Register</button>
            </form>
            <p class="register-links">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>
