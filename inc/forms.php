<?php
declare(strict_types=1);

function csrf_token(): string
{
    if (empty($_SESSION['tpl_csrf'])) {
        $_SESSION['tpl_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['tpl_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(?string $token): bool
{
    $stored = $_SESSION['tpl_csrf'] ?? '';
    return is_string($token) && $stored !== '' && hash_equals($stored, $token);
}

function form_status(): array
{
    $ok = ($_GET['enviado'] ?? '') === '1';
    $err = ($_GET['error'] ?? '') === '1';
    $errors = $_SESSION['tpl_form_errors'] ?? [];
    $old = $_SESSION['tpl_form_old'] ?? [];
    if ($ok || $err) {
        unset($_SESSION['tpl_form_errors'], $_SESSION['tpl_form_old']);
    }
    return [
        'ok' => $ok,
        'error' => $err,
        'errors' => is_array($errors) ? $errors : [],
        'old' => is_array($old) ? $old : [],
    ];
}

function format_lead_date(string $value): string
{
    if ($value === '') {
        return '';
    }
    $dt = DateTime::createFromFormat('Y-m-d', $value);
    return $dt instanceof DateTime ? $dt->format('d/m/Y') : $value;
}

function lead_room_options(): array
{
    foreach (site()['form']['fields'] as $field) {
        if ($field['name'] === 'casa') {
            return $field['options'] ?? [];
        }
    }
    return [];
}

function build_wa_message(array $data): string
{
    $form = site()['form'];
    $contacto = trim((string) ($data['contacto'] ?? ''));
    $lines = array_filter([
        $form['wa_intro'] ?? contact()['whatsapp_message'],
        'Nombre: ' . ($data['nombre'] ?? ''),
        $contacto !== '' ? 'Contacto: ' . $contacto : null,
        'Cantidad de personas: ' . ($data['huespedes'] ?? ''),
        'Llegada: ' . format_lead_date((string) ($data['checkin'] ?? '')),
        'Salida: ' . format_lead_date((string) ($data['checkout'] ?? '')),
        ($form['room_label'] ?? 'Habitación') . ': ' . (($data['casa'] ?? '') !== '' ? $data['casa'] : 'A definir'),
    ]);
    $extra = trim((string) ($data['mensaje'] ?? ''));
    if ($extra !== '') {
        $lines[] = 'Mensaje: ' . $extra;
    }
    return implode("\n", $lines);
}

function validate_lead(array $post): array
{
    $data = [
        'nombre' => trim((string) ($post['nombre'] ?? '')),
        'contacto' => trim((string) ($post['contacto'] ?? '')),
        'huespedes' => trim((string) ($post['huespedes'] ?? '')),
        'checkin' => trim((string) ($post['checkin'] ?? '')),
        'checkout' => trim((string) ($post['checkout'] ?? '')),
        'casa' => trim((string) ($post['casa'] ?? '')),
        'mensaje' => trim((string) ($post['mensaje'] ?? '')),
    ];
    $errors = [];

    if (strlen($data['nombre']) < 2) {
        $errors['nombre'] = 'Ingresá tu nombre.';
    }

    $huespedes = filter_var($data['huespedes'], FILTER_VALIDATE_INT);
    if ($huespedes === false || $huespedes < 1 || $huespedes > 20) {
        $errors['huespedes'] = 'Ingresá la cantidad de personas.';
    } else {
        $data['huespedes'] = (string) $huespedes;
    }

    foreach (['checkin' => 'fecha de entrada', 'checkout' => 'fecha de salida'] as $field => $label) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data[$field])) {
            $errors[$field] = 'Ingresá una ' . $label . ' válida.';
        }
    }

    if (empty($errors['checkin']) && empty($errors['checkout']) && $data['checkout'] < $data['checkin']) {
        $errors['checkout'] = 'La salida tiene que ser posterior a la entrada.';
    }

    $allowedRooms = array_map('strval', array_keys(lead_room_options()));
    if (!in_array($data['casa'], $allowedRooms, true)) {
        $data['casa'] = '';
    }

    $data['contacto'] = mb_substr(preg_replace('/\s+/', ' ', $data['contacto']) ?? '', 0, 120);

    if (strlen($data['mensaje']) > 2000) {
        $data['mensaje'] = substr($data['mensaje'], 0, 2000);
    }

    return [$data, $errors];
}

function store_lead(array $data): void
{
    $payload = $data + [
        'fecha' => date('c'),
        'pagina' => request_path(),
        'ip' => client_ip(),
    ];

    try {
        db_save_lead($payload);
        return;
    } catch (Throwable $e) {
        // Si la base no está lista, queda copia local para no perder la consulta.
    }

    $dir = TPL_ROOT . '/data/leads';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }
    $file = $dir . '/' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.json';
    @file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function store_click(string $canal, string $source = '', string $pagina = ''): void
{
    try {
        db_save_click($canal, $source, $pagina);
    } catch (Throwable $e) {
        // El click no debe cortar la salida a WhatsApp o Instagram.
    }
}

function send_lead_mail(array $data): void
{
    $to = trim((string) (contact()['email'] ?? ''));
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return;
    }
    $name = company()['name'];
    $subject = '=?UTF-8?B?' . base64_encode('Consulta web — ' . $name) . '?=';
    $body = "Nueva consulta desde la web de {$name}\n\n";
    foreach ($data as $key => $value) {
        $body .= ucfirst($key) . ': ' . $value . "\n";
    }
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $headers = implode("\r\n", [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' Web <noreply@' . $host . '>',
        'Reply-To: ' . $name . ' <' . $to . '>',
        'X-Mailer: PHP/' . PHP_VERSION,
    ]);
    @mail($to, $subject, $body, $headers);
}
