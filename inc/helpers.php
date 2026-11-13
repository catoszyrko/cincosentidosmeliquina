<?php
declare(strict_types=1);

function site(): array
{
    static $config;
    if ($config === null) {
        $config = require TPL_ROOT . '/inc/config.php';
    }
    return $config;
}

function company(): array
{
    return site()['company'];
}

function contact(): array
{
    return site()['contact'];
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function emphasize(string $text, string $em = ''): string
{
    $html = e($text);
    if ($em === '' || !str_contains($text, $em)) {
        return $html;
    }
    return str_replace(e($em), '<em>' . e($em) . '</em>', $html);
}

function base_path(): string
{
    static $base;
    if ($base !== null) {
        return $base;
    }

    $configured = trim((string) (company()['base_path'] ?? ''), '/');
    if ($configured !== '') {
        $base = '/' . $configured;
        return $base;
    }

    $project = str_replace('\\', '/', realpath(TPL_ROOT) ?: TPL_ROOT);
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));

    // /sub/hosteria/index.php servido desde {proyecto}/hosteria/index.php → base /sub.
    // No depende de DOCUMENT_ROOT, que en hostings con varios dominios suele apuntar a otra carpeta.
    $file = str_replace('\\', '/', realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) ?: '');
    if ($file !== '' && str_starts_with($file, $project . '/') && basename($file) !== 'router.php') {
        $relative = substr($file, strlen($project));
        if (str_ends_with($script, $relative)) {
            $base = rtrim(substr($script, 0, -strlen($relative)), '/');
            return $base;
        }
    }

    if (str_ends_with($script, '.php')) {
        $dir = rtrim(dirname($script), '/');
        $nested = array_merge(['privacidad', 'admin'], array_column(site()['lodging']['items'], 'slug'));
        if (in_array(basename($dir), $nested, true)) {
            $dir = rtrim(dirname($dir), '/');
        }
        $base = in_array($dir, ['', '.'], true) ? '' : $dir;
        return $base;
    }

    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '');
    if ($docRoot !== '' && str_starts_with($project, $docRoot . '/')) {
        $base = rtrim(substr($project, strlen($docRoot)), '/');
        return $base;
    }

    $base = '';
    return $base;
}

function is_local_request(): bool
{
    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    $host = preg_replace('/:\d+$/', '', $host) ?? $host;
    if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
        return true;
    }
    return (bool) preg_match('/\.(local|test|localhost)$/i', $host);
}

function request_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }
    $forwarded = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
    if ($forwarded === 'https') {
        return true;
    }
    return (int) ($_SERVER['SERVER_PORT'] ?? 0) === 443;
}

function canonical_host(): string
{
    $configured = (string) (company()['canonical_host'] ?? '');
    if ($configured === '') {
        $configured = (string) parse_url((string) (company()['url'] ?? ''), PHP_URL_HOST);
    }
    $host = strtolower(preg_replace('/^www\./i', '', $configured) ?? $configured);
    return $host !== '' ? $host : 'cincosentidosmeliquina.com.ar';
}

function force_canonical_host(): bool
{
    return !empty(company()['force_canonical_host']);
}

function request_host(): string
{
    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    return preg_match('/^[a-z0-9.-]+(:\d+)?$/', $host) ? $host : '';
}

function public_origin(): string
{
    if (!force_canonical_host() && PHP_SAPI !== 'cli' && request_host() !== '') {
        return (request_is_https() ? 'https' : 'http') . '://' . request_host();
    }
    return 'https://' . canonical_host();
}

function origin(): string
{
    if (is_local_request()) {
        $scheme = request_is_https() ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host;
    }
    return public_origin();
}

function enforce_canonical_host(): void
{
    if (PHP_SAPI === 'cli' || is_local_request() || !force_canonical_host()) {
        return;
    }

    $host = strtolower(preg_replace('/:\d+$/', '', (string) ($_SERVER['HTTP_HOST'] ?? '')) ?? '');
    if ($host === canonical_host() && request_is_https()) {
        return;
    }

    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    header('Location: ' . public_origin() . $uri, true, 301);
    header('Cache-Control: no-store');
    exit;
}

