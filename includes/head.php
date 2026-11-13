<?php
declare(strict_types=1);
$co = company();
$page = $GLOBALS['page'] ?? [];
$seo = $site['seo'] ?? [];
$title = $page['title'] ?? ($seo['title'] ?? $co['name']);
$description = $page['description'] ?? ($seo['description'] ?? '');
$robots = $page['robots'] ?? ($seo['robots'] ?? 'index, follow');
$keywords = $page['keywords'] ?? ($seo['keywords'] ?? '');
$ogTitle = $page['og_title'] ?? ($seo['og_title'] ?? $title);
$ogDescription = $page['og_description'] ?? ($seo['og_description'] ?? $description);
$ogImage = $page['og_image'] ?? $co['og_image'];
$ogImageUrl = public_asset_url((string) $ogImage);
$canonical = canonical_url();
$isError = ($page['id'] ?? '') === 'error';
$ogFile = TPL_ROOT . '/assets/' . ltrim(preg_replace('#^/?assets/#', '', (string) $ogImage) ?? '', '/');
$ogSize = is_file($ogFile) ? @getimagesize($ogFile) : false;
$gtm = trim((string) ($site['analytics']['gtm_id'] ?? ''));
$ga = trim((string) ($site['analytics']['ga_id'] ?? ''));
$verify = trim((string) ($co['google_site_verification'] ?? ''));
$c = contact();
$ogAlt = $page['og_image_alt'] ?? ($site['hero']['image_alt'] ?? $co['name']);
?>
<!DOCTYPE html>
<html lang="<?= e($co['locale'] ?? 'es-AR') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="<?= e($site['colors']['navy']) ?>">
  <meta name="geo.region" content="<?= e($site['schema']['region_code'] ?? 'AR') ?>">
  <meta name="geo.placename" content="<?= e(trim(($site['schema']['locality'] ?? '') . ', ' . ($site['schema']['region'] ?? ''), ', ')) ?>">
  <meta name="geo.position" content="<?= e($c['lat'] ?? '') ?>;<?= e($c['lng'] ?? '') ?>">
  <meta name="ICBM" content="<?= e($c['lat'] ?? '') ?>, <?= e($c['lng'] ?? '') ?>">
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>">
<?php if ($keywords !== ''): ?>
  <meta name="keywords" content="<?= e($keywords) ?>">
<?php endif; ?>
  <meta name="author" content="<?= e($co['name']) ?>">
  <meta name="robots" content="<?= e($robots === 'index, follow' ? 'index, follow, max-image-preview:large, max-snippet:-1' : $robots) ?>">
<?php if (!$isError): ?>
  <link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>
  <link rel="icon" href="<?= e(asset($co['favicon_32'] ?? $co['favicon'])) ?>" sizes="32x32">
  <link rel="icon" href="<?= e(asset($co['favicon'])) ?>" sizes="180x180">
  <link rel="apple-touch-icon" href="<?= e(asset($co['favicon'])) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?= e($site['fonts']['google']) ?>" rel="stylesheet">
  <style><?= theme_css_vars() ?></style>
  <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
  <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
  <meta property="og:locale" content="<?= e($co['og_locale'] ?? 'es_AR') ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= e($co['name']) ?>">
  <meta property="og:title" content="<?= e($ogTitle) ?>">
  <meta property="og:description" content="<?= e($ogDescription) ?>">
<?php if (!$isError): ?>
  <meta property="og:url" content="<?= e($canonical) ?>">
<?php endif; ?>
  <meta property="og:image" content="<?= e($ogImageUrl) ?>">
  <meta property="og:image:secure_url" content="<?= e($ogImageUrl) ?>">
  <meta property="og:image:alt" content="<?= e($ogAlt) ?>">
  <meta property="og:image:type" content="image/jpeg">
<?php if ($ogSize): ?>
  <meta property="og:image:width" content="<?= (int) $ogSize[0] ?>">
  <meta property="og:image:height" content="<?= (int) $ogSize[1] ?>">
<?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($ogTitle) ?>">
  <meta name="twitter:description" content="<?= e($ogDescription) ?>">
  <meta name="twitter:image" content="<?= e($ogImageUrl) ?>">
  <meta name="twitter:image:alt" content="<?= e($ogAlt) ?>">
<?php if ($verify !== ''): ?>
  <meta name="google-site-verification" content="<?= e($verify) ?>">
<?php endif; ?>
  <script type="application/ld+json"><?= schema_json() ?></script>
<?php if ($gtm !== ''): ?>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= e($gtm) ?>');</script>
<?php elseif ($ga !== ''): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($ga) ?>"></script>
  <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($ga) ?>');</script>
<?php endif; ?>
</head>
<body data-page="<?= e($page['id'] ?? 'home') ?>" data-track-url="<?= e(url('track-click.php')) ?>">
<?php if ($gtm !== ''): ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($gtm) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>
<a class="skip-link" href="#contenido">Ir al contenido</a>
