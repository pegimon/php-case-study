<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $checkUsernameQuery = "SELECT id FROM users WHERE username = ?";
    $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $checkUsernameStmt->store_result();
    if ($checkUsernameStmt->num_rows > 0) {
        echo "Username already taken. Please choose a different one.";
    } else {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $insertUserQuery = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";

        // Using a prepared statement to prevent SQL injection
        $insertUserStmt = $conn->prepare($insertUserQuery);
        $insertUserStmt->bind_param("ss", $username, $hashedPassword);
        
        if ($insertUserStmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Error: " . $insertUserStmt->error;
        }

        // Close the prepared statement
        $insertUserStmt->close();
    }

    // Close the prepared statement
    $checkUsernameStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <h2>Sign Up</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>