function site_url(string $path = ''): string
{
    $prefix = rtrim(origin() . base_path(), '/');
    $path = ltrim($path, '/');

    if ($path === '') {
        return $prefix . '/';
    }

    return $prefix . '/' . $path;
}

function absolute_url(string $path): string
{
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    return origin() . (str_starts_with($path, '/') ? $path : '/' . $path);
}

function public_asset_url(string $path): string
{
    return preg_replace('/\?v=\d+$/', '', absolute_url(asset($path))) ?? absolute_url(asset($path));
}

function url(string $path = ''): string
{
    $hash = '';
    if (str_contains($path, '#')) {
        [$path, $hash] = explode('#', $path, 2);
        $hash = '#' . $hash;
        if ($path === '') {
            $page = $GLOBALS['page'] ?? [];
            $local = ($page['id'] ?? 'home') === 'home'
                || in_array(substr($hash, 1), $page['anchors'] ?? [], true);
            if ($local) {
                return $hash;
            }
            $path = '/';
        }
    }

    if ($path === '' || $path === '/') {
        return (base_path() === '' ? '/' : base_path() . '/') . ltrim($hash, '/');
    }

    if (preg_match('#^https?://#i', $path) || $path === 'whatsapp') {
        return $path === 'whatsapp' ? wa_url() : $path;
    }

    $prefix = base_path() === '' ? '' : rtrim(base_path(), '/');
    $clean = trim($path, '/');
    if (str_ends_with($clean, '.php')) {
        return $prefix . '/' . $clean . $hash;
    }

    return $prefix . '/' . $clean . '/' . ltrim($hash, '/');
}

function asset(string $path): string
{
    $path = ltrim($path, '/');
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    if (!str_starts_with($path, 'assets/')) {
        $path = 'assets/' . $path;
    }

    $full = TPL_ROOT . '/' . $path;
    $url = rtrim(base_path() . '/' . $path, '/');
    if (is_file($full)) {
        $url .= '?v=' . filemtime($full);
    }

    return $url;
}

function img(string $path): string
{
    return asset($path);
}

function wa_url(?string $message = null): string
{
    $c = contact();
    $number = preg_replace('/\D+/', '', $c['whatsapp'] ?? '') ?? '';
    $message = $message ?? ($c['whatsapp_message'] ?? '');
    $url = 'https://wa.me/' . $number;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }
    return $url;
}

function track_attrs(string $canal, string $source = ''): string
{
    $html = ' data-track="' . e($canal) . '"';
    if ($source !== '') {
        $html .= ' data-track-source="' . e($source) . '"';
    }
    return $html;
}

function tracked_link_attrs(string $canal, string $source = ''): string
{
    return ' target="_blank" rel="noopener"' . track_attrs($canal, $source);
}

function canonical_url_for(string $id): string
{
    $prev = $GLOBALS['page'] ?? null;
    $GLOBALS['page'] = [
        'id' => $id,
        'file' => $id === 'home' ? 'index.php' : $id,
    ];
    $url = canonical_url();
    if ($prev === null) {
        unset($GLOBALS['page']);
    } else {
        $GLOBALS['page'] = $prev;
    }
    return $url;
}

function canonical_url(): string
{
    $page = $GLOBALS['page'] ?? [];
    if (!empty($page['canonical'])) {
        return (string) $page['canonical'];
    }

    $id = (string) ($page['id'] ?? '');
    $file = (string) ($page['file'] ?? '');
    $isHome = $id === '' || $id === 'home' || $id === 'error'
        || in_array($file, ['', 'index.php', 'home', '404.php'], true);

    if ($isHome) {
        $path = '/';
    } elseif ($id === 'privacidad' || $file === 'privacidad') {
        $path = '/privacidad/';
    } else {
        $path = '/' . trim((string) preg_replace('/\.php$/', '', $file), '/') . '/';
    }

    return rtrim(origin() . base_path(), '/') . $path;
}

function is_page(string $id): bool
{
    return (($GLOBALS['page']['id'] ?? '') === $id);
}

