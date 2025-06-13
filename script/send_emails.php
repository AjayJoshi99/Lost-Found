<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$conn = new mysqli('localhost', 'root', '', 'Lost_Found');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itemType'])) {
    $itemType = $conn->real_escape_string($_POST['itemType']);

    $sql_lost = "SELECT email, contact FROM lostrequest WHERE itemType = '$itemType'";
    $lost_results = $conn->query($sql_lost);

    if ($lost_results && $lost_results->num_rows > 0) {
        foreach ($lost_results as $lostUser) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ajayjoshi1908@gmail.com';
                $mail->Password = 'lbtqlgjzfusfsdcd'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ajayjoshi1908@gmail.com', 'Lost & Found System');
                $mail->addAddress($lostUser['email'], 'User');

                $mail->isHTML(true);
                $mail->Subject = "Item Found Notification: '$itemType'";
                $mail->Body = "Hello " . htmlspecialchars($lostUser['name']) . ",<br><br>
                               An item matching your lost request (<strong>$itemType</strong>) has been found.<br>
                               Please visit the Lost & Found office to verify.<br><br>Regards,<br>Lost & Found Team";
                $mail->AltBody = "Hello  user,\nAn item matching your lost request ($itemType) has been found.\nPlease visit the Lost & Found office to verify.\n\nRegards,\nLost & Found Team";

                $mail->send();
                echo "Email sent to " . $lostUser['email'] . "<br>";
            } catch (Exception $e) {
                echo "Failed to send email to " . $lostUser['email'] . ": " . $mail->ErrorInfo . "<br>";
            }
        }
    } else {
        echo "No lost requests found for itemType = '$itemType'.";
    }
} else {
    echo "Invalid request.";
}
?>
