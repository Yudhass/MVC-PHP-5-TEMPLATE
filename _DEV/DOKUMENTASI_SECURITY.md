# 🔒 DOKUMENTASI KEAMANAN (SECURITY DOCUMENTATION)

## Daftar Isi
- [Ringkasan Fitur Keamanan](#ringkasan-fitur-keamanan)
- [Konfigurasi Keamanan](#konfigurasi-keamanan)
- [1. CSRF Protection](#1-csrf-protection)
- [2. XSS Protection](#2-xss-protection)
- [3. Input Validation & Sanitization](#3-input-validation--sanitization)
- [4. Password Security](#4-password-security)
- [5. Session Security](#5-session-security)
- [6. Rate Limiting](#6-rate-limiting)
- [7. File Upload Security](#7-file-upload-security)
- [8. Security Headers](#8-security-headers)
- [9. SQL Injection Protection](#9-sql-injection-protection)
- [10. Path Traversal Protection](#10-path-traversal-protection)
- [Best Practices](#best-practices)

---

## Ringkasan Fitur Keamanan

Aplikasi MVC PHP ini dilengkapi dengan **10 layer keamanan** yang komprehensif:

1. ✅ **CSRF Protection** - Token untuk form submissions
2. ✅ **XSS Protection** - Escaping & sanitization output
3. ✅ **Input Validation** - Validasi dan sanitasi input
4. ✅ **Password Security** - Hashing dengan bcrypt/password_hash
5. ✅ **Session Security** - Secure session configuration
6. ✅ **Rate Limiting** - Pencegahan brute force attack
7. ✅ **File Upload Security** - Validasi file upload
8. ✅ **Security Headers** - HTTP security headers
9. ✅ **SQL Injection Protection** - Prepared statements
10. ✅ **Path Traversal Protection** - Validasi path file

---

## Konfigurasi Keamanan

Semua konfigurasi keamanan ada di file `.env`:

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
SESSION_REGENERATE_INTERVAL=1800

# Security Headers
SECURITY_HEADERS_ENABLED=true
```

---

## 1. CSRF Protection

### Apa itu CSRF?
Cross-Site Request Forgery (CSRF) adalah serangan yang memaksa user untuk melakukan aksi yang tidak diinginkan pada aplikasi web dimana mereka sudah terotentikasi.

### Cara Menggunakan

#### Di View (Form HTML):
```php
<form action="<?php echo BASEURL; ?>home/add_data" method="POST">
    <?php echo csrf_field(); ?>
    <!-- form fields -->
    <input type="text" name="nama" required>
    <button type="submit">Submit</button>
</form>
```

#### Di Controller:
```php
public function add_data() 
{
    // Verifikasi CSRF Token
    if (CSRF_ENABLED && !verify_csrf()) {
        $this->redirectBack('Invalid CSRF token', 'error');
        return;
    }
    
    // Proses data...
}
```

#### Fungsi Helper:
```php
// Generate CSRF field untuk form
csrf_field()              // Output: <input type="hidden" name="csrf_token" value="...">

// Get CSRF token saja
csrf_token()              // Return: token string

// Verifikasi CSRF token
verify_csrf()             // Return: true/false
```

### Manual Usage (Security Class):
```php
// Generate token
$token = Security::generateCSRFToken();

// Generate field HTML
$field = Security::csrfField();

// Verify token
if (Security::verifyCSRFToken($_POST['csrf_token'])) {
    // Valid
}
```

---

## 2. XSS Protection

### Apa itu XSS?
Cross-Site Scripting (XSS) adalah vulnerability yang memungkinkan attacker menyisipkan script berbahaya ke dalam web page.

### Cara Menggunakan

#### Escape Output di View:
```php
<!-- Escape semua user input/data dari database -->
<h1><?php echo esc($title); ?></h1>
<p><?php echo esc($user->nama); ?></p>

<!-- Atau gunakan alias e() -->
<span><?php echo e($data); ?></span>
```

#### Clean HTML (jika perlu render HTML):
```php
// Hanya izinkan tag HTML tertentu
$safeHTML = Security::cleanHTML($userInput);
echo $safeHTML;

// Atau strip semua HTML
$plainText = Security::stripHTML($userInput);
echo $plainText;
```

### Fungsi Helper:
```php
esc($string)              // Escape untuk HTML output
e($string)                // Alias dari esc()
```

### Manual Usage:
```php
// Escape HTML entities
Security::escape($string)

// Clean HTML dengan whitelist tags
Security::cleanHTML($html, array('p', 'b', 'i', 'u'))

// Strip semua HTML tags
Security::stripHTML($html)
```

---

## 3. Input Validation & Sanitization

### Sanitasi Input

#### Di Controller:
```php
// Sanitize string
$nama = sanitize($_POST['nama'], 'string');

// Sanitize email
$email = sanitize($_POST['email'], 'email');

// Sanitize integer
$id = sanitize($_POST['id'], 'int');

// Sanitize URL
$website = sanitize($_POST['website'], 'url');
```

### Validasi Input

```php
// Validate email
if (!validate($email, 'email')) {
    echo "Invalid email";
}

// Validate required field
if (!validate($nama, 'required')) {
    echo "Name is required";
}

// Validate minimum length
if (!validate($password, 'min', array('min' => 8))) {
    echo "Password must be at least 8 characters";
}

// Validate maximum length
if (!validate($nama, 'max', array('max' => 100))) {
    echo "Name must not exceed 100 characters";
}

// Validate numeric
if (!validate($age, 'numeric')) {
    echo "Age must be numeric";
}

// Validate URL
if (!validate($website, 'url')) {
    echo "Invalid URL";
}

// Validate regex pattern
if (!validate($phone, 'regex', array('pattern' => '/^[0-9]{10,13}$/'))) {
    echo "Invalid phone number";
}
```

### Fungsi Helper:
```php
sanitize($input, $type)              // Sanitasi input
validate($input, $rule, $params)     // Validasi input
```

### Manual Usage:
```php
// Sanitize
Security::sanitize($_POST['nama'], 'string')
Security::sanitize($_POST['email'], 'email')
Security::sanitize($_POST['age'], 'int')

// Validate
Security::validate($email, 'email')
Security::validate($password, 'min', array('min' => 8))
```

### Contoh Lengkap:
```php
public function register() 
{
    // Sanitize input
    $nama = sanitize($_POST['nama'], 'string');
    $email = sanitize($_POST['email'], 'email');
    $password = $_POST['password']; // jangan sanitize password
    
    // Validate
    if (!validate($nama, 'required') || !validate($nama, 'min', array('min' => 3))) {
        $this->redirectBack('Name must be at least 3 characters', 'error');
        return;
    }
    
    if (!validate($email, 'email')) {
        $this->redirectBack('Invalid email format', 'error');
        return;
    }
    
    if (!validate($password, 'min', array('min' => 8))) {
        $this->redirectBack('Password must be at least 8 characters', 'error');
        return;
    }
    
    // Hash password
    $hashedPassword = hash_password($password);
    
    // Save to database...
}
```

---

## 4. Password Security

### Password Hashing

#### Di Controller (Registration):
```php
public function register() 
{
    $password = $_POST['password'];
    
    // Hash password sebelum simpan ke database
    $hashedPassword = hash_password($password);
    
    $user->insert(array(
        'email' => $email,
        'password' => $hashedPassword
    ));
}
```

#### Di Controller (Login):
```php
public function login() 
{
    $email = sanitize($_POST['email'], 'email');
    $password = $_POST['password'];
    
    $user = $User->selectWhere('email', $email);
    
    if ($user && verify_password($password, $user['password'])) {
        // Login success
        $_SESSION['user_id'] = $user['id'];
    } else {
        // Login failed
        $this->redirectBack('Invalid credentials', 'error');
    }
}
```

### Fungsi Helper:
```php
hash_password($password)              // Hash password
verify_password($password, $hash)     // Verify password dengan hash
```

### Manual Usage:
```php
// Hash password (otomatis pilih algoritma terbaik)
$hash = Security::hashPassword($password);

// Verify password
if (Security::verifyPassword($password, $hash)) {
    // Password benar
}
```

### Password Policy
Konfigurasi di `.env`:
```env
PASSWORD_MIN_LENGTH=8
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBER=true
PASSWORD_REQUIRE_SPECIAL=true
```

Validasi password policy:
```php
// Custom validation
if (strlen($password) < PASSWORD_MIN_LENGTH) {
    echo "Password too short";
}

if (PASSWORD_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
    echo "Password must contain uppercase letter";
}

if (PASSWORD_REQUIRE_NUMBER && !preg_match('/[0-9]/', $password)) {
    echo "Password must contain number";
}

if (PASSWORD_REQUIRE_SPECIAL && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    echo "Password must contain special character";
}
```

---

## 5. Session Security

### Konfigurasi Session
Session security otomatis diinisialisasi di `Config.php`:

```php
Security::startSecureSession();
```

Konfigurasi di `.env`:
```env
SESSION_SECURE=false         # true jika HTTPS
SESSION_HTTPONLY=true        # Prevent XSS access to session
SESSION_SAMESITE=Lax         # CSRF protection
SESSION_LIFETIME=3600        # 1 hour
SESSION_REGENERATE_INTERVAL=1800  # 30 minutes
```

### Best Practices:
```php
// Regenerate session ID setelah login
session_regenerate_id(true);

// Destroy session saat logout
public function logout() 
{
    session_destroy();
    $this->redirect('login');
}

// Check session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > SESSION_LIFETIME) {
    session_destroy();
    $this->redirect('login');
}
$_SESSION['LAST_ACTIVITY'] = time();
```

---

## 6. Rate Limiting

### Apa itu Rate Limiting?
Rate limiting membatasi jumlah request yang bisa dilakukan user dalam waktu tertentu, mencegah brute force attack.

### Cara Menggunakan

#### Di Controller:
```php
public function login() 
{
    // Check rate limit: max 5 attempts dalam 5 menit
    if (!rate_limit('login', 5, 300)) {
        $this->redirectBack('Too many login attempts. Please try again later.', 'error');
        return;
    }
    
    // Process login...
}
```

### Fungsi Helper:
```php
rate_limit($action, $maxAttempts, $timeWindow)  // Return true/false
```

### Manual Usage:
```php
// Check rate limit
if (Security::rateLimit('action_name', 5, 300)) {
    // Allowed
} else {
    // Rate limit exceeded
}
```

### Contoh Penggunaan:
```php
// Login attempts
rate_limit('login', 5, 300)           // 5 attempts per 5 minutes

// Registration
rate_limit('register', 3, 3600)       // 3 attempts per hour

// Password reset
rate_limit('reset_password', 3, 900)  // 3 attempts per 15 minutes

// Add data
rate_limit('add_data', 10, 60)        // 10 attempts per minute

// Delete data
rate_limit('delete_data', 5, 60)      // 5 attempts per minute
```

---

## 7. File Upload Security

### Validasi File Upload

```php
public function upload_file() 
{
    if (!isset($_FILES['file'])) {
        $this->redirectBack('No file uploaded', 'error');
        return;
    }
    
    $file = $_FILES['file'];
    
    // Validasi file upload
    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    $maxSize = 2 * 1024 * 1024; // 2MB
    
    $validation = Security::validateFileUpload($file, $allowedTypes, $maxSize);
    
    if ($validation !== true) {
        $this->redirectBack($validation, 'error');
        return;
    }
    
    // Generate safe filename
    $safeFilename = Security::generateSafeFilename($file['name']);
    
    // Move uploaded file
    $uploadPath = 'uploads/' . $safeFilename;
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $this->redirectBack('File uploaded successfully', 'success');
    } else {
        $this->redirectBack('Failed to upload file', 'error');
    }
}
```

### Manual Usage:
```php
// Validate file upload
$result = Security::validateFileUpload(
    $_FILES['file'],
    array('image/jpeg', 'image/png'),  // allowed types
    2097152                             // max size (2MB)
);

if ($result === true) {
    // Valid
} else {
    echo $result; // error message
}

// Generate safe filename
$safeName = Security::generateSafeFilename('user file.jpg');
// Output: user-file-1234567890.jpg
```

### Allowed File Types:
```php
// Images
$imageTypes = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');

// Documents
$docTypes = array('application/pdf', 'application/msword', 
                  'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

// Archives
$archiveTypes = array('application/zip', 'application/x-rar-compressed');
```

---

## 8. Security Headers

### HTTP Security Headers
Security headers otomatis dikirim jika `SECURITY_HEADERS_ENABLED=true` di `.env`:

```php
Security::setSecurityHeaders();
```

Headers yang dikirim:
```
X-Frame-Options: SAMEORIGIN           # Prevent clickjacking
X-Content-Type-Options: nosniff       # Prevent MIME sniffing
X-XSS-Protection: 1; mode=block       # XSS protection (legacy)
Content-Security-Policy: default-src 'self'  # CSP
Strict-Transport-Security: max-age=31536000  # HSTS (jika HTTPS)
```

### Custom CSP (Content Security Policy):
```php
Security::setSecurityHeaders(array(
    'Content-Security-Policy' => "default-src 'self'; script-src 'self' https://cdn.example.com"
));
```

---

## 9. SQL Injection Protection

### Prepared Statements
Model class sudah menggunakan prepared statements:

```php
// SELECT dengan WHERE
$user = $User->selectWhere('email', $email);

// UPDATE dengan WHERE
$User->updateById($id, array('nama' => $nama));

// DELETE dengan WHERE
$User->deleteById($id);
```

### Custom Query:
```php
// Dengan PDO (PHP 5.3+)
$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(array(':email' => $email));

// Dengan mysql_* (PHP 5.2)
$email_escaped = $db->escapeString($email);
$query = "SELECT * FROM users WHERE email = '$email_escaped'";
$result = $db->query($query);
```

### ❌ JANGAN PERNAH:
```php
// TIDAK AMAN! Vulnerable to SQL injection
$query = "SELECT * FROM users WHERE email = '$_POST[email]'";
$db->query($query);
```

### ✅ SELALU GUNAKAN:
```php
// AMAN! Using prepared statements
$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(array(':email' => $_POST['email']));
```

---

## 10. Path Traversal Protection

### Apa itu Path Traversal?
Path traversal attack memungkinkan attacker mengakses file di luar directory yang diizinkan dengan menggunakan `../` dalam path.

### Validasi Path:
```php
// Validate file path
$filename = $_GET['file'];

if (Security::isPathTraversal($filename)) {
    die('Invalid file path');
}

// Safe file include
$basePath = '/var/www/uploads/';
$fullPath = realpath($basePath . $filename);

if (strpos($fullPath, $basePath) !== 0) {
    die('Invalid file path');
}

include $fullPath;
```

### Manual Usage:
```php
// Check path traversal
if (Security::isPathTraversal($path)) {
    // Path contains ../ or ..\
    die('Invalid path');
}
```

---

## Best Practices

### 1. Input Validation
```php
// ✅ SELALU sanitize dan validate input
$nama = sanitize($_POST['nama'], 'string');
if (!validate($nama, 'min', array('min' => 3))) {
    // Error
}

// ❌ JANGAN langsung gunakan input
$nama = $_POST['nama'];
```

### 2. Output Escaping
```php
// ✅ SELALU escape output
echo esc($user->nama);

// ❌ JANGAN output langsung
echo $user->nama;
```

### 3. CSRF Protection
```php
// ✅ SELALU gunakan CSRF token di form POST
<form method="POST">
    <?php echo csrf_field(); ?>
    ...
</form>

// ✅ SELALU verify token di controller
if (!verify_csrf()) {
    // Error
}
```

### 4. Password Security
```php
// ✅ SELALU hash password
$hash = hash_password($password);

// ❌ JANGAN simpan password plain text
$db->insert(array('password' => $password));
```

### 5. Session Security
```php
// ✅ SELALU regenerate session setelah login
session_regenerate_id(true);

// ✅ SELALU destroy session saat logout
session_destroy();
```

### 6. Database Queries
```php
// ✅ SELALU gunakan prepared statements
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(array(':id' => $id));

// ❌ JANGAN concat query
$query = "SELECT * FROM users WHERE id = " . $_GET['id'];
```

### 7. File Upload
```php
// ✅ SELALU validate file upload
$result = Security::validateFileUpload($_FILES['file'], $allowedTypes, $maxSize);

// ✅ SELALU generate safe filename
$safeName = Security::generateSafeFilename($_FILES['file']['name']);
```

### 8. Error Handling
```php
// ✅ JANGAN expose error details di production
if (ENVIRONMENT === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
```

### 9. HTTPS
```php
// ✅ SELALU gunakan HTTPS di production
if (ENVIRONMENT === 'production' && !is_https()) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}
```

### 10. Rate Limiting
```php
// ✅ SELALU gunakan rate limiting untuk aksi sensitif
if (!rate_limit('login', 5, 300)) {
    // Too many attempts
}
```

---

## Utility Functions

### Check HTTPS:
```php
if (is_https()) {
    // Connection is secure
}
```

### Check AJAX Request:
```php
if (is_ajax()) {
    // AJAX request
}
```

### Get Client IP:
```php
$ip = get_client_ip();
```

---

## Troubleshooting

### CSRF Token Mismatch
**Problem:** Form selalu error "Invalid CSRF token"

**Solution:**
1. Pastikan `CSRF_ENABLED=true` di `.env`
2. Pastikan `csrf_field()` ada di dalam form
3. Pastikan session aktif (`session_start()` sudah dipanggil)
4. Check CSRF_EXPIRE (default 3600 seconds)

### Rate Limit Blocking
**Problem:** Terus kena rate limit

**Solution:**
1. Check `RATE_LIMIT_MAX_ATTEMPTS` dan `RATE_LIMIT_TIME_WINDOW` di `.env`
2. Clear session atau tunggu sampai time window habis
3. Disable rate limiting: `RATE_LIMIT_ENABLED=false`

### Password Hash Not Working
**Problem:** Password verification selalu gagal

**Solution:**
1. Pastikan database column 'password' cukup panjang (VARCHAR(255))
2. Jangan sanitize password sebelum hash
3. Gunakan `hash_password()` untuk hash, `verify_password()` untuk verify

### File Upload Rejected
**Problem:** File upload selalu ditolak

**Solution:**
1. Check allowed file types
2. Check max file size
3. Check PHP upload_max_filesize dan post_max_size di php.ini
4. Check folder permissions

---

## PHP Version Compatibility

Security class kompatibel dengan **PHP 5.2, 5.3-5.6, 7.x, 8.x**:

- **PHP 5.2**: Menggunakan `sha256` hash untuk password
- **PHP 5.3-5.4**: Menggunakan custom `password_hash` polyfill
- **PHP 5.5+**: Menggunakan native `password_hash()` dengan BCRYPT
- **PHP 7.2+**: Menggunakan Argon2i jika tersedia
- **PHP 8.x**: Full compatibility

---

## Kesimpulan

Aplikasi ini dilengkapi dengan **10 layer keamanan** yang comprehensive:

1. ✅ CSRF Protection untuk form submissions
2. ✅ XSS Protection untuk output escaping
3. ✅ Input Validation & Sanitization
4. ✅ Password Hashing dengan bcrypt/argon2
5. ✅ Secure Session Management
6. ✅ Rate Limiting untuk brute force protection
7. ✅ File Upload Validation
8. ✅ Security Headers (CSP, HSTS, X-Frame-Options)
9. ✅ SQL Injection Protection dengan prepared statements
10. ✅ Path Traversal Protection

**Selalu ikuti best practices dan update security patches secara berkala!**

---

© 2024 MVC PHP Template - Secure by Default
