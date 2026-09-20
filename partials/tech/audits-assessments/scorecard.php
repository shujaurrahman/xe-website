<?php /* DRAFT COPY — review before launch */
/* Scorecard — the board-readable version of the register. Six dimensions, one per audit type, each
   scored 1–5 against a published maturity ladder, with the descriptor that earned the score and the
   descriptor the target level requires. A hexagonal radar carries the same six numbers: the filled
   shape is today, the dashed outline is the target, and the toggle morphs one into the other.
   Both descriptors are always on the page — the toggle changes emphasis and the radar, never what is
   readable. scorecard.js tweens the polygon; without it the radar still shows both shapes. */

$taa_sc_levels = [
    1 => ['Absent',     'Nothing in place, or it exists only in someone’s head.'],
    2 => ['Ad hoc',     'It happens when someone remembers, and differently each time.'],
    3 => ['Repeatable', 'Documented, owned and repeated, but not measured.'],
    4 => ['Managed',    'Measured against a target, with alerts when it drifts.'],
    5 => ['Optimised',  'Improved on evidence, and the improvement is proven by re-test.'],
];

/* k · axis label · name · today · target · today descriptor · target descriptor · badge keys · pill */
$taa_sc_dims = [
    ['security', 'Security', 'Security & compliance', 2, 4,
     'MFA on some admin accounts, audit logging off in two of five cloud accounts, patching done on request.',
     'MFA everywhere including break-glass, centralised audit logs with alerting, patch SLAs measured, cloud settings held against CIS Benchmarks.',
     ['owasp-asvs', 'nist-csf'], ''],
    ['perf', 'Speed', 'Performance & accessibility', 2, 4,
     'Core Web Vitals measured in the lab only; checkout LCP 4.6 s on mobile at p75; accessibility never tested.',
     'Field Core Web Vitals good at p75 — LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1 — a performance budget enforced in CI, WCAG 2.2 AA checked each release.',
     ['cwv', 'wcag22'], ''],
    ['data', 'Data', 'Data & governance', 2, 4,
     'Revenue reported three ways, no metric owner, no catalogue, retention undefined and personal data in analytics exports.',
     'One definition per critical metric with a named owner, quality tests running in the pipeline, retention and consent enforced and evidenced.',
     ['dpdp', 'gdpr'], ''],
    ['search', 'Search', 'Search & AI visibility', 3, 4,
     'Indexation healthy on the main templates, structured data partial and invalid on product pages, no answer-engine baseline.',
     'Templates validated every release, entity coverage complete, citation share tracked on a fixed, dated prompt panel.',
     [], 'schema.org · Google Search Essentials'],
    ['ai', 'AI', 'AI readiness', 1, 3,
     'No model inventory, no evaluation set, knowledge base 40% duplicated, no agreed owner for model output.',
     'Model inventory with approval gates, an evaluation set per use case, a deduplicated and owned retrieval corpus, logged decisions.',
     ['iso42001', 'nist-ai-rmf'], ''],
    ['carbon', 'Carbon', 'Carbon & efficiency', 1, 3,
     'No energy or emissions baseline, two database instances idle above 80% of the month, page weight unbudgeted.',
     'An SCI baseline published per functional unit, right-sizing reviewed monthly against p95 use, page weight budgeted and enforced.',
     ['sci'], ''],
];

