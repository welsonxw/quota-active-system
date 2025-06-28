<?php
include '../includes/db_studentlocal.php'; // if the file is in an "includes" folder one level up

$questions = [];
$sql = "SELECT * FROM questions";
$result = $conn->query($sql);
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
                <label for="question<?= $q['id'] ?>">Question <?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></label>
                <div class="radio-options">
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['id'] ?>]" value="Did not participate" id="q<?= $q['id'] ?>_1">
                        <label for="q<?= $q['id'] ?>_1">Did not participate</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['id'] ?>]" value="Participate" id="q<?= $q['id'] ?>_2">
                        <label for="q<?= $q['id'] ?>_2">Participate</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['id'] ?>]" value="Crew" id="q<?= $q['id'] ?>_3">
                        <label for="q<?= $q['id'] ?>_3">Crew</label>
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
