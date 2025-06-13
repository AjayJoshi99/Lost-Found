<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<div class="form-wrapper mt-5 d-flex justify-content-center">
  <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 600px;">
    <div class="card-body">
      <h2 class="text-center fw-bold mb-4 text-primary">
        <i class="bi bi-box-arrow-in-down"></i> Found Request Form
      </h2>

      <form id="lostRequestForm" action="../../script/foundRequest.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label fw-semibold">Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required />
          </div>
        </div>

        <div class="mb-3">
          <label for="itemType" class="form-label fw-semibold">Item Type</label>
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
          <label for="image" class="form-label fw-semibold">Upload Image</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" required />
        </div>

        <div class="mb-4">
          <label for="contact" class="form-label fw-semibold">Contact No.</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" class="form-control" id="contact" name="contact" placeholder="Enter your contact number" required />
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 shadow-sm">
          <i class="bi bi-send-fill me-1"></i> Submit Request
        </button>
      </form>
    </div>
  </div>
</div>
