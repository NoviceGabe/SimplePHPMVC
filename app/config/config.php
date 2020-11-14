<?php
/*
	Configuration Settings
	Change the values if necessary
*/

// Database parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'usaptayo');
// Website name
define('SITE_NAME', 'Usap Tayo');
// Application root
define('ROOT_URL', '/usaptayo'); // change to / in live server
define('ROOT_PATH', 'http://'.$_SERVER['HTTP_HOST'].ROOT_URL);

// Assets directory
define('ASSETS', ROOT_PATH.'/public/assets');
// Vendor directory
define('VENDOR', ASSETS.'/vendor');
// Bootstrap file
define('BOOTSTRAP', VENDOR.'/bootstrap/css/bootstrap.min.css');
// Jquery file
define('JQUERY', VENDOR.'/jquery/jquery-3.5.1.min.js');

// Default controller and method
define('DEFAULT_CONTROLLER', 'app\\controller\\Home');
define('DEFAULT_METHOD', 'index');
// Default layout
define('DEFAULT_LAYOUT','default');

// Debugging
define('DEBUG', true);

