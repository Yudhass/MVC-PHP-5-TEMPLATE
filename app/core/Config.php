<?php
// base url
define('BASEURL','http://192.168.1.78/template/');

// Folder upload di server
define('UPLOAD_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/template/public/img/');

// database
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','phpmvc');
define('DB_PORT','3306');

define('FOLDER_PROJECT', 'MVC-PHP-5-TEMPLATE');

// Fungsi helper untuk URL
function base_url($path = '') {
    return BASEURL . $path;
}
?>