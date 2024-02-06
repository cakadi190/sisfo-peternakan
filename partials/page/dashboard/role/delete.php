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

    if ($userCount > 0) {
      $_SESSION['error'] = "Failed to delete role! The role is still being used by {$userCount} users.";
    } else {
      $deleteRoleResult = deleteRole($db, $id);

      if ($deleteRoleResult) {
        $_SESSION['success'] = "Role deleted successfully!";
      } else {
        $_SESSION['error'] = "Failed to delete role!";
      }
    }
  } else {
    $_SESSION['error'] = "Failed to delete role! No role found with the provided ID.";
  }
} else {
  $_SESSION['error'] = "Failed to delete role! No target role ID provided.";
}

// Redirect to dashboard
redirect('/dashboard/role');
