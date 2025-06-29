<?php
include '../includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=ranking_list.csv');

// Open output stream
$output = fopen("php://output", "w");

// Write column headers
fputcsv($output, ['Matrix No', 'Name', 'Gender', 'Year of Study', 'Merit', 'Status']);

// Fetch ranking data
$sql = "SELECT 
            student.matrix_no, 
            student.fullname, 
            student.gender, 
            student.year, 
            applications.merit, 
            applications.status 
        FROM student
        INNER JOIN applications ON student.student_id = applications.student_id
        ORDER BY merit DESC";

$result = mysqli_query($mysqli, $sql);
// Write each row to the CSV

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
