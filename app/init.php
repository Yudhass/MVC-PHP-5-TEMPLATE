<?php 

// Start output buffering to prevent "headers already sent" errors
ob_start();

if(!session_id()) session_start();

require_once 'core/App.php';
require_once 'core/Router.php'; 
require_once 'core/Controller.php';
require_once 'core/Config.php';
require_once 'core/Database.php';
require_once 'core/Helper.php';
// require_once 'core/Flasher.php';
?>