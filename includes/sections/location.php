<?php
declare(strict_types=1);
$loc = site()['location'];
$c = contact();
?>
<section class="section section-soft" id="<?= e($loc['id']) ?>">
  <div class="wrap">
    <div class="split location-split">
      <div>
        <header class="section-head left" data-reveal>
          <p class="kicker"><?= e($loc['kicker']) ?></p>
          <h2><?= e($loc['title']) ?></h2>
          <p><?= e($loc['text']) ?></p>
        </header>
        <ol class="routes">
          <?php foreach ($loc['routes'] as $i => $route): ?>
            <li data-reveal style="--d: <?= (int) ($i * 70) ?>ms">
              <h3><?= e($route['title']) ?></h3>
              <p><?= e($route['text']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
        <ul class="contact-list" data-reveal>
          <li><?= icon('pin', 'ico ico-sm') ?> <span><?= e($c['address']) ?></span></li>
          <li><?= icon('clock', 'ico ico-sm') ?> <span><?= e($c['hours']) ?></span></li>
        </ul>
        <div class="hero-cta" data-reveal>
          <a class="btn btn-primary btn-sm" href="<?= e($c['maps_url']) ?>" target="_blank" rel="noopener"><?= icon('pin', 'ico ico-sm') ?> Abrir en Google Maps</a>
          <a class="btn btn-ghost-dark btn-sm" href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'location') ?>><?= icon('whatsapp', 'ico ico-sm') ?> WhatsApp</a>
        </div>
      </div>
      <div class="map-embed" data-reveal style="--d: 120ms">
        <iframe
          title="Mapa: <?= e(company()['name']) ?> en Villa Lago Meliquina"
          src="<?= e($c['maps_embed']) ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </div>
</section>
