<?php
session_start();
include '../includes/db_studentlocal.php';

$student_id = $_SESSION['student_id'] ?? null;

// Fetch quota criteria text
$criteria_text = '';
$result = $mysqli->query("SELECT value FROM config WHERE name = 'quota_criteria'");
if ($result && $row = $result->fetch_assoc()) {
    $criteria_text = $row['value'];
}

// Fetch application info
$application = null;
if ($student_id) {
    $stmt = $mysqli->prepare("SELECT status,  submitted_at FROM applications WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quota Active Dashboard</title>
  <link rel="stylesheet" href="../css/student-dashboard.css" />

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
        <li class="nav-item active">Dashboard</li>
        <li class="nav-item">Chatbot</li>
        <li class="nav-item"> <a href="profile.php" class="nav-link">Profile</a></li> 
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
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
        <h3>Application Criteria</h3>
        <p><?= nl2br(htmlspecialchars($criteria_text)) ?></p>
      </div>

      <!-- Grid 2: Choose College -->
      <div class="card college">
        <h3>Choose College</h3>
        <div class="college-buttons">
          <button>KTC</button>
          <button>KTDI</button>
          <button>KRP</button>
          <button>K9K10</button>
        </div>
      </div>

      <!-- Grid 3: Application Status -->
      <div class="card status">
        <h3>Application Status</h3>
        <?php if ($application): ?>
<?php
  $status = strtolower($application['status']);
  $statusColor = match ($status) {
      'accepted' => 'green',
      'rejected' => 'red',
      'pending'  => 'orange',
      default    => 'black'
  };
?>
<p>Status: 
  <strong style="color: <?= $statusColor ?>;">
    <?= ucfirst(htmlspecialchars($application['status'])) ?>
  </strong>
</p>
          <p>College: <strong>KTDI</strong></p>
          <p>Submitted: <strong><?= $application['submitted_at'] ? 'Yes' : 'No' ?></strong></p>
        <?php else: ?>
          <p>No application found.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>
</div>
</body>
</html>
