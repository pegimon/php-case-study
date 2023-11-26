<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION["role"] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

$insertErrorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["name"];
    $productPrice = $_POST["price"];

    $insertProductQuery = "INSERT INTO products (product_name, price) VALUES (?, ?)";
    $insertProductStmt = $conn->prepare($insertProductQuery);
    $insertProductStmt->bind_param("sd", $productName, $productPrice);

    if ($insertProductStmt->execute()) {
        header("Location: products.php");
        exit();
    } else {
        $insertErrorMessage = "Error inserting product. Please try again.";
    }

    $insertProductStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Insert New Product</h2>

        <?php
        if (!empty($insertErrorMessage)) {
            echo '<div class="message">' . $insertErrorMessage . '</div>';
        }
        ?>

        <form action="" method="post">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <button type="submit">Insert Product</button>
        </form>

        <p><a href="dashboard.php">Back to dashboard</a></p>
    </div>
</body>
</html>