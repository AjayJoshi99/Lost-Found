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

$targetDir = "../dashboard/images/foundRequest/";
$targetFile = $targetDir . $imageName;

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (move_uploaded_file($image["tmp_name"], $targetFile)) {
    $imageURL = "dashboard/images/foundRequest/" . $imageName;
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $stmt = $conn->prepare("INSERT INTO foundrequest (name, email, contact, itemType, image_url, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $contact, $itemType, $imageURL, $date, $time);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Request submitted successfully!";
        $stmt->close();

        $claimedDate = null;
        $claimerName = null;
        $claimerEmail = null;
        $claimerContact = null;

        $stmtHistory = $conn->prepare("INSERT INTO history (founder_name, founder_email, founder_contact, image_url,  claimer_name, claimer_email, claimer_contact, found_date, claimed_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtHistory->bind_param("sssssssss", $name, $email, $contact, $imageURL,  $claimerName, $claimerEmail, $claimerContact, $date, $claimedDate);
        $stmtHistory->execute();
        $stmtHistory->close();
    } else {
        $_SESSION['msg'] = "DB Insert Error: " . $stmt->error;
        $stmt->close();
    }
} else {
    $_SESSION['msg'] = "Failed to upload image to: $targetFile";
}

$conn->close();
header("Location: ../dashboard/user/student_dashboard.php");
exit();
?>
