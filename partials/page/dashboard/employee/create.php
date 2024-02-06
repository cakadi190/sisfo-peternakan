<?php

use function inc\helper\dd;
use function inc\helper\url;

include_once(__DIR__ . '/../../../../templates/panel/header.php');

// Get User Role From Database
$dbRoleInit = $db->getConnection()->prepare("SELECT * FROM roles");
$dbRoleInit->execute();
$roleLists = $dbRoleInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">

  <div class="row justify-content-center">
    <div class="col-md-3">
      <a href="<?=url('/dashboard/employee') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div class="col-lg-6">
      <?php include(__DIR__ . '../../../../alert.php'); ?>

      <div class="card card-body">
        <h3>Tambah Data Baru</h3>

        <form action="<?= url('/dashboard/employee/store') ?>" method="POST">
          <div class="form-group mb-2">
            <label for="full_name">Nama Lengkap</label>
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Mis: Hari Darmawan" />
          </div>
          <div class="form-group mb-2">
            <label for="phone">Nomor HP</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Mis: +6281234567890" />
          </div>
          <div class="form-group mb-2">
            <label for="address">Alamat</label>
            <textarea type="text" class="form-control" id="address" name="address" placeholder="Mis: Kepanjen, Malang"></textarea>
          </div>
          <hr />
          <div class="form-group mb-2">
            <label for="email">Surat Elektronik</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Mis: admin@bbib.kementan.go.id" />
          </div>
          <div class="form-group mb-2">
            <label for="password">Kata Sandi</label>
            <input type="password" id="password" value="password" disabled class="form-control" name="password" placeholder="Masukkan kata sandi anda" aria-describedby="password" />
            <div class="form-text">Kata sandi bawaannya adalah "password".</div>
          </div>
          <div class="form-group mb-3">
            <label for="role">Peran</label>
            <select name="role" id="role" class="form-control">
              <option disabled selected>[Pilih Salah Satu]</option>
              <?php if (isset($roleLists)) : foreach ($roleLists as $role) : ?>
                <option value="<?=$role['id'] ?>"><?=$role['name'] ?></option>
                <?php endforeach;
              else : ?>
                <option value="2">Karyawan</option>
                <option value="1">Administrator</option>
              <?php endif; ?>
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
