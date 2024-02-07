<?php

use inc\classes\Sanitize;

use function inc\helper\redirect;

session_start();

function sanitizeInput($input)
{
  return htmlspecialchars(trim($input));
}

function checkIfRoleIsUsed($db, $id)
{
  $getUserData = $db->getConnection()->prepare("SELECT COUNT(*) as userCount FROM `users` WHERE `role` = ?");
  $getUserData->bind_param('s', $id);
  $getUserData->execute();
  $userResult = $getUserData->get_result();
  $userData = $userResult->fetch_assoc();
  return $userData['userCount'];
}

function deleteRole($db, $id)
{
  $deleteRole = $db->getConnection()->prepare("DELETE FROM roles WHERE id = ?");
  $deleteRole->bind_param('s', $id);
  $deleteRoleResult = $deleteRole->execute();
  $deleteRole->close();
  return $deleteRoleResult;
}

$id = isset($_GET['id']) ? sanitizeInput($_GET['id']) : null;

if ($id !== null) {
  $roleList = $db->getConnection()->prepare("SELECT * FROM roles WHERE id = ?");
  $roleList->bind_param('s', $id);
  $roleList->execute();
  $roleListResult = $roleList->get_result();

  if ($roleListResult->num_rows > 0) {
    $userCount = checkIfRoleIsUsed($db, $id);

    if($id === 1) {
      $_SESSION['error'] = "Gagal menghapus peran pengguna, karena anda menghapus peran yang digunakan oleh admin.";
    } elseif ($userCount > 0) {
      $_SESSION['error'] = "Gagal menghapus peran pengguna, karena masih digunakan oleh {$userCount} pengguna.";
    } else {
      $deleteRoleResult = deleteRole($db, $id);

      if ($deleteRoleResult) {
        $_SESSION['success'] = "Peran telah terhapus!";
      } else {
        $_SESSION['error'] = "Gagal menghapus peran!";
      }
    }
  } else {
    $_SESSION['error'] = "Gagal menghapus peran! Tidak ada peran yang sesuai dengan ID yang anda masukkan.";
  }
} else {
  $_SESSION['error'] = "Gagal menghapus peran! Tidak ada target ID peran.";
}

// Redirect to dashboard
redirect('/dashboard/role');
