# Environment Configuration (.env) - Ringkasan Cepat

## ✅ Fitur Baru: Environment Configuration

Semua konfigurasi aplikasi sekarang terpusat di file **`.env`**!

---

## 🚀 Quick Start

### 1. Setup .env

```bash
# Copy .env.example ke .env
copy .env.example .env
```

### 2. Edit Konfigurasi

Buka `.env` dan sesuaikan dengan environment Anda:

```env
# Database
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=crudtest
DB_PORT=3306

# Application
APP_NAME=MVC-PHP-5-TEMPLATE
APP_ENV=development
APP_DEBUG=true

# URL Configuration
BASE_URL=http://192.168.1.240/MVC-PHP-5-TEMPLATE/
FOLDER_PROJECT=MVC-PHP-5-TEMPLATE
```

---

## 📝 Daftar Konfigurasi yang Tersedia

### Database
- `DB_HOST` - Host database
- `DB_USER` - Username database
- `DB_PASS` - Password database
- `DB_NAME` - Nama database
- `DB_PORT` - Port database

### Application
- `APP_NAME` - Nama aplikasi
- `APP_ENV` - Environment (development/production)
- `APP_DEBUG` - Debug mode (true/false)

### URL & Path
- `BASE_URL` - Base URL aplikasi
- `FOLDER_PROJECT` - Nama folder project
- `UPLOAD_FOLDER` - Folder upload files
- `MAX_UPLOAD_SIZE` - Max upload size (bytes)

### Session
- `SESSION_LIFETIME` - Session timeout (seconds)
- `SESSION_NAME` - Nama session cookie

### Security
- `APP_KEY` - Application key
- `HASH_ALGO` - Hash algorithm

### Timezone
- `APP_TIMEZONE` - Timezone aplikasi

### Maintenance
- `MAINTENANCE_MODE` - Maintenance mode (true/false)
- `MAINTENANCE_MESSAGE` - Pesan maintenance

### Logging
- `LOG_LEVEL` - Log level (error, warning, info, debug)
- `LOG_PATH` - Path folder log

### Cache
- `CACHE_ENABLED` - Enable cache (true/false)
- `CACHE_LIFETIME` - Cache lifetime (seconds)

### Email (Optional)
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, dll

### API (Optional)
- `API_ENABLED`, `API_PREFIX`, `API_VERSION`

---

## 💻 Cara Penggunaan

### 1. Helper Function

```php
// Akses environment variable dengan helper
$dbHost = env('DB_HOST');
$appName = env('APP_NAME', 'Default Name'); // dengan default
$debug = env('APP_DEBUG', false);
```

### 2. Constants

```php
// Setelah Config.php loaded
echo DB_HOST;      // localhost
echo DB_NAME;      // crudtest
echo BASEURL;      // http://...
echo APP_NAME;     // MVC-PHP-5-TEMPLATE
```

### 3. Check Variable Exists

```php
if (Env::has('CUSTOM_VAR')) {
    echo env('CUSTOM_VAR');
}
```

---

## 🔒 Keamanan

### ❌ JANGAN commit file .env

File `.env` sudah di `.gitignore`. Jangan commit file ini ke repository!

### ✅ Gunakan .env.example

File `.env.example` adalah template tanpa data sensitif. Commit file ini.

---

## 📚 Dokumentasi Lengkap

Lihat [DOKUMENTASI_ENV.md](DOKUMENTASI_ENV.md) untuk:
- Detail semua konfigurasi
- Contoh penggunaan lengkap
- Best practices
- Troubleshooting
- Security tips

---

## 🎯 Keuntungan .env

✅ **Konfigurasi Terpusat** - Semua config di satu file  
✅ **Environment-Specific** - Beda config untuk dev/staging/production  
✅ **Keamanan** - Data sensitif tidak di-commit  
✅ **Mudah Deploy** - Tinggal ganti file .env  
✅ **Clean Code** - Tidak hardcode config di code  

---

**Happy Configuring!** 🚀
