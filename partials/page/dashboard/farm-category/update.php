<?php

use inc\classes\Request;
use inc\classes\Sanitize;

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

if (Request::isMethod('post')) {
  $id = Sanitize::validateInput($_GET['id']);
  $input = Request::only(
    'category_name',
    'race',
    'weight_class',
    'color'
  );

  try {
    $db->update('farm_category', $input, "`id` = '{$id}'");
    $_SESSION['success'] = "Berhasil memperbaharui data ke dalam database!";
    redirect('/dashboard/farm-category');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
