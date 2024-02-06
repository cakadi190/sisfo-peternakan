<?php

include_once(__DIR__ . '/templates/panel/header.php'); ?>
<div class="container-fluid flex-grow-1 container-p-y">
  <div class="d-flex mb-3 align-items-center justify-content-between">
    <h1 class="mb-0 h3">Beranda</h1>
  </div>

  <?php include(__DIR__ . '/partials/alert.php') ?>

  <!-- Card Summary -->
  <div class="row mb-3">
    <?php if ($auth->user()['role'] === 1) : ?>
      <div class="col-md-3">
        <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-summary-user.php'); ?>
      </div>
    <?php endif; ?>
    <div class="col-md-<?= $auth->user()['role'] !== 1 ? '4' : '3' ?>">
      <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-summary-medicine.php'); ?>
    </div>
    <div class="col-md-<?= $auth->user()['role'] !== 1 ? '4' : '3' ?>">
      <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-summary-farm.php'); ?>
    </div>
    <div class="col-md-<?= $auth->user()['role'] !== 1 ? '4' : '3' ?>">
      <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-summary-barn.php'); ?>
    </div>
  </div>

  <!-- Second Row -->
  <div class="row mt-5">
    <div class="col-md-12">
      <h5>Data Terkini</h5>
    </div>

    <div class="col-md-6 mb-3">
      <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-barn.php'); ?>
    </div>
    <div class="col-md-6 mb-3">
      <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-farm.php'); ?>
    </div>

    <!-- User List -->
    <?php if ($auth->user()['role'] === 1) : ?>
      <div class="col-md-12 mb-3">
        <?php include_once(__DIR__ . '/partials/page/dashboard/home/card-userlist.php'); ?>
      </div>
    <?php endif; ?>
  </div>

</div>
<?php include_once(__DIR__ . '/templates/panel/footer.php');
