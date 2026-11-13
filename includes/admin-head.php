<?php
declare(strict_types=1);
$co = company();
$title = ($pageTitle ?? 'Admin') . ' · ' . $co['name'];
$isLogin = empty($adminPage);
?>
<!DOCTYPE html>
<html lang="<?= e($co['locale'] ?? 'es-AR') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <meta name="theme-color" content="<?= e(site()['colors']['navy']) ?>">
  <title><?= e($title) ?></title>
  <link rel="icon" href="<?= e(asset($co['favicon_32'] ?? $co['favicon'])) ?>" sizes="32x32">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?= e(site()['fonts']['google']) ?>" rel="stylesheet">
  <style><?= theme_css_vars() ?></style>
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body class="admin<?= $isLogin ? ' is-login' : '' ?>">
