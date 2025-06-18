<?php
// apply.php — handles form + file upload (you can add database logic if needed)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $responses = [];
    for ($i = 1; $i <= 5; $i++) {
        $responses["q$i"] = $_POST["q$i"] ?? '';
    }

    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['pdf_file'];
        $fileName = basename($uploadedFile['name']);
        $uploadPath = "uploads/" . $fileName;
        move_uploaded_file($uploadedFile['tmp_name'], $uploadPath);
        // echo "Uploaded to: $uploadPath";
    }

    // You can now save to DB or redirect
    // header("Location: success.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Application Form</title>
  <link rel="stylesheet" href="../css/apply.css" />
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="form-container">
  <h1>Student Application Form</h1>

  <form action="" method="post" enctype="multipart/form-data">
    <?php for ($i = 1; $i <= 5; $i++): ?>
      <div class="question-card">
        <label for="q<?= $i ?>">Question <?= $i ?>:</label>
        <div class="radio-options">
          <div class="radio-option">
            <input type="radio" id="q<?= $i ?>_1" name="q<?= $i ?>" value="did_not_participate" required>
            <label for="q<?= $i ?>_1">Did not participate</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="q<?= $i ?>_2" name="q<?= $i ?>" value="participate">
            <label for="q<?= $i ?>_2">Participate</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="q<?= $i ?>_3" name="q<?= $i ?>" value="crew">
            <label for="q<?= $i ?>_3">Crew</label>
          </div>
        </div>
      </div>
    <?php endfor; ?>

    <div class="question-card">
      <label for="pdf_file">Upload PDF File:</label>
      <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required />
    </div>

    <button type="submit" class="submit-btn">Submit Application</button>
  </form>
</div>
<?php include 'chatbot.php'; ?>
</body>
</html>
