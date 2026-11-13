<?php
declare(strict_types=1);
$w = site()['why'];
?>
<section class="section section-soft" id="<?= e($w['id']) ?>">
  <div class="wrap split why-split">
    <div class="why-media" data-reveal>
      <figure class="why-photo">
        <img src="<?= e(asset($w['image'])) ?>" alt="<?= e($w['image_alt']) ?>" width="800" height="762" loading="lazy">
      </figure>
      <?php if (!empty($w['image_secondary'])): ?>
        <figure class="why-photo is-small">
          <img src="<?= e(asset($w['image_secondary'])) ?>" alt="<?= e($w['image_secondary_alt'] ?? '') ?>" width="800" height="762" loading="lazy">
        </figure>
      <?php endif; ?>
    </div>
    <div>
      <header class="section-head left" data-reveal>
        <p class="kicker"><?= e($w['kicker']) ?></p>
        <h2><?= e($w['title']) ?></h2>
        <p><?= e($w['text']) ?></p>
      </header>
      <ul class="why-list">
        <?php foreach ($w['items'] as $i => $item): ?>
          <li data-reveal style="--d: <?= (int) ($i * 70) ?>ms">
            <h3><?= e($item['title']) ?></h3>
            <p><?= e($item['text']) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <a class="text-link" href="<?= e(url('#historia')) ?>" data-reveal>Leer nuestra historia <?= icon('arrow', 'ico ico-sm') ?></a>
    </div>
  </div>
</section>
