<?php
require_once('../includes/db_studentlocal.php');

// Add new question
$added = false;
if (isset($_POST['question'])) {
    $text = $_POST['question'];
    $stmt = $mysqli->prepare("INSERT INTO questions (question_text) VALUES (?)");
    $stmt->bind_param("s", $text);
    if ($stmt->execute()) {
        $added = true;
    }
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php include 'navbar.php'; ?>

<body>
    <div class="container my-5 p-4 bg-white rounded shadow-sm">
        <h2 class="mb-4">Manage Application Questions</h2>

        <!-- Form to Add Question -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="question" class="form-label">Question:</label>
                <input type="text" name="question" id="question" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Question</button>
        </form>

        <!-- Display Questions Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Question</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php while ($row = $questions->fetch_assoc()): ?>
                        <tr>
                            <td><?= $index++ ?></td>
                            <td><?= htmlspecialchars($row['question_text']) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $row['question_id'] ?>)">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- pop up delete                     -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This question will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?delete=' + id;
                }
            });
        }
        // pop up success
        <?php if ($added): ?>
        Swal.fire({
            title: 'Success!',
            text: 'New question added.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        <?php endif; ?>
    </script>
</body>
</html>
