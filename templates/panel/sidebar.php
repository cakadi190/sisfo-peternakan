<?php

use function inc\helper\auth;
use function inc\helper\url;

$currentUrl = url(str_replace('/crud', '/', $_SERVER['REQUEST_URI']));
$currentUserRoles = auth()->user()['role'];

$menuItems = [
  [
    'url' => url('/dashboard'),
    'icon' => 'bx bx-home',
    'text' => 'Dashboard',
  ],
  [
    'header' => true,
    'text' => 'Data Peternakan',
  ],
  [
    'toggle' => true,
    'url' => url('/dashboard/medicine'),
    'icon' => 'fa-solid fa-tablets',
    'text' => 'Data Obat',
    'subMenu' => [
      [
        'url' => url('/dashboard/medicine'),
        'text' => 'Persediaan Obat',
      ],
      [
        'url' => url('/dashboard/medicine-usage'),
        'text' => 'Ambil Obat',
      ],
    ],
  ],
  [
    'toggle' => true,
    'url' => url('/dashboard/farm'),
    'icon' => 'fa-solid fa-cow',
    'text' => 'Data Ternak',
    'subMenu' => [
      [
        'url' => url('/dashboard/farm-category'),
        'text' => 'Kategori Ternak',
      ],
      [
        'url' => url('/dashboard/farm'),
        'text' => 'Semua Data Ternak',
      ],
      [
        'url' => url('/dashboard/farm/create'),
        'text' => 'Tambah Ternak baru',
      ],
    ],
  ],
  [
    'toggle' => true,
    'url' => url('/dashboard/barn'),
    'icon' => 'fa-solid fa-wheat-awn',
    'text' => 'Data Pakan Ternak',
    'subMenu' => [
      [
        'url' => url('/dashboard/barn-category'),
        'text' => 'Kategori Pakan Ternak',
      ],
      [
        'url' => url('/dashboard/barn'),
        'text' => 'Semua Data',
      ],
      [
        'url' => url('/dashboard/barn'),
        'text' => 'Tambah Pakan',
      ],
      [
        'url' => url('/dashboard/barn'),
        'text' => 'Ambil Pakan',
      ],
    ],
  ],
  [
    'header' => true,
    'text' => 'Pengguna',
    'only' => [1],
  ],
  [
    'toggle' => true,
    'icon' => 'fas fa-dice-d20',
    'text' => 'Peran',
    'url' => url('/dashboard/role'),
    'only' => [1],
    'subMenu' => [
      [
        'url' => url('/dashboard/role'),
        'text' => 'Semua Data',
        'only' => [1],
      ],
      [
        'url' => url('/dashboard/role/create'),
        'text' => 'Tambah Baru',
        'only' => [1],
      ],
    ],
  ],
  [
    'toggle' => true,
    'icon' => 'fas fa-user',
    'text' => 'Karyawan',
    'url' => url('/dashboard/employee'),
    'only' => [1],
    'subMenu' => [
      [
        'url' => url('/dashboard/employee'),
        'text' => 'Semua Data',
        'only' => [1],
      ],
      [
        'url' => url('/dashboard/employee/create'),
        'text' => 'Tambah Baru',
        'only' => [1],
      ],
    ],
  ],
];

?>
<ul class="menu-inner py-1">
  <?php foreach ($menuItems as $item) : ?>
    <?php if (isset($item['header'])) : ?>
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text"><?= $item['text'] ?></span>
      </li>
    <?php elseif (isset($item['toggle'])) : ?>
      <?php
      $allowedRoles = $item['only'] ?? null;
      if ($allowedRoles === null || in_array($currentUserRoles, $allowedRoles)) :
      ?>
        <li class="menu-item <?= isset($item['url']) && strpos($currentUrl, $item['url']) !== false ? 'active open' : '' ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon <?= $item['icon'] ?>"></i>
            <div data-i18n="<?= $item['text'] ?>"><?= $item['text'] ?></div>
          </a>
          <?php if (isset($item['subMenu'])) : ?>
            <ul class="menu-sub">
              <?php foreach ($item['subMenu'] as $subItem) : ?>
                <?php
                $allowedSubRoles = $subItem['only'] ?? null;
                if ($allowedSubRoles === null || in_array($currentUserRoles, $allowedRoles)) :
                ?>
                  <li class="menu-item <?= isset($subItem['url']) && $currentUrl === $subItem['url'] ? 'active' : '' ?>">
                    <a href="<?= $subItem['url'] ?>" class="menu-link">
                      <div data-i18n="<?= $subItem['text'] ?>"><?= $subItem['text'] ?></div>
                    </a>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endif; ?>
    <?php else : ?>
      <?php
      // Check if the "only" key is set and if the current user has any of the specified roles
      $allowedRoles = $item['only'] ?? null;
      if ($allowedRoles === null || in_array($currentUserRoles, $allowedRoles)) :
      ?>
        <li class="menu-item <?= isset($item['url']) && strpos($currentUrl, $item['url']) !== false ? 'active open' : '' ?>">
          <a href="<?= $item['url'] ?>" class="menu-link">
            <i class="menu-icon <?= $item['icon'] ?>"></i>
            <div data-i18n="<?= $item['text'] ?>"><?= $item['text'] ?></div>
          </a>
        </li>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; ?>
</ul>