<?php

/**
 * Helper Functions
 * Functions yang dapat digunakan di seluruh aplikasi (controller dan view)
 * Compatible with PHP 5.2, 7, 8+
 */

/**
 * Die Dump - Beautiful debug output
 * Usage: dd($var1, $var2, $var3)
 */
if (!function_exists('dd')) {
    function dd()
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
}

/**
 * Dump - Debug output without die
 * Usage: dump($var1, $var2, $var3)
 */
if (!function_exists('dump')) {
    function dump()
    {
        $args = func_get_args();
        
        echo '<pre style="background: #2d2d44; color: #e0e0e0; padding: 15px; margin: 10px; border-radius: 5px; font-family: monospace; font-size: 13px; border-left: 4px solid #667eea;">';
        foreach ($args as $index => $data) {
            if (count($args) > 1) {
                echo '<strong style="color: #667eea;">Variable #' . ($index + 1) . ':</strong><br>';
            }
            var_dump($data);
            if ($index < count($args) - 1) {
                echo '<hr style="border: 1px solid #3d3d5c; margin: 10px 0;">';
            }
        }
        echo '</pre>';
    }
}

// Get session value
if (!function_exists('getSession')) {
    function getSession($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
}

// Set session value
if (!function_exists('setSession')) {
    function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}

// Get and clear flash message
if (!function_exists('getFlashMessage')) {
    function getFlashMessage()
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
}

// Check if flash message exists
if (!function_exists('hasFlashMessage')) {
    function hasFlashMessage()
    {
        return isset($_SESSION['flash_message']);
    }
}

// Set flash message
if (!function_exists('setFlashMessage')) {
    function setFlashMessage($message, $type = 'success')
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_message_type'] = $type;
    }
}

// Display flash message as HTML
if (!function_exists('displayFlashMessage')) {
    function displayFlashMessage()
    {
        $flash = getFlashMessage();
        if ($flash) {
            $alertClass = array(
                'success' => 'alert-success',
                'error' => 'alert-danger',
                'warning' => 'alert-warning',
                'info' => 'alert-info'
            );
            
            $class = isset($alertClass[$flash['type']]) ? $alertClass[$flash['type']] : 'alert-info';
            
            return '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($flash['message']) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
        
        return '';
    }
}
