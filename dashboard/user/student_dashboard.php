<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Lost_Found';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
$filters = $_GET['filter'] ?? []; 

$allowedFilters = ['mouse', 'laptop', 'charger', 'jewellery', 'i-card', 'bag', 'stationary-item', 'watch', 'bottle', 'other', 'key'];


$filters = array_filter($filters, function($f) use ($allowedFilters) {
    return in_array($f, $allowedFilters);
});

$sql = "SELECT * FROM foundrequest WHERE accepted = 1";
$params = [];
$types = '';

if ($search !== '') {
    $searchTerm = "%$search%";
    $sql .= " AND (
        itemType LIKE ? OR
        Name LIKE ? OR
        email LIKE ? OR
        contact LIKE ? OR
        date LIKE ? OR
        time LIKE ?
    )";
    for ($i = 0; $i < 6; $i++) {
        $params[] = $searchTerm;
        $types .= 's';
    }
}

if (count($filters) > 0) {
    $placeholders = implode(',', array_fill(0, count($filters), '?'));
    $sql .= " AND itemType IN ($placeholders)";
    foreach ($filters as $f) {
        $params[] = $f;
        $types .= 's';
    }
}

$sql .= " ORDER BY date DESC";

$stmt = $conn->prepare($sql);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Home Page</title>
  <link href="../../css/studentHome.css" rel="stylesheet">
  <link href="../../css/studentHome2.css" rel="stylesheet">
  <style>
    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }
    .card {
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      background: #fff;
    }
    .card-img img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .card-content {
      padding: 15px;
    }
    .card-content h5 {
      margin-top: 0;
      font-size: 18px;
      color: #333;
    }
    .card-content p {
      font-size: 14px;
      color: #555;
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
    .filter-checkboxes label {
      margin-right: 10px;
      font-weight: normal;
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
  </style>
</head>
<script>
  function toggleForm(id) {
    const form = document.getElementById(id);
    if (form.style.display === 'none') {
      form.style.display = 'block';
    } else {
      form.style.display = 'none';
    }
  }
</script>

<body>
  <div class="container">
    <aside class="sidebar" id="sidebar">
      <h2>Student Menu</h2>
      <nav>
        <a href="#" id="Home">Home</a>
        <a href="#" id="lostRequestLink">Lost Request</a>
        <a href="#" id="foundRequestLink">Found Request</a>
        <a href="#" id="Help">Help</a>
        <?php include '../../logout_component.php'; ?>
      </nav>
    </aside>

    <main class="main-content" id="mainContent">
      <h1>Welcome to the Student Home Page</h1>

      <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert" style="padding: 10px; background-color: #d4edda; color: #155724; margin: 10px 0; border-radius: 5px;">
          <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
      <?php endif; ?>

      <form method="get" action="" class="filter-bar">
        <label for="search">Search Item Type:</label>
        <input type="text" id="search" name="search" placeholder="e.g. laptop" value="<?= htmlspecialchars($search) ?>">

        <div class="filter-checkboxes">
          <label><input type="checkbox" name="filter[]" value="mouse" <?= in_array('mouse', $filters) ? 'checked' : '' ?>> Mouse</label>
          <label><input type="checkbox" name="filter[]" value="laptop" <?= in_array('laptop', $filters) ? 'checked' : '' ?>> Laptop</label>
          <label><input type="checkbox" name="filter[]" value="charger" <?= in_array('charger', $filters) ? 'checked' : '' ?>> Charger</label>
          <label><input type="checkbox" name="filter[]" value="jewellery" <?= in_array('jewellery', $filters) ? 'checked' : '' ?>> Jewellery</label>
          <label><input type="checkbox" name="filter[]" value="i-card" <?= in_array('i-card', $filters) ? 'checked' : '' ?>> I-Card</label>
          <label><input type="checkbox" name="filter[]" value="bag" <?= in_array('bag', $filters) ? 'checked' : '' ?>> Bag</label>
          <label><input type="checkbox" name="filter[]" value="stationary-item" <?= in_array('stationary-item', $filters) ? 'checked' : '' ?>> Stationary-item</label>
          <label><input type="checkbox" name="filter[]" value="watch" <?= in_array('watch', $filters) ? 'checked' : '' ?>> Watch</label>
          <label><input type="checkbox" name="filter[]" value="bottle" <?= in_array('bottle', $filters) ? 'checked' : '' ?>> Bottle</label>
          <label><input type="checkbox" name="filter[]" value="key" <?= in_array('key', $filters) ? 'checked' : '' ?>> Key</label>
          <label><input type="checkbox" name="filter[]" value="other" <?= in_array('other', $filters) ? 'checked' : '' ?>> Other</label>
        </div>
        <button type="submit">Filter</button>
      </form>

      <h2>Found Items</h2>
      <div class="card-container">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
              <div class="card-img">
                <a href="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" target="_blank">
                    <img src="../../<?= htmlspecialchars($row['image_url'] ?? '') ?>" class="card-img-top admin-lost-img" alt="Item Image">
                  </a>
              </div>
              <div class="card-content">
                <h5><?= htmlspecialchars($row['Name']) ?></h5>
                <p>
                  <strong>Type:</strong> <?= htmlspecialchars($row['itemType']) ?><br>
                  <strong>Date:</strong> <?= htmlspecialchars($row['date']) ?><br>
                  <strong>Time:</strong> <?= htmlspecialchars($row['time']) ?><br>
                  <strong>Email:</strong> <?= htmlspecialchars($row['email']) ?><br>
                  <strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?>
                </p>
          </br>
                <button type="button" class="claim-btn-unique" onclick="toggleForm('form-<?= md5($row['image_url']) ?>')">Claim Request</button>
                <form action="../../script/claim_found.php" method="post" 
                    id="form-<?= md5($row['image_url']) ?>" 
                    class="claim-form-unique" 
                    style="display:none; margin-top: 15px;">
                
                <input type="hidden" name="image_url" value="<?= htmlspecialchars($row['image_url']) ?>">
                <input type="hidden" name="found_by_name" value="<?= htmlspecialchars($row['Name']) ?>">
                <input type="hidden" name="found_by_email" value="<?= htmlspecialchars($row['email']) ?>">
                <input type="hidden" name="claimer_email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">

                <div class="form-group-unique">
                  <label>Your Name:</label>
                  <input type="text" name="claimer_name" required placeholder="Enter your name" 
                        value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>">
                </div>

                <div class="form-group-unique">
                  <label>Mobile Number:</label>
                  <input type="text" name="claimer_contact" required placeholder="Enter mobile number">
                </div>

                <button type="submit" class="claim-btn-unique" onclick="return confirm('Submit claim request?')">
                  Submit Claim
                </button>
              </form>

              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No found items have been accepted yet.</p>
        <?php endif; ?>
      </div>
      <footer class="student-footer-bar">
        <p>© <?= date('Y') ?> Marwadi Unievrsity All rights reserved.</p>
      </footer>
    </main>
    
  </div>


  <button class="floating-btn" id="toggleSidebar" title="Toggle Sidebar">&#9776;</button>
  <script src="../../script/studentHome.js"></script>
</body>
</html>
