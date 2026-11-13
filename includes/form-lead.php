<?php
declare(strict_types=1);
$form = site()['form'];
$c = contact();
$viaWhatsapp = ($form['via'] ?? '') === 'whatsapp';
$fields = $form['fields'];
foreach (($formDefaults ?? []) as $name => $value) {
    foreach ($fields as &$field) {
        if ($field['name'] === $name) {
            $field['value'] = $value;
        }
    }
    unset($field);
}
?>
<form
  class="lead-form"
  method="post"
  action="<?= e(url('procesar-consulta.php')) ?>"
  data-lead-form
  data-lead-url="<?= e(url('procesar-consulta.php')) ?>"
  <?php if ($viaWhatsapp): ?>data-wa-form data-wa-number="<?= e(preg_replace('/\D+/', '', $c['whatsapp']) ?? '') ?>" data-wa-intro="<?= e($form['wa_intro'] ?? $c['whatsapp_message']) ?>" data-wa-room-label="<?= e($form['room_label'] ?? 'Habitación') ?>"<?php endif; ?>
  novalidate
>
  <?= csrf_field() ?>
  <div class="honeypot" aria-hidden="true">
    <label>Sitio web <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
  </div>
  <?php
  $i = 0;
  $total = count($fields);
  while ($i < $total):
      $field = $fields[$i];
      $group = $field['group'] ?? null;
      $chunk = [$field];
      if ($group) {
          while ($i + 1 < $total && (($fields[$i + 1]['group'] ?? null) === $group)) {
              $chunk[] = $fields[++$i];
          }
      }
      $i++;
  ?>
    <?php if (count($chunk) > 1): ?>
      <div class="field-row">
        <?php foreach ($chunk as $item) {
            form_field($item);
        } ?>
      </div>
    <?php else: ?>
      <?php form_field($chunk[0]); ?>
    <?php endif; ?>
  <?php endwhile; ?>
  <button class="btn btn-accent btn-block" type="submit"><?= icon('whatsapp', 'ico ico-sm') ?> <?= e($form['submit']) ?></button>
  <p class="form-note"><?= e($form['disclaimer']) ?></p>
</form>
