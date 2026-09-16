<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'Destinations — ' . SITE_NAME;
$page_description = 'Explore Maasai Mara, Amboseli, Diani, Mombasa, Nairobi, Naivasha, Samburu, Tsavo, Zanzibar, and East Africa extensions.';
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
    <p>Kenya’s great parks and coast — plus Zanzibar and regional extensions when you want more.</p>
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
              <ul class="feature-list">
                <?php foreach (explode('|', (string) $d['highlights']) as $h): ?>
                  <li><?= e(trim($h)) ?></li>
                <?php endforeach; ?>
              </ul>
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
