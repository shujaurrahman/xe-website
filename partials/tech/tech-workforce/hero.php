<?php /* DRAFT COPY — review before launch */
/* Hero — photo mosaic with a text tile. A 12-column, 3-row mosaic of six restrained editorial
   photographs; a paper tile holds cols 1–6 of rows 1–2 with the eyebrow, h1, lead and the two CTAs.
   Every photo carries a role chip; a thin "Your sprint" board strip runs along the bottom and
   collects the same chips. hero.js flies the chips down into the strip while the hero is on screen.
   The HTML is the finished state: chips are in the strip already. */
$ttw_hr_photos = [   // [file, alt, area key, role, skills, object-position]
    ['pairing.jpg', 'Two engineers reviewing code together on a monitor in an open office', 'a', 'Senior backend', 'Go · Kubernetes', '50% 40%'],
    ['standup.jpg', 'A team gathered around a whiteboard while a colleague walks through a plan',  'b', 'Delivery manager', 'Sprint cadence', '50% 45%'],
    ['review.jpg',  'Four colleagues gathered around a desktop screen, one pointing at the work under discussion', 'c', 'Tech lead', 'Architecture · review', '50% 40%'],
    ['focus.jpg',   'A developer pointing at a laptop screen of code while a colleague leans in',  'd', 'ML engineer', 'RAG · evals', '50% 45%'],
    ['remote.jpg',  'An engineer working through an editor full of code at a table at home',       'e', 'Frontend', 'React · TypeScript', '55% 45%'],
    ['desk.jpg',    'A hand typing on a laptop keyboard beside an open notebook and a pencil',     'f', 'QA automation', 'Playwright', '50% 50%'],
];
$ttw_hr_meta = [
    ['Typical start',  '2–4 weeks'],            // PLACEHOLDER: confirm typical start time before launch
    ['Models',         'Individual · pod · squad · BOT'],
    /* The full contracted range across the five zones on this page: US East 3 h at the low end,
       the Gulf 8.5 h at the top. #overlap and #composer both show the per-zone figures. */
    ['Overlap',        '3–8.5 h with your day'],
];
?>
<section class="band ttw-hero" id="hero" aria-labelledby="hero-t">
  <span class="ttw-hero__wall dots" aria-hidden="true"></span>
  <div class="wrap">
    <nav class="ttw-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology &amp; Intelligence') ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>
  </div>

  <div class="wrap ttw-hero__in" data-ttw-arm>

    <div class="ttw-hero__mosaic">
      <div class="ttw-hero__tile">
        <p class="ttw-kick"><span class="ttw-kick__ref">Capability 10 / 10</span><span>Your stack, your cadence</span></p>
        <h1 class="ttw-hero__h" id="hero-t"><span class="g">Engineers who join your sprint,</span> not your hiring queue.</h1>
        <p class="lead ttw-hero__lead">Vetted engineers, AI specialists and full delivery squads embedded in your team. They work in your repositories, your tools and your ceremonies, with a delivery manager and sprint reporting that make the capacity accountable.</p>
        <div class="ttw-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Tell us the squad you need <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#composer">Build a squad <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

      <!-- PLACEHOLDER: reference photographs (Unsplash) — confirm before launch. Role chips are illustrative. -->
      <?php foreach ($ttw_hr_photos as $ttw_hp): ?>
        <figure class="ttw-hero__ph ttw-hero__ph--<?= e($ttw_hp[2]) ?>">
          <img src="<?= e(xe_url('assets/imgs/tech/tech-workforce/' . $ttw_hp[0])) ?>" alt="<?= e($ttw_hp[1]) ?>"
               width="700" height="467" loading="<?= $ttw_hp[2] === 'a' ? 'eager' : 'lazy' ?>" decoding="async"
               style="object-position:<?= e($ttw_hp[5]) ?>">
          <figcaption class="ttw-chip ttw-hero__rc" data-ttw-fly="<?= e($ttw_hp[2]) ?>">
            <span class="ttw-chip__d" aria-hidden="true"></span><?= e($ttw_hp[3]) ?><span class="ttw-chip__s"><?= e($ttw_hp[4]) ?></span>
          </figcaption>
        </figure>
      <?php endforeach; ?>

      <p class="ttw-hero__ov" aria-hidden="true"><span class="ttw-led ttw-led--pulse"></span>IST&nbsp;↔&nbsp;UK overlap 4.5&nbsp;h</p>
    </div>

    <div class="ttw-hero__strip" aria-hidden="true">
      <p class="ttw-hero__sh"><span class="ttw-hero__sl">Your sprint</span><span class="ttw-ro">Sprint 24 · day 1 of 10</span></p>
      <ul class="ttw-hero__sq" role="list">
        <?php foreach ($ttw_hr_photos as $ttw_hp): ?>
          <li><span class="ttw-chip" data-ttw-seat="<?= e($ttw_hp[2]) ?>"><span class="ttw-chip__d"></span><?= e($ttw_hp[3]) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <p class="ttw-hero__sr"><span class="ttw-hero__ready">Squad ready · 6 roles</span></p>
    </div>
    <p class="bdh-sr">An illustrative squad strip. Six role chips — senior backend, delivery manager, tech lead, machine-learning engineer, frontend and QA automation — move from the photographs into a sprint board marked “Sprint 24, day 1 of 10”, which then reads “Squad ready, 6 roles”. A readout shows an overlap of four and a half hours between Indian Standard Time and the United Kingdom.</p>

    <dl class="ttw-hero__meta">
      <?php foreach ($ttw_hr_meta as $ttw_hm): ?>
        <div><dt><?= e($ttw_hm[0]) ?></dt><dd><?= e($ttw_hm[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

  </div>
</section>
