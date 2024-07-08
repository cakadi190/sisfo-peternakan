<?php

use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

// Get All Stored Users
$usersList = $db->getConnection()->prepare("SELECT * FROM users");
$usersList->execute();
$users = $usersList->get_result()->fetch_all(MYSQLI_ASSOC);

// Get All Medicines
$medList = $db->getConnection()->prepare("SELECT * FROM animal_medicines");
$medList->execute();
$medicines = $medList->get_result()->fetch_all(MYSQLI_ASSOC);

$medicineRetrieval = $db->getConnection()->prepare("SELECT * FROM medication_retrieval WHERE id = ?");
$medicineRetrieval->bind_param('s', $_GET['id']);
$medicineRetrieval->execute();
$medicineRetrievalResult = $medicineRetrieval->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?= url('/dashboard/medicine-usage') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Ubah Data</h3>

        <form enctype="multipart/form-data" action="<?= url("/dashboard/medicine-usage/{$medicineRetrievalResult['id']}/update") ?>" method="POST">
          <div class="form-group mb-3">
            <label for="retrieval_date">Tanggal Pengambilan</label>
            <input type="date" class="form-control" value="<?= $medicineRetrievalResult['retrieval_date'] ?>" id="retrieval_date" name="retrieval_date" required>
          </div>

          <div class="form-group mb-3">
            <label for="taken_by">Diambil Oleh</label>
            <select class="form-select" id="taken_by" name="taken_by" required>
              <option disabled selected>[Pilih Salah Satu]</option>
              <?php foreach ($users as $user) : ?>
                <option <?= $medicineRetrievalResult['taken_by'] !== $user['id'] ?: 'selected' ?> value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="med_id">Nama Obat</label>
            <select class="form-select" id="med_id" name="med_id" required>
              <option disabled selected>[Pilih Salah Satu]</option>
              <?php foreach ($medicines as $med) : ?>
                <option <?= $medicineRetrievalResult['med_id'] !== $med['id'] ?: 'selected' ?> value="<?= $med['id'] ?>"><?= $med['medication_name'] ?></option>
              <?php endforeach; ?>
            </select>

            <?php if (empty($medicines)) : ?>
              <div class="form-text">Masih belum ada data obatnya. Tambahkan data obat <a href="<?= url("/dashboard/medicine/create") ?>">disini</a>.</div>
            <?php endif ?>
          </div>

          <div class="form-group mb-3">
            <label for="quantity_taken">Jumlah Yang Diambil</label>
            <input type="number" class="form-control" value="<?= $medicineRetrievalResult['quantity_taken'] ?>" placeholder="Masukkan jumlah yang akan diambil" id="quantity_taken" name="quantity_taken" required>
          </div>

          <div class="card card-body mb-3">
            <div>
              <img src="<?= url("/uploads/{$medicineRetrievalResult['evidence']}") ?>" alt="Bukti" class="rounded mb-3" height="160px" width="auto" />
            </div>

            <div class="form-group">
              <label for="evidence">Bukti Dokumentasi (opsional)</label>
              <input type="file" class="form-control" id="evidence" name="evidence" />
              <div class="form-text">Unggah berkas apabila akan menggantinya.</div>
            </div>
          </div>

          <button class="btn btn-primary" type="submit">Ubah Data</button>
        </form>

      </div>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>