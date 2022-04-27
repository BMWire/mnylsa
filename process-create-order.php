<?php

session_start();

// Get the session variables
$sqlFetch = require __DIR__ . "/database.php";

// get the user's id
$fetch = "SELECT * FROM users
            WHERE id = {$_SESSION['user_id']}";

$fetch_result = $sqlFetch->query($fetch);

$sessioned_user = $fetch_result->fetch_assoc();

/* Get logged in artist's id and name */
$user_id = $sessioned_user['id'];
$user_name = $sessioned_user['name'];

// Start of getting the piece order details

/* Get the id of the piece from the session */
$_SESSION['piece_id'] = $piece['id'];
$piece_id = $_SESSION['piece_id'];

/* Get the rest of the piece details from the art table */
$fetch_piece = "SELECT * FROM art WHERE id = {$piece_id}";

$piece_result = $sqlFetch->query($fetch_piece);

$sessioned_piece = $piece_result->fetch_assoc();

/* Get the rest of the piece data from the table */
$piece_title = $sessioned_piece['title'];
$piece_artist = $sessioned_piece['artist_name'];
$piece_price = $sessioned_piece['price'];


// End of getting the piece order details


$mysqli = require __DIR__ . '/database.php';

$sql = "INSERT INTO art_orders (piece_id, piece_name, piece_price, user_id, user_name)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die('SQL error: ' . $mysqli->error);
}

$stmt->bind_param(
    'sssss',
    $piece_id,
    $piece_name,
    $piece_price,
    $user_id,
    $user_name
);

if ($stmt->execute()) {
    header("Location: orders.php?id={$piece['id']}");
    exit;
} else {
    die($mysqli->error . ' ' . $mysqli->errno);
}
