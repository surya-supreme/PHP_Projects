<?php
/**
 * Registration Processing Script
 * Handles form submission, validation, and database insertion
 */

session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $_SESSION['errors'] = ["Invalid form submission. Please try again."];
        header("Location: index.php");
        exit();
    }
    
    // Initialize errors array
    $errors = [];
    
    // Get and sanitize form data
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = sanitize($_POST['full_name'] ?? '');
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $dob = isset($_POST['dob']) && !empty($_POST['dob']) ? $_POST['dob'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $terms = isset($_POST['terms']) ? true : false;
    
    // Validate username
    $usernameValidation = validateUsername($username);
    if ($usernameValidation !== true) {
        $errors[] = $usernameValidation;
    }
    
    // Validate email
    $emailValidation = validateEmail($email);
    if ($emailValidation !== true) {
        $errors[] = $emailValidation;
    }
    
    // Validate password
    $passwordValidation = validatePassword($password);
    if ($passwordValidation !== true) {
        $errors[] = $passwordValidation;
    }
    
    // Check password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Validate full name
    $nameValidation = validateFullName($full_name);
    if ($nameValidation !== true) {
        $errors[] = $nameValidation;
    }
    
    // Validate phone if provided
    if (!empty($phone)) {
        $phoneValidation = validatePhone($phone);
        if ($phoneValidation !== true) {
            $errors[] = $phoneValidation;
        }
    }
    
    // Validate date of birth if provided
    if (!empty($dob)) {
        $dobValidation = validateDOB($dob);
        if ($dobValidation !== true) {
            $errors[] = $dobValidation;
        }
    }
    
    // Validate gender if provided
    if (!empty($gender) && !in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = "Invalid gender selection";
    }
    
    // Validate terms acceptance
    if (!$terms) {
        $errors[] = "You must agree to the Terms and Conditions";
    }
    
    // If no validation errors, check database for duplicates
    if (empty($errors)) {
        try {
            // Get database connection
            $conn = getConnection();
            
            // Check if connection was successful
            if (!$conn) {
                throw new Exception("Database connection failed. Please check your database configuration.");
            }
            
            // Check if username already exists
            if (usernameExists($username, $conn)) {
                $errors[] = "Username already taken. Please choose another.";
            }
            
            // Check if email already exists
            if (emailExists($email, $conn)) {
                $errors[] = "Email already registered. Please use another or login.";
            }
            
            // If still no errors, proceed with registration
            if (empty($errors)) {
                
                // Hash the password using bcrypt
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Prepare SQL statement to prevent SQL injection
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone, date_of_birth, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                if ($stmt === false) {
                    throw new Exception("Failed to prepare statement. Please ensure the database table exists.");
                }
                
                // Bind parameters
                $stmt->bind_param("sssssss", $username, $email, $hashed_password, $full_name, $phone, $dob, $gender);
                
                // Execute the statement
                if ($stmt->execute()) {
                    // Registration successful
                    $user_id = $stmt->insert_id;
                    
                    // Store success message and user info in session
                    $_SESSION['success'] = "Registration successful! Welcome aboard, " . htmlspecialchars($username) . "!";
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user_id;
                    
                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                    
                    // Redirect to success page
                    header("Location: success.php");
                    exit();
                    
                } else {
                    // Registration failed
                    $errors[] = "Registration failed: " . $stmt->error;
                    $stmt->close();
                }
            }
            
            // Close connection
            if ($conn) {
                $conn->close();
            }
            
        } catch (Exception $e) {
            // Log error and show generic message to user
            error_log("Registration error: " . $e->getMessage());
            $errors[] = "An error occurred during registration: " . $e->getMessage();
            $errors[] = "Please ensure the database is properly configured and the table exists.";
        }
    }
    
    // If there are errors, store in session and redirect back to form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: index.php");
        exit();
    }
    
} else {
    // If accessed directly without POST, redirect to form
    header("Location: index.php");
    exit();
}
?>
