<?php

use function inc\helper\redirect;

$barnData = $db->getConnection()->prepare("SELECT * FROM barn_categories WHERE id = ?");
$barnData->bind_param('s', $_GET['id']);
$barnData->execute();
$barnDataResult = $barnData->get_result();

if ($barnDataResult->num_rows > 0) {
  $deleteData = $db->getConnection()->prepare("DELETE FROM barn_categories WHERE id = ?");
  $deleteData->bind_param('s', $_GET['id']);
  $deleteDataResult = $deleteData->execute();

  if ($deleteDataResult) {
    $_SESSION['success'] = "Berhasil menghapus pengguna!";
  } else {
    $_SESSION['error'] = "Gagal menghapus pengguna!";
  }

  $deleteData->close();
} else {
  $_SESSION['error'] = "Gagal menghapus! Karena anda tidak memberikan ID target pengguna!";
}

redirect('/dashboard/barn-category');
