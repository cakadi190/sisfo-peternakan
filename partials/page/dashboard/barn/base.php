<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\indonesiaDate;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Medication Retrieval Data with Medicine Details
if ($user['role'] === 1) {
  $dbInit = $db->getConnection()->prepare("SELECT
      br.*,
      us.full_name,
      us.id as user_id,
      bc.id as barn_id,
      bc.barn_name
    FROM barn_retrieval br
    JOIN barn_categories bc ON br.categories = bc.id
    JOIN users us ON br.taken_by = us.id
    ORDER BY br.created_at DESC
  ");
} else { 
  $dbInit = $db->getConnection()->prepare("SELECT
      br.*,
      us.full_name,
      us.id as user_id,
      bc.id as barn_id,
      bc.barn_name
    FROM barn_retrieval br
    JOIN barn_categories bc ON br.categories = bc.id
    JOIN users us ON br.taken_by = us.id
    WHERE br.taken_by = ?
    ORDER BY br.created_at DESC
  ");
  $dbInit->bind_param('s', $user['id']);
}

$dbInit->execute();
$barns = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Data Pengambilan Pakan</h1>
    <a href="<?= url('/dashboard/barn/create') ?>" class="btn btn-primary">Tambah Data</a>
  </div>

  <?php include(__DIR__ . '/../../../alert.php') ?>

  <div class="card card-body table-responsive">
    <table class="tables table table-striped border" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Pakan</th>
          <th style="width: 30%">Tanggal Pengambilan</th>
          <th style="width: auto">Jumlah Pengambilan Pakan</th>
          <?php if (auth()->user()['role'] === 1) : ?>
            <th style="width: auto">Diambil Oleh</th>
            <th style="width: 20%">Aksi</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($barns) && isset($barns)) : foreach ($barns as $barn) : ?>
            <tr>
              <td><a href="<?= url("/dashboard/medicine/{$barn['barn_id']}/show") ?>"><?= $barn['barn_name'] ?></a></td>
              <td><?= indonesiaDate($barn['retrieval_date']) ?></td>
              <td><?= $barn['quantity_taken'] ?> Pakan</td>
              <?php if (auth()->user()['role'] === 1) : ?>
                <td><a href="<?= url("/dashboard/employee/{$barn['user_id']}/show") ?>"><?= $barn['full_name'] ?></a></td>
                <td>
                  <div class="btn-group-sm btn-group">
                    <a href="<?= url("/dashboard/barn/{$barn['id']}/show") ?>" class="btn btn-primary"><i class="bx bx-show"></i></a>
                    <a href="<?= url("/dashboard/barn/{$barn['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
                    <a href="<?= url("/dashboard/barn/{$barn['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengambilan pakan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
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