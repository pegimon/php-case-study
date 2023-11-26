<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$isAdmin = ($_SESSION["role"] === "admin");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>

    <?php if ($isAdmin): ?>
        <p>You have admin privileges if you want to drop the database don't hasitate to call me.</p>
        <p>here you can add products make yourself home <a href="addProducts.php">add products</a>.</p>
        <p>you can also see the list of products if you want <a href="products.php">show products</a>.</p>
    <?php else: ?>
        <p>such a pethitic user. you can only see the products huh.</p>
        <a href="products.php">show products</a>
    <?php endif; ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>