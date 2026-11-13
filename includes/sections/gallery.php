<?php
declare(strict_types=1);
$g = site()['gallery'];
?>
<section class="section" id="<?= e($g['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($g['kicker']) ?></p>
      <h2><?= e($g['title']) ?></h2>
      <p><?= e($g['text']) ?></p>
    </header>
    <div class="gallery-grid" data-lightbox-group>
      <?php foreach ($g['items'] as $i => $item): ?>
        <figure class="gallery-item" data-reveal style="--d: <?= (int) min(($i % 6) * 50, 250) ?>ms">
          <a href="<?= e(asset($item['src'])) ?>" data-lightbox aria-label="Ampliar foto: <?= e($item['alt']) ?>">
            <img src="<?= e(asset($item['src'])) ?>" alt="<?= e($item['alt']) ?>" width="800" height="800" loading="lazy">
          </a>
        </figure>
      <?php endforeach; ?>
    </div>
    <p class="gallery-more" data-reveal>
      Más fotos en
      <a href="<?= e(contact()['instagram']) ?>"<?= tracked_link_attrs('instagram', 'gallery') ?>><?= icon('instagram', 'ico ico-sm') ?> @cincosentidosmeliquina</a>
    </p>
  </div>
</section>
