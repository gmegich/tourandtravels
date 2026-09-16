<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'FAQ — ' . SITE_NAME;
$page_description = 'Frequently asked questions about Kenya safari packages, park fees, migration timing, and booking with Nyika Safaris.';
$faqs = site_faqs();

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1547471080-7cc2caa01a7e', [
        'alt' => 'Elephants on the savannah',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>Frequently asked questions</h1>
    <p>Straight answers on planning, payments, safari timing, and what your trip includes.</p>
  </div>
</section>

<section class="section">
  <div class="shell" style="max-width:48rem">
    <div class="faq-list" data-faq>
      <?php foreach ($faqs as $i => $faq): ?>
        <details class="faq-item reveal"<?= $i === 0 ? ' open' : '' ?>>
          <summary><?= e($faq['q']) ?></summary>
          <p><?= e($faq['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
    <p class="reveal" style="margin-top:2rem">
      Still unsure? <a href="contact.php">Send a booking request</a> or
      <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">message us on WhatsApp</a>.
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
