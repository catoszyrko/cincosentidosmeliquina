<?php
declare(strict_types=1);

function db_config(): array
{
    $local = site()['database_local'] ?? [];
    $requestHost = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    if ($local && in_array($requestHost, $local['hosts'] ?? [], true)) {
        return $local;
    }
    return site()['database'] ?? [];
}

function db(): PDO
{
    static $pdo;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = db_config();
    $host = trim((string) ($cfg['host'] ?? 'localhost'));
    $name = trim((string) ($cfg['name'] ?? ''));
    $user = trim((string) ($cfg['user'] ?? ''));
    $pass = (string) ($cfg['pass'] ?? '');
    $charset = trim((string) ($cfg['charset'] ?? 'utf8mb4'));
    $port = (int) ($cfg['port'] ?? 3306);

    if ($name === '' || $user === '') {
        throw new RuntimeException('Completá host, name y user de la base en inc/config.php (clave database).');
    }

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $hosts = [$host];
    if ($host === 'localhost') {
        $hosts[] = '127.0.0.1';
    }

    $last = null;
    foreach ($hosts as $tryHost) {
        try {
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $tryHost, $port, $name, $charset);
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (PDOException $e) {
            $last = $e;
        }
    }

    throw $last ?? new RuntimeException('No se pudo conectar a MySQL.');
}

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}

function client_ua(): string
{
    return substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);
}

function request_path(): string
{
    $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
    $path = parse_url($uri, PHP_URL_PATH);
    return substr(is_string($path) && $path !== '' ? $path : '/', 0, 255);
}

function db_save_lead(array $data): void
{
    $sql = 'INSERT INTO leads
        (nombre, contacto, huespedes, checkin, checkout, casa, mensaje, pagina, ip, user_agent, created_at)
        VALUES (:nombre, :contacto, :huespedes, :checkin, :checkout, :casa, :mensaje, :pagina, :ip, :user_agent, :created_at)';
    $stmt = db()->prepare($sql);
    $huespedes = isset($data['huespedes']) && $data['huespedes'] !== '' ? (int) $data['huespedes'] : null;
    $checkin = trim((string) ($data['checkin'] ?? ''));
    $checkout = trim((string) ($data['checkout'] ?? ''));
    $casa = trim((string) ($data['casa'] ?? ''));
    $mensaje = trim((string) ($data['mensaje'] ?? ''));
    $contacto = trim((string) ($data['contacto'] ?? ''));

    $stmt->execute([
        ':nombre' => (string) ($data['nombre'] ?? ''),
        ':contacto' => $contacto !== '' ? $contacto : null,
        ':huespedes' => $huespedes,
        ':checkin' => $checkin !== '' ? $checkin : null,
        ':checkout' => $checkout !== '' ? $checkout : null,
        ':casa' => $casa !== '' ? $casa : null,
        ':mensaje' => $mensaje !== '' ? $mensaje : null,
        ':pagina' => substr((string) ($data['pagina'] ?? request_path()), 0, 255),
        ':ip' => client_ip(),
        ':user_agent' => client_ua(),
        ':created_at' => date('Y-m-d H:i:s'),
    ]);
}

function db_save_click(string $canal, string $source = '', string $pagina = ''): void
{
    $canal = strtolower($canal);
    if (!in_array($canal, ['whatsapp', 'instagram'], true)) {
        return;
    }

    $source = preg_replace('/[^a-z0-9_-]/i', '', $source) ?? '';
    $source = substr($source, 0, 80);
    $pagina = substr($pagina !== '' ? $pagina : request_path(), 0, 255);

    $sql = 'INSERT INTO clicks (canal, source, pagina, ip, user_agent, created_at)
            VALUES (:canal, :source, :pagina, :ip, :user_agent, :created_at)';
    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':canal' => $canal,
        ':source' => $source !== '' ? $source : null,
        ':pagina' => $pagina,
        ':ip' => client_ip(),
        ':user_agent' => client_ua(),
        ':created_at' => date('Y-m-d H:i:s'),
    ]);
}

function db_count(string $table, string $where = '', array $params = []): int
{
    $sql = 'SELECT COUNT(*) FROM ' . $table;
    if ($where !== '') {
        $sql .= ' WHERE ' . $where;
    }
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}

function db_lead_stats(): array
{
    return [
        'total' => db_count('leads'),
        'week' => db_count('leads', 'created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'),
        'month' => db_count('leads', 'created_at >= DATE_FORMAT(NOW(), \'%Y-%m-01\')'),
    ];
}

function db_click_stats(): array
{
    $stmt = db()->query("SELECT canal, COUNT(*) AS total FROM clicks GROUP BY canal");
    $byCanal = ['whatsapp' => 0, 'instagram' => 0];
    foreach ($stmt->fetchAll() as $row) {
        $canal = (string) ($row['canal'] ?? '');
        if (isset($byCanal[$canal])) {
            $byCanal[$canal] = (int) $row['total'];
        }
    }

    return [
        'total' => $byCanal['whatsapp'] + $byCanal['instagram'],
        'whatsapp' => $byCanal['whatsapp'],
        'instagram' => $byCanal['instagram'],
        'week' => db_count('clicks', 'created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'),
    ];
}

function db_leads(int $limit, int $offset): array
{
    $stmt = db()->prepare('SELECT * FROM leads ORDER BY created_at DESC, id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', max(1, $limit), PDO::PARAM_INT);
    $stmt->bindValue(':offset', max(0, $offset), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function db_leads_all(): array
{
    return db()->query('SELECT * FROM leads ORDER BY created_at DESC, id DESC')->fetchAll();
}

function db_clicks(int $limit, int $offset): array
{
    $stmt = db()->prepare('SELECT * FROM clicks ORDER BY created_at DESC, id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', max(1, $limit), PDO::PARAM_INT);
    $stmt->bindValue(':offset', max(0, $offset), PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Contactos por día, canal y origen desde $since (Y-m-d).
 * Los clicks de WhatsApp con origen "form" se excluyen: son la apertura
 * de WhatsApp posterior a una consulta ya contada en leads.
 */
function db_contact_series(string $since): array
{
    $stmt = db()->prepare("SELECT DATE(created_at) AS day, 'form' AS canal, 'form' AS source, COUNT(*) AS total
                           FROM leads WHERE created_at >= :since1
                           GROUP BY day
                           UNION ALL
                           SELECT DATE(created_at) AS day, canal, COALESCE(source, '') AS source, COUNT(*) AS total
                           FROM clicks
                           WHERE created_at >= :since2 AND NOT (canal = 'whatsapp' AND source = 'form')
                           GROUP BY day, canal, source");
    $stmt->execute([':since1' => $since, ':since2' => $since]);
    return $stmt->fetchAll();
}

function db_clicks_by_source(): array
{
    $stmt = db()->query('SELECT canal, COALESCE(source, \'\') AS source, COUNT(*) AS total
                         FROM clicks GROUP BY canal, source ORDER BY total DESC');
    return $stmt->fetchAll();
}
