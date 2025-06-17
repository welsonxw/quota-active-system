<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';



// Card Data
$total = $conn->query("SELECT COUNT(*) as count FROM application")->fetch_assoc()['count'];
$pending = $conn->query("SELECT COUNT(*) as count FROM application WHERE status='pending'")->fetch_assoc()['count'];
$approved = $conn->query("SELECT COUNT(*) as count FROM application WHERE status='approved'")->fetch_assoc()['count'];
$rejected = $conn->query("SELECT COUNT(*) as count FROM application WHERE status='rejected'")->fetch_assoc()['count'];

// Area Chart (Monthly Trends)
$monthlyData = $conn->query("SELECT MONTH(submitted_at) AS month, COUNT(*) AS total FROM application GROUP BY MONTH(submitted_at)");
$monthLabels = [];
$monthCounts = [];
$monthNames = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
while ($row = $monthlyData->fetch_assoc()) {
    $monthLabels[] = $monthNames[(int)$row['month']];
    $monthCounts[] = $row['total'];
}

// Bar Chart (Year of Study vs Total Students)
$yearData = $conn->query("SELECT year_of_study, COUNT(*) AS total FROM application GROUP BY year_of_study");
$yearLabels = [];
$yearCounts = [];
while ($row = $yearData->fetch_assoc()) {
    $yearLabels[] = "Year " . $row['year_of_study'];
    $yearCounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Admin Dashboard</h2>

    <!-- Dashboard Cards -->
    <div class="row text-white mb-4">
        <div class="col-md-3">
            <div class="card bg-primary p-3">Total Applications: <?= $total ?> <a href="view_applications.php" class="text-white">View</a></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning p-3">Pending: <?= $pending ?> <a href="view_applications.php?status=pending" class="text-white">View</a></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success p-3">Approved: <?= $approved ?> <a href="view_applications.php?status=approved" class="text-white">View</a></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger p-3">Rejected: <?= $rejected ?> <a href="view_applications.php?status=rejected" class="text-white">View</a></div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-6">
            <h5>Monthly Application Trend</h5>
            <canvas id="areaChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5>Applications by Year of Study</h5>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Data Table Preview -->
    <div class="row mt-4">
        <div class="col-12">
            <h5>Recent Applications</h5>
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
                    <?php
                    $result = $conn->query("SELECT * FROM application ORDER BY submitted_at DESC LIMIT 5");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['matrix_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['college']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['year_of_study']) . "</td>";
                            echo "<td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>";
                            echo "<td><a href='application_detail.php?id=" . $row['id'] . "' class='btn btn-sm btn-info'>View</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No applications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="view_applications.php" class="btn btn-primary">View All Applications</a>
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
            label: 'Applications',
            data: <?= json_encode($monthCounts) ?>,
            fill: true,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
        }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});

const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($yearLabels) ?>,
        datasets: [{
            label: 'Total Students',
            data: <?= json_encode($yearCounts) ?>,
            backgroundColor: '#007bff'
        }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
</script>
</body>
</html>