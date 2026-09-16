<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = SITE_NAME . ' — ' . SITE_TAGLINE;
$page_description = 'Book Kenya safaris, beach holidays, and private tours with Nyika Safaris.';
$body_class = 'page-home';

$featured = array_slice(get_destinations(true), 0, 6);
$packages = array_slice(get_packages(true), 0, 3);
if (count($packages) < 3) {
    $packages = array_slice(get_packages(false), 0, 3);
}
$dest_options = get_destinations(false);
$hero_image = 'https://images.unsplash.com/photo-1516426122078-c23e76319801';
$preload_image = optimize_image_url($hero_image, 1400);
$experiences = experience_cards();
$steps = planning_steps();
$faqs = array_slice(site_faqs(), 0, 4);

require __DIR__ . '/includes/header.php';
?>

<section class="hero" aria-label="Welcome">
  <div class="hero-media">
    <?= img_tag($hero_image, [
        'alt' => 'Wildlife on the Kenyan savannah at golden hour',
        'width' => 2000,
        'height' => 1200,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="hero-content">
    <p class="hero-brand"><?= e(SITE_NAME) ?></p>
    <h1 class="hero-title"><?= e(SITE_TAGLINE) ?></h1>
    <p class="hero-lead">Safaris, coast escapes, and private journeys crafted for travelers who want Kenya done properly.</p>
    <div class="btn-group">
      <a class="btn btn-primary" href="contact.php">Book a trip</a>
      <a class="btn btn-ghost" href="tours.php">View packages</a>
    </div>
  </div>
</section>

<section class="search-strip">
  <div class="shell">
    <div class="search-panel reveal">
      <form data-trip-search action="contact.php" method="get" aria-label="Search and book a trip">
        <div class="field">
          <label for="q-destination">Destination</label>
          <select id="q-destination" name="destination">
            <option value="">Where to?</option>
            <?php foreach ($dest_options as $d): ?>
              <option value="<?= e($d['name']) ?>"><?= e($d['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label for="q-start">Travel start</label>
          <input type="date" id="q-start" name="travel_start">
        </div>
        <div class="field">
          <label for="q-travelers">Travelers</label>
          <input type="number" id="q-travelers" name="travelers" min="1" max="40" value="2">
        </div>
        <button class="btn btn-primary" type="submit">Search trips</button>
      </form>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Featured destinations</h2>
      <p>From the Mara plains to the Indian Ocean — places that define a Kenya journey.</p>
    </div>
    <div class="dest-mosaic">
      <?php foreach ($featured as $i => $d): ?>
        <a class="dest-item reveal" href="destinations.php#<?= e($d['slug']) ?>">
          <?= img_tag((string) $d['image_url'], [
              'alt' => (string) $d['name'],
              'width' => $i === 0 ? 1100 : 800,
              'height' => $i === 0 ? 900 : 600,
              'loading' => $i < 2 ? 'eager' : 'lazy',
              'sizes' => $i === 0
                  ? '(max-width: 700px) 100vw, 58vw'
                  : '(max-width: 700px) 100vw, 42vw',
          ]) ?>
          <div class="dest-meta">
            <strong><?= e($d['name']) ?></strong>
            <span><?= e($d['region'] ?? '') ?><?= !empty($d['country']) ? ' · ' . e($d['country']) : '' ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-tone">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Popular tour packages</h2>
      <p>Ready-to-book itineraries with room to tailor every day to you.</p>
    </div>
    <div class="package-list">
      <?php foreach ($packages as $p): ?>
        <a class="package-item reveal" href="tour.php?slug=<?= e(urlencode((string) $p['slug'])) ?>">
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
            <span class="package-link-hint">View full itinerary →</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:1.75rem"><a class="btn btn-outline" href="tours.php">All packages</a></p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Travel experiences</h2>
      <p>Choose a style of journey — then open a full itinerary with inclusions and day-by-day detail.</p>
    </div>
    <div class="experience-grid">
      <?php foreach ($experiences as $ex): ?>
        <a class="experience-card reveal" href="<?= e($ex['href']) ?>">
          <?= img_tag(str_starts_with($ex['image'], 'assets/') ? asset_url($ex['image']) : $ex['image'], [
              'alt' => $ex['title'],
              'width' => 720,
              'height' => 480,
              'sizes' => '(max-width: 700px) 100vw, 33vw',
          ]) ?>
          <div class="experience-body">
            <h3><?= e($ex['title']) ?></h3>
            <p><?= e($ex['text']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-tone">
  <div class="shell">
    <div class="section-head reveal">
      <h2>How planning works</h2>
      <p>A transparent path from first message to confirmed itinerary — the standard of a detailed safari planner.</p>
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
    <p class="reveal" style="margin-top:1.75rem"><a class="btn btn-outline" href="plan.php">Full planning guide</a></p>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Why choose us</h2>
      <p>Local planning, careful pacing, and vehicles that match the journey.</p>
    </div>
    <div class="why-grid">
      <article class="why-item reveal">
        <span class="why-num">01</span>
        <h3>Kenya specialists</h3>
        <p>We live the routes we recommend — Mara tracks, coast transfers, and cross-border logistics included.</p>
      </article>
      <article class="why-item reveal">
        <span class="why-num">02</span>
        <h3>Booking-first service</h3>
        <p>Clear quotes, WhatsApp updates, and a single planner from first inquiry to return airport drop.</p>
      </article>
      <article class="why-item reveal">
        <span class="why-num">03</span>
        <h3>Fleet you can trust</h3>
        <p>Safari vans, Land Cruisers, and VIP Vellfire transfers maintained for comfort and safety.</p>
      </article>
    </div>
  </div>
</section>

<section class="section section-tone">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Traveler reviews</h2>
      <p>Words from guests who explored Kenya with us.</p>
    </div>
    <div class="review-rail">
      <figure class="review reveal">
        <blockquote>“Our Mara game drives felt unhurried and expertly timed. We saw the migration and still had space to breathe.”</blockquote>
        <cite>Amelia &amp; Tom · United Kingdom</cite>
      </figure>
      <figure class="review reveal">
        <blockquote>“Airport pickup in the Vellfire set the tone — then Diani was effortless. Communication on WhatsApp was excellent.”</blockquote>
        <cite>Priya N. · Nairobi</cite>
      </figure>
      <figure class="review reveal">
        <blockquote>“They built a private Amboseli–Naivasha loop for our family. Kids loved Crescent Island; we loved the calm pacing.”</blockquote>
        <cite>The Okello family · Kenya</cite>
      </figure>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <div class="section-head reveal">
      <h2>Common questions</h2>
      <p>Park fees, vehicles, migration timing, and how booking works.</p>
    </div>
    <div class="faq-list" style="max-width:48rem">
      <?php foreach ($faqs as $i => $faq): ?>
        <details class="faq-item reveal"<?= $i === 0 ? ' open' : '' ?>>
          <summary><?= e($faq['q']) ?></summary>
          <p><?= e($faq['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
    <p class="reveal" style="margin-top:1.5rem"><a class="btn btn-outline" href="faq.php">All FAQs</a></p>
  </div>
</section>

<section class="section section-dark">
  <div class="shell">
    <div class="cta-band reveal">
      <div>
        <h2>Ready when you are</h2>
        <p>Tell us your dates and destination — we reply on WhatsApp or email with a clear plan.</p>
      </div>
      <div class="btn-group">
        <a class="btn btn-primary" href="contact.php">Book now</a>
        <a class="btn btn-ghost" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">WhatsApp us</a>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
