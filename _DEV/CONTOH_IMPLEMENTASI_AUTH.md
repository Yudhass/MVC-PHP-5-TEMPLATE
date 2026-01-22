# Contoh Implementasi Lengkap - Middleware & Advanced Features

## 📚 Daftar Isi
- [Setup Authentication](#setup-authentication)
- [Contoh Controller](#contoh-controller)
- [Contoh Routes](#contoh-routes)
- [Contoh Views](#contoh-views)

## 🔐 Setup Authentication

### 1. Model User

Pastikan tabel users memiliki kolom `role`:

```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    email_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert admin user
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password: password
```

### 2. Model User.php

```php
<?php

class User extends Model
{
    protected $table = 'users';
    
    /**
     * Find user by username
     */
    public function findByUsername($username)
    {
        return $this->selectWhere('username', $username);
    }
    
    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        return $this->selectWhere('email', $email);
    }
    
    /**
     * Verify password
     */
    public function verifyPassword($inputPassword, $hashedPassword)
    {
        // PHP 5.5+ menggunakan password_verify
        if (function_exists('password_verify')) {
            return password_verify($inputPassword, $hashedPassword);
        }
        
        // Fallback untuk PHP < 5.5
        return $inputPassword === $hashedPassword;
    }
    
    /**
     * Hash password
     */
    public function hashPassword($password)
    {
        // PHP 5.5+ menggunakan password_hash
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Fallback untuk PHP < 5.5
        return hash('sha256', $password);
    }
}
```

### 3. Controller AuthController.php

```php
<?php

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function login()
    {
        $this->view('auth/login');
    }
    
    /**
     * Process login
     */
    public function login_process()
    {
        // Validasi input
        if (empty($_POST['username']) || empty($_POST['password'])) {
            setFlashMessage('Username dan password harus diisi!', 'warning');
            header('Location: ' . BASEURL . 'login');
            exit;
        }
        
        $User = $this->model('User');
        
        // Cari user berdasarkan username
        $users = $User->findByUsername($_POST['username']);
        
        if (empty($users)) {
            setFlashMessage('Username atau password salah!', 'error');
            header('Location: ' . BASEURL . 'login');
            exit;
        }
        
        $user = (array)$users[0];
        
        // Verify password
        if (!$User->verifyPassword($_POST['password'], $user['password'])) {
            setFlashMessage('Username atau password salah!', 'error');
            header('Location: ' . BASEURL . 'login');
            exit;
        }
        
        // Set session
        $_SESSION['user'] = array(
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        );
        
        // Set session timestamps untuk middleware
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['LAST_REGENERATE'] = time();
        
        setFlashMessage('Login berhasil! Selamat datang, ' . $user['username'], 'success');
        
        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: ' . BASEURL . 'admin/dashboard');
        } else {
            header('Location: ' . BASEURL . 'dashboard');
        }
        exit;
    }
    
    /**
     * Show register form
     */
    public function register()
    {
        $this->view('auth/register');
    }
    
    /**
     * Process registration
     */
    public function register_process()
    {
        // Validasi input
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            setFlashMessage('Semua field harus diisi!', 'warning');
            header('Location: ' . BASEURL . 'register');
            exit;
        }
        
        // Validasi password confirmation
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            setFlashMessage('Konfirmasi password tidak cocok!', 'error');
            header('Location: ' . BASEURL . 'register');
            exit;
        }
        
        $User = $this->model('User');
        
        // Cek username sudah ada
        if (!empty($User->findByUsername($_POST['username']))) {
            setFlashMessage('Username sudah digunakan!', 'error');
            header('Location: ' . BASEURL . 'register');
            exit;
        }
        
        // Cek email sudah ada
        if (!empty($User->findByEmail($_POST['email']))) {
            setFlashMessage('Email sudah digunakan!', 'error');
            header('Location: ' . BASEURL . 'register');
            exit;
        }
        
        // Insert user baru
        $data = array(
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $User->hashPassword($_POST['password']),
            'role' => 'user'
        );
        
        $result = $User->insert($data);
        
        if ($result) {
            setFlashMessage('Registrasi berhasil! Silakan login.', 'success');
            header('Location: ' . BASEURL . 'login');
        } else {
            setFlashMessage('Registrasi gagal! Silakan coba lagi.', 'error');
            header('Location: ' . BASEURL . 'register');
        }
        exit;
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        // Hapus semua session
        session_destroy();
        
        setFlashMessage('Anda telah logout.', 'info');
        header('Location: ' . BASEURL . 'login');
        exit;
    }
}
```

### 4. Controller DashboardController.php

```php
<?php

class DashboardController extends Controller
{
    /**
     * User dashboard (untuk user biasa)
     */
    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'user' => $_SESSION['user']
        );
        
        $this->view('dashboard/index', $data);
    }
}
```

### 5. Controller AdminController.php

```php
<?php

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function index()
    {
        $data = array(
            'title' => 'Admin Dashboard'
        );
        
        $this->view('admin/dashboard', $data);
    }
    
    /**
     * List all users
     */
    public function users()
    {
        $User = $this->model('User');
        $users = $User->selectAll();
        
        $data = array(
            'title' => 'Manage Users',
            'users' => $users
        );
        
        $this->view('admin/users', $data);
    }
    
    /**
     * Show user detail
     */
    public function showUser($id)
    {
        $User = $this->model('User');
        $user = $User->selectOne($id);
        
        if (!$user) {
            setFlashMessage('User tidak ditemukan!', 'error');
            header('Location: ' . BASEURL . 'admin/users');
            exit;
        }
        
        $data = array(
            'title' => 'User Detail',
            'user' => $user
        );
        
        $this->view('admin/user-detail', $data);
    }
    
    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        // Prevent deleting self
        if ($id == $_SESSION['user']['id']) {
            setFlashMessage('Anda tidak bisa menghapus akun sendiri!', 'error');
            header('Location: ' . BASEURL . 'admin/users');
            exit;
        }
        
        $User = $this->model('User');
        $result = $User->delete($id);
        
        if ($result) {
            setFlashMessage('User berhasil dihapus!', 'success');
        } else {
            setFlashMessage('Gagal menghapus user!', 'error');
        }
        
        header('Location: ' . BASEURL . 'admin/users');
        exit;
    }
}
```

## 🛣️ Contoh Routes

File: `app/routes/routes.php`

```php
<?php

/**
 * Routes Configuration dengan Middleware
 */

// ========================================
// PUBLIC ROUTES (No Authentication)
// ========================================
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

// ========================================
// GUEST ROUTES (Belum Login)
// ========================================
$router->get('/login', 'AuthController@login', array('guest'));
$router->post('/login', 'AuthController@login_process', array('guest'));
$router->get('/register', 'AuthController@register', array('guest'));
$router->post('/register', 'AuthController@register_process', array('guest'));

// ========================================
// PROTECTED ROUTES (Sudah Login)
// ========================================
$router->get('/dashboard', 'DashboardController@index', array('auth'));
$router->get('/profile', 'ProfileController@index', array('auth'));
$router->post('/profile/update', 'ProfileController@update', array('auth'));
$router->get('/logout', 'AuthController@logout', array('auth'));

// ========================================
// ADMIN ROUTES (Admin Only)
// ========================================
$router->get('/admin/dashboard', 'AdminController@index', array('auth', 'role:admin'));
$router->get('/admin/users', 'AdminController@users', array('auth', 'role:admin'));
$router->get('/admin/users/{id}', 'AdminController@showUser', array('auth', 'role:admin'));
$router->post('/admin/users/{id}/delete', 'AdminController@deleteUser', array('auth', 'role:admin'));
$router->get('/admin/settings', 'AdminController@settings', array('auth', 'role:admin'));
$router->post('/admin/settings/update', 'AdminController@settingsUpdate', array('auth', 'role:admin'));

// ========================================
// API ROUTES (Optional)
// ========================================
// $router->get('/api/users', 'ApiController@users', array('auth'));
// $router->post('/api/users', 'ApiController@createUser', array('auth', 'role:admin'));
```

## 📄 Contoh Views

### View: auth/login.php

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        <?php echo displayFlashMessage(); ?>
                        
                        <form action="<?php echo BASEURL; ?>login" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        
                        <hr>
                        <p class="text-center mb-0">
                            Belum punya akun? <a href="<?php echo BASEURL; ?>register">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### View: dashboard/index.php

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASEURL; ?>"><?php echo APP_NAME; ?></a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?php echo BASEURL; ?>profile">Profile</a>
                <a class="nav-link" href="<?php echo BASEURL; ?>logout">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <?php echo displayFlashMessage(); ?>
        
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome, <?php echo htmlspecialchars($data['user']['username']); ?>!</h1>
                <p class="lead">Ini adalah dashboard Anda.</p>
                
                <div class="card">
                    <div class="card-header">
                        <h5>User Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">Username:</th>
                                <td><?php echo htmlspecialchars($data['user']['username']); ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo htmlspecialchars($data['user']['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Role:</th>
                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo htmlspecialchars($data['user']['role']); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### View: admin/users.php

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASEURL; ?>admin/dashboard">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?php echo BASEURL; ?>admin/dashboard">Dashboard</a>
                <a class="nav-link active" href="<?php echo BASEURL; ?>admin/users">Users</a>
                <a class="nav-link" href="<?php echo BASEURL; ?>admin/settings">Settings</a>
                <a class="nav-link" href="<?php echo BASEURL; ?>logout">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <?php echo displayFlashMessage(); ?>
        
        <h1><?php echo $data['title']; ?></h1>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['users'])): ?>
                            <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td><?php echo $user->id; ?></td>
                                <td><?php echo htmlspecialchars($user->username); ?></td>
                                <td><?php echo htmlspecialchars($user->email); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $user->role === 'admin' ? 'danger' : 'primary'; ?>">
                                        <?php echo htmlspecialchars($user->role); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASEURL; ?>admin/users/<?php echo $user->id; ?>" 
                                       class="btn btn-sm btn-info">View</a>
                                    
                                    <?php if ($user->id != $_SESSION['user']['id']): ?>
                                    <form action="<?php echo BASEURL; ?>admin/users/<?php echo $user->id; ?>/delete" 
                                          method="POST" style="display: inline;">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus user ini?')">Delete</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

## 🔍 Testing

### 1. Test Routes Tanpa Middleware
```
http://localhost/MVC-PHP-5-TEMPLATE/
http://localhost/MVC-PHP-5-TEMPLATE/home
http://localhost/MVC-PHP-5-TEMPLATE/about
```
**Expected:** Bisa diakses tanpa login

### 2. Test Guest Middleware
```
http://localhost/MVC-PHP-5-TEMPLATE/login
http://localhost/MVC-PHP-5-TEMPLATE/register
```
**Expected:** 
- Jika belum login: Tampil form
- Jika sudah login: Redirect ke home

### 3. Test Auth Middleware
```
http://localhost/MVC-PHP-5-TEMPLATE/dashboard
```
**Expected:** 
- Jika belum login: Redirect ke login
- Jika sudah login: Tampil dashboard

### 4. Test Role Middleware
```
http://localhost/MVC-PHP-5-TEMPLATE/admin/dashboard
http://localhost/MVC-PHP-5-TEMPLATE/admin/users
```
**Expected:** 
- Jika belum login: Redirect ke login
- Jika login sebagai user: 403 Forbidden
- Jika login sebagai admin: Bisa akses

## 🐛 Debug Tips

### 1. Lihat Session Data
```php
dd($_SESSION);
```

### 2. Lihat Middleware Execution
Di `app/core/App.php`, tambahkan dump di method `executeMiddlewares()`:
```php
dump('Executing middleware:', $middleware);
```

### 3. Lihat Routes
```php
$router = new Router();
$router->loadRoutes();
dd($router->getRoutes());
```

### 4. Test Error Handling
```php
// Trigger error
throw new Exception("Test error!");

// Atau
trigger_error("Test PHP error", E_USER_ERROR);
```

## ✅ Checklist Implementasi

- [ ] Install database dan import SQL
- [ ] Setup .env file
- [ ] Buat Model User
- [ ] Buat AuthController
- [ ] Buat DashboardController
- [ ] Buat AdminController
- [ ] Buat view auth/login.php
- [ ] Buat view auth/register.php
- [ ] Buat view dashboard/index.php
- [ ] Buat view admin/users.php
- [ ] Setup routes dengan middleware
- [ ] Test semua routes
- [ ] Test middleware authorization

---

**Status:** ✅ Ready to use!
