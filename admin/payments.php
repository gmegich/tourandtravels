<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'payments';
$admin_title = 'Payments (M-Pesa ready)';
$prefillBooking = isset($_GET['booking_id']) ? (int) $_GET['booking_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $status = post_str('status') ?: 'pending';
    $paidAt = $status === 'paid' ? date('Y-m-d H:i:s') : null;
    db()->prepare(
        'INSERT INTO payments (booking_id, customer_id, amount, currency, method, status, mpesa_receipt, mpesa_phone, notes, paid_at)
         VALUES (?,?,?,?,?,?,?,?,?,?)'
    )->execute([
        post_int('booking_id') ?: null,
        post_int('customer_id') ?: null,
        post_float('amount'),
        'KES',
        post_str('method') ?: 'mpesa',
        $status,
        post_str('mpesa_receipt') ?: null,
        post_str('mpesa_phone') ?: null,
        post_str('notes') ?: null,
        $paidAt,
    ]);
    flash('success', 'Payment record saved. Live M-Pesa STK Push can plug into this table later.');
    redirect('payments.php');
}

if (isset($_GET['delete'])) {
    delete_by_id('payments', (int) $_GET['delete']);
    flash('success', 'Payment deleted.');
    redirect('payments.php');
}

$rows = fetch_all(
    'SELECT p.*, b.booking_ref, c.name AS customer_name
     FROM payments p
     LEFT JOIN bookings b ON b.id = p.booking_id
     LEFT JOIN customers c ON c.id = p.customer_id
     ORDER BY p.created_at DESC LIMIT 100'
);
$bookings = fetch_all('SELECT id, booking_ref FROM bookings ORDER BY created_at DESC LIMIT 100');
$customers = fetch_all('SELECT id, name FROM customers ORDER BY name');

require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <p class="note">Structure for M-Pesa: receipt, phone, checkout/merchant request IDs (columns ready). Live Daraja STK is deferred until credentials exist in <code>includes/config.php</code>.</p>
  <h2 style="margin:1rem 0 .75rem;font-size:1.05rem">Record payment</h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="grid-2">
      <div class="field">
        <label>Booking</label>
        <select name="booking_id">
          <option value="">—</option>
          <?php foreach ($bookings as $b): ?>
            <option value="<?= (int) $b['id'] ?>"<?= $prefillBooking === (int) $b['id'] ? ' selected' : '' ?>><?= e($b['booking_ref']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Customer</label>
        <select name="customer_id">
          <option value="">—</option>
          <?php foreach ($customers as $c): ?>
            <option value="<?= (int) $c['id'] ?>"><?= e($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Amount (KES)</label><input type="number" step="0.01" name="amount" required></div>
      <div class="field">
        <label>Method</label>
        <select name="method">
          <option value="mpesa">M-Pesa</option>
          <option value="cash">Cash</option>
          <option value="card">Card</option>
          <option value="bank">Bank</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="field">
        <label>Status</label>
        <select name="status">
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
          <option value="failed">Failed</option>
          <option value="refunded">Refunded</option>
        </select>
      </div>
      <div class="field"><label>M-Pesa receipt</label><input name="mpesa_receipt"></div>
      <div class="field"><label>M-Pesa phone</label><input name="mpesa_phone" placeholder="2547..."></div>
    </div>
    <div class="field"><label>Notes</label><input name="notes"></div>
    <button class="btn" type="submit">Save payment</button>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Date</th><th>Booking</th><th>Customer</th><th>Method</th><th>Status</th><th>Amount</th><th>Receipt</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['created_at']) ?></td>
          <td><?= e($r['booking_ref'] ?? '—') ?></td>
          <td><?= e($r['customer_name'] ?? '—') ?></td>
          <td><?= e($r['method']) ?></td>
          <td><span class="badge"><?= e($r['status']) ?></span></td>
          <td><?= e(money_kes($r['amount'])) ?></td>
          <td><?= e($r['mpesa_receipt'] ?? '') ?></td>
          <td><a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
