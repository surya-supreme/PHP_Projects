<?php
/**
 * Registration Processing Script (File-Based - No Database)
 */

session_start();
require_once 'config.php';
require_once 'functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['errors'] = ["Invalid security token. Please try again."];
    header("Location: ../index.php");
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$dob = isset($_POST['dob']) && !empty($_POST['dob']) ? $_POST['dob'] : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
$terms = isset($_POST['terms']);

$usernameValidation = validateUsername($username);
if ($usernameValidation !== true) $errors[] = $usernameValidation;

$emailValidation = validateEmail($email);
if ($emailValidation !== true) $errors[] = $emailValidation;

$passwordValidation = validatePassword($password);
if ($passwordValidation !== true) $errors[] = $passwordValidation;

if ($password !== $confirm_password) $errors[] = "Passwords do not match";

$fullNameValidation = validateFullName($full_name);
if ($fullNameValidation !== true) $errors[] = $fullNameValidation;

if (!empty($phone)) {
    $phoneValidation = validatePhone($phone);
    if ($phoneValidation !== true) $errors[] = $phoneValidation;
}

if (!empty($dob)) {
    $dobValidation = validateDOB($dob);
    if ($dobValidation !== true) $errors[] = $dobValidation;
}

if (!$terms) $errors[] = "You must accept the terms and conditions";

if (usernameExists($username)) $errors[] = "Username already exists";
if (emailExists($email)) $errors[] = "Email already registered";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: ../index.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$userData = [
    'username' => $username,
    'email' => $email,
    'password' => $hashed_password,
    'full_name' => $full_name,
    'phone' => $phone,
    'date_of_birth' => $dob,
    'gender' => $gender
];

if (addUser($userData)) {
    $_SESSION['success'] = "Registration successful! Welcome, " . htmlspecialchars($full_name) . "!";
    $_SESSION['username'] = $username;
    unset($_SESSION['form_data']);
    header("Location: ../pages/success.php");
    exit();
} else {
    $_SESSION['errors'] = ["Registration failed. Please try again."];
    $_SESSION['form_data'] = $_POST;
    header("Location: ../index.php");
    exit();
}
?>
