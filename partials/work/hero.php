<?php /* DRAFT COPY — review before launch */
/* Hero — the page opens as a contact sheet: five plates from the work beside the statement that
   explains why none of them carries a client's name. The ledger under it counts what the page holds,
   from data/work.php, so it can never disagree with the index below. */
$wrk_used = [];
foreach ($wrk_cases as $wrk_c) foreach ($wrk_c['did'] as $wrk_x) $wrk_used[$wrk_x[0]] = true;
$wrk_live = 0;
foreach ($wrk_cases as $wrk_c) if ($wrk_has($wrk_c['slug'])) $wrk_live++;

/* PLACEHOLDER reference plates — assets/imgs/work/CREDITS.md. Replace with own project photography. */
$wrk_sheet = [
    ['file' => 'hero-atrium.jpg',    'alt' => 'Travellers crossing a vaulted station concourse under a ribbed concrete roof', 'w' => 1080, 'h' => 1920, 'pos' => '50% 46%', 'k' => 'a', 'cap' => 'Environment'],
    ['file' => 'hero-wall.jpg',      'alt' => 'Two people arranging sticky notes into columns on a glass wall',               'w' => 1800, 'h' => 1200, 'pos' => '50% 45%', 'k' => 'b', 'cap' => 'Strategy'],
    ['file' => 'hero-desk.jpg',      'alt' => 'An operations desk with two monitors and a keyboard, lit from the side',       'w' => 1600, 'h' => 1067, 'pos' => '50% 50%', 'k' => 'c', 'cap' => 'Product'],
    ['file' => 'hero-revisions.jpg', 'alt' => 'Two people signing a printed document at a desk',                              'w' => 1400, 'h' => 1050, 'pos' => '50% 55%', 'k' => 'd', 'cap' => 'Approval'],
    ['file' => 'hero-docs.jpg',      'alt' => 'A team reading documentation together at a laptop',                            'w' => 1200, 'h' => 900,  'pos' => '50% 45%', 'k' => 'e', 'cap' => 'Handover'],
];
?>
<section class="band wrk-hero" id="top" aria-labelledby="wrk-hero-t">
  <div class="wrap">
    <div class="wrk-hero__grid">

      <div class="wrk-hero__say">
        <p class="lbl lbl--blue"><span class="dot"></span>Selected work · anonymised</p>
        <h1 class="d1" id="wrk-hero-t"><span class="g">Delivered.</span> Named only with permission.</h1>
        <p class="lead wrk-hero__lead">Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it. Our clients’ names stay theirs — so each programme is told through its brief, the system we built, the artefacts it left behind and how it is measured.</p>
        <div class="wrk-hero__cta">
          <a class="btn btn--ink btn--lg" href="#programmes">Browse <?= count($wrk_cases) ?> programmes <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#featured">The featured case <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

      <div class="wrk-sheet-wrap" data-rv data-rv-d="80">
        <p class="wrk-sheet__bar bdh-ro" aria-hidden="true">
          <span><span class="bdh-pulse"></span>contact sheet</span>
          <span>work / <?= wrk_n(count($wrk_cases)) ?> programmes</span>
        </p>
        <div class="wrk-sheet" data-bdh-stagger data-bdh-in>
          <?php foreach ($wrk_sheet as $wrk_i => $wrk_p): ?>
            <?= wrk_img($wrk_p, [
                'ratio'    => '',
                'class'    => 'bdh-up wrk-sheet__p wrk-sheet__p--' . $wrk_p['k'],
                'eager'    => $wrk_i < 2,
                'parallax' => $wrk_i === 0 ? '0.05' : '',
                'inner'    => '<span class="wrk-sheet__n bdh-ro" aria-hidden="true">' . wrk_n($wrk_i + 1) . '</span>'
                            . '<span class="wrk-sheet__cap bdh-ro" aria-hidden="true">' . e($wrk_p['cap']) . '</span>',
            ]) ?>
          <?php endforeach; ?>
        </div>
        <p class="wrk-sheet__foot bdh-ro">Reference plates · <a class="tl" href="#confidential">why there are no logos</a></p>
      </div>

    </div>

    <dl class="wrk-led" aria-label="What this page holds">
      <div><dt>Programmes on this page</dt><dd><?= count($wrk_cases) ?></dd></div>
      <div><dt>With a full case page</dt><dd><?= $wrk_live ?> of <?= count($wrk_cases) ?></dd></div>
      <div><dt>Disciplines involved</dt><dd><?= count($wrk_used) ?> of <?= count($wrk_disc) ?></dd></div>
      <div><dt>Sectors covered</dt><dd><?= count(array_unique(array_column($wrk_cases, 'industry'))) ?></dd></div>
      <div class="wrk-led--wide"><dt>Clients named</dt><dd>None, by design — names are shared only with written permission</dd></div>
    </dl>
  </div>
</section>
