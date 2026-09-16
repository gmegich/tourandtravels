<?php
/**
 * One-shot Supabase setup: apply schema + seed, then upsert admin.
 *
 * Usage (from project root):
 *   C:\xampp\php\php.exe scripts\run_supabase_setup.php
 *
 * Requires DB_PASS in .env (not the YOUR_DATABASE_PASSWORD placeholder).
 */
declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/config.php';
require_once $root . '/includes/db.php';

function out(string $msg): void
{
    fwrite(STDOUT, $msg . PHP_EOL);
}

function fail(string $msg, int $code = 1): never
{
    fwrite(STDERR, 'ERROR: ' . $msg . PHP_EOL);
    exit($code);
}

/**
 * Split SQL into executable statements, skipping pure comment / empty chunks.
 * Handles $$ ... $$ dollar-quoted blocks used by Postgres functions.
 */
function split_sql_statements(string $sql): array
{
    $statements = [];
    $buf = '';
    $len = strlen($sql);
    $inDollar = false;
    $dollarTag = '';

    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i];

        if (!$inDollar && $ch === '-' && ($i + 1) < $len && $sql[$i + 1] === '-') {
            // Line comment: skip until newline, keep newline in buffer for readability
            while ($i < $len && $sql[$i] !== "\n") {
                $i++;
            }
            if ($i < $len) {
                $buf .= "\n";
            }
            continue;
        }

        if ($ch === '$') {
            // Start or end of $tag$ ... $tag$
            if (preg_match('/\$([A-Za-z_][A-Za-z0-9_]*)?\$/', substr($sql, $i), $m)) {
                $tag = $m[0];
                if (!$inDollar) {
                    $inDollar = true;
                    $dollarTag = $tag;
                    $buf .= $tag;
                    $i += strlen($tag) - 1;
                    continue;
                }
                if ($tag === $dollarTag) {
                    $inDollar = false;
                    $dollarTag = '';
                    $buf .= $tag;
                    $i += strlen($tag) - 1;
                    continue;
                }
            }
        }

        if (!$inDollar && $ch === ';') {
            $stmt = trim($buf);
            if ($stmt !== '') {
                $statements[] = $stmt;
            }
            $buf = '';
            continue;
        }

        $buf .= $ch;
    }

    $tail = trim($buf);
    if ($tail !== '') {
        $statements[] = $tail;
    }

    return $statements;
}

function run_sql_file(PDO $pdo, string $path): int
{
    if (!is_readable($path)) {
        fail("SQL file not readable: {$path}");
    }
    $raw = file_get_contents($path);
    if ($raw === false) {
        fail("Could not read: {$path}");
    }
    $statements = split_sql_statements($raw);
    $ran = 0;
    foreach ($statements as $stmt) {
        $pdo->exec($stmt);
        $ran++;
    }
    return $ran;
}

out('Nyika Safaris — Supabase setup runner');
out(str_repeat('-', 48));

if (str_contains(DB_HOST, 'YOUR_PROJECT_REF') || DB_PASS === 'YOUR_DATABASE_PASSWORD' || DB_PASS === '') {
    fail(
        "DB_PASS is missing or still the placeholder.\n" .
        "Set DB_PASS in .env from Supabase → Project Settings → Database, then re-run."
    );
}

if (!extension_loaded('pdo_pgsql')) {
    fail('Enable extension=pdo_pgsql in php.ini');
}

try {
    $pdo = db();
    $pdo->query('SELECT 1');
    out('OK  Connected to ' . DB_HOST);
} catch (Throwable $e) {
    fail('PDO connection failed: ' . $e->getMessage());
}

$needed = ['admins', 'destinations', 'packages', 'vehicles', 'bookings', 'customers', 'inquiries'];
$missing = [];
foreach ($needed as $table) {
    $stmt = $pdo->prepare(
        "SELECT 1 FROM information_schema.tables WHERE table_schema = 'public' AND table_name = ? LIMIT 1"
    );
    $stmt->execute([$table]);
    if (!$stmt->fetchColumn()) {
        $missing[] = $table;
    }
}

$schemaPath = $root . '/database/supabase_schema.sql';
$seedPath = $root . '/database/supabase_seed.sql';

if ($missing) {
    out('Applying schema (' . count($missing) . ' tables missing)...');
    $n = run_sql_file($pdo, $schemaPath);
    out("OK  Schema applied ({$n} statements)");
} else {
    out('OK  Schema tables already present');
}

$destCount = (int) $pdo->query('SELECT COUNT(*) FROM destinations')->fetchColumn();
if ($destCount === 0) {
    out('Applying seed (destinations empty)...');
    $n = run_sql_file($pdo, $seedPath);
    out("OK  Seed applied ({$n} statements)");
} else {
    out("OK  Seed present ({$destCount} destinations) — re-running seed for idempotent upserts");
    $n = run_sql_file($pdo, $seedPath);
    out("OK  Seed refreshed ({$n} statements)");
}

$hash = password_hash(ADMIN_DEFAULT_PASSWORD, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('SELECT id FROM admins WHERE email = ?');
$stmt->execute([ADMIN_EMAIL]);
if ($stmt->fetch()) {
    $pdo->prepare('UPDATE admins SET password_hash = ? WHERE email = ?')
        ->execute([$hash, ADMIN_EMAIL]);
    out('OK  Admin password reset for ' . ADMIN_EMAIL);
} else {
    $pdo->prepare('INSERT INTO admins (name, email, password_hash, role) VALUES (?,?,?,?)')
        ->execute(['Site Admin', ADMIN_EMAIL, $hash, 'admin']);
    out('OK  Admin created: ' . ADMIN_EMAIL);
}

// Verify login hash
$check = $pdo->prepare('SELECT password_hash FROM admins WHERE email = ?');
$check->execute([ADMIN_EMAIL]);
$row = $check->fetch();
if (!$row || !password_verify(ADMIN_DEFAULT_PASSWORD, $row['password_hash'])) {
    fail('Admin password verify failed after upsert');
}
out('OK  Admin login verified (password_verify)');

$destCount = (int) $pdo->query('SELECT COUNT(*) FROM destinations')->fetchColumn();
$pkgCount = (int) $pdo->query('SELECT COUNT(*) FROM packages')->fetchColumn();
$vehCount = (int) $pdo->query('SELECT COUNT(*) FROM vehicles')->fetchColumn();
out(str_repeat('-', 48));
out("Done. destinations={$destCount} packages={$pkgCount} vehicles={$vehCount}");
out('Site: ' . SITE_URL);
out('Admin: ' . ADMIN_EMAIL . ' / (ADMIN_DEFAULT_PASSWORD from .env)');
out('Next: open install.php once if desired, then protect/delete it.');
exit(0);
