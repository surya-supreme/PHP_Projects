```markdown
# User Registration System (Session-Based)

## 🎯 Overview
This is a complete PHP-based user registration system using **session storage** instead of a database. Perfect for learning, prototyping, and demonstrations without database setup complexity.

## ✨ Features
- ✅ Secure user registration with validation
- ✅ Password encryption using bcrypt
- ✅ CSRF token protection
- ✅ Session-based data storage (no database needed!)
- ✅ Real-time client-side validation
- ✅ Password strength indicator
- ✅ Password visibility toggle
- ✅ Comprehensive error handling
- ✅ User dashboard with profile management
- ✅ Profile editing capabilities
- ✅ Password change functionality
- ✅ Account deletion with confirmation
- ✅ Responsive design for all devices
- ✅ Secure logout functionality

## 🔧 Requirements
- PHP 7.4 or higher
- Apache web server (with mod_rewrite enabled)
- XAMPP/WAMP/LAMP (recommended for local development)
- Modern web browser (Chrome, Firefox, Safari, Edge)

**Note:** No MySQL or database required! All data is stored in PHP sessions.

## 📦 Installation Steps

### 1. Deploy Files

**For XAMPP (Windows):**
- Copy all project files to `C:\xampp\htdocs\registration\`
- Access via: `http://localhost/registration/`

**For WAMP (Windows):**
- Copy all project files to `C:\wamp64\www\registration\`
- Access via: `http://localhost/registration/`

**For LAMP (Linux):**
- Copy all project files to `/var/www/html/registration/`
- Access via: `http://localhost/registration/`

**For MAMP (macOS):**
- Copy all project files to `/Applications/MAMP/htdocs/registration/`
- Access via: `http://localhost/registration/`

### 2. Start Apache Server

**XAMPP:**
1. Open XAMPP Control Panel
2. Click "Start" next to Apache
3. Wait for Apache to show green "Running" status

**WAMP:**
1. Start WAMP server
2. Ensure icon is green (not orange or red)

**LAMP:**
```bash
sudo systemctl start apache2
sudo systemctl status apache2
```

### 3. Verify PHP Session Support

Create a test file `test.php`:
```php
<?php
session_start();
$_SESSION['test'] = 'Sessions are working!';
echo $_SESSION['test'];
phpinfo();
?>
```

Access: `http://localhost/registration/test.php`

If you see "Sessions are working!" and PHP info, you're ready to go!

### 4. Test the Application

1. Open your browser
2. Navigate to `http://localhost/registration/`
3. Try registering a new user
4. Test login functionality
5. Explore dashboard features

## ⚠️ Important Session Notes

### Data Persistence:
- **Data is stored in PHP sessions** - temporary storage only
- **Data will be lost when:**
  - Browser is closed completely
  - After 24 minutes of inactivity (PHP default)
  - Server is restarted
  - Session is manually destroyed (logout)

### Session Files Location:
- **Windows (XAMPP):** `C:\xampp\tmp\sess_*`
- **Linux:** `/tmp/sess_*` or `/var/lib/php/sessions/`
- **macOS (MAMP):** `/Applications/MAMP/tmp/php/sess_*`

### Not Suitable For:
- ❌ Production websites
- ❌ Multiple concurrent users
- ❌ Long-term data storage
- ❌ Critical user information
- ❌ E-commerce or financial applications

### Perfect For:
- ✅ Learning PHP sessions
- ✅ Prototyping and demos
- ✅ Understanding form validation
- ✅ Testing UI/UX designs
- ✅ Educational projects
- ✅ Local development practice

## 🐛 Common Issues and Solutions

### Issue 1: "Session could not be started"
**Solution:**
- Ensure Apache is running
- Check PHP session settings in `php.ini`:
```ini
session.save_path = "/tmp"
session.auto_start = 0
```
- Verify tmp directory exists and is writable
- Windows: `C:\xampp\tmp`
- Linux: `/tmp`

### Issue 2: "Data disappears after page refresh"
**Solution:**
- Sessions may not be persisting properly
- Check browser cookies are enabled
- Try different browser or incognito mode
- Verify `session_start()` is at top of each PHP file
- Check for output before `session_start()`

### Issue 3: "Cannot modify header information"
**Solution:**
- This error means output was sent before `session_start()`
- Remove any spaces, HTML, or echo before `<?php session_start(); ?>`
- Check for UTF-8 BOM in files (save as UTF-8 without BOM)
- Ensure no whitespace after closing `?>` tags

