<?php
declare(strict_types=1);
$l = site()['lodging'];
$form = site()['form'];
$c = contact();
$house = $GLOBALS['page']['house'];
$booking = !empty($house['booking']);
$others = array_values(array_filter($l['items'], static fn (array $item): bool => $item['slug'] !== $house['slug']));
$waMessage = $house['wa_message'] ?? null;
$formDefaults = ['casa' => $house['form_value'] ?? ''];
?>
<main id="contenido" class="page-inner">
  <section class="section house-intro">
    <div class="wrap">
      <nav class="breadcrumb" aria-label="Ruta de navegación">
        <a href="<?= e(url('/')) ?>">Inicio</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page"><?= e($house['name']) ?></span>
      </nav>
      <div class="split house-split">
        <figure class="media house-cover" data-reveal>
          <img src="<?= e(asset($house['photo'])) ?>" alt="<?= e($house['image_alt'] ?? $house['name']) ?>" width="768" height="1024" fetchpriority="high">
        </figure>
        <div data-reveal style="--d: 80ms">
          <p class="kicker"><?= e($house['capacity'] ?? '') ?></p>
          <h1><?= e($house['name']) ?> <em>Cinco Sentidos</em></h1>
          <p class="house-lead"><?= e($house['role']) ?></p>
          <div class="house-text">
            <?php foreach (($house['description'] ?? []) as $paragraph): ?>
              <p><?= e($paragraph) ?></p>
            <?php endforeach; ?>
          </div>
          <div class="hero-cta house-cta">
            <?php if ($booking): ?>
              <a class="btn btn-accent" href="#reservas"><?= icon('calendar', 'ico ico-sm') ?> Consultar disponibilidad</a>
            <?php else: ?>
              <a class="btn btn-accent" href="<?= e($c['maps_url']) ?>" target="_blank" rel="noopener"><?= icon('pin', 'ico ico-sm') ?> Cómo llegar</a>
            <?php endif; ?>
            <a class="btn btn-ghost-dark" href="<?= e(wa_url($waMessage)) ?>"<?= tracked_link_attrs('whatsapp', 'house-' . $house['slug']) ?>>
              <?= icon('whatsapp', 'ico ico-sm') ?> <?= e($l['detail_cta']) ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section section-soft">
    <div class="wrap house-details">
      <div class="house-box" data-reveal>
        <h2><?= $booking ? 'Comodidades' : 'Qué vas a encontrar' ?></h2>
        <ul class="lodging-list">
          <?php foreach ($house['amenities'] as $amenity): ?>
            <li><?= icon('check', 'ico ico-sm') ?> <?= e($amenity) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php if (!empty($house['info'])): ?>
        <div class="house-box" data-reveal style="--d: 80ms">
          <h2><?= e($house['info_title']) ?></h2>
          <ul class="lodging-list">
            <?php foreach ($house['info'] as $item): ?>
              <li><?= icon('check', 'ico ico-sm') ?> <?= e($item) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php if (!empty($house['gallery'])): ?>
    <section class="section">
      <div class="wrap">
        <header class="section-head" data-reveal>
          <p class="kicker">Galería</p>
          <h2>Así es la <?= e($house['name']) ?></h2>
        </header>
        <div class="gallery-grid house-gallery" data-lightbox-group>
          <?php foreach ($house['gallery'] as $i => $item): ?>
            <figure class="gallery-item" data-reveal style="--d: <?= (int) min(($i % 6) * 50, 250) ?>ms">
              <a href="<?= e(asset($item['src'])) ?>" data-lightbox aria-label="Ampliar foto: <?= e($item['alt']) ?>">
                <img src="<?= e(asset($item['src'])) ?>" alt="<?= e($item['alt']) ?>" width="800" height="800" loading="lazy">
              </a>
            </figure>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section class="section section-tint"<?= $booking ? ' id="reservas"' : '' ?>>
    <div class="wrap split house-booking">
      <div data-reveal>
        <?php if ($booking): ?>
          <p class="kicker"><?= e($form['kicker']) ?></p>
          <h2><?= e($form['title']) ?></h2>
          <p class="house-booking-text"><?= e($form['subtitle']) ?></p>
        <?php else: ?>
          <p class="kicker">Visitanos</p>
          <h2>Te esperamos a la hora del té</h2>
          <p class="house-booking-text"><?= e(site()['method']['result_text']) ?></p>
        <?php endif; ?>
        <?php foreach ($others as $other): ?>
          <a class="house-other" href="<?= e(url($other['slug'])) ?>">
            <img src="<?= e(asset($other['photo'])) ?>" alt="" width="160" height="120" loading="lazy">
            <span>
              <small>Conocé también</small>
              <strong>La <?= e($other['name']) ?></strong>
              <span class="house-other-link">Ver más <?= icon('arrow', 'ico ico-sm') ?></span>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
      <?php if ($booking): ?>
        <div class="form-card house-form" data-reveal style="--d: 80ms">
          <h3 class="form-title"><?= e($form['card_title'] ?? $form['title']) ?></h3>
          <?php require TPL_ROOT . '/includes/form-lead.php'; ?>
        </div>
      <?php else: ?>
        <div class="visit-card" data-reveal style="--d: 80ms">
          <ul class="contact-list">
            <li><?= icon('clock', 'ico ico-sm') ?> <span><strong>Horario</strong><?= e($c['hours']) ?></span></li>
            <li><?= icon('pin', 'ico ico-sm') ?> <span><strong>Dirección</strong><?= e($c['address']) ?></span></li>
            <li><?= icon('whatsapp', 'ico ico-sm') ?> <span><strong>WhatsApp</strong><?= e($c['whatsapp_display']) ?></span></li>
          </ul>
          <div class="map-embed is-compact">
            <iframe title="Mapa: <?= e(company()['name']) ?> en Villa Lago Meliquina" src="<?= e($c['maps_embed']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
          </div>
          <div class="hero-cta">
            <a class="btn btn-primary btn-sm" href="<?= e($c['maps_url']) ?>" target="_blank" rel="noopener">Abrir en Google Maps</a>
            <a class="btn btn-wa btn-sm" href="<?= e(wa_url($waMessage)) ?>"<?= tracked_link_attrs('whatsapp', 'house-' . $house['slug'] . '-visit') ?>><?= icon('whatsapp', 'ico ico-sm') ?> Escribir</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php section('cta'); ?>
</main>
