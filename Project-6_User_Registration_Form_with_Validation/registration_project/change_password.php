<?php
/**
 * Change Password Page
 * Allows users to update their password
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config.php';
require_once 'functions.php';

$errors = [];
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($current_password)) {
        $errors[] = "Current password is required";
    }
    
    if (empty($new_password)) {
        $errors[] = "New password is required";
    } else {
        $passwordValidation = validatePassword($new_password);
        if ($passwordValidation !== true) {
            $errors[] = $passwordValidation;
        }
    }
    
    if ($new_password !== $confirm_password) {
        $errors[] = "New passwords do not match";
    }
    
    // Process if no errors
    if (empty($errors)) {
        try {
            $conn = getConnection();
            $user_id = $_SESSION['user_id'];
            
            // Get current password from database
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            
            // Verify current password
            if (password_verify($current_password, $user['password'])) {
                // Hash new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update password
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_password, $user_id);
                
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Password changed successfully!";
                    header("Location: dashboard.php");
                    exit();
                }
                
                $stmt->close();
            } else {
                $errors[] = "Current password is incorrect";
            }
            
            $conn->close();
        } catch (Exception $e) {
            $errors[] = "Error changing password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>🔒 Change Password</h2>
        <p class="subtitle">Update your account password</p>
        
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
        
        <form method="POST">
            <div class="form-group">
                <label for="current_password">
                    Current Password <span class="required">*</span>
                </label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            </div>
            
            <div class="form-group">
                <label for="new_password">
                    New Password <span class="required">*</span>
                </label>
                <input type="password" id="new_password" name="new_password" required autocomplete="new-password">
                <small>Min 8 characters with uppercase, lowercase, and number</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">
                    Confirm New Password <span class="required">*</span>
                </label>
                <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
            </div>
            
            <button type="submit" class="btn-submit">Change Password</button>
            <a href="dashboard.php" class="login-link">← Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
