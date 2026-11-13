<?php
declare(strict_types=1);
$cta = site()['cta'];
$stats = site()['stats'];
$isWa = $cta['button_href'] === 'whatsapp';
?>
<section class="cta-band">
  <div class="wrap cta-inner" data-reveal>
    <div>
      <h2><?= e($cta['title']) ?></h2>
      <p><?= e($cta['text']) ?></p>
      <a class="btn btn-light" href="<?= e($isWa ? wa_url() : url($cta['button_href'])) ?>"<?= $isWa ? tracked_link_attrs('whatsapp', 'cta') : '' ?>><?php if ($isWa): ?><?= icon('whatsapp', 'ico ico-sm') ?> <?php endif; ?><?= e($cta['button']) ?></a>
    </div>
    <dl class="stats">
      <?php foreach ($stats as $stat): ?>
        <div>
          <dt><?= e($stat['value']) ?></dt>
          <dd><?= e($stat['label']) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
