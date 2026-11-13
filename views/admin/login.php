<?php
declare(strict_types=1);
$co = company();
?>
<main class="admin-login">
  <div class="admin-login-card">
    <img src="<?= e(asset($co['logo'])) ?>" alt="<?= e($co['name']) ?>" width="170" height="64">
    <h1>Ingresar al panel</h1>
    <p>Consultas del formulario y clicks a WhatsApp o Instagram.</p>
    <?php if (!empty($loginError)): ?>
      <p class="admin-alert is-error"><?= e($loginError) ?></p>
    <?php endif; ?>
    <form method="post" action="<?= e(url('admin')) ?>" class="admin-form">
      <?= csrf_field() ?>
      <input type="hidden" name="admin_login" value="1">
      <label>
        <span>Email</span>
        <input type="email" name="email" autocomplete="username" required value="<?= e((string) ($_POST['email'] ?? '')) ?>">
      </label>
      <label>
        <span>Contraseña</span>
        <input type="password" name="password" autocomplete="current-password" required>
      </label>
      <button class="admin-btn" type="submit">Entrar</button>
    </form>
  </div>
</main>
