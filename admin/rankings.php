<?php
require_once __DIR__ . '/../includes/db.php';

$male = $mysqli->query("SELECT s.matrix_no, s.fullname, a.student_id, a.merit, a.status, a.file_path 
                        FROM student s 
                        JOIN applications a ON s.student_id = a.student_id 
                        WHERE s.gender = 'Male' 
                        ORDER BY a.merit DESC");

$female = $mysqli->query("SELECT s.matrix_no, s.fullname, a.student_id, a.merit, a.status, a.file_path 
                        FROM student s 
                        JOIN applications a ON s.student_id = a.student_id 
                        WHERE s.gender = 'Female' 
                        ORDER BY a.merit DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Rankings - Quota System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-select.pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-select.accepted {
            color: #28a745;
            font-weight: bold;
        }

        .status-select.rejected {
            color: #dc3545;
            font-weight: bold;
        }

        .btn-group-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Student Rankings</h2>

    <form method="POST" action="update_statuses.php">
        <div class="row">
            <!-- Male Rankings -->
            <div class="col-md-6">
                <h4 class="text-primary">Male Rankings</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Matric No</th>
                                <th>Name</th>
                                <th>Merit Points</th>
                                <th>Document</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        while ($row = $male->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['merit']) ?></td>
                                <td>
                                    <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../student/' . $row['file_path'])): ?>
                                        <a href="../student/<?= htmlspecialchars($row['file_path']) ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    <?php else: ?>
                                        No document
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select name="status[<?= $row['student_id'] ?>]" class="form-select form-select-sm status-select <?= $row['status'] ?>">
                                        <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="accepted" <?= $row['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                        <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($i == 1): ?>
                            <tr><td colspan="6" class="text-center">No approved male applications.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Female Rankings -->
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
                                <th>Document</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        while ($row = $female->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['merit']) ?></td>
                                <td>
                                    <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../student/' . $row['file_path'])): ?>
                                        <a href="../student/<?= htmlspecialchars($row['file_path']) ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    <?php else: ?>
                                        No document
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select name="status[<?= $row['student_id'] ?>]" class="form-select form-select-sm status-select <?= $row['status'] ?>">
                                        <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="accepted" <?= $row['status'] == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                        <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
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

        <!-- Action Buttons -->
        <div class="btn-group-actions">
            <button type="submit" class="btn btn-success">Update All Statuses</button>
            <form method="POST" action="export_ranking.php">
                <button type="submit" class="btn btn-primary">Download CSV</button>
            </form>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
