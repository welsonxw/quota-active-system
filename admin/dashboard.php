<?php
// admin/dashboard.php
require_once __DIR__ . '/../includes/db.php';

$total = $mysqli->query("SELECT COUNT(*) as count FROM applications")->fetch_assoc()['count'];
$pending = $mysqli->query("SELECT COUNT(*) as count FROM applications WHERE status='pending'")->fetch_assoc()['count'];
$approved = $mysqli->query("SELECT COUNT(*) as count FROM applications WHERE status='approved'")->fetch_assoc()['count'];
$rejected = $mysqli->query("SELECT COUNT(*) as count FROM applications WHERE status='rejected'")->fetch_assoc()['count'];

$monthlyData = $mysqli->query("SELECT MONTH(submitted_at) AS month, COUNT(*) AS total FROM applications GROUP BY MONTH(submitted_at)");
$monthCounts = array_fill(1, 12, 0); // Initialize array with 12 months (1-12) set to 0
while ($row = $monthlyData->fetch_assoc()) {
    $monthCounts[(int)$row['month']] = $row['total'];
}
$monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

$yearData = $mysqli->query("SELECT year, COUNT(*) AS total FROM student GROUP BY year");
$yearLabels = [];
$yearCounts = [];
while ($row = $yearData->fetch_assoc()) {
    $yearLabels[] = "Year " . $row['year'];
    $yearCounts[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quota System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <h2 class="mb-4">Admin Dashboard</h2>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3">Total students: <?= $total ?></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white p-3">Pending: <?= $pending ?></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white p-3">Approved: <?= $approved ?></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white p-3">Rejected: <?= $rejected ?></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-primary">Monthly student Trend</h5>
                    <canvas id="areaChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-primary">students by Year of Study</h5>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        const areaCtx = document.getElementById('areaChart').getContext('2d');
        new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($monthLabels) ?>,
                datasets: [{
                    label: 'students',
                    data: <?= json_encode(array_values($monthCounts)) ?>,
                    borderColor: '#0057b8',
                    backgroundColor: 'rgba(0, 87, 184, 0.2)',
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    },
                    x: {
                        title: { display: true, text: 'Month' }
                    }
                }
            }
        });

        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($yearLabels) ?>,
                datasets: [{
                    label: 'Total Students',
                    data: <?= json_encode($yearCounts) ?>,
                    backgroundColor: '#0057b8'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>