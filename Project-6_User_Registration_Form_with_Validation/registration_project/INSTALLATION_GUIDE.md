# 🚀 COMPLETE INSTALLATION GUIDE - STEP BY STEP

## ❌ ERROR: "Not Found - The requested URL was not found on this server"

### CAUSE:
The files are not in the correct folder, or the folder name is wrong in the URL.

---

## ✅ SOLUTION: Follow These Exact Steps

### STEP 1: Check if Apache and MySQL are Running

**For XAMPP:**
1. Open **XAMPP Control Panel**
2. Make sure these are **GREEN** and say "Running":
   - ✅ **Apache** 
   - ✅ **MySQL**
3. If not green, click **Start** button for each

**Visual Check:**
```
Module    Status
------    ------
Apache    [Stop] ← Should say "Running" in green
MySQL     [Stop] ← Should say "Running" in green
```

---

### STEP 2: Find Your htdocs Folder

**For XAMPP (Windows):**
Default location: `C:\xampp\htdocs\`

**For WAMP (Windows):**
Default location: `C:\wamp64\www\`

**For LAMP (Linux):**
Default location: `/var/www/html/`

**For MAMP (Mac):**
Default location: `/Applications/MAMP/htdocs/`

**How to find it:**
1. Open XAMPP Control Panel
2. Click **Explorer** button (right side)
3. You'll see the `htdocs` folder
4. **THIS IS WHERE YOUR FILES MUST GO**

---

### STEP 3: Extract and Copy Files

1. **Extract** the `registration_project_fixed.zip` file
2. You should see a folder named `registration_project_fixed`
3. **Copy** this entire folder into `htdocs`

**Final structure should be:**
```
C:\xampp\htdocs\
└── registration_project_fixed\
    ├── index.php
    ├── register.php
    ├── setup_database.php
    ├── config.php
    ├── functions.php
    ├── script.js
    ├── style.css
    ├── terms.php
    ├── privacy.php
    ├── success.php
    ├── login.php
    ├── test_connection.php
    ├── database_setup.sql
    └── (other files)
```

**IMPORTANT:** 
- Don't put files inside another folder
- Don't rename the folder
- Make sure all files are directly inside `registration_project_fixed` folder

---

### STEP 4: Test the Correct URL

Open your browser and type **EXACTLY**:

```
http://localhost/registration_project_fixed/setup_database.php
```

**Common mistakes to avoid:**
- ❌ `http://localhost/setup_database.php` (missing folder name)
- ❌ `http://localhost/registration_project_fixed.zip/setup_database.php` (don't use .zip)
- ❌ `http://localhost/registration/setup_database.php` (wrong folder name)
- ✅ `http://localhost/registration_project_fixed/setup_database.php` (CORRECT!)

---

### STEP 5: Run Database Setup

If the page loads correctly:
1. You'll see a blue button: **"🚀 Run Database Setup"**
2. Click it
3. Wait for green success messages
4. Click **"Go to Registration Form"**

---

## 🔍 TROUBLESHOOTING

### Problem 1: Still getting "Not Found" error

**Check these:**

**A) Is Apache running?**
- Open XAMPP Control Panel
- Apache should be GREEN
- If not, click Start

**B) Are files in the right place?**
- Open File Explorer
- Go to: `C:\xampp\htdocs\`
- You should see folder: `registration_project_fixed`
- Open that folder
- You should see: `index.php`, `setup_database.php`, etc.

**C) Is the URL correct?**
```
✅ Correct: http://localhost/registration_project_fixed/setup_database.php
❌ Wrong:   http://localhost/setup_database.php
❌ Wrong:   http://localhost/registration_project_fixed
```

**D) Test if Apache is working at all:**
- Go to: `http://localhost/`
- You should see XAMPP welcome page or folder listing
- If this doesn't work, Apache is not running properly

---

### Problem 2: Port 80 is being used by another program

**Symptoms:**
- Apache won't start (stays red)
- Error message about port 80

**Solution:**

**Option A - Stop the conflicting program:**
1. Press `Win + R`
2. Type: `resmon.exe`
3. Click "Network" tab
4. Look for process using port 80
5. End that process

