<?php
/**
 * Validation and Helper Functions
 * Contains all validation logic and utility functions
 */

/**
 * Sanitize input data
 * Removes whitespace, slashes, and converts special characters
 * 
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate username
 * Requirements: 3-20 characters, alphanumeric and underscore only
 * 
 * @param string $username Username to validate
 * @return mixed True if valid, error message if invalid
 */
function validateUsername($username) {
    $username = sanitize($username);
    
    if (empty($username)) {
        return "Username is required";
    }
    
    if (strlen($username) < 3 || strlen($username) > 20) {
        return "Username must be between 3 and 20 characters";
    }
    
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        return "Username can only contain letters, numbers, and underscores";
    }
    
    return true;
}

/**
 * Validate email address
 * Uses PHP's built-in email validation filter
 * 
 * @param string $email Email to validate
 * @return mixed True if valid, error message if invalid
 */
function validateEmail($email) {
    $email = sanitize($email);
    
    if (empty($email)) {
        return "Email is required";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }
    
    return true;
}

/**
 * Validate password
 * Requirements: At least 8 characters, 1 uppercase, 1 lowercase, 1 number
 * 
 * @param string $password Password to validate
 * @return mixed True if valid, error message if invalid
 */
function validatePassword($password) {
    if (empty($password)) {
        return "Password is required";
    }
    
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long";
    }
    
    if (!preg_match("/[A-Z]/", $password)) {
        return "Password must contain at least one uppercase letter";
    }
    
    if (!preg_match("/[a-z]/", $password)) {
        return "Password must contain at least one lowercase letter";
    }
    
    if (!preg_match("/[0-9]/", $password)) {
        return "Password must contain at least one number";
    }
    
    return true;
}

/**
 * Validate phone number
 * Optional field - if provided, must be 10 digits
 * 
 * @param string $phone Phone number to validate
 * @return mixed True if valid, error message if invalid
 */
function validatePhone($phone) {
    if (empty($phone)) {
        return true; // Phone is optional
    }
    
    $phone = sanitize($phone);
    
    // Remove spaces, dashes, parentheses
    $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
    
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        return "Phone number must be 10 digits";
    }
    
    return true;
}

/**
 * Validate full name
 * Requirements: At least 3 characters, letters and spaces only
 * 
 * @param string $name Full name to validate
 * @return mixed True if valid, error message if invalid
 */
function validateFullName($name) {
    $name = sanitize($name);
    
    if (empty($name)) {
        return "Full name is required";
    }
    
    if (strlen($name) < 3) {
        return "Full name must be at least 3 characters";
    }
    
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        return "Full name can only contain letters and spaces";
    }
    
    return true;
}

/**
 * Validate date of birth
 * Checks if user is at least 13 years old
 * 
 * @param string $dob Date of birth
 * @return mixed True if valid, error message if invalid
 */
function validateDOB($dob) {
    if (empty($dob)) {
        return true; // DOB is optional
    }
    
    $today = new DateTime();
    $birthDate = new DateTime($dob);
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
 * Check if username exists in database
 * 
 * @param string $username Username to check
 * @param mysqli $conn Database connection
 * @return bool True if exists, false otherwise
 */
function usernameExists($username, $conn) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Check if email exists in database
 * 
 * @param string $email Email to check
 * @param mysqli $conn Database connection
 * @return bool True if exists, false otherwise
 */
function emailExists($email, $conn) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
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
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Log user activity
 * 
 * @param int $user_id User ID
 * @param string $action Action performed
 * @param mysqli $conn Database connection
 */
function logActivity($user_id, $action, $conn) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("INSERT INTO activity_log (user_id, action, ip_address) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $action, $ip_address);
    $stmt->execute();
    $stmt->close();
}
?>
