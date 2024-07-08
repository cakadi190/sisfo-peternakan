<?php

use function inc\helper\dd;
use function inc\helper\redirect;

$medicineData = $db->getConnection()->prepare("SELECT * FROM animal_medicines WHERE `id` = ?");
$medicineData->bind_param('s', $_GET['id']);
$medicineData->execute();
$medicineDataResult = $medicineData->get_result();

if ($medicineDataResult->num_rows > 0) {
  $deleteData = $db->getConnection()->prepare("DELETE FROM animal_medicines WHERE `id` = ?");
  $deleteData->bind_param('s', $_GET['id']);
  $deleteDataResult = $deleteData->execute();

  if ($deleteDataResult) {
    $_SESSION['success'] = "Berhasil menghapus data obat!";
  } else {
    $_SESSION['error'] = "Gagal menghapus data obat!";
  }

  $deleteData->close();
} else {
  $_SESSION['error'] = "Gagal menghapus! Karena anda tidak memberikan ID target data obat!";
}

redirect('/dashboard/medicine');
