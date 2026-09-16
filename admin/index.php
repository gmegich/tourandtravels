<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_admin();

$admin_page = 'dashboard';
$admin_title = 'Dashboard';

$stats = [
    'Packages' => count_rows('packages'),
    'Destinations' => count_rows('destinations'),
    'Bookings' => count_rows('bookings'),
    'Customers' => count_rows('customers'),
    'Inquiries' => count_rows('inquiries'),
    'Payments' => count_rows('payments'),
];

$recentBookings = fetch_all(
    'SELECT b.*, c.name AS customer_name
     FROM bookings b
     LEFT JOIN customers c ON c.id = b.customer_id
     ORDER BY b.created_at DESC LIMIT 8'
);

$revenue = fetch_one('SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE status = \'paid\'');
$expenseTotal = fetch_one('SELECT COALESCE(SUM(amount),0) AS total FROM expenses');
$paid = (float) ($revenue['total'] ?? 0);
$spent = (float) ($expenseTotal['total'] ?? 0);

require __DIR__ . '/includes/admin-header.php';
?>

<div class="stats">
  <?php foreach ($stats as $label => $n): ?>
    <div class="stat-card"><strong><?= (int) $n ?></strong><span><?= e($label) ?></span></div>
  <?php endforeach; ?>
  <div class="stat-card"><strong><?= e(money_kes($paid)) ?></strong><span>Paid revenue</span></div>
  <div class="stat-card"><strong><?= e(money_kes($paid - $spent)) ?></strong><span>Est. profit (paid − expenses)</span></div>
</div>

<div class="panel">
  <h2 style="margin:0 0 1rem;font-size:1.1rem">Recent bookings</h2>
  <?php if (!$recentBookings): ?>
    <p class="muted">No bookings yet. Public contact form writes here after install.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>Ref</th><th>Customer</th><th>Dates</th><th>Status</th><th>Amount</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($recentBookings as $b): ?>
          <tr>
            <td><?= e($b['booking_ref']) ?></td>
            <td><?= e($b['customer_name'] ?? '—') ?></td>
            <td><?= e(trim(($b['travel_start'] ?? '') . ' → ' . ($b['travel_end'] ?? ''), ' →')) ?></td>
            <td><span class="badge"><?= e($b['status']) ?></span></td>
            <td><?= e(money_kes($b['total_amount'] ?? 0)) ?></td>
            <td class="row-actions"><a class="btn btn-ghost btn-sm" href="bookings.php?edit=<?= (int) $b['id'] ?>">Open</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="panel">
  <h2 style="margin:0 0 .5rem;font-size:1.1rem">Integrations</h2>
  <p class="note">M-Pesa live STK: <?= MPESA_ENABLED ? 'enabled' : 'deferred (structure in payments table + config placeholders)' ?>.</p>
  <p class="note">Email notifications: <?= EMAIL_NOTIFICATIONS_ENABLED ? 'enabled' : 'logged as placeholders in notification_logs' ?>.</p>
  <p class="note">WhatsApp: public floating CTA uses <?= e(WHATSAPP_DISPLAY) ?> — outbound API hooks log only.</p>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
