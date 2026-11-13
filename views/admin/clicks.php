<?php
declare(strict_types=1);
?>
  <?php if (!empty($dbError)): ?>
    <p class="admin-alert is-error">No se pudo leer la base: <?= e($dbError) ?>.</p>
  <?php endif; ?>

  <section class="admin-stats">
    <article>
      <p>Total clicks</p>
      <strong><?= (int) ($clickStats['total'] ?? 0) ?></strong>
    </article>
    <article>
      <p>WhatsApp</p>
      <strong><?= (int) ($clickStats['whatsapp'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Instagram</p>
      <strong><?= (int) ($clickStats['instagram'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Últimos 7 días</p>
      <strong><?= (int) ($clickStats['week'] ?? 0) ?></strong>
    </article>
  </section>

  <?php if (!empty($bySource)): ?>
  <section class="admin-card">
    <div class="admin-card-head">
      <h2>Por destino y origen</h2>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Canal</th>
            <th>Origen</th>
            <th>Clicks</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bySource as $row): ?>
            <tr>
              <td><span class="admin-tag is-<?= e((string) $row['canal']) ?>"><?= e($row['canal'] === 'instagram' ? 'Instagram' : 'WhatsApp') ?></span></td>
              <td><?= e(click_source_label((string) ($row['source'] ?? ''))) ?></td>
              <td><?= (int) $row['total'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
  <?php endif; ?>

  <section class="admin-card">
    <div class="admin-card-head">
      <h2>Detalle</h2>
      <p><?= (int) $total ?> registro<?= $total === 1 ? '' : 's' ?></p>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Canal</th>
            <th>Origen</th>
            <th>Página</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$clicks): ?>
            <tr>
              <td colspan="4" class="admin-empty">Todavía no hay clicks registrados.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($clicks as $row): ?>
              <tr>
                <td><?= e(date('d/m/Y H:i', strtotime((string) $row['created_at']))) ?></td>
                <td><span class="admin-tag is-<?= e((string) $row['canal']) ?>"><?= e($row['canal'] === 'instagram' ? 'Instagram' : 'WhatsApp') ?></span></td>
                <td><?= e(click_source_label((string) ($row['source'] ?? ''))) ?></td>
                <td><?= e((string) ($row['pagina'] ?: '—')) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?= admin_pagination($total, $page, $perPage, url('admin/clicks.php') . '?p=') ?>
  </section>
