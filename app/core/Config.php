<?php

// database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'crudtest');
define('DB_PORT', '3306');

define('FOLDER_PROJECT', 'MVC-PHP-5-TEMPLATE');

// base url
// define('BASEURL','http://192.168.1.78/template/');
define('BASEURL', 'http://localhost/' . FOLDER_PROJECT . '/');

// Folder upload di server
define('UPLOAD_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/' . FOLDER_PROJECT . '/public/img/');

// Fungsi helper untuk URL
function base_url($path = '')
{
    return BASEURL . $path;
}

// Fungsi helper untuk flash message
function getAlertMessage()
{
    echo $_SESSION['flash_message'];
}

function delete_alert()
{
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_message_type']);
}
