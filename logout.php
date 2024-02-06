<?php

use inc\classes\Input;
use inc\classes\Validator;

use function inc\helper\auth;
use function inc\helper\redirect;

require_once __DIR__ . '/inc/loader.php';


// If Logout Action Performed
if ($auth->check()) {
  auth()->logout();
  $_SESSION['success'] = "Berhasil mengeluarkan anda dari sesi ini.";
} else {
  $_SESSION['error'] = "Anda belum melakukan autentikasi. Silahkan autentikasi terlebih dahulu.";
}

redirect('/');
