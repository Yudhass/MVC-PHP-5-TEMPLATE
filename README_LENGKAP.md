# MVC-PHP-5-TEMPLATE - Dokumentasi Lengkap

Template MVC PHP yang **kompatibel dengan PHP 5.2, 7, 8 dan versi lebih tinggi**. Terinspirasi dari Laravel dan CodeIgniter dengan konfigurasi yang disesuaikan untuk mendukung berbagai versi PHP.

---

## 📋 Daftar Isi

1. [Fitur Utama](#-fitur-utama)
2. [Struktur Folder](#-struktur-folder)
3. [Instalasi & Setup](#-instalasi--setup)
4. [Konfigurasi Environment](#-konfigurasi-environment)
5. [Dokumentasi CRUD](#-dokumentasi-crud)
6. [Query Builder](#-query-builder)
7. [Routing](#-routing)
8. [Controller](#-controller)
9. [Model](#-model)
10. [View](#-view)
11. [Authentication](#-authentication)
12. [Middleware](#-middleware)
13. [Helper Functions](#-helper-functions)
14. [Security](#-security)
15. [Kompatibilitas PHP](#-kompatibilitas-php)
16. [Tips & Best Practices](#-tips--best-practices)
17. [Troubleshooting](#-troubleshooting)

---

## ✨ Fitur Utama

- ✅ **Kompatibilitas Multi-Versi**: PHP 5.2, 7, 8 dan lebih tinggi
- ✅ **Auto-Detection**: Otomatis menggunakan PDO atau mysql_* sesuai versi PHP
- ✅ **Environment Configuration**: Semua config terpusat di file .env
- ✅ **CRUD Lengkap**: Insert, Select All, Select One, Select Where, Update, Delete
- ✅ **Query Builder**: Mendukung method chaining untuk query kompleks
- ✅ **MVC Pattern**: Structure yang clean dan terorganisir
- ✅ **Flash Messages**: System pesan notifikasi
- ✅ **Helper Functions**: Berbagai fungsi helper yang berguna
- ✅ **Security**: Prepared statements dan input sanitization
- ✅ **Authentication & Authorization**: Login, Register, Logout, Role-based access
- ✅ **Middleware System**: Request filtering dan validation

---

## 📁 Struktur Folder

```
MVC-PHP-5-TEMPLATE/
├── .env                             # Environment configuration
├── .env.example                     # Environment template
├── .gitignore                       # Git ignore file
├── README.md                        # Dokumentasi utama
├── test_implementation.php          # File testing implementasi
│
├── _DEV/                           # Folder dokumentasi development
│   ├── CHANGELOG_SECURITY.md        # Log perubahan security
│   ├── CONTOH_IMPLEMENTASI_AUTH.md  # Contoh auth implementation
│   ├── CONTOH_IMPLEMENTASI.md       # Contoh CRUD implementation
│   ├── database_secure.sql          # Database schema dengan security
│   ├── database.sql                 # Database schema basic
│   ├── DOKUMENTASI_CRUD.md          # Dokumentasi lengkap CRUD
│   ├── DOKUMENTASI_ENV.md           # Dokumentasi environment
│   ├── DOKUMENTASI_MIDDLEWARE.md    # Dokumentasi middleware
│   ├── DOKUMENTASI_SECURITY.md      # Dokumentasi security features
│   ├── ENV_QUICK_START.md           # Quick start guide .env
│   ├── FIX_ERROR_LOG.md            # Log perbaikan error
│   ├── FIX_HEADERS_ERROR.md        # Fix untuk headers error
│   ├── LAPORAN_ANALISIS.md         # Laporan analisis sistem
│   ├── RINGKASAN_PERUBAHAN.md      # Ringkasan perubahan
│   ├── SECURITY_FEATURES.md        # Detail security features
│   ├── UPDATE_LOG_MIDDLEWARE.md    # Update log middleware
│   └── test_compatibility.php      # Test kompatibilitas PHP
│
├── app/                            # Folder aplikasi utama
│   ├── init.php                     # Inisialisasi aplikasi
│   │
│   ├── controllers/                 # Folder controllers
│   │   ├── AuthController.php       # Controller untuk authentication
│   │   └── HomeController.php       # Controller homepage
│   │
│   ├── core/                        # Folder core system
│   │   ├── App.php                  # Core aplikasi
│   │   ├── Config.php               # Konfigurasi (baca dari .env)
│   │   ├── Controller.php           # Base controller
│   │   ├── Database.php             # Database handler (PHP 5.2 - 8+)
│   │   ├── Env.php                  # Environment loader
│   │   ├── Helper.php               # Helper functions
│   │   ├── Middleware.php           # Middleware handler
│   │   ├── Model.php                # Base model dengan CRUD
│   │   ├── Router.php               # Routing system
│   │   └── Security.php             # Security functions
│   │
│   ├── middlewares/                 # Folder middlewares
│   │   ├── AuthMiddleware.php       # Middleware untuk auth users
│   │   ├── GuestMiddleware.php      # Middleware untuk guests
│   │   └── RoleMiddleware.php       # Middleware role-based
│   │
│   ├── models/                      # Folder models
│   │   └── User.php                 # Model User
│   │
│   ├── routes/                      # Folder routing
│   │   └── routes.php               # Definisi routing
│   │
│   └── views/                       # Folder views
│       ├── home.php                 # View homepage
│       └── errors/                  # Error views
│           ├── dd.php               # Debug & dump view
│           └── error.php            # Error view
│
├── public/                         # Folder public (document root)
│   └── index.php                    # Entry point aplikasi
│
├── release/                         # Folder untuk release files
│
└── storage/                        # Folder storage
    ├── cache/                       # Cache directory
    └── logs/                        # Log files directory
```

### Penjelasan Struktur

| Folder/File | Fungsi |
|-------------|--------|
| **.env** | File konfigurasi environment (database, app settings, dll) |
| **_DEV/** | Dokumentasi lengkap dan file development |
| **app/controllers/** | Tempat semua controller aplikasi |
| **app/core/** | Core system framework (jangan diubah kecuali tahu yang dilakukan) |
| **app/middlewares/** | Middleware untuk filtering request |
| **app/models/** | Model untuk database operations |
| **app/routes/** | Definisi routing URL |
| **app/views/** | File tampilan HTML/PHP |
| **public/** | Entry point, bisa diakses publik |
| **storage/** | Tempat cache dan log files |

---

## 🚀 Instalasi & Setup

### Langkah 1: Clone atau Download Template

```bash
# Clone repository (jika dari GitHub)
git clone https://github.com/username/MVC-PHP-5-TEMPLATE.git

# Atau download ZIP dan extract
```

### Langkah 2: Setup Environment Configuration

```bash
# Copy .env.example ke .env
copy .env.example .env

# Edit .env dan sesuaikan dengan environment Anda
notepad .env
```

### Langkah 3: Konfigurasi Database di File .env

Edit file `.env` dan sesuaikan konfigurasi database:

```env
# Database Configuration
DB_HOST=localhost
DB_NAME=crudtest
DB_USER=root
DB_PASS=
DB_PORT=3306
DB_CHARSET=utf8
```

### Langkah 4: Buat Database dan Import Schema

**Buat database baru:**

```sql
CREATE DATABASE crudtest;
USE crudtest;
```

**Import schema (pilih salah satu):**

```bash
# Option 1: Basic schema (untuk CRUD basic)
mysql -u root -p crudtest < _DEV/database.sql

# Option 2: Secure schema (dengan authentication & security features)
mysql -u root -p crudtest < _DEV/database_secure.sql
```

**Atau import manual via phpMyAdmin:**

1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Pilih database `crudtest`
3. Klik tab "Import"
4. Pilih file `_DEV/database.sql` atau `_DEV/database_secure.sql`
5. Klik "Go"

### Langkah 5: Jalankan Aplikasi

**Menggunakan PHP Built-in Server:**

```bash
# Jalankan dari root directory project
cd c:\xampp\htdocs\MVC-PHP-5-TEMPLATE
php -S localhost:8000 -t public

# Akses di browser
http://localhost:8000
```

**Menggunakan XAMPP/WAMP:**

1. Letakkan folder di `htdocs` (XAMPP) atau `www` (WAMP)
2. Pastikan Apache dan MySQL running
3. Edit `.env` dan sesuaikan `BASE_URL`:
   ```env
   BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/
   ```
4. Akses di browser:
   ```
   http://localhost/MVC-PHP-5-TEMPLATE/
   ```

### Langkah 6: Testing Instalasi

Buka browser dan akses homepage. Jika berhasil, Anda akan melihat:
- Halaman home dengan data user dari database
- Tidak ada error PHP
- Data tampil dengan benar

---

## 🔧 Konfigurasi Environment

### File .env

Semua konfigurasi aplikasi tersentralisasi di file `.env`. Ini memudahkan deployment ke berbagai environment (development, staging, production).

### Daftar Konfigurasi yang Tersedia

```env
# ============================================
# DATABASE CONFIGURATION
# ============================================
DB_HOST=localhost               # Host database (localhost atau IP server)
DB_NAME=crudtest               # Nama database
DB_USER=root                   # Username database
DB_PASS=                       # Password database (kosong untuk XAMPP default)
DB_PORT=3306                   # Port MySQL (default 3306)
DB_CHARSET=utf8                # Character set (utf8 atau utf8mb4)

# ============================================
# APPLICATION CONFIGURATION
# ============================================
APP_NAME=MVC-PHP-5-TEMPLATE    # Nama aplikasi
APP_ENV=development            # Environment: development, staging, production
APP_DEBUG=true                 # Debug mode (true/false)
APP_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# ============================================
# BASE URL CONFIGURATION
# ============================================
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/
# Sesuaikan dengan URL aplikasi Anda

# ============================================
# SESSION CONFIGURATION
# ============================================
SESSION_LIFETIME=120           # Waktu session (menit)
SESSION_COOKIE_NAME=mvc_session # Nama cookie session

# ============================================
# SECURITY CONFIGURATION
# ============================================
SECURITY_SALT=your_random_salt_here_change_this
# Ganti dengan string random untuk security
HASH_ALGO=sha256               # Algorithm hash (md5, sha256, dll)

# ============================================
# ERROR HANDLING
# ============================================
DISPLAY_ERRORS=true            # Tampilkan error di browser
LOG_ERRORS=true                # Log error ke file
ERROR_LOG_PATH=storage/logs/error.log
```

### Cara Menggunakan Environment Variables

```php
<?php
// Ambil nilai dari .env
$dbHost = env('DB_HOST', 'localhost');  // Dengan default value
$appName = env('APP_NAME');             // Tanpa default value

// Contoh penggunaan
$debugMode = env('APP_DEBUG', false);
if ($debugMode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Cek environment
$env = env('APP_ENV');
if ($env === 'production') {
    // Konfigurasi production
} else {
    // Konfigurasi development
}
```

### Tips Konfigurasi Environment

1. **Jangan commit file .env ke repository** - Gunakan .env.example sebagai template
2. **Gunakan nilai yang berbeda untuk setiap environment** - Development, staging, production
3. **Ganti SECURITY_SALT** - Gunakan string random yang unik
4. **Set DEBUG=false di production** - Untuk keamanan dan performa
5. **Backup file .env** - Simpan di tempat yang aman

**📖 Dokumentasi lengkap:** [DOKUMENTASI_ENV.md](_DEV/DOKUMENTASI_ENV.md)

---

## 📚 Dokumentasi CRUD

### Method CRUD yang Tersedia

Model dasar menyediakan method CRUD lengkap yang kompatibel dengan semua versi PHP:

| Method | Fungsi | Parameter | Return |
|--------|--------|-----------|--------|
| `insert($data)` | Tambah data baru | Array data | Object |
| `selectAll()` | Ambil semua data | - | Array |
| `selectOne($id)` | Ambil satu data berdasarkan ID | Integer ID | Object/null |
| `selectWhere($col, $val, $op)` | Select dengan kondisi WHERE | Column, Value, Operator | Array |
| `update($data)` | Update data (butuh WHERE) | Array data | Integer |
| `updateById($id, $data)` | Update berdasarkan ID | ID, Array data | Integer |
| `delete($id)` | Hapus data berdasarkan ID | Integer ID | Integer |
| `deleteById($id)` | Alias dari delete() | Integer ID | Integer |

### 1. INSERT - Tambah Data Baru

**Syntax:**
```php
$model->insert($data);
```

**Parameter:**
- `$data` (array): Associative array dengan key = nama kolom, value = nilai

**Return:** Object hasil insert (dengan ID yang baru dibuat)

**Contoh:**

```php
<?php
// Di Controller
class UserController extends Controller
{
    public function store()
    {
        $user = new User();
        
        // Data yang akan disimpan
        $data = array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'user'
        );
        
        // Insert data
        $result = $user->insert($data);
        
        if ($result) {
            // $result->id berisi ID yang baru dibuat
            $this->redirectBack('Data berhasil disimpan dengan ID: ' . $result->id, 'success');
        } else {
            $this->redirectBack('Gagal menyimpan data', 'error');
        }
    }
}
```

### 2. SELECT ALL - Ambil Semua Data

**Syntax:**
```php
$model->selectAll();
```

**Parameter:** Tidak ada

**Return:** Array of objects (semua record dari tabel)

**Contoh:**

```php
<?php
class UserController extends Controller
{
    public function index()
    {
        $user = new User();
        
        // Ambil semua data
        $users = $user->selectAll();
        
        // Kirim ke view
        $this->view('users/index', array('users' => $users));
    }
}
```

**Contoh di View:**

```php
<?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user->id; ?></td>
        <td><?php echo htmlspecialchars($user->nama); ?></td>
        <td><?php echo htmlspecialchars($user->email); ?></td>
    </tr>
<?php endforeach; ?>
```

### 3. SELECT ONE - Ambil Satu Data

**Syntax:**
```php
$model->selectOne($id);
```

**Parameter:**
- `$id` (integer): ID record yang akan diambil

**Return:** Object (single record) atau null jika tidak ditemukan

**Contoh:**

```php
<?php
class UserController extends Controller
{
    public function show($id)
    {
        $user = new User();
        
        // Ambil data berdasarkan ID
        $userData = $user->selectOne($id);
        
        if ($userData) {
            // Data ditemukan
            $this->view('users/show', array('user' => $userData));
        } else {
            // Data tidak ditemukan
            $this->redirectTo('users', 'Data tidak ditemukan', 'error');
        }
    }
}
```

**Contoh di View:**

```php
<h1>Detail User</h1>
<p><strong>ID:</strong> <?php echo $user->id; ?></p>
<p><strong>Nama:</strong> <?php echo htmlspecialchars($user->nama); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
```

### 4. SELECT WHERE - Ambil Data Dengan Kondisi

**Syntax:**
```php
$model->selectWhere($column, $value, $operator);
```

**Parameter:**
- `$column` (string): Nama kolom
- `$value` (mixed): Nilai yang dicari
- `$operator` (string): Operator (=, <, >, <=, >=, LIKE, dll) - Default: '='

**Return:** Array of objects (record yang memenuhi kondisi)

**Contoh:**

```php
<?php
$user = new User();

// Cari berdasarkan nama (LIKE)
$users = $user->selectWhere('nama', '%John%', 'LIKE');

// Cari berdasarkan email (exact match)
$users = $user->selectWhere('email', 'john@example.com', '=');
// Atau tanpa operator (default =)
$users = $user->selectWhere('email', 'john@example.com');

// Cari user aktif
$users = $user->selectWhere('status', 1);

// Cari umur lebih dari 18
$users = $user->selectWhere('age', 18, '>');

// Cari user dengan role admin
$admins = $user->selectWhere('role', 'admin');
```

### 5. UPDATE BY ID - Update Data

**Syntax:**
```php
$model->updateById($id, $data);
```

**Parameter:**
- `$id` (integer): ID record yang akan diupdate
- `$data` (array): Associative array data yang akan diupdate

**Return:** Integer (jumlah row yang affected)

**Contoh:**

```php
<?php
class UserController extends Controller
{
    public function update($id)
    {
        $user = new User();
        
        // Data yang akan diupdate
        $data = array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email'])
        );
        
        // Jika password diisi, update juga
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        
        // Update berdasarkan ID
        $affected = $user->updateById($id, $data);
        
        if ($affected > 0) {
            $this->redirectBack('Data berhasil diupdate', 'success');
        } else {
            $this->redirectBack('Tidak ada data yang diupdate', 'warning');
        }
    }
}
```

### 6. DELETE - Hapus Data

**Syntax:**
```php
$model->deleteById($id);
// atau
$model->delete($id);
```

**Parameter:**
- `$id` (integer): ID record yang akan dihapus

**Return:** Integer (jumlah row yang affected)

**Contoh:**

```php
<?php
class UserController extends Controller
{
    public function destroy($id)
    {
        $user = new User();
        
        // Hapus data
        $affected = $user->deleteById($id);
        
        if ($affected > 0) {
            $this->redirectBack('Data berhasil dihapus', 'success');
        } else {
            $this->redirectBack('Gagal menghapus data', 'error');
        }
    }
}
```

**Dengan Konfirmasi di View:**

```php
<form action="<?php echo base_url('users/' . $user->id . '/delete'); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>
```

### Tips CRUD

1. **Selalu gunakan clean_input()** untuk sanitasi data input
2. **Gunakan password_hash()** untuk password, jangan simpan plain text
3. **Cek hasil operasi** sebelum redirect atau tampilkan pesan
4. **Gunakan htmlspecialchars()** saat menampilkan data di view (XSS protection)
5. **Validasi data** sebelum insert/update

**📖 Dokumentasi lengkap:** [DOKUMENTASI_CRUD.md](_DEV/DOKUMENTASI_CRUD.md)

---

## 🔍 Query Builder

Query Builder memungkinkan Anda membuat query kompleks dengan method chaining yang mudah dibaca dan maintainable.

### Method Query Builder

| Method | Fungsi | Parameter | Return |
|--------|--------|-----------|--------|
| `where($col, $val, $op)` | Tambah kondisi WHERE | Column, Value, Operator | Model |
| `orWhere($col, $val, $op)` | Tambah kondisi OR WHERE | Column, Value, Operator | Model |
| `orderBy($col, $dir)` | Urutkan hasil | Column, Direction | Model |
| `limit($limit)` | Batasi jumlah hasil | Integer | Model |
| `offset($offset)` | Skip n record | Integer | Model |
| `get()` | Eksekusi query & ambil semua | - | Array |
| `first()` | Eksekusi query & ambil pertama | - | Object/null |
| `count()` | Hitung jumlah record | - | Integer |

### 1. WHERE - Kondisi WHERE

**Syntax:**
```php
$model->where($column, $value, $operator)->get();
```

**Contoh:**

```php
<?php
$user = new User();

// Single WHERE
$users = $user->where('nama', 'John')->get();

// Multiple WHERE (AND condition)
$users = $user->where('nama', 'John')
              ->where('status', 1)
              ->get();

// WHERE dengan operator
$users = $user->where('age', 18, '>')->get();
$users = $user->where('nama', '%John%', 'LIKE')->get();
$users = $user->where('created_at', '2024-01-01', '>=')->get();

// Complex WHERE
$users = $user->where('status', 1)
              ->where('verified', 1)
              ->where('created_at', '2024-01-01', '>')
              ->get();
```

### 2. OR WHERE - Kondisi OR WHERE

**Syntax:**
```php
$model->where(...)->orWhere(...)->get();
```

**Contoh:**

```php
<?php
$user = new User();

// WHERE dengan OR
$users = $user->where('nama', 'John')
              ->orWhere('nama', 'Jane')
              ->get();

// Kombinasi AND dan OR
$users = $user->where('status', 1)
              ->where('age', 18, '>')
              ->orWhere('role', 'admin')
              ->get();
// SQL: WHERE status = 1 AND age > 18 OR role = 'admin'

// Search di multiple fields
$search = $_GET['search'];
$users = $user->where('nama', "%{$search}%", 'LIKE')
              ->orWhere('email', "%{$search}%", 'LIKE')
              ->orWhere('phone', "%{$search}%", 'LIKE')
              ->get();
```

### 3. ORDER BY - Mengurutkan Hasil

**Syntax:**
```php
$model->orderBy($column, $direction)->get();
```

**Parameter:**
- `$column` (string): Nama kolom
- `$direction` (string): 'ASC' atau 'DESC' (default: 'ASC')

**Contoh:**

```php
<?php
$user = new User();

// Order ASC (ascending)
$users = $user->orderBy('nama', 'ASC')->get();

// Order DESC (descending)
$users = $user->orderBy('created_at', 'DESC')->get();

// Multiple order by
$users = $user->orderBy('status', 'DESC')
              ->orderBy('nama', 'ASC')
              ->get();

// Order by dengan WHERE
$users = $user->where('status', 1)
              ->orderBy('created_at', 'DESC')
              ->get();
```

### 4. LIMIT - Batasi Jumlah Hasil

**Syntax:**
```php
$model->limit($number)->get();
```

**Contoh:**

```php
<?php
$user = new User();

// Ambil 10 data pertama
$users = $user->limit(10)->get();

// Ambil 5 user terbaru
$users = $user->orderBy('created_at', 'DESC')
              ->limit(5)
              ->get();

// Ambil 10 user aktif
$users = $user->where('status', 1)
              ->limit(10)
              ->get();
```

### 5. OFFSET - Skip Record

**Syntax:**
```php
$model->offset($number)->get();
```

**Contoh:**

```php
<?php
$user = new User();

// Skip 10 record pertama
$users = $user->offset(10)->get();

// Pagination: Halaman 1 (0-9)
$users = $user->limit(10)->offset(0)->get();

// Pagination: Halaman 2 (10-19)
$users = $user->limit(10)->offset(10)->get();

// Pagination: Halaman 3 (20-29)
$users = $user->limit(10)->offset(20)->get();
```

### 6. GET - Eksekusi dan Ambil Semua

**Syntax:**
```php
$model->where(...)->get();
```

**Return:** Array of objects

**Contoh:**

```php
<?php
$user = new User();

// Get semua hasil query
$users = $user->where('status', 1)->get();

// Loop hasil
foreach ($users as $user) {
    echo $user->nama . '<br>';
}

// Cek apakah ada hasil
if (count($users) > 0) {
    echo "Ditemukan " . count($users) . " users";
}
```

### 7. FIRST - Ambil Hasil Pertama

**Syntax:**
```php
$model->where(...)->first();
```

**Return:** Object atau null

**Contoh:**

```php
<?php
$user = new User();

// Ambil user berdasarkan email
$user = $user->where('email', 'john@example.com')->first();

if ($user) {
    echo "Nama: " . $user->nama;
    echo "Email: " . $user->email;
} else {
    echo "User tidak ditemukan";
}

// Login check
$user = $user->where('email', $email)
            ->where('status', 1)
            ->first();

if ($user && password_verify($password, $user->password)) {
    // Login berhasil
}
```

### 8. COUNT - Hitung Jumlah Record

**Syntax:**
```php
$model->where(...)->count();
```

**Return:** Integer

**Contoh:**

```php
<?php
$user = new User();

// Hitung semua user
$total = $user->count();
echo "Total users: " . $total;

// Hitung user aktif
$active = $user->where('status', 1)->count();
echo "Active users: " . $active;

// Hitung admin
$admins = $user->where('role', 'admin')->count();

// Hitung user yang terdaftar hari ini
$today = date('Y-m-d');
$newUsers = $user->where('created_at', $today, 'LIKE')->count();
```

### Contoh Query Builder Kompleks

#### Pagination Lengkap

```php
<?php
class UserController extends Controller
{
    public function index()
    {
        $user = new User();
        
        // Pagination settings
        $perPage = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;
        
        // Get data
        $users = $user->where('status', 1)
                     ->orderBy('created_at', 'DESC')
                     ->limit($perPage)
                     ->offset($offset)
                     ->get();
        
        // Total records
        $total = $user->where('status', 1)->count();
        $totalPages = ceil($total / $perPage);
        
        // Send to view
        $this->view('users/index', array(
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total
        ));
    }
}
```

#### Search & Filter

```php
<?php
class UserController extends Controller
{
    public function search()
    {
        $user = new User();
        $search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
        $role = isset($_GET['role']) ? clean_input($_GET['role']) : '';
        
        // Build query
        $query = $user;
        
        // Add search condition
        if (!empty($search)) {
            $query = $query->where('nama', "%{$search}%", 'LIKE')
                          ->orWhere('email', "%{$search}%", 'LIKE');
        }
        
        // Add role filter
        if (!empty($role)) {
            $query = $query->where('role', $role);
        }
        
        // Execute
        $users = $query->orderBy('nama', 'ASC')->get();
        
        $this->view('users/search', array('users' => $users));
    }
}
```

#### Advanced Query

```php
<?php
$user = new User();

// Query kompleks untuk admin panel
$users = $user->where('status', 1)
              ->where('email_verified', 1)
              ->where('created_at', '2024-01-01', '>=')
              ->where('role', 'admin', '!=')
              ->orderBy('last_login', 'DESC')
              ->limit(50)
              ->get();

// Latest active users
$latestUsers = $user->where('status', 1)
                   ->where('last_login', date('Y-m-d'), 'LIKE')
                   ->orderBy('last_login', 'DESC')
                   ->limit(10)
                   ->get();
```

---

## 🎯 Routing

Routing mengatur URL dan mengarahkannya ke Controller dan Method yang sesuai.

### File Routing

Semua route didefinisikan di: `app/routes/routes.php`

### Format Route

```php
<?php
return array(
    array('METHOD', 'URI', 'Controller@method'),
    array('METHOD', 'URI', 'Controller@method', 'middleware'),
);
```

**Parameter:**
- `METHOD`: HTTP method (GET, POST, PUT, DELETE)
- `URI`: Path URL (bisa dengan parameter `{id}`, `{slug}`, dll)
- `Controller@method`: Nama controller dan method
- `middleware`: Opsional, nama middleware yang akan dijalankan

### Contoh Route Basic

```php
<?php
return array(
    // Homepage
    array('GET', '/', 'HomeController@index'),
    
    // Static pages
    array('GET', '/about', 'PageController@about'),
    array('GET', '/contact', 'PageController@contact'),
    
    // Users CRUD
    array('GET', '/users', 'UserController@index'),
    array('GET', '/users/create', 'UserController@create'),
    array('POST', '/users/store', 'UserController@store'),
    array('GET', '/users/{id}', 'UserController@show'),
    array('GET', '/users/{id}/edit', 'UserController@edit'),
    array('POST', '/users/{id}/update', 'UserController@update'),
    array('POST', '/users/{id}/delete', 'UserController@destroy'),
);
```

### Route dengan Parameter

```php
<?php
return array(
    // Single parameter
    array('GET', '/users/{id}', 'UserController@show'),
    array('GET', '/posts/{id}', 'PostController@show'),
    
    // Multiple parameters
    array('GET', '/category/{cat}/product/{id}', 'ProductController@show'),
    array('GET', '/blog/{year}/{month}/{slug}', 'BlogController@show'),
);
```

**Di Controller:**

```php
<?php
class UserController extends Controller
{
    // Parameter otomatis di-pass ke method
    public function show($id)
    {
        $user = new User();
        $userData = $user->selectOne($id);
        // ...
    }
}

class ProductController extends Controller
{
    public function show($cat, $id)
    {
        // $cat dan $id otomatis tersedia
    }
}
```

### Route dengan Middleware

```php
<?php
return array(
    // Route tanpa middleware (public)
    array('GET', '/', 'HomeController@index'),
    
    // Route dengan AuthMiddleware (harus login)
    array('GET', '/dashboard', 'DashboardController@index', 'auth'),
    array('GET', '/profile', 'ProfileController@index', 'auth'),
    array('POST', '/profile/update', 'ProfileController@update', 'auth'),
    
    // Route dengan GuestMiddleware (belum login)
    array('GET', '/login', 'AuthController@loginForm', 'guest'),
    array('POST', '/login', 'AuthController@login', 'guest'),
    array('GET', '/register', 'AuthController@registerForm', 'guest'),
    array('POST', '/register', 'AuthController@register', 'guest'),
    
    // Route dengan RoleMiddleware (hanya admin)
    array('GET', '/admin', 'AdminController@index', 'role:admin'),
    array('GET', '/admin/users', 'AdminController@users', 'role:admin'),
    
    // Multiple roles (admin atau moderator)
    array('GET', '/moderator', 'ModController@index', 'role:admin,moderator'),
);
```

### Resourceful Routing (CRUD)

Untuk CRUD lengkap, gunakan pattern ini:

```php
<?php
return array(
    // Resource: Users
    array('GET',    '/users',           'UserController@index'),    // List all
    array('GET',    '/users/create',    'UserController@create'),   // Show create form
    array('POST',   '/users',           'UserController@store'),    // Store new
    array('GET',    '/users/{id}',      'UserController@show'),     // Show detail
    array('GET',    '/users/{id}/edit', 'UserController@edit'),     // Show edit form
    array('POST',   '/users/{id}',      'UserController@update'),   // Update
    array('POST',   '/users/{id}/delete', 'UserController@destroy'), // Delete
);
```

### Named Routes

Untuk URL yang lebih clean dan mudah diingat:

```php
<?php
return array(
    // Auth routes
    array('GET',  '/login',     'AuthController@loginForm'),
    array('POST', '/login',     'AuthController@login'),
    array('GET',  '/register',  'AuthController@registerForm'),
    array('POST', '/register',  'AuthController@register'),
    array('GET',  '/logout',    'AuthController@logout'),
    
    // Dashboard
    array('GET', '/dashboard',      'DashboardController@index', 'auth'),
    array('GET', '/dashboard/stats', 'DashboardController@stats', 'auth'),
    
    // Admin
    array('GET', '/admin',              'AdminController@index', 'role:admin'),
    array('GET', '/admin/users',        'AdminController@users', 'role:admin'),
    array('GET', '/admin/settings',     'AdminController@settings', 'role:admin'),
);
```

### Tips Routing

1. **Urutkan dari yang spesifik ke general** - Route dengan parameter harus di bawah route static
2. **Gunakan naming convention** - Buat URL yang clean dan meaningful
3. **Group related routes** - Tempatkan route yang related berdekatan
4. **Protect dengan middleware** - Gunakan middleware untuk route yang perlu authentication
5. **RESTful pattern** - Ikuti pattern RESTful untuk API endpoints

---

## 🎮 Controller

Controller menangani logic aplikasi dan menghubungkan Model dengan View.

### Base Controller

Semua controller harus extends dari `Controller` class di `app/core/Controller.php`.

### Membuat Controller Baru

```php
<?php
// app/controllers/ProductController.php
require_once dirname(__FILE__) . '/../core/Controller.php';
require_once dirname(__FILE__) . '/../models/Product.php';

class ProductController extends Controller
{
    // Method untuk list all products
    public function index()
    {
        $product = new Product();
        $products = $product->selectAll();
        
        $this->view('products/index', array('products' => $products));
    }
    
    // Method untuk show detail product
    public function show($id)
    {
        $product = new Product();
        $productData = $product->selectOne($id);
        
        if ($productData) {
            $this->view('products/show', array('product' => $productData));
        } else {
            $this->error('Product not found', 404);
        }
    }
    
    // Method untuk show create form
    public function create()
    {
        $this->view('products/create');
    }
    
    // Method untuk store new product
    public function store()
    {
        $product = new Product();
        
        $data = array(
            'name' => clean_input($_POST['name']),
            'price' => clean_input($_POST['price']),
            'stock' => clean_input($_POST['stock']),
            'description' => clean_input($_POST['description'])
        );
        
        $result = $product->insert($data);
        
        if ($result) {
            $this->redirectTo('products', 'Product berhasil ditambahkan', 'success');
        } else {
            $this->redirectBack('Gagal menambahkan product', 'error');
        }
    }
    
    // Method untuk show edit form
    public function edit($id)
    {
        $product = new Product();
        $productData = $product->selectOne($id);
        
        if ($productData) {
            $this->view('products/edit', array('product' => $productData));
        } else {
            $this->redirectTo('products', 'Product tidak ditemukan', 'error');
        }
    }
    
    // Method untuk update product
    public function update($id)
    {
        $product = new Product();
        
        $data = array(
            'name' => clean_input($_POST['name']),
            'price' => clean_input($_POST['price']),
            'stock' => clean_input($_POST['stock']),
            'description' => clean_input($_POST['description'])
        );
        
        $affected = $product->updateById($id, $data);
        
        if ($affected > 0) {
            $this->redirectTo('products', 'Product berhasil diupdate', 'success');
        } else {
            $this->redirectBack('Tidak ada perubahan data', 'warning');
        }
    }
    
    // Method untuk delete product
    public function destroy($id)
    {
        $product = new Product();
        $affected = $product->deleteById($id);
        
        if ($affected > 0) {
            $this->redirectBack('Product berhasil dihapus', 'success');
        } else {
            $this->redirectBack('Gagal menghapus product', 'error');
        }
    }
}
```

### Method Controller yang Tersedia

#### 1. view($viewPath, $data)

Load dan tampilkan view dengan data.

```php
<?php
// View tanpa data
$this->view('home');

// View dengan data
$this->view('users/index', array(
    'users' => $users,
    'title' => 'Daftar User'
));

// Nested view
$this->view('admin/dashboard/index', $data);
```

#### 2. redirectTo($url, $message, $type)

Redirect ke URL tertentu dengan flash message.

```php
<?php
// Redirect ke users
$this->redirectTo('users');

// Redirect dengan message
$this->redirectTo('users', 'Data berhasil disimpan', 'success');

// Redirect ke homepage
$this->redirectTo('');

// Redirect ke external URL
$this->redirectTo('http://google.com');
```

#### 3. redirectBack($message, $type)

Redirect kembali ke halaman sebelumnya.

```php
<?php
// Redirect back tanpa message
$this->redirectBack();

// Redirect back dengan message
$this->redirectBack('Data berhasil disimpan', 'success');
$this->redirectBack('Terjadi kesalahan', 'error');
$this->redirectBack('Perhatian!', 'warning');
```

#### 4. error($message, $code)

Tampilkan halaman error.

```php
<?php
// Error 404
$this->error('Page not found', 404);

// Error 403
$this->error('Access denied', 403);

// Error 500
$this->error('Internal server error', 500);
```

### Contoh Controller Lengkap dengan Validation

```php
<?php
class UserController extends Controller
{
    public function store()
    {
        // Validation
        $errors = array();
        
        if (empty($_POST['nama'])) {
            $errors[] = 'Nama harus diisi';
        }
        
        if (empty($_POST['email'])) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email tidak valid';
        }
        
        if (empty($_POST['password'])) {
            $errors[] = 'Password harus diisi';
        } elseif (strlen($_POST['password']) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }
        
        // Jika ada error
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirectBack();
            return;
        }
        
        // Cek email sudah ada atau belum
        $user = new User();
        $exists = $user->where('email', $_POST['email'])->first();
        
        if ($exists) {
            $this->redirectBack('Email sudah digunakan', 'error');
            return;
        }
        
        // Insert data
        $data = array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'user'
        );
        
        $result = $user->insert($data);
        
        if ($result) {
            $this->redirectTo('users', 'User berhasil ditambahkan', 'success');
        } else {
            $this->redirectBack('Gagal menambahkan user', 'error');
        }
    }
}
```

---

## 📦 Model

Model menangani database operations dan business logic.

### Base Model

Semua model harus extends dari `Model` class di `app/core/Model.php`.

### Membuat Model Baru

```php
<?php
// app/models/Product.php
require_once dirname(__FILE__) . '/../core/Model.php';

class Product extends Model
{
    // Nama tabel (wajib)
    protected $table = 'tbl_product';
    
    // Daftar kolom (opsional)
    protected $fields = array('id', 'name', 'price', 'stock', 'description', 'created_at');
    
    // Custom method
    public function getActiveProducts()
    {
        return $this->where('status', 1)
                    ->where('stock', 0, '>')
                    ->orderBy('name', 'ASC')
                    ->get();
    }
    
    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }
    
    public function getTopProducts($limit = 10)
    {
        return $this->where('featured', 1)
                    ->where('status', 1)
                    ->orderBy('views', 'DESC')
                    ->limit($limit)
                    ->get();
    }
    
    public function searchProducts($keyword)
    {
        return $this->where('name', "%{$keyword}%", 'LIKE')
                    ->orWhere('description', "%{$keyword}%", 'LIKE')
                    ->where('status', 1)
                    ->orderBy('name', 'ASC')
                    ->get();
    }
}
```

### Property Model

```php
<?php
protected $table = 'nama_tabel';        // Wajib: nama tabel database
protected $fields = array('col1', ...); // Opsional: daftar kolom
```

### Contoh Model Lengkap

```php
<?php
// app/models/User.php
require_once dirname(__FILE__) . '/../core/Model.php';

class User extends Model
{
    protected $table = 'tbl_user';
    protected $fields = array('id', 'nama', 'email', 'password', 'role', 'status', 'created_at');
    
    /**
     * Get all active users
     */
    public function getActiveUsers()
    {
        return $this->where('status', 1)
                    ->orderBy('nama', 'ASC')
                    ->get();
    }
    
    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    
    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
                    ->where('status', 1)
                    ->get();
    }
    
    /**
     * Search users
     */
    public function searchUsers($keyword)
    {
        return $this->where('nama', "%{$keyword}%", 'LIKE')
                    ->orWhere('email', "%{$keyword}%", 'LIKE')
                    ->orderBy('nama', 'ASC')
                    ->get();
    }
    
    /**
     * Get users with pagination
     */
    public function getUsersPaginated($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        
        return $this->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($perPage)
                    ->offset($offset)
                    ->get();
    }
    
    /**
     * Count total users
     */
    public function getTotalUsers()
    {
        return $this->count();
    }
    
    /**
     * Count active users
     */
    public function getActiveUsersCount()
    {
        return $this->where('status', 1)->count();
    }
}
```

### Tips Model

1. **Buat method untuk query yang sering dipakai** - Jangan tulis query yang sama berulang-ulang
2. **Gunakan nama method yang descriptive** - `getActiveUsers()` lebih baik dari `getUsers()`
3. **Tambahkan comment/docblock** - Jelaskan fungsi dari method
4. **Validasi di model atau controller** - Tergantung kompleksitas business logic
5. **Jangan hardcode value** - Gunakan parameter untuk nilai yang dynamic

---

## 👁️ View

View menangani tampilan HTML yang ditampilkan ke user.

### Struktur View

```
app/views/
├── home.php              # Homepage
├── users/                # User views
│   ├── index.php         # List users
│   ├── show.php          # User detail
│   ├── create.php        # Create form
│   └── edit.php          # Edit form
├── products/             # Product views
│   ├── index.php
│   └── show.php
├── auth/                 # Auth views
│   ├── login.php
│   └── register.php
└── errors/               # Error views
    ├── error.php
    └── dd.php
```

### Contoh View - List Data

```php
<!-- app/views/users/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
    <style>
        .alert { padding: 10px; margin: 10px 0; }
        .alert.success { background: #d4edda; color: #155724; }
        .alert.error { background: #f8d7da; color: #721c24; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Daftar User</h1>
    
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert <?php echo $_SESSION['flash_type']; ?>">
            <?php 
            echo $_SESSION['flash_message']; 
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            ?>
        </div>
    <?php endif; ?>
    
    <!-- Action Buttons -->
    <div>
        <a href="<?php echo base_url('users/create'); ?>">+ Tambah User</a>
    </div>
    
    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo htmlspecialchars($user->nama); ?></td>
                    <td><?php echo htmlspecialchars($user->email); ?></td>
                    <td><?php echo $user->role; ?></td>
                    <td><?php echo $user->status == 1 ? 'Aktif' : 'Nonaktif'; ?></td>
                    <td>
                        <a href="<?php echo base_url('users/' . $user->id); ?>">Detail</a> |
                        <a href="<?php echo base_url('users/' . $user->id . '/edit'); ?>">Edit</a> |
                        <form action="<?php echo base_url('users/' . $user->id . '/delete'); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
```

### Contoh View - Create Form

```php
<!-- app/views/users/create.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; }
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Tambah User Baru</h1>
    
    <!-- Error Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <!-- Form -->
    <form action="<?php echo base_url('users/store'); ?>" method="POST">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required value="<?php echo isset($_SESSION['old']['nama']) ? $_SESSION['old']['nama'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required value="<?php echo isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit">Simpan</button>
            <a href="<?php echo base_url('users'); ?>">Batal</a>
        </div>
    </form>
    
    <?php unset($_SESSION['old']); ?>
</body>
</html>
```

### Menampilkan View dari Controller

```php
<?php
// Method 1: View tanpa data
$this->view('home');

// Method 2: View dengan data
$this->view('users/index', array(
    'users' => $users,
    'title' => 'Daftar User',
    'total' => count($users)
));

// Method 3: Nested view path
$this->view('admin/dashboard/index', $data);
```

### Tips View

1. **Gunakan htmlspecialchars()** untuk output user-generated content (XSS protection)
2. **Pisahkan logic dari view** - Logic di controller/model, view hanya untuk display
3. **Gunakan base_url()** untuk semua URL
4. **Flash message** untuk feedback user (success, error, warning)
5. **Validation error** tampilkan dengan user-friendly
6. **Old input** untuk re-populate form saat validation error

---

## 🔐 Authentication

### Login

```php
<?php
// app/controllers/AuthController.php
class AuthController extends Controller
{
    public function loginForm()
    {
        $this->view('auth/login');
    }
    
    public function login()
    {
        $email = clean_input($_POST['email']);
        $password = $_POST['password'];
        
        // Validation
        if (empty($email) || empty($password)) {
            $this->redirectBack('Email dan password harus diisi', 'error');
            return;
        }
        
        // Get user by email
        $user = new User();
        $userData = $user->where('email', $email)->first();
        
        // Check user exists dan password benar
        if ($userData && password_verify($password, $userData->password)) {
            // Check status aktif
            if ($userData->status != 1) {
                $this->redirectBack('Akun Anda tidak aktif', 'error');
                return;
            }
            
            // Set session
            $_SESSION['user_id'] = $userData->id;
            $_SESSION['user_name'] = $userData->nama;
            $_SESSION['user_email'] = $userData->email;
            $_SESSION['user_role'] = $userData->role;
            $_SESSION['logged_in'] = true;
            
            // Update last login (optional)
            $user->updateById($userData->id, array(
                'last_login' => date('Y-m-d H:i:s')
            ));
            
            $this->redirectTo('dashboard', 'Login berhasil', 'success');
        } else {
            $this->redirectBack('Email atau password salah', 'error');
        }
    }
}
```

### Register

```php
<?php
class AuthController extends Controller
{
    public function registerForm()
    {
        $this->view('auth/register');
    }
    
    public function register()
    {
        // Validation
        $errors = array();
        
        if (empty($_POST['nama'])) {
            $errors[] = 'Nama harus diisi';
        }
        
        if (empty($_POST['email'])) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        }
        
        if (empty($_POST['password'])) {
            $errors[] = 'Password harus diisi';
        } elseif (strlen($_POST['password']) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }
        
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            $errors[] = 'Konfirmasi password tidak cocok';
        }
        
        // Check errors
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $this->redirectBack();
            return;
        }
        
        // Check email already exists
        $user = new User();
        $exists = $user->where('email', $_POST['email'])->first();
        
        if ($exists) {
            $this->redirectBack('Email sudah terdaftar', 'error');
            return;
        }
        
        // Insert new user
        $data = array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 1
        );
        
        $result = $user->insert($data);
        
        if ($result) {
            $this->redirectTo('login', 'Registrasi berhasil, silakan login', 'success');
        } else {
            $this->redirectBack('Gagal melakukan registrasi', 'error');
        }
    }
}
```

### Logout

```php
<?php
class AuthController extends Controller
{
    public function logout()
    {
        // Hapus semua session
        session_unset();
        session_destroy();
        
        $this->redirectTo('login', 'Logout berhasil', 'success');
    }
}
```

### Cek Authentication di View

```php
<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    <!-- User sudah login -->
    <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
    <a href="<?php echo base_url('logout'); ?>">Logout</a>
<?php else: ?>
    <!-- User belum login -->
    <a href="<?php echo base_url('login'); ?>">Login</a>
    <a href="<?php echo base_url('register'); ?>">Register</a>
<?php endif; ?>
```

### Cek Authentication di Controller

```php
<?php
class DashboardController extends Controller
{
    public function index()
    {
        // Check if user logged in
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            $this->redirectTo('login', 'Silakan login terlebih dahulu', 'warning');
            return;
        }
        
        // User sudah login, tampilkan dashboard
        $this->view('dashboard/index');
    }
}
```

**📖 Dokumentasi lengkap:** [CONTOH_IMPLEMENTASI_AUTH.md](_DEV/CONTOH_IMPLEMENTASI_AUTH.md)

---

## 🛡️ Middleware

Middleware adalah filter yang dijalankan sebelum request sampai ke controller. Berguna untuk authentication, authorization, logging, dll.

### Jenis Middleware Built-in

1. **AuthMiddleware** - Hanya untuk user yang sudah login
2. **GuestMiddleware** - Hanya untuk user yang belum login  
3. **RoleMiddleware** - Filter berdasarkan role user (admin, user, dll)

### AuthMiddleware

Memastikan user sudah login sebelum mengakses route.

```php
<?php
// app/middlewares/AuthMiddleware.php
class AuthMiddleware extends Middleware
{
    public function handle()
    {
        // Cek apakah user sudah login
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            // Belum login, redirect ke login page
            header('Location: ' . base_url('login'));
            exit;
        }
        
        // Sudah login, lanjutkan ke controller
    }
}
```

**Penggunaan di route:**

```php
<?php
array('GET', '/dashboard', 'DashboardController@index', 'auth'),
array('GET', '/profile', 'ProfileController@index', 'auth'),
```

### GuestMiddleware

Hanya untuk user yang belum login (redirect jika sudah login).

```php
<?php
// app/middlewares/GuestMiddleware.php
class GuestMiddleware extends Middleware
{
    public function handle()
    {
        // Cek apakah user sudah login
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            // Sudah login, redirect ke dashboard
            header('Location: ' . base_url('dashboard'));
            exit;
        }
        
        // Belum login, lanjutkan ke controller (login/register page)
    }
}
```

**Penggunaan di route:**

```php
<?php
array('GET', '/login', 'AuthController@loginForm', 'guest'),
array('GET', '/register', 'AuthController@registerForm', 'guest'),
```

### RoleMiddleware

Filter berdasarkan role user (admin, moderator, user, dll).

```php
<?php
// app/middlewares/RoleMiddleware.php
class RoleMiddleware extends Middleware
{
    private $allowedRoles = array();
    
    public function setRoles($roles)
    {
        $this->allowedRoles = explode(',', $roles);
    }
    
    public function handle()
    {
        // Cek apakah user sudah login
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: ' . base_url('login'));
            exit;
        }
        
        // Cek role user
        $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';
        
        if (!in_array($userRole, $this->allowedRoles)) {
            // Role tidak sesuai, tampilkan error
            header('HTTP/1.0 403 Forbidden');
            echo 'Access Denied: You do not have permission to access this page.';
            exit;
        }
        
        // Role sesuai, lanjutkan ke controller
    }
}
```

**Penggunaan di route:**

```php
<?php
// Hanya admin
array('GET', '/admin', 'AdminController@index', 'role:admin'),

// Hanya admin dan moderator
array('GET', '/moderator', 'ModController@index', 'role:admin,moderator'),

// Multiple roles
array('GET', '/special', 'SpecialController@index', 'role:admin,premium,vip'),
```

### Membuat Middleware Custom

```php
<?php
// app/middlewares/CustomMiddleware.php
require_once dirname(__FILE__) . '/../core/Middleware.php';

class CustomMiddleware extends Middleware
{
    public function handle()
    {
        // Custom logic
        // Contoh: Check IP address
        $allowedIPs = array('127.0.0.1', '::1');
        $userIP = $_SERVER['REMOTE_ADDR'];
        
        if (!in_array($userIP, $allowedIPs)) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Access Denied: Your IP is not allowed.';
            exit;
        }
        
        // Lanjutkan ke controller
    }
}
```

**Register middleware di Router:**

```php
<?php
// app/core/Router.php
// Tambahkan di method handleMiddleware()
case 'custom':
    require_once __DIR__ . '/../middlewares/CustomMiddleware.php';
    $middleware = new CustomMiddleware();
    $middleware->handle();
    break;
```

**Penggunaan di route:**

```php
<?php
array('GET', '/secret', 'SecretController@index', 'custom'),
```

### Contoh Middleware Kompleks

```php
<?php
// Middleware untuk check subscription
class SubscriptionMiddleware extends Middleware
{
    public function handle()
    {
        // Check user login
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('login'));
            exit;
        }
        
        // Check subscription status
        $user = new User();
        $userData = $user->selectOne($_SESSION['user_id']);
        
        if (!$userData || $userData->subscription_status != 'active') {
            header('Location: ' . base_url('subscribe'));
            exit;
        }
        
        // Check subscription expiry
        if (strtotime($userData->subscription_end) < time()) {
            header('Location: ' . base_url('renew-subscription'));
            exit;
        }
        
        // All checks passed
    }
}
```

**📖 Dokumentasi lengkap:** [DOKUMENTASI_MIDDLEWARE.md](_DEV/DOKUMENTASI_MIDDLEWARE.md)

---

## 💡 Helper Functions

Helper functions adalah fungsi-fungsi global yang bisa dipanggil dari mana saja.

### 1. base_url($path)

Membuat URL lengkap dari base URL aplikasi.

```php
<?php
// Basic usage
echo base_url('users');              // http://localhost/mvc/users
echo base_url('users/create');       // http://localhost/mvc/users/create
echo base_url();                     // http://localhost/mvc/

// Di view
<a href="<?php echo base_url('products'); ?>">Products</a>
<a href="<?php echo base_url('users/' . $user->id); ?>">Detail</a>

// Di form action
<form action="<?php echo base_url('users/store'); ?>" method="POST">
```

### 2. env($key, $default)

Mengambil nilai dari file .env.

```php
<?php
// Dengan default value
$dbHost = env('DB_HOST', 'localhost');
$appName = env('APP_NAME', 'My App');
$debug = env('APP_DEBUG', false);

// Tanpa default value
$dbName = env('DB_NAME');

// Usage example
if (env('APP_DEBUG', false)) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
```

### 3. clean_input($data)

Membersihkan input dari karakter berbahaya (sanitization).

```php
<?php
// Clean single input
$nama = clean_input($_POST['nama']);
$email = clean_input($_POST['email']);

// Clean in array
$data = array(
    'nama' => clean_input($_POST['nama']),
    'email' => clean_input($_POST['email']),
    'address' => clean_input($_POST['address'])
);

// Clean array of inputs
foreach ($_POST as $key => $value) {
    $_POST[$key] = clean_input($value);
}
```

### 4. dd($data)

Debug and dump data (die and dump). Menampilkan data dan stop execution.

```php
<?php
// Dump array
$users = $user->selectAll();
dd($users);

// Dump object
$user = $user->selectOne(1);
dd($user);

// Dump multiple variables
dd($users, $products, $categories);

// Dump with label
dd('Users Data:', $users);
```

### 5. redirect($url)

Redirect ke URL tertentu.

```php
<?php
// Redirect ke URL internal
redirect('users');
redirect('dashboard');
redirect('login');

// Redirect ke homepage
redirect('');

// Redirect ke external URL
redirect('http://google.com');
```

### 6. session_get($key, $default)

Mengambil nilai dari session.

```php
<?php
// Get dengan default value
$userId = session_get('user_id', 0);
$userName = session_get('user_name', 'Guest');

// Get tanpa default
$userId = session_get('user_id');

// Check if session exists
if (session_get('logged_in')) {
    echo "User is logged in";
}
```

### 7. session_set($key, $value)

Menyimpan nilai ke session.

```php
<?php
// Set single value
session_set('user_id', 123);
session_set('user_name', 'John Doe');

// Set multiple values
session_set('user_id', $user->id);
session_set('user_name', $user->nama);
session_set('user_email', $user->email);
session_set('logged_in', true);
```

### 8. flash_message($message, $type)

Set flash message untuk notifikasi one-time.

```php
<?php
// Success message
flash_message('Data berhasil disimpan', 'success');

// Error message
flash_message('Terjadi kesalahan', 'error');

// Warning message
flash_message('Perhatian! Data akan dihapus', 'warning');

// Info message
flash_message('Informasi penting', 'info');
```

**Display flash message di view:**

```php
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="alert <?php echo $_SESSION['flash_type']; ?>">
        <?php 
        echo $_SESSION['flash_message']; 
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        ?>
    </div>
<?php endif; ?>
```

### 9. old($key, $default)

Mengambil old input value (untuk re-populate form saat validation error).

```php
<!-- Form with old input -->
<input type="text" name="nama" value="<?php echo old('nama'); ?>">
<input type="email" name="email" value="<?php echo old('email'); ?>">
<textarea name="address"><?php echo old('address'); ?></textarea>
```

### 10. is_logged_in()

Check apakah user sudah login.

```php
<?php
// Di controller
if (!is_logged_in()) {
    $this->redirectTo('login', 'Please login first', 'warning');
    return;
}

// Di view
<?php if (is_logged_in()): ?>
    <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
<?php else: ?>
    <a href="<?php echo base_url('login'); ?>">Login</a>
<?php endif; ?>
```

### 11. has_role($role)

Check apakah user memiliki role tertentu.

```php
<?php
// Di controller
if (!has_role('admin')) {
    $this->error('Access Denied', 403);
    return;
}

// Di view
<?php if (has_role('admin')): ?>
    <a href="<?php echo base_url('admin'); ?>">Admin Panel</a>
<?php endif; ?>

// Multiple roles
if (has_role('admin') || has_role('moderator')) {
    // User is admin or moderator
}
```

### Contoh Penggunaan Helper Functions

```php
<?php
class UserController extends Controller
{
    public function store()
    {
        // 1. Clean all inputs
        $nama = clean_input($_POST['nama']);
        $email = clean_input($_POST['email']);
        $password = $_POST['password'];
        
        // 2. Check if user logged in
        if (!is_logged_in()) {
            redirect('login');
            return;
        }
        
        // 3. Check role
        if (!has_role('admin')) {
            flash_message('You are not authorized', 'error');
            $this->redirectBack();
            return;
        }
        
        // 4. Insert data
        $user = new User();
        $data = array(
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );
        
        $result = $user->insert($data);
        
        // 5. Redirect with flash message
        if ($result) {
            flash_message('User created successfully', 'success');
            redirect('users');
        } else {
            flash_message('Failed to create user', 'error');
            $this->redirectBack();
        }
    }
}
```

---

## 🔒 Security

### Security Features

Template ini dilengkapi dengan berbagai fitur keamanan:

1. **Prepared Statements** - Mencegah SQL Injection
2. **Input Sanitization** - Membersihkan input user
3. **XSS Protection** - Mencegah Cross-Site Scripting
4. **Password Hashing** - Password tidak disimpan plain text
5. **CSRF Protection** - Bisa ditambahkan untuk form
6. **Environment Variables** - Data sensitif di .env (tidak di-commit)

### 1. SQL Injection Protection

**Menggunakan Prepared Statements:**

```php
<?php
// ✅ AMAN - Menggunakan prepared statements
$user = $user->where('email', $email)->first();

// ✅ AMAN - Method CRUD otomatis menggunakan prepared statements
$user->insert($data);
$user->updateById($id, $data);
$user->deleteById($id);

// ❌ TIDAK AMAN - Raw query tanpa prepared statements
// JANGAN LAKUKAN INI:
// $query = "SELECT * FROM users WHERE email = '$email'";
```

### 2. XSS (Cross-Site Scripting) Protection

**Menggunakan htmlspecialchars():**

```php
<!-- ✅ AMAN - Output di-escape -->
<p><?php echo htmlspecialchars($user->nama); ?></p>
<p><?php echo htmlspecialchars($user->email); ?></p>

<!-- ❌ TIDAK AMAN - Output langsung -->
<!-- <p><?php echo $user->nama; ?></p> -->
```

### 3. Input Sanitization

**Menggunakan clean_input():**

```php
<?php
// ✅ AMAN - Input di-sanitize
$nama = clean_input($_POST['nama']);
$email = clean_input($_POST['email']);

// ✅ AMAN - Clean semua input
$data = array(
    'nama' => clean_input($_POST['nama']),
    'email' => clean_input($_POST['email']),
    'address' => clean_input($_POST['address'])
);

// ❌ TIDAK AMAN - Langsung dari $_POST
// $nama = $_POST['nama'];
```

### 4. Password Security

**Menggunakan password_hash() dan password_verify():**

```php
<?php
// ✅ AMAN - Hash password sebelum simpan
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$user->insert(array(
    'password' => $hashedPassword
));

// ✅ AMAN - Verify password saat login
if (password_verify($_POST['password'], $user->password)) {
    // Password benar
}

// ❌ TIDAK AMAN - Plain text password
// $user->insert(array('password' => $_POST['password']));
// if ($_POST['password'] === $user->password) { }
```

### 5. CSRF Protection

Menambahkan CSRF token untuk form:

```php
<?php
// Generate CSRF token
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
```

**Di form:**

```php
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
    <!-- form fields -->
</form>
```

**Di controller:**

```php
<?php
if (!verify_csrf_token($_POST['csrf_token'])) {
    $this->error('Invalid CSRF token', 403);
    return;
}
```

### 6. File Upload Security

Jika menambahkan fitur upload file:

```php
<?php
function secure_upload($file, $allowed_types = array('jpg', 'png', 'pdf')) {
    // Check file exists
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    // Check file size (max 2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        return false;
    }
    
    // Check file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_types)) {
        return false;
    }
    
    // Check mime type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    $allowed_mimes = array(
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    );
    
    if (!isset($allowed_mimes[$ext]) || $mime !== $allowed_mimes[$ext]) {
        return false;
    }
    
    // Generate random filename
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $destination = 'uploads/' . $filename;
    
    // Move file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }
    
    return false;
}
```

### 7. Environment Variables Security

```env
# ✅ JANGAN commit file .env ke repository
# ✅ Tambahkan .env ke .gitignore
# ✅ Gunakan .env.example sebagai template

# .gitignore
.env
storage/logs/*.log
```

### 8. Headers Security

Tambahkan security headers di `public/index.php`:

```php
<?php
// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Untuk production, gunakan HTTPS
if (env('APP_ENV') === 'production') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}
```

### Security Checklist

- ✅ Selalu gunakan prepared statements untuk query
- ✅ Sanitize semua input dengan clean_input()
- ✅ Escape semua output dengan htmlspecialchars()
- ✅ Hash password dengan password_hash()
- ✅ Validate input di server-side (jangan hanya di client-side)
- ✅ Gunakan HTTPS untuk production
- ✅ Jangan commit .env ke repository
- ✅ Set display_errors=false di production
- ✅ Update PHP dan dependencies secara rutin
- ✅ Limit file upload size dan type
- ✅ Use CSRF protection untuk form
- ✅ Implement rate limiting untuk login

**📖 Dokumentasi lengkap:** [DOKUMENTASI_SECURITY.md](_DEV/DOKUMENTASI_SECURITY.md)

---

## 🔧 Kompatibilitas PHP

Template ini mendukung berbagai versi PHP dengan auto-detection system.

### PHP Version Support

| PHP Version | Support | Database Driver |
|-------------|---------|-----------------|
| PHP 5.2 | ✅ Full Support | mysql_* functions |
| PHP 5.3 - 5.6 | ✅ Full Support | PDO or mysql_* |
| PHP 7.0 - 7.4 | ✅ Full Support | PDO |
| PHP 8.0+ | ✅ Full Support | PDO |

### Auto-Detection System

System otomatis detect versi PHP dan menggunakan driver yang sesuai:

```php
<?php
// app/core/Database.php
if (class_exists('PDO')) {
    // PHP 7+ - Gunakan PDO
    $this->connection = new PDO($dsn, $user, $pass);
} else {
    // PHP 5.2 - Gunakan mysql_*
    $this->connection = mysql_connect($host, $user, $pass);
}
```

### Fitur Per Versi PHP

#### PHP 5.2

**Fitur yang Didukung:**
- ✅ Semua CRUD operations
- ✅ Query Builder
- ✅ Routing
- ✅ MVC pattern
- ✅ Session management
- ✅ Basic security

**Database Driver:**
- Menggunakan `mysql_*` functions
- `mysql_connect()`, `mysql_query()`, dll
- `mysql_real_escape_string()` untuk escape

**Fallback Functions:**
```php
<?php
// Password hashing fallback untuk PHP < 5.5
if (!function_exists('password_hash')) {
    function password_hash($password, $algo) {
        return md5($password . env('SECURITY_SALT', ''));
    }
    
    function password_verify($password, $hash) {
        return md5($password . env('SECURITY_SALT', '')) === $hash;
    }
}
```

#### PHP 7+

**Fitur yang Didukung:**
- ✅ Semua fitur PHP 5.2
- ✅ PDO dengan prepared statements
- ✅ Better error handling
- ✅ Native password functions
- ✅ Type declarations
- ✅ Better performance

**Database Driver:**
- Menggunakan PDO
- Prepared statements untuk security
- Better error handling dengan try-catch

**Contoh:**
```php
<?php
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(array(':email' => $email));
} catch (PDOException $e) {
    error_log($e->getMessage());
}
```

#### PHP 8+

**Fitur yang Didukung:**
- ✅ Semua fitur PHP 7
- ✅ Named arguments
- ✅ Match expressions
- ✅ Null safe operator
- ✅ Constructor property promotion
- ✅ Union types

**Contoh PHP 8 Features:**
```php
<?php
// Named arguments
$user->insert(
    data: array('nama' => 'John'),
    validate: true
);

// Null safe operator
$userName = $user?->profile?->name ?? 'Guest';

// Match expression
$message = match($status) {
    'success' => 'Data berhasil disimpan',
    'error' => 'Terjadi kesalahan',
    default => 'Status tidak diketahui'
};
```

### Testing Kompatibilitas

File `_DEV/test_compatibility.php` untuk test kompatibilitas:

```php
<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PDO Available: " . (class_exists('PDO') ? 'Yes' : 'No') . "\n";
echo "mysql_* Available: " . (function_exists('mysql_connect') ? 'Yes' : 'No') . "\n";
```

### Best Practices

1. **Gunakan features yang compatible** - Hindari PHP 8-only features jika support PHP 5.2
2. **Test di multiple PHP versions** - Test di PHP 5.2, 7, dan 8
3. **Use fallback functions** - Untuk features yang tidak ada di PHP lama
4. **Check function exists** - Gunakan `function_exists()` sebelum pakai function baru
5. **Document requirements** - Jelaskan minimum PHP version jika gunakan feature khusus

---

## 💎 Tips & Best Practices

### 1. Struktur Kode

```php
<?php
// ✅ BAIK - Terstruktur dan readable
class UserController extends Controller
{
    public function index()
    {
        $user = new User();
        $users = $user->where('status', 1)
                     ->orderBy('nama', 'ASC')
                     ->get();
        
        $this->view('users/index', array('users' => $users));
    }
}

// ❌ TIDAK BAIK - Logic di view
// Jangan campur logic kompleks di view
```

### 2. Database Naming Convention

```sql
-- ✅ BAIK - Consistent naming
tbl_user
tbl_product
tbl_category
tbl_order

-- Column names
id, nama, email, created_at, updated_at

-- ❌ TIDAK BAIK - Inconsistent
users, product, Categories, ORDER
```

### 3. Security

```php
<?php
// ✅ SELALU clean input
$nama = clean_input($_POST['nama']);

// ✅ SELALU escape output
echo htmlspecialchars($user->nama);

// ✅ SELALU hash password
password_hash($password, PASSWORD_DEFAULT);

// ✅ SELALU validate di server-side
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid
}
```

### 4. Error Handling

```php
<?php
// ✅ BAIK - Check result dan handle error
$result = $user->insert($data);
if ($result) {
    flash_message('Success', 'success');
} else {
    flash_message('Failed', 'error');
}

// ✅ BAIK - Check data exists
$userData = $user->selectOne($id);
if (!$userData) {
    $this->error('Not found', 404);
    return;
}
```

### 5. Clean Code

```php
<?php
// ✅ BAIK - Descriptive names
public function getActiveUsers() { }
public function getUsersByRole($role) { }

// ❌ TIDAK BAIK - Unclear names
public function get() { }
public function doSomething() { }

// ✅ BAIK - Comments untuk complex logic
/**
 * Get users with pagination and filters
 * @param int $page Current page
 * @param int $perPage Items per page
 * @param array $filters Filter conditions
 * @return array Users data
 */
public function getUsersPaginated($page, $perPage, $filters = array()) { }
```

### 6. Performance

```php
<?php
// ✅ BAIK - Limit query results
$users = $user->limit(100)->get();

// ✅ BAIK - Use specific columns
$users = $user->select('id, nama, email')->get();

// ❌ TIDAK BAIK - Query all tanpa limit
// $users = $user->get(); // Bisa return ribuan rows
```

### 7. DRY Principle (Don't Repeat Yourself)

```php
<?php
// ✅ BAIK - Create reusable method
class User extends Model
{
    public function getActiveUsers()
    {
        return $this->where('status', 1)
                   ->orderBy('nama', 'ASC')
                   ->get();
    }
}

// Di berbagai controller
$activeUsers = $user->getActiveUsers();

// ❌ TIDAK BAIK - Repeat same query
// $users = $user->where('status', 1)->orderBy('nama', 'ASC')->get();
// Tulis query yang sama di banyak tempat
```

---

## 🔍 Troubleshooting

### Error: Headers already sent

**Penyebab:** Output sebelum redirect atau header()

**Solusi:**
```php
<?php
// Pastikan tidak ada output (echo, HTML, whitespace) sebelum redirect
// ❌ SALAH
echo "Test";
$this->redirectTo('users');

// ✅ BENAR
$this->redirectTo('users');
```

### Error: Database connection failed

**Penyebab:** Konfigurasi database salah atau MySQL tidak running

**Solusi:**
1. Check file `.env` - pastikan DB_HOST, DB_NAME, DB_USER, DB_PASS benar
2. Pastikan MySQL service running (XAMPP: Start MySQL)
3. Test connection manual via phpMyAdmin

### Error: Class not found

**Penyebab:** File tidak di-require atau path salah

**Solusi:**
```php
<?php
// Pastikan require_once path benar
require_once dirname(__FILE__) . '/../core/Model.php';
require_once dirname(__FILE__) . '/../models/User.php';
```

### Error: Call to undefined method

**Penyebab:** Method tidak ada di class atau salah ketik

**Solusi:**
- Check nama method sudah benar
- Pastikan class extends dari base class yang benar
- Check dokumentasi method yang available

### Session tidak persist

**Penyebab:** session_start() belum dipanggil

**Solusi:**
- Pastikan `session_start()` ada di `public/index.php`
- Check tidak ada output sebelum session_start()

### .env tidak terbaca

**Penyebab:** File .env tidak ada atau path salah

**Solusi:**
1. Copy `.env.example` ke `.env`
2. Edit `.env` dan isi konfigurasi
3. Pastikan Env::load() dipanggil di init.php

### Base URL salah

**Penyebab:** BASE_URL di .env tidak sesuai

**Solusi:**
```env
# Untuk XAMPP
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# Untuk PHP built-in server
BASE_URL=http://localhost:8000/
```

### Error 404 di semua route

**Penyebab:** Routing tidak disetup dengan benar

**Solusi:**
1. Check file `app/routes/routes.php` ada dan benar
2. Pastikan .htaccess ada di folder public (jika pakai Apache)
3. Untuk PHP built-in server, jalankan dari public folder: `php -S localhost:8000 -t public`

---

## 📝 Changelog

### Version 2.2 (Latest - 2024)
- ✅ Dokumentasi lengkap dan terstruktur
- ✅ Authentication & Authorization system
- ✅ Middleware system (Auth, Guest, Role)
- ✅ Security features lengkap
- ✅ Helper functions tambahan
- ✅ Error handling improvement
- ✅ Flash message system
- ✅ Session management
- ✅ CSRF protection ready

### Version 2.1
- ✅ Environment configuration system (.env)
- ✅ Env class untuk load environment variables
- ✅ Semua config terpusat di .env
- ✅ Storage directory untuk logs & cache
- ✅ .gitignore untuk keamanan
- ✅ Dokumentasi lengkap environment config

### Version 2.0
- ✅ Kompatibilitas PHP 5.2 - 8+
- ✅ Auto-detect PDO/mysql_*
- ✅ Method CRUD lengkap dengan alias
- ✅ Query builder support
- ✅ Dokumentasi lengkap
- ✅ Contoh implementasi

### Version 1.0
- Basic MVC structure
- PDO only support
- Simple CRUD

---

## 🤝 Contributing

Contributions are welcome! Jika Anda ingin berkontribusi:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 License

MIT License - Feel free to use this template for your projects.

---

## 👨‍💻 Author

Created with ❤️ for maximum PHP compatibility

---

## 📚 Dokumentasi Tambahan

Untuk dokumentasi lebih detail, lihat folder `_DEV/`:

- [DOKUMENTASI_CRUD.md](_DEV/DOKUMENTASI_CRUD.md) - Dokumentasi lengkap CRUD operations
- [DOKUMENTASI_ENV.md](_DEV/DOKUMENTASI_ENV.md) - Dokumentasi environment configuration
- [DOKUMENTASI_MIDDLEWARE.md](_DEV/DOKUMENTASI_MIDDLEWARE.md) - Dokumentasi middleware system
- [DOKUMENTASI_SECURITY.md](_DEV/DOKUMENTASI_SECURITY.md) - Dokumentasi security features
- [CONTOH_IMPLEMENTASI.md](_DEV/CONTOH_IMPLEMENTASI.md) - Contoh implementasi lengkap
- [CONTOH_IMPLEMENTASI_AUTH.md](_DEV/CONTOH_IMPLEMENTASI_AUTH.md) - Contoh authentication

---

## 📞 Support

Jika ada pertanyaan atau issues, silakan buat issue di GitHub repository.

---

**Happy Coding!** 🚀

---

**Last Updated:** 2024
**Version:** 2.2.0
**Compatibility:** PHP 5.2, 7.x, 8.x+