function theme_css_vars(): string
{
    $colors = site()['colors'];
    $fonts = site()['fonts'];
    $rules = [];
    foreach ($colors as $key => $value) {
        $rules[] = '--' . str_replace('_', '-', $key) . ':' . $value;
    }
    $rules[] = '--font-sans:' . ($fonts['sans'] ?? 'Poppins') . ',system-ui,sans-serif';
    $rules[] = '--font-display:' . ($fonts['display'] ?? 'Oswald') . ',system-ui,sans-serif';
    return ':root{' . implode(';', $rules) . ';}';
}

function section(string $name, array $data = []): void
{
    $file = TPL_ROOT . '/includes/sections/' . $name . '.php';
    if (!is_file($file)) {
        return;
    }
    $site = site();
    extract($data, EXTR_SKIP);
    include $file;
}

function lodging_item(string $slug): ?array
{
    foreach (site()['lodging']['items'] as $item) {
        if (($item['slug'] ?? '') === $slug) {
            return $item;
        }
    }
    return null;
}

function render_house(string $slug): void
{
    $house = lodging_item($slug);
    if ($house === null) {
        http_response_code(404);
        require TPL_ROOT . '/404.php';
        return;
    }

    render('house', [
        'id' => $slug,
        'file' => $slug,
        'title' => $house['seo_title'] ?? ($house['name'] . ' | ' . company()['name']),
        'description' => $house['seo_description'] ?? $house['role'],
        'og_title' => $house['seo_title'] ?? $house['name'],
        'og_description' => $house['seo_description'] ?? $house['role'],
        'og_image' => $house['photo'],
        'og_image_alt' => $house['image_alt'] ?? $house['name'],
        'solid_nav' => true,
        'anchors' => !empty($house['booking']) ? ['reservas'] : [],
        'form_redirect' => '/' . $slug . '/',
        'house' => $house,
    ]);
}

function render(string $view, array $page = []): void
{
    $GLOBALS['page'] = $page;
    $site = site();
    require TPL_ROOT . '/includes/head.php';
    require TPL_ROOT . '/includes/header.php';
    $viewFile = TPL_ROOT . '/views/' . $view . '.php';
    if (is_file($viewFile)) {
        require $viewFile;
    }
    require TPL_ROOT . '/includes/footer.php';
}

