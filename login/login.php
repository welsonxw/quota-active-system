<?php
session_start();
require_once '../includes/db_studentlocal.php';

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $loginError = "Please fill in all fields.";
    } else {
        // Fetch from student table
        $sql = "SELECT * FROM student WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['student_name'] = $user['fullname'];
                header("Location: ../student/dashboard.php");
                exit;
            } else {
                $loginError = "Incorrect password.";
            }
        } else {
            $loginError = "No account found with that email.";
        }

        $stmt->close();
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Quota Active System</h2>
            <div class="toggle-buttons">
                <button class="active">Student</button>
                <a href="../admin/admin_login.php"><button>Admin</button></a>
            </div>

            <?php if (!empty($loginError)) : ?>
                <p class="error"><?= htmlspecialchars($loginError) ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register as student</a></p>
        </div>
    </div>
</body>
</html>
