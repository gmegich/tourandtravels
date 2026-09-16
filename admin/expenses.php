<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'expenses';
$admin_title = 'Expenses & profit';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    db()->prepare(
        'INSERT INTO expenses (booking_id, category, description, amount, expense_date) VALUES (?,?,?,?,?)'
    )->execute([
        post_int('booking_id') ?: null,
        post_str('category') ?: 'ops',
        post_str('description'),
        post_float('amount'),
        post_str('expense_date') ?: date('Y-m-d'),
    ]);
    flash('success', 'Expense recorded.');
    redirect('expenses.php');
}

if (isset($_GET['delete'])) {
    delete_by_id('expenses', (int) $_GET['delete']);
    flash('success', 'Expense deleted.');
    redirect('expenses.php');
}

$rows = fetch_all(
    'SELECT e.*, b.booking_ref FROM expenses e
     LEFT JOIN bookings b ON b.id = e.booking_id
     ORDER BY e.expense_date DESC, e.id DESC LIMIT 100'
);
$bookings = fetch_all('SELECT id, booking_ref FROM bookings ORDER BY created_at DESC LIMIT 100');
$paid = (float) (fetch_one('SELECT COALESCE(SUM(amount),0) AS t FROM payments WHERE status=\'paid\'')['t'] ?? 0);
$spent = (float) (fetch_one('SELECT COALESCE(SUM(amount),0) AS t FROM expenses')['t'] ?? 0);

require __DIR__ . '/includes/admin-header.php';
?>

<div class="stats">
  <div class="stat-card"><strong><?= e(money_kes($paid)) ?></strong><span>Paid revenue</span></div>
  <div class="stat-card"><strong><?= e(money_kes($spent)) ?></strong><span>Total expenses</span></div>
  <div class="stat-card"><strong><?= e(money_kes($paid - $spent)) ?></strong><span>Basic profit</span></div>
</div>

<div class="panel">
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="grid-2">
      <div class="field"><label>Description</label><input name="description" required></div>
      <div class="field"><label>Amount (KES)</label><input type="number" step="0.01" name="amount" required></div>
      <div class="field"><label>Category</label><input name="category" value="ops" placeholder="fuel, park fees, lodging…"></div>
      <div class="field"><label>Date</label><input type="date" name="expense_date" value="<?= e(date('Y-m-d')) ?>"></div>
      <div class="field">
        <label>Related booking</label>
        <select name="booking_id"><option value="">—</option>
          <?php foreach ($bookings as $b): ?><option value="<?= (int) $b['id'] ?>"><?= e($b['booking_ref']) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <button class="btn" type="submit">Add expense</button>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Date</th><th>Description</th><th>Category</th><th>Booking</th><th>Amount</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['expense_date']) ?></td>
          <td><?= e($r['description']) ?></td>
          <td><?= e($r['category']) ?></td>
          <td><?= e($r['booking_ref'] ?? '—') ?></td>
          <td><?= e(money_kes($r['amount'])) ?></td>
          <td><a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
