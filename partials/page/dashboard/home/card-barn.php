<?php

use function inc\helper\auth;
use function inc\helper\indonesiaDate;
use function inc\helper\url;

// Get All Stored Users
$dbInit = $db->getConnection()->prepare("SELECT `barn`.*, COALESCE(SUM(br.quantity_taken), 0) AS total_quantity_taken 
FROM `barn_categories` `barn`
LEFT JOIN `barn_retrieval` `br` ON `barn`.`id` = `br`.`categories`
GROUP BY barn.id");
$dbInit->execute();
$barnCategories = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="card card-body">
  <div class="d-flex justify-content-between mb-3">
    <h3 class="mb-0">Data Lumbung Pakan</h3>
    <a href="<?= url('/dashboard/barn-category') ?>" class="btn btn-primary">Lihat Semua</a>
  </div>

  <div class="table-responsive rounded-3 border">

    <table class="tables table table-striped" style="border-radius: .5rem">
      <thead>
        <tr>
          <th>Nama Komoditas</th>
          <th>Tanggal Masuk</th>
          <th>Pemasok</th>
          <th>Stok</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($barnCategories) : foreach ($barnCategories as $barn) : ?>
            <tr>
              <td>
                <strong><?= $barn['barn_name'] ?></strong>
              </td>
              <td><?= indonesiaDate($barn['entrance_date'] ?? date('Y-m-d H.i.s'), true) ?></td>
              <td>
                <?php if ($barn['vendor'] === 'local') : ?>
                  Pemasok Lokal (BBIB Singosari)
                <?php else : echo $barn['vendor_name'] ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($barn['stock'] > 0) : ?>
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