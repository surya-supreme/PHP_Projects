<?php
/**
 * Login Processing Script (File-Based - No Database)
 */

session_start();
require_once 'config.php';
require_once 'functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/login.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $errors[] = "Invalid security token. Please try again.";
    $_SESSION['errors'] = $errors;
    header("Location: ../pages/login.php");
    exit();
}

$login_credential = trim($_POST['login_credential'] ?? '');
$password = $_POST['login_password'] ?? '';
$remember_me = isset($_POST['remember_me']);

if (empty($login_credential)) $errors[] = "Please enter your email or username";
if (empty($password)) $errors[] = "Please enter your password";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../pages/login.php");
    exit();
}

$user = findUser($login_credential);

if (!$user) {
    $errors[] = "Invalid email/username or password";
    $_SESSION['errors'] = $errors;
    header("Location: ../pages/login.php");
    exit();
}

if (!password_verify($password, $user['password'])) {
    $errors[] = "Invalid email/username or password";
    $_SESSION['errors'] = $errors;
    header("Location: ../pages/login.php");
    exit();
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['logged_in'] = true;
$_SESSION['login_time'] = time();

$_SESSION['user_data'] = [
    'phone' => $user['phone'],
    'dob' => $user['date_of_birth'],
    'gender' => $user['gender'],
    'created_at' => $user['created_at']
];

if ($remember_me) {
    setcookie('remember_user', $user['username'], time() + (86400 * 30), '/');
}

updateLastLogin($user['id']);

header("Location: ../pages/dashboard.php");
exit();
?>
