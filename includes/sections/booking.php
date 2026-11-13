<?php
declare(strict_types=1);
$form = site()['form'];
$c = contact();
?>
<section class="section section-tint" id="<?= e($form['id']) ?>">
  <div class="wrap split booking-split">
    <div data-reveal>
      <p class="kicker"><?= e($form['kicker']) ?></p>
      <h2><?= e($form['title']) ?> en la hostería</h2>
      <p class="booking-text"><?= e($form['subtitle']) ?></p>
      <ul class="contact-cards">
        <li>
          <a href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'booking') ?>>
            <span class="icon-bubble is-wa"><?= icon('whatsapp') ?></span>
            <span><small>WhatsApp</small><strong><?= e($c['whatsapp_display']) ?></strong></span>
          </a>
        </li>
        <?php if (!empty($c['email'])): ?>
          <li>
            <a href="mailto:<?= e($c['email']) ?>">
              <span class="icon-bubble"><?= icon('mail') ?></span>
              <span><small>Email</small><strong><?= e($c['email']) ?></strong></span>
            </a>
          </li>
        <?php endif; ?>
        <?php if (!empty($c['instagram'])): ?>
          <li>
            <a href="<?= e($c['instagram']) ?>"<?= tracked_link_attrs('instagram', 'booking') ?>>
              <span class="icon-bubble"><?= icon('instagram') ?></span>
              <span><small>Instagram</small><strong>@cincosentidosmeliquina</strong></span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="form-card" data-reveal style="--d: 100ms">
      <h3 class="form-title"><?= e($form['card_title'] ?? $form['title']) ?></h3>
      <?php require TPL_ROOT . '/includes/form-lead.php'; ?>
    </div>
  </div>
</section>
