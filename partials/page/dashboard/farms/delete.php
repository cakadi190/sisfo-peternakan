<?php

use function inc\helper\dd;
use function inc\helper\redirect;

$dbinit = $db->getConnection()->prepare("SELECT * FROM farms WHERE `id` = ?");
$dbinit->bind_param('s', $_GET['id']);
$dbinit->execute();
$farmResult = $dbinit->get_result();

if ($farmResult->num_rows > 0) {
  $deleteData = $db->getConnection()->prepare("DELETE FROM farms WHERE `id` = ?");
  $deleteData->bind_param('s', $_GET['id']);
  $deleteDataResult = $deleteData->execute();

  if ($deleteDataResult) {
    $_SESSION['success'] = "Berhasil menghapus data hewan ternak!";
  } else {
    $_SESSION['error'] = "Gagal menghapus data hewan ternak!";
  }

  $deleteData->close();
} else {
  $_SESSION['error'] = "Gagal menghapus! Karena anda tidak memberikan ID target data hewan ternak!";
}

redirect('/dashboard/farm');
