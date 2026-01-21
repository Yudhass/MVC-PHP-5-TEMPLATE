# Dokumentasi MVC PHP 5.2+ Template

Template MVC ini kompatibel dengan PHP 5.2, 7, 8 dan versi lebih tinggi.

## Fitur Utama

✅ Kompatibel dengan PHP 5.2, 7, 8 dan lebih tinggi  
✅ Auto-detect PDO atau mysql_* functions  
✅ CRUD operations lengkap  
✅ Query Builder support  
✅ MVC Pattern yang clean  

---

## Database Configuration

Edit file `app/core/Config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'crudtest');
define('DB_PORT', '3306');
```

---

## CRUD Operations

### 1. INSERT - Tambah Data Baru

**Method:** `insert($data)` atau `create($data)`

```php
$user = new User();
$result = $user->insert(array(
    'nama' => 'John Doe',
    'email' => 'john@example.com'
));

// Atau menggunakan alias create
$result = $user->create(array(
    'nama' => 'Jane Doe'
));
```

**Return:** Object data yang baru ditambahkan (hasil dari find dengan lastInsertId)

---

### 2. SELECT ALL - Ambil Semua Data

**Method:** `selectAll()` atau `all()`

```php
$user = new User();
$allUsers = $user->selectAll();

// Atau menggunakan alias all
$allUsers = $user->all();

// Loop hasil
foreach ($allUsers as $row) {
    echo $row->nama;
}
```

**Return:** Array of objects

---

### 3. SELECT ONE - Ambil Satu Data Berdasarkan ID

**Method:** `selectOne($id)` atau `find($id)`

```php
$user = new User();
$oneUser = $user->selectOne(1);

// Atau menggunakan find
$oneUser = $user->find(1);

if ($oneUser) {
    echo $oneUser->nama;
}
```

**Return:** Object atau null jika tidak ditemukan

---

### 4. SELECT WHERE - Ambil Data Dengan Kondisi

**Method:** `selectWhere($column, $value, $operator = '=')`

```php
$user = new User();

// Contoh 1: Exact match
$users = $user->selectWhere('nama', 'John');

// Contoh 2: LIKE operator
$users = $user->selectWhere('nama', '%John%', 'LIKE');

// Contoh 3: Greater than
$users = $user->selectWhere('age', 18, '>');
```

**Return:** Array of objects

#### Query Builder WHERE

Gunakan method `where()` dengan `get()` atau `first()`:

```php
$user = new User();

// Single WHERE
$users = $user->where('nama', 'John')->get();

// Multiple WHERE (AND)
$users = $user->where('nama', 'John')
              ->where('age', 18, '>')
              ->get();

// Get single result
$user = $user->where('email', 'john@example.com')->first();
```

---

### 5. UPDATE - Update Data

**Method:** `update($data)` - memerlukan 'id' di dalam array

```php
$user = new User();
$updated = $user->update(array(
    'id' => 1,
    'nama' => 'John Updated',
    'email' => 'john.new@example.com'
));

if ($updated > 0) {
    echo "Data berhasil diupdate";
}
```

**Return:** Jumlah row yang terpengaruh (integer)

---

### 6. UPDATE BY ID - Update Data Berdasarkan ID

**Method:** `updateById($id, $data)`

```php
$user = new User();
$updated = $user->updateById(1, array(
    'nama' => 'John Updated',
    'email' => 'john.new@example.com'
));

// Lebih clean, tidak perlu memasukkan 'id' di array data
```

**Return:** Jumlah row yang terpengaruh (integer)

---

### 7. DELETE - Hapus Data Berdasarkan ID

**Method:** `delete($id)` atau `deleteById($id)`

```php
$user = new User();
$deleted = $user->delete(1);

// Atau menggunakan deleteById
$deleted = $user->deleteById(1);

if ($deleted > 0) {
    echo "Data berhasil dihapus";
}
```

**Return:** Jumlah row yang terpengaruh (integer)

---

## Contoh Lengkap di Controller

