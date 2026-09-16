<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'About Us — ' . SITE_NAME;
$page_description = 'Nyika Safaris is a Nairobi-based tour and transport company crafting detailed Kenya safaris, coast escapes, and East Africa extensions.';
$steps = planning_steps();

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1516426122078-c23e76319801', [
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
    <p>Locally rooted travel planning with the detail of a specialist safari agency.</p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="prose reveal">
      <p><strong><?= e(SITE_NAME) ?></strong> designs Kenya journeys that feel considered — not rushed. We combine safari expertise, coastal knowledge, and a reliable transport fleet so your trip reads as one clear story from arrival to departure.</p>
      <p>Like the best East African trip planners, we start with your dates and interests, then build a written itinerary: nights per park, vehicle type, lodge tier, and what is (and is not) included. Whether you need a classic Maasai Mara circuit, a Diani honeymoon, a Mount Kenya trek, or a private multi-country extension into Tanzania or Uganda, our planners stay with you on WhatsApp and email until you are home.</p>
      <div class="stats-row">
        <div class="stat"><strong>10+</strong><span>Years guiding trips</span></div>
        <div class="stat"><strong>500+</strong><span>Trips arranged</span></div>
        <div class="stat"><strong>24/7</strong><span>WhatsApp support</span></div>
      </div>
      <h2>What we handle</h2>
      <ul class="check-list">
        <li>Safari circuits across Mara, Amboseli, Tsavo, Samburu, and Naivasha</li>
        <li>Beach extensions on the south and north coast</li>
        <li>Airport meet-and-greet and VIP Vellfire transfers</li>
        <li>Family, honeymoon, and photography-focused pacing</li>
        <li>Cross-border planning for Tanzania and Uganda</li>
      </ul>
      <p>Based in Westlands, Nairobi, we operate safari vans, Land Cruisers, executive Vellfire transfers, and event transport — with drivers who know both park gates and city traffic.</p>
    </div>
  </div>
</section>

<section class="section section-tone">
  <div class="shell">
    <div class="section-head reveal">
      <h2>How we work with you</h2>
      <p>A transparent planning path from first message to return flight.</p>
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
    <p class="reveal" style="margin-top:2rem">
      <a class="btn btn-primary" href="contact.php">Start your booking</a>
      <a class="btn btn-outline" href="plan.php">Full planning guide</a>
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
