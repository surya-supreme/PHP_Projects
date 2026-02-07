# 🔧 Troubleshooting Guide

## Quick Diagnostic Checklist

Run through this checklist to identify and fix common issues:

### ✅ Step 1: Verify Server is Running
- [ ] XAMPP/WAMP Apache is running (green light)
- [ ] MySQL is running (green light)
- [ ] Can access http://localhost/

### ✅ Step 2: Database Setup
- [ ] Database `registration_db` exists
- [ ] Table `users` exists with correct columns
- [ ] Database credentials in config.php are correct

### ✅ Step 3: File Location
- [ ] All files are in the correct htdocs/www folder
- [ ] Can access http://localhost/registration_form/

### ✅ Step 4: PHP Configuration
- [ ] PHP version is 7.4 or higher
- [ ] PHP sessions are enabled
- [ ] Error reporting is on (for debugging)

---

## Detailed Error Solutions

### 🔴 Error: "Connection failed: Access denied"

**Cause:** Database credentials are incorrect

**Solution:**
1. Open `config.php`
2. Check these values:
```php
define('DB_USER', 'root');  // Usually 'root' for XAMPP
define('DB_PASS', '');      // Usually empty for XAMPP
```
3. Try connecting manually:
```bash
mysql -u root -p
# If it asks for password and you don't have one, press Enter
```

---

### 🔴 Error: Form shows errors immediately without submitting

**Cause:** JavaScript validation is too strict or issues with script.js

**Solution:**
1. Check browser console for JavaScript errors (F12)
2. Ensure `script.js` is loading:
   - View page source
   - Look for `<script src="script.js"></script>`
   - Try accessing http://localhost/registration_form/script.js
3. Clear browser cache (Ctrl+Shift+Delete)

---

### 🔴 Error: "Invalid form submission" or CSRF token error

**Cause:** PHP sessions not working or cookies blocked

**Solution:**
1. Clear browser cookies
2. Try in incognito/private mode
3. Check PHP session configuration:
```php
<?php
// Create test.php in your project folder
session_start();
$_SESSION['test'] = 'working';
echo session_id() ? "Sessions are working!" : "Sessions NOT working";
?>
```
4. Visit http://localhost/registration_form/test.php

---

### 🔴 Error: Terms and Conditions link gives 404

**Cause:** File doesn't exist or wrong path

**Solution:**
1. Verify `terms.php` exists in same folder as `index.php`
2. Check file permissions (Linux):
```bash
ls -la /var/www/html/registration_form/terms.php
chmod 644 terms.php
```
3. Check for typos in the link

---

### 🔴 Error: Password validation not working

**Cause:** Password doesn't meet requirements

**Requirements:**
- Minimum 8 characters
- At least one uppercase letter (A-Z)
- At least one lowercase letter (a-z)
- At least one number (0-9)

**Valid Examples:**
- ✅ MyPass123
- ✅ SecureP4ss
- ✅ Test@1234
- ❌ password (no uppercase or number)
- ❌ PASSWORD123 (no lowercase)
- ❌ MyPass (no number)
- ❌ Pass123 (less than 8 characters)

---

### 🔴 Error: Phone number validation failing

**Cause:** Phone format is incorrect

**Solution:**
Phone must be exactly 10 digits:
- ✅ 9876543210
- ✅ 1234567890
- ❌ 98765 (too short)
- ❌ 98765432101 (too long)
- ❌ 987-654-3210 (contains dashes - it auto-removes them but re-check)

---

### 🔴 Error: Age validation failing

**Cause:** User is under 13 years old

**Solution:**
Date of birth must make user at least 13 years old
- If today is 2026-02-06
- DOB must be 2013-02-06 or earlier
- System calculates this automatically

---

### 🔴 Error: Registration succeeds but no success message

**Cause:** success.php missing or session issues

**Solution:**
1. Check if `success.php` exists
2. Manually visit http://localhost/registration_form/success.php
3. Check PHP error logs for redirect issues

---

## Debugging Steps

### Enable PHP Error Display:

Add to top of `config.php`:
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Check Apache Error Log:

**Windows (XAMPP):**
```
C:\xampp\apache\logs\error.log
```

**Linux:**
```bash
tail -f /var/log/apache2/error.log
```

**Mac:**
```bash
tail -f /Applications/XAMPP/logs/error_log
```

---

## Browser Console Debugging

1. Open browser Developer Tools (F12)
2. Go to Console tab
3. Look for JavaScript errors
4. Go to Network tab
5. Submit form and check if:
   - POST request to register.php is sent
   - Response is received
   - Any errors in response

---

## Port Conflicts

### If localhost doesn't work:

**Check ports:**
```bash
# Windows
netstat -ano | findstr :80
netstat -ano | findstr :3306

# Linux/Mac
netstat -tuln | grep :80
netstat -tuln | grep :3306
```

**Change Apache port:**
1. Open XAMPP Control Panel
2. Click Apache Config → httpd.conf
3. Find `Listen 80` and change to `Listen 8080`
4. Restart Apache
5. Access via http://localhost:8080/

---

## Still Having Issues?

### Create a detailed bug report:

1. **Environment:**
   - OS: (Windows/Linux/Mac)
   - Server: (XAMPP/WAMP/LAMP)
   - PHP Version: (run `php -v`)

2. **Error Details:**
   - Exact error message
   - When does it occur?
   - What you tried
   - Screenshots if possible

3. **Check:**
   - Browser console errors (F12)
   - PHP error logs
   - Network tab in DevTools

4. **Test Files:**
   - Can you access index.php?
   - Does phpMyAdmin work?

---

## Prevention Tips

1. Always use latest XAMPP/WAMP version
2. Don't modify files you don't understand
3. Make backups before changes
4. Test in multiple browsers
5. Keep database credentials simple for development (complex for production)
6. Clear browser cache regularly during development

---

**Need More Help?**

Check the main README.md for:
- Installation steps
- File structure
- Feature documentation
- Testing guide
