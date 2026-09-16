<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/crud.php';
require_admin();

$admin_page = 'destinations';
$admin_title = 'Destinations';
$edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $name = post_str('name');
    $slug = post_str('slug') ?: slugify($name);
    $data = [
        $name, $slug, post_str('region') ?: null, post_str('country') ?: 'Kenya',
        post_str('short_description') ?: null, post_str('description') ?: null,
        post_str('image_url') ?: null, post_str('highlights') ?: null,
        post_str('best_time') ?: null, post_bool('is_featured'), post_bool('is_active'), post_int('sort_order'),
    ];
    $id = post_int('id');
    if ($id) {
        db()->prepare(
            'UPDATE destinations SET name=?, slug=?, region=?, country=?, short_description=?, description=?, image_url=?, highlights=?, best_time=?, is_featured=?, is_active=?, sort_order=? WHERE id=?'
        )->execute([...$data, $id]);
        flash('success', 'Destination updated.');
    } else {
        db()->prepare(
            'INSERT INTO destinations (name, slug, region, country, short_description, description, image_url, highlights, best_time, is_featured, is_active, sort_order)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
        )->execute($data);
        flash('success', 'Destination created.');
    }
    redirect('destinations.php');
}

if (isset($_GET['edit'])) {
    $edit = fetch_one('SELECT * FROM destinations WHERE id = ?', [(int) $_GET['edit']]);
}
if (isset($_GET['delete'])) {
    delete_by_id('destinations', (int) $_GET['delete']);
    flash('success', 'Destination deleted.');
    redirect('destinations.php');
}

$rows = fetch_all('SELECT * FROM destinations ORDER BY sort_order, name');
require __DIR__ . '/includes/admin-header.php';
?>

<div class="panel">
  <h2 style="margin-top:0;font-size:1.05rem"><?= $edit ? 'Edit destination' : 'Add destination' ?></h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <div class="grid-2">
      <div class="field"><label>Name</label><input name="name" required value="<?= e($edit['name'] ?? '') ?>"></div>
      <div class="field"><label>Slug</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>"></div>
      <div class="field"><label>Region</label><input name="region" value="<?= e($edit['region'] ?? '') ?>"></div>
      <div class="field"><label>Country</label><input name="country" value="<?= e($edit['country'] ?? 'Kenya') ?>"></div>
      <div class="field"><label>Image URL</label><input name="image_url" value="<?= e($edit['image_url'] ?? '') ?>"></div>
      <div class="field"><label>Best time</label><input name="best_time" value="<?= e($edit['best_time'] ?? '') ?>"></div>
      <div class="field"><label>Sort order</label><input type="number" name="sort_order" value="<?= e((string) ($edit['sort_order'] ?? '0')) ?>"></div>
    </div>
    <div class="field"><label>Short description</label><input name="short_description" value="<?= e($edit['short_description'] ?? '') ?>"></div>
    <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
    <div class="field"><label>Highlights (| separated)</label><input name="highlights" value="<?= e($edit['highlights'] ?? '') ?>"></div>
    <div class="actions">
      <label><input type="checkbox" name="is_featured" <?= !empty($edit['is_featured']) ? 'checked' : '' ?>> Featured</label>
      <label><input type="checkbox" name="is_active" <?= !isset($edit) || !empty($edit['is_active']) ? 'checked' : '' ?>> Active</label>
      <button class="btn" type="submit">Save</button>
      <?php if ($edit): ?><a class="btn btn-ghost" href="destinations.php">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="panel">
  <table>
    <thead><tr><th>Name</th><th>Region</th><th>Country</th><th>Flags</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= e($r['name']) ?></td>
          <td><?= e($r['region'] ?? '') ?></td>
          <td><?= e($r['country'] ?? '') ?></td>
          <td><?= !empty($r['is_featured']) ? 'Featured · ' : '' ?><?= !empty($r['is_active']) ? 'Active' : 'Hidden' ?></td>
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
