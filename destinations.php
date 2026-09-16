<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'Destinations — ' . SITE_NAME;
$page_description = 'In-depth Kenya and East Africa destinations: Maasai Mara, Amboseli, Diani, Samburu, Tsavo, Zanzibar, and more — wildlife, activities, and how to get there.';
$destinations = get_destinations(false);

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1507525428034-b723cf961d3e', [
        'alt' => 'Tropical beach along the Kenyan coast',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>Destinations</h1>
    <p>Park-by-park detail — wildlife, activities, best seasons, and how we get you there.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="split-list">
      <?php foreach ($destinations as $i => $d): ?>
        <article class="split-row reveal" id="<?= e($d['slug']) ?>">
          <div class="split-media">
            <?= img_tag((string) $d['image_url'], [
                'alt' => (string) $d['name'],
                'width' => 900,
                'height' => 600,
                'loading' => $i === 0 ? 'eager' : 'lazy',
                'sizes' => '(max-width: 800px) 100vw, 50vw',
            ]) ?>
          </div>
          <div class="split-copy">
            <h3><?= e($d['name']) ?></h3>
            <p class="package-cat" style="margin-bottom:0.6rem"><?= e(($d['region'] ?? '') . (!empty($d['country']) ? ' · ' . $d['country'] : '')) ?></p>
            <p><?= e($d['description'] ?? $d['short_description'] ?? '') ?></p>
            <?php if (!empty($d['highlights'])): ?>
              <h4 class="mini-label">Highlights</h4>
              <ul class="feature-list">
                <?php foreach (pipe_list((string) $d['highlights']) as $h): ?>
                  <li><?= e($h) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <?php if (!empty($d['wildlife'])): ?>
              <h4 class="mini-label">Wildlife</h4>
              <ul class="feature-list">
                <?php foreach (pipe_list((string) $d['wildlife']) as $w): ?>
                  <li><?= e($w) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <?php if (!empty($d['activities'])): ?>
              <h4 class="mini-label">Activities</h4>
              <ul class="feature-list">
                <?php foreach (pipe_list((string) $d['activities']) as $a): ?>
                  <li><?= e($a) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <?php if (!empty($d['getting_there'])): ?>
              <p class="detail-note"><strong>Getting there:</strong> <?= e((string) $d['getting_there']) ?></p>
            <?php endif; ?>
            <?php if (!empty($d['best_time'])): ?>
              <p class="price-tag">Best time: <?= e($d['best_time']) ?></p>
            <?php endif; ?>
            <a class="btn btn-outline" href="contact.php?destination=<?= e(urlencode($d['name'])) ?>">Plan this trip</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
