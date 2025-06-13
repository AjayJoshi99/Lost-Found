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

$itemType = 'mouse';
$sql = "SELECT email, contact FROM lostrequest WHERE itemType = '$itemType'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $htmlBody = "<h3>Matching Lost Requests for '$itemType'</h3><table border='1' cellpadding='8' cellspacing='0'>";
    $htmlBody .= "<tr><th>Name</th><th>Email</th><th>Contact</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $htmlBody .= "<tr>
                        
                        <td>{$row['email']}</td>
                        <td>{$row['contact']}</td>
                      </tr>";
    }
    $htmlBody .= "</table>";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ajayjoshi1908@gmail.com';
        $mail->Password = 'lbtqlgjzfusfsdcd'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ajayjoshi1908@gmail.com', 'Lost & Found System');
        $mail->addAddress('ajay.joshi119418@marwadiuniversity.ac.in', 'Admin');

        $mail->isHTML(true);
        $mail->Subject = "Lost Items Report - '$itemType'";
        $mail->Body    = $htmlBody;
        $mail->AltBody = "There are lost requests for itemType = $itemType. Please check the system.";

        $mail->send();
        echo "Mail sent successfully with lost item data.";
    } catch (Exception $e) {
        echo "Mail Error: " . $mail->ErrorInfo;
    }
} else {
    echo "No data found for itemType = '$itemType'";
}

$conn->close();
?>
