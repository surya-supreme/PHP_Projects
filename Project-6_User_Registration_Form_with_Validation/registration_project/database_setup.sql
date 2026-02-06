-- ============================================
-- User Registration System Database Setup
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS registration_db;

-- Use the database
USE registration_db;

-- ============================================
-- Create Users Table
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NULL,
    date_of_birth DATE NULL,
    gender ENUM('Male', 'Female', 'Other') NULL,
    is_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255) NULL,
    reset_token VARCHAR(255) NULL,
    reset_token_expiry DATETIME NULL,
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes for better performance
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Create Activity Log Table (Optional)
-- ============================================
CREATE TABLE IF NOT EXISTS activity_log (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    action VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign key relationship
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Index for better query performance
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Create Login Attempts Table (Optional - for security)
-- ============================================
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success TINYINT(1) DEFAULT 0,
    
    -- Index for better query performance
    INDEX idx_email (email),
    INDEX idx_ip_address (ip_address),
    INDEX idx_attempt_time (attempt_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Sample Data (Optional - for testing)
-- ============================================

-- Note: Password is 'Test@123' hashed using PASSWORD_DEFAULT
-- You should not insert plain text passwords in production
-- This is just for testing purposes

-- INSERT INTO users (username, email, password, full_name, phone, gender) VALUES
-- ('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', '9876543210', 'Male'),
-- ('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane Smith', '9876543211', 'Female');

-- ============================================
-- Views (Optional - for reporting)
-- ============================================

-- View to get user statistics
CREATE OR REPLACE VIEW user_statistics AS
SELECT 
    COUNT(*) as total_users,
    COUNT(CASE WHEN is_verified = 1 THEN 1 END) as verified_users,
    COUNT(CASE WHEN is_verified = 0 THEN 1 END) as unverified_users,
    COUNT(CASE WHEN gender = 'Male' THEN 1 END) as male_users,
    COUNT(CASE WHEN gender = 'Female' THEN 1 END) as female_users,
    COUNT(CASE WHEN gender = 'Other' THEN 1 END) as other_gender_users,
    COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as registered_today,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as registered_this_week,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as registered_this_month
FROM users;

-- View to get recent registrations
CREATE OR REPLACE VIEW recent_registrations AS
SELECT 
    id,
    username,
    email,
    full_name,
    created_at
FROM users
ORDER BY created_at DESC
LIMIT 10;

-- ============================================
-- Stored Procedures (Optional - for advanced operations)
-- ============================================

DELIMITER //

-- Procedure to get user by email or username
CREATE PROCEDURE IF NOT EXISTS GetUserByCredential(
    IN credential VARCHAR(100)
)
BEGIN
    SELECT * FROM users 
    WHERE email = credential OR username = credential
    LIMIT 1;
END //

-- Procedure to update last login
CREATE PROCEDURE IF NOT EXISTS UpdateLastLogin(
    IN user_id INT
)
BEGIN
    UPDATE users 
    SET last_login = NOW() 
    WHERE id = user_id;
END //

-- Procedure to delete old unverified users (cleanup)
CREATE PROCEDURE IF NOT EXISTS CleanupUnverifiedUsers(
    IN days_old INT
)
BEGIN
    DELETE FROM users 
    WHERE is_verified = 0 
    AND created_at < DATE_SUB(NOW(), INTERVAL days_old DAY);
END //

DELIMITER ;

-- ============================================
-- Triggers (Optional - for automatic operations)
-- ============================================

-- Trigger to log user creation
DELIMITER //
CREATE TRIGGER IF NOT EXISTS after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO activity_log (user_id, action, ip_address)
    VALUES (NEW.id, 'User registered', NULL);
END //
DELIMITER ;

-- ============================================
-- Grant Permissions (Optional - for security)
-- ============================================

-- Create a specific database user with limited permissions
-- Uncomment and modify as needed
-- CREATE USER 'registration_user'@'localhost' IDENTIFIED BY 'strong_password_here';
-- GRANT SELECT, INSERT, UPDATE ON registration_db.users TO 'registration_user'@'localhost';
-- GRANT SELECT, INSERT ON registration_db.activity_log TO 'registration_user'@'localhost';
-- FLUSH PRIVILEGES;

-- ============================================
-- Verification and Information Queries
-- ============================================

-- Show all tables
SHOW TABLES;

-- Describe users table structure
DESCRIBE users;

-- Show user statistics
SELECT * FROM user_statistics;

-- Show recent registrations
SELECT * FROM recent_registrations;

-- ============================================
-- Maintenance Queries
-- ============================================

-- Count total users
-- SELECT COUNT(*) as total_users FROM users;

-- Find users registered today
-- SELECT * FROM users WHERE DATE(created_at) = CURDATE();

-- Find unverified users
-- SELECT * FROM users WHERE is_verified = 0;

-- Clean up old login attempts (keep only last 30 days)
-- DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 30 DAY);

-- ============================================
-- End of Database Setup
-- ============================================
