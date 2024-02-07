<?php

use function inc\helper\auth;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$dbInit = $db->getConnection()->prepare("SELECT `barn`.*, COALESCE(SUM(br.quantity_taken), 0) AS total_quantity_taken 
FROM `barn_categories` `barn`
LEFT JOIN `barn_retrieval` `br` ON `barn`.`id` = `br`.`categories`
GROUP BY barn.id");
$dbInit->execute();
$barnCategories = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Komoditas Gudang Pakan</h1>
    <a href="<?= url('/dashboard/barn-category/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th>Nama Komoditas</th>
          <th>Tanggal Masuk</th>
          <th>Pemasok</th>
          <th>Stok</th>
          <?php if (auth()->user()['role'] === 1) : ?>
            <th>Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($barnCategories) : foreach ($barnCategories as $barn) : ?>
            <tr>
              <td>
                <strong><?= $barn['barn_name'] ?></strong>
                <div class="pt-2"><?= $barn['description'] ? $barn['description'] : '<i class="fas fa-info-circle me-2"></i> Tidak ada deskripsi' ?></div>
              </td>
              <td><?= (new DateTime($barn['entrance_date'] ?? date('Y-m-d H.i.s')))->format('l, j F Y H.i.s') ?></td>
              <td>
                <?php if ($barn['vendor'] === 'local') : ?>
                  Pemasok Lokal
                <?php else : echo $barn['vendor_name'] ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if($barn['stock'] > 0) : ?>
                <div class="progress mb-2" style="height: 20px;">
                  <?php $remaining = round((intval($barn['stock']) - intval($barn['total_quantity_taken'])) / intval($barn['stock']) * 100, 2) ?>
                  <div class="progress-bar <?= $remaining > 75 ? 'bg-success' : ($remaining >= 30 && $remaining <= 75 ? 'bg-warning' : 'bg-danger') ?>" role="progressbar" style="width: <?= $remaining ?>%;" aria-valuenow="<?= $remaining ?>" aria-valuemin="0" aria-valuemax="100">
                    <?= $remaining ?>% <?= $remaining > 75 ? 'Tersedia' : ($remaining >= 30 && $remaining <= 75 ? 'Tersisa' : ($remaining === 0 ? 'Habis' : 'Tersisa')) ?>
                  </div>
                </div>
                <?php endif; ?>
                <div>
                  <?= intval($barn['stock']) - intval($barn['total_quantity_taken']) ?> /
                  <?= $barn['stock'] ?>
                  <?= (intval($barn['stock']) - intval($barn['total_quantity_taken']) !== 0) ? '' : '<span class="text-danger"><i class="fas fa-exclamation-triangle ms-2 me-1"></i>Stok Habis!</span>' ?>
                </div>
              </td>
              <?php if (auth()->user()['role'] === 1) : ?>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="<?= url("dashboard/barn-category/{$barn['id']}/edit") ?>" class="btn btn-warning"><i class="fas fa-pencil"></i></a>
                    <a href="<?= url("dashboard/barn-category/{$barn['id']}/delete") ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')"><i class="fas fa-trash"></i></a>
                  </div>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach;
        else : ?>
          <tr>
            <td colspan="5">Data tidak dapat ditemukan.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
