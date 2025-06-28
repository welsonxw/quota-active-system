<?php
// view_applications.php
require_once __DIR__ . '/../includes/db.php';
$sql = "SELECT 
            applications.*, 
            student.matrix_no, 
            student.fullname, 
            student.college, 
            student.year, 
            student.status 
        FROM applications 
        INNER JOIN student 
        ON applications.student_id = student.student_id";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quota System - View Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Quota System Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="view_applications.php">View Applications</a></li>
        <li class="nav-item"><a class="nav-link" href="rankings.php">Rankings</a></li>
        <li class="nav-item"><a class="nav-link" href="edit_criteria.php">Edit Criteria</a></li>
      </ul>
    </div>
  </div>
</nav>
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
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['college']) ?></td>
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
</body>
</html>
