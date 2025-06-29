
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

  <!-- botpres chatbot  -->
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
    <section class="card-grid">
      <!-- Left Column -->
       <div class="card info">
    <h3>📋 Application Criteria</h3>
    <p><?= nl2br(htmlspecialchars($criteria_text)) ?></p>
  </div>
</section>

      <!-- Top Right -->
      <div class="card choices">
        <h3>🎓 Choose College</h3>
        <div class="college-buttons">
          <button>KTC</button>
          <button>KTDI</button>
          <button>KRP</button>
          <button>K9K10</button>
        </div>
      </div>

      <!-- Bottom Right -->
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
