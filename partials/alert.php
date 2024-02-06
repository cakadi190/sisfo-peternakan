<?php

use function inc\helper\dd;

function displayMessages()
{
  $types = [
    'error' => ['title' => 'Galat', 'class' => 'danger'],
    'danger' => ['title' => 'Galat', 'class' => 'danger'],
    'info' => ['title' => 'Informasi', 'class' => 'info'],
    'warning' => ['title' => 'Peringatan', 'class' => 'warning'],
    'success' => ['title' => 'Berhasil', 'class' => 'success']
  ];

  foreach ($types as $type => $data) {
    if (!empty($_SESSION[$type])) {
      $messages = (array)$_SESSION[$type];

      echo '<div class="alert alert-' . $data['class'] . ' alert-dismissible fade show">';
      echo '<strong>' . $data['title'] . '</strong> &mdash;&nbsp;';
      echo implode('<br>', $messages);
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
      echo '</div>';

      unset($_SESSION[$type]);
    }
  }
}

displayMessages();
?>
