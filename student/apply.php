<?php
session_start();


include '../includes/db_studentlocal.php'; // DB connection

if (!isset($_SESSION['student_id'])) {
    die("Error: Student is not logged in.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q1 = $_POST['q1'] ?? '';
    $q2 = $_POST['q2'] ?? '';
    $q3 = $_POST['q3'] ?? '';
    $q4 = $_POST['q4'] ?? '';
    $q5 = $_POST['q5'] ?? '';
    $q6 = $_POST['q6'] ?? '';

    // File upload (optional)
    $uploadPath = '';
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $uploadPath = 'uploads/' . basename($_FILES['pdf_file']['name']);
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadPath);
    }

    // Save to database
    $sql = "INSERT INTO applications (student_id, q1, q2, q3, q4, q5, q6, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

   $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isssssss", $_SESSION['student_id'], $q1, $q2, $q3, $q4, $q5, $q6, $uploadPath);

    if ($stmt->execute()) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Load questions
$questions = [];
$sql = "SELECT * FROM questions";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Application Form</title>
    <link rel="stylesheet" href="../css/apply.css"> <!-- Adjust path if needed -->
</head>
<body>
<div class="form-container">
    <h1>Student Application Form</h1>
    <form action="apply.php" method="post" enctype="multipart/form-data">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <label for="question<?= $q['question_id'] ?>">Question <?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></label>
                <div class="radio-options">
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['question_id'] ?>]" value="Did not participate" id="q<?= $q['question_id'] ?>_1">
                        <label for="q<?= $q['question_id'] ?>_1">Did not participate</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['question_id'] ?>]" value="Participate" id="q<?= $q['question_id'] ?>_2">
                        <label for="q<?= $q['question_id'] ?>_2">Participate</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['question_id'] ?>]" value="Crew" id="q<?= $q['question_id'] ?>_3">
                        <label for="q<?= $q['question_id'] ?>_3">Crew</label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="question-card">
            <label for="supporting_file">Upload PDF File:</label>
            <input type="file" name="supporting_file" accept=".pdf,.jpg,.jpeg">
        </div>

        <button type="submit" class="submit-btn">Submit Application</button>
    </form>
</div>
</body>
</html>
