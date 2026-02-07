<?php
session_start();
require_once 'includes/functions.php';

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : [];
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

unset($_SESSION['errors']);
unset($_SESSION['success']);
unset($_SESSION['form_data']);

$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Sign Up</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>🔐 User Registration Form</h2>
        <p class="subtitle">Create your account to get started</p>
        
        <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <strong>✅ Success!</strong>
            <ul>
                <?php foreach ($success as $message): ?>
                    <li><?php echo htmlspecialchars($message); ?></li>
                <?php endforeach; ?>
            </ul>
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
        
        <form id="registrationForm" action="includes/register.php" method="POST" novalidate>
            
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="username">
                    <span class="label-text">Username</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo isset($form_data['username']) ? htmlspecialchars($form_data['username']) : ''; ?>" 
                    placeholder="Choose a unique username"
                    required
                    autocomplete="username">
                <span class="error" id="usernameError"></span>
                <small>3-20 characters, letters, numbers, and underscores only</small>
            </div>

            <div class="form-group">
                <label for="email">
                    <span class="label-text">Email Address</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>" 
                    placeholder="your.email@example.com"
                    required
                    autocomplete="email">
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="password">
                    <span class="label-text">Password</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Create a strong password"
                    required
                    autocomplete="new-password">
                <span class="error" id="passwordError"></span>
                <div class="password-strength" id="passwordStrength"></div>
                <small>Min 8 characters with uppercase, lowercase, and number</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">
                    <span class="label-text">Confirm Password</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    placeholder="Re-enter your password"
                    required
                    autocomplete="new-password">
                <span class="error" id="confirmPasswordError"></span>
            </div>

            <div class="form-group">
                <label for="full_name">
                    <span class="label-text">Full Name</span>
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    value="<?php echo isset($form_data['full_name']) ? htmlspecialchars($form_data['full_name']) : ''; ?>" 
                    placeholder="Enter your full name"
                    required
                    autocomplete="name">
                <span class="error" id="fullNameError"></span>
            </div>

            <div class="form-group">
                <label for="phone">
                    <span class="label-text">Phone Number</span>
                    <span class="optional">(Optional)</span>
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="<?php echo isset($form_data['phone']) ? htmlspecialchars($form_data['phone']) : ''; ?>" 
                    placeholder="10 digit phone number"
                    autocomplete="tel">
                <span class="error" id="phoneError"></span>
            </div>

            <div class="form-group">
                <label for="dob">
                    <span class="label-text">Date of Birth</span>
                    <span class="optional">(Optional)</span>
                </label>
                <input 
                    type="date" 
                    id="dob" 
                    name="dob" 
                    value="<?php echo isset($form_data['dob']) ? htmlspecialchars($form_data['dob']) : ''; ?>"
                    max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>">
                <span class="error" id="dobError"></span>
                <small>You must be at least 13 years old</small>
            </div>

            <div class="form-group">
                <label>
                    <span class="label-text">Gender</span>
                    <span class="optional">(Optional)</span>
                </label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="Male" 
                            <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Male') ? 'checked' : ''; ?>>
                        <span>Male</span>
                    </label>
                    <label class="radio-label">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="Female" 
                            <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Female') ? 'checked' : ''; ?>>
                        <span>Female</span>
                    </label>
                    <label class="radio-label">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="Other" 
                            <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Other') ? 'checked' : ''; ?>>
                        <span>Other</span>
                    </label>
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="terms" name="terms" required>
                    <span>
                        I agree to the <a href="pages/terms.php" target="_blank">Terms and Conditions</a> and <a href="pages/privacy.php" target="_blank">Privacy Policy</a>
                        <span class="required">*</span>
                    </span>
                </label>
                <span class="error" id="termsError"></span>
            </div>

            <button type="submit" class="btn-submit">
                <span>Create Account</span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <p class="login-link">
                Already have an account? <a href="pages/login.php">Login here</a>
            </p>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
