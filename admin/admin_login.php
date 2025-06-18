<?php
session_start();

$message = '';
$default_username = 'admin';
$default_password = 'password123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $default_username && $password === $default_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: /quota_aktif/admin/dashboard.php");

        exit;
    } else {
        $message = '<div class="alert alert-danger" role="alert">Wrong credential, please try again.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTM COLLEGE ADMINISTRATION - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d3d3d3; /* Solid grey background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        .webug-logo {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 2rem;
            color: #3498db;
            font-weight: bold;
        }
        .webug-logo::after {
            content: "🐞"; /* Bug icon as a placeholder */
            margin-left: 5px;
        }
        .btn-custom {
            background-color: #8B0000; /* Maroon color similar to UTM */
            border-color: #8B0000;
            width: 100%;
            color: #ffffff; /* Bright white text for prominence */
            font-weight: bold; /* Make it stand out */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Tumbul effect */
        }
        .btn-custom:hover {
            background-color: #700000;
            border-color: #700000;
            color: #ffffff;
        }
        .form-label {
            text-align: left;
            display: block;
        }
        .mb-3 input {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="webug-logo">Webug</div>
    <div class="login-container">
        <h2 class="mb-4">UTM COLLEGE ADMINISTRATION</h2>
        <?php if ($message): ?>
            <?= $message ?>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
<div class="input-group">
  <input type="password" class="form-control" id="password" name="password" required>
  <button class="btn btn-outline-secondary" type="button" id="togglePassword">
    👁️
  </button>
</div>
            </div>
            <button type="submit" class="btn btn-custom">Login</button>
        </form>
        <p class="text-center mt-3 text-muted">Don't have an account? <a href="#" class="text-primary">Register as Admin</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const toggleBtn = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  toggleBtn.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Optional: toggle icon if using Font Awesome
    if (eyeIcon) {
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    }
  });
</script>

</body>
</html>