<?php

use inc\classes\Request;

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\random_color;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

if (Request::isMethod('post')) {
  $input = Request::only(
    'category_name',
    'race',
    'weight_class',
  );

  $farmCategory = array_merge($input, [
    'color' => random_color(),
    'id' => uniqid(),
  ]);

  try {
    $db->insert('farm_category', $farmCategory);
    $_SESSION['success'] = "Berhasil menambahkan data ke dalam database!";
    redirect('/dashboard/farm-category');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
