# 🔒 SECURITY FEATURES SUMMARY

## Fitur Keamanan yang Tersedia

Template MVC PHP ini dilengkapi dengan **10 layer keamanan** yang komprehensif untuk melindungi aplikasi dari berbagai jenis serangan:

### 1. 🛡️ CSRF Protection
- Token unik untuk setiap form submission
- Mencegah Cross-Site Request Forgery attacks
- Helper functions: `csrf_field()`, `verify_csrf()`

### 2. 🔐 XSS Protection  
- Output escaping otomatis
- Sanitasi HTML content
- Helper functions: `esc()`, `e()`, `sanitize()`

### 3. ✅ Input Validation & Sanitization
- Validasi email, URL, numeric, string
- Sanitasi semua user input
- Support min/max length, regex pattern
- Helper functions: `validate()`, `sanitize()`

### 4. 🔑 Password Security
- Password hashing dengan bcrypt/argon2
- Kompatibel PHP 5.2+ (auto-fallback)
- Password policy enforcement
- Helper functions: `hash_password()`, `verify_password()`

### 5. 🍪 Session Security
- Secure session configuration
- Session regeneration
- Session timeout handling
- HTTPOnly & SameSite cookies

### 6. 🚦 Rate Limiting
- Mencegah brute force attacks
- Configurable max attempts & time window
- Per-action rate limiting
- Helper function: `rate_limit()`

### 7. 📁 File Upload Security
- File type validation (MIME type)
- File size limit
- Safe filename generation
- Path traversal protection

### 8. 🔒 Security Headers
- X-Frame-Options (Clickjacking protection)
- X-Content-Type-Options (MIME sniffing)
- Content-Security-Policy (CSP)
- Strict-Transport-Security (HSTS)
- X-XSS-Protection

### 9. 💉 SQL Injection Protection
- Prepared statements (PDO)
- Parameterized queries
- Auto-escaping (mysql_* fallback)
- No raw SQL concatenation

### 10. 📂 Path Traversal Protection
- File path validation
- Prevention of `../` attacks
- Helper function: `Security::isPathTraversal()`

---

## 🎯 Quick Start Security

### 1. Aktifkan Fitur Keamanan di `.env`:

```env
# CSRF Protection
CSRF_ENABLED=true
CSRF_EXPIRE=3600

# Rate Limiting
RATE_LIMIT_ENABLED=true
RATE_LIMIT_MAX_ATTEMPTS=5
RATE_LIMIT_TIME_WINDOW=300

# Password Policy
PASSWORD_MIN_LENGTH=8
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBER=true
PASSWORD_REQUIRE_SPECIAL=true

# Session Security
SESSION_SECURE=false
SESSION_HTTPONLY=true
SESSION_SAMESITE=Lax
SESSION_LIFETIME=3600

# Security Headers
SECURITY_HEADERS_ENABLED=true
```

### 2. Tambahkan CSRF di Form (View):

```php
<form method="POST" action="<?php echo BASEURL; ?>home/add_data">
    <?php echo csrf_field(); ?>
    
    <input type="text" name="nama" required>
    <button type="submit">Submit</button>
</form>
```

### 3. Verifikasi CSRF di Controller:

```php
public function add_data() 
{
    // CSRF Protection
    if (CSRF_ENABLED && !verify_csrf()) {
        $this->redirectBack('Invalid CSRF token', 'error');
        return;
    }
    
    // Rate Limiting
    if (RATE_LIMIT_ENABLED && !rate_limit('add_data', 10, 60)) {
        $this->redirectBack('Too many attempts', 'error');
        return;
    }
    
    // Sanitize & Validate Input
    $nama = sanitize($_POST['nama'], 'string');
    
    if (!validate($nama, 'min', array('min' => 3))) {
        $this->redirectBack('Name too short', 'error');
        return;
    }
    
    // Process data...
}
```

### 4. Escape Output di View:

```php
<!-- SELALU escape output dari database/user input -->
<h1><?php echo esc($title); ?></h1>
<p><?php echo esc($user->nama); ?></p>
<td><?php echo e($data); ?></td>
```

