<?php

use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

$roleData = $db->getConnection()->prepare("SELECT * FROM roles WHERE id = ?");
$roleData->bind_param('s', $_GET['id']);
$roleData->execute();
$roleDataResult = $roleData->get_result()->fetch_assoc();
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Ubah Data</h3>

        <form action="<?= url("/dashboard/role/{$roleDataResult['id']}/update") ?>" method="POST">
          <div class="form-group mb-3">
            <label for="name">Nama Peran</label>
            <input type="text" class="form-control" value="<?=$roleDataResult['name']; ?>" id="name" placeholder="Mis: Administrator" name="name" />
          </div>

          <div class="form-group mb-3">
            <label for="color">Warna</label>
            <input type="color" value="<?=$roleDataResult['color']; ?>" class="form-control" id="color" placeholder="Mis: #fff" name="color" />
            <div class="form-text">Warna ini sebagai pembeda antara role satu dengan yang lain.</div>
          </div>
        
          <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>

</div>
<?php
include_once(__DIR__ . '/../../../../templates/panel/footer.php');
?>