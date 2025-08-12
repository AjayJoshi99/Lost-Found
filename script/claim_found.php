<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must be logged in to claim an item.";
    header("Location: ../../index.php");
    exit();
}

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Lost_Found';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    $_SESSION['msg'] = "Database connection failed.";
    header("Location: studentHome.php");
    exit();
}

if (
    isset($_POST['image_url'], $_POST['found_by_name'], $_POST['found_by_email'],
          $_POST['claimer_name'], $_POST['claimer_contact'], $_POST['claimer_email'])
) {
    $image_url = $_POST['image_url'];
    $found_by_name = $_POST['found_by_name'];
    $found_by_email = $_POST['found_by_email'];
    $claimer_name = $_POST['claimer_name'];
    $claimer_contact = $_POST['claimer_contact'];
    $claimer_email = $_POST['claimer_email'];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $stmt = $conn->prepare("INSERT INTO claims (image_url, found_by_name, found_by_email, claimer_name, claimer_email, claimer_contact, claim_date, claim_time)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $image_url, $found_by_name, $found_by_email,
                      $claimer_name, $claimer_email, $claimer_contact, $date, $time);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Claim request submitted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to submit claim request.";
    }
    $stmt->close();
}

$conn->close();
header("Location: ../dashboard/user/student_dashboard.php");
exit();
