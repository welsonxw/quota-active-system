<?php
require_once 'includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? 'admin-dashboard.php' : 'student-dashboard.php'));
    exit();
}

$errors = [];
$success = false;
$formData = [
    'full_name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $formData = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? ''
    ];

    // Validate inputs
    if (empty($formData['full_name'])) {
        $errors['full_name'] = 'Full name is required';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($formData['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }

    if ($formData['password'] !== $formData['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // If no errors, process registration
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Check if email already exists
        // 2. Hash the password
        // 3. Save to database
        // 4. Send confirmation email
        
        // For demo purposes, we'll just show success message
        $success = true;
        
        // Clear form
        $formData = [
            'full_name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => ''
        ];
    }
}

$pageTitle = 'Student Registration';
$cssFile = 'register.css';
require_once 'includes/header.php';
?>

<img src="assets/images/logo.png" alt="School Logo" class="logo">

<div class="register-container">
    <div class="register-header">
        
        <h2>Student Registration</h2>
        <p>Create your student account</p>
    </div>
    
    <?php if ($success): ?>
        <div class="success-message">
            <p>Registration successful! You can now <a href="login.php">login</a>.</p>
        </div>
    <?php else: ?>
        <form method="POST" action="register.php" class="register-form">
            <div class="form-group <?php echo isset($errors['full_name']) ? 'has-error' : ''; ?>">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" 
                       value="<?php echo htmlspecialchars($formData['full_name']); ?>" required>
                <?php if (isset($errors['full_name'])): ?>
                    <span class="error-text"><?php echo $errors['full_name']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group <?php echo isset($errors['email']) ? 'has-error' : ''; ?>">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($formData['email']); ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-text"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group <?php echo isset($errors['password']) ? 'has-error' : ''; ?>">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
                <div class="password-hint">Minimum 8 characters</div>
            </div>
            
            <div class="form-group <?php echo isset($errors['confirm_password']) ? 'has-error' : ''; ?>">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="error-text"><?php echo $errors['confirm_password']; ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="register-btn">Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>