<?php

use inc\classes\Input;
use inc\classes\Validator;

use function inc\helper\auth;
use function inc\helper\redirect;

require_once __DIR__ . '/inc/loader.php';

// Redirect to the dashboard if the user is already authenticated a.k.a middleware
if ($auth->check()) {
  redirect("/dashboard");
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $inputs   = Input::sanitizeInput($_POST);
  $email    = $inputs['email'];
  $password = $inputs['password'];
  $remember = filter_var($inputs['remember'], FILTER_VALIDATE_BOOLEAN);

  $validator = new Validator();
  $validator->validateEmail($email);
  $validator->validateMinLength($email, 5);
  $validator->validateRequired($email, 5);
  $validator->validateRequired($password);
  $validator->validateMinLength($password, 8);

  // Check if form is valid
  if ($validator->isValid()) {
    if (auth()->attempt(['email' => $email, 'password' => $password], $remember)) {
      $_SESSION['success'] = "Anda berhasil masuk ke dalam sistem.";
      return redirect('/dashboard');
    } else {
      $_SESSION['error'] = "Ups, surat elektronik atau kata sandi anda tidak valid atau tidak dapat ditemukan. Silahkan coba lagi.";
    }
  } else {
    $_SESSION['error'] = $validator->getErrors();
  }

  return redirect('/');
}
