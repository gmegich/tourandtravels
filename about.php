<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'About Us — ' . SITE_NAME;
$page_description = 'Nyika Safaris is a Nairobi-based tour and transport company crafting Kenya safaris and coast escapes.';

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1488188840666-e962ff04b6e3', [
        'alt' => 'Open East African landscape at dusk',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>About <?= e(SITE_NAME) ?></h1>
    <p>Locally rooted travel planning with a booking-first mindset.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="prose reveal">
      <p><strong><?= e(SITE_NAME) ?></strong> designs Kenya journeys that feel considered — not rushed. We combine safari expertise, coastal knowledge, and a reliable transport fleet so your trip reads as one clear story from arrival to departure.</p>
      <p>Whether you need a classic Maasai Mara circuit, a Diani honeymoon, a Mount Kenya trek, or a private multi-country extension into Tanzania or Uganda, our planners stay with you on WhatsApp and email until you are home.</p>
      <div class="stats-row">
        <div class="stat"><strong>10+</strong><span>Years guiding trips</span></div>
        <div class="stat"><strong>500+</strong><span>Trips arranged</span></div>
        <div class="stat"><strong>24/7</strong><span>WhatsApp support</span></div>
      </div>
      <p>Based in Westlands, Nairobi, we operate safari vans, Land Cruisers, executive Vellfire transfers, and event transport — with drivers who know both park gates and city traffic.</p>
      <p><a class="btn btn-primary" href="contact.php">Start your booking</a></p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
