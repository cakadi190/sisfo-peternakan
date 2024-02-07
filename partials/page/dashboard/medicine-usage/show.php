<?php

use function inc\helper\asset;
use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$user = $auth->user();

// Get All Stored Users
$medicationRetrieval = $db->getConnection()->prepare("
SELECT
    mr.*,
    us.full_name,
    us.id as user_id,
    am.id as medicine_id,
    am.medication_name
FROM medication_retrieval mr
JOIN animal_medicine am ON mr.med_id = am.id
JOIN users us ON mr.taken_by = us.id
WHERE mr.id = ?
");
$medicationRetrieval->bind_param('s', $_GET['id']);
$medicationRetrieval->execute();
$medicationRetrievalResult = $medicationRetrieval->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0">Detail Pengambilan Obat</h1>

    <div class="btn-group-sm btn-group">
      <a href="<?= url("/dashboard/medicine-usage") ?>" class="btn btn-primary"><i class="bx bx-chevron-left"></i></a>
      <a href="<?= url("/dashboard/medicine-usage/{$medicationRetrievalResult['id']}/edit") ?>" class="btn btn-success"><i class="bx bx-pencil"></i></a>
      <a href="<?= url("/dashboard/medicine-usage/{$medicationRetrievalResult['id']}/delete") ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')" class="btn btn-danger"><i class="bx bx-trash"></i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card card-body table-responsive">
        <table class="tables table table-striped border" style="border-radius: .5rem">
          <tbody>
            <tr>
              <th>Data Masuk Pada</th>
              <td><?= (new DateTime($medicationRetrievalResult['created_at']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Data Diperbaharui Pada</th>
              <td><?= (new DateTime($medicationRetrievalResult['updated_at']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Nama Obat</th>
              <td>
                <a href="<?= url("/dashboard/medicine/{$medicationRetrievalResult['medicine_id']}/show") ?>"><?= $medicationRetrievalResult['medication_name'] ?></a>
              </td>
            </tr>
            <tr>
              <th>Petugas</th>
              <td>
                <a href="<?= url("/dashboard/employee/{$medicationRetrievalResult['user_id']}/show") ?>"><?= $medicationRetrievalResult['full_name'] ?></a>
              </td>
            </tr>
            <tr>
              <th>Diambil Pada</th>
              <td><?= (new DateTime($medicationRetrievalResult['retrieval_date']))->format('l, j F Y'); ?></td>
            </tr>
            <tr>
              <th>Jumlah Pengambilan</th>
              <td><?= $medicationRetrievalResult['quantity_taken'] ?> Obat</td>
            </tr>
            <tr>
              <th>Bukti</th>
              <td><img src="<?= url("/uploads/{$medicationRetrievalResult['evidence']}") ?>" alt="Bukti" class="w-100 rounded" /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
