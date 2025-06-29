<?php
// admin/rankings.php
require_once __DIR__ . '/../includes/db.php';

$male = $mysqli->query("SELECT s.matrix_no, s.fullname, a.student_id, a.merit, a.status, a.file_path 
                        FROM student s 
                        JOIN applications a ON s.student_id = a.student_id 
                        WHERE s.gender = 'Male' 
                        ORDER BY a.merit DESC");

$female = $mysqli->query("SELECT s.matrix_no, s.fullname, a.merit, a.status, a.file_path 
                        FROM student s 
                        JOIN applications a ON s.student_id = a.student_id 
                        WHERE s.gender = 'Female' 
                        ORDER BY a.merit DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Rankings - Quota System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Student Rankings</h2>
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-primary">Male Rankings</h4>
            <div class="table-responsive">
                <form method="POST" action="update_statuses.php">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Matric No</th>
                                <th>Name</th>
                                <th>Merit Points</th>
                                <th>Status</th>
                                <th>View Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = $male->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['merit']) ?></td>
                                    <td>
                                        <select name="status[<?= $row['student_id'] ?>]" class="form-select form-select-sm">
                                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="accepted" <?= $row['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                            <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../student/' . $row['file_path'])): ?>
                                            <a href="../student/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">View</a>
                                        <?php else: ?>
                                            No document
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($i == 1): ?>
                                <tr><td colspan="6" class="text-center">No approved male applications.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button type="submit" class="btn btn-success">Update All Statuses</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="text-primary">Female Rankings</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Matric No</th>
                            <th>Name</th>
                            <th>Merit Points</th>
                            <th>Status</th>
                            <th>View Document</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = $female->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['merit']) ?></td>
                                    <td>
                                        <select name="status[<?= $row['student_id'] ?>]" class="form-select form-select-sm">
                                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="accepted" <?= $row['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                            <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </td>
                                <td>
                                    <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../student/' . $row['file_path'])): ?>
                                        <a href="../student/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">View</a>
                                    <?php else: ?>
                                        No document
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($i == 1): ?>
                            <tr><td colspan="6" class="text-center">No approved female applications.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <form method="post" action="export_ranking.php">
            <button type="submit" class="btn btn-primary">Download CSV</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
