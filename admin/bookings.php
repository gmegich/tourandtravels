<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'bookings';
$admin_title = 'Bookings';
$edit = null;
$statuses = ['new','confirmed','in_progress','completed','cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $id = post_int('id');
    if ($id) {
        db()->prepare(
            'UPDATE bookings SET status=?, assigned_driver_id=?, vehicle_id=?, total_amount=?, special_requests=?, travel_start=?, travel_end=?, travelers=? WHERE id=?'
        )->execute([
            post_str('status') ?: 'new',
            post_int('assigned_driver_id') ?: null,
            post_int('vehicle_id') ?: null,
            post_float('total_amount'),
            post_str('special_requests') ?: null,
            post_str('travel_start') ?: null,
            post_str('travel_end') ?: null,
            post_int('travelers', 1),
            $id,
        ]);
        flash('success', 'Booking updated.');
    }
    redirect('bookings.php?edit=' . $id);
}

if (isset($_GET['edit'])) {
    $edit = fetch_one(
        'SELECT b.*, c.name AS customer_name, c.phone AS customer_phone, c.email AS customer_email,
                p.title AS package_title, d.name AS destination_name
         FROM bookings b
         LEFT JOIN customers c ON c.id = b.customer_id
         LEFT JOIN packages p ON p.id = b.package_id
         LEFT JOIN destinations d ON d.id = b.destination_id
         WHERE b.id = ?',
        [(int) $_GET['edit']]
    );
}

$rows = fetch_all(
    'SELECT b.*, c.name AS customer_name FROM bookings b
     LEFT JOIN customers c ON c.id = b.customer_id
     ORDER BY b.created_at DESC LIMIT 100'
);
$drivers = fetch_all('SELECT id, name FROM drivers ORDER BY name');
$vehicles = fetch_all('SELECT id, name FROM vehicles ORDER BY name');

require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($edit): ?>
<div class="panel">
  <h2 style="margin-top:0;font-size:1.05rem">Booking <?= e($edit['booking_ref']) ?></h2>
  <p class="muted"><?= e($edit['customer_name'] ?? '') ?> · <?= e($edit['customer_phone'] ?? '') ?> · <?= e($edit['customer_email'] ?? '') ?></p>
  <p class="muted">Package: <?= e($edit['package_title'] ?? '—') ?> · Destination: <?= e($edit['destination_name'] ?? '—') ?></p>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) $edit['id'] ?>">
    <div class="grid-2">
      <div class="field">
        <label>Status</label>
        <select name="status">
          <?php foreach ($statuses as $s): ?>
            <option value="<?= e($s) ?>"<?= $edit['status'] === $s ? ' selected' : '' ?>><?= e($s) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Assign driver</label>
        <select name="assigned_driver_id">
          <option value="">—</option>
          <?php foreach ($drivers as $d): ?>
            <option value="<?= (int) $d['id'] ?>"<?= ((int) ($edit['assigned_driver_id'] ?? 0) === (int) $d['id']) ? ' selected' : '' ?>><?= e($d['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Vehicle</label>
        <select name="vehicle_id">
          <option value="">—</option>
          <?php foreach ($vehicles as $v): ?>
            <option value="<?= (int) $v['id'] ?>"<?= ((int) ($edit['vehicle_id'] ?? 0) === (int) $v['id']) ? ' selected' : '' ?>><?= e($v['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Total amount</label><input type="number" step="0.01" name="total_amount" value="<?= e((string) $edit['total_amount']) ?>"></div>
      <div class="field"><label>Travel start</label><input type="date" name="travel_start" value="<?= e($edit['travel_start'] ?? '') ?>"></div>
      <div class="field"><label>Travel end</label><input type="date" name="travel_end" value="<?= e($edit['travel_end'] ?? '') ?>"></div>
      <div class="field"><label>Travelers</label><input type="number" name="travelers" value="<?= e((string) $edit['travelers']) ?>"></div>
    </div>
    <div class="field"><label>Special requests</label><textarea name="special_requests"><?= e($edit['special_requests'] ?? '') ?></textarea></div>
    <div class="actions">
      <button class="btn" type="submit">Save booking</button>
      <a class="btn btn-ghost" href="bookings.php">Back</a>
      <a class="btn btn-ghost" href="payments.php?booking_id=<?= (int) $edit['id'] ?>">Add payment</a>
    </div>
  </form>
</div>
<?php endif; ?>

<div class="panel">
  <table>
    <thead><tr><th>Ref</th><th>Customer</th><th>Status</th><th>Dates</th><th>Amount</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['booking_ref']) ?></td>
          <td><?= e($r['customer_name'] ?? '—') ?></td>
          <td><span class="badge"><?= e($r['status']) ?></span></td>
          <td><?= e(($r['travel_start'] ?? '') . (($r['travel_end'] ?? '') ? ' → ' . $r['travel_end'] : '')) ?></td>
          <td><?= e(money_kes($r['total_amount'])) ?></td>
          <td><a class="btn btn-ghost btn-sm" href="?edit=<?= (int) $r['id'] ?>">Manage</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
