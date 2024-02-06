<?php

use function inc\helper\asset;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$userLists = $db->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
$userLists->bind_param('s', $_GET['id']);
$userLists->execute();
$userListsResult = $userLists->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Detail Karyawan</h1>
    
    <div class="btn-group-sm btn-group">
      <a href="<?= url("/dashboard/employee") ?>" class="btn btn-primary"><i class="bx bx-chevron-left"></i></a>
      <a href="<?= url("/dashboard/employee/{$user['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
      <a href="<?= url("/dashboard/employee/{$user['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card card-body table-responsive">
        <table class="tables table table-striped border" style="border-radius: .5rem">
          <tbody>
            <tr>
              <th>Data Masuk Pada</th>
              <td><?= date_format(date_create($userListsResult['created_at']), 'l, j F Y H:i:s') ?></td>
            </tr>
            <tr>
              <th>Data Diperbaharui Pada</th>
              <td><?= date_format(date_create($userListsResult['updated_at']), 'l, j F Y H:i:s') ?></td>
            </tr>
            <tr>
              <th>Nama Lengkap</th>
              <td><?= $userListsResult['full_name'] ?></td>
            </tr>
            <tr>
              <th>Surat Elektronik</th>
              <td><?= $userListsResult['email'] ?></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td><?= $userListsResult['address'] ?></td>
            </tr>
            <tr>
              <th>Nomor HP</th>
              <td><?= $userListsResult['phone'] ?></td>
            </tr>
            <tr>
              <th>Peran</th>
              <td><?= $userListsResult['role'] === 'admin' ? 'Administrator' : 'Karyawan'; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
</div>

<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');