### 5. Hash Password (Authentication):

```php
// Registration
$hashedPassword = hash_password($_POST['password']);
$User->insert(array(
    'email' => $email,
    'password' => $hashedPassword
));

// Login
if (verify_password($_POST['password'], $user['password'])) {
    // Login success
}
```

---

## 📖 Dokumentasi Lengkap

Untuk dokumentasi lengkap dengan contoh kode dan best practices:

👉 **[DOKUMENTASI_SECURITY.md](_DEV/DOKUMENTASI_SECURITY.md)**

---

## ⚡ Helper Functions Tersedia

### CSRF Protection:
- `csrf_field()` - Generate hidden input CSRF token
- `csrf_token()` - Get CSRF token string
- `verify_csrf()` - Verify CSRF token

### XSS Protection:
- `esc($string)` - Escape HTML entities
- `e($string)` - Alias untuk esc()

### Input Validation:
- `sanitize($input, $type)` - Sanitize input (string, email, int, url)
- `validate($input, $rule, $params)` - Validate input (email, required, min, max, numeric, url, regex)

### Password Security:
- `hash_password($password)` - Hash password
- `verify_password($password, $hash)` - Verify password

### Rate Limiting:
- `rate_limit($action, $maxAttempts, $timeWindow)` - Check rate limit

### Utilities:
- `get_client_ip()` - Get client IP address
- `is_https()` - Check if connection is HTTPS
- `is_ajax()` - Check if request is AJAX

---

## 🛡️ Contoh AuthController

Lihat file [app/controllers/AuthController.php](app/controllers/AuthController.php) untuk contoh lengkap implementasi:
- Login dengan CSRF & Rate Limiting
- Register dengan Password Policy
- Session Security
- Logout
- Forgot Password

---

## ✅ Security Checklist

- [x] CSRF token di semua form POST
- [x] Verify CSRF di semua POST handlers
- [x] Escape semua output dengan `esc()`
- [x] Sanitize semua input dengan `sanitize()`
- [x] Validate input dengan `validate()`
- [x] Hash password dengan `hash_password()`
- [x] Rate limiting untuk login/register/forgot password
- [x] Prepared statements untuk query database
- [x] Session security configured
- [x] Security headers enabled
- [x] File upload validation
- [x] HTTPS enabled (production)

---

## 🔍 Troubleshooting

### CSRF Token Mismatch?
1. Pastikan `CSRF_ENABLED=true` di .env
2. Pastikan `csrf_field()` ada di form
3. Check CSRF_EXPIRE (default 1 hour)

### Rate Limit Blocking?
1. Tunggu sampai time window habis
2. Atau disable: `RATE_LIMIT_ENABLED=false`

### Password Hash Not Working?
1. Pastikan column `password` VARCHAR(255)
2. Jangan sanitize password sebelum hash
3. Gunakan `hash_password()` dan `verify_password()`

---

## 📝 Best Practices

1. ✅ **Input**: SELALU sanitize & validate
2. ✅ **Output**: SELALU escape dengan `esc()`
3. ✅ **Form**: SELALU gunakan CSRF token
4. ✅ **Password**: SELALU hash dengan `hash_password()`
5. ✅ **Query**: SELALU gunakan prepared statements
6. ✅ **Session**: Regenerate setelah login/logout
7. ✅ **Upload**: SELALU validate file type & size
8. ✅ **HTTPS**: Gunakan HTTPS di production
9. ✅ **Error**: Jangan expose error details di production
10. ✅ **Update**: Keep security patches up to date

---

## 🔐 Compatibility

Security features kompatibel dengan:
- ✅ PHP 5.2 (fallback to sha256 for passwords)
- ✅ PHP 5.3-5.4 (custom password_hash polyfill)
- ✅ PHP 5.5-5.6 (native password_hash with bcrypt)
- ✅ PHP 7.x (full support)
- ✅ PHP 8.x (full support with Argon2)

---

**🔒 Secure by Default - Stay Safe!**

© 2024 MVC PHP Template
