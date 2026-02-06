<?php
/**
 * Login Processing Script (Without Database)
 * Validates credentials against session stored users
 */

session_start();

// Initialize users array if not exists
if (!isset($_SESSION['registered_users'])) {
    $_SESSION['registered_users'] = [];
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors'] = ["Invalid form submission. Please try again."];
        header("Location: login.php");
        exit();
    }
    
    // Initialize errors array
    $errors = [];
    
    // Get form data
    $credential = trim($_POST['login_credential'] ?? '');
    $password = $_POST['login_password'] ?? '';
    
    // Validate inputs
    if (empty($credential)) {
        $errors[] = "Please enter your email or username";
    }
    
    if (empty($password)) {
        $errors[] = "Please enter your password";
    }
    
    // If validation passed, check credentials
    if (empty($errors)) {
        
        $user_found = false;
        $authenticated = false;
        
        // Search for user in session
        foreach ($_SESSION['registered_users'] as $user) {
            // Check if credential matches username or email
            if (strtolower($user['username']) === strtolower($credential) || 
                strtolower($user['email']) === strtolower($credential)) {
                
                $user_found = true;
                
                // Verify password
                if (password_verify($password, $user['password'])) {
                    $authenticated = true;
                    
                    // Set logged in user session
                    $_SESSION['logged_in_user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'full_name' => $user['full_name']
                    ];
                    
                    // Set success message
                    $_SESSION['success'] = "Welcome back, " . htmlspecialchars($user['username']) . "!";
                    
                    // Redirect to dashboard
                    header("Location: dashboard.php");
                    exit();
                }
                break;
            }
        }
        
        // If user not found or password incorrect
        if (!$user_found) {
            $errors[] = "No account found with this email or username. Please <a href='index.php' style='color: #667eea; font-weight: bold;'>register here</a>.";
        } elseif (!$authenticated) {
            $errors[] = "Incorrect password. Please try again.";
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
