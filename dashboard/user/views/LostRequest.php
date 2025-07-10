<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lost Request - Lost & Found Portal</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Styling -->
  <style>
    body {
      background: #fafafa;
      font-family: 'Segoe UI', sans-serif;
    }

    .m_content {
      background: linear-gradient(135deg, #f44336, #ffcdd2); /* Red to Light Red */
      padding: 40px 20px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      color: #000;
      max-width: 1000px;
      margin: 40px auto;
    }

    .card {
      background: #fff5f5;
      border-radius: 16px;
    }

    .intro-section {
      text-align: center;
      margin-bottom: 30px;
    }

    .intro-section h1 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #b71c1c;
    }

    .intro-section p {
      font-size: 1.1rem;
      color: #333;
      max-width: 750px;
      margin: auto;
    }

    .form-label {
      font-weight: 600;
    }

    .input-group-text {
      background-color: #fff0f0;
      /* border-color: #f44336; */
    }

    .form-control, .form-select {
      border-radius: 8px;
    }

    .btn-danger {
      font-weight: 600;
      border-radius: 8px;
    }

    .btn-danger:hover {
      background-color: #c62828;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      font-size: 0.9rem;
      color: #555;
    }

    footer a {
      color: #b71c1c;
      text-decoration: none;
    }
  </style>
</head>

<body>

  <div class="form-wrapper mt-5 d-flex justify-content-center m_content">

    <div class="w-100">

      <div class="intro-section mb-4">
        <h1><i class="bi bi-clipboard-check-fill me-2"></i> Report Lost Item</h1>
        <p>
          Lost something on campus? Don't worry! Please fill out this form with accurate details so we can help track down your item and get it back to you as soon as possible.
        </p>
      </div>

  
      <div class="card shadow border-danger border-2 rounded-4 w-100 mx-auto" style="max-width: 600px;">
        <div class="card-body">
          <h2 class="text-center fw-bold mb-4 text-danger">
            <i class="bi bi-exclamation-circle-fill me-2"></i>Lost Request Form
          </h2>

          <form id="lostRequestForm" action="../../script/lost_request_submit.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="name" class="form-label">Name :</label>
              <div class="input-group">
                <span class="input-group-text text-danger"><i class="bi bi-person-circle"></i></span>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required />
              </div>
            </div>

            <div class="mb-3">
              <label for="itemType" class="form-label">Item Type :</label>
              <select class="form-select" id="itemType" name="itemType" required>
                <option value="" disabled selected>Select an item</option>
                <option value="watch">Watch</option>
                <option value="bottle">Bottle</option>
                <option value="i-card">I-card</option>
                <option value="jewellery">Jewellery</option>
                <option value="mouse">Mouse</option>
                <option value="charger">Charger</option>
                <option value="bag">Bag</option>
                <option value="laptop">Laptop</option>
                <option value="stationary-item">Stationary-item</option>
                <option value="key">Key</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Upload Image :</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" required />
            </div>

            <div class="mb-4">
              <label for="contact" class="form-label">Contact No. :</label>
              <div class="input-group">
                <span class="input-group-text text-danger"><i class="bi bi-telephone-forward-fill"></i></span>
                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter your contact number" required />
              </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 shadow-sm">
              <i class="bi bi-search me-1"></i> Submit Lost Item
            </button>
          </form>
        </div>
      </div>

      <!-- Footer -->
      <footer class="mt-4">
        <p>Having trouble? Contact <a href="mailto:support@university.edu">support@university.edu</a></p>
        <p>&copy; <?= date('Y') ?> Marwadi University Lost & Found Portal</p>
      </footer>

    </div>

  </div>

</body>
</html>
