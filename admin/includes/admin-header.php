<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_admin();

$admin_page = $admin_page ?? 'dashboard';
$admin_title = $admin_title ?? 'Dashboard';

$nav = [
    'index.php' => ['dashboard', 'Dashboard'],
    'packages.php' => ['packages', 'Packages'],
    'destinations.php' => ['destinations', 'Destinations'],
    'vehicles.php' => ['vehicles', 'Vehicles'],
    'bookings.php' => ['bookings', 'Bookings'],
    'customers.php' => ['customers', 'Customers'],
    'payments.php' => ['payments', 'Payments'],
    'drivers.php' => ['drivers', 'Drivers'],
    'schedules.php' => ['schedules', 'Schedules'],
    'expenses.php' => ['expenses', 'Expenses'],
    'inquiries.php' => ['inquiries', 'Inquiries'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($admin_title) ?> — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="admin-shell">
  <aside class="admin-side">
    <p class="admin-brand"><?= e(SITE_NAME) ?></p>
    <nav class="admin-nav">
      <?php foreach ($nav as $href => [$key, $label]): ?>
        <a href="<?= e($href) ?>" class="<?= $admin_page === $key ? 'is-active' : '' ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
      <a href="../index.php" target="_blank" rel="noopener">View site</a>
      <a href="logout.php">Logout</a>
    </nav>
  </aside>
  <div class="admin-main">
    <div class="admin-top">
      <h1><?= e($admin_title) ?></h1>
      <span class="muted"><?= e(admin_name()) ?></span>
    </div>
    <?php if ($flash = take_flash()): ?>
      <div class="alert alert-<?= e($flash['type'] === 'success' ? 'success' : 'error') ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
