<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../vendor/autoload.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Lost_Found';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo "<div class='alert'>Database connection failed: " . $conn->connect_error . "</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_id'])) {
    $imageUrl = $conn->real_escape_string($_POST['accept_id']);

    $sql_get_item = "SELECT itemType FROM foundrequest WHERE image_url = '$imageUrl'";
    $result = $conn->query($sql_get_item);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $itemType = $row['itemType'];

        $sql_update = "UPDATE foundrequest SET accepted = 1 WHERE image_url = '$imageUrl'";
        if ($conn->query($sql_update)) {

            $sql_lost = "SELECT email FROM lostrequest WHERE itemType = '$itemType'";
            $lost_results = $conn->query($sql_lost);

            if ($lost_results && $lost_results->num_rows > 0) {
                while ($lostUser = $lost_results->fetch_assoc()) {
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'a35183205@gmail.com'; //ajayjoshi1908@gmail.com
                        $mail->Password = 'pvtwwwtdkcdjcrdi'; 
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('lost.found.marwadiuniversity@gmail.com', 'Lost & Found System');
                        $mail->addAddress($lostUser['email'], 'User');

                        $mail->isHTML(true);
                        $mail->Subject = "Item Found Notification: $itemType";
                        $mail->Body = "Hello User,<br><br>
                                       An item matching your lost request (<strong>$itemType</strong>) has been found.<br>
                                       Please visit the Lost & Found office to verify.<br><br>Regards,<br>Lost & Found Team";
                        $mail->AltBody = "Hello User,\nAn item matching your lost request ($itemType) has been found.\nPlease visit the Lost & Found office to verify.\n\nRegards,\nLost & Found Team";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("Mail error to {$lostUser['email']}: {$mail->ErrorInfo}");
                    }
                }
            }

             header("Location: ../admin_dashboard.php");
            exit();

        } else {
            echo "Failed to update found request as accepted.";
        }
    } else {
        echo "No found request found with the given image URL.";
    }
}

$query = "SELECT * FROM foundrequest WHERE accepted = 0";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pending Found Requests</title>
  <link rel="stylesheet" href="../../../css/adminFoundReq.css">
</head>
<body>

<div class="pending-requests-page">
  <h3 class="title">Pending Found Requests</h3>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="card">
          <div class="card-img">
            <a href="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" target="_blank">
            <img src="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" class="card-img-top admin-lost-img" alt="Item Image">
          </a>

          </div>
          <div class="card-content">
            <h5>Name : <?= htmlspecialchars($row['Name'] ?? 'No name') ?></h5>
            <p>
              <strong>Email:</strong> <?= htmlspecialchars($row['email'] ?? 'N/A') ?><br>
              <strong>Contact:</strong> <?= htmlspecialchars($row['contact'] ?? 'N/A') ?><br>
              <strong>Item Type:</strong> <?= htmlspecialchars($row['itemType'] ?? 'N/A') ?><br>
              <strong>Date:</strong> <?= htmlspecialchars($row['date'] ?? 'N/A') ?><br>
              <strong>Time:</strong> <?= htmlspecialchars($row['time'] ?? 'N/A') ?>
            </p>
            <input type="hidden" name="accept_id" value="<?= htmlspecialchars($row['image_url']) ?>">
            <button class="accept-btn" type="submit">Accept</button>
          </div>
        </div>
      </form>
    <?php endwhile; ?>
  <?php else: ?>
    <div style="color: gray; padding: 10px;">No pending requests found.</div>
  <?php endif; ?>
</div>

</body>
</html>
