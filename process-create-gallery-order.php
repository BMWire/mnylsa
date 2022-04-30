<?php

session_start();

// create a connection to the db
$mysqli = require __DIR__ . '/database.php';

// collect the session data from the tickets.php
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['user_name'] = $_POST['user_name'];
$_SESSION['gallery_id'] = $_POST['gallery_id'];
$_SESSION['artist_id'] = $_POST['gallery_artist_id'];
$_SESSION['gallery_title'] = $_POST['gallery_title'];
$_SESSION['gallery_fee'] = $_POST['gallery_fee'];

// insert the data into the gallery_orders table
$sql = "INSERT INTO gallery_orders (user_id, user_name, gallery_id, artist_id, gallery_title, gallery_fee) VALUES ('$_SESSION[user_id]', '$_SESSION[user_name]', '$_SESSION[gallery_id]', '$_SESSION[artist_id]', '$_SESSION[gallery_title]', '$_SESSION[gallery_fee]')";

// execute insert query
if ($mysqli->query($sql) === TRUE) {
    // redirect to order.php?id={$_SESSION['user_id']}
    header("Location: gallery-orders.php?id=$_SESSION[user_id]");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

