<?php
declare(strict_types=1);
$m = site()['method'];
?>
<section class="section section-navy tea-section" id="<?= e($m['id']) ?>">
  <div class="wrap">
    <div class="split method-split">
      <div>
        <header class="section-head left on-dark" data-reveal>
          <p class="kicker kicker-light"><?= e($m['kicker']) ?></p>
          <h2><?= e($m['title']) ?></h2>
          <p><?= e($m['text']) ?></p>
        </header>
        <ol class="steps">
          <?php foreach ($m['steps'] as $i => $step): ?>
            <li data-reveal style="--d: <?= (int) ($i * 80) ?>ms">
              <span class="step-n"><?= e($step['n']) ?></span>
              <div>
                <h3><?= e($step['title']) ?></h3>
                <p><?= e($step['text']) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
      <div class="method-photos" data-reveal style="--d: 120ms">
        <figure class="method-photo is-main">
          <img src="<?= e(asset($m['image'])) ?>" alt="<?= e($m['image_alt']) ?>" width="800" height="600" loading="lazy">
        </figure>
        <?php foreach (($m['side_images'] ?? []) as $side): ?>
          <figure class="method-photo">
            <img src="<?= e(asset($side['src'])) ?>" alt="<?= e($side['alt']) ?>" width="640" height="800" loading="lazy">
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="result-band" data-reveal>
      <span class="result-icon"><?= icon('clock') ?></span>
      <div>
        <p class="result-title"><?= e($m['result_title']) ?></p>
        <p class="result-text"><?= e($m['result_text']) ?></p>
      </div>
      <div class="result-actions">
        <a class="btn btn-light btn-sm" href="<?= e(url('casa-de-te')) ?>"><?= e($m['detail_cta']) ?></a>
        <a class="btn btn-wa btn-sm" href="<?= e(wa_url('Hola, quiero hacer una consulta sobre la Casa de Té Cinco Sentidos.')) ?>"<?= tracked_link_attrs('whatsapp', 'method') ?>><?= icon('whatsapp', 'ico ico-sm') ?> <?= e($m['cta']) ?></a>
      </div>
    </div>
  </div>
</section>
