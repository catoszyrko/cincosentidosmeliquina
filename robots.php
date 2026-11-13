<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';
header('Content-Type: text/plain; charset=UTF-8');
$sitemap = is_local_request() ? site_url('sitemap.xml') : public_origin() . '/sitemap.xml';
echo "User-agent: *\nAllow: /\n";
echo "Disallow: /inc/\nDisallow: /includes/\nDisallow: /views/\nDisallow: /data/\n";
echo "Disallow: /admin/\nDisallow: /migrations/\n";
echo "Disallow: /procesar-consulta.php\nDisallow: /track-click.php\nDisallow: /migrate.php\n\n";
echo "Sitemap: " . $sitemap . "\n";
