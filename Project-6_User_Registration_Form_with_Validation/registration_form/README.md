# 📁 User Registration System - Professional Project Structure

## 🎯 Project Overview
A complete PHP user registration and login system with **NO DATABASE REQUIRED**. Uses file-based storage (JSON) for simplicity and easy setup.

---

## 📂 Project Folder Structure

```
registration_form/
│
├── 📄 index.php                    ← Main landing page (Registration Form)
│
├── 📁 assets/                      ← All static resources
│   ├── css/
│   │   └── style.css              ← All styles
│   └── js/
│       └── script.js              ← Client-side validation
│
├── 📁 includes/                    ← Backend processing files
│   ├── config.php                 ← Configuration (file-based storage)
│   ├── functions.php              ← Validation and helper functions
│   ├── register.php               ← Registration processor
│   ├── process_login.php          ← Login processor
│   └── logout.php                 ← Logout handler
│
├── 📁 pages/                       ← User interface pages
│   ├── login.php                  ← Login page
│   ├── dashboard.php              ← User dashboard (after login)
│   ├── success.php                ← Registration success page
│   ├── terms.php                  ← Terms and conditions
│   └── privacy.php                ← Privacy policy
│
├── 📁 data/                        ← User data storage (auto-created)
│   └── users.json                 ← All user data (JSON format)
│
└── 📁 docs/                        ← Documentation
    └── (various .md files)
```

---

## 🚀 How to Run on Localhost

### Prerequisites
- XAMPP (or WAMP/LAMP) installed
- Apache web server
- PHP 7.4 or higher
- **NO DATABASE REQUIRED!** ✅

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install it on your computer
3. Start **Apache** service (no need for MySQL)

### Step 2: Copy Project
1. Extract the `registration_form` folder
2. Copy it to: `C:\xampp\htdocs\`
   
   Final path should be:
   ```
   C:\xampp\htdocs\registration_form\
   ```

### Step 3: Set Permissions (Important!)
The `data/` folder needs write permissions:

**Windows:**
- Right-click on `data` folder → Properties → Security
- Make sure Users have "Modify" permissions

**Linux/Mac:**
```bash
chmod 777 data/
chmod 666 data/users.json
```

### Step 4: Open in Browser
1. Open your web browser
2. Go to: `http://localhost/registration_form/`
3. That's it! No database setup needed!

---

## 🎯 User Flow

```
1. Open Browser
   ↓
   http://localhost/registration_form/
   (Shows: index.php - Registration Form)
   
2. Fill Registration Form
   ↓
   Submit → includes/register.php
   ↓
   Data saved in data/users.json
   ↓
   Redirect to pages/success.php
   
3. Click "Proceed to Login"
   ↓
   pages/login.php
   
4. Enter Credentials
   ↓
   Submit → includes/process_login.php
   ↓
   Verify from data/users.json
   ↓
   Redirect to pages/dashboard.php
   
5. View Dashboard
   - See all your profile information
   - Account statistics
   - User details
   
6. Click "Logout"
   ↓
   includes/logout.php
   ↓
   Clear session → Redirect to pages/login.php
```

---

## 📁 File Purposes

### Root Level Files

| File | Purpose |
|------|---------|
| `index.php` | Main entry point - Shows registration form |

### Assets Folder

| File | Purpose |
|------|---------|
| `assets/css/style.css` | All styling for the entire application |
| `assets/js/script.js` | Client-side form validation |

### Includes Folder (Backend Logic)

| File | Purpose |
|------|---------|
| `config.php` | File-based storage configuration and functions |
| `functions.php` | Validation functions (username, email, password, etc.) |
| `register.php` | Processes registration form, saves to JSON file |
| `process_login.php` | Authenticates user, creates session |
| `logout.php` | Destroys session, logs user out |

### Pages Folder (User Interface)

| File | Purpose |
|------|---------|
| `login.php` | Login form page |
| `dashboard.php` | User profile dashboard (after login) |
| `success.php` | Shows success message after registration |
| `terms.php` | Terms and conditions page |
| `privacy.php` | Privacy policy page |

### Data Folder (Storage)

| File | Purpose |
|------|---------|
| `users.json` | Stores all user data in JSON format |

---

## 🔐 How It Works (No Database)

### Data Storage
- All user data is stored in `data/users.json`
- Each user is a JSON object in an array
- Data persists between sessions

### Example User Data Structure:
```json
[
    {
        "id": 1,
        "username": "johndoe",
        "email": "john@example.com",
        "password": "$2y$10$...", // Hashed password
        "full_name": "John Doe",
        "phone": "1234567890",
        "date_of_birth": "1990-01-01",
        "gender": "Male",
        "created_at": "2026-02-07 10:30:00",
        "last_login": "2026-02-07 14:30:00"
    }
]
```

