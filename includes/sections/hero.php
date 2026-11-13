<?php
declare(strict_types=1);
$hero = site()['hero'];
?>
<section class="hero" id="inicio">
  <div class="wrap hero-grid">
    <div class="hero-copy" data-reveal>
      <p class="kicker"><?= e($hero['kicker']) ?></p>
      <h1><?= emphasize($hero['title'], $hero['title_em'] ?? '') ?></h1>
      <p class="lede"><?= e($hero['text']) ?></p>
      <div class="hero-cta">
        <a class="btn btn-accent" href="<?= e(url($hero['cta_href'])) ?>"><?= icon('calendar', 'ico ico-sm') ?> <?= e($hero['cta']) ?></a>
        <a class="btn btn-ghost-dark" href="<?= e(url($hero['cta_secondary_href'])) ?>"><?= e($hero['cta_secondary']) ?> <?= icon('arrow', 'ico ico-sm') ?></a>
      </div>
    </div>
    <div class="hero-media" data-reveal style="--d: 120ms">
      <figure class="hero-arch">
        <img src="<?= e(asset($hero['image'])) ?>" alt="<?= e($hero['image_alt']) ?>" width="1000" height="667" fetchpriority="high">
      </figure>
      <figure class="hero-inset">
        <img src="<?= e(asset($hero['inset'])) ?>" alt="<?= e($hero['inset_alt']) ?>" width="320" height="426">
      </figure>
      <p class="hero-badge">
        <?= icon('cup', 'ico') ?>
        <span><strong><?= e($hero['badge_title']) ?></strong><?= e($hero['badge_text']) ?></span>
      </p>
    </div>
  </div>
  <div class="wrap">
    <dl class="hero-facts" data-reveal style="--d: 200ms">
      <?php foreach ($hero['facts'] as $fact): ?>
        <div>
          <dt><?= e($fact['value']) ?></dt>
          <dd><?= e($fact['label']) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
