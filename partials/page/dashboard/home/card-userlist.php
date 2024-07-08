<?php

use function inc\helper\isLightColor;
use function inc\helper\url;

$user = $auth->user();

// Get All Stored Users
$userLists = $db->getConnection()->prepare("SELECT users.*, roles.color, roles.name as role_name FROM users JOIN roles ON users.role = roles.id ORDER BY users.created_at DESC LIMIT 10");
$userLists->execute();
$usersLists = $userLists->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="card card-body table-responsive">
  <div class="d-flex justify-content-between mb-3">
    <h3 class="mb-0">Pengguna</h3>
    <a href="<?= url('/dashboard/employee') ?>" class="btn btn-primary">Lihat Semua</a>
  </div>

  <div class="table-responsive rounded-3 border">
    <table class="tables table table-striped" style="border-radius: .5rem">
      <thead>
        <tr>
          <th style="width: auto">Nama Lengkap</th>
          <th style="width: 30%">Alamat</th>
          <th style="width: auto">Nomor HP</th>
          <th style="width: auto">Surat Elektronik</th>
          <th style="width: auto">Peran</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usersLists)) : foreach ($usersLists as $user) : ?>
            <tr>
              <td><?= $user['full_name'] ?></td>
              <td><?= $user['address'] ?></td>
              <td><?= $user['phone'] ?></td>
              <td><?= $user['email'] ?></td>
              <td>
                <span class="badge" style="background: <?= $user['color'] ?>;color: <?= isLightColor($user['color']) ?>;"><?= $user['role_name'] ?></span>
              </td>
            </tr>
          <?php endforeach;
        else : ?>
          <tr>
            <td colspan="6">Tidak Ada Data Sama Sekali</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>