### Security Features
✅ Password hashing (bcrypt)
✅ CSRF protection
✅ Input validation
✅ XSS protection
✅ Session management

---

## 💻 Quick Start Commands

### Windows (XAMPP):
```batch
1. Open XAMPP Control Panel
2. Start Apache
3. Open browser: http://localhost/registration_form/
```

### Linux/Mac:
```bash
# If using built-in PHP server
cd /path/to/registration_form
php -S localhost:8000

# Open browser: http://localhost:8000/
```

---

## 🧪 Testing the Application

1. **Register a New User:**
   - Go to `http://localhost/registration_form/`
   - Fill all required fields
   - Click "Create Account"
   - See success message

2. **Login:**
   - Click "Proceed to Login" or go to `pages/login.php`
   - Enter email/username and password
   - Click "Login"

3. **View Dashboard:**
   - After login, see your complete profile
   - View all account details
   - Check account statistics

4. **Logout:**
   - Click "Logout" button
   - Session cleared
   - Redirected to login page

---

## 🛠️ Customization

### Change Colors
Edit `assets/css/style.css`:
```css
/* Find and modify the gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Add More Fields
1. Add input field in `index.php`
2. Add validation in `includes/functions.php`
3. Update `includes/register.php` to save the field
4. Display in `pages/dashboard.php`

### Change Site Name
Edit the `<title>` tag in each page file

---

## 📊 File Access Rules

### From `index.php` (root):
```php
require_once 'includes/functions.php';        // ✅ Correct
href="assets/css/style.css"                    // ✅ Correct
action="includes/register.php"                 // ✅ Correct
href="pages/login.php"                         // ✅ Correct
```

### From `pages/*.php`:
```php
require_once '../includes/functions.php';      // ✅ Correct
href="../assets/css/style.css"                 // ✅ Correct
action="../includes/process_login.php"         // ✅ Correct
href="../index.php"                            // ✅ Correct
```

### From `includes/*.php`:
```php
require_once 'config.php';                     // ✅ Correct
require_once 'functions.php';                  // ✅ Correct
header("Location: ../index.php");              // ✅ Correct
header("Location: ../pages/dashboard.php");    // ✅ Correct
```

---

## ⚠️ Important Notes

### 1. Data Folder Permissions
**CRITICAL:** The `data/` folder must have write permissions!
- On Windows: Give "Users" group "Modify" permission
- On Linux/Mac: `chmod 777 data/`

### 2. No Database Setup Required
- This project uses JSON file storage
- No MySQL, no phpMyAdmin needed
- Just extract and run!

### 3. First-Time Setup
- The `users.json` file is created automatically
- Empty array `[]` is the initial state
- Users are added as you register

### 4. Data Persistence
- All data is saved in `data/users.json`
- Data persists even after server restart
- To reset: Delete content and put `[]` in users.json

---

## 🆘 Troubleshooting

### "Not Found" Error
**Solution:**
- Check folder is at: `C:\xampp\htdocs\registration_form/`
- Check Apache is running
- URL should be: `http://localhost/registration_form/`

### CSS/JS Not Loading
**Solution:**
- Hard refresh: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
- Check file paths in HTML
- Clear browser cache

### "Failed to save user" Error
**Solution:**
- Check `data/` folder has write permissions
- On Windows: Right-click → Properties → Security → Edit
- On Linux: `chmod 777 data/`

### Data Not Saving
**Solution:**
- Check `data/users.json` exists
- Check file permissions (should be 666 or writable)
- Check PHP error logs for details

---

## ✅ Advantages of This Structure

### 1. **Clean Organization**
   - Separate folders for different purposes
   - Easy to find any file
   - Professional structure

### 2. **Easy Maintenance**
   - All styles in one place (`assets/css/`)
   - All scripts in one place (`assets/js/`)
   - All backend logic in `includes/`
   - All pages in `pages/`

### 3. **No Database Complexity**
   - No SQL setup required
   - No connection issues
   - Just copy and run!

### 4. **Scalable**
   - Easy to add new pages
   - Easy to add new features
   - Clear separation of concerns

### 5. **Beginner-Friendly**
   - Simple to understand
   - Clear file purposes
   - No complex setup

---

## 📝 Version Information

- **Version:** 2.0 (Organized Structure)
- **PHP Required:** 7.4+
- **Database Required:** None ✅
- **Last Updated:** February 2026

---

## 🎉 Ready to Use!

This project is completely ready to run. No database setup, no complex configuration. Just:
1. Copy to htdocs
2. Start Apache
3. Open in browser
4. Start using!

**Enjoy your professional, well-organized registration system!** 🚀
