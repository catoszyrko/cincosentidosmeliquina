<?php
declare(strict_types=1);
$co = company();
$c = contact();
$nav = site()['nav'];
$headerCta = site()['header_cta'] ?? ['label' => 'Consultar', 'href' => '#reservas'];
$solid = !empty($GLOBALS['page']['solid_nav']);
?>
<header class="site-header<?= $solid ? ' is-solid' : '' ?>" data-header>
  <div class="wrap header-inner">
    <a class="brand" href="<?= e(url('/')) ?>" aria-label="<?= e($co['name']) ?> — inicio">
      <img src="<?= e(asset($co['logo'])) ?>" alt="<?= e($co['name']) ?>" width="96" height="80">
    </a>
    <nav class="nav-desktop" aria-label="Principal">
      <?php foreach ($nav as $item): ?>
        <a href="<?= e(!empty($item['external']) ? $item['href'] : url($item['href'])) ?>"<?= !empty($item['external']) ? ' target="_blank" rel="noopener"' : '' ?>><?= e($item['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="header-actions">
      <a class="btn btn-accent btn-sm hide-sm" href="<?= e(url($headerCta['href'])) ?>"><?= e($headerCta['label']) ?></a>
      <a class="btn btn-wa btn-sm hide-sm" href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'header') ?>>
        <?= icon('whatsapp', 'ico ico-sm') ?> WhatsApp
      </a>
      <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="menu-movil" aria-label="Abrir menú">
        <?= icon('menu') ?>
      </button>
    </div>
  </div>
</header>
<div class="nav-panel" id="menu-movil" data-nav-panel>
  <div class="nav-panel-top">
    <img src="<?= e(asset($co['logo_light'] ?? $co['logo'])) ?>" alt="" width="96" height="80">
    <button type="button" data-nav-close aria-label="Cerrar menú"><?= icon('close') ?></button>
  </div>
  <nav aria-label="Menú móvil">
    <?php foreach ($nav as $item): ?>
      <a href="<?= e(!empty($item['external']) ? $item['href'] : url($item['href'])) ?>"<?= !empty($item['external']) ? ' target="_blank" rel="noopener"' : '' ?>><?= e($item['label']) ?></a>
    <?php endforeach; ?>
    <a class="btn btn-accent" href="<?= e(url($headerCta['href'])) ?>"><?= e($headerCta['label']) ?></a>
    <a class="btn btn-wa" href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'nav-mobile') ?>><?= icon('whatsapp', 'ico ico-sm') ?> WhatsApp</a>
  </nav>
</div>
