<?php

// Create a database connection
$mysqli = require __DIR__ . '/database.php';

// Get the order id from the session
$_SESSION['order_id'] = $_POST['order_id'];

// Update the isPaid field in art_orders to 1
$sql = "UPDATE gallery_orders SET isPaid = 1 WHERE id = '$_SESSION[order_id]'";

// Execute the update query and redirect the artist back to the art orders page
if ($mysqli->query($sql) === TRUE) {
    // redirect to admin-orders
    header("Location: admin-orders.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
