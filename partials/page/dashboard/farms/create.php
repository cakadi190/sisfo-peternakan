<?php

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

// Get Category
$dbFarmCat = $db->getConnection()->prepare("SELECT * FROM farm_category");
$dbFarmCat->execute();
$farmCat = $dbFarmCat->get_result()->fetch_all(MYSQLI_ASSOC);

// Get All Stored Users
$usersList = $db->getConnection()->prepare("SELECT * FROM users");
$usersList->execute();
$users = $usersList->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?= url('/dashboard/farm') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/farm/store') ?>" method="POST">
          <div class="form-group mb-2">
            <label for="name">Nama Hewan</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Mis: Hardimulyo" />
          </div>
          <div class="form-group mb-2">
            <label for="farm_shed">Ditaruh Di Kandang</label>
            <input type="text" class="form-control" id="farm_shed" name="farm_shed" placeholder="Mis: Kandang paling bawah dekat pos jaga." />
          </div>
          <div class="form-group mb-2">
            <label for="entrance_date">Tanggal Masuk</label>
            <input type="datetime-local" step="1" value="<?= date('Y-m-d H:i:s') ?>" class="form-control" id="entrance_date" name="entrance_date" placeholder="Mis: Kandang paling bawah dekat pos jaga." />
          </div>

          <div class="form-group mb-2">
            <label for="gender">Kelamin</label>
            <select name="gender" id="gender" class="form-select">
              <option disabled="disabled" selected="selected">Pilih Salah Satu</option>
              <option value="jantan">Jantan</option>
              <option value="betina">Betina</option>
            </select>
          </div>

          <div class="form-group mb-2">
            <label for="category">Kategori</label>
            <select name="category" id="category" class="form-select">
              <option disabled="disabled" selected="selected">Pilih Salah Satu</option>
              <?php foreach ($farmCat as $c) : ?>
                <option value="<?= $c['id'] ?>"><?= $c['category_name'] ?> / <?= $c['race'] ?> / <?=ucwords($c['weight_class']) ?></option>
              <?php endforeach; ?>
            </select>

            <?php if (empty($farmCat)) : ?>
              <div class="form-text">Masih belum ada kategori. Tambahkan kategori <a href="<?= url("/dashboard/farm-category/create") ?>">disini</a>.</div>
            <?php endif ?>
          </div>

          <?php if (auth()->user()['role'] === 1) : ?>
            <div class="form-group mb-2">
              <label for="pic">Penanggungjawab</label>
              <select class="form-select" id="pic" name="pic" required>
                <option disabled selected>[Pilih Salah Satu]</option>
                <?php foreach ($users as $user) : ?>
                  <option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php else : ?>
            <input type="hidden" name="pic" value="<?= auth()->user()['id'] ?>" />
          <?php endif; ?>

          <div class="form-group mb-2">
            <label for="status">Status Hewan Ternak</label>
            <select name="status" id="status" class="form-select">
              <option selected disabled>[Pilih Salah Satu]</option>
              <option value="hidup">Hidup</option>
              <option value="mati">Mati</option>
              <option value="terjual">Terjual</option>
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
