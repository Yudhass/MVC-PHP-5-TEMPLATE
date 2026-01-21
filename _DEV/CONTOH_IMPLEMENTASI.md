# CONTOH IMPLEMENTASI CRUD LENGKAP

## File SQL untuk Testing

```sql
-- Database: crudtest
CREATE DATABASE IF NOT EXISTS `crudtest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `crudtest`;

-- Table: tbl_user
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert sample data
INSERT INTO `tbl_user` (`nama`, `email`, `alamat`) VALUES
('John Doe', 'john@example.com', 'Jakarta'),
('Jane Smith', 'jane@example.com', 'Bandung'),
('Bob Wilson', 'bob@example.com', 'Surabaya');
```

---

## 1. MODEL - User.php

File: `app/models/User.php`

```php
<?php 
require_once dirname(__FILE__) . '/../core/Model.php';

class User extends Model
{
    protected $table = 'tbl_user';
    protected $fields = array('id', 'nama', 'email', 'alamat');
    
    // Custom method untuk mencari berdasarkan email
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    
    // Custom method untuk mencari user aktif
    public function getActiveUsers()
    {
        return $this->selectWhere('status', 'active');
    }
}
```

---

## 2. CONTROLLER - UserController.php

File: `app/controllers/UserController.php`

```php
<?php
require_once dirname(__FILE__) . '/../models/User.php';

class UserController extends Controller
{
    // CRUD 1: READ ALL - Tampilkan semua data
    public function index()
    {
        $user = new User();
        $allUsers = $user->selectAll(); // atau $user->all();
        
        return $this->view('users/list', array(
            'title' => 'Daftar User',
            'users' => $allUsers
        ));
    }
    
    // CRUD 2: CREATE - Form tambah data
    public function create()
    {
        return $this->view('users/create', array(
            'title' => 'Tambah User Baru'
        ));
    }
    
    // CRUD 3: INSERT - Proses tambah data
    public function store()
    {
        $user = new User();
        
        // Validasi sederhana
        if (empty($_POST['nama']) || empty($_POST['email'])) {
            $this->redirectBack('Nama dan email wajib diisi!', 'error');
            return;
        }
        
        // Insert data
        $result = $user->insert(array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email']),
            'alamat' => clean_input($_POST['alamat'])
        ));
        
        if ($result) {
            $this->redirect(base_url('users'), 'Data berhasil ditambahkan!', 'success');
        } else {
            $this->redirectBack('Gagal menambahkan data!', 'error');
        }
    }
    
    // CRUD 4: READ ONE - Tampilkan detail satu data
    public function show($id)
    {
        $user = new User();
        $userData = $user->selectOne($id); // atau $user->find($id)
        
        if (!$userData) {
            $this->redirect(base_url('users'), 'Data tidak ditemukan!', 'error');
            return;
        }
        
        return $this->view('users/detail', array(
            'title' => 'Detail User',
            'user' => $userData
        ));
    }
    
    // CRUD 5: EDIT - Form edit data
    public function edit($id)
    {
        $user = new User();
        $userData = $user->find($id);
        
        if (!$userData) {
            $this->redirect(base_url('users'), 'Data tidak ditemukan!', 'error');
            return;
        }
        
        return $this->view('users/edit', array(
            'title' => 'Edit User',
            'user' => $userData
        ));
    }
    
    // CRUD 6: UPDATE - Proses update data
    public function update($id)
    {
        $user = new User();
        
        // Cek apakah data ada
        $userData = $user->find($id);
        if (!$userData) {
            $this->redirect(base_url('users'), 'Data tidak ditemukan!', 'error');
            return;
        }
        
        // Update data menggunakan updateById
        $updated = $user->updateById($id, array(
            'nama' => clean_input($_POST['nama']),
            'email' => clean_input($_POST['email']),
            'alamat' => clean_input($_POST['alamat'])
        ));
        
        if ($updated > 0) {
            $this->redirect(base_url('users'), 'Data berhasil diupdate!', 'success');
        } else {
            $this->redirectBack('Tidak ada perubahan data', 'info');
        }
    }
    
    // CRUD 7: DELETE - Hapus data
    public function destroy($id)
    {
        $user = new User();
        
        // Cek apakah data ada
        $userData = $user->find($id);
        if (!$userData) {
            $this->redirect(base_url('users'), 'Data tidak ditemukan!', 'error');
            return;
        }
        
        // Delete data
        $deleted = $user->deleteById($id); // atau $user->delete($id)
        
        if ($deleted > 0) {
            $this->redirectBack('Data berhasil dihapus!', 'success');
        } else {
            $this->redirectBack('Gagal menghapus data!', 'error');
        }
    }
    
    // CRUD 8: SEARCH - Cari data dengan WHERE
    public function search()
    {
        $user = new User();
        $keyword = isset($_GET['keyword']) ? clean_input($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            $this->redirect(base_url('users'), 'Masukkan keyword pencarian!', 'warning');
            return;
        }
        
        // Search menggunakan selectWhere dengan LIKE
        $results = $user->selectWhere('nama', '%' . $keyword . '%', 'LIKE');
        
        // Atau menggunakan query builder:
        // $results = $user->where('nama', '%' . $keyword . '%', 'LIKE')->get();
        
        return $this->view('users/list', array(
            'title' => 'Hasil Pencarian: ' . $keyword,
            'users' => $results
        ));
    }
    
    // CONTOH: Multiple WHERE conditions
    public function advancedSearch()
    {
        $user = new User();
        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        
        // Menggunakan query builder dengan multiple WHERE
        $query = $user;
        
        if (!empty($nama)) {
            $query = $query->where('nama', '%' . $nama . '%', 'LIKE');
        }
        
        if (!empty($email)) {
            $query = $query->where('email', '%' . $email . '%', 'LIKE');
        }
        
        $results = $query->get();
        
        return $this->view('users/list', array(
            'title' => 'Hasil Pencarian Lanjutan',
            'users' => $results
        ));
    }
}
```

---

## 3. VIEW - List Users

File: `app/views/users/list.php`

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo $title; ?></h1>
        
        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message_type']; ?> alert-dismissible fade show">
                <?php echo getAlertMessage(); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php delete_alert(); ?>
        <?php endif; ?>
        
        <!-- Search Form -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="<?php echo base_url('users/search'); ?>" method="GET" class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari user...">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?php echo base_url('users/create'); ?>" class="btn btn-success">
                    + Tambah User
                </a>
            </div>
        </div>
        
        <!-- Data Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->id); ?></td>
                            <td><?php echo htmlspecialchars($user->nama); ?></td>
                            <td><?php echo htmlspecialchars($user->email); ?></td>
                            <td><?php echo htmlspecialchars($user->alamat); ?></td>
                            <td>
                                <a href="<?php echo base_url('users/' . $user->id); ?>" 
                                   class="btn btn-info btn-sm">Detail</a>
                                <a href="<?php echo base_url('users/edit/' . $user->id); ?>" 
                                   class="btn btn-warning btn-sm">Edit</a>
                                <form action="<?php echo base_url('users/delete/' . $user->id); ?>" 
                                      method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Yakin hapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

---

## 4. VIEW - Form Create

File: `app/views/users/create.php`

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('users/store'); ?>" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama *</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="<?php echo base_url('users'); ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

---

## 5. VIEW - Form Edit

File: `app/views/users/edit.php`

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('users/update/' . $user->id); ?>" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama *</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?php echo htmlspecialchars($user->nama); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user->email); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($user->alamat); ?></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="<?php echo base_url('users'); ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

---

## 6. ROUTES Configuration

File: `app/routes/routes.php`

```php
<?php

