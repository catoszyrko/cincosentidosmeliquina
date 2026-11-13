<?php
declare(strict_types=1);
$h = site()['history'];
?>
<section class="section section-soft" id="<?= e($h['id']) ?>">
  <div class="wrap history-wrap">
    <header class="section-head left history-head" data-reveal>
      <p class="kicker"><?= e($h['kicker']) ?></p>
      <h2><?= e($h['title']) ?></h2>
      <p><?= e($h['text']) ?></p>
      <?php if (!empty($h['image'])): ?>
        <figure class="history-photo">
          <img src="<?= e(asset($h['image'])) ?>" alt="<?= e($h['image_alt'] ?? '') ?>" width="800" height="762" loading="lazy">
        </figure>
      <?php endif; ?>
    </header>
    <ol class="timeline">
      <?php foreach ($h['items'] as $i => $item): ?>
        <li data-reveal style="--d: <?= (int) (($i % 3) * 70) ?>ms">
          <span class="year"><?= e($item['year']) ?></span>
          <div>
            <h3><?= e($item['title']) ?></h3>
            <p><?= e($item['text']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