```php
<?php
require_once dirname(__FILE__) . '/../models/User.php';

class UserController extends Controller
{
    // 1. Tampilkan semua data
    public function index()
    {
        $user = new User();
        $data = $user->selectAll(); // atau $user->all()
        
        return $this->view('users/index', array(
            'users' => $data
        ));
    }
    
    // 2. Insert data baru
    public function store()
    {
        $user = new User();
        $result = $user->insert(array(
            'nama' => $_POST['nama'],
            'email' => $_POST['email']
        ));
        
        if ($result) {
            $this->redirectBack('Data berhasil ditambahkan', 'success');
        }
    }
    
    // 3. Tampilkan satu data
    public function show($id)
    {
        $user = new User();
        $data = $user->selectOne($id); // atau $user->find($id)
        
        return $this->view('users/show', array(
            'user' => $data
        ));
    }
    
    // 4. Update data
    public function update($id)
    {
        $user = new User();
        $updated = $user->updateById($id, array(
            'nama' => $_POST['nama'],
            'email' => $_POST['email']
        ));
        
        if ($updated) {
            $this->redirectBack('Data berhasil diupdate', 'success');
        }
    }
    
    // 5. Delete data
    public function destroy($id)
    {
        $user = new User();
        $deleted = $user->deleteById($id);
        
        if ($deleted) {
            $this->redirectBack('Data berhasil dihapus', 'success');
        }
    }
    
    // 6. Search dengan WHERE
    public function search()
    {
        $user = new User();
        $keyword = $_GET['keyword'];
        
        $data = $user->selectWhere('nama', '%' . $keyword . '%', 'LIKE');
        
        return $this->view('users/index', array(
            'users' => $data
        ));
    }
}
```

---

## Membuat Model Baru

1. Buat file baru di `app/models/`, misalnya `Product.php`

```php
<?php 
require_once dirname(__FILE__) . '/../core/Model.php';

class Product extends Model
{
    protected $table = 'tbl_product'; // Nama tabel
    protected $fields = array('id', 'name', 'price', 'stock');
}
```

2. Gunakan di Controller:

```php
require_once dirname(__FILE__) . '/../models/Product.php';

class ProductController extends Controller
{
    public function index()
    {
        $product = new Product();
        $data = $product->selectAll();
        
        return $this->view('products', array(
            'products' => $data
        ));
    }
}
```

---

## Routes Configuration

Edit file `app/routes/routes.php`:

```php
<?php
return array(
    // GET routes
    array('GET', '/', 'HomeController@index'),
    array('GET', '/users', 'UserController@index'),
    array('GET', '/users/{id}', 'UserController@show'),
    
    // POST routes
    array('POST', '/users', 'UserController@store'),
    array('POST', '/users/update/{id}', 'UserController@update'),
    array('POST', '/users/delete/{id}', 'UserController@destroy'),
);
```

---

## Pemanggilan View

Di Controller:

```php
public function index()
{
    $data = array(
        'title' => 'Home Page',
        'users' => $userModel->all()
    );
    
    return $this->view('home', $data);
}
```

Di View (`app/views/home.php`):

```php
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php foreach ($users as $user): ?>
        <p><?php echo $user->nama; ?></p>
    <?php endforeach; ?>
</body>
</html>
```

---

## Flash Messages

Set flash message:

```php
$this->redirectBack('Data berhasil disimpan', 'success');
// Types: success, error, warning, info
```

Tampilkan di view:

```php
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['flash_message_type']; ?>">
        <?php echo getAlertMessage(); ?>
    </div>
    <?php delete_alert(); ?>
<?php endif; ?>
```

---

## Kompatibilitas PHP

### PHP 5.2
- Menggunakan mysql_* functions
- Array syntax: array()
- Function syntax kompatibel

### PHP 7+
- Menggunakan PDO
- Mendukung array short syntax
- Error handling lebih baik

### PHP 8+
- Full PDO support
- Named arguments support
- Type declarations

---

## Helper Functions

### 1. base_url()

```php
echo base_url(); // http://localhost/MVC-PHP-5-TEMPLATE/
echo base_url('users'); // http://localhost/MVC-PHP-5-TEMPLATE/users
```

### 2. clean_input()

```php
$nama = clean_input($_POST['nama']);
// Sanitasi: trim, stripslashes, htmlspecialchars
```

### 3. redirect()

```php
redirect(base_url('users'));
```

---

## Tips & Best Practices

1. **Selalu gunakan prepared statements** - Sudah otomatis di semua method
2. **Validasi input** - Gunakan clean_input() atau validasi custom
3. **Error handling** - Cek return value dari operasi CRUD
4. **Security** - Gunakan htmlspecialchars() di view
5. **Naming convention** - Gunakan snake_case untuk database, camelCase untuk PHP

---

## Troubleshooting

### Error: PDO not found
- Sistem otomatis fallback ke mysql_*
- Pastikan extension mysql atau mysqli aktif di PHP 5.2

### Error: Table not found
- Cek nama tabel di property `$table` di model
- Cek koneksi database di Config.php

### Error: Method not found
- Pastikan extend Model di class model Anda
- Cek nama method (case-sensitive)

---

## SQL Schema Contoh

```sql
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

---

## Changelog

**Version 2.0**
- ✅ Kompatibilitas PHP 5.2 - 8+
- ✅ Auto-detect PDO/mysql_*
- ✅ Method CRUD lengkap
- ✅ Query builder support
- ✅ Flash message system
- ✅ Helper functions

---

**Dibuat dengan ❤️ untuk kompatibilitas maksimal**
