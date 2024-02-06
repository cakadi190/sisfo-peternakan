<?php

use inc\classes\Request;
use inc\classes\Sanitize;

use function inc\helper\auth;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

if (Request::isMethod('post')) {
  $id = Sanitize::validateInput($_GET['id']);
  $input = Request::only(
    'buy_date',
    'medication_name',
    'medication_type',
    'dosage',
    'usage',
    'batch_number',
    'expiration_date',
    'vendor',
    'contradictions'
  );

  $medicationData = array_merge($input, [
    'id' => uniqid(),
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
    'stock' => intval(Request::post('stock'))
  ]);

  if (intval($medicationData['stock']) < 0) {
    $_SESSION['error'] = "Stok tidak boleh kurang dari 0 atau dalam kata lain nilai minus.";
    redirect()->back();
  }

  try {
    $db->update('animal_medicine', $medicationData, "`id` = '{$id}'");
    $_SESSION['success'] = "Berhasil memperbaharui data ke dalam database!";
    redirect('/dashboard/medicine');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}