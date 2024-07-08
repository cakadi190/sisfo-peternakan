<?php

use function inc\helper\indonesiaDate;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$medicineData = $db->getConnection()->prepare("
  SELECT am.*, COALESCE(SUM(mr.quantity_taken), 0) AS total_quantity_taken
  FROM animal_medicines am
  LEFT JOIN medication_retrieval mr ON am.id = mr.med_id
  WHERE am.id = ?
  GROUP BY am.id
");
$medicineData->bind_param('s', $_GET['id']);
$medicineData->execute();
$medicineDataResult = $medicineData->get_result()->fetch_assoc();

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
    <h1 class="mb-0">Detail Obat</h1>

    <div class="btn-group-sm btn-group">
      <a href="<?= url("/dashboard/medicine") ?>" class="btn btn-primary"><i class="bx bx-chevron-left"></i></a>
      <a href="<?= url("/dashboard/medicine/{$medicineDataResult['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
      <a href="<?= url("/dashboard/medicine/{$medicineDataResult['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
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
              <td><?= $medicineDataResult['id'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Tanggal Pembelian</th>
              <td><?= date('l, j F Y', strtotime($medicineDataResult['buy_date'])) ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Nama Obat</th>
              <td><?= $medicineDataResult['medication_name'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Tipe Obat</th>
              <td><?= $type[$medicineDataResult['medication_type']] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Dosis</th>
              <td><?= $medicineDataResult['dosage'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Cara Penggunaan</th>
              <td><?= $medicineDataResult['usage'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Nomor Batch</th>
              <td><?= $medicineDataResult['batch_number'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Tanggal Kadaluarsa</th>
              <td><?= indonesiaDate($medicineDataResult['expiration_date']) ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Pemasok</th>
              <td><?= $medicineDataResult['vendor'] ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Kontraindikasi dan Efek Samping</th>
              <td><?= $medicineDataResult['contradictions'] ? $medicineDataResult['contradictions'] : '<span class="text-muted">Tidak ada kontradiksi penggunaan</span>' ?></td>
            </tr>
            <tr>
              <th style="width: 30%">Stok</th>
              <td>
                <div class="progress mb-2" style="height: 20px;">
                  <?php $remaining = round((intval($medicineDataResult['stock']) - intval($medicineDataResult['total_quantity_taken'])) / intval($medicineDataResult['stock']) * 100, 2) ?>
                  <div class="progress-bar <?= $remaining > 75 ? 'bg-success' : ($remaining >= 30 && $remaining <= 75 ? 'bg-warning' : 'bg-danger') ?>" role="progressbar" style="width: <?= $remaining ?>%;" aria-valuenow="<?= $remaining ?>" aria-valuemin="0" aria-valuemax="100">
                    <?= $remaining ?>% <?= $remaining > 75 ? 'Tersedia' : ($remaining >= 30 && $remaining <= 75 ? 'Tersisa' : ($remaining === 0 ? 'Habis' : 'Tersisa')) ?>
                  </div>
                </div>
                <div><?= intval($medicineDataResult['stock']) - intval($medicineDataResult['total_quantity_taken']) ?> / <?= $medicineDataResult['stock'] ?></div>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
