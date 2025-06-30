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
    <link href="../css/custom.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
                                    <tr>
                                        <td colspan="6" class="text-center">No approved male applications.</td>
                                    </tr>
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
                                    <tr>
                                        <td colspan="6" class="text-center">No approved female applications.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group-actions">
                <button type="submit" class="btn btn-success">Update All Status</button>
                <form method="POST" action="export_ranking.php">
                    <button type="submit" class="btn btn-primary">Download CSV</button>
                </form>
            </div>
        </form>
    </div>

    <script>
        // Function to update class based on dropdown value
        function updateStatusClass(selectEl) {
            selectEl.classList.remove('pending', 'accepted', 'rejected');
            const value = selectEl.value;
            selectEl.classList.add(value);
        }

        // On page load, set initial classes
        document.querySelectorAll('.status-select').forEach(select => {
            updateStatusClass(select);
            select.addEventListener('change', () => updateStatusClass(select));
        });
    </script>

    <?php if (isset($_GET['status_updated']) && $_GET['status_updated'] == 1): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated',
                    text: 'All statuses have been successfully updated!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    <?php endif; ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>