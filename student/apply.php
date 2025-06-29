<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/db_studentlocal.php'; // DB connection

if (!isset($_SESSION['student_id'])) {
    die("Error: Student is not logged in.");
}

// Load questions 
$questions = [];
$sql = "SELECT * FROM questions";
$result = $mysqli->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

// Check if student already applied
$alreadyApplied = false;
$check = $mysqli->prepare("SELECT COUNT(*) FROM applications WHERE student_id = ?");
$check->bind_param("i", $_SESSION['student_id']);
$check->execute();
$check->bind_result($count);
$check->fetch();
$check->close();

if ($count > 0) {
    $alreadyApplied = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$alreadyApplied) {
    $answers = $_POST['question'] ?? [];

    $q_values = array_fill(0, 6, '');
    $i = 0;
    foreach ($answers as $qid => $ans) {
        if ($i < 6) {
            $q_values[$i] = $ans;
            $i++;
        }
    }

    // File upload (optional)
    $uploadPath = '';
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = basename($_FILES['pdf_file']['name']);
        $uploadPath = $uploadDir . time() . '_' . $filename;
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadPath);
    }

    // Save to applications table
    $sql = "INSERT INTO applications (student_id, q1, q2, q3, q4, q5, q6, file_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
        "isssssss",
        $_SESSION['student_id'],
        $q_values[0],
        $q_values[1],
        $q_values[2],
        $q_values[3],
        $q_values[4],
        $q_values[5],
        $uploadPath
    );

    if ($stmt->execute()) {
        include '../admin/calculate_merit.php';
        $_SESSION['submission_success'] = true;
        header("Location: apply.php"); // redirect to avoid resubmission
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Application Form</title>
    <link rel="stylesheet" href="../css/apply.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if (isset($_SESSION['submission_success'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Your application was submitted successfully!',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
<?php unset($_SESSION['submission_success']); ?>
<?php endif; ?>

<?php if ($alreadyApplied): ?>
<script>
    Swal.fire({
        icon: 'info',
        title: 'Already Submitted',
        text: 'You have already submitted your application. You cannot apply again.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
<?php else: ?>

<div class="form-container">
    <h1>Student Application Form</h1>
    <form action="apply.php" method="post" enctype="multipart/form-data">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <label for="question<?= $q['question_id'] ?>">Question <?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></label>
                <div class="radio-options">
                    <div class="radio-option">
                        <input type="radio" name="question[<?= $q['question_id'] ?>]" value="Did not participate" id="q<?= $q['question_id'] ?>_1" required>
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
            <input type="file" name="pdf_file" accept=".pdf,.jpg,.jpeg">
        </div>

        <button type="submit" class="submit-btn">Submit Application</button>
    </form>
</div>

<?php endif; ?>

<!-- Chatbot integration -->
<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/06/27/07/20250627072905-7RCE1TQ0.js" defer></script>
</body>
</html>
