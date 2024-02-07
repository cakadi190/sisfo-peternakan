<?php

use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?=url('/dashboard/medicine') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/medicine/store') ?>" method="POST">
          <div class="form-group mb-2">
            <label for="medication_name">Nama Obat</label>
            <input type="text" class="form-control" id="medication_name" name="medication_name" placeholder="Mis: Analgesik Generik" />
          </div>

          <div class="form-group mb-2">
            <label for="medication_type">Jenis Obat Hewan Ternak</label>
            <select name="medication_type" id="medication_type" class="form-control">
              <option disabled selected>[Pilih Salah Satu]</option>
              <option value="antibiotik">Antibiotik</option>
              <option value="antiparasit">Antiparasit</option>
              <option value="vitamin">Vitamin</option>
              <option value="vaksin">Vaksin</option>
              <option value="pemutih">Pemutih</option>
              <option value="pakan">Pakan</option>
              <option value="antiinflamasi">Antiinflamasi</option>
              <option value="mineral">Mineral</option>
              <option value="obat_kondisioner">Obat Kondisioner</option>
              <option value="obat_kesuburan">Obat Kesuburan</option>
              <option value="antibakteri">Antibakteri</option>
              <option value="anestesi">Anestesi</option>
              <option value="probiotik">Probiotik</option>
              <option value="antijamur">Antijamur</option>
              <option value="suplemen">Suplemen</option>
              <option value="analgesik">Analgesik</option>
              <option value="antivirus">Antivirus</option>
              <option value="ekspektoran">Ekspektoran</option>
              <option value="other">Lainnya</option>
            </select>
          </div>

          <div class="form-group mb-2">
            <label for="dosage">Dosis</label>
            <input type="text" class="form-control" id="dosage" name="dosage" placeholder="Mis: 10 mL" />
          </div>

          <div class="form-group mb-2">
            <label for="usage">Metode Penggunaan</label>
            <input type="text" class="form-control" id="usage" name="usage" placeholder="Mis: Penggunaan Oral" />
          </div>

          <div class="form-group mb-2">
            <label for="batch_number">Nomor Batch</label>
            <input type="text" class="form-control" id="batch_number" name="batch_number" placeholder="Mis: ABC123" />
          </div>

          <div class="form-group mb-2">
            <label for="buy_date">Tanggal Beli</label>
            <input type="date" class="form-control" id="buy_date" name="buy_date" />
          </div>

          <div class="form-group mb-2">
            <label for="expiration_date">Tanggal Kedaluwarsa</label>
            <input type="date" class="form-control" id="expiration_date" name="expiration_date" />
          </div>

          <div class="form-group mb-2">
            <label for="vendor">Vendor</label>
            <input type="text" class="form-control" id="vendor" name="vendor" placeholder="Mis: ABC Pharmaceuticals" />
          </div>

          <div class="form-group mb-2">
            <label for="contradictions">Kontraindikasi dan Efek Samping (opsional)</label>
            <textarea class="form-control" id="contradictions" name="contradictions" rows="3"></textarea>
          </div>

          <div class="form-group mb-2">
            <label for="stock">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" placeholder="Mis: 100" />
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