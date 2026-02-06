<?php
/**
 * User Registration Form (Without Database)
 * Uses session storage for demonstration
 */

session_start();

// Initialize users array in session if not exists
if (!isset($_SESSION['registered_users'])) {
    $_SESSION['registered_users'] = [];
}

// Display errors if any from previous submission
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

// Clear session errors and form data after displaying
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
unset($_SESSION['success']);

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>🔐 User Registration Form</h2>
        <p class="subtitle">Create your account to get started</p>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>✅ Success!</strong>
            <p><?php echo htmlspecialchars($success); ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>⚠️ Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; // Contains HTML for links ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form id="registrationForm" action="register.php" method="POST" novalidate>
            
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <!-- Username Field -->
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

            <!-- Email Field -->
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

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">
                    <span class="label-text">Password</span>
                    <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Create a strong password"
                        required
                        autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')" aria-label="Toggle password visibility">
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
                <span class="error" id="passwordError"></span>
                <div class="password-strength" id="passwordStrength"></div>
                <small>Min 8 characters with uppercase, lowercase, and number</small>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="confirm_password">
                    <span class="label-text">Confirm Password</span>
                    <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')" aria-label="Toggle password visibility">
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
                <span class="error" id="confirmPasswordError"></span>
            </div>

            <!-- Full Name Field -->
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

            <!-- Phone Number Field -->
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

            <!-- Date of Birth Field -->
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

            <!-- Gender Field -->
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

            <!-- Terms and Conditions -->
            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="terms" name="terms" required>
                    <span>I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a> <span class="required">*</span></span>
                </label>
                <span class="error" id="termsError"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <span>Create Account</span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <!-- Login Link -->
            <p class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
