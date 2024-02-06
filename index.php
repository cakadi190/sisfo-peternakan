<?php

use function inc\helper\asset;
use function inc\helper\auth;
use function inc\helper\redirect;
use function inc\helper\url;

require_once __DIR__ . '/inc/loader.php';

// The middleware
if (auth()->check()) redirect('/dashboard');

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Autentikasi</title>

  <meta name="description" content="Masuk ke dalam sistem Balai Besar Inseminasi Buatan - Singosari Malang" />
  <meta name="keywords" content="bbib,sisfo,bbib malang">
  <!-- Canonical SEO -->
  <link rel="canonical" href="<?= url('/') ?>">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/favicon/apple-touch-icon.png') ?>" />
  <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon/favicon-32x32.png') ?>" />
  <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/favicon/favicon-16x16.png') ?>" />
  <link rel="manifest" href="<?= asset('images/favicon/site.webmanifest') ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="<?= asset('vendor/fonts/boxicons.css') ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= asset('vendor/css/core.css') ?>" class="template-customizer-core-css" />
  <link rel="stylesheet" href="<?= asset('vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="<?= asset('css/demo.css') ?>" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="<?= asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="<?= asset('vendor/css/pages/page-auth.css') ?>">

  <!-- Helpers -->
  <script src="<?= asset('vendor/js/helpers.js') ?>"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?= asset('js/config.js') ?>"></script>

</head>

<body>
  <!-- Content -->
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="<?= url('/') ?>" class="app-brand-link gap-2">
                <img src="<?= asset('images/logo.webp') ?>" height="96px" />
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="text-center mb-2">Portal BBIB Singosari</h4>
            <p class="text-center mb-4">Silahkan masuk untuk melanjutkan pengelolaan data</p>

            <?php require_once(__DIR__ . '/partials/alert.php') ?>

            <form id="formAuthentication" class="mb-3" method="POST" action="<?= url('/auth.php') ?>">
              <div class="mb-3">
                <label for="email" class="form-label">Surat Elektronik</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="mis: admin@bbib.kementan.go.id" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Kata Sandi</label>
                  <a href="<?= url('/forgot-password') ?>">
                    <small>Lupa Sandi?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan kata sandi anda" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                  <label class="form-check-label" for="remember-me">
                    Ingatkan Saya
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->

  <script src="<?= asset('vendor/libs/jquery/jquery.js') ?>"></script>
  <script src="<?= asset('vendor/libs/popper/popper.js') ?>"></script>
  <script src="<?= asset('vendor/js/bootstrap.js') ?>"></script>
  <script src="<?= asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
  <script src="<?= asset('vendor/js/menu.js') ?>"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="<?= asset('js/main.js') ?>"></script>

  <!-- Page JS -->
</body>

</html>

<!-- beautify ignore:end -->