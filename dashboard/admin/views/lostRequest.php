<?php
$conn = new mysqli("localhost", "root", "", "Lost_Found");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM lostrequest";
$params = [];
$types = '';

if ($search !== '') {
    $sql .= " WHERE 
        name LIKE ? OR 
        email LIKE ? OR 
        contact LIKE ? OR 
        date LIKE ? OR 
        time LIKE ? OR 
        itemType LIKE ?";
    $likeSearch = "%$search%";
    for ($i = 0; $i < 6; $i++) {
        $params[] = $likeSearch;
        $types .= 's';
    }
}

$sql .= " ORDER BY id DESC";
$stmt = $conn->prepare($sql);
if ($search !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Lost Requests</title>
  <link href="../../css/studentHome.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f4f6f9;
      font-family: Arial, sans-serif;
    }

    h2.page-title {
      text-align: center;
      margin-bottom: 1rem;
      color: #333;
    }

    .filter-bar {
      margin-bottom: 20px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 15px;
    }
    .filter-bar label {
      margin-right: 8px;
      font-weight: bold;
    }
    input[type="text"] {
      padding: 5px 8px;
      font-size: 14px;
      width: 180px;
    }
    button[type="submit"] {
      padding: 6px 12px;
      font-size: 14px;
      cursor: pointer;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
      justify-content: center;
    }

    .card {
      width: 320px;
      border: 1px solid #ccc;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 1px solid #ccc;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .card-body {
      padding: 15px;
    }

    .card-body h5 {
      font-weight: bold;
      color: #007bff;
      margin-bottom: 10px;
    }

    .card-body p {
      font-size: 14px;
      margin: 4px 0;
      color: #333;
    }

    .card-body form button {
      margin-top: 10px;
      padding: 8px 12px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
    }

    .card-body form button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <h2 class="page-title">All Lost Requests</h2>

  <form method="get" action="" class="filter-bar">
         <label for="search">Search Item Type:</label>
        <input type="text" id="search" name="search" placeholder="e.g. laptop" value="<?= htmlspecialchars($search) ?>">
      </form>

  <div class="card-container">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
          <a href="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" target="_blank">
            <img src="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" alt="Item Image">
          </a>
          <div class="card-body">
            <h5><?= htmlspecialchars($row['itemType']) ?></h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($row['date']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($row['time']) ?></p>
            <form method="post" action="../../../script/mark_returned.php" onsubmit="return confirm('Mark this item as returned?');">
              <input type="hidden" name="lost_id" value="<?= $row['id'] ?>">
              <button type="submit">Returned</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align: center; margin-top: 40px;">No lost requests found.</p>
    <?php endif; ?>
  </div>

</body>
</html>
