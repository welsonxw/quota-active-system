<?php
// Student Application Form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application Form</title>

</head>
<body>
    <div class="form-container">
        <h1>Student Application Form</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="form-group">
                    <label>Question <?php echo $i; ?>:</label>
                    <div class="radio-options">
                        <div class="radio-option">
                            <input type="radio" id="q<?php echo $i; ?>_1" name="q<?php echo $i; ?>" value="did_not_participate" required>
                            <label for="q<?php echo $i; ?>_1">Did not participate</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="q<?php echo $i; ?>_2" name="q<?php echo $i; ?>" value="participate">
                            <label for="q<?php echo $i; ?>_2">Participate</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="q<?php echo $i; ?>_3" name="q<?php echo $i; ?>" value="crew">
                            <label for="q<?php echo $i; ?>_3">Crew</label>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
            
            <div class="form-group">
                <label for="pdf_file">Upload PDF File:</label>
                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
            </div>
            
            <button type="submit" class="submit-btn">Submit Application</button>
        </form>
    </div>
</body>
</html>