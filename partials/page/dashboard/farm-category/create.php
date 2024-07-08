<?php

use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?=url('/dashboard/farm-category') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/farm-category/store') ?>" method="POST">
          <div class="form-group mb-2">
            <label for="category_name">Nama Kategori</label>
            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Mis: Sapi Brahmana" />
          </div>

          <div class="form-group mb-2">
            <label for="race">Ras</label>
            <input type="text" class="form-control" id="race" name="race" placeholder="Mis: Brahmana" />
          </div>

          <div class="form-group mb-2">
            <label for="weight_class">Kelas Berat</label>
            <select name="weight_class" id="weight_class" class="form-select">
              <option selected disabled>[Pilih Kelas Berat]</option>
              <option value="ringan">Ringan</option>
              <option value="sedang">Sedang</option>
              <option value="berat">Berat</option>
            </select>
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
