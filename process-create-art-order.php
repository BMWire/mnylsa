<?php

session_start();

// connect to the database
$mysqli = require __DIR__ . "/database.php";

// collect session data from cart.php
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['user_name'] = $_POST['user_name'];
$_SESSION['piece_id'] = $_POST['piece_id'];
$_SESSION['piece_title'] = $_POST['piece_title'];
$_SESSION['piece_price'] = $_POST['piece_price'];

// insert the data into the art_orders table
$sql = "INSERT INTO art_orders (user_id, user_name, piece_id, piece_title, piece_price) VALUES ('$_SESSION[user_id]', '$_SESSION[user_name]', '$_SESSION[piece_id]', '$_SESSION[piece_title]', '$_SESSION[piece_price]')";

// execute insert query
if ($mysqli->query($sql) === TRUE) {
    // redirect to order.php?id={$_SESSION['user_id']}
    header("Location: orders.php?id=$_SESSION[user_id]");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
