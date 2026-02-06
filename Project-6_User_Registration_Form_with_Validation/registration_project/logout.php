<?php
/**
 * Logout Script
 * Destroys user session and redirects to home page
 */

session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login/registration page
header("Location: index.php");
exit();
?>
