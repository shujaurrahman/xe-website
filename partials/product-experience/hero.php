<?php /* DRAFT COPY — review before launch */
/* Hero — the discipline's promise: decide what to build, and prove it before you build it.
   Text on paper, left. Right: an ink panel holding the thing this discipline actually produces before
   anyone commits — a prototype with a real person's session traced across it. The HTML is the finished
   state (the trace fully drawn, the friction ring in place, readouts at their values); hero.js runs a
   marker along the trace, types the session notes and drifts the readouts while the panel is on screen.
   Reduced motion keeps the static state.
   PLACEHOLDER: every readout and session note below is illustrative, not a client result. */
$hero_read = [
    // [key, label, value, unit]
    ['task',  'Task success',  '86',  '%'],
    ['time',  'Time on task',  '41',  's'],
    ['sus',   'SUS',           '78',  '/ 100'],
    ['round', 'Round',         '6',   'of 6'],
];
/* the session tape: what a moderator actually writes down, one line at a time */
$hero_tape = [
    ['P07', '00:12', 'reads the summary first, ignores the top nav'],
    ['P07', '00:38', 'hesitates at “delivery options” — expects the price here'],
    ['P07', '01:04', 'goes back a step to check the address'],
    ['P07', '01:26', 'completes, then asks whether it saved'],
    ['P08', '00:09', 'tabs straight to the form, never uses the mouse'],
    ['P08', '00:44', 'same hesitation at “delivery options”'],
    ['P08', '01:11', 'completes · 71 s · no errors'],
];
/* the traced session, in the wireframe's own 640 × 300 coordinates. Each leg starts and ends at a
   control, never through one. The ring sits on the step people hesitate at. */
