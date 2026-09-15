<?php /* DRAFT COPY — review before launch */
/* Plate 09 — Process ($CAP['process']) as a print run: sketch → proof 1 → proof 2 → press-ready.
   Each phase is a paper sheet that lands on the pile as you step. Beside it: the phase, its weeks,
   the artefacts, and where agents help versus what people decide. process.js drives the stepper. */
$pr = $CAP['process'];
$pr_sheets = ['Sketch', 'Proof 1', 'Proof 2', 'Press-ready'];
$pr_roles = [   // [where agents help, what people decide] — one per $pr['steps'] row
    ['Agents gather and sort category examples, so the audit covers the whole field rather than the first page of results.', 'What the identity must carry, and what it must never look like.'],
    ['Agents mock each direction onto dozens of real touchpoints overnight, using image tools such as Flux or Adobe Firefly per task.', 'Which direction goes forward, in one decision session with the people who own the brand.'],
    ['Agents draft rule examples and check contrast, clear space and voice across every template as it is built.', 'The design itself, and the final wording of every rule.'],
    ['Agents export assets in every format and check each file against the rules before it reaches the library.', 'Sign-off for release, and what changes after the first month in use.'],
];
$pr_rot = [-3.2, 2.4, -1.4, .8];
?>
<section class="cbi-sec cbi-sec--tint cbi-pr" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 09 · Process</span><span>A print run in <?= count($pr['steps']) ?> sheets</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="process-t"><?php /* DRAFT COPY */ ?><span class="g">Sketch to press,</span> one proof at a time.</h2>
      </div>
      <p class="lead"><?= e($pr['lead']) ?></p>
    </div>

    <div class="cbi-pr__grid">
      <div class="cbi-pr__stage" data-cur="3" aria-hidden="true">
        <?php foreach ($pr['steps'] as $pr_i => $pr_s): ?>
        <div class="cbi-pr__sheet cbi-pr__sheet--<?= $pr_i ?> is-down" style="--i:<?= $pr_i ?>;--r:<?= $pr_rot[$pr_i] ?>deg">
          <p class="cbi-pr__slug"><span>Sheet <?= sprintf('%02d', $pr_i + 1) ?> · <?= e($pr_sheets[$pr_i]) ?></span><span><?= e($pr_s[1]) ?></span></p>
          <div class="cbi-pr__art">
            <?php if ($pr_i === 0): ?>
              <svg viewBox="0 0 300 220" class="cbi-pr__sketch"><path d="M60 118c2-40 36-58 64-54 30 4 48 30 44 60-4 32-34 50-62 46-28-3-48-26-46-52z"/><path d="M58 122c6-34 40-56 70-50"/><path d="M178 60l58 2-2 56-58-2z"/><path d="M176 118c38-2 60 22 58 58"/><path d="M230 176c-30 4-54-20-54-56"/><path d="M92 120c0-14 14-24 28-20"/><path d="M40 200c60-8 150-6 230 2" class="thin"/><text x="206" y="46">rough 3</text></svg>
            <?php elseif ($pr_i === 1): ?>
              <div class="cbi-pr__dirs"><?php foreach (['A', 'B', 'C'] as $pr_k => $pr_d): ?><span class="<?= $pr_k === 1 ? 'is-pick' : '' ?>"><i class="cbi-pr__d cbi-pr__d--<?= $pr_k ?>"></i><em>Direction <?= $pr_d ?></em></span><?php endforeach; ?></div>
            <?php elseif ($pr_i === 2): ?>
              <div class="cbi-pr__sys"><svg viewBox="0 0 400 400"><circle cx="150" cy="200" r="100"/><path d="M250 100h100v100h-100z" class="b"/><path d="M250 200h100a100 100 0 0 1-100 100z"/><circle cx="150" cy="200" r="50" class="k"/></svg><span class="cbi-pr__chips"><i></i><i></i><i></i><i></i></span><span class="cbi-pr__aa">Aa</span><span class="cbi-pr__ln"><i></i><i></i><i></i></span></div>
            <?php else: ?>
              <div class="cbi-pr__press">
                <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own imagery before launch -->
                <img src="<?= xe_url('assets/imgs/brand/brand-identity/press-sheet.jpg') ?>" alt="" width="800" height="1200" loading="lazy" decoding="async">
                <span class="cbi-pr__stamp">Approved for release</span>
              </div>
            <?php endif; ?>
          </div>
          <p class="cbi-pr__bars"><i></i><i></i><i></i><i></i><i></i><i></i><span class="cbi-reg"></span></p>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="cbi-pr__side">
        <ol class="cbi-pr__steps" aria-label="Phases">
          <?php foreach ($pr['steps'] as $pr_i => $pr_s): ?>
          <li><button type="button" class="cbi-pr__step" aria-controls="process-p<?= $pr_i ?>" aria-pressed="<?= $pr_i === 3 ? 'true' : 'false' ?>"><span><?= e($pr_sheets[$pr_i]) ?></span><b><?= e($pr_s[0]) ?></b><em><?= e($pr_s[1]) ?></em></button></li>
          <?php endforeach; ?>
        </ol>
        <div class="cbi-pr__panes">
          <?php foreach ($pr['steps'] as $pr_i => $pr_s): ?>
          <div class="cbi-pr__pane<?= $pr_i === 3 ? ' is-on' : '' ?>" id="process-p<?= $pr_i ?>">
            <h3 class="cbi-pr__t"><?= e($pr_s[0]) ?> <span class="g"><?= e($pr_s[1]) ?></span></h3>
            <p class="cbi-pr__desc"><?= e($pr_s[2]) ?></p>
            <p class="cbi-lbl cbi-pr__onl">On this sheet</p>
            <ul class="cbi-pr__arts"><?php foreach ($pr_s[3] as $pr_a): ?><li><?= e($pr_a) ?></li><?php endforeach; ?></ul>
            <dl class="cbi-pr__roles">
              <div><dt>Agents help</dt><dd><?= e($pr_roles[$pr_i][0] ?? '') ?></dd></div>
              <div><dt>People decide</dt><dd><?= e($pr_roles[$pr_i][1] ?? '') ?></dd></div>
            </dl>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="cbi-pr__nav">
          <button type="button" class="cbi-btn" data-go="-1"><span aria-hidden="true">‹</span> Previous sheet</button>
          <button type="button" class="cbi-btn cbi-btn--blue" data-go="1" disabled>Next sheet <span aria-hidden="true">›</span></button>
        </div>
      </div>
    </div>
  </div>
</section>
