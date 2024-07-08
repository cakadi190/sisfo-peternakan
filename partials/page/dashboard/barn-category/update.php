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

function checkIfNegative($number) {
  if(intval($number <= 1)) {
    $_SESSION['error'] = "Nilai \"stok\" harus lebih dari sama dengan 1";
    redirect()->back();
    exit();
  }
}

function checkIfStockLessThanTotalRetrieval($id, $stock) {
  global $db;

  $getStock = $db->getConnection()->prepare("SELECT COALESCE(CAST(SUM(`quantity_taken`) AS UNSIGNED), 0) as `total` FROM `barn_retrievals` WHERE `categories` = ?");
  $getStock->bind_param("s", $id);
  $getStock->execute();
  $dataStock = $getStock->get_result()->fetch_assoc();

  $calcTotal = intval($dataStock['total']);

  if($calcTotal > $stock) {
    $_SESSION['error'] = "Stok tidak boleh kurang dari \"{$calcTotal} obat\".";
    redirect()->back();
    exit();
  }
}

if (Request::isMethod('post')) {
  $id = Sanitize::sanitizeInput($_GET['id']);
  $input = Request::only(
    'barn_name',
    'description',
    'vendor',
    'vendor_name',
  );

  checkIfStockLessThanTotalRetrieval($id, intval(Request::post('stock')));
  checkIfNegative(Request::post('stock'));

  $barnCategory = array_merge($input, [
    'updated_at' => date('Y-m-d H:i:s'),
    'id' => uniqid(),
    'stock' => intval(Request::post('stock')),
  ]);

  try {
    $db->update('barn_categories', $barnCategory, "`id` = '{$id}'");
    $_SESSION['success'] = "Berhasil mengubah data ke dalam database!";
    redirect('/dashboard/barn-category');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
