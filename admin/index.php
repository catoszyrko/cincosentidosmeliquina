<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/inc/bootstrap.php';

header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

$loginError = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['admin_login'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $loginError = 'La sesión expiró. Probá de nuevo.';
    } elseif (admin_credentials_ok((string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? ''))) {
        admin_login(admin_email());
        header('Location: ' . url('admin'));
        exit;
    } else {
        $loginError = 'Email o clave incorrectos.';
    }
}

if (!admin_logged_in()) {
    $pageTitle = 'Ingresar';
    require TPL_ROOT . '/includes/admin-head.php';
    require TPL_ROOT . '/views/admin/login.php';
    require TPL_ROOT . '/includes/admin-foot.php';
    exit;
}

$perPage = 40;
$page = max(1, (int) ($_GET['p'] ?? 1));
$dbError = '';
$stats = ['total' => 0, 'week' => 0, 'month' => 0];
$clickStats = ['total' => 0, 'whatsapp' => 0, 'instagram' => 0, 'week' => 0];
$leads = [];
$total = 0;
$chartDays = 90;
$chartData = ['since' => date('Y-m-d', strtotime('-' . ($chartDays - 1) . ' days')), 'today' => date('Y-m-d'), 'rows' => [], 'labels' => []];

try {
    $stats = db_lead_stats();
    $clickStats = db_click_stats();
    $total = $stats['total'];
    $leads = db_leads($perPage, ($page - 1) * $perPage);
    foreach (db_contact_series($chartData['since']) as $row) {
        $source = (string) $row['source'];
        $chartData['rows'][] = [$row['day'], $row['canal'], $source, (int) $row['total']];
        $chartData['labels'][$source] = click_source_label($source);
    }
} catch (Throwable $e) {
    $dbError = $e->getMessage();
}

$adminPage = 'leads';
$pageTitle = 'Consultas';
require TPL_ROOT . '/includes/admin-head.php';
require TPL_ROOT . '/includes/admin-nav.php';
require TPL_ROOT . '/views/admin/leads.php';
require TPL_ROOT . '/includes/admin-foot.php';
