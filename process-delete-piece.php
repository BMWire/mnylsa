<?php

// Create a database connection
$mysqli = require __DIR__ . '/database.php';

// Get the piece id from the session
$_SESSION['piece_id'] = $_POST['piece_id'];

// Delete the piece whose id is in the session
$sql = "DELETE FROM art WHERE id = '$_SESSION[piece_id]'";

// Execute the update query and redirect the artist back to the art orders page
if ($mysqli->query($sql) === TRUE) {
    // redirect to order.php?id={$_SESSION['user_id']}
    header("Location: admin-pieces.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
