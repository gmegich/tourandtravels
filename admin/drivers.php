<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'drivers';
$admin_title = 'Drivers';
$edit = null;
$statuses = ['available','on_trip','off_duty'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [post_str('name'), post_str('phone') ?: null, post_str('license_no') ?: null, post_str('status') ?: 'available', post_str('notes') ?: null];
    $id = post_int('id');
    if ($id) {
        db()->prepare('UPDATE drivers SET name=?, phone=?, license_no=?, status=?, notes=? WHERE id=?')->execute([...$data, $id]);
        flash('success', 'Driver updated.');
    } else {
        db()->prepare('INSERT INTO drivers (name, phone, license_no, status, notes) VALUES (?,?,?,?,?)')->execute($data);
        flash('success', 'Driver added.');
    }
    redirect('drivers.php');
}

if (isset($_GET['edit'])) {
    $edit = fetch_one('SELECT * FROM drivers WHERE id = ?', [(int) $_GET['edit']]);
}
if (isset($_GET['delete'])) {
    delete_by_id('drivers', (int) $_GET['delete']);
    flash('success', 'Driver deleted.');
    redirect('drivers.php');
}

$rows = fetch_all('SELECT * FROM drivers ORDER BY name');
require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="grid-2">
      <div class="field"><label>Name</label><input name="name" required value="<?= e($edit['name'] ?? '') ?>"></div>
      <div class="field"><label>Phone</label><input name="phone" value="<?= e($edit['phone'] ?? '') ?>"></div>
      <div class="field"><label>License no.</label><input name="license_no" value="<?= e($edit['license_no'] ?? '') ?>"></div>
      <div class="field">
        <label>Status</label>
        <select name="status">
          <?php foreach ($statuses as $s): ?>
            <option value="<?= e($s) ?>"<?= (($edit['status'] ?? '') === $s) ? ' selected' : '' ?>><?= e($s) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="field"><label>Notes</label><textarea name="notes"><?= e($edit['notes'] ?? '') ?></textarea></div>
    <button class="btn" type="submit">Save</button>
    <?php if ($edit): ?><a class="btn btn-ghost" href="drivers.php">Cancel</a><?php endif; ?>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Name</th><th>Phone</th><th>License</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['name']) ?></td>
          <td><?= e($r['phone'] ?? '') ?></td>
          <td><?= e($r['license_no'] ?? '') ?></td>
          <td><span class="badge"><?= e($r['status']) ?></span></td>
          <td class="row-actions">
            <a class="btn btn-ghost btn-sm" href="?edit=<?= (int) $r['id'] ?>">Edit</a>
            <a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
