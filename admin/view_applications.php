<?php
// view_applications.php
require_once __DIR__ . '/../includes/db.php';

// Get filter values if set
$statusFilter = $_GET['status'] ?? '';

// Build SQL with optional WHERE clause
$sql = "SELECT 
            applications.*, 
            student.matrix_no, 
            student.fullname, 
            student.year, 
            student.gender
        FROM applications 
        INNER JOIN student 
        ON applications.student_id = student.student_id";

if (!empty($statusFilter)) {
    $sql .= " WHERE applications.status = ?";
}

$stmt = $mysqli->prepare($sql);

// Bind parameters if needed
if (!empty($statusFilter)) {
    $stmt->bind_param("s", $statusFilter);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quota System - View Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
</head>
<body>

   <?php include 'navbar.php'; ?>


<div class="container mt-4">
    <h2>Student Applications</h2>
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $statusFilter == 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $statusFilter == 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Matrics No.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Year</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['gender']) ?></td>
                    <td><?= htmlspecialchars($row['year']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                    <td><a href="application_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="6">No applications found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
