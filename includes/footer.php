<?php
declare(strict_types=1);
$co = company();
$c = contact();
$footer = site()['footer'];
$year = date('Y');
?>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <a class="brand brand-light" href="<?= e(url('/')) ?>">
        <img src="<?= e(asset($co['logo_light'] ?? $co['logo'])) ?>" alt="<?= e($co['name']) ?>" width="144" height="120">
      </a>
      <p class="footer-blurb"><?= e($footer['blurb']) ?></p>
      <p class="footer-meta">
        <?php if (!empty($c['email'])): ?>
          <a href="mailto:<?= e($c['email']) ?>"><?= e($c['email']) ?></a><br>
        <?php endif; ?>
        <?php if (!empty($c['phone']) && preg_replace('/\D+/', '', $c['phone']) !== preg_replace('/\D+/', '', $c['whatsapp'] ?? '')): ?>
          <a href="tel:<?= e(preg_replace('/\D+/', '', $c['phone']) ?? '') ?>"><?= e($c['phone']) ?></a><br>
        <?php endif; ?>
        <a href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'footer') ?>><?= e($c['whatsapp_display']) ?></a><br>
        <?= e($c['address_short'] ?? $c['address'] ?? '') ?>
      </p>
      <div class="social">
        <?php if (!empty($c['instagram'])): ?><a href="<?= e($c['instagram']) ?>"<?= tracked_link_attrs('instagram', 'footer') ?> aria-label="Instagram"><?= icon('instagram') ?></a><?php endif; ?>
        <?php if (!empty($c['facebook'])): ?><a href="<?= e($c['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook"><?= icon('facebook') ?></a><?php endif; ?>
        <?php if (!empty($c['tiktok'])): ?><a href="<?= e($c['tiktok']) ?>" target="_blank" rel="noopener" aria-label="TikTok"><?= icon('tiktok') ?></a><?php endif; ?>
        <?php if (!empty($c['linkedin'])): ?><a href="<?= e($c['linkedin']) ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><?= icon('linkedin') ?></a><?php endif; ?>
      </div>
    </div>
    <?php foreach ($footer['columns'] as $col): ?>
      <nav aria-label="<?= e($col['title']) ?>">
        <p class="footer-title"><?= e($col['title']) ?></p>
        <ul>
          <?php foreach ($col['links'] as $link):
              $href = $link['href'];
              $external = !empty($link['external']);
              $track = '';
              if ($href === 'whatsapp') {
                  $href = wa_url();
                  $external = true;
                  $track = tracked_link_attrs('whatsapp', 'footer');
              } elseif (is_string($href) && str_contains($href, 'instagram.com')) {
                  $track = tracked_link_attrs('instagram', 'footer');
              } elseif (!$external) {
                  $href = url($href);
              }
          ?>
            <li><a href="<?= e($href) ?>"<?= $external && $track === '' ? ' target="_blank" rel="noopener"' : '' ?><?= $track ?>><?= e($link['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>
    <?php endforeach; ?>
  </div>
  <div class="footer-bottom">
    <div class="wrap">
      <p>© <?= e($year) ?> <?= e($footer['copyright']) ?></p>
      <p><a href="<?= e(url('privacidad')) ?>">Política de privacidad</a></p>
      <?php if (!empty($footer['credit_url'])): ?>
        <p class="footer-credit">
          <?= e($footer['credit_prefix'] ?? 'desarrollado por:') ?>
          <a href="<?= e($footer['credit_url']) ?>" target="_blank" rel="noopener"><?= e($footer['credit_label'] ?? 'estudiolimay.com') ?></a>
        </p>
      <?php endif; ?>
    </div>
  </div>
</footer>

<a class="wa-float" href="<?= e(wa_url()) ?>"<?= tracked_link_attrs('whatsapp', 'float') ?>>
  <span class="wa-float-label">Consultar por WhatsApp</span>
  <span class="wa-float-btn" aria-hidden="true"><?= icon('whatsapp') ?></span>
  <span class="sr-only">Escribir por WhatsApp</span>
</a>
<script src="<?= e(asset('js/app.js')) ?>" defer></script>
</body>
</html>
