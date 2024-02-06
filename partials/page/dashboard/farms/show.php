<?php

use function inc\helper\asset;
use function inc\helper\auth;
use function inc\helper\isLightColor;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
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
  WHERE `farms`.`id` = ?
");
$dbInit->bind_param('s', $_GET['id']);
$dbInit->execute();
$farmData = $dbInit->get_result()->fetch_assoc();

// Status Hewan
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
    <h1 class="mb-0">Detail Hewan Ternak</h1>

    <div class="btn-group-sm btn-group">
      <a href="<?= url("/dashboard/farm") ?>" class="btn btn-primary"><i class="bx bx-chevron-left"></i></a>
      <a href="<?= url("/dashboard/farm/{$farmData['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
      <a href="<?= url("/dashboard/farm/{$farmData['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ternak ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card card-body table-responsive">
        <table class="tables table table-striped border" style="border-radius: .5rem">
          <tbody>
            <!-- Lengkapi disini -->
            <tr>
              <th style="width: 30%">ID</th>
              <td>#<?= $farmData['id'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Nama</th>
              <td><?= $farmData['name'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Ditempatkan Di Kandang</th>
              <td><?= $farmData['farm_shed'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Status Hewan</th>
              <td>
                <span class="<?= $status[$farmData['status']]['class'] ?>"><?= $status[$farmData['status']]['label'] ?></span>
              </td>
            </tr>
            <tr>
              <th style="width: 30%">Tanggal Masuk</th>
              <td><?= date('l, j F Y', strtotime($farmData['entrance_date'])) ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Kategori dan Ras</th>
              <td>
                <span class="badge" style="background: <?= $farmData['color'] ?>;color: <?= isLightColor($farmData['color']) ?>;"><?= $farmData['category_name'] ?> / <?= $farmData['race'] ?></span>
              </td>
            </tr>

            <?php if (auth()->user()['role'] === 1) : ?>
              <tr>
                <th style="width: 30%">Penanggungjawab</th>
                <td>
                  <a href="<?= url("/dashboard/employee/{$farmData['user_id']}/show") ?>"><?= $farmData['pic_name'] ?></a>
                </td>
              </tr>
            <?php endif ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
