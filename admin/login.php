<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';

if (admin_logged_in()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $error = 'Invalid session. Try again.';
    } elseif (attempt_login($email, $password)) {
        redirect('index.php');
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin login — <?= e(SITE_NAME) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
  <div class="login-wrap">
    <div class="login-box">
      <h1>Admin</h1>
      <p class="muted"><?= e(SITE_NAME) ?> control panel</p>
      <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required value="<?= e(ADMIN_EMAIL) ?>">
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button class="btn" type="submit">Sign in</button>
      </form>
      <p class="note" style="margin-top:1rem">Default after install: <?= e(ADMIN_EMAIL) ?> / <?= e(ADMIN_DEFAULT_PASSWORD) ?></p>
    </div>
  </div>
</body>
</html>
