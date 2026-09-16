<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'schedules';
$admin_title = 'Tour schedules';
$statuses = ['planned','active','done','cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    db()->prepare(
        'INSERT INTO tour_schedules (package_id, booking_id, title, start_datetime, end_datetime, meeting_point, notes, status)
         VALUES (?,?,?,?,?,?,?,?)'
    )->execute([
        post_int('package_id') ?: null,
        post_int('booking_id') ?: null,
        post_str('title'),
        post_str('start_datetime'),
        post_str('end_datetime') ?: null,
        post_str('meeting_point') ?: null,
        post_str('notes') ?: null,
        post_str('status') ?: 'planned',
    ]);
    flash('success', 'Schedule added.');
    redirect('schedules.php');
}

if (isset($_GET['delete'])) {
    delete_by_id('tour_schedules', (int) $_GET['delete']);
    flash('success', 'Schedule deleted.');
    redirect('schedules.php');
}

$rows = fetch_all(
    'SELECT s.*, p.title AS package_title, b.booking_ref
     FROM tour_schedules s
     LEFT JOIN packages p ON p.id = s.package_id
     LEFT JOIN bookings b ON b.id = s.booking_id
     ORDER BY s.start_datetime DESC LIMIT 100'
);
$packages = fetch_all('SELECT id, title FROM packages ORDER BY title');
$bookings = fetch_all('SELECT id, booking_ref FROM bookings ORDER BY created_at DESC LIMIT 100');

require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="grid-2">
      <div class="field"><label>Title</label><input name="title" required placeholder="e.g. Mara Day 1 pickup"></div>
      <div class="field"><label>Start</label><input type="datetime-local" name="start_datetime" required></div>
      <div class="field"><label>End</label><input type="datetime-local" name="end_datetime"></div>
      <div class="field"><label>Meeting point</label><input name="meeting_point"></div>
      <div class="field">
        <label>Package</label>
        <select name="package_id"><option value="">—</option>
          <?php foreach ($packages as $p): ?><option value="<?= (int) $p['id'] ?>"><?= e($p['title']) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Booking</label>
        <select name="booking_id"><option value="">—</option>
          <?php foreach ($bookings as $b): ?><option value="<?= (int) $b['id'] ?>"><?= e($b['booking_ref']) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Status</label>
        <select name="status"><?php foreach ($statuses as $s): ?><option value="<?= e($s) ?>"><?= e($s) ?></option><?php endforeach; ?></select>
      </div>
    </div>
    <div class="field"><label>Notes</label><textarea name="notes"></textarea></div>
    <button class="btn" type="submit">Add schedule</button>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>When</th><th>Title</th><th>Package</th><th>Booking</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['start_datetime']) ?></td>
          <td><?= e($r['title']) ?></td>
          <td><?= e($r['package_title'] ?? '—') ?></td>
          <td><?= e($r['booking_ref'] ?? '—') ?></td>
          <td><span class="badge"><?= e($r['status']) ?></span></td>
          <td><a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