return array(
    // Home
    array('GET', '/', 'HomeController@index'),
    
    // Users - CRUD
    array('GET', '/users', 'UserController@index'),
    array('GET', '/users/create', 'UserController@create'),
    array('POST', '/users/store', 'UserController@store'),
    array('GET', '/users/{id}', 'UserController@show'),
    array('GET', '/users/edit/{id}', 'UserController@edit'),
    array('POST', '/users/update/{id}', 'UserController@update'),
    array('POST', '/users/delete/{id}', 'UserController@destroy'),
    
    // Search
    array('GET', '/users/search', 'UserController@search'),
);
```

---

## 7. Cara Testing

### Test di PHP 5.2:
```bash
# Jalankan dengan PHP 5.2
php -v  # Cek versi
php -S localhost:8000  # Start server
```

### Test di PHP 7:
```bash
# Jalankan dengan PHP 7
php -v  # Cek versi
php -S localhost:8000
```

### Test di PHP 8:
```bash
# Jalankan dengan PHP 8
php -v  # Cek versi
php -S localhost:8000
```

### Test CRUD Operations:
1. **Create**: Buka http://localhost/MVC-PHP-5-TEMPLATE/users/create
2. **Read All**: Buka http://localhost/MVC-PHP-5-TEMPLATE/users
3. **Read One**: Klik "Detail" pada salah satu user
4. **Update**: Klik "Edit" pada salah satu user
5. **Delete**: Klik "Hapus" pada salah satu user
6. **Search**: Gunakan form pencarian di list users

---

## Summary Method yang Tersedia:

| No | Method | Fungsi | Return |
|----|--------|--------|--------|
| 1 | `insert($data)` | Tambah data baru | Object |
| 2 | `selectAll()` | Ambil semua data | Array |
| 3 | `selectOne($id)` | Ambil satu data by ID | Object |
| 4 | `selectWhere($col, $val, $op)` | Ambil data dengan WHERE | Array |
| 5 | `update($data)` | Update (perlu id di array) | Integer |
| 6 | `updateById($id, $data)` | Update by ID | Integer |
| 7 | `delete($id)` | Hapus by ID | Integer |
| 8 | `deleteById($id)` | Alias delete | Integer |
| 9 | `find($id)` | Cari by ID | Object |
| 10 | `where($col, $val)->get()` | Query builder | Array |
| 11 | `where($col, $val)->first()` | Query builder | Object |

---

Semua method sudah **kompatibel dengan PHP 5.2, 7, 8 dan lebih tinggi!** ✅
