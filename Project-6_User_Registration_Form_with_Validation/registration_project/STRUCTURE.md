# Project File Structure

```
registration_form_organized/
│
├── 📄 README.md                    # Main documentation
├── 📄 .gitignore                   # Git ignore file
│
├── 📂 public/                      # 🌐 Entry Point
│   └── index.php                   # Main landing page
│
├── 📂 assets/                      # 🎨 Static Resources
│   ├── css/
│   │   └── style.css              # Stylesheet
│   └── js/
│       └── script.js              # JavaScript
│
├── 📂 pages/                       # 📄 Application Pages
│   ├── register.php               # Registration page
│   ├── login.php                  # Login page
│   ├── dashboard.php              # User dashboard
│   ├── view_users.php             # View users
│   ├── success.php                # Success page
│   ├── terms.php                  # Terms & conditions
│   └── privacy.php                # Privacy policy
│
├── 📂 includes/                    # ⚙️ Backend Scripts
│   ├── .htaccess                  # Security file
│   ├── helpers.php                # Utility functions
│   ├── process_login.php          # Login handler
│   └── logout.php                 # Logout handler
│
├── 📂 config/                      # 🔧 Configuration
│   ├── .htaccess                  # Security file
│   └── config.php                 # Main config
│
└── 📂 docs/                        # 📚 Documentation
    ├── README.md                   # Original docs
    └── SETUP_GUIDE.md             # Setup instructions
```

## 📊 File Count

- Public Files: 1
- Assets: 2 (1 CSS + 1 JS)
- Pages: 7
- Includes: 3
- Config: 1
- Docs: 2
- Security: 3
- **Total: 19 files**

## 🎯 Quick Reference

### Path from public/index.php:
- Pages: `../pages/filename.php`
- CSS: `../assets/css/style.css`
- JS: `../assets/js/script.js`

### Path from pages/*.php:
- Other pages: `filename.php` (same folder)
- Includes: `../includes/filename.php`
- Assets: `../assets/css/style.css`

### Path from includes/*.php:
- Pages: `../pages/filename.php`
- Config: `../config/config.php`
