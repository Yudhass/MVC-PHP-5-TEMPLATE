# MVC PHP 5 TEMPLATE - Complete Framework

Framework MVC PHP yang **powerful** dan **kompatibel** dengan PHP 5.2, 7, 8 dan versi lebih tinggi. Dilengkapi dengan fitur-fitur modern seperti Query Builder, Security Layer, Validator, Environment Configuration, dan banyak lagi!

[![PHP Version](https://img.shields.io/badge/PHP-5.2%20|%207%20|%208+-777BB4?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)
[![Maintenance](https://img.shields.io/badge/Maintained-Yes-brightgreen.svg?style=flat-square)](https://github.com/Yudhass/MVC-PHP-5-TEMPLATE)

---

## 🎯 Tentang Framework

**MVC PHP 5 TEMPLATE** adalah framework MVC yang dirancang untuk memberikan pengalaman pengembangan modern namun tetap **backward compatible** dengan PHP versi lama. Framework ini cocok untuk:

- ✅ **Legacy Systems**: Update sistem lama tanpa upgrade PHP
- ✅ **Shared Hosting**: Hosting dengan PHP versi rendah
- ✅ **Modern Development**: Fitur-fitur modern dengan syntax yang clean
- ✅ **Learning**: Belajar MVC pattern dan best practices

---

## ✨ Fitur Utama

### 🔧 Fitur Teknis Core

#### 1. **Multi-PHP Compatibility** (PHP 5.2 - 8+)
```php
// Otomatis detect dan gunakan fitur terbaik yang tersedia
- PDO (PHP 5.3+) atau mysql_* (PHP 5.2)
- password_hash() atau bcrypt/SHA-256 fallback
- Exception handling atau error handling legacy
```

#### 2. **Query Builder Laravel-Style**
```php
// Method chaining untuk query kompleks
$users = $userModel
    ->where('status', 'active')
    ->whereIn('role', ['admin', 'manager'])
    ->whereNotNull('verified_at')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

// JOIN operations
$orders = $orderModel
    ->select('orders.*, users.name as user_name')
    ->leftJoin('users', 'orders.user_id', 'users.id')
    ->where('orders.status', 'completed')
    ->get();

// Raw query with bindings
$results = $model->rawQuery(
    "SELECT * FROM users WHERE role = :role AND status = :status",
    ['role' => 'admin', 'status' => 'active']
);
```

#### 3. **Multiple Database Connections**
```php
// Gunakan multiple database dalam satu aplikasi
DatabaseManager::addConnection('TEST2', [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'TEST2',
    'port' => 3306
]);

// Switch connection di model
$model->setConnection('TEST2');
$data = $model->all();

// Atau gunakan helper
$db = db_connection('TEST2');
$results = $db->query("SELECT * FROM employees");
```

#### 4. **10 Layer Security System**

| Layer | Fitur | Implementasi |
|-------|-------|-------------|
| 1️⃣ | **CSRF Protection** | Token validation di semua form |
| 2️⃣ | **XSS Protection** | Auto escape output & sanitization |
| 3️⃣ | **SQL Injection** | Prepared statements & bindings |
| 4️⃣ | **Session Security** | Secure session dengan regeneration |
| 5️⃣ | **Password Hashing** | Bcrypt cost 12 atau SHA-256 salt |
| 6️⃣ | **Rate Limiting** | Prevent brute force attacks |
| 7️⃣ | **Security Headers** | X-Frame, CSP, HSTS, dll |
| 8️⃣ | **File Upload** | MIME & extension validation |
| 9️⃣ | **Path Traversal** | Sanitize file paths |
| 🔟 | **Input Validation** | Comprehensive validator class |

```php
// CSRF Protection
echo Security::csrfField();

// Verify CSRF
if (!Security::verifyCSRFToken($_POST['csrf_token'])) {
    die('Invalid CSRF token');
}

// XSS Protection
echo Security::escape($userInput);

// Password Hashing (auto-detect best method)
$hash = Security::hashPassword($password);
$valid = Security::verifyPassword($password, $hash);

// Rate Limiting
if (!Security::rateLimit('login', 5, 60)) {
    die('Too many attempts');
}

// File Upload Validation
$result = Security::validateFileUpload($_FILES['document'], [
    'max_size' => 5242880, // 5MB
    'allowed_types' => ['jpg', 'png', 'pdf'],
    'allowed_mimes' => ['image/jpeg', 'image/png', 'application/pdf']
]);
```

#### 5. **Laravel-Like Validator**
```php
// Basic validation
$validator = new Validator($data, [
    'name' => 'required|min_length[3]|max_length[50]',
    'email' => 'required|email|unique[users.email]',
    'password' => 'required|min_length[8]|confirmed',
    'age' => 'required|integer|min[18]|max[100]',
    'role' => 'required|in[admin,user,manager]',
    'website' => 'url',
    'phone' => 'regex[/^[0-9]{10,15}$/]'
]);

if ($validator->fails()) {
    $errors = $validator->getErrors();
    // ['email' => ['Email sudah digunakan'], ...]
}

// Helper function
validate($data, $rules, $messages, $redirectUrl);

// Quick check
if (is_valid($data, $rules)) {
    // Process data
}
```

**Validation Rules Tersedia:**
- `required`, `email`, `url`, `ip`, `date`
- `min_length[n]`, `max_length[n]`, `min[n]`, `max[n]`
- `numeric`, `integer`, `alpha`, `alpha_numeric`, `alpha_dash`
- `same[field]`, `different[field]`, `match[field]`, `confirmed`
- `in[val1,val2]`, `not_in[val1,val2]`
- `unique[table.column,id_field,id_value]`
- `exists[table.column]`
- `before[date]`, `after[date]`
- `regex[pattern]`

#### 6. **Environment Configuration (.env)**
```env
# Database Configuration
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=crudtest
DB_PORT=3306

# Secondary Database (Optional)
DB_TEST2_HOST=localhost
DB_TEST2_USER=root
DB_TEST2_PASS=
DB_TEST2_NAME=db_TEST2
DB_TEST2_PORT=3306

# Application Configuration
APP_NAME=MVC-PHP-5-TEMPLATE
APP_ENV=development
APP_DEBUG=true
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# Security Configuration
CSRF_ENABLED=true
CSRF_EXPIRE=1800
RATE_LIMIT_ENABLED=true
RATE_LIMIT_MAX_ATTEMPTS=5
RATE_LIMIT_TIME_WINDOW=60
SESSION_LIFETIME=7200
SESSION_REGENERATE_INTERVAL=1800

# Password Policy
PASSWORD_MIN_LENGTH=8
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBER=true
PASSWORD_REQUIRE_SPECIAL=false
```

```php
// Akses environment variable
$dbHost = env('DB_HOST', 'localhost');
$appName = env('APP_NAME', 'MyApp');
$debug = env('APP_DEBUG', false); // auto convert to boolean
```

#### 7. **Middleware System**
```php
// Define routes dengan middleware
$router->get('/admin/dashboard', 'AdminController@index', ['auth', 'role:admin']);
$router->get('/profile', 'UserController@profile', ['auth']);
$router->get('/login', 'AuthController@login', ['guest']);

// Buat middleware sendiri
class CustomMiddleware extends Middleware {
    public function handle() {
        if (!$this->checkCondition()) {
            $this->redirect('error', 'Access denied', 'error');
            return false;
        }
        return true;
    }
}
```

**Built-in Middleware:**
- `AuthMiddleware`: Cek user sudah login
- `GuestMiddleware`: Cek user belum login (untuk halaman login/register)
- `RoleMiddleware`: Cek role user (`role:admin,manager`)

#### 8. **Helper Functions**
```php
// Debug helpers
dd($var1, $var2, $var3);           // Dump and die dengan UI cantik
dump($data);                        // Dump tanpa die

// Session helpers
setSession('user', $userData);
$user = getSession('user');
Auth();                             // Get current user object

// Flash messages
setFlashMessage('Success!', 'success');
$flash = getFlashMessage();
displayFlashMessage();              // Auto generate HTML

// Validation helpers
$validator = validator($data, $rules, $messages);
validate($data, $rules);            // Auto redirect on fail
if (is_valid($data, $rules)) { }

// Database helpers
$db = db();                         // Default connection
$db = db_connection('TEST2');   // Named connection
db_query($sql, $params, 'TEST2');

// Security helpers (via Security class)
Security::escape($input);
Security::csrfField();
Security::hashPassword($pass);
Security::sanitize($input, 'email');
```

#### 9. **Error Handling & Debugging**
```php
// Beautiful error pages dengan stack trace
- PHP Errors (Notice, Warning, Fatal)
- Uncaught Exceptions
- 404 Not Found (Route, Controller, Method, View)
- 500 Internal Server Error

// Custom error handler dengan informasi lengkap:
- Error type & message
- File & line number
- Stack trace dengan syntax highlighting
- Request info (Method, URI, Headers)
- PHP version & environment info
```

---

## 📁 Struktur Folder

```
MVC-PHP-5-TEMPLATE/
├── .env                             # Environment configuration (JANGAN commit!)
├── .env.example                     # Environment template
├── .gitignore
├── .htaccess                        # Apache rewrite rules
├── README.md                        # Dokumentasi ini
├── README_COMPLETE.md               # Dokumentasi lengkap
├── app/
│   ├── init.php                     # Application initializer
│   ├── controllers/                 # Controllers
│   │   ├── HomeController.php
│   │   └── AuthController.php
│   ├── core/                        # Core framework files
│   │   ├── App.php                  # Application core
│   │   ├── Router.php               # Routing system
│   │   ├── Controller.php           # Base controller
│   │   ├── Model.php                # Base model dengan Query Builder
│   │   ├── Database.php             # Database connection (PDO/mysql_*)
│   │   ├── DatabaseManager.php      # Multi database manager
│   │   ├── Middleware.php           # Base middleware
│   │   ├── Security.php             # 10 Layer Security
│   │   ├── Validator.php            # Laravel-like validator
│   │   ├── Helper.php               # Helper functions
│   │   ├── Config.php               # Configuration loader
│   │   ├── Env.php                  # Environment loader
│   │   └── View.php                 # View renderer (reserved)
│   ├── database/                    # Database files
│   │   └── migrations/              # Migration files
│   ├── middlewares/                 # Middleware classes
│   │   ├── AuthMiddleware.php
│   │   ├── GuestMiddleware.php
│   │   └── RoleMiddleware.php
│   ├── models/                      # Model classes
│   │   └── User.php
│   ├── routes/                      # Route definitions
│   │   └── routes.php
│   └── views/                       # View files
│       ├── home.php
│       ├── auth/
│       ├── components/
│       ├── errors/
│       └── layouts/
├── public/                          # Public web root
│   ├── index.php                    # Entry point
│   └── assets/
│       ├── css/
│       ├── js/
│       └── img/
├── storage/                         # Storage files
│   ├── cache/
│   └── logs/
├── _DEV/                            # Development files
│   ├── DOKUMENTASI_*.md             # Various documentation
│   └── test_*.php                   # Test files
└── release/                         # Release packages
```

---

## 🚀 Quick Start

### 1. Installation

#### Via Git Clone
```bash
git clone https://github.com/Yudhass/MVC-PHP-5-TEMPLATE.git
cd MVC-PHP-5-TEMPLATE
```

#### Via Download
1. Download ZIP dari GitHub
2. Extract ke folder `htdocs/` (XAMPP) atau `www/` (WAMP)

### 2. Configuration

```bash
# Copy .env.example menjadi .env
copy .env.example .env    # Windows
cp .env.example .env      # Linux/Mac

# Edit .env sesuai environment Anda
notepad .env              # Windows
nano .env                 # Linux/Mac
```

**Minimal Configuration:**
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=your_database_name
DB_PORT=3306

FOLDER_PROJECT=MVC-PHP-5-TEMPLATE
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/
```

### 3. Database Setup

```sql
CREATE DATABASE your_database_name;
USE your_database_name;

-- Import your SQL file atau gunakan migration
```

### 4. Running the Application

#### XAMPP/WAMP/LAMP
```
Akses: http://localhost/MVC-PHP-5-TEMPLATE/
```

#### PHP Built-in Server
```bash
php -S localhost:8000 -t public
# Akses: http://localhost:8000
```

---

## 📚 Dokumentasi Lengkap

Lihat file [README_COMPLETE.md](README_COMPLETE.md) untuk dokumentasi lengkap tentang:

- Query Builder Advanced
- Security Best Practices
- Multiple Database Implementation
- CRUD Examples
- Authentication Examples
- Middleware System
- dan masih banyak lagi...

---

## 🎓 Ringkasan Fitur yang Diterapkan dari SILAU

### Core System Files ✅
- ✅ `App.php` - Complete error handling & middleware execution
- ✅ `Router.php` - Routing dengan middleware support
- ✅ `Controller.php` - Base controller dengan helper methods
- ✅ `Model.php` - Query Builder lengkap (WHERE IN, NOT IN, JOIN, RAW Query, dll)
- ✅ `Database.php` - Multi-PHP version support (PDO & mysql_*)
- ✅ `DatabaseManager.php` - Multiple database connections
- ✅ `Config.php` - Environment-based configuration
- ✅ `Env.php` - .env file parser
- ✅ `Helper.php` - 40+ helper functions
- ✅ `Middleware.php` - Base middleware class
- ✅ `Security.php` - 10 Layer security system
- ✅ `Validator.php` - 30+ validation rules

### Query Builder Methods ✅
- ✅ `where()`, `orWhere()` - Basic WHERE clauses
- ✅ `whereIn()`, `whereNotIn()` - IN & NOT IN clauses
- ✅ `whereNull()`, `whereNotNull()` - NULL checks
- ✅ `whereNotEqual()` - NOT EQUAL comparison
- ✅ `join()`, `leftJoin()`, `rightJoin()` - JOIN operations
- ✅ `select()` - Custom SELECT columns
- ✅ `orderBy()` - ORDER BY clause
- ✅ `limit()` - LIMIT & OFFSET
- ✅ `rawQuery()`, `rawQueryFirst()` - Raw SQL with bindings
- ✅ `first()`, `get()` - Execute query

### Security Features ✅
- ✅ CSRF Protection with token generation & verification
- ✅ XSS Protection with auto-escape
- ✅ SQL Injection Prevention with prepared statements
- ✅ Password Hashing (Bcrypt cost 12 atau SHA-256 fallback)
- ✅ Session Security dengan regeneration
- ✅ Rate Limiting untuk prevent brute force
- ✅ Security Headers (X-Frame, CSP, HSTS)
- ✅ File Upload Validation (MIME type & extension)
- ✅ Path Traversal Protection
- ✅ Input Sanitization

### Helper Functions ✅
- ✅ Debug: `dd()`, `dump()`
- ✅ Session: `setSession()`, `getSession()`, `Auth()`
- ✅ Flash Messages: `setFlashMessage()`, `getFlashMessage()`, `displayFlashMessage()`
- ✅ Validation: `validator()`, `validate()`, `is_valid()`
- ✅ Database: `db()`, `db_connection()`, `db_query()`
- ✅ Security: Semua via Security class

### Middleware System ✅
- ✅ `AuthMiddleware` - Check user login
- ✅ `GuestMiddleware` - Check user not logged in
- ✅ `RoleMiddleware` - Check user role with parameters

### Configuration System ✅
- ✅ `.env` file support untuk semua konfigurasi
- ✅ Environment variable parser dengan type conversion
- ✅ Multiple database configuration
- ✅ Security settings
- ✅ Application settings

### Error Handling ✅
- ✅ Beautiful error pages dengan debugging info
- ✅ Stack trace visualization
- ✅ PHP Error handler (Notice, Warning, Fatal)
- ✅ Exception handler
- ✅ 404 & 500 error pages

---

## 📝 Changelog

### Version 2.0.0 (Latest) - Complete Framework from SILAU
- ✅ **Complete Query Builder**: WHERE IN, NOT IN, NULL, NOT NULL, JOIN, RAW Query
- ✅ **10 Layer Security System**: CSRF, XSS, SQL Injection, dll
- ✅ **Laravel-like Validator**: 30+ validation rules
- ✅ **Multiple Database Support**: DatabaseManager untuk multi connection
- ✅ **Environment Configuration**: .env file support
- ✅ **Middleware System**: Auth, Guest, Role middleware
- ✅ **Helper Functions**: 40+ helper functions
- ✅ **Error Handling**: Beautiful error pages dengan debugging info
- ✅ **Migration System**: Database migration support
- ✅ **PHP 5.2 to 8+ Compatible**: Auto-detection best features

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Yudhass**

- GitHub: [@Yudhass](https://github.com/Yudhass)
- Repository: [MVC-PHP-5-TEMPLATE](https://github.com/Yudhass/MVC-PHP-5-TEMPLATE)

---

## ⭐ Star This Repository

Jika framework ini membantu project Anda, mohon berikan ⭐ di GitHub!

---

**Happy Coding! 🚀**
