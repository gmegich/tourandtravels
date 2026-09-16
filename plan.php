<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'How trip planning works — ' . SITE_NAME;
$page_description = 'From first WhatsApp message to airport drop — how Nyika Safaris plans Kenya safaris and tours.';
$steps = planning_steps();

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800', [
        'alt' => 'Open road through East African landscape',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>How trip planning works</h1>
    <p>A clear process so you always know what happens next — the same care you expect from a detailed safari planner.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Four steps to your Kenya journey</h2>
      <p>No pressure sales — just a written plan you can compare, refine, and confirm.</p>
    </div>
    <div class="steps-grid">
      <?php foreach ($steps as $s): ?>
        <article class="step-card reveal">
          <span class="why-num"><?= e($s['num']) ?></span>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e($s['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-tone">
  <div class="shell prose reveal">
    <h2>What you receive before you pay</h2>
    <p>Every serious inquiry gets a day-by-day outline, lodge or camp options in your budget band, vehicle type (safari van, Land Cruiser, or Vellfire transfer), and a line-item estimate. Inclusions and exclusions are listed so park fees and extras never surprise you.</p>
    <h2>While you travel</h2>
    <p>Your planner stays on WhatsApp for flight changes, room requests, and on-ground questions. Drivers carry local knowledge of park gates, fuel stops, and safe pacing for families or photographers.</p>
    <p class="form-actions" style="margin-top:1.5rem">
      <a class="btn btn-primary" href="contact.php">Start planning</a>
      <a class="btn btn-outline" href="faq.php">Read FAQs</a>
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
