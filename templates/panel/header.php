<?php

use function inc\helper\asset;
use function inc\helper\auth;
use function inc\helper\redirect;
use function inc\helper\url;

require_once __DIR__ . '/../../inc/loader.php';

// The middleware
if (!auth()->check()) redirect('/');

$user = $auth->user();
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>BBIB Singosari</title>

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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Page -->
  <link rel="stylesheet" href="<?= asset('vendor/css/pages/page-auth.css') ?>">

  <!-- Helpers -->
  <script src="<?= asset('vendor/js/helpers.js') ?>"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="<?= asset('js/config.js') ?>"></script>

</head>

<body>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">

      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

        <div class="app-brand demo ">
          <a href="<?= url('/') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">

              <img src="<?= asset('images/logo.webp') ?>" height="56px" />

            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="text-transform: unset;">BBIB</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <?php include_once(__DIR__ . '/sidebar.php'); ?>

      </aside>
      <!-- / Menu -->
      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
              </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="<?= asset('img/avatars/1.png') ?>" alt class="w-px-40 h-auto rounded-circle">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="<?= asset('img/avatars/1.png') ?>" alt class="w-px-40 h-auto rounded-circle">
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-medium d-block"><?= $user['full_name'] ?></span>
                          <small class="text-muted"><?= $user['role'] === 'admin' ? 'Administrator' : 'Karyawan'; ?></small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="<?= url('/auth/logout') ?>" onclick="return confirm('Apakah Anda yakin ingin keluar dan mengakhiri sesi ini?')">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Keluar</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>

        </nav>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->