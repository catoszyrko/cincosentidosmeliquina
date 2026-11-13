<?php
declare(strict_types=1);

function admin_email(): string
{
    return strtolower(trim((string) (site()['admin']['email'] ?? '')));
}

function admin_logged_in(): bool
{
    return !empty($_SESSION['tpl_admin']['ok']);
}

function require_admin(): void
{
    if (admin_logged_in()) {
        return;
    }
    header('Location: ' . url('admin'));
    exit;
}

function admin_credentials_ok(string $email, string $password): bool
{
    $expectedEmail = admin_email();
    $expectedPass = (string) (site()['admin']['password'] ?? '');
    if ($expectedEmail === '' || $expectedPass === '') {
        return false;
    }
    return hash_equals($expectedEmail, strtolower(trim($email)))
        && hash_equals($expectedPass, $password);
}

function migrate_token_ok(string $token): bool
{
    $expected = (string) (site()['admin']['migrate_token'] ?? site()['admin']['password'] ?? '');
    return $expected !== '' && hash_equals($expected, $token);
}

function admin_login(string $email): void
{
    session_regenerate_id(true);
    $_SESSION['tpl_admin'] = [
        'ok' => true,
        'email' => $email,
        'at' => time(),
    ];
}

function admin_logout(): void
{
    unset($_SESSION['tpl_admin']);
    session_regenerate_id(true);
}

function click_source_label(string $source): string
{
    $map = [
        'form' => 'Formulario',
        'header' => 'Encabezado',
        'nav-mobile' => 'Menú móvil',
        'float' => 'Botón flotante',
        'footer' => 'Pie de página',
        'hero' => 'Inicio',
        'lodging' => 'Propuesta',
        'lodging-hosteria' => 'Propuesta · Hostería',
        'lodging-casa-de-te' => 'Propuesta · Casa de Té',
        'method' => 'Casa de Té',
        'booking' => 'Reservas',
        'gallery' => 'Galería',
        'house-hosteria' => 'Página Hostería',
        'house-casa-de-te' => 'Página Casa de Té',
        'house-casa-de-te-visit' => 'Página Casa de Té · Visita',
        'cta' => 'Llamado a la acción',
        'location' => 'Ubicación',
        '404' => 'Página 404',
    ];
    return $map[$source] ?? ($source !== '' ? $source : 'Directo');
}

function lead_contact_html(?string $contacto): string
{
    $contacto = trim((string) $contacto);
    if ($contacto === '') {
        return '—';
    }
    if (filter_var($contacto, FILTER_VALIDATE_EMAIL)) {
        return '<a class="admin-contact is-email" href="mailto:' . e($contacto) . '">' . e($contacto) . '</a>';
    }
    $digits = preg_replace('/\D+/', '', $contacto) ?? '';
    if (strlen($digits) >= 8 && strlen($digits) <= 15) {
        return '<a class="admin-contact is-whatsapp" href="https://wa.me/' . e($digits) . '" target="_blank" rel="noopener">' . e($contacto) . '</a>';
    }
    return e($contacto);
}

function admin_pagination(int $total, int $page, int $perPage, string $base): string
{
    $pages = max(1, (int) ceil($total / $perPage));
    if ($pages <= 1) {
        return '';
    }
    $page = min($pages, max(1, $page));
    $html = '<nav class="admin-pager" aria-label="Paginación">';
    if ($page > 1) {
        $html .= '<a href="' . e($base . ($page - 1)) . '">Anterior</a>';
    }
    $html .= '<span>Página ' . $page . ' de ' . $pages . '</span>';
    if ($page < $pages) {
        $html .= '<a href="' . e($base . ($page + 1)) . '">Siguiente</a>';
    }
    return $html . '</nav>';
}

function json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function request_payload(): array
{
    $contentType = strtolower((string) ($_SERVER['CONTENT_TYPE'] ?? ''));
    if (str_contains($contentType, 'application/json')) {
        $raw = file_get_contents('php://input') ?: '';
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
    return $_POST;
}

function wants_json(): bool
{
    $accept = strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? ''));
    $contentType = strtolower((string) ($_SERVER['CONTENT_TYPE'] ?? ''));
    $xhr = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));
    return str_contains($contentType, 'application/json')
        || str_contains($accept, 'application/json')
        || in_array($xhr, ['fetch', 'xmlhttprequest'], true);
}
