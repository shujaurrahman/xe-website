<?php /* DRAFT COPY — review before launch */
/* Confidential — the honest answer to "is this all of it?". Most enterprise work cannot be published, and
   pretending otherwise is what produces invented case studies. Two columns: what is public, and what we can
   show privately; then the three steps to ask for the private version. Nothing here promises a named
   reference: that is always the client's call. */
$wkn_why = [
    ['lock',  'Regulated sectors', 'In financial services, health and the public sector, publication needs a compliance sign-off that is rarely worth the client\'s time.'],
    ['clock', 'Not launched yet',  'A rebrand or a product is confidential until the client announces it. Some of the best work waits a year.'],
    ['doc',   'Procurement terms', 'Many master services agreements simply forbid naming the client in marketing. We sign them anyway.'],
    ['users', 'The client\'s choice', 'A few clients would rather their competitors did not know who builds their systems. That is a good reason.'],
];
$wkn_public = [
    'The sector and the scope of the work',
    'The problem, in terms the client agreed',
    'What we did and what they received',
    'The disciplines and how long it took',
    'What changed, with its baseline and source',
];
$wkn_private = [
    'A walk-through of the real work, screen by screen, under NDA',
    'Anonymised artefacts: the system, the architecture, the eval set',
    'The delivery record: the plan, the gates, the decision log',
    'A reference call with a client who has agreed to take one',
    'The statement of work as a template, with the commercials removed',
];
$wkn_steps = [
    ['Ask',    'Tell us the sector and the problem you are solving. We will say what is relevant.'],
    ['Sign',   'A mutual NDA, signed before anything specific is shared. Usually the same day.'],
    ['See it', 'A working session with the people who built it, not an account manager with a deck.'],
];
?>
<section class="band band--alt wk-confidential" id="confidential" aria-labelledby="confidential-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What is not here</p>
        <h2 class="h2" id="confidential-t"><span class="g">Most of the work</span> cannot be published.</h2>
      </div>
      <div>
        <p class="lead">That is normal for enterprise delivery, and it is the reason agency portfolios are
          so often fiction. We would rather show you a short, honest archive and then show you the rest
          privately.</p>
      </div>
    </div>

    <ul class="wk-confidential__why" data-rv-s data-rv-step="60">
      <?php foreach ($wkn_why as $wkn_w): ?>
        <li>
          <span class="wk-confidential__ico" aria-hidden="true"><?= xt_icon($wkn_w[0], ['size' => 20]) ?></span>
          <h3 class="bdh-t bdh-t--s"><?= e($wkn_w[1]) ?></h3>
          <p class="bdh-d"><?= e($wkn_w[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="wk-confidential__split" data-rv data-rv-d="70">
      <div class="wk-confidential__col">
        <p class="wk-k">Published here, for every record</p>
        <ul class="wk-confidential__list">
          <?php foreach ($wkn_public as $wkn_p): ?>
            <li><span class="wk-tick" aria-hidden="true">✓</span><?= e($wkn_p) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="wk-confidential__col wk-confidential__col--nda">
        <p class="wk-k">Shown privately, under NDA</p>
        <ul class="wk-confidential__list">
          <?php foreach ($wkn_private as $wkn_p): ?>
            <li><span class="wk-tick" aria-hidden="true">✓</span><?= e($wkn_p) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="wk-note">A reference call depends on the client agreeing to take one. We ask; we never
          assume.</p>
      </div>
    </div>

    <ol class="wk-confidential__steps" data-rv-s data-rv-step="80">
      <?php foreach ($wkn_steps as $wkn_i => $wkn_s): ?>
        <li>
          <span class="bdh-idx"><?= str_pad((string) ($wkn_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bdh-t bdh-t--s"><?= e($wkn_s[0]) ?></h3>
          <p class="bdh-d"><?= e($wkn_s[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="wk-confidential__cta" data-rv>
      <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Ask to see the work <span class="i" aria-hidden="true">›</span></a>
      <!-- PLACEHOLDER: confirm the NDA turnaround and first-call format before launch -->
      <span class="wk-note">Typically a mutual NDA the same day, then a working session with the team that
        built it.</span>
    </p>
  </div>
</section>