$hero_trace = 'M92 91 L92 119 L92 147 L300 95 L300 129 L188 163 L92 179 L300 163 L470 123 L470 171 L498 211';
/* where the participant stopped — one dwell dot per turn in the trace above */
$hero_dwell = [[92, 91], [92, 119], [92, 147], [300, 95], [300, 129], [188, 163], [92, 179], [300, 163], [470, 123], [470, 171], [498, 211]];
?>
<section class="pxh-hero" id="top" aria-labelledby="hero-t">
  <span class="pxh-hero__bg" aria-hidden="true"><span class="pxh-hero__grid dots"></span></span>

  <div class="wrap pxh-hero__in">
    <div class="pxh-hero__text">
      <p class="lbl lbl--blue pxh-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="pxh-hero__h pxh-hero__up" id="hero-t" style="--i:1"><span class="g">Decide what to build.</span> Prove it before you build it.</h1>
      <p class="lead pxh-hero__lead pxh-hero__up" style="--i:2"><?= e($DISC['intro']) ?></p>
      <div class="pxh-hero__act pxh-hero__up" style="--i:3">
        <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'product-experience')) ?>">Start a product brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#proving">Put a bet through the proof <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="pxh-hero__proof pxh-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
        <div><dt>Scope</dt><dd>Research → front end</dd></div>
        <div><dt>Standard</dt><dd>WCAG 2.2 AA</dd></div>
      </dl>
    </div>

    <div class="pxh-hero__vis">
      <p class="bdh-sr">A prototype of a three-step checkout with one participant's session traced across it. The trace doubles back at the delivery-options step, which is ringed as the point people hesitate. Illustrative readouts report task success of 86 per cent, 41 seconds on task, a System Usability Scale score of 78 out of 100, and round 6 of 6. Six of the eight participants hesitated at the same step.</p>

      <div class="pxh-panel pxh-panel--ink pxh-hero__panel" aria-hidden="true" data-bdh-in data-bdh-live>
        <div class="pxh-panel__bar">
          <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
          <span class="pxh-panel__name">checkout-v3 <i>/</i> usability round 6</span>
          <span class="pxh-panel__pill">moderated · remote</span>
          <span class="pxh-panel__ill">Illustrative</span>
          <span class="pxh-live"><i class="bdh-pulse"></i>Session</span>
        </div>

        <div class="pxh-hero__stage">
          <svg viewBox="0 0 640 250" fill="none" focusable="false">
            <!-- step rail -->
            <g class="pxh-hero__rail">
              <path d="M92 22 H470"/>
              <circle cx="92" cy="22" r="5"/><circle cx="300" cy="22" r="5"/><circle cx="470" cy="22" r="5" class="is-last"/>
            </g>
            <!-- the three screens of the prototype, plus the one not designed yet -->
            <g class="pxh-hero__screens">
              <rect x="20" y="42" width="144" height="196" rx="9"/>
              <rect x="228" y="42" width="144" height="196" rx="9"/>
              <rect x="398" y="42" width="144" height="196" rx="9"/>
              <rect x="566" y="42" width="54" height="196" rx="9" class="is-ghost"/>
            </g>
            <g class="pxh-hero__ui">
              <!-- screen 1: details -->
              <rect x="36" y="54" width="52" height="7" rx="3.5" class="is-lbl"/>
              <rect x="36" y="80" width="112" height="22" rx="6"/>
              <rect x="36" y="108" width="112" height="22" rx="6"/>
              <rect x="36" y="136" width="112" height="22" rx="6"/>
              <rect x="36" y="168" width="112" height="22" rx="6" class="is-ghost"/>
              <rect x="36" y="206" width="60" height="22" rx="11" class="is-cta"/>
              <!-- screen 2: delivery options -->
              <rect x="244" y="54" width="66" height="7" rx="3.5" class="is-lbl"/>
              <rect x="244" y="82" width="112" height="26" rx="6"/>
              <rect x="244" y="116" width="112" height="26" rx="6" class="is-hot"/>
              <rect x="244" y="150" width="112" height="26" rx="6"/>
              <rect x="244" y="206" width="60" height="22" rx="11" class="is-cta"/>
              <!-- screen 3: confirm -->
              <rect x="414" y="54" width="44" height="7" rx="3.5" class="is-lbl"/>
              <rect x="414" y="80" width="112" height="7" rx="3.5" class="is-ghost"/>
              <rect x="414" y="94" width="86" height="7" rx="3.5" class="is-ghost"/>
              <rect x="414" y="112" width="112" height="22" rx="6"/>
              <rect x="414" y="160" width="112" height="22" rx="6"/>
              <rect x="470" y="200" width="56" height="22" rx="11" class="is-cta"/>
            </g>
            <!-- the traced session: drawn in full in the shipped markup -->
            <path class="pxh-hero__trace bdh-draw" d="<?= e($hero_trace) ?>" pathLength="1"/>
            <g class="pxh-hero__dwell">
              <?php foreach ($hero_dwell as $hero_i => $hero_p): ?><circle cx="<?= $hero_p[0] ?>" cy="<?= $hero_p[1] ?>" r="<?= $hero_i === count($hero_dwell) - 1 ? 3.6 : 2.6 ?>"<?= $hero_i === count($hero_dwell) - 1 ? ' class="is-end"' : '' ?>/><?php endforeach; ?>
            </g>
            <path class="pxh-hero__mark" d="<?= e($hero_trace) ?>" pathLength="1"/>
            <!-- where people hesitate -->
            <circle class="pxh-hero__ring" cx="300" cy="129" r="19"/>
          </svg>
          <p class="pxh-hero__legend"><span class="is-trace">Session trace · P07</span><span class="is-ring">Hesitation · delivery options</span><span class="is-n">6 of 8 hesitated here</span></p>
        </div>

        <p class="pxh-hero__tape" data-tape="<?= e(json_encode($hero_tape, JSON_UNESCAPED_UNICODE)) ?>">
          <span class="pxh-hero__tp">›</span><span class="pxh-hero__tw"><?= e($hero_tape[0][0]) ?></span><span class="pxh-hero__tt"><?= e($hero_tape[0][1]) ?></span><span class="pxh-hero__tx"><span class="pxh-hero__txt"><?= e($hero_tape[0][2]) ?></span><span class="bdh-caret"></span></span>
        </p>

        <!-- PLACEHOLDER: illustrative readouts, not a client result — confirm before launch -->
        <dl class="pxh-read pxh-hero__read">
          <?php foreach ($hero_read as $hero_r): ?>
            <div><dt><?= e($hero_r[1]) ?></dt><dd><b data-k="<?= e($hero_r[0]) ?>"><?= e($hero_r[2]) ?></b> <?= e($hero_r[3]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>

  <div class="wrap pxh-hero__foot">
    <p class="pxh-k pxh-hero__fk">The five capabilities</p>
    <ul class="pxh-capls pxh-hero__caps" role="list">
      <?php foreach ($CAPS as $hero_c): ?>
        <li><a class="pxh-capl" href="#<?= e($hero_c['slug']) ?>"><b><?= e($hero_c['n']) ?></b><span><?= e($hero_c['name']) ?></span><i aria-hidden="true">›</i></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
