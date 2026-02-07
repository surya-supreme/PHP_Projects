<?php
/**
 * Configuration File (File-Based Storage - No Database Required)
 * Uses JSON files to store user data
 */

// Define data directory for storing user files
define('DATA_DIR', __DIR__ . '/../data/');

// Create data directory if it doesn't exist
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0777, true);
}

// Define user data file
define('USERS_FILE', DATA_DIR . 'users.json');

// Create users file if it doesn't exist
if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode([]));
}

/**
 * Get all users from file
 */
function getAllUsers() {
    $data = file_get_contents(USERS_FILE);
    return json_decode($data, true) ?: [];
}

/**
 * Save users to file
 */
function saveUsers($users) {
    return file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

/**
 * Find user by email or username
 */
function findUser($credential) {
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['email'] === $credential || $user['username'] === $credential) {
            return $user;
        }
    }
    return null;
}

/**
 * Check if username exists
 */
function usernameExists($username) {
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return true;
        }
    }
    return false;
}

/**
 * Check if email exists
 */
function emailExists($email) {
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }
    return false;
}

/**
 * Add new user
 */
function addUser($userData) {
    $users = getAllUsers();
    $userData['id'] = count($users) + 1;
    $userData['created_at'] = date('Y-m-d H:i:s');
    $userData['last_login'] = null;
    $users[] = $userData;
    return saveUsers($users);
}

/**
 * Update user's last login
 */
function updateLastLogin($userId) {
    $users = getAllUsers();
    foreach ($users as &$user) {
        if ($user['id'] == $userId) {
            $user['last_login'] = date('Y-m-d H:i:s');
            break;
        }
    }
    return saveUsers($users);
}

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('Asia/Kolkata');
?>
