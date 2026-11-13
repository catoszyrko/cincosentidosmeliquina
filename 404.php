<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';
http_response_code(404);
render('404', [
    'id' => 'error',
    'file' => '404.php',
    'title' => 'Página no encontrada | ' . company()['name'],
    'description' => 'La página que buscás no existe.',
    'robots' => 'noindex, follow',
    'solid_nav' => true,
]);
