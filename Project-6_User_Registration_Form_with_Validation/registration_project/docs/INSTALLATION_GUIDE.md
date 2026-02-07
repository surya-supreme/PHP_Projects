# User Registration System - Installation Guide

## 📋 Project Overview

This is a complete PHP user registration and login system with the following features:
- User registration with validation
- Secure login/logout functionality
- User dashboard showing profile details
- Password hashing for security
- CSRF protection
- Session management
- Responsive design

## 🚀 Quick Start Guide

### Prerequisites
- **XAMPP** (or WAMP/LAMP) installed on your computer
- Apache server
- MySQL/MariaDB database
- PHP 7.4 or higher

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP on your computer
3. Start **Apache** and **MySQL** from XAMPP Control Panel

### Step 2: Setup Project Files

1. **Copy project folder** to XAMPP's htdocs directory:
   ```
   C:\xampp\htdocs\registration_project\
   ```
   
   Your folder structure should look like this:
   ```
   C:\xampp\htdocs\registration_project\
   ├── config.php
   ├── functions.php
   ├── index.php (registration form)
   ├── login.php
   ├── process_login.php
   ├── register.php
   ├── dashboard.php
   ├── logout.php
   ├── success.php
   ├── style.css
   ├── script.js
   ├── database_setup.sql
   └── README.md
   ```

### Step 3: Setup Database

1. Open your browser and go to: **http://localhost/phpmyadmin**

2. Click on **"SQL"** tab at the top

3. Open the `database_setup.sql` file and copy its contents

4. Paste the SQL code into the SQL tab and click **"Go"**

5. This will:
   - Create database: `registration_db`
   - Create table: `users`
   - Setup all necessary columns and indexes

### Step 4: Configure Database Connection

1. Open `config.php` file

2. Verify these settings (usually correct by default):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Empty for XAMPP default
   define('DB_NAME', 'registration_db');
   ```

3. If your MySQL password is different, update `DB_PASS`

### Step 5: Test the Application

1. Open your browser

2. Navigate to: **http://localhost/registration_project/**

3. You should see the registration form

## 🔧 Fixing "Not Found" Error

If you see **"Not Found - The requested URL was not found on this server"** error:

### Solution 1: Check File Location
- Make sure all files are in: `C:\xampp\htdocs\registration_project\`
- Files should NOT be in a subfolder

### Solution 2: Check Apache Service
1. Open XAMPP Control Panel
2. Make sure **Apache** is running (green highlight)
3. If not, click **Start** next to Apache

### Solution 3: Check Port Conflicts
1. Apache usually runs on port 80
2. If another application is using port 80, change it:
   - Click **Config** → **Apache (httpd.conf)**
   - Find `Listen 80` and change to `Listen 8080`
   - Restart Apache
   - Access via: `http://localhost:8080/registration_project/`

### Solution 4: Check URL
- Correct URL: `http://localhost/registration_project/`
- NOT: `http://localhost/registration_project/index.html`
- NOT: `file:///C:/xampp/htdocs/registration_project/`

### Solution 5: Check File Permissions
- Make sure all PHP files have read permissions
- On Windows, this is usually automatic

## 📝 How to Use the System

### Register a New User
1. Go to: `http://localhost/registration_project/`
2. Fill in the registration form:
   - Username (required)
   - Email (required)
   - Password (required, min 8 characters)
   - Confirm Password (required)
   - Full Name (required)
   - Phone (optional)
   - Date of Birth (optional)
   - Gender (optional)
3. Accept terms and conditions
4. Click **"Create Account"**
5. You'll be redirected to success page

### Login to Your Account
1. Click **"Login here"** or go to: `http://localhost/registration_project/login.php`
2. Enter your **email or username**
3. Enter your **password**
4. Click **"Login"**
5. You'll be redirected to your dashboard

### View Your Dashboard
- After login, you'll see your complete profile information
- User details are displayed in organized cards
- You can see:
  - Username, Email, Full Name
  - Phone Number, Date of Birth, Gender
  - Account creation date
  - Last login time
  - Account statistics

### Logout
- Click the **"Logout"** button in the top-right corner of dashboard
- You'll be redirected to login page with a success message

## 🎯 File Structure Explained

### Main Files
- **index.php** - Registration form (landing page)
- **login.php** - Login form page
- **dashboard.php** - User dashboard (shows after login)
- **register.php** - Processes registration form
- **process_login.php** - Handles login authentication
- **logout.php** - Handles user logout
- **success.php** - Registration success page

### Helper Files
- **config.php** - Database configuration
- **functions.php** - Reusable PHP functions
- **style.css** - All styling
- **script.js** - Client-side validation

### Database
- **database_setup.sql** - Complete database schema

## 🔐 Security Features

1. **Password Hashing** - Passwords are hashed using PHP's `password_hash()`
2. **CSRF Protection** - Forms include CSRF tokens
3. **SQL Injection Prevention** - Using prepared statements
4. **XSS Protection** - Output is escaped with `htmlspecialchars()`
5. **Session Security** - Proper session management
6. **Input Validation** - Both client-side and server-side

## 🐛 Troubleshooting

### "Connection failed" error
- Make sure MySQL is running in XAMPP
- Check database credentials in `config.php`
- Verify database `registration_db` exists in phpMyAdmin

### "Username/Email already exists" error
- This username or email is already registered
- Try different credentials

### "Invalid security token" error
- Clear browser cookies and cache
- Try in incognito/private browsing mode

### CSS/JavaScript not loading
- Check file paths in HTML files
- Make sure `style.css` and `script.js` are in the same folder
- Hard refresh browser: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)

### Blank white page
- Check PHP error logs in XAMPP
- Enable error display in `config.php`:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```

## 📊 Database Structure

### Users Table
```
- id (Primary Key)
- username (Unique)
- email (Unique)
- password (Hashed)
- full_name
- phone
- dob (Date of Birth)
- gender
- last_login
- created_at
- updated_at
```

## 🎨 Customization

### Change Colors
Edit `style.css` - look for gradient colors:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Change Site Name
Edit the `<title>` tags in each PHP file

### Add More Fields
1. Add column to database
2. Add input field in `index.php`
3. Add validation in `functions.php`
4. Update `register.php` to save the field
5. Display in `dashboard.php`

## 📞 Support

If you encounter any issues:
1. Check this README file
2. Review error messages carefully
3. Check XAMPP error logs
4. Verify all files are in correct location
5. Make sure Apache and MySQL are running

## ✅ Testing Checklist

- [ ] XAMPP installed and running
- [ ] Apache service is green/running
- [ ] MySQL service is green/running
- [ ] Database created successfully
- [ ] Files in htdocs/registration_project/
- [ ] Can access http://localhost/registration_project/
- [ ] Registration form loads correctly
- [ ] Can submit registration form
- [ ] Can login with credentials
- [ ] Dashboard displays user information
- [ ] Can logout successfully

## 📝 Default Settings

- **Database Host**: localhost
- **Database User**: root
- **Database Password**: (empty)
- **Database Name**: registration_db
- **Timezone**: Asia/Kolkata
- **Min Password Length**: 8 characters
- **Min Age Requirement**: 13 years

---

**Created by:** Your Name
**Last Updated:** February 2026
**Version:** 1.0
