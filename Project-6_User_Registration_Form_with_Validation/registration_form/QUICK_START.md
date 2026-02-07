# ⚡ QUICK START - 3 Simple Steps

## 🎯 Super Simple Setup (No Database!)

### Step 1: Copy to XAMPP
```
Extract folder → Copy to: C:\xampp\htdocs\
```

### Step 2: Start Apache
```
Open XAMPP Control Panel → Click "Start" next to Apache
```

### Step 3: Open Browser
```
Go to: http://localhost/registration_form/
```

**That's it!** No database setup needed! 🎉

---

## 🎮 How to Use

### Register New User:
1. Fill the form at `http://localhost/registration_form/`
2. Click "Create Account"
3. See success message

### Login:
1. Go to `pages/login.php`  (or click "Login here" link)
2. Enter email/username and password
3. Click "Login"

### View Profile:
- After login, you'll see your dashboard automatically
- All your information displayed nicely
- Account statistics shown

### Logout:
- Click "Logout" button on dashboard
- You're logged out!

---

## 📂 Project Structure (Simple View)

```
registration_form/
├── index.php              ← Main page (start here!)
├── assets/                ← CSS & JavaScript
├── includes/              ← PHP backend files
├── pages/                 ← Login, dashboard, etc.
└── data/                  ← Your user data (JSON)
```

---

## ⚠️ Only 1 Important Thing

**The `data/` folder needs write permission!**

**Windows:**
- Right-click `data` folder
- Properties → Security
- Make sure "Users" can "Modify"

**Linux/Mac:**
```bash
chmod 777 data/
```

---

## 🆘 Troubleshooting

**Can't access the site?**
→ Make sure Apache is running in XAMPP

**CSS not loading?**
→ Press Ctrl+F5 to hard refresh

**Registration not working?**
→ Check `data/` folder permissions

**Can't login?**
→ Make sure you registered first!

---

## 🎯 URLs to Remember

| What | URL |
|------|-----|
| Main page (Register) | `http://localhost/registration_form/` |
| Login | `http://localhost/registration_form/pages/login.php` |
| Dashboard | Automatic after login |

---

## 💡 Pro Tips

1. **Test user data:** Check `data/users.json` to see saved users
2. **Reset data:** Delete content of `users.json` and put `[]`
3. **Customize:** Edit `assets/css/style.css` to change colors
4. **Read more:** Check `README.md` for detailed docs

---

## ✅ Features

✨ User Registration
✨ Secure Login
✨ User Dashboard
✨ Profile Display
✨ Logout Function
✨ No Database Required!
✨ File-based Storage
✨ Password Hashing
✨ Form Validation
✨ Responsive Design

---

**Need more help?** Check `README.md` or `FOLDER_STRUCTURE.md`

**Enjoy your registration system!** 🚀
