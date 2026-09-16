<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/includes/functions.php';

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!admin_logged_in()) {
        redirect('login.php');
    }
}

function attempt_login(string $email, string $password): bool
{
    $admin = fetch_one('SELECT * FROM admins WHERE email = ? LIMIT 1', [$email]);
    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        return false;
    }
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_email'] = $admin['email'];
    return true;
}

function admin_logout(): void
{
    unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_email']);
}

function admin_name(): string
{
    return (string) ($_SESSION['admin_name'] ?? 'Admin');
}
