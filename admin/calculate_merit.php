<?php
require_once __DIR__ . '/../includes/db.php';

$result = $conn->query("SELECT * FROM applications");

while ($row = $result->fetch_assoc()) {
    $merit = 0;

    // Calculate score from q1 to q6
    for ($i = 1; $i <= 6; $i++) {
        $response = strtolower($row["q$i"]);
        switch ($response) {
            case 'participant':
                $merit += 10;
                break;
            case 'crew':
                $merit += 20;
                break;
            case 'none':
            default:
                $merit += 0;
        }
    }

    // Update merit in the database
    $stmt = $conn->prepare("UPDATE applications SET merit = ? WHERE id = ?");
    $stmt->bind_param("ii", $merit, $row['id']);
    $stmt->execute();
}

echo "✅ Merit scores updated successfully.";
?>
