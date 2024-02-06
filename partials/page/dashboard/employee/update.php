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

// The middleware
if (!auth()->check()) redirect('/dashboard');

if (Request::isMethod('post')) {
  $inputs = Request::only('email', 'full_name', 'address', 'role', 'phone');
  $id = Sanitize::validateInput($_GET['id']);

  $email = Request::post('email');
  $phone = Request::post('phone');
  $userExists = $db->exists(TABLE_USERS, ['email' => $email, 'id' => "!= {$id}"]);
  $phoneExists = $db->exists(TABLE_USERS, ['phone' => $phone, 'id' => "!= {$id}"]);

  if ($userExists) {
    $_SESSION[SESSION_ERROR_KEY] = 'Surat elektronik sudah ada dan terdaftar dalam sistem.';
    redirect("/dashboard/employee/{$id}/edit");
    exit();
  }

  if ($phoneExists) {
    $_SESSION[SESSION_ERROR_KEY] = 'Nomor ponsel sudah ada dan terdaftar dalam sistem.';
    redirect("/dashboard/employee/{$id}/edit");
    exit();
  }

  // If user change their password
  if (Request::exists('password')) {
    $password = bcrypt(Request::post('password'));
    $data = array_merge($inputs, ['password' => $password]);
  }

  $data = array_merge($data, ['password' => $password, 'updated_at' => date('Y-m-d H:i:s')]);

  $db->update('users', $data, "id = {$id}");

  $_SESSION['success'] = 'Berhasil memperbaharui data karyawan';
  redirect('/dashboard/employee');
} else {
  redirect()->back();
}
