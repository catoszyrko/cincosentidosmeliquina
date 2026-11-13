<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');
$lastmod = gmdate('Y-m-d', filemtime(__DIR__ . '/inc/config.php') ?: time());
$pages = [
    ['loc' => canonical_url_for('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => canonical_url_for('privacidad'), 'priority' => '0.3', 'changefreq' => 'yearly'],
];
foreach (site()['lodging']['items'] as $item) {
    $pages[] = ['loc' => canonical_url_for($item['slug']), 'priority' => '0.8', 'changefreq' => 'monthly'];
}
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
  <url>
    <loc><?= e($page['loc']) ?></loc>
    <lastmod><?= e($lastmod) ?></lastmod>
    <changefreq><?= e($page['changefreq']) ?></changefreq>
    <priority><?= e($page['priority']) ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
