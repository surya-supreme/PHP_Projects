<?php
/**
 * Login Processing Script
 * Handles user authentication and session management
 */

session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $_SESSION['errors'] = ["Invalid form submission. Please try again."];
        header("Location: login.php");
        exit();
    }
    
    // Get and sanitize form data
    $login_credential = sanitize($_POST['login_credential'] ?? '');
    $password = $_POST['login_password'] ?? '';
    $remember_me = isset($_POST['remember_me']);
    
    // Initialize errors array
    $errors = [];
    
    // Validate inputs
    if (empty($login_credential)) {
        $errors[] = "Email or username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no validation errors, proceed with login
    if (empty($errors)) {
        try {
            // Get database connection
            $conn = getConnection();
            
            // Check if connection was successful
            if (!$conn) {
                throw new Exception("Database connection failed.");
            }
            
            // Prepare SQL to find user by email or username
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1");
            $stmt->bind_param("ss", $login_credential, $login_credential);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, create session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['full_name'] = $user['full_name'];
                    
                    // Update last login time
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
                    $update_stmt->bind_param("i", $user['id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                    
                    // Set success message
                    $_SESSION['success'] = "Welcome back, " . htmlspecialchars($user['full_name']) . "!";
                    
                    // Handle remember me (optional - sets longer session)
                    if ($remember_me) {
                        // Extend session lifetime to 30 days
                        ini_set('session.gc_maxlifetime', 30 * 24 * 60 * 60);
                        session_set_cookie_params(30 * 24 * 60 * 60);
                    }
                    
                    $stmt->close();
                    $conn->close();
                    
                    // Redirect to dashboard
                    header("Location: dashboard.php");
                    exit();
                    
                } else {
                    $errors[] = "Invalid password. Please try again.";
                }
            } else {
                $errors[] = "No account found with that email or username.";
            }
            
            $stmt->close();
            $conn->close();
            
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $errors[] = "An error occurred during login. Please try again later.";
        }
    }
    
    // If there are errors, store in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
    }
    
} else {
    // If accessed directly without POST, redirect to login
    header("Location: login.php");
    exit();
}
?>
