<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['lost_id'])) {
    $conn = new mysqli("localhost", "root", "", "Lost_Found");
    if ($conn->connect_error) {
        $_SESSION['msg'] = "Database connection failed!";
        header("Location: ../dashboard/admin/admin_dashboard.php");
        exit();
    }

    $lost_id = intval($_POST['lost_id']);

    $stmt = $conn->prepare("DELETE FROM lostrequest WHERE id = ?");
    $stmt->bind_param("i", $lost_id);
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Lost request marked as returned and deleted.";
    } else {
        $_SESSION['msg'] = "Failed to mark item as returned.";
    }

    $stmt->close();
    $conn->close();
}

header("Location: ../dashboard/admin/admin_dashboard.php");
exit();
