<?php
require __DIR__ . '/config.php';
$pageTitle = 'Welcome';
$events = $pdo->query("SELECT title, description, event_date, location FROM events WHERE is_published = 1 AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3")->fetchAll();
$announcements = $pdo->query("SELECT title, body, created_at FROM announcements WHERE is_published = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();
require __DIR__ . '/partials/header.php';
?>
<header class="hero">
  <div class="container hero-inner">
    <div class="hero-copy">
      <span class="eyebrow">FAITH • FELLOWSHIP • SERVICE</span>
      <h1>Welcome to <span>IRM Church</span></h1>
      <p class="lead">A place to grow in faith, find fellowship, and serve our community.</p>
      <p class="hero-location"><span aria-hidden="true">⌖</span> Minanga, Aparri, Cagayan</p>
      <div class="d-flex flex-wrap gap-2 mt-4">
        <a class="btn btn-gold btn-lg rounded-pill px-4" href="prayer-request.php">Submit a Prayer Request</a>
        <a class="btn btn-outline-light btn-lg rounded-pill px-4" href="#about">Learn About Us</a>
      </div>
      <p class="small text-white-50 mt-3 mb-0">Please confirm official service schedules and contact details with the church.</p>
    </div>
    <div class="hero-symbol" aria-hidden="true"><div class="cross">✝</div><div class="symbol-caption">Faith • Hope • Love</div></div>
  </div>
</header>

<section class="container section-pad" id="about">
  <div class="section-heading"><span class="eyebrow dark">GET TO KNOW US</span><h2>A church family for everyone</h2><p>IRM Church welcomes visitors and members to learn, connect, pray, and take part in church life.</p></div>
  <div class="row g-4 mt-2">
    <div class="col-md-4"><article class="info-card"><div class="card-icon">♡</div><h3>Our Faith</h3><p>A community seeking to grow in faith and live out Christian values.</p></article></div>
    <div class="col-md-4"><article class="info-card"><div class="card-icon">⌂</div><h3>Our Community</h3><p>A place to build meaningful relationships and encourage one another.</p></article></div>
    <div class="col-md-4"><article class="info-card"><div class="card-icon">✦</div><h3>Our Service</h3><p>Opportunities to serve, support, and care for people in our community.</p></article></div>
  </div>
</section>

<section class="soft-section section-pad" id="ministries">
  <div class="container">
    <div class="section-heading"><span class="eyebrow dark">GROW TOGETHER</span><h2>Ministries & fellowship</h2><p>Replace these sample categories with the ministries officially offered by IRM Church.</p></div>
    <div class="row g-3 mt-2">
      <div class="col-sm-6 col-lg-3"><div class="ministry-card"><span>♫</span><h3>Worship</h3><p>Music, praise, and worship service.</p></div></div>
      <div class="col-sm-6 col-lg-3"><div class="ministry-card"><span>✧</span><h3>Youth</h3><p>Faith, fellowship, and youth activities.</p></div></div>
      <div class="col-sm-6 col-lg-3"><div class="ministry-card"><span>♡</span><h3>Prayer</h3><p>Prayer and spiritual encouragement.</p></div></div>
      <div class="col-sm-6 col-lg-3"><div class="ministry-card"><span>✚</span><h3>Community Care</h3><p>Support and service for those in need.</p></div></div>
    </div>
  </div>
</section>

<section class="container section-pad" id="events">
  <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4"><div><span class="eyebrow dark">WHAT'S HAPPENING</span><h2 class="mb-0">Upcoming events</h2></div></div>
  <?php if ($events): ?><div class="row g-3">
    <?php foreach ($events as $event): ?><div class="col-md-4"><article class="event-card"><div class="event-date"><?= e(date('M d, Y', strtotime($event['event_date']))) ?></div><h3><?= e($event['title']) ?></h3><p><?= nl2br(e($event['description'])) ?></p><?php if ($event['location']): ?><small>⌖ <?= e($event['location']) ?></small><?php endif; ?></article></div><?php endforeach; ?>
  </div><?php else: ?><div class="empty-state"><h3>Church events will appear here</h3><p>There are no published upcoming events yet. Check back for updates.</p></div><?php endif; ?>
</section>

<section class="prayer-band">
  <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div><span class="eyebrow">YOU ARE NOT ALONE</span><h2>How can we pray for you?</h2><p class="mb-0">Share a prayer request privately with the church's authorized prayer team.</p></div>
    <a class="btn btn-light btn-lg rounded-pill px-4 flex-shrink-0" href="prayer-request.php">Send a Prayer Request</a>
  </div>
</section>

<section class="container section-pad" id="announcements">
  <div class="section-heading"><span class="eyebrow dark">CHURCH UPDATES</span><h2>Announcements</h2></div>
  <?php if ($announcements): ?><div class="row g-3 mt-2"><?php foreach ($announcements as $item): ?><div class="col-md-4"><article class="event-card"><small class="text-secondary"><?= e(date('M d, Y', strtotime($item['created_at']))) ?></small><h3 class="mt-2"><?= e($item['title']) ?></h3><p><?= nl2br(e($item['body'])) ?></p></article></div><?php endforeach; ?></div><?php else: ?><div class="empty-state"><p class="mb-0">Official church announcements will be posted here.</p></div><?php endif; ?>
</section>

<section class="soft-section section-pad" id="contact">
  <div class="container contact-box"><div><span class="eyebrow dark">VISIT OR CONTACT US</span><h2>We'd be glad to connect.</h2><p class="mb-1"><strong>Location:</strong> Minanga, Aparri, Cagayan</p><p class="text-secondary small mb-0">Official phone number, email, service schedule, and map link should be added after confirmation by church leadership.</p></div><a href="prayer-request.php" class="btn btn-primary rounded-pill px-4">Prayer Request</a></div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
