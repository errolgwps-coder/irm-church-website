<?php
require __DIR__ . '/config.php';
$pageTitle = 'Prayer Request';
$errors = [];
$name = '';
$category = 'Personal';
$message = '';
$consent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    // Honeypot field for basic bot filtering.
    if (!empty($_POST['website'])) {
        flash('Thank you. Your request has been received.', 'success');
        header('Location: prayer-request.php'); exit;
    }
    $name = trim((string)($_POST['name'] ?? ''));
    $category = trim((string)($_POST['category'] ?? 'Personal'));
    $message = trim((string)($_POST['message'] ?? ''));
    $consent = isset($_POST['consent']);
    $allowed = ['Personal', 'Family', 'Healing and Strength', 'Guidance and Provision', 'Thanksgiving', 'Other'];
    if (mb_strlen($name) > 100) $errors[] = 'Please keep the name under 100 characters.';
    if (!in_array($category, $allowed, true)) $errors[] = 'Please choose a valid category.';
    if (mb_strlen($message) < 10 || mb_strlen($message) > 3000) $errors[] = 'The message must be 10 to 3000 characters.';
    if (!$consent) $errors[] = 'Please confirm that you understand how your request will be handled.';
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO prayer_requests (name, category, message, status, created_at) VALUES (:name, :category, :message, "Pending", NOW())');
        $stmt->execute(['name' => $name !== '' ? $name : null, 'category' => $category, 'message' => $message]);
        flash('Your prayer request has been submitted privately. Thank you for trusting us.');
        header('Location: prayer-request.php'); exit;
    }
}
require __DIR__ . '/partials/header.php';
?>
<section class="page-hero"><div class="container"><span class="eyebrow">PRAYER & CARE</span><h1>How can we pray for you?</h1><p>Share only what you feel comfortable sharing. Your request is private and is intended for authorized church prayer team members.</p></div></section>
<section class="container form-section">
  <div class="form-panel">
    <div class="d-flex align-items-start gap-3 mb-4"><div class="card-icon">♡</div><div><h2 class="h3">Prayer request form</h2><p class="text-secondary mb-0">Fields marked optional may be left blank.</p></div></div>
    <?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" action="prayer-request.php">
      <?= csrf_field() ?>
      <div class="hp-field" aria-hidden="true"><label>Leave this blank<input name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="mb-3"><label class="form-label" for="name">Name (optional)</label><input class="form-control form-control-lg" id="name" name="name" maxlength="100" value="<?= e($name) ?>" placeholder="You may remain unnamed"></div>
      <div class="mb-3"><label class="form-label" for="category">Prayer category</label><select class="form-select form-select-lg" id="category" name="category"><?php foreach (['Personal','Family','Healing and Strength','Guidance and Provision','Thanksgiving','Other'] as $option): ?><option value="<?= e($option) ?>" <?= $category === $option ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?></select></div>
      <div class="mb-3"><label class="form-label" for="message">Prayer request <span class="text-danger">*</span></label><textarea class="form-control" id="message" name="message" rows="6" minlength="10" maxlength="3000" required placeholder="Share your prayer request..."><?= e($message) ?></textarea><div class="form-text">Please avoid including passwords, financial account details, or other information that is not needed for prayer.</div></div>
      <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="consent" name="consent" required <?= $consent ? 'checked' : '' ?>><label class="form-check-label" for="consent">I understand this request will be stored by the church and viewed by authorized prayer team members for prayer and pastoral care. I will not include information about another person that I do not have permission to share.</label></div>
      <button class="btn btn-primary btn-lg rounded-pill px-4" type="submit">Submit Prayer Request</button>
    </form>
  </div>
  <p class="text-secondary small text-center mt-3">Please note: this form is not an emergency service. If someone is in immediate danger, contact local emergency services or a trusted person nearby.</p>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
