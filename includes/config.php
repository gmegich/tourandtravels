<?php
/**
 * Nyika Safaris — site configuration
 * Loads optional .env from project root, then defines constants.
 * Database: Supabase Postgres via PDO (pgsql).
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Load KEY=VALUE pairs from .env (simple parser; no nested quotes). */
(function (): void {
    $envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
    if (!is_readable($envFile)) {
        return;
    }
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
})();

function env(string $key, string $default = ''): string
{
    $v = $_ENV[$key] ?? getenv($key);
    if ($v === false || $v === null || $v === '') {
        return $default;
    }
    return (string) $v;
}

define('SITE_NAME', 'Nyika Safaris');
define('SITE_TAGLINE', 'Explore Kenya With Us');
define('SITE_URL', env('SITE_URL', 'http://localhost/tour%20and%20travel%20website'));

/** WhatsApp business number (E.164 without +) */
define('WHATSAPP_NUMBER', env('WHATSAPP_NUMBER', '254712136002'));
define('WHATSAPP_DISPLAY', env('WHATSAPP_DISPLAY', '+254 712 136002'));
define('CONTACT_EMAIL', env('CONTACT_EMAIL', 'gmegichuru@gmail.com'));
define('CONTACT_PHONE', env('CONTACT_PHONE', '0712 136002'));
define('CONTACT_ADDRESS', env('CONTACT_ADDRESS', 'Westlands, Nairobi, Kenya'));

/**
 * Supabase project (Dashboard → Settings → API).
 * Accepts legacy anon/service_role names and newer publishable/secret names.
 * REST keys are optional while using PDO; keep them for future PostgREST use.
 */
define('SUPABASE_URL', env('SUPABASE_URL', 'https://YOUR_PROJECT_REF.supabase.co'));

$supabaseAnonKey = env('SUPABASE_ANON_KEY', env('SUPABASE_PUBLISHABLE_KEY', 'YOUR_SUPABASE_ANON_KEY'));
$supabaseServiceKey = env('SUPABASE_SERVICE_ROLE_KEY', env('SUPABASE_SECRET_KEY', 'YOUR_SUPABASE_SERVICE_ROLE_KEY'));

define('SUPABASE_ANON_KEY', $supabaseAnonKey);
define('SUPABASE_PUBLISHABLE_KEY', env('SUPABASE_PUBLISHABLE_KEY', $supabaseAnonKey));
define('SUPABASE_SERVICE_ROLE_KEY', $supabaseServiceKey);
define('SUPABASE_SECRET_KEY', env('SUPABASE_SECRET_KEY', $supabaseServiceKey));
define(
    'SUPABASE_JWKS_URL',
    env(
        'SUPABASE_JWKS_URL',
        rtrim(SUPABASE_URL, '/') . '/auth/v1/.well-known/jwks.json'
    )
);

/**
 * Supabase Postgres (Dashboard → Settings → Database → Connection string).
 * Host looks like: db.YOUR_PROJECT_REF.supabase.co
 * Prefer "Session mode" pooler (port 5432) or direct connection for PDO.
 */
define('DB_HOST', env('DB_HOST', 'db.YOUR_PROJECT_REF.supabase.co'));
define('DB_PORT', env('DB_PORT', '5432'));
define('DB_NAME', env('DB_NAME', 'postgres'));
define('DB_USER', env('DB_USER', 'postgres'));
define('DB_PASS', env('DB_PASS', 'YOUR_DATABASE_PASSWORD'));
define('DB_SSLMODE', env('DB_SSLMODE', 'require'));

/** Default admin account (seed / install) */
define('ADMIN_EMAIL', env('ADMIN_EMAIL', 'gmegichuru@gmail.com'));
define('ADMIN_DEFAULT_PASSWORD', env('ADMIN_DEFAULT_PASSWORD', 'admin123'));

/** Email notification placeholder — set true when SMTP is configured */
define('EMAIL_NOTIFICATIONS_ENABLED', filter_var(env('EMAIL_NOTIFICATIONS_ENABLED', 'false'), FILTER_VALIDATE_BOOLEAN));
define('EMAIL_FROM', env('EMAIL_FROM', 'gmegichuru@gmail.com'));

/** M-Pesa Daraja placeholders — fill when credentials exist */
define('MPESA_ENABLED', filter_var(env('MPESA_ENABLED', 'false'), FILTER_VALIDATE_BOOLEAN));
define('MPESA_CONSUMER_KEY', env('MPESA_CONSUMER_KEY', ''));
define('MPESA_CONSUMER_SECRET', env('MPESA_CONSUMER_SECRET', ''));
define('MPESA_SHORTCODE', env('MPESA_SHORTCODE', ''));
define('MPESA_PASSKEY', env('MPESA_PASSKEY', ''));
define('MPESA_ENV', env('MPESA_ENV', 'sandbox')); // sandbox | production

date_default_timezone_set('Africa/Nairobi');
