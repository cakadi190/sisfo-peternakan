<?php

use function inc\helper\redirect;

try {
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    throw new Exception("ID kategori tidak diberikan.");
  }

  $id = $_GET['id'];

  $farmCategory = $db->getConnection()->prepare("SELECT * FROM farm_category WHERE id = ?");
  $farmCategory->bind_param('s', $id);
  $farmCategory->execute();
  $farmCategoryResult = $farmCategory->get_result();
  $farmCategory->close(); // Tutup prepared statement setelah digunakan

  if ($farmCategoryResult->num_rows > 0) {
    $deleteCategory = $db->getConnection()->prepare("DELETE FROM farm_category WHERE id = ?");
    $deleteCategory->bind_param('s', $id);
    $deleteCategoryResult = $deleteCategory->execute();
    $deleteCategory->close(); // Tutup prepared statement setelah digunakan

    if ($deleteCategoryResult) {
      $_SESSION['success'] = "Berhasil menghapus kategori!";
    } else {
      throw new Exception("Gagal menghapus kategori.");
    }
  } else {
    throw new Exception("Kategori dengan ID tersebut tidak ditemukan.");
  }

  redirect('/dashboard/farm-category');
} catch (Exception $e) {
  $_SESSION['error'] = $e->getMessage();
  redirect('/dashboard/farm-category');
}
