<?php

/**
 * Helper Functions
 * Functions yang dapat digunakan di seluruh aplikasi (controller dan view)
 * Compatible with PHP 5.2, 7, 8+
 */

/**
 * Die Dump - Beautiful debug output with file location
 * Usage: dd($var1, $var2, $var3)
 */
if (!function_exists('dd')) {
    function dd()
    {
        // Get all arguments
        $args = func_get_args();
        
        // Get backtrace to find where dd() was called
        $backtrace = debug_backtrace();
        $caller = isset($backtrace[0]) ? $backtrace[0] : array('file' => 'Unknown', 'line' => 0);
        
        // Clear any output buffer
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Start new output buffer
        ob_start();
        
        // Prepare debug data with location info
        $debugData = $args;
        $callerFile = isset($caller['file']) ? $caller['file'] : 'Unknown';
        $callerLine = isset($caller['line']) ? $caller['line'] : 0;
        
        // Load dd view
        $ddView = dirname(__FILE__) . '/../views/errors/dd.php';
        
        if (file_exists($ddView)) {
            require $ddView;
        } else {
            // Fallback jika view tidak ada
            echo '<!DOCTYPE html><html><head><title>Debug</title></head><body>';
            echo '<div style="background: #667eea; color: white; padding: 15px; font-family: sans-serif;">';
            echo '<h2>🐛 Debug Data - Dump & Die</h2>';
            echo '<p style="font-size: 13px; opacity: 0.9;">Called from: <strong>' . htmlspecialchars($callerFile) . '</strong> on line <strong>' . $callerLine . '</strong></p>';
            echo '</div>';
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

if (!function_exists('Auth')) {
    function Auth()
    {
        if(isset($_SESSION['user'])) {
            return (object) $_SESSION['user'];
        } else {
            return null;
        }
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

if (!function_exists('getTypeFlashMessage')) {
    function getTypeFlashMessage()
    {
        if (isset($_SESSION['flash_message'])) {
            $message = array(
                'type' => isset($_SESSION['flash_message_type']) ? $_SESSION['flash_message_type'] : 'success'
            );
            
            return $message['type'];
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

// convert tanggal full indo 2026-01-23 08:40:00 -> 23 Januari 2026 08:40:00
if (!function_exists('getDateID')) {
    function getDateID($date)
    {
        return date('d F Y H:i:s', strtotime($date));
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

// Dump and Die - Debug helper
if (!function_exists('dd')) {
    function dd()
    {
        // Get all arguments
        $args = func_get_args();
        
        // Clear any output buffer
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Prepare debug data
        $debugData = array();
        foreach ($args as $arg) {
            $debugData[] = $arg;
        }
        
        // Load dd view
        $ddView = dirname(__FILE__) . '/../views/errors/dd.php';
        
        if (file_exists($ddView)) {
            require $ddView;
        } else {
            // Fallback jika view tidak ada
            echo '<pre>';
            foreach ($debugData as $index => $data) {
                echo "=== Variable #" . ($index + 1) . " ===\n";
                var_dump($data);
                echo "\n";
            }
            echo '</pre>';
        }
        
        die();
    }
}

// Dump - Debug helper tanpa die
if (!function_exists('dump')) {
    function dump()
    {
        $args = func_get_args();
        
        echo '<div style="background: #f8f9fa; border: 2px solid #667eea; border-radius: 8px; padding: 20px; margin: 10px 0; font-family: monospace;">';
        foreach ($args as $index => $arg) {
            echo '<div style="margin-bottom: 15px;">';
            echo '<strong style="color: #667eea;">Variable #' . ($index + 1) . ':</strong>';
            echo '<pre style="margin: 10px 0; padding: 10px; background: white; border-radius: 4px;">';
            var_dump($arg);
            echo '</pre>';
            echo '</div>';
        }
        echo '</div>';
    }
}

/**
 * ============================================================================
 * VALIDATION HELPER FUNCTIONS
 * ============================================================================
 */

/**
 * Create validator instance
 * Usage: $validator = validator($data, $rules, $messages);
 * 
 * @param array $data Data yang akan divalidasi
 * @param array $rules Rules validasi
 * @param array $messages Custom error messages (optional)
 * @return Validator
 */
if (!function_exists('validator')) {
    function validator($data, $rules, $messages = array())
    {
        return new Validator($data, $rules, $messages);
    }
}

/**
 * Quick validation with auto redirect on fail
 * Usage: validate($data, $rules, $messages);
 * 
 * @param array $data Data yang akan divalidasi
 * @param array $rules Rules validasi
 * @param array $messages Custom error messages (optional)
 * @param string $redirectUrl URL untuk redirect jika gagal (optional)
 * @return Validator|null Return validator jika sukses, redirect jika gagal
 */
if (!function_exists('validate')) {
    function validate($data, $rules, $messages = array(), $redirectUrl = null)
    {
        $validator = new Validator($data, $rules, $messages);
        
        if ($validator->fails()) {
            $errors = $validator->getErrorMessages();
            $errorMessage = implode(' ', $errors);
            
            // Set flash message untuk alert notif
            setFlashMessage($errorMessage, 'error');
            
            // Redirect
            if ($redirectUrl) {
                header('Location: ' . $redirectUrl);
            } else {
                // Redirect back
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                } else {
                    header('Location: ' . BASEURL);
                }
            }
            exit;
        }
        
        return $validator;
    }
}

/**
 * Validate data and return boolean
 * Usage: if (is_valid($data, $rules)) { ... }
 * 
 * @param array $data Data yang akan divalidasi
 * @param array $rules Rules validasi
 * @param array $messages Custom error messages (optional)
 * @return boolean
 */
if (!function_exists('is_valid')) {
    function is_valid($data, $rules, $messages = array())
    {
        $validator = new Validator($data, $rules, $messages);
        return $validator->passes();
    }
}

/**
 * Get validation errors
 * Usage: $errors = validation_errors($validator);
 * 
 * @param Validator $validator Instance validator
 * @return array
 */
if (!function_exists('validation_errors')) {
    function validation_errors($validator)
    {
        if ($validator instanceof Validator) {
            return $validator->getErrors();
        }
        return array();
    }
}

/**
 * Get first validation error message
 * Usage: $error = validation_first_error($validator);
 * 
 * @param Validator $validator Instance validator
 * @return string|null
 */
if (!function_exists('validation_first_error')) {
    function validation_first_error($validator)
    {
        if ($validator instanceof Validator) {
            return $validator->getFirstError();
        }
        return null;
    }
}

/**
 * Get all validation error messages as flat array
 * Usage: $messages = validation_messages($validator);
 * 
 * @param Validator $validator Instance validator
 * @return array
 */
if (!function_exists('validation_messages')) {
    function validation_messages($validator)
    {
        if ($validator instanceof Validator) {
            return $validator->getErrorMessages();
        }
        return array();
    }
}

if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $message = null, $data = null)
    {
        header('Content-Type: application/json');
        echo json_encode(array('status' => $status, 'message' => $message, 'data' => $data));
    }
}



/**
 * ============================================================================
 * DATABASE HELPER FUNCTIONS
 * ============================================================================
 */

/**
 * Get database connection by name
 * Usage: $db = db_connection('TEST2');
 * 
 * @param string $name Connection name
 * @return DatabaseConnection
 */
if (!function_exists('db_connection')) {
    function db_connection($name = 'default')
    {
        return DatabaseManager::connection($name);
    }
}

/**
 * Get default database connection
 * Usage: $db = db();
 * 
 * @return DatabaseConnection
 */
if (!function_exists('db')) {
    function db()
    {
        return DatabaseManager::connection('default');
    }
}

/**
 * Execute raw query on specific connection
 * Usage: db_query('SELECT * FROM users', array(), 'TEST2');
 * 
 * @param string $query SQL query
 * @param array $params Query parameters
 * @param string $connection Connection name
 * @return mixed
 */
if (!function_exists('db_query')) {
    function db_query($query, $params = array(), $connection = 'default')
    {
        $db = DatabaseManager::connection($connection);
        return $db->query($query, $params);
    }
}
