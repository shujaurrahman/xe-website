<?php /* DRAFT COPY — review before launch */
/* Confidential — why no logos, and what comes off once an NDA is signed. The case sheet is the same
   record the index shows, with the parts we are not free to publish blacked out, so the redaction is
   the argument rather than an illustration of it. */
$wrk_after = [
    ['users',  'Who it was', 'The client, the market and the team that ran it.'],
    ['chart',  'The numbers', 'Baseline, target and where it landed, with the source named.'],
    ['layers', 'The artefacts', 'The real screens, the real templates, the real pipelines.'],
    ['headset','The referee', 'A client lead who will take your call and answer plainly.'],
];
?>
<section class="band band--alt wrk-nda" id="confidential" aria-labelledby="confidential-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Why there are no logos</p>
        <h2 class="h2" id="confidential-t"><span class="g">Confidential by default.</span> Detail on request.</h2>
      </div>
      <div>
        <p class="lead">A logo wall is the cheapest thing an agency can publish and the least it can prove. We would rather show the brief, the system and the measures — and hand over the rest in a room, under an agreement, to people who are actually evaluating us.</p>
      </div>
    </div>

    <div class="wrk-nda__grid">
      <ol class="wrk-nda__list" data-bdh-stagger data-bdh-in>
        <li class="bdh-up"><span class="bdh-idx">01</span><div><h3 class="bdh-t bdh-t--l">Names stay theirs</h3><p class="bdh-d">Much of this work sits inside regulated launches and unannounced products. Permission to be named is a decision for the client’s communications and legal teams, not for us, and we ask for it in writing or not at all.</p></div></li>
        <li class="bdh-up"><span class="bdh-idx">02</span><div><h3 class="bdh-t bdh-t--l">Walk-throughs under NDA</h3><p class="bdh-d">Once an NDA is in place, the redactions come off for a relevant programme: the system as built, the artefacts, the baseline and where it landed, and the parts that did not work.</p></div></li>
        <li class="bdh-up"><span class="bdh-idx">03</span><div><h3 class="bdh-t bdh-t--l">References, not testimonials</h3><p class="bdh-d">For a shortlisted engagement we connect you with a client lead who ran the programme. A conversation you control is worth more than a sentence we chose.</p></div></li>
      </ol>

      <figure class="wrk-sheet-f bdh-ui">
        <div aria-hidden="true">
          <div class="wrk-sheetf__bar bdh-ro"><span><span class="bdh-pulse"></span>Case sheet · before NDA</span><span class="wrk-sheetf__st">Redacted</span></div>
          <dl class="wrk-sheetf__dl">
            <div><dt class="bdh-ro">Client</dt><dd><span class="wrk-red" style="--w:11"></span></dd></div>
            <div><dt class="bdh-ro">Sector</dt><dd>Consumer health · 9 markets</dd></div>
            <div><dt class="bdh-ro">Brief</dt><dd>Hold one brand across nine markets without slowing any of them down.</dd></div>
            <div><dt class="bdh-ro">System</dt><dd>Tokens, claims library, pack architecture, <span class="wrk-red" style="--w:7"></span></dd></div>
            <div><dt class="bdh-ro">Team</dt><dd><span class="wrk-red" style="--w:5"></span> · <span class="wrk-red" style="--w:8"></span></dd></div>
            <div><dt class="bdh-ro">Results</dt><dd><span class="wrk-red" style="--w:5"></span> faster to approved asset · <span class="wrk-red" style="--w:4"></span> first-time pass</dd></div>
            <div><dt class="bdh-ro">Contact</dt><dd><span class="wrk-red" style="--w:9"></span></dd></div>
          </dl>
          <div class="wrk-sheetf__foot bdh-ro"><span>Shared after NDA</span><span>Names · figures · artefacts</span></div>
        </div>
        <figcaption class="bdh-sr">Illustration: a programme case sheet before an NDA, with the client name, the team, the figures and the contact blacked out, and the sector, the brief and the system left readable.</figcaption>
      </figure>
    </div>

    <div class="wrk-nda__after" data-rv data-rv-d="90">
      <p class="bdh-ro wrk-nda__ah">What comes off, once the agreement is signed</p>
      <ul class="wrk-nda__chips">
        <?php foreach ($wrk_after as $wrk_a): ?>
        <li><span class="wrk-nda__ci"><?= xt_icon($wrk_a[0], ['size' => 18]) ?></span><b><?= e($wrk_a[1]) ?></b><span><?= e($wrk_a[2]) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a class="btn btn--out" href="<?= xe_url('contact.php') ?>">Ask for a walk-through <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
