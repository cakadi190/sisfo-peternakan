<?php

use function inc\helper\redirect;

$userLists = $db->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
$userLists->bind_param('s', $_GET['id']);
$userLists->execute();
$userListsResult = $userLists->get_result();

if ($userListsResult->num_rows > 0) {
  $deleteUser = $db->getConnection()->prepare("DELETE FROM users WHERE id = ?");
  $deleteUser->bind_param('s', $_GET['id']);
  $deleteUserResult = $deleteUser->execute();

  if ($deleteUserResult) {
    $_SESSION['success'] = "Berhasil menghapus pengguna!";
  } else {
    $_SESSION['error'] = "Gagal menghapus pengguna!";
  }

  $deleteUser->close();
} else {
  $_SESSION['error'] = "Gagal menghapus! Karena anda tidak memberikan ID target pengguna!";
}

redirect('/dashboard/employee');
