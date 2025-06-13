<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'Lost_Found');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_url'])) {
    $image_url = $conn->real_escape_string($_POST['image_url']);


    $sql_get_item = "SELECT itemType FROM foundrequest WHERE image_url = '$image_url'";
    $result = $conn->query($sql_get_item);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $itemType = $row['itemType'];

        $sql_update = "UPDATE foundrequest SET accepted = 1 WHERE image_url = '$image_url'";
        if ($conn->query($sql_update)) {

            $sql_lost = "SELECT email, contact FROM lostrequest WHERE itemType = '$itemType'";
            $lost_results = $conn->query($sql_lost);

            if ($lost_results && $lost_results->num_rows > 0) {

                $htmlBody = "<h3>Matching Lost Requests for '$itemType'</h3><table border='1' cellpadding='8' cellspacing='0'>";
                $htmlBody .= "<tr><th>Email</th><th>Contact</th></tr>";
                
                while ($lostUser = $lost_results->fetch_assoc()) {
                    $htmlBody .= "<tr>
                                    
                                    <td>" . htmlspecialchars($lostUser['email']) . "</td>
                                    <td>" . htmlspecialchars($lostUser['contact']) . "</td>
                                  </tr>";
                }
                $htmlBody .= "</table>";
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
                        $mail->addAddress($lostUser['email'], $lostUser['name']);

                        $mail->isHTML(true);
                        $mail->Subject = "Item Found Notification: '$itemType'";
                        $mail->Body = "Hello " . htmlspecialchars($lostUser['name']) . ",<br><br>
                                       An item matching your lost request (<strong>$itemType</strong>) has been found.<br>
                                       Please visit the Lost & Found office to verify.<br><br>Regards,<br>Lost & Found Team";
                        $mail->AltBody = "Hello " . $lostUser['name'] . ",\nAn item matching your lost request ($itemType) has been found.\nPlease visit the Lost & Found office to verify.\n\nRegards,\nLost & Found Team";

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
            echo "Failed to update found request as accepted.";
        }
    } else {
        echo "No found request found with the given image URL.";
    }
} else {
    echo "Invalid request.";
}


header("Location: ../dashboard/admin/admin_dashboard.php");
?>
