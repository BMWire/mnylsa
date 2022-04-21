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

$sql = "INSERT INTO galleries (title, location, story, fee)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "ssss",
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
