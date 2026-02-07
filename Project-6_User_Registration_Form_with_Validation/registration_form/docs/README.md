# User Registration System

## 🎯 Overview
This is a complete PHP-based user registration system with enhanced error handling, comprehensive terms and conditions, and improved security features.

## ✨ Features
- ✅ Secure user registration with validation
- ✅ Password encryption using bcrypt
- ✅ CSRF token protection
- ✅ SQL injection prevention
- ✅ Real-time client-side validation
- ✅ Comprehensive Terms and Conditions
- ✅ Privacy Policy page
- ✅ Better error handling and messaging
- ✅ Responsive design
- ✅ Session management

## 🔧 Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.3 or higher
- Apache/Nginx web server
- XAMPP/WAMP/LAMP (recommended for local development)

## 📦 Installation Steps

### 1. Database Setup

**Step 1:** Start your MySQL server (XAMPP/WAMP)

**Step 2:** Create the database using one of these methods:

**Method A - Using phpMyAdmin:**
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "New" to create a database
3. Name it `registration_db`
4. Click "Import" tab
5. Choose the `database_setup.sql` file
6. Click "Go"

**Method B - Using MySQL Command Line:**
```bash
mysql -u root -p
CREATE DATABASE registration_db;
USE registration_db;
SOURCE database_setup.sql;
```

### 2. Configure Database Connection

Open `config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Your MySQL username
define('DB_PASS', '');              // Your MySQL password
define('DB_NAME', 'registration_db');
```

### 3. Deploy Files

**For XAMPP:**
- Copy all project files to `C:\xampp\htdocs\registration_form_fixed\`
- Access via: `http://localhost/registration_form_fixed/`

**For WAMP:**
- Copy all project files to `C:\wamp64\www\registration_form_fixed\`
- Access via: `http://localhost/registration_form_fixed/`

**For LAMP (Linux):**
- Copy all project files to `/var/www/html/registration_form_fixed/`
- Access via: `http://localhost/registration_form_fixed/`

### 4. Set Permissions (Linux only)

```bash
sudo chown -R www-data:www-data /var/www/html/registration_form_fixed
sudo chmod -R 755 /var/www/html/registration_form_fixed
```

### 5. Test the Application

1. Open your browser
2. Navigate to `http://localhost/registration_form_fixed/`
3. Try registering a new user

## 🐛 Common Issues and Solutions

### Issue 1: "Database connection failed"
**Solution:**
- Verify MySQL is running
- Check database credentials in `config.php`
- Ensure database `registration_db` exists
- Test connection: `mysql -u root -p` in terminal

### Issue 2: "Failed to prepare statement"
**Solution:**
- Run the `database_setup.sql` script
- Verify the `users` table exists:
```sql
USE registration_db;
SHOW TABLES;
DESCRIBE users;
```

### Issue 3: "Invalid form submission"
**Solution:**
- Clear browser cookies and cache
- Try in incognito/private mode
- Ensure PHP sessions are enabled

### Issue 4: Password not meeting requirements
**Solution:**
Password must have:
- At least 8 characters
- One uppercase letter (A-Z)
- One lowercase letter (a-z)
- One number (0-9)

Example valid password: `MyPass123`

### Issue 5: Terms and Conditions link not working
**Solution:**
- Ensure `terms.php` and `privacy.php` are in the same directory
- Check file permissions
- Verify files are not empty

### Issue 6: Form submission redirects but no success message
**Solution:**
1. Check if data is actually inserted:
```sql
SELECT * FROM users ORDER BY id DESC LIMIT 5;
```
2. Verify `success.php` exists and is accessible
3. Check PHP error logs: `tail -f /var/log/apache2/error.log`

## 📝 Testing the Registration

### Test User Data
Use these details to test registration:

**Username:** testuser123  
**Email:** test@example.com  
**Password:** TestPass123  
**Full Name:** Test User  
**Phone:** 9876543210  
**Date of Birth:** 2000-01-01  
**Gender:** Male  
**Terms:** ✓ Checked  

### Validation Testing
Test these scenarios to ensure validation works:

1. **Empty fields** - Should show "Field is required" errors
2. **Short username** - Use "ab" (less than 3 chars)
3. **Invalid email** - Use "test@com" or "testcom"
4. **Weak password** - Use "password" (no uppercase/number)
5. **Mismatched passwords** - Different confirm password
6. **Invalid phone** - Use "123" (not 10 digits)
7. **Underage user** - Date of birth less than 13 years ago
8. **Unchecked terms** - Submit without checking terms

All should show appropriate error messages.

## 🔒 Security Features

### Implemented Security Measures:
1. **Password Hashing:** Bcrypt with automatic salt
2. **CSRF Protection:** Tokens for form submissions
3. **SQL Injection Prevention:** Prepared statements
4. **XSS Prevention:** Input sanitization and output escaping
5. **Session Security:** Secure session handling
6. **Input Validation:** Both client and server-side

## 📁 File Structure

```
registration_form_fixed/
├── index.php              # Main registration form
├── register.php           # Registration processing
├── login.php              # Login page
├── success.php            # Success page after registration
├── terms.php              # Terms and Conditions (NEW)
├── privacy.php            # Privacy Policy (NEW)
├── config.php             # Database configuration
├── functions.php          # Validation and helper functions
├── script.js              # Client-side validation
├── style.css              # Styling
├── database_setup.sql     # Database schema
└── README.md              # This file
```

## 🎨 New Features in Fixed Version

### 1. Comprehensive Terms and Conditions (`terms.php`)
- 13 detailed sections covering all legal aspects
- User responsibilities and acceptable use policies
- Data protection and privacy information
- Account termination policies
- Intellectual property rights
- Disclaimers and liability limitations

### 2. Privacy Policy (`privacy.php`)
- Detailed data collection practices
- Information usage and sharing policies
- Security measures explanation
- User privacy rights
- Cookie and tracking information
- Children's privacy protection
- International data transfer information

### 3. Improved Error Handling
- Better database connection error messages
- More specific validation error messages
- Helpful troubleshooting suggestions
- Clear indication of what went wrong

### 4. Enhanced User Experience
- Links to terms and privacy open in new tab
- Cleaner, more professional styling
- Better visual hierarchy
- Mobile-responsive design

## 🚀 Usage Guide

### For Users:
1. Fill in all required fields (marked with *)
2. Password must meet security requirements
3. Review and accept Terms and Conditions
4. Click "Create Account"
5. Upon success, you'll be redirected to success page

### For Developers:
1. Customize styling in `style.css`
2. Modify validation rules in `functions.php`
3. Update database schema in `database_setup.sql`
4. Adjust security settings in `config.php`
5. Update contact information in terms.php and privacy.php

## 🔄 Database Schema

### Users Table Structure:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);
```

## 📞 Support

If you encounter issues:

1. Check this README for solutions
2. Review PHP error logs
3. Verify database connection and tables
4. Ensure all files are in correct location
5. Test in different browser (clear cache)

## 📄 License

This project is provided as-is for educational and development purposes.

## 🙏 Credits

- PHP Password Hashing: bcrypt algorithm
- Form Validation: Custom JavaScript
- Security: OWASP guidelines
- Database: MySQL/MariaDB

---

**Last Updated:** February 6, 2026  
**Version:** 2.0 (Fixed)
