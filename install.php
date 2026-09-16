<?php
/**
 * Setup helper for Supabase: verifies Postgres connection and upserts admin.
 * Schema/seed must be run in the Supabase SQL Editor first.
 *
 * Visit: http://localhost/tour%20and%20travel%20website/install.php
 * Delete or protect this file after setup.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$messages = [];
$ok = false;

try {
    if (str_contains(DB_HOST, 'YOUR_PROJECT_REF') || DB_PASS === 'YOUR_DATABASE_PASSWORD') {
        throw new RuntimeException(
            'Fill Supabase credentials in .env (copy from .env.example) or includes/config.php defaults before running install.'
        );
    }

    if (!extension_loaded('pdo_pgsql')) {
        throw new RuntimeException('Enable PHP extension pdo_pgsql in php.ini (XAMPP usually ships with it).');
    }

    $pdo = db();
    $pdo->query('SELECT 1');
    $messages[] = 'Connected to Supabase Postgres at ' . DB_HOST;

    // Confirm core tables exist
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
    if ($missing) {
        throw new RuntimeException(
            'Missing tables: ' . implode(', ', $missing) .
            '. Run database/supabase_schema.sql (then supabase_seed.sql) in the Supabase SQL Editor.'
        );
    }
    $messages[] = 'Schema tables found.';

    $hash = password_hash(ADMIN_DEFAULT_PASSWORD, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = ?');
    $stmt->execute([ADMIN_EMAIL]);
    if ($stmt->fetch()) {
        $pdo->prepare('UPDATE admins SET password_hash = ? WHERE email = ?')
            ->execute([$hash, ADMIN_EMAIL]);
        $messages[] = 'Admin password reset for ' . ADMIN_EMAIL . ' / ' . ADMIN_DEFAULT_PASSWORD;
    } else {
        $pdo->prepare('INSERT INTO admins (name, email, password_hash, role) VALUES (?,?,?,?)')
            ->execute(['Site Admin', ADMIN_EMAIL, $hash, 'admin']);
        $messages[] = 'Admin created: ' . ADMIN_EMAIL . ' / ' . ADMIN_DEFAULT_PASSWORD;
    }

    $count = (int) $pdo->query('SELECT COUNT(*) FROM destinations')->fetchColumn();
    if ($count === 0) {
        $messages[] = 'Destinations empty — run database/supabase_seed.sql in the Supabase SQL Editor.';
    } else {
        $messages[] = "Seed looks present ({$count} destinations).";
    }

    $ok = true;
} catch (Throwable $e) {
    $messages[] = 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Install — <?= htmlspecialchars(SITE_NAME) ?></title>
  <style>
    body { font-family: Georgia, serif; max-width: 40rem; margin: 3rem auto; padding: 0 1.25rem; color: #1c1917; background: #f5f6f4; }
    h1 { font-size: 1.75rem; }
    .box { background: #fff; border: 1px solid #d6d3d1; padding: 1.25rem 1.5rem; }
    .ok { color: #166534; }
    .err { color: #991b1b; }
    a { color: #0f3d2e; }
    ul { padding-left: 1.2rem; }
    code { font-size: .9em; }
  </style>
</head>
<body>
  <h1><?= htmlspecialchars(SITE_NAME) ?> — Supabase setup</h1>
  <div class="box <?= $ok ? 'ok' : 'err' ?>">
    <ul>
      <?php foreach ($messages as $m): ?>
        <li><?= htmlspecialchars($m) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php if ($ok): ?>
    <p><a href="index.php">View site</a> · <a href="admin/login.php">Admin login</a></p>
    <p><small>Delete <code>install.php</code> after setup.</small></p>
  <?php else: ?>
    <p>See <code>README.md</code> and <code>.env.example</code> for Supabase connection steps.</p>
  <?php endif; ?>
</body>
</html>
