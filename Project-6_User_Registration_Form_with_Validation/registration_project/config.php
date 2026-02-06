<?php
/**
 * Database Configuration File
 * Contains database connection settings and helper functions
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'registration_db');

/**
 * Create and return database connection
 * @return mysqli Database connection object
 */
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8
    $conn->set_charset("utf8");
    
    return $conn;
}

// Set error reporting for development
// In production, set display_errors to 0 and log errors instead
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('Asia/Kolkata');
?>
