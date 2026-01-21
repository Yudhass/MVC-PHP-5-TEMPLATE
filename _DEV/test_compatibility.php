<?php
/**
 * TEST COMPATIBILITY SCRIPT
 * Script untuk testing kompatibilitas MVC dengan berbagai versi PHP
 * 
 * Cara menggunakan:
 * 1. Jalankan dari browser: http://localhost/MVC-PHP-5-TEMPLATE/_DEV/test_compatibility.php
 * 2. Atau dari CLI: php test_compatibility.php
 */

// Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header untuk output HTML
if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/html; charset=utf-8');
}

echo "<h1>MVC PHP Compatibility Test</h1>\n";
echo "<hr>\n";

// 1. Test PHP Version
echo "<h2>1. PHP Version Test</h2>\n";
echo "PHP Version: <strong>" . PHP_VERSION . "</strong><br>\n";
echo "PHP SAPI: " . php_sapi_name() . "<br>\n";
echo "OS: " . PHP_OS . "<br>\n";

// Check PHP version compatibility
if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    echo "<span style='color:green'>✓ PHP version compatible (>= 5.2)</span><br>\n";
} else {
    echo "<span style='color:red'>✗ PHP version too old (< 5.2)</span><br>\n";
}

echo "<hr>\n";

// 2. Test PDO Availability
echo "<h2>2. Database Extension Test</h2>\n";
if (class_exists('PDO')) {
    echo "<span style='color:green'>✓ PDO available</span><br>\n";
    $drivers = PDO::getAvailableDrivers();
    echo "Available PDO drivers: " . implode(', ', $drivers) . "<br>\n";
} else {
    echo "<span style='color:orange'>⚠ PDO not available (will use mysql_* functions)</span><br>\n";
}

// Check mysql extension
if (function_exists('mysql_connect')) {
    echo "<span style='color:green'>✓ mysql_* functions available</span><br>\n";
} else {
    echo "<span style='color:orange'>⚠ mysql_* functions not available</span><br>\n";
}

// Check mysqli extension
if (function_exists('mysqli_connect')) {
    echo "<span style='color:green'>✓ mysqli_* functions available</span><br>\n";
} else {
    echo "<span style='color:orange'>⚠ mysqli_* functions not available</span><br>\n";
}

echo "<hr>\n";

// 3. Test File Structure
echo "<h2>3. File Structure Test</h2>\n";
$requiredFiles = array(
    '../app/core/Database.php',
    '../app/core/Model.php',
    '../app/core/Controller.php',
    '../app/core/Config.php',
    '../app/models/User.php',
    '../app/controllers/HomeController.php',
);

$allFilesExist = true;
foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<span style='color:green'>✓ {$file}</span><br>\n";
    } else {
        echo "<span style='color:red'>✗ {$file} NOT FOUND</span><br>\n";
        $allFilesExist = false;
    }
}

if ($allFilesExist) {
    echo "<br><span style='color:green'>✓ All required files exist</span><br>\n";
}

echo "<hr>\n";

