<?php
declare(strict_types=1);
$a = site()['area'];
?>
<section class="section" id="<?= e($a['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($a['kicker']) ?></p>
      <h2><?= e($a['title']) ?></h2>
      <p><?= e($a['text']) ?></p>
    </header>
    <div class="area-photos">
      <?php foreach ($a['photos'] as $i => $photo): ?>
        <figure class="area-photo" data-reveal style="--d: <?= (int) ($i * 80) ?>ms">
          <img src="<?= e(asset($photo['src'])) ?>" alt="<?= e($photo['alt']) ?>" width="800" height="762" loading="lazy">
        </figure>
      <?php endforeach; ?>
    </div>
    <ul class="area-list">
      <?php foreach ($a['items'] as $i => $item): ?>
        <li data-reveal style="--d: <?= (int) (($i % 4) * 60) ?>ms">
          <span class="icon-bubble"><?= icon($item['icon']) ?></span>
          <div>
            <h3><?= e($item['title']) ?></h3>
            <p><?= e($item['text']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
