<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/bootstrap.php';

header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

$token = (string) ($_GET['token'] ?? '');
if (!migrate_token_ok($token)) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Token inválido.';
    exit;
}

function migrate_run_sql(PDO $pdo, string $sql): void
{
    $sql = preg_replace('/^\s*--.*$/m', '', $sql) ?? $sql;
    foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
        $pdo->exec($statement);
    }
}

$results = [];
$ok = true;

try {
    $pdo = db();
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS schema_migrations (
            filename VARCHAR(190) NOT NULL,
            applied_at DATETIME NOT NULL,
            PRIMARY KEY (filename)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $appliedStmt = $pdo->query('SELECT filename FROM schema_migrations');
    $applied = array_flip($appliedStmt->fetchAll(PDO::FETCH_COLUMN));

    $files = glob(TPL_ROOT . '/migrations/*.sql') ?: [];
    sort($files);

    if ($files === []) {
        $results[] = ['file' => '—', 'status' => 'skip', 'detail' => 'No hay ficheros en /migrations.'];
    }

    $insert = $pdo->prepare('INSERT INTO schema_migrations (filename, applied_at) VALUES (:filename, :applied_at)');

    foreach ($files as $path) {
        $name = basename($path);
        if (isset($applied[$name])) {
            $results[] = ['file' => $name, 'status' => 'skip', 'detail' => 'Ya aplicada.'];
            continue;
        }

        $sql = file_get_contents($path);
        if ($sql === false || trim($sql) === '') {
            $results[] = ['file' => $name, 'status' => 'error', 'detail' => 'El fichero está vacío o no se pudo leer.'];
            $ok = false;
            continue;
        }

        try {
            migrate_run_sql($pdo, $sql);
            $insert->execute([
                ':filename' => $name,
                ':applied_at' => date('Y-m-d H:i:s'),
            ]);
            $results[] = ['file' => $name, 'status' => 'ok', 'detail' => 'Aplicada.'];
        } catch (Throwable $e) {
            $ok = false;
            $results[] = ['file' => $name, 'status' => 'error', 'detail' => $e->getMessage()];
        }
    }
} catch (Throwable $e) {
    $ok = false;
    $results[] = ['file' => 'conexión', 'status' => 'error', 'detail' => $e->getMessage()];
}

http_response_code($ok ? 200 : 500);
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Migraciones</title>
  <style>
    body{font-family:system-ui,sans-serif;background:#f3f7f4;color:#24302c;margin:0;padding:2rem}
    main{max-width:42rem;margin:0 auto;background:#fff;border:1px solid #dbe5df;border-radius:1.1rem;padding:1.4rem 1.5rem}
    h1{font-size:1.35rem;margin:0 0 .8rem}
    li{margin:.45rem 0;padding:.55rem .7rem;border-radius:.7rem;list-style:none}
    ul{padding:0;margin:0}
    .ok{background:#e8fff6}
    .skip{background:#f3f7f4}
    .error{background:#ffe8e8}
    p{margin:1rem 0 0;color:#5d6b66}
  </style>
</head>
<body>
  <main>
    <h1>Migraciones</h1>
    <ul>
      <?php foreach ($results as $row): ?>
        <li class="<?= e($row['status']) ?>">
          <strong><?= e($row['file']) ?></strong> — <?= e($row['detail']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <p><?= $ok ? 'Listo.' : 'Revisá el error y volvé a correr la ruta.' ?></p>
  </main>
</body>
</html>
