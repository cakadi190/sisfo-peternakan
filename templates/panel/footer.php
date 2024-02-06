<?php

use function inc\helper\asset;
use function inc\helper\url;

?>

<!-- / Content -->

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      © <script>
        document.write(new Date().getFullYear())
      </script>
      <a href="<?= url('/') ?>">BBIB Singosari</a>
    </div>
  </div>
</footer>
<!-- / Footer -->


<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>


<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>


</div>
<!-- / Layout wrapper -->

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
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

<!-- Main JS -->
<script src="<?= asset('js/main.js') ?>"></script>

<!-- Page JS -->
</body>

</html>

<!-- beautify ignore:end -->