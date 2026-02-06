<?php
/**
 * Logout Script
 */

session_start();

// Remove logged in user but keep registered users
unset($_SESSION['logged_in_user']);

// Set success message
$_SESSION['success'] = "You have been logged out successfully!";

// Redirect to login page
header("Location: login.php");
exit();
?>
