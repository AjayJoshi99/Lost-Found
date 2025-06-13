<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Help - Lost & Found Guide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .help-body {
      background-color: #f5f9ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    .help-container {
      max-width: 1000px;
      margin: auto;
      padding: 40px 20px;
    }

    .help-title {
      text-align: center;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 30px;
      color: #007bff;
    }

    .help-card {
      background-color: #ffffff;
      border: 1px solid #e3e3e3;
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 6px 12px rgba(0, 123, 255, 0.1);
      transition: transform 0.3s;
    }

    .help-card:hover {
      transform: translateY(-4px);
    }

    .help-card h5 {
      color: #0056b3;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .help-step-list {
      list-style: decimal inside;
      padding-left: 0;
      font-size: 15px;
    }

    .help-step-list li {
      margin-bottom: 10px;
    }

    .help-note {
      background: #e8f0fe;
      border-left: 5px solid #007bff;
      padding: 15px;
      border-radius: 8px;
      margin-top: 20px;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .help-title {
        font-size: 26px;
      }
    }
  </style>
</head>
<body class="help-body">
  <div class="help-container">
    <h1 class="help-title">📘 How to Use the Lost & Found System</h1>

    <div class="help-card">
      <h5>🧾 Found Request (You Found an Item)</h5>
      <ul class="help-step-list">
        <li>Submit a <strong>Found Request</strong> with details of the item and optional photo.</li>
        <li>Visit the <strong>Lost and Found Department</strong> and hand over the item.</li>
        <li>Once verified, admin will accept the request.</li>
        <li>The item will then be displayed on the homepage for others to see.</li>
      </ul>
    </div>

    <div class="help-card">
      <h5>📢 Lost Request (You Lost an Item)</h5>
      <ul class="help-step-list">
        <li>Submit a <strong>Lost Request</strong> with a detailed description of the lost item.</li>
        <li>This request is only visible to the admin.</li>
        <li>If someone finds your item and submits a Found Request, you will get an <strong>email notification</strong>.</li>
      </ul>
    </div>

    <div class="help-card">
      <h5>📥 Claiming a Found Item</h5>
      <ul class="help-step-list">
        <li>If your lost item appears on the home screen, click <strong>Claim</strong>.</li>
        <li>Fill in your name, email, and contact (auto-filled if logged in).</li>
        <li>Visit the Lost and Found Department with <strong>proof of ownership</strong>.</li>
        <li>Admin will accept your claim and return the item to you.</li>
      </ul>
    </div>

    <div class="help-card">
      <h5>👨‍💼 Admin Process (Handled by Staff)</h5>
      <ul class="help-step-list">
        <li>Admin can accept or reject found and claim requests after physical verification.</li>
        <li>Returned items are manually marked and removed from the database.</li>
        <li>Admins also monitor and handle notifications to users.</li>
      </ul>
    </div>

    <div class="help-note">
      💡 <strong>Note:</strong> Always provide accurate contact details and visit the department within college hours.
    </div>
  </div>
</body>
</html>
