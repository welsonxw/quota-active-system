<?php
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    foreach ($_POST['status'] as $student_id => $new_status) {
        // Skip empty values (just in case)
        if (empty($new_status)) continue;

        $stmt = $mysqli->prepare("UPDATE applications SET status = ? WHERE student_id = ?");
        $stmt->bind_param("si", $new_status, $student_id);
        $stmt->execute();
    }

    // Redirect back with success flag
    // update_statuses.php
    header("Location: rankings.php?status_updated=1");
    exit;
} else {
    // If accessed directly or no data sent
    header("Location: rankings.php");
    exit;
}
