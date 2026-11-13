<?php
declare(strict_types=1);
$f = site()['faq'];
?>
<section class="section" id="<?= e($f['id']) ?>">
  <div class="wrap wrap-narrow">
    <header class="section-head" data-reveal>
      <p class="kicker"><?= e($f['kicker']) ?></p>
      <h2><?= e($f['title']) ?></h2>
      <p><?= e($f['text']) ?></p>
    </header>
    <div class="faq" data-accordion-group>
      <?php foreach ($f['items'] as $i => $item): ?>
        <div class="faq-item<?= $i === 0 ? ' is-open' : '' ?>" data-accordion>
          <button type="button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
            <span><?= e($item['q']) ?></span>
            <span class="faq-plus" aria-hidden="true"></span>
          </button>
          <div class="faq-body">
            <?php foreach (preg_split("/\n\s*\n/", trim((string) $item['a'])) as $para): ?>
              <p><?= e($para) ?></p>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
