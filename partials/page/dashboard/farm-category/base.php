<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\isLightColor;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medicines
$dbInit = $db->getConnection()->prepare("SELECT farm_category.*, 
                                        COUNT(farms.id) AS total_data, 
                                        SUM(CASE WHEN farms.status = 'hidup' THEN 1 ELSE 0 END) AS alive,
                                        SUM(CASE WHEN farms.status != 'hidup' THEN 1 ELSE 0 END) AS sold_or_dead
                                        FROM farm_category 
                                        LEFT JOIN farms ON farm_category.id = farms.category 
                                        GROUP BY farm_category.id");
$dbInit->execute();
$farmCategory = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Obat</h1>
    <a href="<?= url('/dashboard/farm-category/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Kategori</th>
          <th style="width: auto">Warna Kategori</th>
          <th style="width: auto">Ras</th>
          <th style="width: 30%">Populasi</th>
          <th style="width: auto">Berat</th>
          <th style="width: 15%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($farmCategory)) : foreach ($farmCategory as $farm) : ?>
            <tr>
              <td><?= $farm['category_name'] ?></td>
              <td><span class="badge font-monospace" style="background: <?= $farm['color'] ?>;color: <?= isLightColor($farm['color']) ?>;"><?= $farm['color'] ?></span></td>
              <td><?= $farm['race'] ?></td>
              <td>
                <strong><?= $farm['alive'] ?> ekor</strong>
                <?php if($farm['alive'] > 0): ?>
                <div class="mt-2">
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?=($farm['alive'] / $farm['total_data']) * 100 ?>%" aria-valuenow="<?=($farm['alive'] / $farm['total_data']) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?=($farm['sold_or_dead'] / $farm['total_data']) * 100 ?>%" aria-valuenow="<?=($farm['sold_or_dead'] / $farm['total_data']) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <div class="d-flex justify-content-between">
                    <div><?=$farm['alive'] ?> hidup</div>
                    <div><?=$farm['sold_or_dead'] ?> terjual / mati</div>
                  </div>
                </div>
                <?php endif; ?>
              </td>
              <td><?= ucwords($farm['weight_class']) ?></td>
              <td>
                <div class="btn-group-sm btn-group">
                  <a href="<?= url("/dashboard/farm-category/{$farm['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                  <a href="<?= url("/dashboard/farm-category/{$farm['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data obat ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                </div>
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
?>