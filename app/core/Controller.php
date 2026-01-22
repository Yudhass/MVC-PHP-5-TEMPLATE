<?php

class Controller
{
    public function view($view, $data = array())
    {
        if (!file_exists(dirname(__FILE__) . '/../views/' . $view . '.php')) {
            echo "File : " . dirname(__FILE__) . '/../views/' . $view . '.php Tidak ditemukan';
            die();
        }

        if (count($data)) {
            extract($data);
        }
        require_once dirname(__FILE__) . '/../views/' . $view . '.php';
    }

    public function dd()
    {
        // Get all arguments
        $args = func_get_args();
        
        // Clear any output buffer
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Start new output buffer
        ob_start();
        
        // Prepare debug data
        $debugData = $args;
        
        // Load dd view
        $ddView = dirname(__FILE__) . '/../views/errors/dd.php';
        
        if (file_exists($ddView)) {
            require $ddView;
        } else {
            // Fallback jika view tidak ada
            echo '<!DOCTYPE html><html><head><title>Debug</title></head><body>';
            echo '<pre style="background: #1a1a2e; color: #e0e0e0; padding: 20px; font-family: monospace;">';
            foreach ($debugData as $index => $data) {
                echo "=== Variable #" . ($index + 1) . " ===\n";
                var_dump($data);
                echo "\n\n";
            }
            echo '</pre></body></html>';
        }
        
        // Flush output buffer
        ob_end_flush();
        
        die();
    }

    public function model($model)
    {
        $file = '../app/models/' . $model . '.php';

        // Cek apakah file model ada
        if (!file_exists($file)) {
            echo "File : " . $file . " Tidak ditemukan";
            die();
        }

        // Memasukkan file model
        require_once $file;

        // Pastikan kelas model ada, kemudian buat instance objeknya
        if (class_exists($model)) {
            return new $model();
        } else {
            echo "Kelas model : " . $model . " tidak ditemukan.";
            die();
        }
    }

    // Custom redirect method
    public function redirect($route, $message = null, $type = 'success')
    {
        // Store the message in session to display it on the next page
        if ($message) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_message_type'] = $type; // success, error, etc.
        }

        // Redirect to the specified route
        header('Location: ' . $route);
        exit;
    }

    // Redirect back to the previous page
    public function redirectBack($message = null, $type = 'success')
    {
        if ($message) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_message_type'] = $type;
        }

        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Get session value
    public function getSession($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    // Get and clear flash message
    public function getFlashMessage()
    {
        if (isset($_SESSION['flash_message'])) {
            $message = array(
                'message' => $_SESSION['flash_message'],
                'type' => isset($_SESSION['flash_message_type']) ? $_SESSION['flash_message_type'] : 'success'
            );

            // Clear the flash message after retrieving
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_message_type']);

            return $message;
        }

        return null;
    }

    // Check if flash message exists
    public function hasFlashMessage()
    {
        return isset($_SESSION['flash_message']);
    }
}
