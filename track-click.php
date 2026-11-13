<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';

header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    json_response(['ok' => false, 'error' => 'Método no permitido.'], 405);
}

$payload = request_payload();
$canal = strtolower(trim((string) ($payload['canal'] ?? '')));
if (!in_array($canal, ['whatsapp', 'instagram'], true)) {
    json_response(['ok' => false, 'error' => 'Canal inválido.'], 400);
}

$source = (string) ($payload['source'] ?? '');
$pagina = (string) ($payload['pagina'] ?? '');
store_click($canal, $source, $pagina);
json_response(['ok' => true]);
