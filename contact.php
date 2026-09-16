<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/content.php';

$page_title = 'Contact / Book Now — ' . SITE_NAME;
$page_description = 'Book a Kenya safari or tour. Send your dates and we will confirm on WhatsApp or email.';

$prefill = [
    'destination' => trim((string) ($_GET['destination'] ?? '')),
    'travel_start' => trim((string) ($_GET['travel_start'] ?? '')),
    'travel_end' => trim((string) ($_GET['travel_end'] ?? '')),
    'travelers' => trim((string) ($_GET['travelers'] ?? '2')),
    'package' => trim((string) ($_GET['package'] ?? '')),
];

$flash = take_flash();
$packages = get_packages(false);
$destinations = get_destinations(false);

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="page-hero-media">
    <?= img_tag('https://images.unsplash.com/photo-1516426122078-c23e76319801', [
        'alt' => 'Kenya safari landscape',
        'width' => 1800,
        'height' => 900,
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'sizes' => '100vw',
    ]) ?>
  </div>
  <div class="page-hero-content">
    <h1>Contact / Book now</h1>
    <p>Share your plans — we respond with availability, a quote outline, and next steps.</p>
  </div>
</section>

<section class="section">
  <div class="shell contact-layout">
    <div class="form-panel reveal">
      <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type'] === 'success' ? 'success' : 'error') ?>">
          <?= e($flash['message']) ?>
        </div>
      <?php endif; ?>

      <form action="api/book.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <div class="form-grid two">
          <div class="field">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required maxlength="160" autocomplete="name">
          </div>
          <div class="field">
            <label for="phone">Phone *</label>
            <input type="tel" id="phone" name="phone" required maxlength="40" autocomplete="tel" placeholder="+254...">
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="190" autocomplete="email">
          </div>
          <div class="field">
            <label for="destination">Destination</label>
            <select id="destination" name="destination">
              <option value="">Select destination</option>
              <?php foreach ($destinations as $d): ?>
                <option value="<?= e($d['name']) ?>"<?= $prefill['destination'] === $d['name'] ? ' selected' : '' ?>><?= e($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="travel_start">Travel start</label>
            <input type="date" id="travel_start" name="travel_start" value="<?= e($prefill['travel_start']) ?>">
          </div>
          <div class="field">
            <label for="travel_end">Travel end</label>
            <input type="date" id="travel_end" name="travel_end" value="<?= e($prefill['travel_end']) ?>">
          </div>
          <div class="field">
            <label for="travelers">Number of travelers</label>
            <input type="number" id="travelers" name="travelers" min="1" max="40" value="<?= e($prefill['travelers'] !== '' ? $prefill['travelers'] : '2') ?>">
          </div>
          <div class="field">
            <label for="package">Package</label>
            <select id="package" name="package">
              <option value="">Select package</option>
              <?php foreach ($packages as $p): ?>
                <option value="<?= e($p['title']) ?>"<?= $prefill['package'] === $p['title'] ? ' selected' : '' ?>><?= e($p['title']) ?></option>
              <?php endforeach; ?>
              <?php if ($prefill['package'] && !in_array($prefill['package'], array_column($packages, 'title'), true)): ?>
                <option value="<?= e($prefill['package']) ?>" selected><?= e($prefill['package']) ?></option>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="field" style="margin-top:1rem">
          <label for="message">Special requests</label>
          <textarea id="message" name="message" maxlength="2000" placeholder="Dietary needs, lodge style, airport times, celebration details…"></textarea>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Submit booking request</button>
          <a class="btn btn-outline" href="<?= e(whatsapp_link('Hi Nyika Safaris, I\'d like to book a trip.')) ?>" target="_blank" rel="noopener">WhatsApp instead</a>
        </div>
      </form>
    </div>

    <aside class="contact-aside reveal">
      <h3>Talk to a planner</h3>
      <p>We typically reply within a few hours during the day. For urgent same-day transfers, WhatsApp is fastest.</p>
      <ul>
        <li>Phone: <a href="tel:<?= e(preg_replace('/\s+/', '', CONTACT_PHONE) ?? '') ?>"><?= e(CONTACT_PHONE) ?></a></li>
        <li>Email: <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></li>
        <li><?= e(CONTACT_ADDRESS) ?></li>
      </ul>
      <a class="btn btn-primary" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">Open WhatsApp</a>
    </aside>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
