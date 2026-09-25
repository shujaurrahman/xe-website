<?php /* DRAFT COPY — review before launch */
/* Measures — what the programmes above are judged by, and why no percentage appears beside any of
   them. The thresholds quoted are public standards (Core Web Vitals, WCAG 2.2 AA, DORA), not our
   results. The plan panel is the template a measure is agreed with, drawn code-side. */
$wrk_fams = [
    ['gauge', 'Experience', 'Whether the thing is usable by the people it is for, on the devices they own.', [
        ['Core Web Vitals at p75', 'LCP ≤ 2.5 s · INP ≤ 200 ms · CLS ≤ 0.1', 'Google, “good” thresholds'],
        ['Task completion by step', 'measured on the whole path, not the screen', 'defined with you'],
        ['WCAG 2.2 AA conformance', 'audited, with the report attached', 'W3C'],
    ]],
    ['trend-up', 'Adoption', 'Whether people actually use what was built, once the launch noise has stopped.', [
        ['Share of work using the system', 'templates, tokens, journeys', 'defined with you'],
        ['Time from brief to approved', 'the wait, not the effort', 'defined with you'],
        ['Repeat use at 90 days', 'counted, not surveyed', 'defined with you'],
    ]],
    ['bolt', 'Delivery', 'Whether the team can keep changing it safely after we leave.', [
        ['Lead time for change', 'commit to production', 'DORA'],
        ['Change failure rate', 'and time to restore', 'DORA'],
        ['Deployment frequency', 'weekly at minimum', 'DORA'],
    ]],
    ['shield', 'Trust', 'Whether the AI in it can be relied on, and whether a person is still in charge.', [
        ['Eval pass rate', 'on a fixed, versioned set', 'defined with you'],
        ['Grounded-citation rate', 'answers with a source', 'defined with you'],
        ['Escalation to a person', 'reported as a feature, not a fault', 'defined with you'],
    ]],
];
$wrk_plan = [
    ['Baseline', 'Measured before anything changes, from the system of record. Not remembered, not estimated.'],
    ['Target', 'One number and one date, agreed by the person who owns the outcome.'],
    ['Instrument', 'Where the number is read from, who can read it, and what it excludes.'],
    ['Review', 'Same definition, same source, every month — including the months it moves the wrong way.'],
];
?>
<section class="band wrk-meas" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it is measured</p>
        <h2 class="h2" id="measures-t"><span class="g">Measures, not results.</span> The difference matters.</h2>
      </div>
      <div>
        <p class="lead">Every programme in the index lists what it is measured by. None of them lists what it achieved. That is deliberate: a result belongs to the client, and it is published when they approve the number and the wording — not before.</p>
      </div>
    </div>

    <div class="wrk-meas__grid">
      <?php foreach ($wrk_fams as $wrk_i => $wrk_f): ?>
      <article class="wrk-fam bdh-card" data-rv data-rv-d="<?= 40 * $wrk_i ?>">
        <p class="wrk-fam__top"><span class="wrk-fam__i"><?= xt_icon($wrk_f[0], ['size' => 20]) ?></span><span class="bdh-idx"><?= wrk_n($wrk_i + 1) ?></span></p>
        <h3 class="bdh-t bdh-t--l"><?= e($wrk_f[1]) ?></h3>
        <p class="bdh-d"><?= e($wrk_f[2]) ?></p>
        <dl class="wrk-fam__dl">
          <?php foreach ($wrk_f[3] as $wrk_m): ?>
          <div><dt><?= e($wrk_m[0]) ?></dt><dd class="bdh-ro"><?= e($wrk_m[1]) ?></dd><dd class="wrk-fam__src bdh-ro"><?= e($wrk_m[2]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="wrk-meas__plan" data-rv data-rv-d="120">
      <div class="wrk-meas__say">
        <h3 class="bdh-t bdh-t--l">How a measure is agreed</h3>
        <p class="p">Four fields, filled in together in the first weeks, and never quietly re-cut afterwards. A measure that changes definition mid-programme is not a measure.</p>
        <p class="wrk-pending bdh-ro"><?= xt_icon('lock', ['size' => 14]) ?>Results · shared under NDA, pending client approval</p>
      </div>
      <ol class="wrk-plan" data-bdh-stagger data-bdh-in>
        <?php foreach ($wrk_plan as $wrk_i => $wrk_p): ?>
        <li class="bdh-up"><span class="wrk-plan__n bdh-ro"><?= wrk_n($wrk_i + 1) ?></span><div><h4 class="bdh-t bdh-t--s"><?= e($wrk_p[0]) ?></h4><p class="bdh-d"><?= e($wrk_p[1]) ?></p></div></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
