<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/content.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../contact.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    flash('error', 'Your session expired. Please try again.');
    redirect('../contact.php');
}

$name = trim((string) ($_POST['name'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$destination = trim((string) ($_POST['destination'] ?? ''));
$travel_start = trim((string) ($_POST['travel_start'] ?? ''));
$travel_end = trim((string) ($_POST['travel_end'] ?? ''));
$travelers = max(1, (int) ($_POST['travelers'] ?? 1));
$package = trim((string) ($_POST['package'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || $phone === '') {
    flash('error', 'Please provide your name and phone number.');
    redirect('../contact.php');
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('error', 'Please enter a valid email address.');
    redirect('../contact.php');
}

$startDate = $travel_start !== '' ? $travel_start : null;
$endDate = $travel_end !== '' ? $travel_end : null;

try {
    if (!db_available()) {
        throw new RuntimeException('Database unavailable. Configure Supabase and run install.php.');
    }

    $pdo = db();
    $pdo->beginTransaction();

    $inquiryId = db_insert('inquiries', [
        'name' => $name,
        'phone' => $phone,
        'email' => $email !== '' ? $email : null,
        'destination' => $destination !== '' ? $destination : null,
        'travel_start' => $startDate,
        'travel_end' => $endDate,
        'travelers' => $travelers,
        'package_interest' => $package !== '' ? $package : null,
        'message' => $message !== '' ? $message : null,
        'status' => 'new',
    ]);

    // Upsert-ish customer by email or phone
    $customerId = null;
    if ($email !== '') {
        $existing = fetch_one('SELECT id FROM customers WHERE email = ?', [$email]);
        if ($existing) {
            $customerId = (int) $existing['id'];
            $pdo->prepare('UPDATE customers SET name = ?, phone = COALESCE(?, phone) WHERE id = ?')
                ->execute([$name, $phone, $customerId]);
        }
    }
    if (!$customerId && $phone !== '') {
        $existing = fetch_one('SELECT id FROM customers WHERE phone = ?', [$phone]);
        if ($existing) {
            $customerId = (int) $existing['id'];
            $pdo->prepare('UPDATE customers SET name = ?, email = COALESCE(?, email) WHERE id = ?')
                ->execute([$name, $email !== '' ? $email : null, $customerId]);
        }
    }
    if (!$customerId) {
        $customerId = db_insert('customers', [
            'name' => $name,
            'email' => $email !== '' ? $email : null,
            'phone' => $phone,
        ]);
    }

    $packageId = null;
    $destId = null;
    $total = 0.0;

    if ($package !== '') {
        $pkg = fetch_one('SELECT id, destination_id, price_from FROM packages WHERE title = ? LIMIT 1', [$package]);
        if ($pkg) {
            $packageId = (int) $pkg['id'];
            $destId = $pkg['destination_id'] ? (int) $pkg['destination_id'] : null;
            $total = (float) $pkg['price_from'] * $travelers;
        }
    }
    if (!$destId && $destination !== '') {
        $dest = fetch_one('SELECT id FROM destinations WHERE name = ? LIMIT 1', [$destination]);
        if ($dest) {
            $destId = (int) $dest['id'];
        }
    }

    $ref = booking_ref();
    $bookingId = db_insert('bookings', [
        'booking_ref' => $ref,
        'customer_id' => $customerId,
        'package_id' => $packageId,
        'destination_id' => $destId,
        'travel_start' => $startDate,
        'travel_end' => $endDate,
        'travelers' => $travelers,
        'special_requests' => $message !== '' ? $message : null,
        'status' => 'new',
        'total_amount' => $total,
        'source' => 'website',
    ]);

    $notifyBody = "New booking {$ref}\nName: {$name}\nPhone: {$phone}\nEmail: {$email}\nDestination: {$destination}\nPackage: {$package}\nTravelers: {$travelers}\nDates: {$travel_start} to {$travel_end}\nRequests: {$message}";

    db_insert('notification_logs', [
        'channel' => 'email',
        'recipient' => CONTACT_EMAIL,
        'subject' => 'New booking ' . $ref,
        'body' => $notifyBody,
        'status' => 'skipped',
        'related_type' => 'booking',
        'related_id' => $bookingId,
    ]);

    db_insert('notification_logs', [
        'channel' => 'whatsapp',
        'recipient' => WHATSAPP_NUMBER,
        'subject' => null,
        'body' => $notifyBody,
        'status' => 'skipped',
        'related_type' => 'booking',
        'related_id' => $bookingId,
    ]);

    notify_email(CONTACT_EMAIL, 'New booking ' . $ref, $notifyBody);
    notify_whatsapp(WHATSAPP_NUMBER, $notifyBody);
    if ($email !== '') {
        notify_email($email, 'We received your ' . SITE_NAME . ' request (' . $ref . ')', "Thank you, {$name}. We received your booking request {$ref} and will be in touch shortly.");
    }

    $pdo->commit();

    flash('success', "Thank you! Your request {$ref} is in. We will contact you soon — or message us on WhatsApp.");
    redirect('../contact.php');
} catch (Throwable $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Booking error: ' . $e->getMessage());
    flash('error', 'We could not save your request. Please try WhatsApp or ensure Supabase is configured.');
    redirect('../contact.php');
}
