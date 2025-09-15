<?php
session_start();
include('php/db_connection.php');

if (!isset($_SESSION['reset_user'])) {
    header("Location: forgot_password.php"); // Redirect if no user is set for reset
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = trim($_POST['new_password']);
    $username = $_SESSION['reset_user'];

    // Update the user's password as plain text
    $query = "UPDATE users SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $new_password, $username);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Password reset successful! You can now log in.";
        unset($_SESSION['reset_user']); // Clear session variable
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error resetting password: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - University Grants Commission</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="reset-container">
        <div class="reset-card">
            <h1>Reset Password</h1>
            <p>Please set a new password for your account.</p>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
            ?>

            <form method="POST" action="reset_password.php" class="reset-form">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required placeholder="Enter new password">
                </div>

                <button type="submit" class="reset-btn">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>

