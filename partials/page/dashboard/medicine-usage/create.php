<?php

use function inc\helper\auth;
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
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?= url('/dashboard/medicine-usage') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form enctype="multipart/form-data" action="<?= url('/dashboard/medicine-usage/store') ?>" method="POST">
          <div class="form-group mb-3">
            <label for="retrieval_date">Tanggal Pengambilan</label>
            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="retrieval_date" name="retrieval_date" required>
          </div>

          <?php if (auth()->user()['role'] === 1) : ?>
            <div class="form-group mb-3">
              <label for="taken_by">Diambil Oleh</label>
              <select class="form-select" id="taken_by" name="taken_by" required>
                <option disabled selected>[Pilih Salah Satu]</option>
                <?php foreach ($users as $user) : ?>
                  <option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php else : ?>
            <input type="hidden" name="taken_by" value="<?= auth()->user()['id'] ?>" />
          <?php endif; ?>

          <div class="form-group mb-3">
            <label for="med_id">Nama Obat</label>
            <select class="form-select" id="med_id" name="med_id" required>
              <option disabled selected>[Pilih Salah Satu]</option>
              <?php foreach ($medicines as $med) : ?>
                <option value="<?= $med['id'] ?>"><?= $med['medication_name'] ?></option>
              <?php endforeach; ?>
            </select>

            <?php if (empty($medicines)) : ?>
              <div class="form-text">Masih belum ada data obatnya. Tambahkan data obat <a href="<?= url("/dashboard/medicine/create") ?>">disini</a>.</div>
            <?php endif ?>
          </div>

          <div class="form-group mb-3">
            <label for="quantity_taken">Jumlah Yang Diambil</label>
            <input type="number" class="form-control" placeholder="Masukkan jumlah yang akan diambil" id="quantity_taken" name="quantity_taken" required>
          </div>

          <div class="form-group mb-3">
            <label for="evidence">Bukti Dokumentasi</label>
            <input type="file" class="form-control" id="evidence" name="evidence" />
          </div>

          <button class="btn btn-primary" type="submit">Tambahkan</button>
        </form>

      </div>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>