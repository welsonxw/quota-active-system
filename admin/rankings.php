<?php
// admin/rankings.php
require_once __DIR__ . '/../includes/db.php';
$male = $conn->query("SELECT * FROM application WHERE gender='male' AND status='approved' ORDER BY merit DESC");
$female = $conn->query("SELECT * FROM application WHERE gender='female' AND status='approved' ORDER BY merit DESC");
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
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Matric No</th>
                                <th>Name</th>
                                <th>Merit Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = $male->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['merit']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($i == 1): ?>
                                <tr><td colspan="4" class="text-center">No approved male applications.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = $female->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['matrix_no']) ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['merit']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($i == 1): ?>
                                <tr><td colspan="4" class="text-center">No approved female applications.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: center; margin-top: 30px;">
    <form method="post" action="export_ranking.php">
        <button type="submit" style="padding: 10px 20px; background-color: green; color: white; border: none; border-radius: 5px;">
            Download CSV
        </button>
    </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>