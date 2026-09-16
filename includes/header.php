<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

$page_title = $page_title ?? SITE_NAME;
$page_description = $page_description ?? 'Premium Kenya safari, beach, and private tour experiences with Nyika Safaris.';
$body_class = $body_class ?? '';
$preload_image = $preload_image ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title><?= e($page_title) ?></title>
  <meta name="description" content="<?= e($page_description) ?>">
  <meta name="theme-color" content="#0a2a1f">
  <meta name="color-scheme" content="light">
  <link rel="dns-prefetch" href="https://images.unsplash.com">
  <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" href="<?= e(asset_url('assets/css/style.css')) ?>" as="style">
  <?php if ($preload_image !== ''): ?>
  <link rel="preload" as="image" href="<?= e($preload_image) ?>" fetchpriority="high">
  <?php endif; ?>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600&display=swap" rel="stylesheet"></noscript>
  <link rel="stylesheet" href="<?= e(asset_url('assets/css/style.css')) ?>">
</head>
<body class="<?= e($body_class) ?>">
  <a class="skip-link" href="#main">Skip to content</a>
  <header class="site-header" data-header>
    <div class="shell header-inner">
      <a class="brand" href="index.php" aria-label="<?= e(SITE_NAME) ?> home">
        <span class="brand-mark" aria-hidden="true"></span>
        <span class="brand-text"><?= e(SITE_NAME) ?></span>
      </a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
        <span class="nav-toggle-bar" aria-hidden="true"></span>
        <span class="sr-only">Menu</span>
      </button>
      <nav class="site-nav" id="site-nav" data-nav>
        <a class="nav-link<?= nav_active('index.php') ?>" href="index.php">Home</a>
        <a class="nav-link<?= (current_page() === 'tours.php' || current_page() === 'tour.php') ? ' is-active' : '' ?>" href="tours.php">Tours</a>
        <a class="nav-link<?= nav_active('destinations.php') ?>" href="destinations.php">Destinations</a>
        <a class="nav-link<?= nav_active('vehicles.php') ?>" href="vehicles.php">Transport</a>
        <a class="nav-link<?= nav_active('plan.php') ?>" href="plan.php">Plan</a>
        <a class="nav-link<?= nav_active('about.php') ?>" href="about.php">About</a>
        <a class="nav-link nav-cta<?= nav_active('contact.php') ?>" href="contact.php">Book Now</a>
      </nav>
    </div>
  </header>
  <main id="main">
