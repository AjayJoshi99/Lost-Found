<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'Lost_Found');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT * FROM login WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['email'] = $user['email'];
    $_SESSION['Role'] = $user['Role'];
    echo $user['role'], $user['email'];
    $email = '';
    $password = '';
    if ($user['Role'] === 'Admin') {
        header("Location: ../dashboard/admin/admin_dashboard.php");
    } else {
        header("Location: ../dashboard/user/student_dashboard.php");
    }
    exit();
    } else {
        header("Location: ../index.php?error=Invalid+email+or+password");
        exit();
    }
?>




