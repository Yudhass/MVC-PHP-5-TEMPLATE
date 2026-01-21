# Dokumentasi Environment Configuration (.env)

## 📋 Daftar Isi

1. [Pengenalan](#pengenalan)
2. [Setup & Instalasi](#setup--instalasi)
3. [Daftar Konfigurasi](#daftar-konfigurasi)
4. [Penggunaan](#penggunaan)
5. [Best Practices](#best-practices)
6. [Troubleshooting](#troubleshooting)

---

## Pengenalan

Semua konfigurasi aplikasi sekarang tersentralisasi dalam file **`.env`**. Ini memudahkan:

✅ **Konfigurasi per environment** (development, production, staging)  
✅ **Keamanan** - .env tidak di-commit ke repository  
✅ **Portabilitas** - Mudah pindah server tanpa ubah code  
✅ **Konsistensi** - Semua config di satu tempat  

---

## Setup & Instalasi

### 1. Copy .env.example menjadi .env

```bash
# Di Windows
copy .env.example .env

# Di Linux/Mac
cp .env.example .env
```

### 2. Edit .env sesuai environment Anda

```bash
# Edit dengan text editor favorit
notepad .env
# atau
nano .env
# atau
vim .env
```

### 3. Sesuaikan nilai konfigurasi

```env
# Contoh untuk production
DB_HOST=localhost
DB_USER=production_user
DB_PASS=strong_password_here
BASE_URL=https://example.com/
APP_ENV=production
APP_DEBUG=false
```

---

## Daftar Konfigurasi

### 1. Database Configuration

```env
DB_HOST=localhost         # Host database (localhost, IP, atau domain)
DB_USER=root             # Username database
DB_PASS=                 # Password database (kosongkan jika tidak ada)
DB_NAME=crudtest         # Nama database
DB_PORT=3306             # Port database (default MySQL: 3306)
```

**Penggunaan:**
```php
// Otomatis tersedia sebagai constants
echo DB_HOST;  // localhost
echo DB_NAME;  // crudtest
```

---

### 2. Application Configuration

```env
APP_NAME=MVC-PHP-5-TEMPLATE    # Nama aplikasi
APP_ENV=development            # Environment: development, production, staging
APP_DEBUG=true                 # Debug mode (true/false)
```

**Penggunaan:**
```php
echo APP_NAME;   // MVC-PHP-5-TEMPLATE
echo APP_ENV;    // development

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
```

---

### 3. Project Configuration

```env
FOLDER_PROJECT=MVC-PHP-5-TEMPLATE    # Nama folder project (tanpa slash)
```

**Penggunaan:**
```php
echo FOLDER_PROJECT;  // MVC-PHP-5-TEMPLATE
```

---

### 4. Base URL Configuration

```env
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/
```

**Contoh berbagai environment:**

```env
# Development (Local)
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# Development (IP Local)
BASE_URL=http://192.168.1.240/MVC-PHP-5-TEMPLATE/

# Production (Domain)
BASE_URL=https://example.com/

# Staging
BASE_URL=https://staging.example.com/
```

**Penggunaan:**
```php
echo BASEURL;              // http://localhost/MVC-PHP-5-TEMPLATE/
echo base_url();           // http://localhost/MVC-PHP-5-TEMPLATE/
echo base_url('users');    // http://localhost/MVC-PHP-5-TEMPLATE/users
```

---

### 5. Upload Configuration

```env
UPLOAD_FOLDER=public/img/       # Path folder upload (relatif)
MAX_UPLOAD_SIZE=5242880         # Max size dalam bytes (5MB = 5242880)
```

**Konversi size:**
- 1 MB = 1048576 bytes
- 5 MB = 5242880 bytes
- 10 MB = 10485760 bytes
- 20 MB = 20971520 bytes

**Penggunaan:**
```php
echo UPLOAD_FOLDER;      // /path/to/public/img/
echo MAX_UPLOAD_SIZE;    // 5242880

// Check file size
if ($_FILES['file']['size'] > MAX_UPLOAD_SIZE) {
    die('File terlalu besar!');
}
```

---

### 6. Session Configuration

```env
SESSION_LIFETIME=7200         # Session timeout dalam detik (7200 = 2 jam)
SESSION_NAME=mvc_session      # Nama session cookie
```

**Konversi waktu:**
- 30 menit = 1800
- 1 jam = 3600
- 2 jam = 7200
- 24 jam = 86400

**Penggunaan:**
```php
echo SESSION_LIFETIME;   // 7200
echo SESSION_NAME;       // mvc_session

// Set session lifetime
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
session_name(SESSION_NAME);
session_start();
```

---

### 7. Security Configuration

```env
APP_KEY=                      # Application key untuk enkripsi
HASH_ALGO=sha256             # Hash algorithm (md5, sha1, sha256, sha512)
```

**Generate APP_KEY (PHP 5.3+):**
```php
echo base64_encode(openssl_random_pseudo_bytes(32));
```

**Generate APP_KEY (PHP 5.2):**
```php
echo md5(uniqid(rand(), true));
```

**Penggunaan:**
```php
echo APP_KEY;      // Your secret key
echo HASH_ALGO;    // sha256

// Hash password
$hashed = hash(HASH_ALGO, $password);
```

---

### 8. Timezone Configuration

```env
APP_TIMEZONE=Asia/Jakarta    # Timezone aplikasi
```

**Timezone Indonesia:**
- `Asia/Jakarta` - WIB (Waktu Indonesia Barat)
- `Asia/Makassar` - WITA (Waktu Indonesia Tengah)
- `Asia/Jayapura` - WIT (Waktu Indonesia Timur)

**Penggunaan:**
```php
echo APP_TIMEZONE;        // Asia/Jakarta
echo date('Y-m-d H:i:s'); // 2026-01-21 10:30:00 (WIB)
```

---

### 9. Localization

```env
APP_LOCALE=id                # Locale utama (id, en, dll)
APP_FALLBACK_LOCALE=en       # Fallback locale
```

**Penggunaan:**
```php
echo APP_LOCALE;           // id
echo APP_FALLBACK_LOCALE;  // en

// Set locale
setlocale(LC_ALL, APP_LOCALE);
```

---

### 10. Maintenance Mode

```env
MAINTENANCE_MODE=false                        # Aktifkan maintenance mode
MAINTENANCE_MESSAGE=Aplikasi sedang dalam maintenance
```

**Penggunaan:**
```php
// Di index.php atau init.php
if (MAINTENANCE_MODE && APP_ENV !== 'development') {
    http_response_code(503);
    die(MAINTENANCE_MESSAGE);
}
```

---

### 11. Logging Configuration

```env
LOG_LEVEL=error              # Level: debug, info, warning, error
LOG_PATH=storage/logs/       # Path untuk log files
```

**Penggunaan:**
```php
echo LOG_LEVEL;  // error
echo LOG_PATH;   // storage/logs/

// Simple logging
function log_error($message) {
    $logFile = LOG_PATH . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}
```

---

### 12. Cache Configuration

```env
CACHE_ENABLED=false          # Enable/disable cache
CACHE_LIFETIME=3600          # Cache lifetime dalam detik (1 jam)
```

**Penggunaan:**
```php
echo CACHE_ENABLED;    // false
echo CACHE_LIFETIME;   // 3600

if (CACHE_ENABLED) {
    // Use caching
}
```

---

### 13. Email Configuration (Optional)

```env
MAIL_DRIVER=smtp                           # Driver: smtp, sendmail, mail
MAIL_HOST=smtp.gmail.com                   # SMTP host
MAIL_PORT=587                              # SMTP port (587, 465, 25)
MAIL_USERNAME=                             # Email username
MAIL_PASSWORD=                             # Email password
MAIL_ENCRYPTION=tls                        # Encryption: tls, ssl, null
MAIL_FROM_ADDRESS=noreply@example.com      # From email
MAIL_FROM_NAME=MVC-PHP-5-TEMPLATE          # From name
```

**Contoh Gmail:**
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

**Penggunaan:**
```php
echo MAIL_HOST;      // smtp.gmail.com
echo MAIL_PORT;      // 587
```

---

### 14. API Configuration (Optional)

```env
API_ENABLED=false            # Enable/disable API
API_PREFIX=api               # API URL prefix
API_VERSION=v1               # API version
API_RATE_LIMIT=60            # Rate limit per menit
```

**Penggunaan:**
```php
echo API_ENABLED;     // false
echo API_PREFIX;      // api
echo API_VERSION;     // v1

// API URL: http://example.com/api/v1/users
```

---

## Penggunaan

### 1. Akses di Code dengan Helper Function

```php
// Gunakan helper function env()
$dbHost = env('DB_HOST');                    // localhost
$appName = env('APP_NAME', 'Default Name'); // dengan default value
$debugMode = env('APP_DEBUG', false);       // boolean

echo $dbHost;
```

### 2. Akses melalui Constants

```php
// Setelah Config.php di-load, gunakan constants
echo DB_HOST;         // localhost
echo DB_NAME;         // crudtest
echo BASEURL;         // http://localhost/...
echo APP_NAME;        // MVC-PHP-5-TEMPLATE
```

### 3. Check Variable Exists

```php
// Check apakah env variable ada
if (Env::has('CUSTOM_VAR')) {
    echo env('CUSTOM_VAR');
}
```

### 4. Get All Environment Variables

```php
// Get semua env variables
$allEnv = Env::all();
print_r($allEnv);
```

### 5. Set Runtime Environment Variable

```php
// Set env variable saat runtime (tidak mengubah file .env)
Env::set('TEMP_VAR', 'temporary value');
echo env('TEMP_VAR');  // temporary value
```

---

## Best Practices

### 1. ❌ JANGAN commit file .env

File `.env` sudah ada di `.gitignore`. Jangan pernah commit file ini!

```bash
# .gitignore
.env
.env.local
.env.*.local
```

### 2. ✅ Gunakan .env.example sebagai template

Selalu update `.env.example` dengan konfigurasi baru (tanpa nilai sensitif):

```env
# .env.example
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=database_name
```

### 3. ✅ Gunakan nilai default

Selalu berikan default value saat mengakses env:

```php
$timeout = env('TIMEOUT', 30);  // Default 30 jika tidak ada
```

### 4. ✅ Dokumentasikan setiap konfigurasi baru

Tambahkan comment di `.env.example` untuk konfigurasi baru:

```env
# Upload Configuration
# MAX_UPLOAD_SIZE dalam bytes (5MB = 5242880)
MAX_UPLOAD_SIZE=5242880
```

### 5. ✅ Gunakan environment berbeda

```env
# .env.development
APP_ENV=development
APP_DEBUG=true
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# .env.production
APP_ENV=production
APP_DEBUG=false
BASE_URL=https://production.com/
```

### 6. ✅ Validasi konfigurasi penting

```php
// Di init.php atau bootstrap
if (empty(DB_NAME)) {
    die('Database name tidak boleh kosong! Check file .env');
}

if (empty(APP_KEY) && APP_ENV === 'production') {
    die('APP_KEY wajib diisi di production!');
}
```

---

## Troubleshooting

### 1. Error: .env file not found

**Solusi:**
```bash
# Copy .env.example ke .env
copy .env.example .env
```

### 2. Error: Environment variable tidak terbaca

**Solusi:**
```php
// Manual reload
Env::load();

// Atau check apakah Config.php sudah di-include
require_once 'app/core/Config.php';
```

### 3. Nilai env selalu default

**Penyebab:** Syntax error di file .env

**Solusi:**
```env
# ❌ Salah - ada spasi sebelum =
DB_HOST =localhost

# ✅ Benar - tidak ada spasi
DB_HOST=localhost
```

### 4. Boolean tidak bekerja

**Solusi:**
```env
# Gunakan lowercase
APP_DEBUG=true   # ✅ Benar
APP_DEBUG=false  # ✅ Benar

# Jangan gunakan
APP_DEBUG=True   # ❌ Akan jadi string
APP_DEBUG=1      # ❌ Akan jadi integer
```

### 5. File .env tidak terbaca di hosting

**Penyebab:** Permissions

**Solusi:**
```bash
# Set permission yang benar
chmod 644 .env
```

---

## Migration dari Config Lama

Jika Anda punya konfigurasi lama di Config.php:

**BEFORE:**
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mydb');
```

**AFTER:**
```env
# Di file .env
DB_HOST=localhost
DB_NAME=mydb
```

```php
// Di Config.php
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_NAME', env('DB_NAME', 'mydb'));
```

---

## Keamanan

### 1. Generate APP_KEY yang kuat

```bash
# PHP 7+
php -r "echo base64_encode(random_bytes(32));"

# PHP 5.3+
php -r "echo base64_encode(openssl_random_pseudo_bytes(32));"
```

### 2. Jangan expose .env di web server

Pastikan `.env` tidak bisa diakses via browser:

**Apache (.htaccess):**
```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

**Nginx:**
```nginx
location ~ /\.env {
    deny all;
}
```

---

**Happy Configuring!** 🚀
