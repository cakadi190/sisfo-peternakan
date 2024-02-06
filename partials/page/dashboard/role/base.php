<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\isLightColor;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medicines
$rolesData = $db->getConnection()->prepare("SELECT * FROM roles");
$rolesData->execute();
$rolesDataItems = $rolesData->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Peran</h1>
    <a href="<?= url('/dashboard/role/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Peran</th>
          <th style="width: auto">Warna</th>
          <th style="width: 15%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($rolesDataItems)) : foreach ($rolesDataItems as $role) : ?>
            <tr>
              <td><?=$role['name'] ?></td>
              <td><span class="badge" style="background: <?= $role['color'] ?>;color: <?= isLightColor($role['color']) ?>;"><?= $role['color'] ?></span></td>
              <td>
                <div class="btn-group-sm btn-group">
                  <a href="<?= url("/dashboard/role/{$role['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                  <a href="<?= url("/dashboard/role/{$role['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data obat ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach;
        else : ?>
          <tr>
            <td colspan="8">Tidak Ada Data Sama Sekali</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>