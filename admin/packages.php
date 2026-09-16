<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_once dirname(__DIR__) . '/includes/content.php';
require_admin();

$admin_page = 'packages';
$admin_title = 'Tour packages';
$edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $action = post_str('action');
    if ($action === 'delete') {
        delete_by_id('packages', post_int('id'));
        flash('success', 'Package deleted.');
        redirect('packages.php');
    }

    $title = post_str('title');
    $slug = post_str('slug') ?: slugify($title);
    $data = [
        $title,
        $slug,
        post_str('category') ?: 'safari',
        post_int('destination_id') ?: null,
        post_int('duration_days', 1),
        post_float('price_from'),
        post_str('short_description') ?: null,
        post_str('description') ?: null,
        post_str('inclusions') ?: null,
        post_str('image_url') ?: null,
        post_bool('is_popular'),
        post_bool('is_active'),
        post_int('sort_order'),
    ];

    $id = post_int('id');
    if ($id) {
        db()->prepare(
            'UPDATE packages SET title=?, slug=?, category=?, destination_id=?, duration_days=?, price_from=?, short_description=?, description=?, inclusions=?, image_url=?, is_popular=?, is_active=?, sort_order=? WHERE id=?'
        )->execute([...$data, $id]);
        flash('success', 'Package updated.');
    } else {
        db()->prepare(
            'INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, is_active, sort_order)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)'
        )->execute($data);
        flash('success', 'Package created.');
    }
    redirect('packages.php');
}

if (isset($_GET['edit'])) {
    $edit = fetch_one('SELECT * FROM packages WHERE id = ?', [(int) $_GET['edit']]);
}
if (isset($_GET['delete'])) {
    delete_by_id('packages', (int) $_GET['delete']);
    flash('success', 'Package deleted.');
    redirect('packages.php');
}

$rows = fetch_all(
    'SELECT p.*, d.name AS destination_name FROM packages p
     LEFT JOIN destinations d ON d.id = p.destination_id
     ORDER BY p.sort_order, p.title'
);
$destinations = fetch_all('SELECT id, name FROM destinations ORDER BY name');
$cats = ['safari','beach','city','mountain','family','honeymoon','custom'];

require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <h2 style="margin-top:0;font-size:1.05rem"><?= $edit ? 'Edit package' : 'Add package' ?></h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="grid-2">
      <div class="field"><label>Title</label><input name="title" required value="<?= e($edit['title'] ?? '') ?>"></div>
      <div class="field"><label>Slug</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>" placeholder="auto from title"></div>
      <div class="field">
        <label>Category</label>
        <select name="category">
          <?php foreach ($cats as $c): ?>
            <option value="<?= e($c) ?>"<?= (($edit['category'] ?? '') === $c) ? ' selected' : '' ?>><?= e(category_label($c)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Destination</label>
        <select name="destination_id">
          <option value="">—</option>
          <?php foreach ($destinations as $d): ?>
            <option value="<?= (int) $d['id'] ?>"<?= ((int) ($edit['destination_id'] ?? 0) === (int) $d['id']) ? ' selected' : '' ?>><?= e($d['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Duration (days)</label><input type="number" name="duration_days" min="1" value="<?= e((string) ($edit['duration_days'] ?? '1')) ?>"></div>
      <div class="field"><label>Price from (KES)</label><input type="number" step="0.01" name="price_from" value="<?= e((string) ($edit['price_from'] ?? '0')) ?>"></div>
      <div class="field"><label>Image URL</label><input name="image_url" value="<?= e($edit['image_url'] ?? '') ?>"></div>
      <div class="field"><label>Sort order</label><input type="number" name="sort_order" value="<?= e((string) ($edit['sort_order'] ?? '0')) ?>"></div>
    </div>
    <div class="field"><label>Short description</label><input name="short_description" value="<?= e($edit['short_description'] ?? '') ?>"></div>
    <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
    <div class="field"><label>Inclusions (use | between items)</label><input name="inclusions" value="<?= e($edit['inclusions'] ?? '') ?>"></div>
    <div class="actions">
      <label><input type="checkbox" name="is_popular" <?= !empty($edit['is_popular']) ? 'checked' : '' ?>> Popular</label>
      <label><input type="checkbox" name="is_active" <?= !isset($edit) || !empty($edit['is_active']) ? 'checked' : '' ?>> Active</label>
      <button class="btn" type="submit">Save</button>
      <?php if ($edit): ?><a class="btn btn-ghost" href="packages.php">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Title</th><th>Category</th><th>Destination</th><th>Price</th><th>Flags</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['title']) ?></td>
          <td><?= e($r['category']) ?></td>
          <td><?= e($r['destination_name'] ?? '—') ?></td>
          <td><?= e(money_kes($r['price_from'])) ?></td>
          <td><?= !empty($r['is_popular']) ? 'Popular · ' : '' ?><?= !empty($r['is_active']) ? 'Active' : 'Hidden' ?></td>
          <td class="row-actions">
            <a class="btn btn-ghost btn-sm" href="?edit=<?= (int) $r['id'] ?>">Edit</a>
            <a class="btn btn-danger btn-sm" href="?delete=<?= (int) $r['id'] ?>" onclick="return confirm('Delete package?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
