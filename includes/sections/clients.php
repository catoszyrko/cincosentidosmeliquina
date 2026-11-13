<?php
declare(strict_types=1);
$c = site()['clients'];
$logos = $c['logos'];
?>
<section class="section section-navy" id="<?= e($c['id']) ?>">
  <div class="wrap">
    <header class="section-head on-dark" data-reveal>
      <p class="kicker kicker-light"><?= e($c['kicker']) ?></p>
      <h2><?= e($c['title']) ?></h2>
      <p><?= e($c['text']) ?></p>
    </header>
    <div class="logo-marquee" data-lenis-prevent>
      <div class="logo-track">
        <?php for ($n = 0; $n < 2; $n++): ?>
          <?php foreach ($logos as $logo): ?>
            <img src="<?= e(asset($logo['src'])) ?>" alt="<?= e($logo['alt']) ?>" width="140" height="80" loading="lazy">
          <?php endforeach; ?>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>
