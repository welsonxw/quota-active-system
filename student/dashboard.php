<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';

checkStudent();

$userId = $_SESSION['user_id'];

// Fetch student info
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$userId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch application status
$stmt2 = $conn->prepare("SELECT status, college FROM applications WHERE user_id = ?");
$stmt2->execute([$userId]);
$application = $stmt2->fetch(PDO::FETCH_ASSOC);

// Fetch application criteria
$criteriaStmt = $conn->query("SELECT * FROM criteria");
$criteria = $criteriaStmt->fetchAll(PDO::FETCH_ASSOC);

// List of colleges
$colleges = ['KTC', 'KTDI', 'KRP', 'K9K10'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($student['name']) ?>!</h2>

    <div class="grid-container">
        <!-- Left: Information -->
        <div class="info-section">
            <h3>📋 Application Criteria</h3>
            <ul>
                <?php foreach ($criteria as $c): ?>
                    <li><?= htmlspecialchars($c['description']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Top Right: Choose College -->
        <div class="college-section">
            <h3>🎓 Choose College</h3>
            <form action="apply.php" method="get">
                <div class="college-buttons">
                    <?php foreach ($colleges as $college): ?>
                        <button name="college" value="<?= $college ?>"><?= $college ?></button>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>

        <!-- Bottom Right: Application Status -->
        <div class="status-section">
            <h3>📊 Application Status</h3>
            <?php if ($application): ?>
                <p>Status: <strong><?= htmlspecialchars($application['status']) ?></strong></p>
                <p>College Applied: <?= htmlspecialchars($application['college']) ?></p>
            <?php else: ?>
                <p>You haven't submitted an application yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
