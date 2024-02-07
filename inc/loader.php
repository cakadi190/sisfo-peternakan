<?php

namespace inc;

/**
 * Autoloader file
 * Including any file inside inc folders.
 */

use inc\classes\Authentication;
use inc\classes\Database;
use inc\classes\Environtment;

// Autoload Env Configuration
include __DIR__ . '/classes/Environtment.php';
(new Environtment(__DIR__ . '/../.env'))->load();

// Autoloader Classess File
require_once __DIR__ . '/classes/Authentication.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Environtment.php';
require_once __DIR__ . '/classes/Input.php';
require_once __DIR__ . '/classes/Request.php';
require_once __DIR__ . '/classes/Sanitize.php';
require_once __DIR__ . '/classes/Url.php';
require_once __DIR__ . '/classes/Validator.php';
// Autoload Helper Files
require_once __DIR__ . '/helper/auth.php';
require_once __DIR__ . '/helper/color.php';
require_once __DIR__ . '/helper/debug.php';
require_once __DIR__ . '/helper/other.php';
require_once __DIR__ . '/helper/urls.php';

// Change Locale
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, 'id_ID');
setlocale(LC_TIME, 'IND');

# Database Initializaition
# Change with the required credentials an .env file!
$hostname = "localhost";
$username = "root";
$password = "cakadi1902";
$database = "bbib_crud";

$db           = new Database($hostname, $username, $password, $database);
$authDatabase = $db->getConnection();
$auth         = new Authentication($authDatabase);
