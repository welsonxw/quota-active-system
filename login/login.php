<?php
require_once('../includes/auth.php');

if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: admin-dashboard.php");
    } else {
        header("Location: student-dashboard.php");
    }
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $userType = $_POST['user_type'] ?? 'student';

    if (!empty($email) && !empty($password)) {
        if (authenticateUser($email, $password, $userType)) {
            if ($userType === 'admin') {
                header("Location: admin-dashboard.php");
            } else {
                header("Location: student-dashboard.php");
            }
            exit();
        } else {
            $error = 'Invalid credentials. Please try again.';
        }
    } else {
        $error = 'Please enter both email and password.';
    }
}

$pageTitle = 'School Portal - Login';
$cssFile = 'login.css';
require_once '../includes/header.php';
?>

<img src="../assets/logo.png" alt="School Logo" class="logo">

<div class="login-container">
    <div class="login-header">
       
		 
		
        <h2>Quota Active System</h2>
    </div>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <div class="user-type-selector">
            <button type="button" id="studentBtn" class="user-type-btn active">Student</button>
            <button type="button" id="adminBtn" class="user-type-btn">Admin</button>
            <input type="hidden" name="user_type" id="userType" value="student">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="login-btn">Login</button>
    </form>
    
    <div class="register-link" id="registerLink">
        Don't have an account? <a href="register.php">Register as student</a>
    </div>
</div>

<script>
    // User type selection
    const studentBtn = document.getElementById('studentBtn');
    const adminBtn = document.getElementById('adminBtn');
    const userTypeInput = document.getElementById('userType');
    const registerLink = document.getElementById('registerLink');
    
    studentBtn.addEventListener('click', function() {
        studentBtn.classList.add('active');
        adminBtn.classList.remove('active');
        userTypeInput.value = 'student';
        registerLink.innerHTML = 'Don\'t have an account? <a href="register.php">Register as student</a>';
    });
    
    adminBtn.addEventListener('click', function() {
        adminBtn.classList.add('active');
        studentBtn.classList.remove('active');
        userTypeInput.value = 'admin';
        registerLink.innerHTML = 'Need admin access? <a href="mailto:admin@school.edu">Contact administrator</a>';
    });
</script>

<?php require_once '../includes/footer.php'; ?>