# 🔧 FIX: "Unknown database 'registration_db'" Error

## ⚡ QUICK FIX (Easiest Method)

### Step 1: Make sure MySQL is running
- **XAMPP Users:** Open XAMPP Control Panel → MySQL should be GREEN
- **WAMP Users:** WAMP icon should be GREEN in system tray

### Step 2: Run the automatic setup script
1. Open your browser
2. Go to: `http://localhost/registration_project_fixed/setup_database.php`
3. Click the "🚀 Run Database Setup" button
4. Wait for success message
5. Click "Go to Registration Form"

**Done!** Your database is now created and ready to use.

---

## 📋 MANUAL FIX (If automatic doesn't work)

### Method 1: Using phpMyAdmin (Recommended)

**Step 1:** Open phpMyAdmin
- Go to: `http://localhost/phpmyadmin`
- Login if required (usually no password for XAMPP)

**Step 2:** Create the database
- Click "**New**" in the left sidebar
- Database name: `registration_db`
- Collation: `utf8mb4_general_ci` (or leave default)
- Click "**Create**"

**Step 3:** Import the SQL file
- Click on `registration_db` database (in left sidebar)
- Click "**Import**" tab (top menu)
- Click "**Choose File**" button
- Select `database_setup.sql` from the project folder
- Click "**Go**" button at the bottom
- Wait for success message

**Step 4:** Verify
- You should see tables: `users` and `activity_log`
- Click on `users` table to view structure

**Done!** Now try registering a user.

---

### Method 2: Using MySQL Command Line

**Step 1:** Open MySQL command line
- **Windows XAMPP:** `C:\xampp\mysql\bin\mysql.exe -u root`
- **Windows WAMP:** From WAMP menu → MySQL Console
- **Linux/Mac:** Open terminal and type: `mysql -u root -p`

**Step 2:** Run these commands

```sql
-- Create the database
CREATE DATABASE registration_db;

-- Select the database
USE registration_db;

-- Create users table
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) DEFAULT NULL,
    date_of_birth DATE DEFAULT NULL,
    gender ENUM('Male','Female','Other') DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create activity_log table
CREATE TABLE activity_log (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    action VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY user_id (user_id),
    CONSTRAINT activity_log_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Verify tables were created
SHOW TABLES;

-- Exit
EXIT;
```

**Step 3:** Verify
- You should see: `users` and `activity_log` tables
- Type `EXIT;` to close MySQL console

**Done!** Database is ready.

---

### Method 3: Import SQL file via Command Line

**Step 1:** Open command prompt/terminal

**Step 2:** Navigate to project folder
```bash
cd C:\xampp\htdocs\registration_project_fixed
# OR
cd /var/www/html/registration_project_fixed
```

**Step 3:** Run import command
```bash
# Windows XAMPP
C:\xampp\mysql\bin\mysql.exe -u root < database_setup.sql

# Linux/Mac
mysql -u root -p < database_setup.sql
```

**Done!**

---

## ✅ Verify Database is Created

### Quick Check:
1. Go to: `http://localhost/registration_project_fixed/test_connection.php`
2. You should see all green checkmarks ✅
3. If not, see error messages for solutions

### Manual Check via phpMyAdmin:
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Look in left sidebar
3. You should see `registration_db`
4. Click on it
5. You should see 2 tables: `users` and `activity_log`

### Manual Check via MySQL Command:
```sql
mysql -u root -p
SHOW DATABASES;
-- You should see 'registration_db' in the list

USE registration_db;
SHOW TABLES;
-- You should see 'users' and 'activity_log'

DESCRIBE users;
-- You should see the table structure

EXIT;
```

---

## 🐛 Still Having Issues?

### Issue: "Access denied for user 'root'"
**Cause:** MySQL password is set but config.php has it empty

**Solution:** Edit `config.php`:
```php
define('DB_PASS', 'your_mysql_password');  // Add your password here
```

---

### Issue: "Can't connect to MySQL server"
**Cause:** MySQL is not running

**Solution:**
- **XAMPP:** Open Control Panel → Start MySQL (should turn green)
- **WAMP:** Make sure WAMP is running (green icon)
- Check if port 3306 is free: `netstat -ano | findstr :3306`

---

### Issue: phpMyAdmin won't open
**Cause:** Apache or MySQL not running

**Solution:**
1. Start both Apache AND MySQL in XAMPP/WAMP
2. Both should show GREEN
3. Try accessing: `http://localhost/phpmyadmin`

---

### Issue: Import SQL file shows errors
**Cause:** Database might already exist with errors

**Solution:**
1. Drop the database first: `DROP DATABASE IF EXISTS registration_db;`
2. Then import the SQL file again
3. Or use the automatic setup script: `setup_database.php`

---

## 📞 Quick Support Checklist

Before asking for help, verify:
- [ ] MySQL is running (green in XAMPP/WAMP)
- [ ] Can access phpMyAdmin (`http://localhost/phpmyadmin`)
- [ ] Database `registration_db` exists
- [ ] Tables `users` and `activity_log` exist
- [ ] Config.php has correct credentials
- [ ] Ran `test_connection.php` to see specific errors

---

## 🎯 After Database is Set Up

1. Go to: `http://localhost/registration_project_fixed/`
2. Fill in the registration form
3. Use this test data:
   - Username: `testuser123`
   - Email: `test@example.com`
   - Password: `TestPass123`
   - Full Name: `Test User`
   - Phone: `9876543210`
   - Check "Terms and Conditions"
4. Click "Create Account"
5. Should show success page!

---

**Still stuck? Run the automatic setup: `setup_database.php`**

This is the easiest and most reliable method!
