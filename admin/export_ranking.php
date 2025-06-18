<?php
include '../includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=ranking_list.csv');

// Open output stream
$output = fopen("php://output", "w");

// Write column headers
fputcsv($output, ['Matrix No', 'Name', 'College', 'Year of Study', 'Merit', 'Status']);

// Fetch ranking data
$sql = "SELECT matrix_no, name, college, year_of_study, merit, status FROM application ORDER BY merit DESC";
$result = mysqli_query($conn, $sql);

// Write each row to the CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
