<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');
header('X-Robots-Tag: noindex');
header('Cache-Control: public, max-age=3600');

$site = site();

$lastmod = static function (array $files): string {
    $times = array_map(static fn (string $f): int => (int) (@filemtime(__DIR__ . '/' . $f) ?: 0), $files);
    return date('c', max($times) ?: time());
};

$images = static function (array $paths): array {
    $paths = array_values(array_unique(array_filter($paths)));
    return array_map(static fn (string $p): string => public_asset_url($p), $paths);
};

$homeImages = [$site['hero']['image'] ?? '', $site['why']['image'] ?? ''];
foreach ($site['lodging']['items'] as $item) {
    $homeImages[] = $item['photo'] ?? '';
}
foreach ($site['rooms']['items'] ?? [] as $room) {
    $homeImages[] = $room['photo'] ?? '';
}
foreach ($site['gallery']['items'] ?? [] as $g) {
    $homeImages[] = $g['src'] ?? '';
}

$pages = [[
    'loc' => canonical_url_for('home'),
    'lastmod' => $lastmod(array_merge(
        ['inc/config.php', 'views/home.php'],
        array_map(static fn (string $f): string => 'includes/sections/' . basename($f), glob(__DIR__ . '/includes/sections/*.php') ?: [])
    )),
    'images' => $images($homeImages),
]];

foreach ($site['lodging']['items'] as $item) {
    $pages[] = [
        'loc' => canonical_url_for($item['slug']),
        'lastmod' => $lastmod(['inc/config.php', 'views/house.php']),
        'images' => $images(array_merge(
            [$item['photo'] ?? ''],
            array_map(static fn (array $g): string => $g['src'] ?? '', $item['gallery'] ?? [])
        )),
    ];
}

$pages[] = [
    'loc' => canonical_url_for('privacidad'),
    'lastmod' => $lastmod(['inc/config.php', 'views/privacy.php']),
    'images' => [],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($pages as $page): ?>
  <url>
    <loc><?= e($page['loc']) ?></loc>
    <lastmod><?= e($page['lastmod']) ?></lastmod>
<?php foreach ($page['images'] as $src): ?>
    <image:image><image:loc><?= e($src) ?></image:loc></image:image>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>
