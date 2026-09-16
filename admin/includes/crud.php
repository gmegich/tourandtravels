<?php
declare(strict_types=1);

/** Shared admin helpers for simple CRUD forms */

function post_str(string $key): string
{
    return trim((string) ($_POST[$key] ?? ''));
}

function post_int(string $key, int $default = 0): int
{
    return isset($_POST[$key]) && $_POST[$key] !== '' ? (int) $_POST[$key] : $default;
}

function post_float(string $key, float $default = 0.0): float
{
    return isset($_POST[$key]) && $_POST[$key] !== '' ? (float) $_POST[$key] : $default;
}

function post_bool(string $key): int
{
    return isset($_POST[$key]) ? 1 : 0;
}

function require_csrf(): void
{
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        flash('error', 'Invalid CSRF token.');
        redirect($_SERVER['PHP_SELF'] ?? 'index.php');
    }
}

function delete_by_id(string $table, int $id): void
{
    static $allowed = [
        'packages', 'destinations', 'vehicles', 'bookings', 'customers',
        'inquiries', 'payments', 'drivers', 'expenses', 'tour_schedules',
        'notification_logs',
    ];
    if (!in_array($table, $allowed, true)) {
        throw new InvalidArgumentException('Invalid table for delete.');
    }
    db()->prepare("DELETE FROM {$table} WHERE id = ?")->execute([$id]);
}
