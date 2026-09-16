<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_once dirname(__DIR__) . '/includes/content.php';
require_admin();

$admin_page = 'vehicles';
$admin_title = 'Vehicles';
$edit = null;
$cats = ['vellfire','safari_van','land_cruiser','transfer','chauffeur','event'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $name = post_str('name');
    $slug = post_str('slug') ?: slugify($name);
    $data = [
        $name, $slug, post_str('category') ?: 'safari_van', post_int('capacity', 4),
        post_float('price_per_day'), post_str('description') ?: null,
        post_str('features') ?: null, post_str('image_url') ?: null, post_bool('is_available'),
    ];
    $id = post_int('id');
    if ($id) {
        db()->prepare(
            'UPDATE vehicles SET name=?, slug=?, category=?, capacity=?, price_per_day=?, description=?, features=?, image_url=?, is_available=? WHERE id=?'
        )->execute([...$data, $id]);
        flash('success', 'Vehicle updated.');
    } else {
        db()->prepare(
            'INSERT INTO vehicles (name, slug, category, capacity, price_per_day, description, features, image_url, is_available)
             VALUES (?,?,?,?,?,?,?,?,?)'
        )->execute($data);
        flash('success', 'Vehicle created.');
    }
    redirect('vehicles.php');
}

if (isset($_GET['edit'])) {
    $edit = fetch_one('SELECT * FROM vehicles WHERE id = ?', [(int) $_GET['edit']]);
}
if (isset($_GET['delete'])) {
    delete_by_id('vehicles', (int) $_GET['delete']);
    flash('success', 'Vehicle deleted.');
    redirect('vehicles.php');
}

$rows = fetch_all('SELECT * FROM vehicles ORDER BY name');
require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <h2 style="margin-top:0;font-size:1.05rem"><?= $edit ? 'Edit vehicle' : 'Add vehicle' ?></h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="grid-2">
      <div class="field"><label>Name</label><input name="name" required value="<?= e($edit['name'] ?? '') ?>"></div>
      <div class="field"><label>Slug</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>"></div>
      <div class="field">
        <label>Category</label>
        <select name="category">
          <?php foreach ($cats as $c): ?>
            <option value="<?= e($c) ?>"<?= (($edit['category'] ?? '') === $c) ? ' selected' : '' ?>><?= e(category_label($c)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Capacity</label><input type="number" name="capacity" value="<?= e((string) ($edit['capacity'] ?? '4')) ?>"></div>
      <div class="field"><label>Price / day (KES)</label><input type="number" step="0.01" name="price_per_day" value="<?= e((string) ($edit['price_per_day'] ?? '0')) ?>"></div>
      <div class="field"><label>Image URL</label><input name="image_url" value="<?= e($edit['image_url'] ?? '') ?>"></div>
    </div>
    <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
    <div class="field"><label>Features (| separated)</label><input name="features" value="<?= e($edit['features'] ?? '') ?>"></div>
    <div class="actions">
      <label><input type="checkbox" name="is_available" <?= !isset($edit) || !empty($edit['is_available']) ? 'checked' : '' ?>> Available</label>
      <button class="btn" type="submit">Save</button>
      <?php if ($edit): ?><a class="btn btn-ghost" href="vehicles.php">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Name</th><th>Category</th><th>Capacity</th><th>Price/day</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['name']) ?></td>
          <td><?= e($r['category']) ?></td>
          <td><?= (int) $r['capacity'] ?></td>
          <td><?= e(money_kes($r['price_per_day'])) ?></td>
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
