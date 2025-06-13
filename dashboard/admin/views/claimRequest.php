<?php
session_start();

$conn = new mysqli("localhost", "root", "", "Lost_Found");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM claims";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Claim Requests</title>
  <link href="../../css/studentHome.css" rel="stylesheet">
  <style>
    .card-container { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
    .card {
      width: 320px; border: 1px solid #ccc; border-radius: 8px;
      background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.1); overflow: hidden;
    }
    .card-content { padding: 15px; }
    .card-content h5 { margin: 0 0 8px; color: #333; }
    .card-content p { margin: 4px 0; font-size: 14px; color: #555; }
    .card-content form button {
      margin-top: 10px; padding: 8px 12px;
      background-color: #007bff; color: white;
      border: none; border-radius: 4px; cursor: pointer;
    }
    .card-content form button:hover { background-color: #0056b3; }
    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ccc;
      }
      .title {
      text-align: center;
      margin-bottom: 2rem;
      color: #333;
    }
    
    .card-content form button {
      margin-top: 10px;
      padding: 8px 12px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
    }
    .card-content form button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

<h2 class ="title">Pending Claim Requests</h2>

<div class="card-container">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="card">
        <a href="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" target="_blank">
          <img src="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>"  alt="Item Image">
        </a>

        <div class="card-content">
          <h5>Claimed by: <?= htmlspecialchars($row['claimer_name']) ?></h5>
          <p><strong>Email:</strong> <?= htmlspecialchars($row['claimer_email']) ?></p>
          <p><strong>Contact:</strong> <?= htmlspecialchars($row['claimer_contact']) ?></p>
          <p><strong>Claim Date:</strong> <?= htmlspecialchars($row['claim_date']) ?></p>
          <p><strong>Found By:</strong> <?= htmlspecialchars($row['found_by_name']) ?> (<?= htmlspecialchars($row['found_by_email']) ?>)</p>
          <form method="post" action="../../../script/accept_claim.php" onsubmit="return confirm('Accept this claim?');">
            <input type="hidden" name="claim_id" value="<?= $row['image_url'] ?>">
            <button type="submit">Accept</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="margin-left: 20px;">No pending claim requests.</p>
  <?php endif; ?>
</div>

</body>
</html>
