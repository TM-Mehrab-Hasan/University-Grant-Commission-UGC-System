<?php
session_start();
include('php/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $security_question = isset($_POST['security_question']) ? trim($_POST['security_question']) : '';
    $security_answer = trim($_POST['security_answer']);
    
    // Check if user exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Check if the security question matches
        if ($security_question === $user['security_question']) {
            // Verify the security answer
            if ($security_answer === $user['security_answer']) {
                // Security question and answer are correct
                $_SESSION['reset_user'] = $username; // Store username for resetting password
                header("Location: reset_password.php");
                exit;
            } else {
                $_SESSION['error'] = "Incorrect security answer.";
            }
        } else {
            $_SESSION['error'] = "Incorrect security question.";
        }
    } else {
        $_SESSION['error'] = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - University Grants Commission</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-card">
            <h1>Forgot Password</h1>
            <p>Provide your username and answer your security question to reset your password.</p>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
            ?>

            <form method="POST" action="forgot_password.php" class="forgot-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label for="security_question">Security Question:</label>
                    <select name="security_question" required>
                        <option value="" disabled selected>Select your security question</option>
                        <option value="What is your birth name?">What is your birth name?</option>
                        <option value="What is your birth place?">What is your birth place?</option>
                        <option value="What is the name of your favourite subject?">What is the name of your favourite subject?</option>
                        <option value="What is your favorite country for foreign studies?">What is your favorite country for foreign studies?</option>
                        <option value="What is your favourite university?">What is your favourite university?</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="security_answer">Security Question Answer:</label>
                    <input type="text" name="security_answer" required placeholder="Enter your answer">
                </div>

                <button type="submit" class="forgot-btn">Verify</button>
            </form>
            <p class="forgot-links">Remembered your password? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>
