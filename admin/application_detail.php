<?php
include __DIR__ . '/includes/auth.php';
include __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "Invalid application ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['action'] === 'approve' ? 'approved' : 'rejected';
    $stmt = $conn->prepare("UPDATE applications SET status=? WHERE id=?");
    $stmt->bind_param("si", $newStatus, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: view_applications.php?status=$newStatus");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM applications WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    echo "Application not found.";
    exit;
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
<div class="container mt-4">
    <h3>Application Detail</h3>
    <table class="table table-bordered">
        <tr><th>Matrix No</th><td><?= htmlspecialchars($data['matrix_no']) ?></td></tr>
        <tr><th>Name</th><td><?= htmlspecialchars($data['name']) ?></td></tr>
        <tr><th>College</th><td><?= htmlspecialchars($data['college']) ?></td></tr>
        <tr><th>Year of Study</th><td><?= htmlspecialchars($data['year_of_study']) ?></td></tr>
        <tr><th>Status</th><td><?= htmlspecialchars(ucfirst($data['status'])) ?></td></tr>
        <tr><th>Submitted At</th><td><?= htmlspecialchars($data['submitted_at']) ?></td></tr>
    </table>
    <form method="POST" onsubmit="return confirm('Are you sure?');">
        <button name="action" value="approve" class="btn btn-success">Approve</button>
        <button name="action" value="reject" class="btn btn-danger">Reject</button>
        <a href="view_applications.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>