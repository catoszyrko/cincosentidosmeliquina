<?php
declare(strict_types=1);
?>
  <?php if (!empty($dbError)): ?>
    <p class="admin-alert is-error">No se pudo leer la base: <?= e($dbError) ?>. Completá <code>database</code> en <code>inc/config.php</code> y corré <code>/migrate.php?token=…</code>.</p>
  <?php endif; ?>

  <section class="admin-stats">
    <article>
      <p>Consultas</p>
      <strong><?= (int) ($stats['total'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Últimos 7 días</p>
      <strong><?= (int) ($stats['week'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Este mes</p>
      <strong><?= (int) ($stats['month'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Clicks WhatsApp</p>
      <strong><?= (int) ($clickStats['whatsapp'] ?? 0) ?></strong>
    </article>
    <article>
      <p>Clicks Instagram</p>
      <strong><?= (int) ($clickStats['instagram'] ?? 0) ?></strong>
    </article>
  </section>

  <section class="admin-charts" data-admin-charts>
    <div class="admin-charts-bar">
      <h2>Actividad</h2>
      <div class="admin-seg" role="group" aria-label="Período">
        <button type="button" data-range="7">7 días</button>
        <button type="button" data-range="30" class="is-active">30 días</button>
        <button type="button" data-range="90">90 días</button>
      </div>
    </div>

    <article class="admin-card admin-chart is-wide">
      <div class="admin-card-head">
        <div>
          <h2>Contactos por día</h2>
          <p>Tocá la leyenda para ocultar o mostrar cada canal.</p>
        </div>
        <div class="admin-seg is-small" role="group" aria-label="Vista">
          <button type="button" data-mode="stack" class="is-active">Juntos</button>
          <button type="button" data-mode="line">Separados</button>
        </div>
      </div>
      <div class="admin-chart-box is-tall"><canvas id="chart-daily" aria-label="Contactos por día"></canvas></div>
    </article>

    <article class="admin-card admin-chart">
      <div class="admin-card-head">
        <div>
          <h2>Canal elegido</h2>
          <p>Formulario, WhatsApp directo o Instagram.</p>
        </div>
      </div>
      <div class="admin-chart-box"><canvas id="chart-channels" aria-label="Contactos por canal"></canvas></div>
    </article>

    <article class="admin-card admin-chart">
      <div class="admin-card-head">
        <div>
          <h2>Desde dónde contactan</h2>
          <p>Botón o sección del sitio que usaron.</p>
        </div>
      </div>
      <div class="admin-chart-box"><canvas id="chart-sources" aria-label="Contactos por origen"></canvas></div>
    </article>
  </section>
  <script type="application/json" id="admin-chart-data"><?= json_encode($chartData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" defer></script>
  <script src="<?= e(asset('js/admin-charts.js')) ?>" defer></script>

  <section class="admin-card">
    <div class="admin-card-head">
      <h2>Registros</h2>
      <div class="admin-card-actions">
        <p><?= (int) $total ?> consulta<?= $total === 1 ? '' : 's' ?></p>
        <?php if ($total > 0): ?>
          <a class="admin-btn-sm" href="<?= e(url('admin/export.php')) ?>" download>
            <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0-4-4m4 4 4-4M5 21h14"/></svg>
            Exportar .xls
          </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Personas</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Habitación</th>
            <th>Mensaje</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$leads): ?>
            <tr>
              <td colspan="8" class="admin-empty">Todavía no hay consultas guardadas.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($leads as $row): ?>
              <tr>
                <td><?= e(date('d/m/Y H:i', strtotime((string) $row['created_at']))) ?></td>
                <td><?= e((string) $row['nombre']) ?></td>
                <td><?= lead_contact_html($row['contacto'] ?? null) ?></td>
                <td><?= e($row['huespedes'] !== null && $row['huespedes'] !== '' ? (string) $row['huespedes'] : '—') ?></td>
                <td><?= e(!empty($row['checkin']) ? format_lead_date((string) $row['checkin']) : '—') ?></td>
                <td><?= e(!empty($row['checkout']) ? format_lead_date((string) $row['checkout']) : '—') ?></td>
                <td><?= e((string) ($row['casa'] ?: 'A definir')) ?></td>
                <td><?= e((string) ($row['mensaje'] ?: '—')) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?= admin_pagination($total, $page, $perPage, url('admin') . '?p=') ?>
  </section>
