<?php
require __DIR__ . '/config.php';
$count = (int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$message = '';
if ($count > 0) {
    http_response_code(403);
    exit('An admin already exists. Delete setup-admin.php from the server.');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if (!preg_match('/^[A-Za-z0-9_.-]{4,40}$/', $username)) {
        $message = 'Username must be 4–40 characters and use letters, numbers, dots, underscores, or hyphens.';
    } elseif (strlen($password) < 12) {
        $message = 'Use a password with at least 12 characters.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO admins (username, password_hash, created_at) VALUES (?, ?, NOW())');
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
        echo '<!doctype html><meta charset="utf-8"><title>Admin created</title><p>Admin created. Delete setup-admin.php from the server immediately, then <a href="login.php">sign in</a>.</p>';
        exit;
    }
}
?><!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Create first admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><body class="bg-light"><main class="container py-5" style="max-width:560px"><div class="card p-4 shadow-sm"><h1 class="h3">Create first admin</h1><p>One-time setup only. Delete this file after creating the account.</p><?php if ($message): ?><div class="alert alert-danger"><?= e($message) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><label class="form-label" for="username">Username</label><input class="form-control mb-3" id="username" name="username" required minlength="4" maxlength="40"><label class="form-label" for="password">Password (12+ characters)</label><input class="form-control mb-3" id="password" name="password" type="password" required minlength="12"><button class="btn btn-primary">Create admin</button></form></div></main></body></html>
