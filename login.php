<?php
require __DIR__ . '/config.php';
if (is_admin()) { header('Location: admin/index.php'); exit; }
$pageTitle = 'Admin Login';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: admin/index.php'); exit;
    }
    $error = 'Invalid username or password.';
}
require __DIR__ . '/partials/header.php';
?>
<section class="container form-section"><div class="form-panel login-panel"><span class="eyebrow dark">AUTHORIZED ACCESS</span><h1 class="h2 mt-2">Admin login</h1><p class="text-secondary">Sign in to manage church announcements and private prayer requests.</p>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post"><?= csrf_field() ?><div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control form-control-lg" id="username" name="username" autocomplete="username" required></div><div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control form-control-lg" id="password" name="password" type="password" autocomplete="current-password" required></div><button class="btn btn-primary btn-lg w-100 rounded-pill">Sign in</button></form></div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