### Issue 4: Password not meeting requirements
**Solution:**
Password must have:
- At least 8 characters
- One uppercase letter (A-Z)
- One lowercase letter (a-z)
- One number (0-9)

Example valid password: `MyPass123`

### Issue 5: "Invalid CSRF token" error
**Solution:**
- Clear browser cookies and cache
- Try in incognito/private mode
- Ensure cookies are enabled
- Don't keep form open for too long before submitting

### Issue 6: All users lost after browser close
**Solution:**
- This is **expected behavior** with session storage
- Sessions are temporary by design
- For permanent storage, you need a database
- Consider this a feature for learning/testing!

### Issue 7: Multiple browser tabs showing different data
**Solution:**
- Each browser/session has independent data
- Same browser tabs share session
- Different browsers = different sessions
- Incognito mode = separate session

## 📝 Testing the Registration

### Test User Data
Use these details to test registration:

**Username:** john_doe  
**Email:** john@example.com  
**Password:** JohnPass123  
**Confirm Password:** JohnPass123  
**Full Name:** John Doe  
**Phone:** 9876543210 (optional)  
**Date of Birth:** 2000-01-15 (optional)  
**Gender:** Male (optional)  
**Terms:** ✓ Checked  

### Validation Testing
Test these scenarios to ensure validation works:

1. **Empty required fields** - Should show "Field is required" errors
2. **Short username** - Use "ab" (less than 3 chars) → Error
3. **Invalid email** - Use "test@com" or "testcom" → Error
4. **Weak password** - Use "password" (no uppercase/number) → Error
5. **Password mismatch** - Different confirm password → Error
6. **Invalid phone** - Use "123" (not 10 digits) → Error
7. **Underage user** - DOB less than 13 years ago → Error (if enabled)
8. **Unchecked terms** - Submit without checking → Error
9. **Duplicate username** - Register twice with same username → Error
10. **Duplicate email** - Register twice with same email → Error

All should show appropriate error messages with helpful feedback.

### Login Testing
After registering, test login with:

1. **Correct credentials** → Should login successfully
2. **Wrong password** → Should show error
3. **Wrong username** → Should show error
4. **Empty fields** → Should show validation errors

### Dashboard Testing
After login, test:

1. **Edit Profile** → Update name, phone, DOB, gender → Save
2. **Change Password** → Enter current and new password → Save
3. **View Profile** → Check all information displays correctly
4. **Delete Account** → Two-step confirmation → Account removed
5. **Logout** → Session destroyed, redirected to home

## 🔒 Security Features

### Implemented Security Measures:
1. **Password Hashing:** Bcrypt with automatic salt (even for session storage!)
2. **CSRF Protection:** Tokens for all form submissions
3. **XSS Prevention:** `htmlspecialchars()` on all outputs
4. **Session Security:** 
   - Secure session handling
   - Session fixation prevention
   - Token validation on all actions
5. **Input Validation:** Both client-side (JavaScript) and server-side (PHP)
6. **Password Strength:** Real-time strength indicator
7. **Password Visibility:** Toggle for user convenience

### Security Limitations (Session-Based):
- ⚠️ Data stored in plain session files on server
- ⚠️ No protection against server-side attacks if compromised
- ⚠️ Session hijacking possible if not using HTTPS
- ⚠️ Not suitable for production environments

## 📁 File Structure

```
registration/
├── index.php              # Main registration form
├── register.php           # Registration processing script
├── login.php              # Login page
├── auth.php              # Login authentication
├── success.php            # Success page after registration
├── dashboard.php          # User dashboard (after login)
├── edit_profile.php       # Profile editing page
├── update_profile.php     # Profile update processing
├── change_password.php    # Password change page
├── update_password.php    # Password update processing
├── delete_account.php     # Account deletion processing
├── logout.php             # Logout and session destroy
├── script.js              # Client-side validation and interactions
├── style.css              # Complete styling for all pages
└── README.md              # This file
```

## 🎨 Key Features Explained

### 1. Session-Based User Storage
```php
// Users stored in session array
$_SESSION['registered_users'] = [
    [
        'username' => 'john_doe',
        'email' => 'john@example.com',
        'password' => '$2y$10$hashed_password_here',
        'full_name' => 'John Doe',
        // ... more fields
    ]
];
```

### 2. Password Strength Indicator
- Real-time visual feedback as user types
- Color-coded: Red (weak) → Orange (medium) → Green (strong)
- Checks for uppercase, lowercase, numbers, and length

### 3. Password Visibility Toggle
- Eye icon to show/hide password
- Works on both password and confirm password fields
- Improves user experience while maintaining security

