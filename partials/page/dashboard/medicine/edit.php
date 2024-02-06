<?php

use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

// Get User Data
$medicineData = $db->getConnection()->prepare("SELECT * FROM animal_medicine WHERE id = ?");
$medicineData->bind_param('s', $_GET['id']);
$medicineData->execute();
$medicineDataResult = $medicineData->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Ubah Data</h3>

        <form action="<?= url("/dashboard/medicine/{$medicineDataResult['id']}/update") ?>" method="POST">
          <div class="form-group mb-2">
            <label for="medication_name">Nama Obat</label>
            <input type="text" class="form-control" value="<?=$medicineDataResult['medication_name'] ?>" id="medication_name" name="medication_name" placeholder="Mis: Analgesik Generik" />
          </div>

          <div class="form-group mb-2">
            <label for="medication_type">Jenis Obat Hewan Ternak</label>
            <select name="medication_type" id="medication_type" class="form-control">
              <option disabled selected>[Pilih Salah Satu]</option>
              <option <?= $medicineDataResult['medication_type'] === 'antibiotik' ? 'selected' : '' ?> value="antibiotik">Antibiotik</option>
              <option <?= $medicineDataResult['medication_type'] === 'antiparasit' ? 'selected' : '' ?> value="antiparasit">Antiparasit</option>
              <option <?= $medicineDataResult['medication_type'] === 'vitamin' ? 'selected' : '' ?> value="vitamin">Vitamin</option>
              <option <?= $medicineDataResult['medication_type'] === 'vaksin' ? 'selected' : '' ?> value="vaksin">Vaksin</option>
              <option <?= $medicineDataResult['medication_type'] === 'pemutih' ? 'selected' : '' ?> value="pemutih">Pemutih</option>
              <option <?= $medicineDataResult['medication_type'] === 'pakan' ? 'selected' : '' ?> value="pakan">Pakan</option>
              <option <?= $medicineDataResult['medication_type'] === 'antiinflamasi' ? 'selected' : '' ?> value="antiinflamasi">Antiinflamasi</option>
              <option <?= $medicineDataResult['medication_type'] === 'mineral' ? 'selected' : '' ?> value="mineral">Mineral</option>
              <option <?= $medicineDataResult['medication_type'] === 'obat_kondisioner' ? 'selected' : '' ?> value="obat_kondisioner">Obat Kondisioner</option>
              <option <?= $medicineDataResult['medication_type'] === 'obat_kesuburan' ? 'selected' : '' ?> value="obat_kesuburan">Obat Kesuburan</option>
              <option <?= $medicineDataResult['medication_type'] === 'antibakteri' ? 'selected' : '' ?> value="antibakteri">Antibakteri</option>
              <option <?= $medicineDataResult['medication_type'] === 'anestesi' ? 'selected' : '' ?> value="anestesi">Anestesi</option>
              <option <?= $medicineDataResult['medication_type'] === 'probiotik' ? 'selected' : '' ?> value="probiotik">Probiotik</option>
              <option <?= $medicineDataResult['medication_type'] === 'antijamur' ? 'selected' : '' ?> value="antijamur">Antijamur</option>
              <option <?= $medicineDataResult['medication_type'] === 'suplemen' ? 'selected' : '' ?> value="suplemen">Suplemen</option>
              <option <?= $medicineDataResult['medication_type'] === 'analgesik' ? 'selected' : '' ?> value="analgesik">Analgesik</option>
              <option <?= $medicineDataResult['medication_type'] === 'antivirus' ? 'selected' : '' ?> value="antivirus">Antivirus</option>
              <option <?= $medicineDataResult['medication_type'] === 'ekspektoran' ? 'selected' : '' ?> value="ekspektoran">Ekspektoran</option>
              <option <?= $medicineDataResult['medication_type'] === 'other' ? 'selected' : '' ?> value="other">Lainnya</option>
            </select>
          </div>

          <div class="form-group mb-2">
            <label for="dosage">Dosis</label>
            <input type="text" class="form-control" id="dosage" value="<?=$medicineDataResult['dosage'] ?>" name="dosage" placeholder="Mis: 10 mL" />
          </div>

          <div class="form-group mb-2">
            <label for="usage">Metode Penggunaan</label>
            <input type="text" class="form-control" id="usage" value="<?=$medicineDataResult['usage'] ?>" name="usage" placeholder="Mis: Penggunaan Oral" />
          </div>

          <div class="form-group mb-2">
            <label for="batch_number">Nomor Batch</label>
            <input type="text" class="form-control" value="<?=$medicineDataResult['batch_number'] ?>" id="batch_number" name="batch_number" placeholder="Mis: ABC123" />
          </div>

          <div class="form-group mb-2">
            <label for="buy_date">Tanggal Beli</label>
            <input type="date" class="form-control" value="<?=$medicineDataResult['buy_date'] ?>" id="buy_date" name="buy_date" />
          </div>

          <div class="form-group mb-2">
            <label for="expiration_date">Tanggal Kedaluwarsa</label>
            <input type="date" value="<?=$medicineDataResult['expiration_date'] ?>" class="form-control" id="expiration_date" name="expiration_date" />
          </div>

          <div class="form-group mb-2">
            <label for="vendor">Vendor</label>
            <input type="text" class="form-control" value="<?=$medicineDataResult['vendor'] ?>" id="vendor" name="vendor" placeholder="Mis: ABC Pharmaceuticals" />
          </div>

          <div class="form-group mb-2">
            <label for="contradictions">Kontraindikasi dan Efek Samping</label>
            <textarea class="form-control" id="contradictions" name="contradictions" rows="3"><?=$medicineDataResult['contradictions'] ?></textarea>
          </div>

          <div class="form-group mb-2">
            <label for="stock">Stok</label>
            <input type="number" class="form-control" id="stock" value="<?=$medicineDataResult['stock'] ?>" name="stock" placeholder="Mis: 100" />
          </div>

          <button class="btn btn-primary" type="submit">Ubah Data</button>
        </form>
      </div>
    </div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>