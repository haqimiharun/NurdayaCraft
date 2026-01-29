<?php
/**
 * Application Configuration
 * Loads environment variables and sets up application constants
 */

// Load environment variables from .env file
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue; // Skip comments
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!defined($key)) {
                define($key, $value);
            }
        }
    }
}

// Set defaults if not defined
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'Nurdaya');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('APP_ENV')) define('APP_ENV', 'development');
if (!defined('APP_URL')) define('APP_URL', 'http://localhost/Nurdaya');
if (!defined('APP_TIMEZONE')) define('APP_TIMEZONE', 'Asia/Kuala_Lumpur');

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

// Error reporting based on environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Define path constants
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CORE_PATH', ROOT_PATH . '/core');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');

// Asset URLs
define('ASSETS_URL', APP_URL . '/assets');
define('UPLOADS_URL', APP_URL . '/uploads');
