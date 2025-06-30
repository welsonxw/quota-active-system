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
$student_name = '';
if ($student_id) {
  $stmt = $mysqli->prepare("SELECT fullname FROM student WHERE student_id = ?");
  $stmt->bind_param("i", $student_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $student_name = $row['fullname'] ?? 'Student';
}

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quota Active Dashboard</title>
  <link rel="stylesheet" href="../css/student-dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- botpress chatbot -->
  <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/06/27/07/20250627072905-7RCE1TQ0.js" defer></script>
</head>

<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-logo text-center my-4">
        <img src="../assets/webug2.png" alt="QAWS Logo" class="sidebar-logo-img">
      </div>

      <i class="fas fa-user-circle profile-avatar-icon"></i>

      <nav>
        <ul class="nav-list">
          <li class="nav-item active"><i class="fas fa-home"></i> Dashboard</a></li>
          <li class="nav-item"><a href="apply.php" class="nav-link"><i class="fas fa-edit"></i> Apply</a></li>
          <li class="nav-item"><a href="profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="main-header">
        <h1>Welcome, <?= htmlspecialchars($student_name) ?></h1>
        <p>Here is your application overview.</p>
      </header>

      <section class="fixed-dashboard-grid">
        <!-- Application Criteria -->
        <div class="card criteria">
          <h3><i class="fas fa-clipboard-list"></i> Application Criteria</h3>
          <p><?= nl2br(htmlspecialchars($criteria_text)) ?></p>
        </div>

        <!-- College Info -->
        <div class="card college">
          <h3><i class="fas fa-school"></i> College Information</h3>
          <div class="college-buttons">
            <a href="https://studentaffairs.utm.my/kolejtuankucanselor/"><button>KTC</button></a>
            <a href="https://studentaffairs.utm.my/ktdi/"><button>KTDI</button></a>
            <a href="https://studentaffairs.utm.my/kolejrahmanputra/"><button>KRP</button></a>
          </div>
        </div>

        <!-- Application Status -->
        <div class="card status">
          <h3><i class="fas fa-clipboard-check"></i> Application Status</h3>
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
            <p>Status: <strong style="color: <?= $statusColor ?>;"><?= ucfirst(htmlspecialchars($application['status'])) ?></strong></p>
            <p>College: <strong>KTDI</strong></p>
            <p>Submitted: <strong><?= $application['submitted_at'] ? 'Yes' : 'No' ?></strong></p>
          <?php else: ?>
            <p>No application found.</p>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div> <!-- moved here: closes .dashboard-container correctly -->
</body>


</html>