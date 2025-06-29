<?php
require_once '../includes/db.php';

$result = $mysqli->query("SELECT * FROM applications");
if (!$result) {
    die("Query failed: " . $mysqli->error);
}

while ($row = $result->fetch_assoc()) {
    $merit = 0;

    // Loop through questions q1 to q6
    for ($i = 1; $i <= 6; $i++) {
        $answer = $row["q$i"];
        if ($answer == 'Participate') {
            $merit += 5;
        } elseif ($answer == 'Crew') {
            $merit += 10;
        }
        // Did not participate = 0, so no addition
    }

    // Update the merit value in the database
    $id = $row['id'];
    $update = $mysqli->query("UPDATE applications SET merit = $merit WHERE id = $id");
    if (!$update) {
        echo "Failed to update merit for ID $id: " . $mysqli->error . "<br>";
    }
}
?>

