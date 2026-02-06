# Registration Form - Organized Project

A well-structured PHP registration system with clean folder organization.

## 📁 Project Structure

```
registration_form_organized/
├── public/              # Entry point
│   └── index.php
├── assets/              # Static files
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
├── pages/               # Application pages
│   ├── register.php
│   ├── login.php
│   ├── dashboard.php
│   ├── view_users.php
│   ├── success.php
│   ├── terms.php
│   └── privacy.php
├── includes/            # Backend scripts
│   ├── helpers.php
│   ├── process_login.php
│   └── logout.php
├── config/              # Configuration
│   └── config.php
└── docs/                # Documentation
    ├── README.md
    └── SETUP_GUIDE.md
```

## 🚀 Quick Start

1. **Extract the project** to your web server directory

2. **Update paths in PHP files:**
   - Add at top of each page: `require_once '../config/config.php';`
   - Update CSS link: `<link rel="stylesheet" href="../assets/css/style.css">`
   - Update JS link: `<script src="../assets/js/script.js"></script>`

3. **Start development server:**
   ```bash
   cd registration_form_organized/public
   php -S localhost:8000
   ```

4. **Access:** http://localhost:8000/index.php

## 🔧 Path Updates Required

### In public/index.php:
```php
<?php require_once __DIR__ . '/../config/config.php'; ?>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
<form action="../pages/register.php" method="POST">
```

### In pages/*.php:
```php
<?php require_once __DIR__ . '/../config/config.php'; ?>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
```

### In includes/process_login.php:
```php
<?php
require_once __DIR__ . '/../config/config.php';
header('Location: ../pages/dashboard.php');
```

## 📝 Features

- User registration with validation
- Secure login system
- Password strength checking
- Session-based authentication
- Clean folder structure
- Helper functions included

## 🔒 Security

- .htaccess files protect config and includes folders
- CSRF token validation
- Input sanitization
- Session security settings

## 📚 Documentation

See `docs/SETUP_GUIDE.md` for detailed setup instructions.

---

**Version:** 1.0.0
**Last Updated:** February 2026
