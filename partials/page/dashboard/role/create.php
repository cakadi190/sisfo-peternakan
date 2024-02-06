<?php

use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/role/store') ?>" method="POST">
          <div class="form-group mb-3">
            <label for="name">Nama Peran</label>
            <input type="text" class="form-control" id="name" placeholder="Mis: Administrator" name="name" />
          </div>
        
          <button class="btn btn-primary" type="submit">Tambahkan</button>
        </form>
      </div>
    </div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>