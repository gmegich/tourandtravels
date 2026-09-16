<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'Tours & Packages — ' . SITE_NAME;
$page_description = 'Safari packages, beach holidays, city tours, hiking trips, family and honeymoon packages across Kenya.';
$packages = get_packages(false);
$categories = ['all' => 'All', 'safari' => 'Safari', 'beach' => 'Beach', 'city' => 'City', 'mountain' => 'Mountain', 'family' => 'Family', 'honeymoon' => 'Honeymoon', 'custom' => 'Custom'];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1547471080-7cc2caa01a7e', [
        'alt' => 'Elephants in Amboseli with Kilimanjaro beyond',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>Tours &amp; packages</h1>
    <p>Safari circuits, coast escapes, city days, mountain treks, and private custom itineraries.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="filter-row reveal" data-filter-group>
      <?php foreach ($categories as $key => $label): ?>
        <button type="button" class="filter-chip<?= $key === 'all' ? ' is-active' : '' ?>" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="package-list">
      <?php foreach ($packages as $p): ?>
        <a class="package-item reveal" data-category="<?= e($p['category']) ?>" href="contact.php?package=<?= e(urlencode($p['title'])) ?>&destination=<?= e(urlencode($p['destination_name'] ?? '')) ?>">
          <?= img_tag((string) $p['image_url'], [
              'alt' => (string) $p['title'],
              'width' => 640,
              'height' => 440,
              'sizes' => '(max-width: 600px) 100vw, (max-width: 980px) 50vw, 360px',
          ]) ?>
          <div class="package-body">
            <span class="package-cat"><?= e(category_label($p['category'])) ?></span>
            <h3><?= e($p['title']) ?></h3>
            <p><?= e($p['short_description']) ?></p>
            <div class="package-meta">
              <span><?= (int) $p['duration_days'] ?> days</span>
              <span><?= (float) $p['price_from'] > 0 ? 'From ' . money_kes($p['price_from']) : 'Custom quote' ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
