<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
$package = get_package_by_slug($slug);

if (!$package) {
    http_response_code(404);
    $page_title = 'Tour not found — ' . SITE_NAME;
    require __DIR__ . '/includes/header.php';
    echo '<section class="section"><div class="shell"><h1>Tour not found</h1><p class="empty-note">That package is unavailable. <a href="tours.php">Browse all tours</a>.</p></div></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$page_title = $package['title'] . ' — ' . SITE_NAME;
$page_description = (string) ($package['short_description'] ?? $package['description'] ?? 'Kenya tour package with Nyika Safaris.');
$itinerary = $package['itinerary'] ?? [];
$inclusions = pipe_list($package['inclusions'] ?? null);
$exclusions = pipe_list($package['exclusions'] ?? null);
$highlights = pipe_list($package['highlights'] ?? null);

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag((string) $package['image_url'], [
        'alt' => (string) $package['title'],
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <p class="package-cat" style="color:var(--gold-soft);margin-bottom:0.5rem"><?= e(category_label((string) $package['category'])) ?></p>
    <h1><?= e($package['title']) ?></h1>
    <p><?= e($package['short_description'] ?? '') ?></p>
  </div>
</section>

<section class="section">
  <div class="shell detail-layout">
    <div class="detail-main reveal">
      <div class="detail-meta-bar">
        <span><strong><?= (int) $package['duration_days'] ?></strong> days</span>
        <span><?= (float) $package['price_from'] > 0 ? 'From <strong>' . e(money_kes($package['price_from'])) . '</strong>' : '<strong>Custom quote</strong>' ?></span>
        <?php if (!empty($package['destination_name'])): ?>
          <span><?= e((string) $package['destination_name']) ?></span>
        <?php endif; ?>
        <?php if (!empty($package['ideal_for'])): ?>
          <span>Ideal for: <?= e((string) $package['ideal_for']) ?></span>
        <?php endif; ?>
      </div>

      <h2>Overview</h2>
      <p class="detail-lead"><?= e((string) ($package['description'] ?? $package['short_description'] ?? '')) ?></p>

      <?php if ($highlights): ?>
        <h3>Trip highlights</h3>
        <ul class="feature-list">
          <?php foreach ($highlights as $h): ?>
            <li><?= e($h) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if ($itinerary): ?>
        <h2>Day-by-day itinerary</h2>
        <ol class="itinerary">
          <?php foreach ($itinerary as $day): ?>
            <li class="itinerary-day">
              <div class="itinerary-day-num">Day <?= (int) $day['day'] ?></div>
              <div>
                <h3><?= e((string) $day['title']) ?></h3>
                <p><?= e((string) $day['body']) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php endif; ?>

      <div class="include-grid">
        <?php if ($inclusions): ?>
          <div>
            <h3>Included</h3>
            <ul class="check-list">
              <?php foreach ($inclusions as $item): ?>
                <li><?= e($item) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <?php if ($exclusions): ?>
          <div>
            <h3>Not included</h3>
            <ul class="check-list check-list-muted">
              <?php foreach ($exclusions as $item): ?>
                <li><?= e($item) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <aside class="detail-aside reveal">
      <div class="form-panel sticky-aside">
        <h3>Book this trip</h3>
        <p>Tell us your dates — we confirm availability and send a clear quote.</p>
        <p class="price-tag">
          <?= (float) $package['price_from'] > 0 ? 'From ' . money_kes($package['price_from']) . ' / person estimate' : 'Custom quote' ?>
        </p>
        <div class="form-actions" style="flex-direction:column;align-items:stretch">
          <a class="btn btn-primary" href="contact.php?package=<?= e(urlencode((string) $package['title'])) ?>&destination=<?= e(urlencode((string) ($package['destination_name'] ?? ''))) ?>">Request a quote</a>
          <a class="btn btn-outline" href="<?= e(whatsapp_link('Hi Nyika Safaris — I want to book: ' . $package['title'])) ?>" target="_blank" rel="noopener">WhatsApp us</a>
          <a class="btn btn-outline" href="tours.php">All packages</a>
        </div>
      </div>
    </aside>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
