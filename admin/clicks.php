<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/inc/bootstrap.php';

header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');
require_admin();

$perPage = 50;
$page = max(1, (int) ($_GET['p'] ?? 1));
$dbError = '';
$clickStats = ['total' => 0, 'whatsapp' => 0, 'instagram' => 0, 'week' => 0];
$clicks = [];
$bySource = [];
$total = 0;

try {
    $clickStats = db_click_stats();
    $total = $clickStats['total'];
    $clicks = db_clicks($perPage, ($page - 1) * $perPage);
    $bySource = db_clicks_by_source();
} catch (Throwable $e) {
    $dbError = $e->getMessage();
}

$adminPage = 'clicks';
$pageTitle = 'Clicks';
require TPL_ROOT . '/includes/admin-head.php';
require TPL_ROOT . '/includes/admin-nav.php';
require TPL_ROOT . '/views/admin/clicks.php';
require TPL_ROOT . '/includes/admin-foot.php';
