<?php
/**
 * Login Page
 * Allows registered users to login to their account
 */

session_start();
require_once 'functions.php';

// Display any messages from registration
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

// Display errors if any
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// Generate CSRF token
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>🔑 Login to Your Account</h2>
        <p class="subtitle">Welcome back! Please login to continue</p>
        
        <?php if ($success_message): ?>
        <div class="alert" style="background-color: #d4edda; border-color: #c3e6cb; border-left: 4px solid #28a745;">
            <strong style="color: #155724;">✅ Success!</strong>
            <p style="color: #155724; margin: 5px 0 0 0;"><?php echo htmlspecialchars($success_message); ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>⚠️ Login Failed:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form action="process_login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="login_credential">
                    <span class="label-text">Email or Username</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="login_credential" 
                    name="login_credential" 
                    placeholder="Enter your email or username"
                    required
                    autocomplete="username">
            </div>
            
            <div class="form-group">
                <label for="login_password">
                    <span class="label-text">Password</span>
                    <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input 
                        type="password" 
                        id="login_password" 
                        name="login_password" 
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password">
                    <button type="button" class="toggle-password" onclick="togglePasswordLogin('login_password')" aria-label="Toggle password visibility">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                <label class="checkbox-label" style="margin: 0;">
                    <input type="checkbox" name="remember_me">
                    <span>Remember me</span>
                </label>
                <a href="forgot_password.php" style="color: #667eea; text-decoration: none; font-size: 14px;">Forgot Password?</a>
            </div>
            
            <button type="submit" class="btn-submit">
                <span>Login</span>
            </button>
            
            <p class="login-link">
                Don't have an account? <a href="index.php">Register here</a>
            </p>
        </form>
    </div>
    
    <script>
        // Toggle password visibility for login
        function togglePasswordLogin(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const button = passwordInput.nextElementSibling;
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
    </script>
</body>
</html>
