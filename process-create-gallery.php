<?php

if (empty($_POST["title"])) {
    die("Title is required");
}
if (empty($_POST["location"])) {
    die("Location is required");
}
if (empty($_POST["story"])) {
    die("Story is required");
}
if (empty($_POST["fee"])) {
    die("Fee is required");
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
    $_POST["fee"]
);

if ($stmt->execute()) {
    header("Location: artist-galleries.php");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
