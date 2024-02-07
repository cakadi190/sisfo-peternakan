<?php

use function inc\helper\asset;
use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$barn = $db->getConnection()->prepare("SELECT
br.*,
us.full_name,
us.id as user_id,
bc.id as barn_id,
bc.barn_name
FROM barn_retrieval br
JOIN barn_categories bc ON br.categories = bc.id
JOIN users us ON br.taken_by = us.id
WHERE br.id = ?
ORDER BY br.created_at DESC
");
$barn->bind_param('s', $_GET['id']);
$barn->execute();
$barnResult = $barn->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Detail Pengambilan Pakan</h1>

    <div class="btn-group-sm btn-group">
      <a href="<?= url("/dashboard/barn") ?>" class="btn btn-primary"><i class="bx bx-chevron-left"></i></a>
      <a href="<?= url("/dashboard/barn/{$barnResult['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
      <a href="<?= url("/dashboard/barn/{$barnResult['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card card-body table-responsive">
        <table class="tables table table-striped border" style="border-radius: .5rem">
          <tbody>
            <tr>
              <th>Data Masuk Pada</th>
              <td><?= (new DateTime($barnResult['created_at']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Data Diperbaharui Pada</th>
              <td><?= (new DateTime($barnResult['updated_at']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Nama Pakan</th>
              <td>
                <a href="<?= url("/dashboard/barn-category/{$barnResult['barn_id']}/show") ?>"><?= $barnResult['barn_name'] ?></a>
              </td>
            </tr>
            <tr>
              <th>Petugas</th>
              <td>
                <a href="<?= url("/dashboard/employee/{$barnResult['user_id']}/show") ?>"><?= $barnResult['full_name'] ?></a>
              </td>
            </tr>
            <tr>
              <th>Diambil Pada</th>
              <td><?= (new DateTime($barnResult['retrieval_date']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Jumlah Pengambilan</th>
              <td><?= $barnResult['quantity_taken'] ?> Pakan</td>
            </tr>
            <tr>
              <th>Bukti</th>
              <td><img src="<?= url("/uploads/{$barnResult['evidence']}") ?>" alt="Bukti" class="w-100 rounded" /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
