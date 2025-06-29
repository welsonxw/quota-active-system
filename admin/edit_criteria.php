<?php
// admin/edit_criteria.php
require_once __DIR__ . '/../includes/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criteria = $_POST['criteria'] ?? '';
    if ($criteria) {
        $stmt = $mysqli->prepare("UPDATE config SET value=? WHERE name='quota_criteria'");
        $stmt->bind_param("s", $criteria);
        $stmt->execute();
        $stmt->close();
        $message = '<div class="alert alert-success" role="alert">Criteria updated successfully.</div>';
    } else {
        $message = '<div class="alert alert-danger" role="alert">Please enter valid criteria.</div>';
    }
}

$result = $mysqli->query("SELECT value FROM config WHERE name='quota_criteria'");
$row = $result->fetch_assoc();
$current = $row ? htmlspecialchars($row['value']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quota Criteria - Quota System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2 class="mb-4">Edit Quota Criteria</h2>
        <?php if ($message): ?>
            <?= $message ?>
        <?php endif; ?>
        <div class="card p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="criteria" class="form-label">Quota Criteria</label>
                    <textarea class="form-control" id="criteria" name="criteria" rows="5" placeholder="Enter quota criteria"><?= $current ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Criteria</button>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>