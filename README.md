# MVC-PHP-5-TEMPLATE

Template MVC PHP yang **kompatibel dengan PHP 5.2, 7, 8 dan versi lebih tinggi**. Terinspirasi dari Laravel dan CodeIgniter dengan konfigurasi yang disesuaikan untuk mendukung berbagai versi PHP.

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

## 📁 Struktur Folder

```
MVC-PHP-5-TEMPLATE/
├── .env                             # Environment configuration
├── .env.example                     # Environment template
├── .gitignore
├── _DEV/
│   ├── DOKUMENTASI_CRUD.md          # Dokumentasi lengkap CRUD
│   ├── DOKUMENTASI_ENV.md           # Dokumentasi environment config
│   ├── CONTOH_IMPLEMENTASI.md       # Contoh implementasi CRUD
│   ├── FIX_ERROR_LOG.md            # Log perbaikan error
│   └── database.sql                 # SQL schema
├── app/
│   ├── init.php
│   ├── controllers/
│   │   └── HomeController.php
│   ├── core/
│   │   ├── App.php
│   │   ├── Config.php               # Konfigurasi (baca dari .env)
│   │   ├── Controller.php
│   │   ├── Database.php             # Support PHP 5.2 - 8+
│   │   ├── Env.php                  # Environment loader
│   │   ├── Model.php                # CRUD methods lengkap
│   │   └── Router.php
│   ├── models/
│   │   └── User.php
│   ├── routes/
│   │   └── routes.php
│   └── views/
│       └── home.php
├── public/
│   └── index.php
├── storage/
│   ├── cache/
│   └── logs/
└── README.md
```

## 🚀 QSetup Environment Configuration

```bash
# Copy .env.example ke .env
copy .env.example .env

# Edit .env dan sesuaikan dengan environment Anda
notepad .env
```

### 3. Konfigurasi Database

Edit4. Import Database

```sql
CREATE DATABASE crudtest;
USE crudtest;

CREATE TABLE tbl_user (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Atau import dari file SQL:

```bash
mysql -u root -p crudtest < _DEV/database.sql
```

### 5
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'crudtest');
define('DB_PORT', '3306');
```

### 3. Import Database

```sql
CREATE DATABASE crudtest;
USE crudtest;

CREATE TABLE tbl_user (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4. Jalankan Aplikasi

```bash
# Untuk PHP built-in server
php -S localhost:8000 -t public

# Atau gunakan XAMPP/WAMP
# Akses: http://localhost/MVC-PHP-5-TEMPLATE/
```

## 📚 Dokumentasi CRUD

### Method yang Tersedia

|             Method             |        Fungsi       | Return  |
|--------------------------------|---------------------|---------|
| `insert($data)`                | Tambah data baru    | Object  |
| `selectAll()`                  | Ambil semua data    | Array   |
| `selectOne($id)`               | Ambil satu data     | Object  |
| `selectWhere($col, $val, $op)` | Select dengan WHERE | Array   |
| `update($data)`                | Update data         | Integer |
| `updateById($id, $data)`       | Update by ID        | Integer |
| `delete($id)`                  | Hapus data          | Integer |
| `deleteById($id)`              | Alias delete        | Integer |

### Contoh Penggunaan

```php
$user = new User();

// INSERT
$user->insert(array('nama' => 'John Doe'));

// SELECT ALL
$allUsers = $user->selectAll();

// SELECT ONE
$oneUser = $user->selectOne(1);

// SELECT WHERE
$users = $user->selectWhere('nama', '%John%', 'LIKE');

// UPDATE BY ID
$user->updateById(1, array('nama' => 'Jane Doe'));

// DELETE BY ID
$user->deleteById(1);
```

### Query Builder

```php
$user = new User();

// Single WHERE
$users = $user->where('nama', 'John')->get();

// Multiple WHERE
$users = $user->where('nama', 'John')
              ->where('age', 18, '>')
              ->get();

// Get first result
$user = $user->where('email', 'john@example.com')->first();
```

## 🔧 Kompatibilitas PHP

### PHP 5.2
- Menggunakan `mysql_*` functions
- Tidak memerlukan PDO extension
- Full support untuk semua CRUD operations

### PHP 7+
- Menggunakan PDO dengan prepared statements
- Error handling lebih baik
- Performance optimal

### PHP 8+
- Full PDO support
- Named arguments ready
- Modern PHP features

## 📖 Dokumentasi Lengkap

Untuk dokumentasi lebih detail, lihat:
- [DOKUMENTASI_CRUD.md](_DEV/DOKUMENTASI_CRUD.md) - Dokumentasi lengkap semua method
- [CONTOH_IMPLEMENTASI.md](_DEV/CONTOH_IMPLEMENTASI.md) - Contoh implementasi lengkap dengan view

## 🛠️ Membuat Model Baru

```php
<?php 
require_once dirname(__FILE__) . '/../core/Model.php';

class Product extends Model
{
    protected $table = 'tbl_product';
    protected $fields = array('id', 'name', 'price');
}
```

## 🎯 Routing

Edit file `app/routes/routes.php`:

```php
return array(
    array('GET', '/', 'HomeController@index'),
    array('POST', '/users', 'UserController@store'),
    array('GET', '/users/{id}', 'UserController@show'),
    array('POST', '/users/update/{id}', 'UserController@update'),
    array('POST', '/users/delete/{id}', 'UserController@destroy'),
);
```

## 💡 Helper Functions

```php
// Base URL
echo base_url('users'); 

// Environment Variables
$dbHost = env('DB_HOST', 'localhost');
$appName = env('APP_NAME');

// Clean Input (sanitization)
$nama = clean_input($_POST['nama']);

// Flash Messages
$this->redirectBack('Data berhasil disimpan', 'success');
```

## 🌍 Environment Configuration

Semua konfigurasi aplikasi tersentralisasi di file `.env`:

```env
# Database
DB_HOST=localhost
DB_NAME=crudtest
DB_USER=root
DB_PASS=

# Application
APP_NAME=MVC-PHP-5-TEMPLATE
APP_ENV=development
BASE_URL=http://localhost/MVC-PHP-5-TEMPLATE/

# Dan banyak lagi...
```

**Dokumentasi lengkap:** [DOKUMENTASI_ENV.md](_DEV/DOKUMENTASI_ENV.md)

## 🔒 Security

- ✅ Prepared statements untuk semua query
- ✅ Input sanitization dengan `clean_input()`
- ✅ XSS protection dengan `htmlspecialchars()`
- ✅ SQL injection protection
- ✅ Environment variables untuk data sensitif

## 📝 Changelog

### Version 2.1 (Latest)
- ✅ Environment configuration system (.env)
- ✅ Env class untuk load environment variables
- ✅ Semua config terpusat di .env
- ✅ Storage directory untuk logs & cache
- ✅ .gitignore untuk keamanan
- ✅ Dokumentasi lengkap environment config

## 📝 Changelog

### Version 2.0 (Latest)
- ✅ Kompatibilitas PHP 5.2 - 8+
- ✅ Auto-detect PDO/mysql_*
- ✅ Method CRUD lengkap dengan alias
- ✅ Query builder support
- ✅ Dokumentasi lengkap
- ✅ Contoh implementasi

### Version 1.0
- Basic MVC structure
- PDO only support

## 🤝 Contributing

Contributions are welcome! Feel free to submit pull requests.

## 📄 License

MIT License - Feel free to use this template for your projects.

## 👨‍💻 Author

Created with ❤️ for maximum PHP compatibility

---

**Happy Coding!** 🚀

