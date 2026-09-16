<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'Vehicles & Transport — ' . SITE_NAME;
$page_description = 'Toyota Vellfire, safari vans, Land Cruisers, airport transfers, chauffeur and event transport in Kenya.';
$vehicles = get_vehicles();
$categories = [
    'all' => 'All',
    'vellfire' => 'Vellfire',
    'safari_van' => 'Safari vans',
    'land_cruiser' => 'Land Cruisers',
    'transfer' => 'Airport transfers',
    'chauffeur' => 'Chauffeur',
    'event' => 'Wedding / event',
];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800', [
        'alt' => 'Safari vehicle on an open road',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>Vehicles &amp; transport</h1>
    <p>From VIP city transfers to pop-up roof game drives — the right vehicle for every mile.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="filter-row reveal" data-filter-group>
      <?php foreach ($categories as $key => $label): ?>
        <button type="button" class="filter-chip<?= $key === 'all' ? ' is-active' : '' ?>" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="split-list">
      <?php foreach ($vehicles as $i => $v): ?>
        <article class="split-row reveal" data-category="<?= e($v['category']) ?>">
          <div class="split-media">
            <?= img_tag((string) $v['image_url'], [
                'alt' => (string) $v['name'],
                'width' => 900,
                'height' => 600,
                'loading' => $i === 0 ? 'eager' : 'lazy',
                'sizes' => '(max-width: 800px) 100vw, 50vw',
            ]) ?>
          </div>
          <div class="split-copy">
            <p class="package-cat"><?= e(category_label($v['category'])) ?></p>
            <h3><?= e($v['name']) ?></h3>
            <p><?= e($v['description']) ?></p>
            <?php if (!empty($v['features'])): ?>
              <ul class="feature-list">
                <?php foreach (explode('|', (string) $v['features']) as $f): ?>
                  <li><?= e(trim($f)) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <p class="price-tag">
              Up to <?= (int) $v['capacity'] ?> guests
              <?php if ((float) $v['price_per_day'] > 0): ?>
                · from <?= money_kes($v['price_per_day']) ?>/day
              <?php endif; ?>
            </p>
            <a class="btn btn-outline" href="contact.php?package=<?= e(urlencode('Transport: ' . $v['name'])) ?>">Request this vehicle</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
