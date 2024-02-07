<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\indonesiaDate;
use function inc\helper\isLightColor;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medicines
if ($auth->user()['role'] === 1) {
  $dbInit = $db->getConnection()->prepare("
  SELECT
    `users`.`full_name` as `pic_name`,
    `users`.`id` as `user_id`,
    `farm_category`.`id` as `category_id`,
    `farm_category`.`category_name`,
    `farm_category`.`color`,
    `farm_category`.`race`,
    `farm_category`.`weight_class`,
    `farms`.*
  FROM `farms`
  JOIN `users` ON `users`.`id`=`farms`.`pic`
  JOIN `farm_category` ON `farm_category`.`id`=`farms`.`category`
  ");
} else {
  $dbInit = $db->getConnection()->prepare("
  SELECT
    `users`.`full_name` as `pic_name`,
    `users`.`id` as `user_id`,
    `farm_category`.`id` as `category_id`,
    `farm_category`.`category_name`,
    `farm_category`.`color`,
    `farm_category`.`race`,
    `farms`.*
  FROM `farms`
  JOIN `users` ON `users`.`id`=`farms`.`pic`
  JOIN `farm_category` ON `farm_category`.`id`=`farms`.`category`
  WHERE `users`.`id` = ?
  ");
  $dbInit->bind_param('s', $auth->user()['id']);
}
$dbInit->execute();
$farms = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);

$status = [
  'mati' => [
    'label' => 'Mati',
    'class' => 'badge bg-danger',
  ],
  'hidup' => [
    'label' => 'Hidup',
    'class' => 'badge bg-success',
  ],
  'terjual' => [
    'label' => 'Terjual',
    'class' => 'badge bg-primary',
  ],
];
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Hewan Ternak</h1>
    <a href="<?= url('/dashboard/farm/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama</th>
          <th style="width: auto">Kelamin</th>
          <th style="width: auto">Kategori</th>
          <th style="width: auto">Kandang</th>
          <th style="width: auto">Tanggal Masuk</th>
          <th style="width: auto">Status</th>
          <?php if (auth()->user()['role'] === 1) : ?>
            <th style="width: auto">Penanggung Jawab</th>
            <th style="width: 15%">Aksi</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($farms)) : foreach ($farms as $farm) : ?>
            <tr>
              <td><?= $farm['name'] ?></td>
              <td>
                <?php if($farm['gender'] == 'jantan'): ?>
                  <div class="d-flex gap-2 align-items-center">
                    <i class="fas fa-mars-stroke"></i>
                    <span>Jantan</span>
                  </div>
                <?php else: ?>
                  <div class="d-flex gap-2 align-items-center">
                    <i class="fas fa-venus"></i>
                    <span>Betina</span>
                  </div>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge" style="background: <?= $farm['color'] ?>;color: <?= isLightColor($farm['color']) ?>;">
                  <?= $farm['category_name'] ?> / <?= $farm['race'] ?> / <?=ucwords($farm['weight_class']) ?>
                </span>
              </td>
              <td><?= $farm['farm_shed'] ?></td>
              <td><?= indonesiaDate($farm['entrance_date'], true) ?></td>
              <td>
                <span class="<?= $status[$farm['status']]['class'] ?>"><?= $status[$farm['status']]['label'] ?></span>
              </td>
              <?php if (auth()->user()['role'] === 1) : ?>
                <td>
                  <a href="<?= url("/dashboard/employee/{$farm['user_id']}/show") ?>"><?= $farm['pic_name'] ?></a>
                </td>
              <?php endif ?>
              <td>
                <div class="btn-group-sm btn-group">
                  <a href="<?= url("/dashboard/farm/{$farm['id']}/show") ?>" class="btn btn-primary"><i class="bx bx-show"></i></a>
                  <a href="<?= url("/dashboard/farm/{$farm['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                  <a href="<?= url("/dashboard/farm/{$farm['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ternak ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
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
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
