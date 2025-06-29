<?php
require_once('../includes/db_studentlocal.php');

// Add new question
if (isset($_POST['add'])) {
    $text = $_POST['question_text'];
    $type = $_POST['question_type'];
    $stmt = $mysqli->prepare("INSERT INTO questions (question_text, question_type) VALUES (?, ?)");
    $stmt->bind_param("ss", $text, $type);
    $stmt->execute();
}

// Delete question
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM questions WHERE question_id = $id");
}

// Fetch all questions
$questions = $mysqli->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/custom.css" rel="stylesheet">
</head>

<?php include 'navbar.php'; ?>

<div class="container my-5 p-4 bg-white rounded shadow-sm">
    <h2 class="mb-4">Manage Application Questions</h2>

    <!-- Form to Add Question -->
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="question" class="form-label">Question:</label>
            <input type="text" name="question" id="question" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type:</label>
            <select name="type" id="type" class="form-select" required>
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>

    <!-- Display Questions Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $questions->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['question_id'] ?></td>
                        <td><?= htmlspecialchars($row['question_text']) ?></td>
                        <td><?= htmlspecialchars($row['question_type']) ?></td>
                        <td>
                            <a href="?delete=<?= $row['question_id'] ?>" class="text-danger text-decoration-none" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>