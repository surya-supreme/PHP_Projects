<?php
/**
 * Logout Script
 */

session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

session_destroy();

session_start();
$_SESSION['success'] = 'You have been successfully logged out.';

header("Location: ../pages/login.php");
exit();
?>
