<?php

session_start();

// Get the session variables
$sqlFetch = require __DIR__ . "/database.php";

// get the user's id
$fetch = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

$fetch_result = $sqlFetch->query($fetch);

$sessioned_user = $fetch_result->fetch_assoc();


if (empty($_POST['title'])) {
    die('Title is required');
}
if (empty($_POST['location'])) {
    die('Location is required');
}
if (empty($_POST['story'])) {
    die('Story is required');
}
if (empty($_POST['date'])) {
    die('Date is required');
}
if (empty($_POST['fee'])) {
    die('Fee is required');
}

/* Cover Image section */

// Upload file errors 
$upload_file_errors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.'
);

// The extension error flag that is false by default
$ext_error = false;

// List of allowed extensions
$extensions = array('jpg', 'jpeg', 'gif', 'png');

// Get the file extension
$file_ext = explode('.', $_FILES['img']['name']);

// Get the last element of the array that contains both the filename and the file extension
$file_ext = strtolower(end($file_ext));

// Check to see if the file extension is in the list of allowed extensions, if not set the extension error flag to true
if (!in_array($file_ext, $extensions)) {
    $ext_error = true;
}

// Check to see if there is an error in the file upload that corresponds to one that is in the associative array. This happens if the error is not equal to zero
if ($_FILES['img']['error']) {
    echo $upload_file_errors[$_FILES['img']['error']];
} elseif ($ext_error) {
    echo "Invalid file extension. Only .jpeg or .jpg or .png or .gif are allowed";
} else {
    echo "Success! Image has been uploaded";
    // If there is no error, move the file to the uploads folder
    move_uploaded_file($_FILES['img']['tmp_name'], 'uploads/gallery/' . $_FILES['img']['name']);
    echo "File uploaded successfully";
}

$img_dir = 'uploads/gallery/' . $_FILES['img']['name'];


if (empty($img_dir)) {
    die('Image is required');
}

/* Cover Image section */

/* Get logged in artist's id and name */
$artist_id = $sessioned_user['id'];
$artist_name = $sessioned_user['name'];

$mysqli = require __DIR__ . '/database.php';

$sql = "INSERT INTO galleries (artist_id, artist_name, coverImg, title, location, story, date, fee)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die('SQL error: ' . $mysqli->error);
}

$stmt->bind_param(
    'ssssssss',
    $artist_id,
    $artist_name,
    $img_dir,
    $_POST['title'],
    $_POST['location'],
    $_POST['story'],
    $_POST['date'],
    $_POST['fee']
);

if ($stmt->execute()) {
    header('Location: artist-galleries.php');
    exit;
} else {
    die($mysqli->error . ' ' . $mysqli->errno);
}
