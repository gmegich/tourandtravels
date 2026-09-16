<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'inquiries';
$admin_title = 'Customer inquiries';
$statuses = ['new','contacted','converted','closed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    db()->prepare('UPDATE inquiries SET status=? WHERE id=?')->execute([post_str('status') ?: 'new', post_int('id')]);
    flash('success', 'Inquiry updated.');
    redirect('inquiries.php');
}

if (isset($_GET['delete'])) {
    delete_by_id('inquiries', (int) $_GET['delete']);
    flash('success', 'Inquiry deleted.');
    redirect('inquiries.php');
}

$rows = fetch_all('SELECT * FROM inquiries ORDER BY created_at DESC LIMIT 150');
require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <p class="note">Contact form submissions land here and also create bookings + customer records. Email/WhatsApp notification attempts are logged in <code>notification_logs</code>.</p>
  <table>
    <thead><tr><th>When</th><th>Name</th><th>Contact</th><th>Interest</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['created_at']) ?></td>
          <td>
            <strong><?= e($r['name']) ?></strong><br>
            <span class="muted"><?= e($r['message'] ?? '') ?></span>
          </td>
          <td><?= e($r['phone'] ?? '') ?><br><?= e($r['email'] ?? '') ?></td>
          <td>
            <?= e($r['destination'] ?? '') ?><br>
            <?= e($r['package_interest'] ?? '') ?><br>
            <?= e(($r['travel_start'] ?? '') . (($r['travel_end'] ?? '') ? ' → ' . $r['travel_end'] : '')) ?>
            · <?= (int) ($r['travelers'] ?? 1) ?> pax
          </td>
          <td>
            <form method="post" class="actions">
              <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
              <select name="status">
                <?php foreach ($statuses as $s): ?>
                  <option value="<?= e($s) ?>"<?= $r['status'] === $s ? ' selected' : '' ?>><?= e($s) ?></option>
                <?php endforeach; ?>
              </select>
              <button class="btn btn-sm" type="submit">Update</button>
            </form>
          </td>
          <td><a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
