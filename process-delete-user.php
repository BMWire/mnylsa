<?php

// Create a database connection
$mysqli = require __DIR__ . '/database.php';

// Delete the user whose id has been pushed by the delete form
$_SESSION['user_id'] = $_POST['user_id'];
$sql = "DELETE FROM users WHERE id = {$_POST['user_id']}";

// Execute the update query and redirect the artist back to the art orders page
if ($mysqli->query($sql) === TRUE) {
    header("Location: admin-users.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}
