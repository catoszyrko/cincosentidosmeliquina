<?php
declare(strict_types=1);
$t = site()['teachers'];
?>
<section class="section" id="<?= e($t['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($t['kicker']) ?></p>
      <h2><?= e($t['title']) ?></h2>
      <p><?= e($t['text']) ?></p>
    </header>
    <div class="teachers" data-carousel>
      <?php foreach ($t['items'] as $item): ?>
        <article class="teacher-card">
          <img src="<?= e(asset($item['photo'])) ?>" alt="<?= e($item['name']) ?>" width="320" height="320" loading="lazy">
          <h3><?= e($item['name']) ?></h3>
          <p><?= e($item['role']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
