<?php

use function inc\helper\redirect;

$farmCategory = $db->getConnection()->prepare("SELECT * FROM farm_category WHERE id = ?");
$farmCategory->bind_param('s', $_GET['id']);
$farmCategory->execute();
$farmCategoryResult = $farmCategory->get_result();

if ($farmCategoryResult->num_rows > 0) {
  $deleteCategory = $db->getConnection()->prepare("DELETE FROM farm_category WHERE id = ?");
  $deleteCategory->bind_param('s', $_GET['id']);
  $deleteCategoryResult = $deleteCategory->execute();

  if ($deleteCategoryResult) {
    $_SESSION['success'] = "Berhasil menghapus kategori!";
  } else {
    $_SESSION['error'] = "Gagal menghapus kategori!";
  }

  $deleteCategory->close();
} else {
  $_SESSION['error'] = "Gagal menghapus! Karena anda tidak memberikan ID target kategori!";
}

redirect('/dashboard/farm-category');
