<?php

require_once dirname(__FILE__) . '/../core/Middleware.php';

/**
 * Auth Middleware
 * Cek apakah user sudah login
 */
class AuthMiddleware extends Middleware
{
    public function handle($params = array())
    {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $this->redirect('login', 'Silakan login terlebih dahulu untuk mengakses halaman ini.', 'warning');
            return false;
        }
        
        // Check session timeout
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > SESSION_LIFETIME) {
            session_destroy();
            $this->redirect('login', 'Session expired. Please login again.', 'error');
            return false;
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
        
        return true;
    }
}
