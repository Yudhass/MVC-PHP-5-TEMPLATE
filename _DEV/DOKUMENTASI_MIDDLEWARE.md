# Dokumentasi Middleware & Advanced Routing

## 📋 Daftar Isi
- [Middleware](#middleware)
- [Routing](#routing)
- [Error Handling](#error-handling)
- [Helper Functions](#helper-functions)

## 🛡️ Middleware

Middleware adalah layer yang berjalan sebelum controller untuk memvalidasi request. Template ini menyediakan 3 middleware bawaan:

### 1. AuthMiddleware
Memastikan user sudah login sebelum mengakses halaman.

**Fitur:**
- Cek session user
- Session timeout (default 2 jam)
- Auto session regeneration (setiap 30 menit)
- Redirect ke login jika belum login

**Contoh Penggunaan:**
```php
// Di routes.php
$router->get('/dashboard', 'DashboardController@index', array('auth'));
$router->post('/profile/update', 'ProfileController@update', array('auth'));
```

### 2. GuestMiddleware
Memastikan user belum login (untuk halaman login/register).

**Fitur:**
- Cek apakah user sudah login
- Redirect ke home jika sudah login

**Contoh Penggunaan:**
```php
// Di routes.php
$router->get('/login', 'AuthController@login', array('guest'));
$router->post('/login', 'AuthController@login_process', array('guest'));
```

### 3. RoleMiddleware
Memastikan user memiliki role/hak akses tertentu.

**Fitur:**
- Cek role user dari session atau database
- Support multiple roles
- Return 403 Forbidden jika tidak punya akses

**Contoh Penggunaan:**
```php
// Single role
$router->get('/admin/dashboard', 'AdminController@index', array('auth', 'role:admin'));

// Multiple roles (akan dibuat middleware baru)
$router->get('/moderator/panel', 'ModeratorController@index', array('auth', 'role:admin,moderator'));
```

### Membuat Middleware Sendiri

1. Buat file baru di `app/middlewares/NamaMiddleware.php`
2. Extend class `Middleware`
3. Implement method `handle()`

**Contoh:**
```php
<?php

require_once dirname(__FILE__) . '/../core/Middleware.php';

class VerifiedMiddleware extends Middleware
{
    public function handle($params = array())
    {
        if (!isset($_SESSION['user']['email_verified']) || !$_SESSION['user']['email_verified']) {
            $this->redirect('verify-email', 'Please verify your email first.', 'warning');
            return false;
        }
        
        return true;
    }
}
```

**Gunakan di routes:**
```php
$router->get('/verified-area', 'VerifiedController@index', array('auth', 'verified'));
```

## 🛣️ Routing

### Method HTTP yang Didukung

Template mendukung berbagai HTTP methods:

```php
// GET request
$router->get('/path', 'Controller@method', array('middleware'));

// POST request
$router->post('/path', 'Controller@method', array('middleware'));

// PUT request
$router->put('/path', 'Controller@method', array('middleware'));

// DELETE request
$router->delete('/path', 'Controller@method', array('middleware'));

// ANY method (GET, POST, PUT, DELETE, PATCH)
$router->any('/path', 'Controller@method', array('middleware'));
```

### Dynamic Parameters

Route mendukung parameter dinamis menggunakan `{nama}`:

```php
// Single parameter
$router->get('/user/{id}', 'UserController@show');

// Multiple parameters
$router->get('/post/{category}/{slug}', 'PostController@show');

// With middleware
$router->get('/admin/user/{id}/edit', 'AdminController@editUser', array('auth', 'role:admin'));
```

**Di Controller:**
```php
public function show($id) {
    echo "User ID: " . $id;
}

public function showPost($category, $slug) {
    echo "Category: " . $category . ", Slug: " . $slug;
}
```

### Multiple Middleware

Anda bisa menggunakan multiple middleware pada satu route:

```php
$router->get('/admin/settings', 'AdminController@settings', array('auth', 'role:admin', 'verified'));
```

Middleware akan dijalankan sesuai urutan dari kiri ke kanan.

### Contoh Routes Lengkap

```php
<?php

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');

// Guest only (user belum login)
$router->get('/login', 'AuthController@login', array('guest'));
$router->post('/login', 'AuthController@login_process', array('guest'));
$router->get('/register', 'AuthController@register', array('guest'));
$router->post('/register', 'AuthController@register_process', array('guest'));

// Protected routes (user sudah login)
$router->get('/dashboard', 'DashboardController@index', array('auth'));
$router->get('/profile', 'ProfileController@index', array('auth'));
$router->post('/profile/update', 'ProfileController@update', array('auth'));
$router->get('/logout', 'AuthController@logout', array('auth'));

// Admin only
$router->get('/admin/dashboard', 'AdminController@index', array('auth', 'role:admin'));
$router->get('/admin/users', 'AdminController@users', array('auth', 'role:admin'));
$router->get('/admin/users/{id}', 'AdminController@showUser', array('auth', 'role:admin'));
$router->post('/admin/users/{id}/delete', 'AdminController@deleteUser', array('auth', 'role:admin'));
```

## 🚨 Error Handling

Template dilengkapi dengan error handling yang comprehensive dan modern.

### Fitur Error Handling

1. **Custom Error Handler**: Menangani semua PHP errors, warnings, notices
2. **Exception Handler**: Menangani uncaught exceptions
3. **Shutdown Handler**: Menangani fatal errors
4. **Beautiful Error Pages**: Halaman error yang informatif dan modern

### Error Page Features

- ✅ Error message yang jelas
- ✅ Stack trace dengan code preview
- ✅ Request information (GET, POST, Headers)
- ✅ Environment information
- ✅ Session data
- ✅ Tab navigation untuk informasi berbeda

### Trigger Error Manually

```php
// Throw exception
throw new Exception("Something went wrong!");

// Trigger PHP error
trigger_error("Custom error message", E_USER_ERROR);

// 404 Not Found - otomatis jika route tidak ada
// 403 Forbidden - otomatis dari middleware
// 500 Server Error - otomatis dari PHP errors
```

## 🔧 Helper Functions

Template menyediakan helper functions yang berguna untuk development.

### Debug Helpers

#### dd() - Dump and Die
Menampilkan data dengan format yang indah dan stop execution.

```php
dd($variable);
dd($var1, $var2, $var3);

// Contoh
$user = array('id' => 1, 'name' => 'John');
dd($user);
```

**Features:**
- Beautiful dark theme
- Syntax highlighting
- Copy to clipboard
- Type information
- Multiple variables support

#### dump() - Dump without Die
Sama seperti dd() tapi tidak stop execution.

```php
dump($variable);
dump($var1, $var2);

// Contoh
dump($_SESSION);
echo "Code continues...";
```

### Session Helpers

#### getSession()
Mengambil nilai dari session.

```php
$userId = getSession('user_id');
$userName = getSession('user_name', 'Guest'); // dengan default value
```

#### setSession()
Menyimpan nilai ke session.

```php
setSession('user_id', 123);
setSession('user_name', 'John Doe');
```

### Flash Message Helpers

#### setFlashMessage()
Menyimpan flash message yang akan ditampilkan sekali.

```php
setFlashMessage('Data berhasil disimpan!', 'success');
setFlashMessage('Terjadi kesalahan!', 'error');
setFlashMessage('Perhatian!', 'warning');
setFlashMessage('Informasi', 'info');
```

#### getFlashMessage()
Mengambil dan menghapus flash message.

```php
$flash = getFlashMessage();
if ($flash) {
    echo $flash['message']; // "Data berhasil disimpan!"
    echo $flash['type'];    // "success"
}
```

#### hasFlashMessage()
Cek apakah ada flash message.

```php
if (hasFlashMessage()) {
    $flash = getFlashMessage();
    // tampilkan flash message
}
```

#### displayFlashMessage()
Menampilkan flash message sebagai HTML (Bootstrap alert).

```php
// Di view
<?php echo displayFlashMessage(); ?>
```

Output:
```html
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data berhasil disimpan!
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

### Contoh Penggunaan di Controller

```php
class UserController extends Controller
{
    public function store()
    {
        try {
            $User = $this->model('User');
            
            $data = array(
                'nama' => $_POST['nama'],
                'email' => $_POST['email']
            );
            
            $result = $User->insert($data);
            
            if ($result) {
                setFlashMessage('User berhasil ditambahkan!', 'success');
                header('Location: ' . BASEURL . 'users');
                exit;
            } else {
                setFlashMessage('Gagal menambahkan user!', 'error');
            }
            
        } catch (Exception $e) {
            setFlashMessage('Error: ' . $e->getMessage(), 'error');
        }
        
        $this->view('users/create');
    }
    
    public function show($id)
    {
        $User = $this->model('User');
        $user = $User->selectOne($id);
        
        // Debug
        dump($user);
        
        // Atau stop di sini untuk debugging
        // dd($user);
        
        $this->view('users/show', array('user' => $user));
    }
}
```

### Contoh Penggunaan di View

```php
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Flash Message -->
        <?php echo displayFlashMessage(); ?>
        
        <h1>User List</h1>
        
        <!-- Content -->
    </div>
</body>
</html>
```

## 📚 Referensi Tambahan

- [DOKUMENTASI_CRUD.md](_DEV/DOKUMENTASI_CRUD.md) - Dokumentasi lengkap CRUD operations
- [DOKUMENTASI_ENV.md](_DEV/DOKUMENTASI_ENV.md) - Dokumentasi environment configuration
- [CONTOH_IMPLEMENTASI.md](_DEV/CONTOH_IMPLEMENTASI.md) - Contoh implementasi lengkap

## 🎯 Tips & Best Practices

1. **Selalu gunakan middleware untuk protect routes**
   ```php
   // ❌ Salah - tidak ada proteksi
   $router->get('/admin/delete-all', 'AdminController@deleteAll');
   
   // ✅ Benar - dengan middleware
   $router->get('/admin/delete-all', 'AdminController@deleteAll', array('auth', 'role:admin'));
   ```

2. **Gunakan flash message untuk user feedback**
   ```php
   setFlashMessage('Operasi berhasil!', 'success');
   ```

3. **Debug dengan dd() dan dump()**
   ```php
   dd($_POST); // lihat data POST
   dump($query); // debug tanpa stop
   ```

4. **Gunakan try-catch untuk error handling**
   ```php
   try {
       // risky operation
   } catch (Exception $e) {
       setFlashMessage('Error: ' . $e->getMessage(), 'error');
   }
   ```

5. **Validasi input sebelum insert/update**
   ```php
   if (empty($_POST['nama'])) {
       setFlashMessage('Nama tidak boleh kosong!', 'warning');
       return;
   }
   ```
