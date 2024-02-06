<?php

use inc\classes\Request;
use function inc\helper\auth;
use function inc\helper\bcrypt;
use function inc\helper\dd;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

const TABLE_USERS = 'users';
const SESSION_ERROR_KEY = 'error';
const SESSION_SUCCESS_KEY = 'success';

function handlePostRequest($db)
{
  if (!auth()->check()) {
    redirect('/dashboard');
  }

  if (Request::isMethod('post')) {
    $email = Request::post('email');
    $phone = Request::post('phone');
    $userExists = $db->exists(TABLE_USERS, ['email' => $email]);
    $phoneExists = $db->exists(TABLE_USERS, ['phone' => $phone]);

    if ($userExists) {
      $_SESSION[SESSION_ERROR_KEY] = 'Surat elektronik sudah ada dan terdaftar dalam sistem.';
      redirect('/dashboard/employee');
      exit();
    }

    if ($phoneExists) {
      $_SESSION[SESSION_ERROR_KEY] = 'Nomor ponsel sudah ada dan terdaftar dalam sistem.';
      redirect('/dashboard/employee');
      exit();
    }

    $data = [
      'email'      => $email,
      'full_name'  => Request::post('full_name'),
      'address'    => Request::post('address'),
      'role'       => Request::post('role'),
      'phone'      => Request::post('phone'),
      'password'   => bcrypt(Request::post('password')),
      'created_at' => $data['updated_at'] = date('Y-m-d H:i:s'),
    ];

    if ($db->insert(TABLE_USERS, $data)) {
      $_SESSION[SESSION_SUCCESS_KEY] = 'Berhasil menambahkan ke dalam pengguna.';
      redirect('/dashboard/employee');
    } else {
      $_SESSION[SESSION_ERROR_KEY] = 'Error inserting user into the database.';
      redirect('/dashboard/error');
    }
  } else {
    redirect()->back();
  }
}

handlePostRequest($db);
