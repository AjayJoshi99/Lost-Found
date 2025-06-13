<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Lost_Found';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    $_SESSION['msg'] = "Database connection failed!";
    header("Location: ../dashboard/user/student_dashboard.php");
    exit();
}

date_default_timezone_set('Asia/Kolkata');

$name = $_POST['name'] ?? '';
$contact = $_POST['contact'] ?? '';
$itemType = $_POST['itemType'] ?? ''; 
$email = $_SESSION['email'] ?? 'guest@example.com';

$image = $_FILES['image'];
$ext = pathinfo($image["name"], PATHINFO_EXTENSION); 
$imageName = time() . "_" . basename($image["name"], "." . $ext) . "." . $ext;

$targetDir = "../dashboard/images/lostRequest/";
$targetFile = $targetDir . $imageName;

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (move_uploaded_file($image["tmp_name"], $targetFile)) {
    $imageURL = "dashboard/images/lostRequest/" . $imageName;
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $stmt = $conn->prepare("INSERT INTO lostrequest (name, email, contact, itemType, image_url, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $contact, $itemType, $imageURL, $date, $time);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Request submitted successfully!";
    } else {
        $_SESSION['msg'] = "DB Insert Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['msg'] = "Failed to upload image to: $targetFile";
}

$conn->close();
header("Location: ../dashboard/user/student_dashboard.php");
exit();
?>
