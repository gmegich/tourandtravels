<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function take_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function whatsapp_link(string $message = ''): string
{
    $text = $message !== '' ? $message : 'Hello ' . SITE_NAME . ', I would like to book a trip.';
    return 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode($text);
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_verify(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function money_kes($amount): string
{
    return 'KES ' . number_format((float) $amount, 0);
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
    return trim($text, '-') ?: 'item';
}

/** Placeholder: queue email when SMTP is wired */
function notify_email(string $to, string $subject, string $body): bool
{
    if (!EMAIL_NOTIFICATIONS_ENABLED) {
        error_log("[EMAIL PLACEHOLDER] To: {$to} | Subject: {$subject} | Body: {$body}");
        return false;
    }
    $headers = 'From: ' . EMAIL_FROM . "\r\n" . 'Content-Type: text/plain; charset=UTF-8';
    return mail($to, $subject, $body, $headers);
}

/** Placeholder: log WhatsApp notification intent */
function notify_whatsapp(string $phone, string $message): bool
{
    error_log("[WHATSAPP PLACEHOLDER] To: {$phone} | Message: {$message}");
    return false;
}

function current_page(): string
{
    return basename($_SERVER['PHP_SELF'] ?? 'index.php');
}

function nav_active(string $file): string
{
    return current_page() === $file ? ' is-active' : '';
}

/** Cache-busted public asset URL */
function asset_url(string $path): string
{
    $relative = ltrim(str_replace('\\', '/', $path), '/');
    $full = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    $version = is_file($full) ? (string) filemtime($full) : '1';
    return $relative . '?v=' . $version;
}

function is_unsplash_url(string $url): bool
{
    return str_contains($url, 'images.unsplash.com');
}

/** Resize/compress Unsplash URLs; pass-through for local/other hosts */
function optimize_image_url(string $url, int $width, int $quality = 72): string
{
    if ($url === '' || !is_unsplash_url($url)) {
        return $url;
    }
    $parts = parse_url($url);
    if ($parts === false || empty($parts['host'])) {
        return $url;
    }
    parse_str($parts['query'] ?? '', $query);
    $query['w'] = (string) max(320, $width);
    $query['q'] = (string) max(40, min(90, $quality));
    $query['auto'] = 'format';
    if (!isset($query['fit'])) {
        $query['fit'] = 'crop';
    }
    $scheme = $parts['scheme'] ?? 'https';
    $path = $parts['path'] ?? '';
    return $scheme . '://' . $parts['host'] . $path . '?' . http_build_query($query);
}

/**
 * Responsive <img> with Unsplash srcset when applicable.
 *
 * @param array{
 *   alt?:string,width?:int,height?:int,loading?:string,fetchpriority?:string,
 *   class?:string,sizes?:string,decoding?:string
 * } $opts
 */
function img_tag(string $url, array $opts = []): string
{
    $alt = (string) ($opts['alt'] ?? '');
    $width = (int) ($opts['width'] ?? 1200);
    $height = (int) ($opts['height'] ?? 800);
    $loading = (string) ($opts['loading'] ?? 'lazy');
    $decoding = (string) ($opts['decoding'] ?? 'async');
    $sizes = (string) ($opts['sizes'] ?? '(max-width: 720px) 100vw, (max-width: 1100px) 50vw, 560px');
    $class = (string) ($opts['class'] ?? '');
    $fetchpriority = isset($opts['fetchpriority']) ? (string) $opts['fetchpriority'] : '';

    $srcWidth = min(max($width, 480), 1600);
    $src = optimize_image_url($url, $srcWidth);
    $attrs = [
        'src="' . e($src) . '"',
        'alt="' . e($alt) . '"',
        'width="' . $width . '"',
        'height="' . $height . '"',
        'loading="' . e($loading) . '"',
        'decoding="' . e($decoding) . '"',
    ];
    if ($class !== '') {
        $attrs[] = 'class="' . e($class) . '"';
    }
    if ($fetchpriority !== '') {
        $attrs[] = 'fetchpriority="' . e($fetchpriority) . '"';
    }

    if (is_unsplash_url($url)) {
        $widths = [480, 768, 1100, 1600];
        $parts = [];
        foreach ($widths as $w) {
            if ($w > $srcWidth + 80) {
                continue;
            }
            $parts[] = e(optimize_image_url($url, $w)) . ' ' . $w . 'w';
        }
        if ($parts === []) {
            $parts[] = e($src) . ' ' . $srcWidth . 'w';
        }
        $attrs[] = 'srcset="' . implode(', ', $parts) . '"';
        $attrs[] = 'sizes="' . e($sizes) . '"';
    }

    return '<img ' . implode(' ', $attrs) . '>';
}

/** Safe fetch helpers that degrade gracefully if DB is offline */
function fetch_all(string $sql, array $params = []): array
{
    try {
        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

function fetch_one(string $sql, array $params = []): ?array
{
    try {
        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function count_rows(string $table): int
{
    static $allowed = [
        'packages', 'destinations', 'vehicles', 'bookings', 'customers',
        'inquiries', 'payments', 'drivers', 'expenses', 'tour_schedules',
        'admins', 'notification_logs',
    ];
    if (!in_array($table, $allowed, true)) {
        return 0;
    }
    try {
        return (int) db()->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
    } catch (Throwable $e) {
        return 0;
    }
}
