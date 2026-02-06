<?php
/**
 * Application Configuration File
 */

// Define base paths
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ASSETS_PATH', BASE_PATH . '/assets');
define('PAGES_PATH', BASE_PATH . '/pages');
define('INCLUDES_PATH', BASE_PATH . '/includes');

// Define URL paths
define('BASE_URL', '/registration_form_organized/public');
define('ASSETS_URL', BASE_URL . '/../assets');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Application settings
define('APP_NAME', 'Registration System');
define('APP_VERSION', '1.0.0');
?>
