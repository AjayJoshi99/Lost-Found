<?php
session_start();
$search = $_GET['search'] ?? '';

$conn = new mysqli("localhost", "root", "", "Lost_Found");
if ($conn->connect_error) {
    echo "<p>Database connection failed!</p>";
} else {
    $sql = "SELECT * FROM history";
    $params = [];
    $types = '';

    if ($search !== '') {
        $sql .= " WHERE 
            founder_name LIKE ? OR
            founder_email LIKE ? OR
            founder_contact LIKE ? OR
            found_date LIKE ? OR
            claimer_name LIKE ? OR
            claimer_email LIKE ? OR
            claimer_contact LIKE ? OR
            claimed_date LIKE ?
        ";
        $likeSearch = "%$search%";
        for ($i = 0; $i < 8; $i++) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Home Page</title>
  <link href="../../css/studentHome.css" rel="stylesheet">
  <style>
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
  </style>
</head>
<body>
  <div class="container">
    <aside class="sidebar" id="sidebar">
      <h2>Admin Menu</h2>
      <nav>
        <a href="#" id="adminHome">Home</a>
        <a href="#" id="lostLink">Lost Requests</a>
        <a href="#" id="foundLink">Found Requests</a>
        <a href="#" id="claimRequest">Claim Requests</a>
        <?php include '../../logout_component.php'; ?>
      </nav>
    </aside>

    <main class="main-content" id="mainContent">
      <h1>Welcome to the Admin Home Page</h1>

      <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert" style="padding: 10px; background-color: #d4edda; color: #155724; margin: 10px 0; border-radius: 5px;">
          <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
      <?php endif; ?>

      <form method="get" action="" class="filter-bar">
         <label for="search">Search Item Type:</label>
        <input type="text" id="search" name="search" placeholder="e.g. laptop" value="<?= htmlspecialchars($search) ?>">
      </form>

      <h3>History</h3>
      <?php
        if ($result && $result->num_rows > 0) {
            echo '<div class="history-list">';
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="history-card">
                  <a href="../../' . htmlspecialchars($row['image_url']) . '" target="_blank">
                    <img src="../../' . htmlspecialchars($row['image_url']) . '" class="card-img-top admin-lost-img" alt="Item Image">
                  </a>
                  <div class="details">
                    <p><strong>Found By:</strong> ' . htmlspecialchars($row['founder_name']) . ' (' . htmlspecialchars($row['founder_email']) . ')</p>
                    <p><strong>Contact:</strong> ' . htmlspecialchars($row['founder_contact']) . '</p>
                    <p><strong>Found Date:</strong> ' . htmlspecialchars($row['found_date']) . '</p>
                    <hr>
                    <p><strong>Claimed By:</strong> ' . ($row['claimer_name'] ?? 'Not yet claimed') . '</p>
                    <p><strong>Email:</strong> ' . ($row['claimer_email'] ?? '-') . '</p>
                    <p><strong>Contact:</strong> ' . ($row['claimer_contact'] ?? '-') . '</p>
                    <p><strong>Claimed Date:</strong> ' . ($row['claimed_date'] ?? '-') . '</p>
                  </div>
                </div>';
            }
            echo '</div>';
        } else {
            echo '<p>No history records found.</p>';
        }
        $conn->close();
      ?>
    </main>
  </div>

  <button class="floating-btn" id="toggleSidebar" title="Toggle Sidebar">&#9776;</button>
  <script src="../../script/adminHome.js"></script>
</body>
</html>
<?php
}
?>
