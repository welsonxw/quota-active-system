<?php
include __DIR__ . '/includes/auth.php';
include __DIR__ . '/includes/db.php';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$kolejFilter = isset($_GET['kolej']) ? $_GET['kolej'] : '';

$sql = "SELECT * FROM applications WHERE 1=1";
$params = [];
if ($statusFilter) {
    $sql .= " AND status = ?";
    $params[] = $statusFilter;
}
if ($kolejFilter) {
    $sql .= " AND college = ?";
    $params[] = $kolejFilter;
}
$sql .= " ORDER BY submitted_at DESC";
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Student Applications</h2>
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $statusFilter == 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $statusFilter == 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="kolej" class="form-select">
                <option value="">All Kolej</option>
                <?php for ($i = 1; $i <= 10; $i++): $k = "Kolej $i"; ?>
                    <option value="<?= $k ?>" <?= $kolejFilter == $k ? 'selected' : '' ?>><?= $k ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Matrix No</th>
                <th>Name</th>
                <th>Kolej</th>
                <th>Year</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['college']) ?></td>
                    <td><?= htmlspecialchars($row['year_of_study']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                    <td><a href="application_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="6">No applications found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>