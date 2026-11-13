<?php
declare(strict_types=1);
$t = site()['testimonials'];
?>
<section class="section section-soft" id="<?= e($t['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($t['kicker']) ?></p>
      <h2><?= e($t['title']) ?></h2>
      <p><?= e($t['text']) ?></p>
      <div class="google-badges">
        <?php foreach (($t['badges'] ?? []) as $badge): ?>
          <a class="google-badge" href="<?= e($badge['url']) ?>" target="_blank" rel="noopener">
            <?= google_mark() ?>
            <span class="google-badge-copy">
              <strong><?= e($badge['label']) ?></strong>
              <span><?= stars_html(5, 'stars stars-sm') ?> <?= e($badge['rating']) ?> de 5</span>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    </header>
    <div class="cards cards-reviews">
      <?php foreach ($t['items'] as $i => $item): ?>
        <blockquote class="quote-card" data-reveal style="--d: <?= (int) (($i % 3) * 70) ?>ms">
          <div class="quote-top">
            <?= stars_html((int) ($item['stars'] ?? 5), 'stars stars-card') ?>
            <?php if (!empty($item['tag'])): ?><span class="quote-tag"><?= e($item['tag']) ?></span><?php endif; ?>
          </div>
          <p><?= e($item['text']) ?></p>
          <footer class="quote-meta">
            <?= google_mark('google-mark-xs') ?>
            <span>Reseña en Google</span>
            <?php if (!empty($item['role'])): ?><time><?= e($item['role']) ?></time><?php endif; ?>
          </footer>
        </blockquote>
      <?php endforeach; ?>
    </div>
  </div>
</section>
