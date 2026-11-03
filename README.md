# Django Girls Sierra Leone — PHP Authentication & User Dashboard

A modern, secure, and lightweight web portal and authentication system built with native PHP and SQLite for the **Django Girls Sierra Leone** community chapter.

This project delivers complete user authentication, session-based access control, responsive UI with modern CSS aesthetics, and an interactive member dashboard without requiring external database server configuration.

---

## 🚀 Features

- **🎨 Modern Responsive Landing Page (`index.php`)**:
  - Hero banner with Chapter branding and visual accents.
  - Automatic redirect for already-authenticated users directly to their dashboard.

- **📝 Secure User Registration (`signup.php`)**:
  - Full input validation (name, unique username, valid email, password length).
  - Password confirmation check.
  - Safe password storage using `password_hash()` with `PASSWORD_DEFAULT` (Bcrypt).
  - Duplicate email and username prevention.

- **🔐 User Authentication (`login.php`)**:
  - Multi-identifier login: users can log in with either their **username** or **email address**.
  - Secure credential verification via `password_verify()`.
  - Session fixation protection with `session_regenerate_id(true)`.
  - One-time flash messaging upon successful registration.

- **📊 Protected User Dashboard (`dashboard.php`)**:
  - Route guard requiring active login (`requireLogin()`).
  - Personalized welcome banner and user avatar initial.
  - Account metrics: Member Since date, Days as a Member counter, and Account Status.
  - Detailed profile overview (Full Name, Username, Email, User ID).

- **🚪 Secure Logout (`logout.php`)**:
  - Complete session wipe (`$_SESSION = []`).
  - Explicit session cookie invalidation.
  - Server-side session destruction (`session_destroy()`).

---

## 🔒 Security Best Practices

| Security Area | Implementation |
| :--- | :--- |
| **Password Storage** | Bcrypt hashing via `password_hash($password, PASSWORD_DEFAULT)` |
| **SQL Injection** | 100% prepared statements with parameterized inputs via PHP PDO |
| **Cross-Site Scripting (XSS)** | String sanitization and contextual escaping with `htmlspecialchars()` |
| **Session Security** | `session_regenerate_id(true)` on login; complete cookie invalidation on logout |
| **Access Control** | Server-side auth guards: `requireLogin()` and `requireGuest()` |
| **Zero-Config Database** | Portable SQLite database (`data/users.db`) automatically created with safe permissions |

---

## 📁 Project Structure

```text
PHP dashboard/
│
├── assets/
│   ├── Djangogirls-logo.png     # Alternative chapter logo
│   ├── django_girls_logo.jpg    # Main banner & header logo
│   └── style.css                # Custom modern styles, animations & responsive grid
│
├── config/
│   ├── database.php             # SQLite PDO connection & auto-table migration
│   └── session.php              # Session management, auth guards & flash messages
│
├── data/
│   └── users.db                 # SQLite database file (auto-generated on first run)
│
├── partials/
│   ├── header.php               # Shared navigation & page header
│   └── footer.php               # Shared footer with project & student credits
│
├── dashboard.php                # Protected member dashboard
├── index.php                    # Public landing / home page
├── login.php                    # User sign-in page
├── logout.php                   # Secure session termination script
├── signup.php                   # User registration page
└── README.md                    # Project documentation
```

---

## 🗄️ Database Schema

The application uses **SQLite** through PHP's `PDO` driver. The database and table are created automatically on the first database connection (`config/database.php`), meaning no manual SQL import or MySQL setup is needed.

### `users` Table
```sql
CREATE TABLE IF NOT EXISTS users (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    username   TEXT    NOT NULL UNIQUE,
    email      TEXT    NOT NULL UNIQUE,
    password   TEXT    NOT NULL,
    full_name  TEXT    NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🛠️ Requirements

- **PHP**: Version 7.4 or 8.x
- **PHP Extensions**:
  - `pdo`
  - `pdo_sqlite`
  - `mbstring`
- **Web Browser**: Any modern browser (Chrome, Edge, Firefox, Safari)

> [!NOTE]
> SQLite support (`pdo_sqlite`) is enabled by default in standard PHP installations and XAMPP/WAMP/Laragon bundles.

---

## ⚡ Quick Start & Running Locally

### Option 1: PHP Built-in Development Server (Recommended)

1. Open your terminal or PowerShell in the project directory:
   ```bash
   cd "path/to/PHP dashboard"
   ```

2. Start the built-in PHP web server:
   ```bash
   php -S localhost:8000
   ```

3. Open your browser and navigate to:
   ```text
   http://localhost:8000
   ```

### Option 2: Using XAMPP / WAMP / Laragon

1. Move or copy the `PHP dashboard` folder into your local web root:
   - **XAMPP**: `C:\xampp\htdocs\php-dashboard`
   - **WAMP**: `C:\wamp64\www\php-dashboard`
   - **Laragon**: `C:\laragon\www\php-dashboard`
2. Start the **Apache** server from your control panel.
3. Visit `http://localhost/php-dashboard` in your browser.

---

## 🧑‍💻 Student Information

- **Student Name**: Osman Kawusu Momoh
- **Student ID**: 905004351
- **Programme**: BSEM
- **Semester**: 05
- **Year**: Year 3

---

## 📜 License & Acknowledgments

- Built for the **Django Girls Sierra Leone** community initiative to inspire and empower women in technology and web development.

