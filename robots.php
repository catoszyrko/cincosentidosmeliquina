<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: public, max-age=86400');
$sitemap = is_local_request() ? site_url('sitemap.xml') : public_origin() . '/sitemap.xml';

echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /admin/\n";
echo "Disallow: /procesar-consulta.php\n";
echo "Disallow: /track-click.php\n";
echo "Disallow: /migrate.php\n";
echo "\n";
echo "Sitemap: " . $sitemap . "\n";