### 4. CSRF Protection
- Unique token generated per session
- Token validated on all form submissions
- Prevents cross-site request forgery attacks

### 5. Form Data Preservation
- If validation fails, user data is preserved
- No need to re-enter everything
- Only errors need to be corrected

### 6. Duplicate Prevention
- Checks for existing usernames
- Checks for existing emails
- Helpful error message with link to login

### 7. User Dashboard
- Personalized welcome message
- View all profile information
- Quick access to edit, change password, delete account
- Security reminders and tips

### 8. Profile Management
- Edit: Full name, phone, DOB, gender
- Locked: Username and email (cannot be changed)
- Success confirmation after updates
- Data validation on all changes

### 9. Password Management
- Current password verification required
- New password must meet strength requirements
- New password must be different from current
- Confirmation field to prevent typos

### 10. Account Deletion
- Two-step confirmation process:
  1. Modal dialog with password confirmation
  2. Browser native confirmation
- Complete data removal from session
- Automatic logout after deletion

## 🚀 Usage Guide

### For Users:
1. **Register:**
   - Fill required fields (Username, Email, Password)
   - Optional: Full name, phone, DOB, gender
   - Check Terms and Conditions
   - Click "Create Account"

2. **Login:**
   - Enter username/email and password
   - Click "Login"
   - Access your dashboard

3. **Manage Profile:**
   - Edit profile information
   - Change password when needed
   - View account details
   - Delete account if desired

4. **Logout:**
   - Click "Logout" button in dashboard
   - Session destroyed, data cleared

### For Developers:
1. **Customize Styling:**
   - Edit `style.css` for colors, fonts, layout
   - All styles are well-organized with comments

2. **Modify Validation:**
   - JavaScript validation in `script.js`
   - PHP validation in processing files
   - Easy to add/remove rules

3. **Add Features:**
   - Session structure is flexible
   - Easy to add new profile fields
   - Simple to add new pages

4. **Security Settings:**
   - Adjust password requirements
   - Modify session timeout
   - Change CSRF token length

5. **Convert to Database:**
   - Replace session operations with database queries
   - Use same validation and security logic
   - Minimal code changes needed

## 🔄 Session Data Structure

### Registered Users Array:
```php
$_SESSION['registered_users'] = [
    [
        'username' => 'john_doe',
        'email' => 'john@example.com',
        'password' => '$2y$10$...',  // Bcrypt hashed
        'full_name' => 'John Doe',
        'phone' => '9876543210',
        'dob' => '2000-01-15',
        'gender' => 'Male',
        'created_at' => '2026-02-07 10:30:00',
        'last_login' => '2026-02-07 10:35:00'
    ]
    // ... more users
];
```

### Current User Session:
```php
$_SESSION['user_logged_in'] = true;
$_SESSION['user_username'] = 'john_doe';
$_SESSION['user_email'] = 'john@example.com';
```

### CSRF Token:
```php
$_SESSION['csrf_token'] = 'abc123def456...';  // 64 character hex string
```

## 📊 Upgrading to Database

When you're ready to use a database, here's what you need:

### 1. Create Database Table:
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

### 2. Replace Session Operations:
```php
// Instead of:
$_SESSION['registered_users'][] = $user_data;

// Use:
$stmt = $pdo->prepare("INSERT INTO users (username, email, password, ...) VALUES (?, ?, ?, ...)");
$stmt->execute([$username, $email, $password, ...]);
```

### 3. Update Login Check:
```php
// Instead of:
foreach ($_SESSION['registered_users'] as $user) {
    if ($user['username'] === $username) { ... }
}

// Use:
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
```

## 📞 Support & Troubleshooting

### Quick Checks:
1. ✅ Is Apache running?
2. ✅ Are cookies enabled in browser?
3. ✅ Did you access via `localhost` (not file:///)?
4. ✅ Is the URL correct?
5. ✅ Are there any PHP errors? (Check error logs)

### Error Log Locations:
- **XAMPP:** `C:\xampp\apache\logs\error.log`
- **WAMP:** `C:\wamp64\logs\apache_error.log`
- **LAMP:** `/var/log/apache2/error.log`

### Testing Checklist:
- [ ] Apache server is running
- [ ] Project files in correct directory
- [ ] Can access http://localhost/registration/
- [ ] Registration form loads properly
- [ ] Can register new user
- [ ] Can login with registered credentials
- [ ] Dashboard displays after login
- [ ] Profile editing works
- [ ] Password change works
- [ ] Account deletion works
- [ ] Logout works properly
