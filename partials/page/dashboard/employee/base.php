<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\isLightColor;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$userLists = $db->getConnection()->prepare("SELECT users.*, roles.color, roles.name as role_name FROM users JOIN roles ON users.role = roles.id");
$userLists->execute();
$usersLists = $userLists->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Karyawan</h1>
    <a href="<?= url('/dashboard/employee/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Lengkap</th>
          <th style="width: 30%">Alamat</th>
          <th style="width: auto">Nomor HP</th>
          <th style="width: auto">Surat Elektronik</th>
          <th style="width: auto">Peran</th>
          <th style="width: 20%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usersLists)) : foreach ($usersLists as $user) : ?>
            <tr>
              <td><?= $user['full_name'] ?></td>
              <td><?= $user['address'] ?></td>
              <td><?= $user['phone'] ?></td>
              <td><?= $user['email'] ?></td>
              <td>
                <span class="badge" style="background: <?= $user['color'] ?>;color: <?= isLightColor($user['color']) ?>;"><?= $user['role_name'] ?></span>
              </td>
              <td>
                <?php if ($user['id'] === auth()->id()) : ?>
                  <div class="d-flex gap-2">
                    <a href="<?= url("/dashboard/employee/{$user['id']}/show") ?>" class="btn btn-sm btn-primary"><i class="bx bx-show"></i></a>
                    <div class="text-info d-flex gap-1 align-items-center" style="flex-wrap: nowrap;"><i class="bx bx-info-circle"></i>Ini adalah anda</div>
                  </div>
                <?php else : ?>
                  <div class="btn-group-sm btn-group">
                    <a href="<?= url("/dashboard/employee/{$user['id']}/show") ?>" class="btn btn-primary"><i class="bx bx-show"></i></a>
                    <a href="<?= url("/dashboard/employee/{$user['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                    <a href="<?= url("/dashboard/employee/{$user['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach;
        else : ?>
          <tr>
            <td colspan="6">Tidak Ada Data Sama Sekali</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
