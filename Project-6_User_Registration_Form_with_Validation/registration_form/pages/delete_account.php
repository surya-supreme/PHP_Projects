<?php
/**
 * Delete Account Handler
 * Permanently deletes user account from the system
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
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

// Process deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $_SESSION['errors'] = ['Invalid security token. Please try again.'];
        header("Location: dashboard.php");
        exit();
    }
    
    // Verify password confirmation
    $password = $_POST['password'] ?? '';
    $user = findUser($email);
    
    if (empty($password)) {
        $_SESSION['errors'] = ['Password is required to delete your account'];
        header("Location: dashboard.php");
        exit();
    }
    
    if (!password_verify($password, $user['password'])) {
        $_SESSION['errors'] = ['Incorrect password. Account deletion cancelled.'];
        header("Location: dashboard.php");
        exit();
    }
    
    // Delete user from the system
    $users = getAllUsers();
    $updatedUsers = [];
    
    foreach ($users as $u) {
        if ($u['id'] != $user_id) {
            $updatedUsers[] = $u;
        }
    }
    
    if (saveUsers($updatedUsers)) {
        // Destroy session
        session_destroy();
        
        // Redirect to index with success message
        session_start();
        $_SESSION['success'] = ['Your account has been permanently deleted. We\'re sorry to see you go!'];
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['errors'] = ['Failed to delete account. Please try again or contact support.'];
        header("Location: dashboard.php");
        exit();
    }
} else {
    // If not POST request, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}
?>
