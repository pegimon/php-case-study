<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $getUserQuery = "SELECT id, username, password, role FROM users WHERE username = ?";
    $getUserStmt = $conn->prepare($getUserQuery);
    $getUserStmt->bind_param("s", $username);
    $getUserStmt->execute();
    $getUserStmt->store_result();

    if ($getUserStmt->num_rows > 0) {
        $getUserStmt->bind_result($userId, $dbUsername, $dbPassword, $userRole);
        $getUserStmt->fetch();

        if (password_verify($password, $dbPassword)) {
            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $dbUsername;
            $_SESSION["role"] = $userRole;

            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid username or password. Please try again.";
        }
    } else {
        $message = "Invalid username or password. Please try again.";
    }

    $getUserStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">        
        <form action="" method="post">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
        <div class="message"><?php echo $message; ?></div>
    </div>

</body>
</html>

