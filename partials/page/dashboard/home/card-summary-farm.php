<?php

$dbInit = $db->getConnection()->prepare("SELECT COUNT(`id`) as count FROM `farms`");
$dbInit->execute();
$farmsData = $dbInit->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="card-body card">
  <div class="d-flex align-items-center">
    <div class="bg-info rounded-3 d-flex text-white justify-content-center align-items-center" style="width: 84px;height: 84px">
      <i class="fas fa-cow fa-2x"></i>
    </div>
    <div class="ps-3">
      <h3 class="mb-1"><?= $farmsData[0]['count'] ?? 0 ?></h3>
      <p class="mb-0">Hewan Ternak</p>
    </div>
  </div>
</div>
