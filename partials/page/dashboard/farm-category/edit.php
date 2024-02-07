<?php

use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$farmCategory = $db->getConnection()->prepare("SELECT * FROM `farm_category` WHERE id = ?");
$farmCategory->bind_param('s', $_GET['id']);
$farmCategory->execute();
$farmCategoryResult = $farmCategory->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?= url('/dashboard/farm-category') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Ubah Data</h3>

        <form action="<?= url("/dashboard/farm-category/{$farmCategoryResult['id']}/update") ?>" method="POST">
          <div class="form-group mb-2">
            <label for="category_name">Nama Kategori</label>
            <input type="text" class="form-control" value="<?=$farmCategoryResult['category_name'] ?>" id="category_name" name="category_name" placeholder="Mis: Sapi Brahmana" />
          </div>

          <div class="form-group mb-2">
            <label for="race">Ras</label>
            <input type="text" class="form-control" value="<?=$farmCategoryResult['race'] ?>" id="race" name="race" placeholder="Mis: Brahmana" />
          </div>

          <div class="form-group mb-3">
            <label for="color">Warna</label>
            <input type="color" value="<?= $farmCategoryResult['color']; ?>" class="form-control" id="color" placeholder="Mis: #fff" name="color" />
            <div class="form-text">Warna ini sebagai pembeda antara kategori satu dengan yang lain.</div>
          </div>

          <div class="form-group mb-2">
            <label for="weight_class">Kelas Berat</label>
            <select name="weight_class" id="weight_class" class="form-select">
              <option selected disabled>[Pilih Kelas Berat]</option>
              <option <?=$farmCategoryResult['weight_class'] === 'ringan' ? 'selected' : '' ?> value="ringan">Ringan</option>
              <option <?=$farmCategoryResult['weight_class'] === 'sedang' ? 'selected' : '' ?> value="sedang">Sedang</option>
              <option <?=$farmCategoryResult['weight_class'] === 'berat' ? 'selected' : '' ?> value="berat">Berat</option>
            </select>
          </div>

          <button class="btn btn-primary" type="submit">Update</button>
        </form>
      </div>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