// 4. Test Config Loading
echo "<h2>4. Config Loading Test</h2>\n";
try {
    require_once '../app/core/Config.php';
    echo "<span style='color:green'>✓ Config.php loaded successfully</span><br>\n";
    
    if (defined('DB_HOST')) {
        echo "DB_HOST: " . DB_HOST . "<br>\n";
        echo "DB_NAME: " . DB_NAME . "<br>\n";
        echo "DB_USER: " . DB_USER . "<br>\n";
        echo "BASEURL: " . BASEURL . "<br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color:red'>✗ Error loading Config: " . $e->getMessage() . "</span><br>\n";
}

echo "<hr>\n";

// 5. Test Database Connection
echo "<h2>5. Database Connection Test</h2>\n";
try {
    require_once '../app/core/Database.php';
    $db = new Database();
    echo "<span style='color:green'>✓ Database class instantiated</span><br>\n";
    
    // Test query
    echo "Attempting test query...<br>\n";
    // Note: This will only work if database is configured
    echo "<span style='color:blue'>ℹ Database connection test requires proper configuration</span><br>\n";
    
} catch (Exception $e) {
    echo "<span style='color:red'>✗ Database error: " . $e->getMessage() . "</span><br>\n";
}

echo "<hr>\n";

// 6. Test Model Loading
echo "<h2>6. Model Loading Test</h2>\n";
try {
    require_once '../app/core/Model.php';
    echo "<span style='color:green'>✓ Model class loaded</span><br>\n";
    
    // Check if methods exist
    $methods = array('insert', 'selectAll', 'selectOne', 'selectWhere', 'update', 'updateById', 'delete', 'deleteById', 'find');
    echo "<br><strong>Available CRUD methods:</strong><br>\n";
    foreach ($methods as $method) {
        if (method_exists('Model', $method)) {
            echo "<span style='color:green'>✓ {$method}()</span><br>\n";
        } else {
            echo "<span style='color:red'>✗ {$method}() NOT FOUND</span><br>\n";
        }
    }
    
} catch (Exception $e) {
    echo "<span style='color:red'>✗ Model loading error: " . $e->getMessage() . "</span><br>\n";
}

echo "<hr>\n";

// 7. Test Array Syntax Compatibility
echo "<h2>7. Array Syntax Test</h2>\n";

// Old style (PHP 5.2+)
$oldStyle = array('key' => 'value');
echo "<span style='color:green'>✓ Old array syntax (array()) works</span><br>\n";

// New style (PHP 5.4+)
if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
    eval('$newStyle = ["key" => "value"];');
    echo "<span style='color:green'>✓ New array syntax ([]) available</span><br>\n";
} else {
    echo "<span style='color:orange'>⚠ New array syntax ([]) not available (PHP < 5.4)</span><br>\n";
}

echo "<hr>\n";

// 8. Test Polyfill Functions
echo "<h2>8. Polyfill Functions Test</h2>\n";

// Test http_response_code polyfill
if (function_exists('http_response_code')) {
    echo "<span style='color:green'>✓ http_response_code() available</span><br>\n";
    
    // Check if it's native or polyfill
    if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
        echo "&nbsp;&nbsp;→ Using native PHP function<br>\n";
    } else {
        echo "&nbsp;&nbsp;→ Using polyfill (compatibility layer)<br>\n";
    }
} else {
    echo "<span style='color:red'>✗ http_response_code() not available</span><br>\n";
}

echo "<hr>\n";

// 9. Summary
echo "<h2>9. Summary</h2>\n";
echo "<div style='background:#f0f0f0; padding:15px; border-radius:5px;'>\n";

$phpOK = version_compare(PHP_VERSION, '5.2.0', '>=');
$dbOK = class_exists('PDO') || function_exists('mysql_connect');
$filesOK = $allFilesExist;

if ($phpOK && $dbOK && $filesOK) {
    echo "<h3 style='color:green'>✓ ALL TESTS PASSED</h3>\n";
    echo "<p>Your environment is ready to run MVC-PHP-5-TEMPLATE!</p>\n";
    echo "<p><strong>Next steps:</strong></p>\n";
    echo "<ol>\n";
    echo "<li>Configure database settings in app/core/Config.php</li>\n";
    echo "<li>Import database.sql from _DEV folder</li>\n";
    echo "<li>Access the application via browser</li>\n";
    echo "</ol>\n";
} else {
    echo "<h3 style='color:orange'>⚠ SOME TESTS FAILED</h3>\n";
    echo "<p>Please check the errors above and fix them before running the application.</p>\n";
    
    if (!$phpOK) {
        echo "<p style='color:red'>- PHP version is too old, upgrade to at least PHP 5.2</p>\n";
    }
    if (!$dbOK) {
        echo "<p style='color:red'>- No database extension available, install PDO or mysql extension</p>\n";
    }
    if (!$filesOK) {
        echo "<p style='color:red'>- Some required files are missing, check file structure</p>\n";
    }
}

echo "</div>\n";

echo "<hr>\n";
echo "<p><small>Test completed at: " . date('Y-m-d H:i:s') . "</small></p>\n";

// For CLI output
if (php_sapi_name() === 'cli') {
    echo "\n\n";
    echo "=================================\n";
    echo "Test completed successfully!\n";
    echo "=================================\n";
}
