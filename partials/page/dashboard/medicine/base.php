<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medicines
$medicineData = $db->getConnection()->prepare("
  SELECT am.*, COALESCE(SUM(mr.quantity_taken), 0) AS total_quantity_taken
  FROM animal_medicine am
  LEFT JOIN medication_retrieval mr ON am.id = mr.med_id
  GROUP BY am.id
");
$medicineData->execute();
$medicineItems = $medicineData->get_result()->fetch_all(MYSQLI_ASSOC);

// Display Type
$type = [
  'antibiotik' => 'Antibiotik',
  'antiparasit' => 'Antiparasit',
  'vitamin' => 'Vitamin',
  'vaksin' => 'Vaksin',
  'pemutih' => 'Pemutih',
  'pakan' => 'Pakan',
  'antiinflamasi' => 'Antiinflamasi',
  'mineral' => 'Mineral',
  'obat_kondisioner' => 'Obat',
  'obat_kesuburan' => 'Obat',
  'antibakteri' => 'Antibakteri',
  'anestesi' => 'Anestesi',
  'probiotik' => 'Probiotik',
  'antijamur' => 'Antijamur',
  'suplemen' => 'Suplemen',
  'analgesik' => 'Analgesik',
  'antivirus' => 'Antivirus',
  'ekspektoran' => 'Ekspektoran',
  'other' => 'Lainnya',
];
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Obat</h1>
    <a href="<?= url('/dashboard/medicine/create') ?>" class="btn btn-primary">Tambah Data Baru</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Obat</th>
          <th style="width: auto">Jenis Obat</th>
          <th style="width: auto">Tanggal Beli</th>
          <th style="width: auto">Tanggal Kadaluarsa</th>
          <th style="width: auto">Vendor</th>
          <th style="width: 15%">Jumlah Obat</th>
          <th style="width: 15%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($medicineItems)) : foreach ($medicineItems as $medicineItem) : ?>
            <tr>
              <td>
                <strong><?= $medicineItem['medication_name'] ?></strong>
                <div class="pt-2"><?= $medicineItem['contradictions'] ? $medicineItem['contradictions'] : '<span class="text-muted"><i class="fas fa-info-circle me-1"></i>Tidak ada kontradiksi penggunaan</span>' ?></div>
              </td>
              <td><?= $type[$medicineItem['medication_type']] ?></td>
              <td><?= date('l, j F Y', strtotime($medicineItem['buy_date'])) ?></td>
              <td><?= date('l, j F Y', strtotime($medicineItem['expiration_date'])) ?></td>
              <td><?= $medicineItem['vendor'] ?></td>
              <td>
                <div class="progress mb-2" style="height: 20px;">
                  <?php $remaining = round((intval($medicineItem['stock']) - intval($medicineItem['total_quantity_taken'])) / intval($medicineItem['stock']) * 100, 2) ?>
                  <div class="progress-bar <?= $remaining > 75 ? 'bg-success' : ($remaining >= 30 && $remaining <= 75 ? 'bg-warning' : 'bg-danger') ?>" role="progressbar" style="width: <?= $remaining ?>%;" aria-valuenow="<?= $remaining ?>" aria-valuemin="0" aria-valuemax="100">
                    <?= $remaining ?>% <?= $remaining > 75 ? 'Tersedia' : ($remaining >= 30 && $remaining <= 75 ? 'Tersisa' : ($remaining === 0 ? 'Habis' : 'Tersisa')) ?>
                  </div>
                </div>
                <div><?= intval($medicineItem['stock']) - intval($medicineItem['total_quantity_taken']) ?> / <?= $medicineItem['stock'] ?><?=(intval($medicineItem['stock']) - intval($medicineItem['total_quantity_taken']) !== 0) ?: '<span class="text-danger"><i class="fas fa-exclamation-triangle ms-2 me-1"></i>Stok Habis!</span>' ?></div>
              </td>
              <td>
                <div class="btn-group-sm btn-group">
                  <a href="<?= url("/dashboard/medicine/{$medicineItem['id']}/show") ?>" class="btn btn-primary"><i class="bx bx-show"></i></a>
                  <a href="<?= url("/dashboard/medicine/{$medicineItem['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                  <a href="<?= url("/dashboard/medicine/{$medicineItem['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data obat ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
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