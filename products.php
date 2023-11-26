<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Products</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a styles.css file -->
</head>
<body>
    <div class="container">
        <h2>Product List</h2>

        <?php
        // Fetch and display products from the database
        $getProductsQuery = "SELECT id, product_name, price FROM products";
        $result = $conn->query($getProductsQuery);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Name</th><th>Price</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No products available.';
        }

        $conn->close();
        ?>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>