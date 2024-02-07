<?php

use inc\classes\Request;
use inc\classes\Sanitize;

use function inc\helper\auth;
use function inc\helper\bcrypt;
use function inc\helper\dd;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

const TABLE_USERS = 'users';
const SESSION_ERROR_KEY = 'error';
const SESSION_SUCCESS_KEY = 'success';

// Check authentication
if (!auth()->check()) {
  redirect('/dashboard');
}

// Process POST request
if (Request::isMethod('post')) {
  // Validate and sanitize input
  $id = Sanitize::validateInput($_GET['id'] ?? '');

  if (!$id) {
    redirect('/dashboard');
  }

  $inputs = Request::only('email', 'full_name', 'address', 'role', 'phone');
  $email = Request::post('email');
  $phone = Request::post('phone');

  // Check for existing email and phone
  if ($db->exists(TABLE_USERS, ['email' => $email, 'id' => "!= {$id}"])) {
    $_SESSION[SESSION_ERROR_KEY] = 'Surat elektronik sudah ada dan terdaftar dalam sistem.';
    redirect("/dashboard/employee/{$id}/edit");
  }
  
  if ($db->exists(TABLE_USERS, ['phone' => $phone, 'id' => "!= {$id}"])) {
    $_SESSION[SESSION_ERROR_KEY] = 'Nomor ponsel sudah ada dan terdaftar dalam sistem.';
    redirect("/dashboard/employee/{$id}/edit");
  }

  // Prepare data for update
  $data = $inputs;
  $data['updated_at'] = date('Y-m-d H:i:s');

  // Update password if provided
  if (Request::exists('password')) {
    $data['password'] = bcrypt(Request::post('password'));
  }

  // Perform database update
  try {
    $db->update(TABLE_USERS, $data, "id = {$id}");
    $_SESSION[SESSION_SUCCESS_KEY] = 'Berhasil memperbaharui data karyawan';
    redirect('/dashboard/employee');
  } catch(\Exception $e) {
    $_SESSION[SESSION_ERROR_KEY] = "Gagal Memperbaharui, karena ada: {$e->getMessage()}";
    redirect()->back();
  }
} else {
  redirect()->back();
}
