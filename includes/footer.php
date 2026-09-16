<?php
declare(strict_types=1);
?>
  </main>
  <footer class="site-footer">
    <div class="shell footer-grid">
      <div class="footer-brand">
        <p class="footer-name"><?= e(SITE_NAME) ?></p>
        <p class="footer-tag"><?= e(SITE_TAGLINE) ?> — safari packages, beach extensions, and trip planning across East Africa.</p>
      </div>
      <div>
        <p class="footer-heading">Explore</p>
        <ul class="footer-links">
          <li><a href="tours.php">Safari packages</a></li>
          <li><a href="destinations.php">Destinations</a></li>
          <li><a href="plan.php">How planning works</a></li>
          <li><a href="faq.php">FAQ</a></li>
          <li><a href="about.php">About us</a></li>
          <li><a href="contact.php">Book a trip</a></li>
        </ul>
      </div>
      <div>
        <p class="footer-heading">Contact</p>
        <ul class="footer-links">
          <li><a href="tel:<?= e(preg_replace('/\s+/', '', CONTACT_PHONE) ?? '') ?>"><?= e(CONTACT_PHONE) ?></a></li>
          <li><a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></li>
          <li><?= e(CONTACT_ADDRESS) ?></li>
          <li><a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">WhatsApp booking</a></li>
        </ul>
      </div>
    </div>
    <div class="shell footer-base">
      <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
      <a href="admin/login.php" class="footer-admin">Admin</a>
    </div>
  </footer>

  <a class="wa-float" href="<?= e(whatsapp_link('Hi Nyika Safaris — I want to plan a Kenya trip.')) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path fill="currentColor" d="M17.47 14.38c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.05 1.02-1.05 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/><path fill="currentColor" d="M12.04 2C6.58 2 2.15 6.43 2.15 11.89c0 1.76.46 3.48 1.34 5L2 22l5.27-1.38a9.86 9.86 0 0 0 4.77 1.21h.01c5.46 0 9.89-4.43 9.89-9.89C21.94 6.43 17.5 2 12.04 2zm0 18.06h-.01a8.17 8.17 0 0 1-4.16-1.14l-.3-.18-3.13.82.84-3.05-.2-.31a8.18 8.18 0 0 1-1.26-4.37c0-4.52 3.68-8.2 8.21-8.2 4.52 0 8.2 3.68 8.2 8.2 0 4.53-3.68 8.23-8.19 8.23z"/></svg>
    <span>WhatsApp</span>
  </a>

  <script src="<?= e(asset_url('assets/js/main.js')) ?>" defer></script>
</body>
</html>
