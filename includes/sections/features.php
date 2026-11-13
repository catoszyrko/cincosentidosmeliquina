<?php
declare(strict_types=1);
$f = site()['features'];
?>
<section class="section section-tint section-tight" id="<?= e($f['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($f['kicker']) ?></p>
      <h2><?= e($f['title']) ?></h2>
      <p><?= e($f['text']) ?></p>
    </header>
    <div class="cards cards-4">
      <?php foreach ($f['items'] as $i => $item): ?>
        <article class="feature-card" data-reveal style="--d: <?= (int) (($i % 4) * 60) ?>ms">
          <span class="icon-bubble"><?= icon($item['icon']) ?></span>
          <h3><?= e($item['title']) ?></h3>
          <p><?= e($item['text']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="section-cta" data-reveal>
      <a class="btn btn-accent" href="<?= e(url('#reservas')) ?>"><?= e($f['cta']) ?></a>
    </div>
  </div>
</section>
