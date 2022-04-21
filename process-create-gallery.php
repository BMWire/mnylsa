<?php

if (empty($_POST["title"])) {
    die("Gallery title is required");
}

if (empty($_POST["location"])) {
    die("Gallery location is required");
}

if (empty($_POST["story"])) {
    die("Gallery story is required");
}

if (empty($_POST["price"])) {
    die("Entrance fee is required");
}


$mysqli = require __DIR__ . "/database.php";

// Get the artist id of the logged in users
// get the user's email address
$select_sql = "SELECT * FROM users
WHERE id = {$_SESSION['user_id']}";

$result = $mysqli->query($select_sql);

$user = $result->fetch_assoc();

$artist_id = $user["id"];
$artist_name = $user["name"];

$sql = "INSERT INTO galleries (artist_id, artist_name, title, location, story, fee)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "ssssss",
    $_POST[$user["id"]],
    $_POST[$user["name"]],
    $_POST["title"],
    $_POST["location"],
    $_POST["story"],
    $_POST["price"]
);

if ($stmt->execute()) {
    header("Location: artist-galleries.php");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
