<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\indonesiaDate;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medication Retrieval Data with Medicine Details
if ($user['role'] === 1) {
  $medicationRetrievalQuery = $db->getConnection()->prepare("
    SELECT
      mr.*,
      us.full_name,
      us.id as user_id,
      am.id as medicine_id,
      am.medication_name
    FROM medication_retrieval mr
    JOIN animal_medicines am ON mr.med_id = am.id
    JOIN users us ON mr.taken_by = us.id
    ORDER BY mr.created_at DESC
  ");
} else { 
  $medicationRetrievalQuery = $db->getConnection()->prepare("
    SELECT
      mr.*,
      us.full_name,
      us.id as user_id,
      am.id as medicine_id,
      am.medication_name
    FROM medication_retrieval mr
    JOIN animal_medicines am ON mr.med_id = am.id
    JOIN users us ON mr.taken_by = us.id
    WHERE mr.taken_by = ?
    ORDER BY mr.created_at DESC
  ");
  $medicationRetrievalQuery->bind_param('s', $user['id']);
}

$medicationRetrievalQuery->execute();
$medicationRetrievalData = $medicationRetrievalQuery->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Pengambilan Obat</h1>
    <a href="<?= url('/dashboard/medicine-usage/create') ?>" class="btn btn-primary">Tambah Data</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Obat</th>
          <th style="width: 30%">Tanggal Pengambilan</th>
          <th style="width: auto">Jumlah Pengambilan Obat</th>
          <?php if (auth()->user()['role'] === 1) : ?>
            <th style="width: auto">Diambil Oleh</th>
            <th style="width: 20%">Aksi</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($medicationRetrievalData) && isset($medicationRetrievalData)) : foreach ($medicationRetrievalData as $medRetrieval) : ?>
            <tr>
              <td><a href="<?= url("/dashboard/medicine/{$medRetrieval['medicine_id']}/show") ?>"><?= $medRetrieval['medication_name'] ?></a></td>
              <td><?= indonesiaDate($medRetrieval['retrieval_date']) ?></td>
              <td><?= $medRetrieval['quantity_taken'] ?> Obat</td>
              <?php if (auth()->user()['role'] === 1) : ?>
                <td><a href="<?= url("/dashboard/employee/{$medRetrieval['user_id']}/show") ?>"><?= $medRetrieval['full_name'] ?></a></td>
                <td>
                  <div class="btn-group-sm btn-group">
                    <a href="<?= url("/dashboard/medicine-usage/{$medRetrieval['id']}/show") ?>" class="btn btn-primary"><i class="bx bx-show"></i></a>
                    <a href="<?= url("/dashboard/medicine-usage/{$medRetrieval['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                    <a href="<?= url("/dashboard/medicine-usage/{$medRetrieval['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengambilan obat ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                  </div>
                </td>
              <?php endif ?>
            </tr>
          <?php endforeach;
        else : ?>
          <tr>
            <td colspan="5">Tidak Ada Data Sama Sekali</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>