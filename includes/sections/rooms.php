<?php
declare(strict_types=1);
$r = site()['rooms'];
?>
<section class="section" id="<?= e($r['id']) ?>">
  <div class="wrap">
    <div class="rooms-head">
      <header class="section-head left" data-reveal>
        <p class="kicker"><?= e($r['kicker']) ?></p>
        <h2><?= e($r['title']) ?></h2>
        <p><?= e($r['text']) ?></p>
      </header>
      <a class="btn btn-ghost-dark btn-sm" href="<?= e(url('hosteria')) ?>" data-reveal><?= e($r['cta']) ?> <?= icon('arrow', 'ico ico-sm') ?></a>
    </div>
    <div class="rooms-grid">
      <?php foreach ($r['items'] as $i => $room): ?>
        <article class="room-card" data-reveal style="--d: <?= (int) ($i * 100) ?>ms">
          <figure class="room-photo">
            <img src="<?= e(asset($room['photo'])) ?>" alt="<?= e($room['image_alt']) ?>" width="768" height="1024" loading="lazy">
          </figure>
          <div class="room-body">
            <h3><?= e($room['name']) ?></h3>
            <dl class="room-specs">
              <?php foreach ($room['specs'] as $spec): ?>
                <div>
                  <dt><?= e($spec['label']) ?></dt>
                  <dd><?= e($spec['value']) ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
            <a class="text-link" href="<?= e(url('#reservas')) ?>" data-room="<?= e($room['form_value'] ?? '') ?>">Consultar esta habitación <?= icon('arrow', 'ico ico-sm') ?></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
