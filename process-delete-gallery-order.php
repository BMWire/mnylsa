<?php

session_start();

// create a connection to the db
$mysqli = require __DIR__ . '/database.php';

// collect the session data from the tickets.php
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['user_name'] = $_POST['user_name'];
$_SESSION['gallery_id'] = $_POST['gallery_id'];

// delete the data from the gallery_orders table
$sql = "DELETE FROM gallery_orders WHERE user_id = '$_SESSION[user_id]' AND gallery_id = '$_SESSION[gallery_id]'";

// execute the delete query and redirect the user back to the gallery orders page
if ($mysqli->query($sql) === TRUE) {
    // redirect to order.php?id={$_SESSION['user_id']}
    header("Location: gallery-orders.php?id=$_SESSION[user_id]");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
