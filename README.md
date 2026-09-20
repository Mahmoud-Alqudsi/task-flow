# 📋 TaskFlow — Task Management System

> A complete, production-ready task management system built from scratch using **raw PHP 8.4** and **MySQL** — no frameworks, no shortcuts.
>
> An educational project demonstrating how to build a secure, well-documented web application following MVC architecture and industry best practices.

## ✨ Features

- 🔐 **Secure Authentication**: User registration, login, logout with session management
- 📋 **Full CRUD Operations**: Create, read, update, and delete tasks
- 🏷️ **Category System**: Many-to-Many relationships between tasks and categories
- 🔍 **Advanced Search**: Filter by status, priority, and text search
- 📄 **Smart Pagination**: Pagination that preserves active filters
- 📊 **Live Dashboard**: Real-time statistics with completion rates
- 🛡️ **Multi-layer Security**: Protection against SQL Injection, XSS, and CSRF
- 👥 **Role-based Access Control**: Admin sees all tasks, users see only their own
- 📱 **Responsive Design**: Works seamlessly on all devices
- 🎨 **Modern UI**: Clean design with glassmorphism effects

## 🛠️ Technologies Used

| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | 8.4+ | Core programming language |
| MySQL | 8.0+ | Relational database |
| PDO | Built-in | Secure database access |
| Git | 2.x+ | Version control |
| Composer | 2.x+ | Autoloading (PSR-4) |

## 📦 Installation

### Prerequisites
- PHP 8.4 or higher
- MySQL 8.0 or higher
- Composer (latest version)
- Git

### Setup Steps

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/task-flow.git
cd task-flow

# 2. Install dependencies (generates autoloader)
composer install

# 3. Configure environment
copy .env.example .env
# Edit .env with your local database credentials

# 4. Set up the database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS task_flow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root task_flow < database/schema.sql
mysql -u root task_flow < database/seed.sql

# 5. Start the development server
composer serve
```

### 6. Access the Application

Open your browser and navigate to: [http://localhost:8080](http://localhost:8080)

### Demo Accounts

| Email | Password | Role |
|-------|----------|------|
| ahmed@example.com | password | Admin |
| sara@example.com | password | User |

## 📂 Project Structure

```
task-flow/
├── public/              ← Front Controller (entry point)
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── src/                 ← Application logic
│   ├── Controllers/     ← Request handlers
│   ├── Models/          ← Data entities (User, Task, Category)
│   ├── Enums/           ← Typed constants
│   ├── Repositories/    ← Database access layer
│   ├── Middleware/      ← Route protection
│   ├── Security/        ← CSRF protection
│   ├── Database.php     ← Singleton PDO connection
│   └── Router.php       ← Advanced routing system
├── views/               ← HTML templates
├── database/            ← SQL schema & seed data
├── docs/                ← Documentation
├── .env.example         ← Environment template
├── composer.json
├── README.md
└── LICENSE
```

## 🔐 Security Layers

This project implements multiple layers of protection:

- ✅ **Prepared Statements** for all database queries (prevents SQL Injection)
- ✅ **`password_hash()` with Argon2id** for password storage
- ✅ **CSRF Tokens** on every POST form
- ✅ **`htmlspecialchars()`** on all user-generated output (prevents XSS)
- ✅ **Session regeneration** after login (prevents Session Fixation)
- ✅ **Hidden error messages** in production environments
- ✅ **Generic error messages** to prevent user enumeration

## 📖 Documentation

- [Architecture Overview](docs/ARCHITECTURE.md)
- [Security Policy](docs/SECURITY.md)
- [API Routes](docs/API.md)

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to open an issue or submit a pull request.

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

**Built with dedication and attention to detail by The Emperor.** 🚀