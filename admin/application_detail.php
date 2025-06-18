// application_detail.php
<?php
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  die("Invalid application ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newStatus = $_POST['action'] === 'approve' ? 'approved' : 'rejected';
  $stmt = $conn->prepare("UPDATE application SET status=? WHERE id=?");
  $stmt->bind_param("si", $newStatus, $id);
  $stmt->execute();
  $stmt->close();
  header("Location: view_applications.php?status=$newStatus");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM application WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
  die("Application not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Application Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Quota System Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="view_applications.php">View Applications</a></li>
        <li class="nav-item"><a class="nav-link" href="rankings.php">Rankings</a></li>
        <li class="nav-item"><a class="nav-link" href="edit_criteria.php">Edit Criteria</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h3>Application Detail</h3>
  <table class="table table-bordered">
    <tr><th>Matrix No</th><td><?= htmlspecialchars($data['matrix_no']) ?></td></tr>
    <tr><th>Name</th><td><?= htmlspecialchars($data['name']) ?></td></tr>
    <tr><th>College</th><td><?= htmlspecialchars($data['college']) ?></td></tr>
    <tr><th>Year of Study</th><td><?= htmlspecialchars($data['year_of_study']) ?></td></tr>
    <tr><th>Gender</th><td><?= htmlspecialchars($data['gender']) ?></td></tr>
    <tr><th>Status</th><td><?= htmlspecialchars(ucfirst($data['status'])) ?></td></tr>
    <tr><th>Merit Points</th><td><?= htmlspecialchars($data['merit']) ?></td></tr>
    <tr><th>Submitted At</th><td><?= htmlspecialchars($data['submitted_at']) ?></td></tr>
  </table>
  <form method="POST" onsubmit="return confirm('Are you sure?');">
    <button name="action" value="approve" class="btn btn-success">Approve</button>
    <button name="action" value="reject" class="btn btn-danger">Reject</button>
    <a href="view_applications.php" class="btn btn-secondary">Back</a>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
