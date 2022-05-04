<?php

// Create a database connection
$mysqli = require __DIR__ . '/database.php';

// Get the user id from the session
$_SESSION['user_id'] = $_POST['user_id'];

// Delete the user whose id is in the session
$sql = "DELETE FROM users WHERE id = '$_SESSION[user_id]'";

// Execute the update query and redirect the artist back to the art orders page
if ($mysqli->query($sql) === TRUE) {
    // redirect to order.php?id={$_SESSION['user_id']}
    header("Location: admin-users.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
