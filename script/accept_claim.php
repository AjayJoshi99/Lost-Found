<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['claim_id'])) {
    $conn = new mysqli("localhost", "root", "", "Lost_Found");
    if ($conn->connect_error) {
        $_SESSION['msg'] = "Database connection failed!";
        header("Location: ../dashboard/admin/admin_dashboard.php");
        exit();
    }

    $claim_id = $_POST['claim_id']; 

    $stmt = $conn->prepare("SELECT claimer_name, claimer_email, claimer_contact FROM claims WHERE image_url = ?");
    $stmt->bind_param("s", $claim_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['msg'] = "Claim not found!";
        $stmt->close();
        $conn->close();
        header("Location: ../dashboard/admin/admin_dashboard.php");
        exit();
    }

    $stmt->bind_result($claimer_name, $claimer_email, $claimer_contact);
    $stmt->fetch();
    $stmt->close();

    $stmt1 = $conn->prepare("DELETE FROM claims WHERE image_url = ?");
    $stmt1->bind_param("s", $claim_id);
    $success1 = $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("DELETE FROM foundrequest WHERE image_url = ?");
    $stmt2->bind_param("s", $claim_id);
    $success2 = $stmt2->execute();
    $stmt2->close();

    if ($success1 && $success2) {
        $claimed_date = date("Y-m-d");
        $stmt3 = $conn->prepare("UPDATE history SET claimer_name = ?, claimer_email = ?, claimer_contact = ?, claimed_date = ? WHERE image_url = ?");
        $stmt3->bind_param("sssss", $claimer_name, $claimer_email, $claimer_contact, $claimed_date, $claim_id);
        $stmt3->execute();
        $stmt3->close();
        $_SESSION['msg'] = "Claim accepted successfully !!!";
    } else {
        $_SESSION['msg'] = "Failed to complete claim process.";
    }

    $conn->close();
}

header("Location: ../dashboard/admin/admin_dashboard.php");
exit();