function icon(string $name, string $class = 'ico'): string
{
    $icons = [
        'play' => '<polygon points="6 4 20 12 6 20 6 4"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'award' => '<circle cx="12" cy="8" r="6"/><path d="M8.2 13.5 7 22l5-3 5 3-1.2-8.5"/>',
        'mic' => '<path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/>',
        'globe' => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20"/><path d="M12 2a15 15 0 0 0 0 20"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'arrow' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'star' => '<polygon points="12 2 15.1 8.3 22 9.3 17 14.1 18.2 21 12 17.8 5.8 21 7 14.1 2 9.3 8.9 8.3 12 2"/>',
        'mail' => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.81.32 1.6.57 2.36a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.72-1.14a2 2 0 0 1 2.11-.45c.76.25 1.55.44 2.36.57A2 2 0 0 1 22 16.92z"/>',
        'pin' => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'whatsapp' => '<path fill="currentColor" stroke="none" d="M20.5 3.5A11.8 11.8 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.6 4.2 1.6 6L0 24l6.2-1.6A11.9 11.9 0 0 0 12 24c6.6 0 12-5.4 12-12 0-3.2-1.3-6.2-3.5-8.5ZM12 22a9.9 9.9 0 0 1-5-1.4l-.4-.2-3.7.9.9-3.6-.2-.4A9.9 9.9 0 0 1 2 12C2 6.5 6.5 2 12 2s10 4.5 10 10-4.5 10-10 10Zm5.5-7.4c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2s-.8 1-.9 1.1-.4.2-.7 0a8.1 8.1 0 0 1-2.4-1.5 8.9 8.9 0 0 1-1.6-2c-.2-.3 0-.5.1-.6l.4-.5.2-.3c.1-.2 0-.4 0-.5l-.7-1.8c-.2-.4-.4-.4-.7-.4h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.4 1.1 2.8 1.2 3c.2.2 2.1 3.2 5.1 4.5 1.8.8 2.3.8 3.1.7.5-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4 0-.2-.2-.3-.5-.4Z"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>',
        'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'tiktok' => '<path d="M14 3v11.2a3.2 3.2 0 1 1-2.4-3.1V8.2A7 7 0 0 0 18 10V6.4A7 7 0 0 1 14 3Z"/>',
        'linkedin' => '<path fill="currentColor" stroke="none" d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9" fill="currentColor" stroke="none"/><circle cx="4" cy="4" r="2" fill="currentColor" stroke="none"/>',
        'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'close' => '<path d="M18 6 6 18M6 6l12 12"/>',
        'home' => '<path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z"/>',
        'droplet' => '<path d="M12 2.7S6 9 6 13.2A6 6 0 0 0 18 13.2C18 9 12 2.7 12 2.7Z"/>',
        'anchor' => '<circle cx="12" cy="5" r="2"/><path d="M12 7v14"/><path d="M5 15H3a9 9 0 0 0 18 0h-2"/><path d="M8 12h8"/>',
        'boat' => '<path d="M3 17c1.5 2 4.5 3 9 3s7.5-1 9-3"/><path d="M4 14h16l-1.2 3H5.2Z"/><path d="M12 4v7"/><path d="M8 8h8"/>',
        'flame' => '<path d="M12 3c2 3 3 5 3 7a3 3 0 0 1-6 0c0 .8-.5 1.8-1.5 2.8C6 14.2 5 16 5 18a7 7 0 0 0 14 0c0-4-3-7-7-15Z"/>',
        'wifi' => '<path d="M5 12.5a10 10 0 0 1 14 0"/><path d="M8.5 16a5.5 5.5 0 0 1 7 0"/><path d="M12 20h.01"/>',
        'leaf' => '<path d="M11 20A7 7 0 0 1 4 13C4 7 12 4 20 4c0 8-3 16-9 16Z"/><path d="M12 20c0-6 2-10 8-13"/>',
        'bed' => '<path d="M3 18v-6a3 3 0 0 1 3-3h13v9"/><path d="M3 18h18"/><path d="M6 9V6h7v3"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'cup' => '<path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><path d="M6 2v2M10 2v2M14 2v2"/>',
        'tv' => '<rect width="20" height="14" x="2" y="3" rx="2"/><path d="M8 21h8M12 17v4"/>',
        'sparkle' => '<path d="M12 3l1.9 5.8L20 11l-6.1 2.2L12 19l-1.9-5.8L4 11l6.1-2.2Z"/>',
        'car' => '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>',
        'fish' => '<path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"/><path d="M18 12v.5"/><path d="M7 10.67C7 8 5.58 5.97 2.73 5.5c-1 1.5-1 5 .23 6.5-1.24 1.5-1.24 5-.23 6.5C5.58 18.03 7 16 7 13.33"/>',
        'snow' => '<path d="M12 2v20M2 12h20M4.9 4.9l14.2 14.2M19.1 4.9 4.9 19.1"/><path d="m9 4 3 2 3-2M9 20l3-2 3 2M4 9l2 3-2 3M20 9l-2 3 2 3"/>',
        'bike' => '<circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>',
        'mountain' => '<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>',
        'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/>',
        'calendar' => '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
    ];

    $path = $icons[$name] ?? $icons['arrow'];
    $fill = in_array($name, ['whatsapp', 'linkedin', 'star'], true) ? 'currentColor' : 'none';
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="' . $fill . '" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

function google_mark(string $class = 'google-mark'): string
{
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.4h6.5c-.3 1.5-1.2 2.8-2.5 3.6v3h4c2.4-2.2 3.5-5.4 3.5-8.7z"/><path fill="#34A853" d="M12 24c3.2 0 6-1.1 8-2.9l-4-3.1c-1.1.7-2.5 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.3v3.1C3.3 21.3 7.4 24 12 24z"/><path fill="#FBBC05" d="M5.4 14.3c-.2-.7-.4-1.5-.4-2.3s.1-1.6.4-2.3V6.6H1.3C.5 8.3 0 10.1 0 12s.5 3.7 1.3 5.4l4.1-3.1z"/><path fill="#EA4335" d="M12 4.8c1.8 0 3.3.6 4.6 1.8l3.4-3.4C18 1.1 15.2 0 12 0 7.4 0 3.3 2.7 1.3 6.6l4.1 3.1C6.3 6.9 8.9 4.8 12 4.8z"/></svg>';
}

function stars_html(int $count = 5, string $class = 'stars'): string
{
    $count = max(0, min(5, $count));
    $out = '<span class="' . e($class) . '" aria-label="' . e((string) $count) . ' de 5 estrellas">';
    for ($i = 0; $i < 5; $i++) {
        $out .= icon('star', 'ico ico-star' . ($i < $count ? ' is-on' : ''));
    }
    return $out . '</span>';
}

function form_field(array $field): void
{
    $name = $field['name'];
    $type = $field['type'] ?? 'text';
    $attrs = $field['attrs'] ?? [];
    ?>
    <label class="field">
      <span><?= e($field['label']) ?></span>
      <?php if ($type === 'textarea'): ?>
        <textarea name="<?= e($name) ?>" placeholder="<?= e($field['placeholder'] ?? '') ?>" rows="2" <?= !empty($field['required']) ? 'required' : '' ?>></textarea>
      <?php elseif ($type === 'select'): ?>
        <select name="<?= e($name) ?>" <?= !empty($field['required']) ? 'required' : '' ?>>
          <?php foreach (($field['options'] ?? []) as $optVal => $optLabel): ?>
            <option value="<?= e((string) $optVal) ?>"<?= isset($field['value']) && (string) $field['value'] === (string) $optVal ? ' selected' : '' ?>><?= e($optLabel) ?></option>
          <?php endforeach; ?>
        </select>
      <?php else: ?>
        <input
          type="<?= e($type) ?>"
          name="<?= e($name) ?>"
          placeholder="<?= e($field['placeholder'] ?? '') ?>"
          <?= !empty($field['required']) ? 'required' : '' ?>
          autocomplete="<?= e($field['autocomplete'] ?? 'on') ?>"
          <?php foreach ($attrs as $attr => $val): ?>
            <?= e((string) $attr) ?>="<?= e((string) $val) ?>"
          <?php endforeach; ?>
        >
      <?php endif; ?>
    </label>
    <?php
}

function schema_json(): string
{
    $co = company();
    $c = contact();
    $page = $GLOBALS['page'] ?? [];
    $sameAs = array_values(array_filter([
        $c['instagram'] ?? '',
        $c['facebook'] ?? '',
        $c['tiktok'] ?? '',
        $c['linkedin'] ?? '',
    ]));

    $schema = site()['schema'] ?? [];
    $address = [
        '@type' => 'PostalAddress',
        'streetAddress' => $c['address_short'] ?? ($c['address'] ?? ''),
        'addressLocality' => $schema['locality'] ?? '',
        'addressRegion' => $schema['region'] ?? '',
        'postalCode' => $schema['postal_code'] ?? '',
        'addressCountry' => 'AR',
    ];
    $geo = [
        '@type' => 'GeoCoordinates',
        'latitude' => $c['lat'] ?? '',
        'longitude' => $c['lng'] ?? '',
    ];

    $org = [
        '@type' => $schema['type'] ?? 'LodgingBusiness',
        '@id' => site_url() . '#organization',
        'name' => $co['name'],
        'alternateName' => array_values(array_filter(array_merge([$co['short'] ?? ''], $schema['alternate_names'] ?? []))),
        'description' => site()['seo']['description'] ?? '',
        'url' => site_url(),
        'logo' => public_asset_url($co['logo']),
        'image' => public_asset_url($co['og_image'] ?? $co['logo']),
        'telephone' => $c['phone'] ?? ('+' . preg_replace('/\D+/', '', $c['whatsapp'] ?? '')),
        'sameAs' => $sameAs,
        'keywords' => site()['seo']['keywords'] ?? '',
        'address' => $address,
        'geo' => $geo,
        'hasMap' => $c['maps_url'] ?? '',
        'amenityFeature' => array_map(static fn (string $name): array => [
            '@type' => 'LocationFeatureSpecification',
            'name' => $name,
            'value' => true,
        ], $schema['amenities'] ?? []),
    ];
    if (!empty($c['email'])) {
        $org['email'] = $c['email'];
    }
    if (!empty($co['founded'])) {
        $org['foundingDate'] = (string) $co['founded'];
    }

    $pageId = (string) ($page['id'] ?? 'home');
    $isHome = $pageId === 'home';
    $graph = [$org];
    if (!empty($schema['cafe'])) {
        $cafe = [
            '@type' => 'CafeOrCoffeeShop',
            '@id' => site_url() . '#casa-de-te',
            'name' => $schema['cafe']['name'],
            'servesCuisine' => $schema['cafe']['cuisine'] ?? '',
            'openingHours' => $schema['cafe']['opening_hours'] ?? '',
            'url' => canonical_url_for('casa-de-te'),
            'image' => public_asset_url($schema['cafe']['image'] ?? 'img/tea/casa-de-te-salon-ventanales.jpg'),
            'telephone' => $org['telephone'],
            'address' => $address,
            'geo' => $geo,
            'hasMap' => $c['maps_url'] ?? '',
            'parentOrganization' => ['@id' => site_url() . '#organization'],
        ];
        if (preg_match('/^(Mo|Tu|We|Th|Fr|Sa|Su)-(Mo|Tu|We|Th|Fr|Sa|Su) (\d{2}:\d{2})-(\d{2}:\d{2})$/', (string) ($schema['cafe']['opening_hours'] ?? ''), $m)) {
            $days = ['Mo' => 'Monday', 'Tu' => 'Tuesday', 'We' => 'Wednesday', 'Th' => 'Thursday', 'Fr' => 'Friday', 'Sa' => 'Saturday', 'Su' => 'Sunday'];
            $keys = array_keys($days);
            $range = array_slice($keys, array_search($m[1], $keys, true), array_search($m[2], $keys, true) - array_search($m[1], $keys, true) + 1);
            $cafe['openingHoursSpecification'] = [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array_map(static fn (string $d): string => 'https://schema.org/' . $days[$d], $range),
                'opens' => $m[3],
                'closes' => $m[4],
            ]];
        }
        $graph[] = $cafe;
    }
    $graph[] = [
            '@type' => 'WebSite',
            '@id' => site_url() . '#website',
            'url' => site_url(),
            'name' => $co['name'],
            'alternateName' => $co['tagline'] ?? '',
            'inLanguage' => $co['locale'] ?? 'es-AR',
            'publisher' => ['@id' => site_url() . '#organization'],
    ];

    if ($pageId !== 'error') {
        $webPage = [
            '@type' => 'WebPage',
            '@id' => canonical_url() . '#webpage',
            'url' => canonical_url(),
            'name' => $page['title'] ?? ($co['name'] ?? ''),
            'description' => $page['description'] ?? '',
            'inLanguage' => $co['locale'] ?? 'es-AR',
            'isPartOf' => ['@id' => site_url() . '#website'],
            'about' => ['@id' => $pageId === 'casa-de-te' && !empty($schema['cafe']) ? site_url() . '#casa-de-te' : site_url() . '#organization'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => public_asset_url((string) ($page['og_image'] ?? $co['og_image'])),
            ],
        ];
        if (!empty($page['house']['name'])) {
            $crumb = $page['house']['name'];
            $webPage['breadcrumb'] = ['@id' => canonical_url() . '#breadcrumb'];
            $graph[] = $webPage;
            $graph[] = [
                '@type' => 'BreadcrumbList',
                '@id' => canonical_url() . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => canonical_url_for('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $crumb, 'item' => canonical_url()],
                ],
            ];
        } else {
            $graph[] = $webPage;
        }
    }

    if ($isHome && !empty(site()['faq']['items'])) {
        $graph[] = [
            '@type' => 'FAQPage',
            '@id' => site_url() . '#faq',
            'mainEntity' => array_map(static function (array $item): array {
                return [
                    '@type' => 'Question',
                    'name' => $item['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['a'],
                    ],
                ];
            }, site()['faq']['items']),
        ];
    }

    return json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
