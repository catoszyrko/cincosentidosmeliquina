<?php
declare(strict_types=1);
$co = company();
?>
<main id="contenido" class="page-inner">
  <section class="section not-found">
    <div class="wrap wrap-narrow text-center">
      <img class="not-found-img" src="<?= e(asset('img/tea/tetera-de-porcelana.jpg')) ?>" alt="Tetera de porcelana en la Casa de Té Cinco Sentidos" width="240" height="240" loading="lazy">
      <p class="kicker">Error 404</p>
      <h1>No encontramos esa página</h1>
      <p class="not-found-text">El enlace puede estar desactualizado o el contenido se movió. Volvé al inicio o escribinos por WhatsApp.</p>
      <div class="hero-cta">
        <a class="btn btn-primary" href="<?= e(url('/')) ?>">Ir al inicio</a>
        <a class="btn btn-ghost-dark" href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', '404') ?>><?= icon('whatsapp') ?> WhatsApp</a>
      </div>
      <p class="not-found-links">
        <a href="<?= e(url('hosteria')) ?>">Hostería</a>
        <a href="<?= e(url('casa-de-te')) ?>">Casa de Té</a>
        <a href="<?= e(url('#ubicacion')) ?>">Cómo llegar</a>
      </p>
    </div>
  </section>
</main>
