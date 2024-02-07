<?php

use function inc\helper\url;

$dbInit = $db->getConnection()->prepare("SELECT farm_category.*, 
                                        COUNT(farms.id) AS total_data, 
                                        SUM(CASE WHEN farms.status = 'hidup' THEN 1 ELSE 0 END) AS alive,
                                        SUM(CASE WHEN farms.status != 'hidup' THEN 1 ELSE 0 END) AS sold_or_dead
                                        FROM farm_category 
                                        LEFT JOIN farms ON farm_category.id = farms.category 
                                        GROUP BY farm_category.id
                                        LIMIT 10");
$dbInit->execute();
$farmCategory = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="card card-body">
  <div class="d-flex justify-content-between mb-3">
    <h3 class="mb-0">Data Hewan Ternak</h3>
    <a href="<?= url('/dashboard/farm') ?>" class="btn btn-primary">Lihat Semua</a>
  </div>

  <div class="table-responsive border rounded-3">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Ras</th>
          <th style="width: 50%">Populasi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($farmCategory)) : foreach ($farmCategory as $farm) : ?>
            <tr>
              <td><?= $farm['category_name'] ?></td>
              <td><?= $farm['race'] ?></td>
              <td>
                <strong><?= intval($farm['alive']) + intval($farm['sold_or_dead']) ?> ekor</strong>
                <?php if ((intval($farm['alive']) + intval($farm['sold_or_dead'])) > 0) : ?>
                  <div class="mt-2">
                    <div class="progress">
                      <?php if (intval($farm['alive']) > 0) : ?><div class="progress-bar bg-success" role="progressbar" style="width: <?= ($farm['alive'] / $farm['total_data']) * 100 ?>%" aria-valuenow="<?= ($farm['alive'] / $farm['total_data']) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div><?php endif; ?>
                      <?php if (intval($farm['sold_or_dead']) > 0) : ?><div class="progress-bar bg-warning" role="progressbar" style="width: <?= ($farm['sold_or_dead'] / $farm['total_data']) * 100 ?>%" aria-valuenow="<?= ($farm['sold_or_dead'] / $farm['total_data']) * 100 ?>" aria-valuemin="0" aria-valuemax="100"></div><?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                      <div><?= $farm['alive'] ?> hidup</div>
                      <div><?= $farm['sold_or_dead'] ?> terjual / mati</div>
                    </div>
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