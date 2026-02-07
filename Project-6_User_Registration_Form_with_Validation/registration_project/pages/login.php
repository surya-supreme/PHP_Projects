<?php
/**
 * Login Page
 * Allows registered users to login to their account
 */

session_start();
require_once '../includes/functions.php';

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
    <link rel="stylesheet" href="../assets/css/style.css">
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
        
        <form action="../includes/process_login.php" method="POST">
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
                <input 
                    type="password" 
                    id="login_password" 
                    name="login_password" 
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password">
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
                Don't have an account? <a href="../index.php">Register here</a>
            </p>
        </form>
    </div>
</body>
</html>
