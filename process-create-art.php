 <?php
 session_start();
 
$target_directory = "uploads/";
$file_name = basename($_FILES["file"]["name"]);
$target_file_path = $target_directory . $file_name;
$file_type = pathinfo($target_file_path, PATHINFO_EXTENSION);

if (empty($_POST["title"])) {
    die("The title of the piece is required");
}

$allowed_types = array("jpg", "jpeg", "png", "gif");
if (!(in_array($file_type, $allowedtypes))) {
    die("Only JPG, JPEG, PNG, GIF files are allowed");
}

if (empty($_POST["story"])) {
    die("A story for the piece is required");
}

if (empty($_POST["price"])) {
    die("The price of the piece is required");
}

$mysqli = require __DIR__ . "/database.php";

$fetch_sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

// $result = $mysqli->query($fetch_sql);
// $artist = $result->fetch_assoc();

$insert_sql = "INSERT INTO art (artist_id, artist_name, title, story, price, img_path)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($insert_sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "ssssss",
    $_SESSION["user_id"],
    $_SESSION["user_name"],
    $_POST["title"],
    $_POST["story"],
    $_POST["price"],
    $_POST["target_file_path"]
);

if ($stmt->execute()) {
    header("Location: artist-create-art.php");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("It seems like that email is already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
