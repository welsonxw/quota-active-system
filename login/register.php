<?php
require_once '../includes/db_studentlocal.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO student (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now <a href='login.php'>Login</a>";
        } else {
            $error = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration</title>
<link rel="stylesheet" href="../css/register.css">
</head>
<body>
  <div class="register-container">
    <div class="register-header">
      <img src="../assets/logo.png" alt="Logo" class="logo" />
      <h2>Student Registration</h2>
      <p>Create your student account</p>
    </div>

    <?php if (isset($error)): ?>
      <div class="error-message"><?= $error ?></div>
    <?php elseif (isset($success)): ?>
      <div class="success-message"><?= $success ?></div>
    <?php endif; ?>

    <form action="register.php" method="post" class="register-form">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" required />
        <div class="password-hint">Minimum 8 characters</div>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" required />
      </div>
      <button class="register-btn" type="submit">Register</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="login.php">Login here</a>
    </div>
  </div>
</body>
</html>