**Option B - Change Apache port:**
1. In XAMPP Control Panel
2. Click **Config** button next to Apache
3. Choose **httpd.conf**
4. Find line: `Listen 80`
5. Change to: `Listen 8080`
6. Save file
7. Restart Apache
8. Now use: `http://localhost:8080/registration_project_fixed/setup_database.php`

---

### Problem 3: Files are nested too deep

**Wrong structure:**
```
htdocs\
└── registration_project_fixed\
    └── registration_project_fixed\  ← WRONG! (folder inside folder)
        └── index.php
```

**Correct structure:**
```
htdocs\
└── registration_project_fixed\
    └── index.php  ← CORRECT! (files directly inside)
```

**Fix:**
1. Open the outer `registration_project_fixed` folder
2. If you see another `registration_project_fixed` folder inside
3. Move all files from inner folder to outer folder
4. Delete the inner empty folder

---

### Problem 4: Using wrong folder name

**Solution:**
The folder MUST be named exactly: `registration_project_fixed`

If you renamed it to something else, either:
- Rename it back to `registration_project_fixed`
- Or use your folder name in the URL: `http://localhost/YOUR_FOLDER_NAME/setup_database.php`

---

## 📋 COMPLETE VERIFICATION CHECKLIST

Go through this checklist:

**1. XAMPP Status:**
- [ ] XAMPP Control Panel is open
- [ ] Apache is RUNNING (green)
- [ ] MySQL is RUNNING (green)

**2. Files Location:**
- [ ] Opened: `C:\xampp\htdocs\`
- [ ] See folder: `registration_project_fixed`
- [ ] Inside that folder, see: `index.php`, `setup_database.php`, etc.
- [ ] Files are NOT inside another subfolder

**3. Test Basic Apache:**
- [ ] Can access: `http://localhost/`
- [ ] See XAMPP dashboard or folder listing

**4. Test Project URL:**
- [ ] Can access: `http://localhost/registration_project_fixed/`
- [ ] See list of files or the registration form

**5. Run Setup:**
- [ ] Can access: `http://localhost/registration_project_fixed/setup_database.php`
- [ ] See the blue "Run Database Setup" button

---

## 🎯 QUICK FIX COMMANDS

**If you're comfortable with Command Prompt:**

```batch
:: Navigate to htdocs
cd C:\xampp\htdocs

:: List contents (should see registration_project_fixed folder)
dir

:: Navigate into the project folder
cd registration_project_fixed

:: List contents (should see all PHP files)
dir
```

You should see:
- config.php
- functions.php
- index.php
- register.php
- setup_database.php
- etc.

---

## 🆘 STILL NOT WORKING?

### Last Resort - Manual Path Check:

1. Right-click on `setup_database.php` file
2. Click **Properties**
3. Check the **Location** field
4. It should show: `C:\xampp\htdocs\registration_project_fixed`

If it shows something different, that's your problem!

**Example of WRONG location:**
- `C:\Users\YourName\Downloads\registration_project_fixed` ❌
- `C:\xampp\registration_project_fixed` ❌
- `C:\xampp\htdocs\registration_project_fixed\registration_project_fixed` ❌

**CORRECT location:**
- `C:\xampp\htdocs\registration_project_fixed` ✅

---

## 📞 CONTACT INFO IN ERROR MESSAGE

You mentioned you see:
```
Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12
```

**This is good news!** It means:
- ✅ Apache IS running
- ✅ PHP is installed (version 8.2.12)
- ❌ The problem is just the file location/URL

**So the issue is definitely:**
1. Files are in wrong folder, OR
2. You're using wrong URL

Follow STEP 2 and STEP 3 above carefully!

---

## ✅ AFTER FILES ARE IN CORRECT LOCATION

Try these URLs in order:

**Test 1:** `http://localhost/`
- Should show XAMPP dashboard or folder list

**Test 2:** `http://localhost/registration_project_fixed/`
- Should show file list or registration form

**Test 3:** `http://localhost/registration_project_fixed/setup_database.php`
- Should show the database setup page

**Test 4:** Click "Run Database Setup"
- Database gets created

**Test 5:** `http://localhost/registration_project_fixed/index.php`
- Registration form should work!

---

**Good Luck! Follow the steps carefully and it will work! 🎉**
