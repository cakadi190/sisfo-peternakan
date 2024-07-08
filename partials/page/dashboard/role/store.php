<?php

use inc\classes\Request;

use function inc\helper\auth;
use function inc\helper\random_color;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

if (Request::isMethod('post')) {
  $input = Request::only('name');
  $input = array_merge($input, ['color' => random_color()]);

  try {
    $db->insert('roles', $input);
    $_SESSION['success'] = "Berhasil menambahkan data peran ke dalam database!";
    redirect('/dashboard/role');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
