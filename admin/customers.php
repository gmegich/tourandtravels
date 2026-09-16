<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'customers';
$admin_title = 'Customers';
$edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $id = post_int('id');
    $data = [post_str('name'), post_str('email') ?: null, post_str('phone') ?: null, post_str('country') ?: null, post_str('notes') ?: null];
    if ($id) {
        db()->prepare('UPDATE customers SET name=?, email=?, phone=?, country=?, notes=? WHERE id=?')->execute([...$data, $id]);
        flash('success', 'Customer updated.');
    } else {
        db()->prepare('INSERT INTO customers (name, email, phone, country, notes) VALUES (?,?,?,?,?)')->execute($data);
        flash('success', 'Customer added.');
    }
    redirect('customers.php');
}

if (isset($_GET['edit'])) {
    $edit = fetch_one('SELECT * FROM customers WHERE id = ?', [(int) $_GET['edit']]);
}
if (isset($_GET['delete'])) {
    delete_by_id('customers', (int) $_GET['delete']);
    flash('success', 'Customer deleted.');
    redirect('customers.php');
}

$rows = fetch_all('SELECT * FROM customers ORDER BY created_at DESC LIMIT 200');
require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <h2 style="margin-top:0;font-size:1.05rem"><?= $edit ? 'Edit customer' : 'Add customer' ?></h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="grid-2">
      <div class="field"><label>Name</label><input name="name" required value="<?= e($edit['name'] ?? '') ?>"></div>
      <div class="field"><label>Email</label><input type="email" name="email" value="<?= e($edit['email'] ?? '') ?>"></div>
      <div class="field"><label>Phone</label><input name="phone" value="<?= e($edit['phone'] ?? '') ?>"></div>
      <div class="field"><label>Country</label><input name="country" value="<?= e($edit['country'] ?? '') ?>"></div>
    </div>
    <div class="field"><label>Notes</label><textarea name="notes"><?= e($edit['notes'] ?? '') ?></textarea></div>
    <div class="actions">
      <button class="btn" type="submit">Save</button>
      <?php if ($edit): ?><a class="btn btn-ghost" href="customers.php">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Country</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['name']) ?></td>
          <td><?= e($r['phone'] ?? '') ?></td>
          <td><?= e($r['email'] ?? '') ?></td>
          <td><?= e($r['country'] ?? '') ?></td>
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
