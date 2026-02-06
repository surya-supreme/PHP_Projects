<?php
/**
 * Registration Processing Script (Without Database)
 * Uses PHP sessions to store user data for demonstration
 */

session_start();

// Initialize users array in session if not exists
if (!isset($_SESSION['registered_users'])) {
    $_SESSION['registered_users'] = [];
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors'] = ["Invalid form submission. Please try again."];
        header("Location: index.php");
        exit();
    }
    
    // Initialize errors array
    $errors = [];
    
    // Get and sanitize form data
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $dob = isset($_POST['dob']) && !empty($_POST['dob']) ? $_POST['dob'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $terms = isset($_POST['terms']) ? true : false;
    
    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $errors[] = "Username must be 3-20 characters long";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores";
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    
    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required";
    } else {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
    }
    
    // Check password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Validate full name
    if (empty($full_name)) {
        $errors[] = "Full name is required";
    } elseif (strlen($full_name) < 3) {
        $errors[] = "Full name must be at least 3 characters long";
    } elseif (!preg_match('/^[a-zA-Z ]+$/', $full_name)) {
        $errors[] = "Full name can only contain letters and spaces";
    }
    
    // Validate phone if provided
    if (!empty($phone)) {
        $clean_phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        if (!preg_match('/^[0-9]{10}$/', $clean_phone)) {
            $errors[] = "Phone number must be 10 digits";
        }
    }
    
    // Validate date of birth if provided
    if (!empty($dob)) {
        $birth_date = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birth_date)->y;
        
        if ($age < 13) {
            $errors[] = "You must be at least 13 years old to register";
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
    
    // If no validation errors, check for duplicates in session
    if (empty($errors)) {
        
        // Check if username already exists
        foreach ($_SESSION['registered_users'] as $user) {
            if (strtolower($user['username']) === strtolower($username)) {
                $errors[] = "This username is already registered. Please choose a different username or <a href='login.php' style='color: #667eea; font-weight: bold;'>login here</a>.";
                break;
            }
        }
        
        // Check if email already exists
        if (empty($errors)) {
            foreach ($_SESSION['registered_users'] as $user) {
                if (strtolower($user['email']) === strtolower($email)) {
                    $errors[] = "This email address is already registered. Please <a href='login.php' style='color: #667eea; font-weight: bold;'>login to your account</a> or use a different email.";
                    break;
                }
            }
        }
        
        // If still no errors, proceed with registration
        if (empty($errors)) {
            
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Create user data array
            $user_data = [
                'id' => count($_SESSION['registered_users']) + 1,
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password,
                'full_name' => $full_name,
                'phone' => $phone,
                'dob' => $dob,
                'gender' => $gender,
                'registered_at' => date('Y-m-d H:i:s')
            ];
            
            // Add user to session
            $_SESSION['registered_users'][] = $user_data;
            
            // Set logged in user
            $_SESSION['logged_in_user'] = [
                'id' => $user_data['id'],
                'username' => $username,
                'email' => $email,
                'full_name' => $full_name
            ];
            
            // Store success message
            $_SESSION['success'] = "Registration successful! Welcome aboard, " . htmlspecialchars($username) . "!";
            
            // Redirect to success page
            header("Location: success.php");
            exit();
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
