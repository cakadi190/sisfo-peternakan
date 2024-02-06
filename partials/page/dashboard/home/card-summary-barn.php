<?php

$medicineData = $db->getConnection()->prepare("SELECT COUNT(`id`) as count FROM `users`");
$medicineData->execute();
$medicineItems = $medicineData->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="card-body card">
  <div class="d-flex align-items-center">
    <div class="bg-success rounded-3 d-flex text-white justify-content-center align-items-center" style="width: 84px;height: 84px">
      <i class="fas fa-wheat-awn fa-2x"></i>
    </div>
    <div class="ps-3">
      <h3 class="mb-1"><?= $medicineItems[0]['count'] ?? 0 ?></h3>
      <p class="mb-0">Stok Pakan Ternak</p>
    </div>
  </div>
</div>
