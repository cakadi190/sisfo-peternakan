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

function checkIfStockLessThanTotalRetrieval($id, $stock) {
  global $db;

  $getStock = $db->getConnection()->prepare("SELECT COALESCE(CAST(SUM(`quantity_taken`) AS UNSIGNED), 0) as `total` FROM `medication_retrieval` WHERE `med_id` = ?");
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

  checkIfStockLessThanTotalRetrieval($id, intval(Request::post('stock')));

  try {
    $db->update('animal_medicines', $medicationData, "`id` = '{$id}'");
    $_SESSION['success'] = "Berhasil memperbaharui data ke dalam database!";
    redirect('/dashboard/medicine');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}
