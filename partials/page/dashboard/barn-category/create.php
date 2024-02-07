<?php

use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?=url('/dashboard/barn-category') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/barn-category/store') ?>" method="POST">
          <div class="form-group mb-2">
            <label for="barn_name">Nama Komoditas</label>
            <input type="text" class="form-control" id="barn_name" name="barn_name" placeholder="Mis: Padi Varietas A" />
          </div>
          <div class="form-group mb-2">
            <label for="description">Deskripsi (opsional)</label>
            <textarea class="form-control" id="description" name="description" placeholder="Mis: Data komoditas padi varietas unggul"></textarea>
          </div>
          <div class="form-group mb-2">
            <label for="stock">Stok</label>
            <input type="number" class="form-control" placeholder="Masukkan stok" id="stock" name="stock" />
          </div>
          
          <div class="form-group mb-2">
            <label for="vendor">Pemasok Lokal / Luar?</label>
            <select name="vendor" id="vendor" class="form-select">
              <option disabled="disabled" selected="selected">[Pilih Salah Satu]</option>
              <option value="local">Lokal</option>
              <option value="outside">Luar</option>
            </select>
          </div>

          <div class="form-group mb-2" id="vendor_name_input" style="display: none">
            <label for="vendor_name">Nama Pemasok</label>
            <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Mis: PT BULOG Tbk. (Persero)" />
          </div>

          <button class="btn btn-primary" type="submit">Tambahkan</button>
        </form>
      </div>
    </div>
    <div class="col-md-3">&nbsp;</div>
  </div>

  <script>
    document.getElementById('vendor').addEventListener('change', (e) => {
      if(e.target.value === 'outside') {
        document.getElementById('vendor_name_input')?.setAttribute('style', 'display: block');
      } else {
        document.getElementById('vendor_name_input')?.setAttribute('style', 'display: none');
      }
    });
  </script>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
