# User Registration System

A complete PHP-based user registration system using session storage. No database required.

## Features

✓ Secure user registration with validation  
✓ Password encryption using bcrypt  
✓ CSRF token protection  
✓ Session-based storage  
✓ Real-time validation  
✓ Password strength indicator  
✓ User dashboard and profile management  
✓ Responsive design  

## Requirements

- PHP 7.4 or higher
- Apache web server with mod_rewrite
- Modern web browser

**Note:** No database required. All data is stored in PHP sessions.

## Installation

### 1. Deploy Files

Copy all project files to your web server directory:

- **XAMPP (Windows):** `C:\xampp\htdocs\registration\`
- **WAMP (Windows):** `C:\wamp64\www\registration\`
- **LAMP (Linux):** `/var/www/html/registration/`
- **MAMP (macOS):** `/Applications/MAMP/htdocs/registration/`

Access via: `http://localhost/registration/`

### 2. Start Apache Server

**XAMPP/WAMP:**  
Open control panel and start Apache service.

**LAMP:**
```bash
sudo systemctl start apache2
```

### 3. Test the Application

Navigate to `http://localhost/registration/` and test registration functionality.

## Important Notes

### Data Persistence

✓ Data is stored in PHP sessions  
✗ Data is lost when browser closes  
✗ Data is lost after 24 minutes of inactivity  
✗ Data is lost when server restarts  

### Best Used For

✓ Learning and prototyping  
✓ Educational projects  
✓ Local development practice  
✓ UI/UX testing  

### Not Suitable For

✗ Production websites  
✗ Multiple concurrent users  
✗ Long-term data storage  
✗ Critical user information  

## Common Issues

### Session could not be started
Ensure Apache is running and check PHP session settings in `php.ini`:
```ini
session.save_path = "/tmp"
session.auto_start = 0
```

### Data disappears after refresh
- Enable browser cookies
- Verify `session_start()` is at the top of each PHP file
- Remove any output before `session_start()`

### Cannot modify header information
Remove any spaces, HTML, or output before `<?php session_start(); ?>`

### Invalid CSRF token
Clear browser cookies and cache, or try incognito mode.

## Testing

### Sample Registration Data

```
Username: john_doe
Email: john@example.com
Password: JohnPass123
Full Name: John Doe
Phone: 9876543210
```

### Password Requirements

- Minimum 8 characters
- One uppercase letter
- One lowercase letter
- One number

### Validation Tests

Test these scenarios:

✓ Empty required fields  
✓ Short username (less than 3 characters)  
✓ Invalid email format  
✓ Weak password  
✓ Password mismatch  
✓ Invalid phone number  
✓ Duplicate username or email  

## Security Features

✓ Bcrypt password hashing  
✓ CSRF protection  
✓ XSS prevention  
✓ Input validation (client and server-side)  
✓ Session fixation prevention  

### Security Limitations

✗ Data stored in plain session files  
✗ Not suitable for production  
✗ Session hijacking possible without HTTPS  

## File Structure

```
registration/
├── index.php              # Registration form
├── register.php           # Registration processing
├── login.php              # Login page
├── auth.php               # Authentication
├── dashboard.php          # User dashboard
├── edit_profile.php       # Profile editing
├── update_profile.php     # Profile update processing
├── change_password.php    # Password change
├── delete_account.php     # Account deletion
├── logout.php             # Logout
├── script.js              # Client-side validation
├── style.css              # Styling
└── README.md              # Documentation
```

## User Guide

### Registration
1. Fill required fields (username, email, password)
2. Add optional information
3. Accept terms and conditions
4. Click "Create Account"

### Login
1. Enter username/email and password
2. Click "Login"
3. Access dashboard

### Profile Management
- Edit profile information
- Change password
- View account details
- Delete account

## Upgrading to Database

### Create Table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(15),
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);
```

### Update Code

Replace session operations with database queries:

```php
// Replace session array with database insert
$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $password]);

// Replace session loop with database query
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
```

## Troubleshooting

### Quick Checks

✓ Apache server running  
✓ Cookies enabled in browser  
✓ Accessing via localhost  
✓ Correct URL path  
✓ Check PHP error logs  

### Error Log Locations

- **XAMPP:** `C:\xampp\apache\logs\error.log`
- **WAMP:** `C:\wamp64\logs\apache_error.log`
- **LAMP:** `/var/log/apache2/error.log`

---

**Version:** 1.0  
**Last Updated:** February 2026
