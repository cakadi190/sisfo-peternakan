<?php

use inc\classes\Request;

use function inc\helper\auth;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

function checkIfNegative($number) {
  if(intval($number <= 1)) {
    $_SESSION['error'] = "Nilai \"stok\" harus lebih dari sama dengan 1";
    redirect()->back();
    exit();
  }
}

if (Request::isMethod('post')) {
  $input = Request::only(
    'barn_name',
    'description',
    'vendor',
    'vendor_name',
  );

  checkIfNegative(Request::post('stock'));

  $barnCategory = array_merge($input, [
    'created_at' => $data['updated_at'] = date('Y-m-d H:i:s'),
    'id' => uniqid(),
    'stock' => intval(Request::post('stock')),
  ]);

  try {
    $db->insert('barn_categories', $barnCategory);
    $_SESSION['success'] = "Berhasil menambahkan data ke dalam database!";
    redirect('/dashboard/barn-category');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
