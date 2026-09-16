<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Shared PDO connection to Supabase Postgres.
 *
 * Why PDO pgsql (not PostgREST): this codebase already uses prepared SQL
 * across admin CRUD and booking. XAMPP here has the pgsql extension, so PDO
 * preserves existing queries with minimal change. REST would require rewriting
 * every query to PostgREST filters/embeds.
 *
 * Requires: PHP pdo_pgsql + openssl. Supabase needs sslmode=require.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    if (!extension_loaded('pdo_pgsql')) {
        throw new RuntimeException(
            'PDO pgsql extension is required for Supabase. Enable extension=pdo_pgsql in php.ini, or see README for alternatives.'
        );
    }

    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s',
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_SSLMODE
    );

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function db_available(): bool
{
    try {
        if (
            str_contains(DB_HOST, 'YOUR_PROJECT_REF')
            || DB_PASS === 'YOUR_DATABASE_PASSWORD'
            || DB_PASS === ''
        ) {
            return false;
        }
        db()->query('SELECT 1');
        return true;
    } catch (Throwable $e) {
        return false;
    }
}

/** Insert a row and return the new id (Postgres-safe). */
function db_insert(string $table, array $data): int
{
    $cols = array_keys($data);
    $placeholders = array_map(static fn(string $c): string => ':' . $c, $cols);
    $sql = sprintf(
        'INSERT INTO %s (%s) VALUES (%s) RETURNING id',
        $table,
        implode(', ', $cols),
        implode(', ', $placeholders)
    );
    $stmt = db()->prepare($sql);
    foreach ($data as $col => $value) {
        if ($value === null) {
            $stmt->bindValue(':' . $col, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':' . $col, $value);
        }
    }
    $stmt->execute();
    return (int) $stmt->fetchColumn();
}
