<?php
declare(strict_types=1);
$l = site()['lodging'];
?>
<section class="section" id="<?= e($l['id']) ?>">
  <div class="wrap">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($l['kicker']) ?></p>
      <h2><?= e($l['title']) ?></h2>
      <p><?= e($l['text']) ?></p>
    </header>
    <div class="lodging-grid">
      <?php foreach ($l['items'] as $i => $item):
          $detailUrl = url($item['slug']);
      ?>
        <article class="lodging-card" data-reveal style="--d: <?= (int) ($i * 100) ?>ms">
          <a class="lodging-photo" href="<?= e($detailUrl) ?>" tabindex="-1" aria-hidden="true">
            <img src="<?= e(asset($item['photo'])) ?>" alt="" width="768" height="1024" loading="lazy">
            <?php if (!empty($item['capacity'])): ?>
              <span class="lodging-cap"><?= e($item['capacity']) ?></span>
            <?php endif; ?>
          </a>
          <div class="lodging-body">
            <h3><a href="<?= e($detailUrl) ?>"><?= e($item['name']) ?></a></h3>
            <p class="lodging-lead"><?= e($item['role']) ?></p>
            <div class="lodging-actions">
              <a class="btn btn-primary btn-sm" href="<?= e($detailUrl) ?>">
                <?= e($l['cta']) ?> <?= icon('arrow', 'ico ico-sm') ?>
              </a>
              <a class="btn btn-ghost-dark btn-sm" href="<?= e(wa_url($item['wa_message'] ?? null)) ?>"<?= tracked_link_attrs('whatsapp', 'lodging-' . $item['slug']) ?>>
                <?= icon('whatsapp', 'ico ico-sm') ?> <?= e($l['detail_cta']) ?>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
