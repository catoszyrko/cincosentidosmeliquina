<?php
declare(strict_types=1);
$co = company();
$current = $adminPage ?? '';
?>
<aside class="admin-sidebar">
  <a class="admin-brand" href="<?= e(url('admin')) ?>">
    <img src="<?= e(asset($co['logo_light'] ?? $co['logo'])) ?>" alt="<?= e($co['name']) ?>" width="150" height="56">
  </a>
  <nav aria-label="Administración">
    <a href="<?= e(url('admin')) ?>"<?= $current === 'leads' ? ' class="is-active"' : '' ?>>Consultas</a>
    <a href="<?= e(url('admin/clicks.php')) ?>"<?= $current === 'clicks' ? ' class="is-active"' : '' ?>>Clicks</a>
    <a href="<?= e(url('/')) ?>" target="_blank" rel="noopener">Ver sitio</a>
    <a href="<?= e(url('admin/logout.php')) ?>">Salir</a>
  </nav>
</aside>
<div class="admin-main">
  <header class="admin-top">
    <div>
      <p class="admin-kicker">Panel</p>
      <h1><?= e($pageTitle ?? 'Admin') ?></h1>
    </div>
    <p class="admin-user"><?= e((string) ($_SESSION['tpl_admin']['email'] ?? '')) ?></p>
  </header>
