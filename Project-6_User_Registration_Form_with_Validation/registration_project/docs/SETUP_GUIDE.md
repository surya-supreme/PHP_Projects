# Setup Guide - Registration Form Project

## 📋 Complete Setup Instructions

### Step 1: Extract Project

Extract the zip file to your web server directory (htdocs, www, or public_html).

### Step 2: Understand the Structure

Your files are now organized:
- **public/** - Contains index.php (entry point)
- **assets/** - Contains CSS and JavaScript files
- **pages/** - Contains all page files (register, login, dashboard, etc.)
- **includes/** - Contains backend processing files
- **config/** - Contains configuration files

### Step 3: Update File Paths

You need to update paths in your PHP files since files have moved to new folders.

#### A. Update public/index.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS link (find this line):**
```php
<!-- OLD -->
<link rel="stylesheet" href="style.css">

<!-- Change to -->
<link rel="stylesheet" href="../assets/css/style.css">
```

**Update JavaScript link:**
```php
<!-- OLD -->
<script src="script.js"></script>

<!-- Change to -->
<script src="../assets/js/script.js"></script>
```

**Update form action:**
```php
<!-- OLD -->
<form action="register.php" method="POST">

<!-- Change to -->
<form action="../pages/register.php" method="POST">
```

**Update links:**
```php
<!-- OLD -->
<a href="login.php">Login here</a>
<a href="view_users.php">View Registered Users</a>

<!-- Change to -->
<a href="../pages/login.php">Login here</a>
<a href="../pages/view_users.php">View Registered Users</a>
```

#### B. Update pages/register.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update redirects (find header Location lines):**
```php
<!-- OLD -->
header('Location: success.php');

<!-- Change to -->
header('Location: success.php');  // Same folder, no change needed
```

**Update links:**
```php
<!-- OLD -->
<a href="login.php">Login</a>

<!-- Change to -->
<a href="login.php">  // Same folder, no change
```

#### C. Update pages/login.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS and JS:**
```php
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
```

**Update form action:**
```php
<!-- OLD -->
<form action="process_login.php" method="POST">

<!-- Change to -->
<form action="../includes/process_login.php" method="POST">
```

#### D. Update pages/dashboard.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS and JS:**
```php
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
```

**Update logout link:**
```php
<!-- OLD -->
<a href="logout.php">Logout</a>

<!-- Change to -->
<a href="../includes/logout.php">Logout</a>
```

#### E. Update pages/view_users.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS and JS:**
```php
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
```

#### F. Update pages/success.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS and JS:**
```php
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
```

#### G. Update pages/terms.php and pages/privacy.php

**Add at the very top of both files:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update CSS:**
```php
<link rel="stylesheet" href="../assets/css/style.css">
```

#### H. Update includes/process_login.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update redirect:**
```php
<!-- OLD -->
header('Location: dashboard.php');

<!-- Change to -->
header('Location: ../pages/dashboard.php');
```

#### I. Update includes/logout.php

**Add at the very top:**
```php
<?php
require_once __DIR__ . '/../config/config.php';
?>
```

**Update redirect:**
```php
<!-- OLD -->
header('Location: login.php');

<!-- Change to -->
header('Location: ../pages/login.php');
```

### Step 4: Test Your Application

1. Start your web server (XAMPP, WAMP, MAMP, or PHP built-in server)

2. Using PHP built-in server:
   ```bash
   cd registration_form_organized/public
   php -S localhost:8000
   ```

3. Open browser: http://localhost:8000/index.php

4. Test these functions:
   - Registration form
   - Login
   - Dashboard access
   - View users
   - Logout

### Step 5: Common Issues

**Issue: Page shows without styling**
- Check CSS path in your HTML
- Should be: `../assets/css/style.css` from pages folder

**Issue: Form doesn't submit**
- Check form action path
- From public folder: `../pages/register.php`
- From pages folder to includes: `../includes/process_login.php`

**Issue: Redirect errors**
- Update all `header('Location: ...')` with correct paths
- From includes to pages: `../pages/filename.php`

### Step 6: Path Reference Chart

| From | To | Path |
|------|-----|------|
| public/index.php | pages/register.php | ../pages/register.php |
| public/index.php | assets/css/style.css | ../assets/css/style.css |
| pages/login.php | includes/process_login.php | ../includes/process_login.php |
| pages/dashboard.php | includes/logout.php | ../includes/logout.php |
| pages/any.php | assets/css/style.css | ../assets/css/style.css |
| includes/process_login.php | pages/dashboard.php | ../pages/dashboard.php |

### Step 7: Security (Optional but Recommended)

The project includes `.htaccess` files to protect config and includes folders.

Make sure your Apache has mod_rewrite enabled.

### Need Help?

- Check README.md for overview
- Review config/config.php for path constants
- Use helper functions in includes/helpers.php

---

✅ **After completing these steps, your application will be fully functional!**
