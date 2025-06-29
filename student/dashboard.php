<?php
session_start();
include '../includes/db_studentlocal.php';
$result = $mysqli->query("SELECT value FROM config WHERE name = 'quota_criteria'");
$criteria_text = '';

if ($result && $row = $result->fetch_assoc()) {
    $criteria_text = $row['value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quota Active Dashboard</title>
  <link rel="stylesheet" href="../css/student-dashboard.css" />

  <style>
    .fixed-dashboard-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-template-rows: auto auto;
      gap: 20px;
      margin-top: 30px;
    }

    .fixed-dashboard-grid .criteria {
      grid-row: 1 / span 2;
    }

    .fixed-dashboard-grid .college {
      grid-column: 2 / 3;
      grid-row: 1;
    }

    .fixed-dashboard-grid .status {
      grid-column: 2 / 3;
      grid-row: 2;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
      .fixed-dashboard-grid {
        display: block;
      }
      .fixed-dashboard-grid .criteria,
      .fixed-dashboard-grid .college,
      .fixed-dashboard-grid .status {
        margin-bottom: 20px;
      }
    }
  </style>

  <!-- botpress chatbot -->
  <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/06/27/07/20250627072905-7RCE1TQ0.js" defer></script>
</head>
<body>

<div class="dashboard-container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">QuotaActive</h2>
    <nav>
      <ul class="nav-list">
        <li class="nav-item active">🏠 Dashboard</li>
        <li class="nav-item"><a href="apply.php" class="nav-link">📝 Apply</a></li>
        <li class="nav-item"><a href="status.php" class="nav-link">📈 Status</a></li>
        <li class="nav-item">💬 Chatbot</li>
        <li class="nav-item"> <a href="profile.php" class="nav-link">👤Profile</a></li> 
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">🚪Logout</a></li>
      </ul>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <header class="main-header">
      <h1>Welcome, Student</h1>
      <p>Here is your application overview.</p>
    </header>

    <!-- Grid Section -->
    <section class="fixed-dashboard-grid">
      <!-- Grid 1: Criteria -->
      <div class="card criteria">
        <h3>📋 Application Criteria</h3>
        <p><?= nl2br(htmlspecialchars($criteria_text)) ?></p>
      </div>

      <!-- Grid 2: Choose College -->
      <div class="card college">
        <h3>🎓 Choose College</h3>
        <div class="college-buttons">
          <button>KTC</button>
          <button>KTDI</button>
          <button>KRP</button>
          <button>K9K10</button>
        </div>
      </div>

      <!-- Grid 3: Application Status -->
      <div class="card status">
        <h3>📊 Application Status</h3>
        <p>Status: <strong class="pending">Pending</strong></p>
        <p>College: <strong>KTDI</strong></p>
        <p>Submitted: <strong>Yes</strong></p>
      </div>
    </section>
  </main>
</div>
</body>
</html>
