<?php

/**
 * AuthController - Contoh implementasi Authentication dengan fitur keamanan lengkap
 * 
 * Fitur keamanan yang digunakan:
 * - CSRF Protection
 * - Rate Limiting
 * - Input Sanitization & Validation
 * - Password Hashing
 * - Session Security
 * - XSS Protection
 */
class AuthController extends Controller
{
    /**
     * Halaman Login
     */
    public function login()
    {
        // Jika sudah login, redirect ke home
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
            return;
        }

        $data = array(
            'title' => 'Login'
        );

        $this->view('auth/login', $data);
    }

    /**
     * Proses Login
     */
    public function login_process()
    {
        // CSRF Protection
        if (CSRF_ENABLED && !verify_csrf()) {
            $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
            return;
        }

        // Rate Limiting - Max 5 login attempts dalam 5 menit
        if (RATE_LIMIT_ENABLED && !rate_limit('login', 5, 300)) {
            $this->redirectBack('Too many login attempts. Please wait 5 minutes and try again.', 'error');
            return;
        }

        // Sanitize input
        $email = isset($_POST['email']) ? sanitize($_POST['email'], 'email') : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Validate input
        if (empty($email) || !validate($email, 'email')) {
            $this->redirectBack('Invalid email format.', 'error');
            return;
        }

        if (empty($password)) {
            $this->redirectBack('Password is required.', 'error');
            return;
        }

        // Get user from database
        $User = new User();
        $user = $User->selectWhere('email', $email);

        // Verify credentials
        if ($user && verify_password($password, $user['password'])) {
            // Login success
            
            // Regenerate session ID untuk security
            session_regenerate_id(true);
            
            // Set session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['LAST_ACTIVITY'] = time();
            
            // Redirect ke home
            $this->redirect('home');
        } else {
            // Login failed
            $this->redirectBack('Invalid email or password.', 'error');
        }
    }

    /**
     * Halaman Register
     */
    public function register()
    {
        // Jika sudah login, redirect ke home
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
            return;
        }

        $data = array(
            'title' => 'Register'
        );

        $this->view('auth/register', $data);
    }

    /**
     * Proses Register
     */
    public function register_process()
    {
        // CSRF Protection
        if (CSRF_ENABLED && !verify_csrf()) {
            $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
            return;
        }

        // Rate Limiting - Max 3 registrations dalam 1 jam
        if (RATE_LIMIT_ENABLED && !rate_limit('register', 3, 3600)) {
            $this->redirectBack('Too many registration attempts. Please wait 1 hour and try again.', 'error');
            return;
        }

        // Sanitize input
        $nama = isset($_POST['nama']) ? sanitize($_POST['nama'], 'string') : '';
        $email = isset($_POST['email']) ? sanitize($_POST['email'], 'email') : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

        // Validate nama
        if (empty($nama)) {
            $this->redirectBack('Name is required.', 'error');
            return;
        }

        if (!validate($nama, 'min', array('min' => 3))) {
            $this->redirectBack('Name must be at least 3 characters.', 'error');
            return;
        }

        if (!validate($nama, 'max', array('max' => 100))) {
            $this->redirectBack('Name must not exceed 100 characters.', 'error');
            return;
        }

        // Validate email
        if (empty($email) || !validate($email, 'email')) {
            $this->redirectBack('Invalid email format.', 'error');
            return;
        }

        // Validate password
        if (empty($password)) {
            $this->redirectBack('Password is required.', 'error');
            return;
        }

        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            $this->redirectBack('Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters.', 'error');
            return;
        }

        if (PASSWORD_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
            $this->redirectBack('Password must contain at least one uppercase letter.', 'error');
            return;
        }

        if (PASSWORD_REQUIRE_LOWERCASE && !preg_match('/[a-z]/', $password)) {
            $this->redirectBack('Password must contain at least one lowercase letter.', 'error');
            return;
        }

        if (PASSWORD_REQUIRE_NUMBER && !preg_match('/[0-9]/', $password)) {
            $this->redirectBack('Password must contain at least one number.', 'error');
            return;
        }

        if (PASSWORD_REQUIRE_SPECIAL && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $this->redirectBack('Password must contain at least one special character.', 'error');
            return;
        }

        // Validate password confirmation
        if ($password !== $password_confirm) {
            $this->redirectBack('Password confirmation does not match.', 'error');
            return;
        }

        // Check if email already exists
        $User = new User();
        $existingUser = $User->selectWhere('email', $email);

        if ($existingUser) {
            $this->redirectBack('Email already registered. Please use another email.', 'error');
            return;
        }

        // Hash password
        $hashedPassword = hash_password($password);

        // Insert to database
        $inserted = $User->insert(array(
            'nama' => $nama,
            'email' => $email,
            'password' => $hashedPassword
        ));

        if ($inserted) {
            $this->redirect('auth/login', 'Registration successful! Please login.', 'success');
        } else {
            $this->redirectBack('Registration failed. Please try again.', 'error');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Destroy session
        session_destroy();
        
        // Redirect ke login
        $this->redirect('auth/login', 'You have been logged out.', 'success');
    }

    /**
     * Halaman Forgot Password
     */
    public function forgot_password()
    {
        $data = array(
            'title' => 'Forgot Password'
        );

        $this->view('auth/forgot_password', $data);
    }

    /**
     * Proses Forgot Password
     */
    public function forgot_password_process()
    {
        // CSRF Protection
        if (CSRF_ENABLED && !verify_csrf()) {
            $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
            return;
        }

        // Rate Limiting - Max 3 attempts dalam 15 menit
        if (RATE_LIMIT_ENABLED && !rate_limit('forgot_password', 3, 900)) {
            $this->redirectBack('Too many reset attempts. Please wait 15 minutes and try again.', 'error');
            return;
        }

        // Sanitize input
        $email = isset($_POST['email']) ? sanitize($_POST['email'], 'email') : '';

        // Validate email
        if (empty($email) || !validate($email, 'email')) {
            $this->redirectBack('Invalid email format.', 'error');
            return;
        }

        // Check if email exists
        $User = new User();
        $user = $User->selectWhere('email', $email);

        if (!$user) {
            // Jangan kasih tau user bahwa email tidak ada (security best practice)
            $this->redirectBack('If the email exists, a password reset link has been sent.', 'success');
            return;
        }

        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $resetExpire = time() + 3600; // 1 hour

        // Save token to database (perlu tambah kolom reset_token dan reset_expire di tabel users)
        // $User->updateById($user['id'], array(
        //     'reset_token' => $resetToken,
        //     'reset_expire' => $resetExpire
        // ));

        // Send email dengan reset link (implementasi email belum ada)
        // $resetLink = BASE_URL . '/auth/reset_password/' . $resetToken;
        // sendEmail($email, 'Password Reset', 'Click this link: ' . $resetLink);

        $this->redirectBack('If the email exists, a password reset link has been sent.', 'success');
    }

    /**
     * Middleware: Check if user is logged in
     */
    public function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login', 'Please login first.', 'error');
            exit;
        }

        // Check session timeout
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > SESSION_LIFETIME) {
            session_destroy();
            $this->redirect('auth/login', 'Session expired. Please login again.', 'error');
            exit;
        }

        // Update last activity time
        $_SESSION['LAST_ACTIVITY'] = time();

        // Regenerate session ID periodically
        if (!isset($_SESSION['LAST_REGENERATE'])) {
            $_SESSION['LAST_REGENERATE'] = time();
        }

        if ((time() - $_SESSION['LAST_REGENERATE']) > SESSION_REGENERATE_INTERVAL) {
            session_regenerate_id(true);
            $_SESSION['LAST_REGENERATE'] = time();
        }
    }
}
