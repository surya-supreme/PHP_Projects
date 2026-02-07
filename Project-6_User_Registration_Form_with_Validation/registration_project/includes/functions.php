<?php
/**
 * Validation and Helper Functions
 * Contains all validation logic for user input
 */

/**
 * Validate username
 * Rules: 3-20 characters, alphanumeric and underscores only
 * 
 * @param string $username Username to validate
 * @return bool|string True if valid, error message if invalid
 */
function validateUsername($username) {
    if (empty($username)) {
        return "Username is required";
    }
    
    if (strlen($username) < 3) {
        return "Username must be at least 3 characters long";
    }
    
    if (strlen($username) > 20) {
        return "Username must not exceed 20 characters";
    }
    
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return "Username can only contain letters, numbers, and underscores";
    }
    
    return true;
}

/**
 * Validate email address
 * 
 * @param string $email Email to validate
 * @return bool|string True if valid, error message if invalid
 */
function validateEmail($email) {
    if (empty($email)) {
        return "Email is required";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email address";
    }
    
    if (strlen($email) > 100) {
        return "Email address is too long";
    }
    
    return true;
}

/**
 * Validate password strength
 * Rules: Min 8 characters, must contain uppercase, lowercase, and number
 * 
 * @param string $password Password to validate
 * @return bool|string True if valid, error message if invalid
 */
function validatePassword($password) {
    if (empty($password)) {
        return "Password is required";
    }
    
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter";
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number";
    }
    
    return true;
}

/**
 * Validate full name
 * 
 * @param string $fullName Full name to validate
 * @return bool|string True if valid, error message if invalid
 */
function validateFullName($fullName) {
    if (empty($fullName)) {
        return "Full name is required";
    }
    
    if (strlen($fullName) < 2) {
        return "Full name must be at least 2 characters long";
    }
    
    if (strlen($fullName) > 100) {
        return "Full name is too long";
    }
    
    if (!preg_match('/^[a-zA-Z\s\-\.]+$/', $fullName)) {
        return "Full name can only contain letters, spaces, hyphens, and periods";
    }
    
    return true;
}

/**
 * Validate phone number (optional field)
 * Rules: 10 digits, numbers only
 * 
 * @param string $phone Phone number to validate
 * @return bool|string True if valid, error message if invalid
 */
function validatePhone($phone) {
    if (empty($phone)) {
        return true; // Phone is optional
    }
    
    // Remove any spaces, dashes, or parentheses
    $cleanPhone = preg_replace('/[\s\-\(\)]/', '', $phone);
    
    if (!preg_match('/^[0-9]{10}$/', $cleanPhone)) {
        return "Phone number must be exactly 10 digits";
    }
    
    return true;
}

/**
 * Validate date of birth
 * Rules: Must be at least 13 years old
 * 
 * @param string $dob Date of birth to validate
 * @return bool|string True if valid, error message if invalid
 */
function validateDOB($dob) {
    if (empty($dob)) {
        return true; // DOB is optional
    }
    
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    
    if ($age < 13) {
        return "You must be at least 13 years old to register";
    }
    
    if ($age > 120) {
        return "Please enter a valid date of birth";
    }
    
    return true;
}

/**
 * Generate CSRF token for form security
 * 
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize user input
 * 
 * @param string $data Data to sanitize
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Format phone number for display
 * 
 * @param string $phone Phone number
 * @return string Formatted phone number
 */
function formatPhone($phone) {
    if (empty($phone)) {
        return '';
    }
    
    $cleaned = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($cleaned) == 10) {
        return '(' . substr($cleaned, 0, 3) . ') ' . substr($cleaned, 3, 3) . '-' . substr($cleaned, 6);
    }
    
    return $phone;
}

/**
 * Calculate age from date of birth
 * 
 * @param string $dob Date of birth
 * @return int Age in years
 */
function calculateAge($dob) {
    if (empty($dob)) {
        return 0;
    }
    
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    return $today->diff($birthDate)->y;
}
?>