$taa_sc_n   = count($taa_sc_dims);
$taa_sc_cx  = 150.0; $taa_sc_cy = 150.0; $taa_sc_rmax = 92.0; $taa_sc_rlab = 112.0;
$taa_sc_ang = function (int $at) use ($taa_sc_n): float { return deg2rad(-90 + (360 / $taa_sc_n) * $at); };
$taa_sc_xy  = function (int $at, float $r) use ($taa_sc_ang, $taa_sc_cx, $taa_sc_cy): array {
    $a = $taa_sc_ang($at);
    return [round($taa_sc_cx + $r * cos($a), 1), round($taa_sc_cy + $r * sin($a), 1)];
};
$taa_sc_poly = function (string $key) use ($taa_sc_dims, $taa_sc_xy, $taa_sc_rmax): string {
    $pts = [];
    foreach ($taa_sc_dims as $at => $dim) {
        $score = $key === 'target' ? $dim[4] : $dim[3];
        $pt = $taa_sc_xy($at, $taa_sc_rmax * ($score / 5));
        $pts[] = $pt[0] . ',' . $pt[1];
    }
    return implode(' ', $pts);
};
$taa_sc_ring = function (float $r) use ($taa_sc_dims, $taa_sc_xy): string {
    $pts = [];
    foreach (array_keys($taa_sc_dims) as $at) { $pt = $taa_sc_xy((int) $at, $r); $pts[] = $pt[0] . ',' . $pt[1]; }
    return implode(' ', $pts);
};
$taa_sc_now = $taa_sc_poly('now');
$taa_sc_tgt = $taa_sc_poly('target');
$taa_sc_avg = function (int $idx) use ($taa_sc_dims): string {
    $sum = 0;
    foreach ($taa_sc_dims as $dim) { $sum += $dim[$idx]; }
    return number_format($sum / count($taa_sc_dims), 1);
};
?>
<section class="band taa-sc" id="scorecard" aria-labelledby="scorecard-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">05</span><span>Scorecard</span></p>
        <h2 class="h2" id="scorecard-t"><span class="g">A scorecard</span> your board can read.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Six dimensions, one score each, against a ladder that is published before the audit starts. The score is not a grade — it is a description of what exists today and what the next level would require.</p>
      </div>
    </header>

    <div class="taa-sc__grid" data-taa-score>

      <div class="taa-sc__panel">
        <div class="taa-sc__ctl">
          <p class="taa-lbl" id="scorecard-view-l">Radar shows</p>
          <div class="taa-sc__seg" role="radiogroup" aria-labelledby="scorecard-view-l" data-taa-view>
            <button type="button" role="radio" data-view="now" aria-checked="true" tabindex="0">Today</button>
            <button type="button" role="radio" data-view="target" aria-checked="false" tabindex="-1">At target</button>
          </div>
        </div>

        <figure class="taa-sc__radar">
          <svg viewBox="0 0 300 300" role="img" aria-labelledby="scorecard-radar-t" data-taa-radar
               data-now="<?= e($taa_sc_now) ?>" data-target="<?= e($taa_sc_tgt) ?>">
            <title id="scorecard-radar-t">Maturity radar: security 2, speed 2, data 2, search 3, AI readiness 1 and carbon 1 out of 5 today, against a target of 4, 4, 4, 4, 3 and 3.</title>
            <g class="taa-sc__rings" aria-hidden="true">
              <?php for ($taa_sc_k = 1; $taa_sc_k <= 5; $taa_sc_k++): ?>
                <polygon points="<?= e($taa_sc_ring($taa_sc_rmax * ($taa_sc_k / 5))) ?>"<?= $taa_sc_k === 5 ? ' class="is-edge"' : '' ?>/>
              <?php endfor; ?>
              <?php foreach (array_keys($taa_sc_dims) as $taa_sc_ai): $taa_sc_pt = $taa_sc_xy((int) $taa_sc_ai, $taa_sc_rmax); ?>
                <line x1="<?= $taa_sc_cx ?>" y1="<?= $taa_sc_cy ?>" x2="<?= $taa_sc_pt[0] ?>" y2="<?= $taa_sc_pt[1] ?>"/>
              <?php endforeach; ?>
            </g>
            <polygon class="taa-sc__tgt" points="<?= e($taa_sc_tgt) ?>" aria-hidden="true"/>
            <polygon class="taa-sc__now" points="<?= e($taa_sc_now) ?>" aria-hidden="true" data-taa-poly />
            <g class="taa-sc__labels" aria-hidden="true">
              <?php foreach ($taa_sc_dims as $taa_sc_li => $taa_sc_ld): $taa_sc_lp = $taa_sc_xy((int) $taa_sc_li, $taa_sc_rlab);
                    $taa_sc_an = $taa_sc_lp[0] > $taa_sc_cx + 4 ? 'start' : ($taa_sc_lp[0] < $taa_sc_cx - 4 ? 'end' : 'middle'); ?>
                <text x="<?= $taa_sc_lp[0] ?>" y="<?= $taa_sc_lp[1] + 3 ?>" text-anchor="<?= $taa_sc_an ?>"><?= e($taa_sc_ld[1]) ?></text>
              <?php endforeach; ?>
            </g>
          </svg>
          <figcaption class="taa-sc__key">
            <span class="taa-sc__k taa-sc__k--now">Today</span>
            <span class="taa-sc__k taa-sc__k--tgt">Target, 12 months</span>
          </figcaption>
        </figure>

        <dl class="taa-sc__avg">
          <div><dt>Overall today</dt><dd><span class="taa-num"><?= $taa_sc_avg(3) ?></span><span class="taa-sc__u">of 5</span></dd></div>
          <div><dt>Overall at target</dt><dd><span class="taa-num"><?= $taa_sc_avg(4) ?></span><span class="taa-sc__u">of 5</span></dd></div>
        </dl>

        <ol class="taa-sc__ladder" role="list">
          <?php foreach ($taa_sc_levels as $taa_sc_lv => $taa_sc_lt): ?>
            <li><span class="taa-sc__lvn"><?= (int) $taa_sc_lv ?></span><b><?= e($taa_sc_lt[0]) ?></b><span><?= e($taa_sc_lt[1]) ?></span></li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="taa-sc__rows" data-rv-s data-rv-step="70">
        <?php foreach ($taa_sc_dims as $taa_sc_d): ?>
          <article class="taa-sc__row" aria-labelledby="scorecard-<?= e($taa_sc_d[0]) ?>-t">
            <div class="taa-sc__rh">
              <h3 class="taa-sc__rn" id="scorecard-<?= e($taa_sc_d[0]) ?>-t"><?= e($taa_sc_d[2]) ?></h3>
              <p class="taa-sc__pips" aria-hidden="true">
                <?php for ($taa_sc_p = 1; $taa_sc_p <= 5; $taa_sc_p++): ?>
                  <i<?= $taa_sc_p <= $taa_sc_d[3] ? ' class="is-now"' : ($taa_sc_p <= $taa_sc_d[4] ? ' class="is-tgt"' : '') ?>></i>
                <?php endfor; ?>
              </p>
              <p class="taa-sc__score">
                <span class="taa-num"><?= (int) $taa_sc_d[3] ?></span>
                <span class="taa-sc__arrow" aria-hidden="true">→</span>
                <span class="taa-sc__t"><?= (int) $taa_sc_d[4] ?></span>
                <span class="bdh-sr">out of 5 today, target <?= (int) $taa_sc_d[4] ?> out of 5</span>
              </p>
            </div>

            <div class="taa-sc__desc">
              <div class="taa-sc__d is-on" data-view="now">
                <p class="taa-lbl">Level <?= (int) $taa_sc_d[3] ?> · <?= e($taa_sc_levels[$taa_sc_d[3]][0]) ?></p>
                <p><?= e($taa_sc_d[5]) ?></p>
              </div>
              <div class="taa-sc__d" data-view="target">
                <p class="taa-lbl">Level <?= (int) $taa_sc_d[4] ?> · <?= e($taa_sc_levels[$taa_sc_d[4]][0]) ?> requires</p>
                <p><?= e($taa_sc_d[6]) ?></p>
              </div>
            </div>

            <div class="taa-sc__std">
              <span class="taa-lbl">Rated against</span>
              <?php if ($taa_sc_d[7]): ?>
                <ul class="xt-badges taa-sc__badges" role="list">
                  <?php foreach ($taa_sc_d[7] as $taa_sc_b) { echo xt_badge($taa_sc_b, ['variant' => 'chip', 'tag' => 'li']); } ?>
                </ul>
              <?php endif; ?>
              <?php if ($taa_sc_d[8]): ?><span class="taa-pill"><?= e($taa_sc_d[8]) ?></span><?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>

        <p class="taa-sc__foot">
          <span class="taa-est">Illustrative</span>
          <span>Scores describe a system at a point in time, not a certificate. Certification against ISO/IEC 27001:2022, ISO/IEC 42001:2023 or SOC 2 is issued by an accredited body after its own audit; what we provide is readiness, evidence and the work to close the gaps. The same six dimensions are re-scored on re-test so progress is measured the same way twice.</span>
        </p>
      </div>

    </div>
  </div>
</section>
