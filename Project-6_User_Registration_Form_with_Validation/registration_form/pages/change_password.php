<?php
/**
 * Change Password Page
 * Allows users to change their password
 */

session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['errors'] = ['Please login to access this page'];
    header("Location: login.php");
    exit();
}

// Get user data
$user = findUser($_SESSION['email']);

// Initialize variables
$errors = [];
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $errors[] = "Invalid security token. Please try again.";
    } else {
        // Get form data
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validate current password
        if (empty($current_password)) {
            $errors[] = "Current password is required";
        } elseif (!password_verify($current_password, $user['password'])) {
            $errors[] = "Current password is incorrect";
        }
        
        // Validate new password
        $passwordValidation = validatePassword($new_password);
        if ($passwordValidation !== true) {
            $errors[] = $passwordValidation;
        }
        
        // Check if new password matches confirmation
        if ($new_password !== $confirm_password) {
            $errors[] = "New passwords do not match";
        }
        
        // Check if new password is different from current
        if (password_verify($new_password, $user['password'])) {
            $errors[] = "New password must be different from current password";
        }
        
        // If no errors, update password
        if (empty($errors)) {
            $users = getAllUsers();
            foreach ($users as &$u) {
                if ($u['id'] == $user['id']) {
                    $u['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                    break;
                }
            }
            
            if (saveUsers($users)) {
                $success = "Password changed successfully! Please use your new password for future logins.";
                // Clear form
                $_POST = [];
            } else {
                $errors[] = "Failed to change password. Please try again.";
            }
        }
    }
}

// Generate CSRF token
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - <?php echo htmlspecialchars($user['full_name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .change-password-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .page-header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        
        .page-header p {
            margin: 0;
            opacity: 0.9;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e8ed;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 13px;
        }
        
        .password-requirements ul {
            margin: 10px 0 0 0;
            padding-left: 20px;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
            color: #666;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .security-notice {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #ffc107;
            margin-top: 20px;
        }
        
        .security-notice p {
            margin: 0;
            color: #856404;
        }
        
        .toggle-password {
            position: relative;
        }
        
        .toggle-password-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
        }
        
        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <div class="page-header">
            <h1>🔒 Change Password</h1>
            <p>Update your account password</p>
        </div>
        
        <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            ✅ <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>⚠️ Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <div class="form-card">
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div class="form-group">
                    <label for="current_password">Current Password *</label>
                    <div class="toggle-password">
                        <input type="password" id="current_password" name="current_password" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('current_password')">👁️</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password *</label>
                    <div class="toggle-password">
                        <input type="password" id="new_password" name="new_password" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('new_password')">👁️</button>
                    </div>
                    
                    <div class="password-requirements">
                        <strong>Password Requirements:</strong>
                        <ul>
                            <li>At least 8 characters long</li>
                            <li>Contains at least one uppercase letter (A-Z)</li>
                            <li>Contains at least one lowercase letter (a-z)</li>
                            <li>Contains at least one number (0-9)</li>
                            <li>Must be different from current password</li>
                        </ul>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password *</label>
                    <div class="toggle-password">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('confirm_password')">👁️</button>
                    </div>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <span>🔒</span>
                        <span>Change Password</span>
                    </button>
                    
                    <a href="dashboard.php" class="btn btn-secondary">
                        <span>❌</span>
                        <span>Cancel</span>
                    </a>
                </div>
            </form>
            
            <div class="security-notice">
                <p>
                    <strong>🔒 Security Tip:</strong> Use a strong, unique password. After changing your password, 
                    you'll need to use the new password for future logins.
                </p>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
</body>
</html>
