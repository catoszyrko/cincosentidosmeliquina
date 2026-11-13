<?php
declare(strict_types=1);
$p = site()['privacy'];
$co = company();
?>
<main id="contenido" class="page-inner">
  <section class="section">
    <div class="wrap wrap-narrow prose">
      <p class="kicker"><?= e($p['updated']) ?></p>
      <h1><?= e($p['title']) ?></h1>
      <p><?= e($p['intro']) ?></p>
      <?php foreach ($p['sections'] as $block): ?>
        <h2><?= e($block['title']) ?></h2>
        <p><?= e($block['text']) ?></p>
      <?php endforeach; ?>
      <p><a class="btn btn-primary" href="<?= e(url('/')) ?>">Volver al inicio</a></p>
    </div>
  </section>
</main>
