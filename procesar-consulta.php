<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    if (wants_json()) {
        json_response(['ok' => false, 'error' => 'Método no permitido.'], 405);
    }
    header('Location: ' . url('/'));
    exit;
}

$payload = request_payload();
$asJson = wants_json();

if (trim((string) ($payload['website'] ?? '')) !== '') {
    if ($asJson) {
        json_response(['ok' => true]);
    }
    header('Location: ' . url('/') . '?enviado=1#reservas');
    exit;
}

if (!verify_csrf(isset($payload['csrf_token']) ? (string) $payload['csrf_token'] : null)) {
    if ($asJson) {
        json_response(['ok' => false, 'error' => 'La sesión expiró. Recargá la página.'], 400);
    }
    $_SESSION['tpl_form_errors'] = ['csrf' => 'La sesión expiró. Volvé a enviar el formulario.'];
    $_SESSION['tpl_form_old'] = $payload;
    header('Location: ' . url('/') . '?error=1#reservas');
    exit;
}

[$data, $errors] = validate_lead($payload);

if ($errors) {
    if ($asJson) {
        json_response(['ok' => false, 'errors' => $errors], 422);
    }
    $_SESSION['tpl_form_errors'] = $errors;
    $_SESSION['tpl_form_old'] = $data;
    header('Location: ' . url('/') . '?error=1#reservas');
    exit;
}

unset($_SESSION['tpl_form_errors'], $_SESSION['tpl_form_old']);
store_lead($data);
store_click('whatsapp', 'form');
send_lead_mail($data);

if ($asJson) {
    json_response([
        'ok' => true,
        'whatsapp' => wa_url(build_wa_message($data)),
    ]);
}

header('Location: ' . wa_url(build_wa_message($data)));
exit;
