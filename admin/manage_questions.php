<?php
require_once('../includes/db_student(localhost).php');

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
    $mysqli->query("DELETE FROM questions WHERE id = $id");
}

// Fetch all questions
$questions = $mysqli->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Questions</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f4f4f4; }
        input, select { padding: 5px; margin-top: 10px; }
        button { padding: 6px 12px; }
    </style>
</head>
<body>
    <h2>Manage Application Questions</h2>

    <form method="POST">
        <label>Question:</label><br>
        <input type="text" name="question_text" required><br>
        <label>Type:</label><br>
        <select name="question_type">
            <option value="text">Text</option>
            <option value="textarea">Textarea</option>
            <option value="number">Number</option>
            <option value="email">Email</option>
        </select><br><br>
        <button type="submit" name="add">Add Question</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php while ($q = $questions->fetch_assoc()): ?>
        <tr>
            <td><?= $q['id'] ?></td>
            <td><?= htmlspecialchars($q['question_text']) ?></td>
            <td><?= $q['question_type'] ?></td>
            <td>
                <a href="?delete=<?= $q['id'] ?>" onclick="return confirm('Delete this question?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
