<?php /* DRAFT COPY — review before launch */
/* How we work with enterprises — the terms procurement, legal, IT and security ask about.
   No certifications are claimed. */
$pr_items = [
    ['own',    'You own everything',      'IP, source files, tokens, templates, model weights and logs transfer on delivery. Nothing is retained, resold or used to train anything else.'],
    ['shield', 'Security from day one',   'NDA before discovery, least-privilege access, your single sign-on where available, and data kept in regions we agree in writing.'],
    ['gov',    'Governance built in',     'Decision records, clear ownership and a release cadence, so the brand never depends on us to keep running.'],
    ['switch', 'Independent on tools',    'No partner badges. Model and tool choices are made on evidence, documented and reversible.'],
    ['access', 'Accessible by default',   'Contrast, legibility and reduced motion are part of the system and part of the brand check.'],
    ['team',   'One accountable team',    'A named engagement director and the same leads from discovery to rollout.'],
];
$pr_icons = [
    'own'    => '<path d="M12 3.5 20 7v5c0 4.5-3.4 7.8-8 9-4.6-1.2-8-4.5-8-9V7z"/><path d="m8.5 12 2.4 2.4 4.6-4.8"/>',
    'shield' => '<rect x="4.5" y="10.5" width="15" height="10" rx="2.2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3M12 14.5v2.5"/>',
    'gov'    => '<path d="M4 20h16M6 20V10M10 20V10M14 20V10M18 20V10M3.5 10 12 4l8.5 6z"/>',
    'switch' => '<path d="M4 8h13l-3-3M20 16H7l3 3"/>',
    'access' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="7.8" r="1.2"/><path d="M7.5 10.5 12 11.5l4.5-1M12 11.5V15l-2.2 3.5M12 15l2.2 3.5"/>',
    'team'   => '<circle cx="9" cy="8.5" r="3"/><circle cx="17" cy="9.5" r="2.3"/><path d="M3.5 19.5c.6-3.3 2.8-5 5.5-5s4.9 1.7 5.5 5M14.5 14.8c.8-.5 1.6-.8 2.5-.8 2.1 0 3.6 1.4 4 4"/>',
];
?>
<section class="band bdh-principles" id="principles" aria-labelledby="principles-t">
  <div class="wrap bdh-grid bdh-pr__grid">
    <div class="bdh-c4 bdh-pr__side">
      <div class="bdh-sticky">
        <div class="bdh-head bdh-pr__head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>How we work with enterprises</p>
          <h2 class="h2" id="principles-t"><span class="g">The terms</span> we work on.</h2>
          <p class="lead">Procurement, legal, IT and security teams ask the same questions. Here are the answers before they have to.</p>
        </div>
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
        <figure class="bdh-img bdh-img--r45 bdh-zoom bdh-pr__img" data-rv data-rv-d="100">
          <img src="<?= xe_url('assets/imgs/brand/hub/principles/leadership.jpg') ?>" alt="A leadership team in discussion around a table in natural light" width="1600" height="900" loading="lazy" decoding="async">
        </figure>
      </div>
    </div>

    <ul class="bdh-c7 bdh-s6 bdh-pr__list" data-rv-s data-rv-step="80">
      <?php foreach ($pr_items as $pr_i => $pr_p): ?>
        <li class="bdh-pr__item">
          <span class="bdh-pr__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= $pr_icons[$pr_p[0]] ?></svg></span>
          <span class="bdh-idx"><?= str_pad((string) ($pr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bdh-t"><?= e($pr_p[1]) ?></h3>
          <p class="bdh-d"><?= e($pr_p[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
