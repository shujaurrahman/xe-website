<?php /* DRAFT COPY — review before launch */
/* 11 · Measured in the field. Three outcomes, and each one is drawn as the artefact it is actually read from, not
   as a bar: Core Web Vitals as a CrUX-style distribution with the good / needs-improvement / poor split per metric,
   crash-free sessions as a seven-day line against the 99.5% floor, time to restore as a DORA restore-time
   histogram with the fifteen-minute marker. These are targets we design and budget for, not results we claim.
   Every figure inside an artefact is illustrative and labelled as such. No section JS: the shapes are drawn in the
   HTML and .bdh-grow / .bdh-growY only animate them in, so the section is complete with JavaScript off. */

/* Core Web Vitals, as CrUX reports them: the share of page loads in each band. A URL passes the assessment when
   all three metrics sit in "good" at the 75th percentile — which is the same thing as at least 75% of loads
   landing in the good band. Thresholds: LCP 2.5 s / 4.0 s · INP 200 ms / 500 ms · CLS 0.1 / 0.25. */
$twa_oc_cwv = [
    ['LCP', 'Largest Contentful Paint', '≤ 2.5 s', [78, 15, 7],  '2.1 s'],
    ['INP', 'Interaction to Next Paint', '≤ 200 ms', [84, 11, 5], '164 ms'],
    ['CLS', 'Cumulative Layout Shift',  '≤ 0.1',   [91, 6, 3],   '0.04'],
];
/* crash-free sessions, seven rolling days. Day four is a release that regressed and was rolled back — the point of
   the line is that the floor is what catches it, not a review in the app store. */
$twa_oc_days = [
    ['Mon', 99.72], ['Tue', 99.68], ['Wed', 99.81], ['Thu', 99.42],
    ['Fri', 99.63], ['Sat', 99.78], ['Sun', 99.74],
];
$twa_oc_floor = 99.5;
/* time to restore service, last 18 unplanned restores, in buckets. DORA's elite band is under one hour; we write
   fifteen minutes into the plan because an automatic rollback does not wait for a person to wake up. */
$twa_oc_rest = [
    ['Under 5 min', 9, true], ['5 – 15 min', 6, true], ['15 – 30 min', 2, false], ['30 – 60 min', 1, false], ['Over 60 min', 0, false],
];
$twa_oc_rest_max = max(array_map(fn ($twa_b) => $twa_b[1], $twa_oc_rest));
$twa_oc_rest_tot = array_sum(array_map(fn ($twa_b) => $twa_b[1], $twa_oc_rest));
$twa_oc_rest_in  = array_sum(array_map(fn ($twa_b) => $twa_b[2] ? $twa_b[1] : 0, $twa_oc_rest));

/* the seven-day line, drawn on a 99.0 – 100.0 scale in a 560 × 168 viewBox. The SVG scales uniformly, so
   the day labels are drawn inside it and cannot drift away from the points they name. */
$twa_oc_x = fn (int $twa_i): float => round(30 + $twa_i / (count($twa_oc_days) - 1) * 512, 1);
$twa_oc_y = fn (float $twa_v): float => round(126 - ($twa_v - 99.0) / 1.0 * 108, 1);
$twa_oc_pts = [];
foreach ($twa_oc_days as $twa_i => $twa_d) { $twa_oc_pts[] = $twa_oc_x($twa_i) . ' ' . $twa_oc_y($twa_d[1]); }
$twa_oc_path = 'M' . implode(' L', $twa_oc_pts);

$twa_oc_rows = [
    [
        'k' => 'fast', 'i' => 'gauge', 'art' => 'cwv',
        'n' => 'Fast where it counts',
        'd' => 'Performance budgets are enforced on every merge and measured in the field at the 75th percentile, on the devices and networks your visitors actually have — not on a developer laptop over office wi-fi.',
        'm' => 'Page loads with all three Core Web Vitals in “good”, at p75',
        'target' => 'at least 75%',
        'how' => [
            ['Measured from', 'Chrome UX Report, 28-day rolling, beside your own RUM'],
            ['Read at', 'p75, split by page template and device class'],
            ['Reviewed', 'On every release, and formally at the day-90 tune'],
        ],
        'note' => 'Google treats a URL as passing Core Web Vitals when LCP is 2.5 s or under, INP 200 ms or under and CLS 0.1 or under at p75 — which is the same as at least three quarters of loads landing in the good band. We hold that line on the templates that carry your traffic, not on a single hand-picked page.',
    ],
    [
        'k' => 'stable', 'i' => 'uptime', 'art' => 'line',
        'n' => 'Stable on the devices people actually hold',
        'd' => 'Crash and error reporting is wired before the first release, with symbolicated stack traces and an owner for every alert. Regressions are caught by the release guard, not by a review in the app store.',
        'm' => 'Crash-free sessions, mobile, rolling 7 days',
        'target' => 'at least 99.5%',
        'how' => [
            ['Measured from', 'Crash reporting, wired before the first build ships'],
            ['Read at', 'Sessions, not users, on a rolling seven-day window'],
            ['Reviewed', 'Daily while a release ramps; weekly after that'],
        ],
        'note' => 'The floor sits at 99.5% because the gap between 99.0% and 99.5% is thousands of broken sessions a month at any real volume. The Thursday dip is a release that regressed: the guard rolled it back and the line recovered inside a day.',
    ],
    [
        'k' => 'ship', 'i' => 'rollback', 'art' => 'hist',
        'n' => 'Shippable every sprint, recoverable in minutes',
        'd' => 'Small releases behind flags, a preview environment per change and an automatic rollback wired to real-user data. Recovery is a property of the pipeline, so it does not depend on who is awake.',
        'm' => 'Time to restore service after a bad release',
        'target' => 'under 15 minutes',
        'how' => [
            ['Measured from', 'Deployment and incident records, kept by the pipeline'],
            ['Read at', 'Every unplanned restore, median and worst case'],
            ['Reviewed', 'At every incident review, with the fix owner named'],
        ],
        'note' => 'Time to restore is one of the four DORA delivery metrics; we report it alongside deployment frequency, lead time for changes and change failure rate. DORA’s highest band is under one hour. We write fifteen minutes into the plan because an automatic rollback does not wait for someone to wake up.',
    ],
];
?>
<section class="band twa-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>11 · Outcomes</b><span>Targets we design to · measured at p75</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="outcomes-t"><span class="g">Measured in the field,</span> ninety days after the applause.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">These are the numbers we write into the plan and check against your real traffic, each one read from the instrument it actually comes from. They are targets to design and budget for, agreed with you at kick-off — not results we are promising in advance.</p>
        <!-- PLACEHOLDER: confirm target bands with delivery leadership before launch -->
        <span class="twa-ill">Targets, not results · sample readings</span>
      </div>
    </div>

    <ol class="twa-oc" data-rv role="list">
      <?php foreach ($twa_oc_rows as $twa_i => $twa_o): ?>
        <li class="twa-oc__row">
          <div class="twa-oc__lead">
            <span class="twa-oc__i" aria-hidden="true"><?= xt_icon($twa_o['i'], ['size' => 22]) ?></span>
            <span class="bdh-idx"><?= str_pad((string) ($twa_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="twa-oc__n"><?= e($twa_o['n']) ?></h3>
            <p class="twa-oc__d"><?= e($twa_o['d']) ?></p>
            <dl class="twa-oc__how">
              <?php foreach ($twa_o['how'] as $twa_h): ?>
                <div><dt><?= e($twa_h[0]) ?></dt><dd><?= e($twa_h[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>

          <div class="twa-oc__art">
            <p class="twa-oc__m"><?= e($twa_o['m']) ?></p>

            <?php if ($twa_o['art'] === 'cwv'): ?>
              <!-- a CrUX-style distribution: the share of loads in each band, per metric, against the 75% line -->
              <div class="twa-oc__cwv" aria-hidden="true">
                <?php foreach ($twa_oc_cwv as $twa_ci => $twa_c): ?>
                  <div class="twa-oc__cr" style="--i:<?= $twa_ci ?>">
                    <span class="twa-oc__ck"><b><?= e($twa_c[0]) ?></b><em><?= e($twa_c[2]) ?></em></span>
                    <span class="twa-oc__cb">
                      <i class="twa-oc__cg bdh-grow" style="--i:<?= $twa_ci ?>;width:<?= $twa_c[3][0] ?>%"></i>
                      <i class="twa-oc__cni" style="left:<?= $twa_c[3][0] ?>%;width:<?= $twa_c[3][1] ?>%"></i>
                      <i class="twa-oc__cp" style="left:<?= $twa_c[3][0] + $twa_c[3][1] ?>%;width:<?= $twa_c[3][2] ?>%"></i>
                      <u class="twa-oc__c75"></u>
                    </span>
                    <span class="twa-oc__cv"><b><?= $twa_c[3][0] ?>%</b><em>p75 <?= e($twa_c[4]) ?></em></span>
                  </div>
                <?php endforeach; ?>
                <p class="twa-oc__ckey"><span class="twa-oc__kg">Good</span><span class="twa-oc__kn">Needs improvement</span><span class="twa-oc__kp">Poor</span><span class="twa-oc__k75">75% line</span></p>
              </div>
              <p class="bdh-sr">Sample distribution of page loads by Core Web Vitals band. Largest Contentful Paint: 78 percent good, 15 percent needs improvement, 7 percent poor, with a 75th-percentile value of 2.1 seconds against a 2.5 second threshold. Interaction to Next Paint: 84 percent good, 11 needs improvement, 5 poor, p75 164 milliseconds against 200. Cumulative Layout Shift: 91 percent good, 6 needs improvement, 3 poor, p75 0.04 against 0.1. All three clear the 75 percent line, so the URL passes the assessment.</p>

            <?php elseif ($twa_o['art'] === 'line'): ?>
              <!-- seven rolling days against the 99.5% floor -->
              <div class="twa-oc__line" aria-hidden="true">
                <svg viewBox="0 0 560 168" role="presentation" focusable="false">
                  <?php foreach ([100.0, 99.5, 99.0] as $twa_g): ?>
                    <line class="twa-oc__grid" x1="30" x2="558" y1="<?= $twa_oc_y($twa_g) ?>" y2="<?= $twa_oc_y($twa_g) ?>"/>
                  <?php endforeach; ?>
                  <line class="twa-oc__floorline" x1="30" x2="558" y1="<?= $twa_oc_y($twa_oc_floor) ?>" y2="<?= $twa_oc_y($twa_oc_floor) ?>"/>
                  <path class="twa-oc__path" d="<?= e($twa_oc_path) ?>"/>
                  <?php foreach ($twa_oc_days as $twa_i => $twa_d): ?>
                    <circle class="twa-oc__dot<?= $twa_d[1] < $twa_oc_floor ? ' is-under' : '' ?>" cx="<?= $twa_oc_x($twa_i) ?>" cy="<?= $twa_oc_y($twa_d[1]) ?>" r="<?= $twa_d[1] < $twa_oc_floor ? 5 : 3.5 ?>"/>
                  <?php endforeach; ?>
                  <text class="twa-oc__ax" x="26" y="<?= $twa_oc_y(100.0) + 4 ?>" text-anchor="end">100</text>
                  <text class="twa-oc__ax" x="26" y="<?= $twa_oc_y($twa_oc_floor) + 4 ?>" text-anchor="end">99.5</text>
                  <text class="twa-oc__ax" x="26" y="<?= $twa_oc_y(99.0) + 4 ?>" text-anchor="end">99.0</text>
                  <?php foreach ($twa_oc_days as $twa_i => $twa_d): ?>
                    <text class="twa-oc__ax twa-oc__day" x="<?= $twa_oc_x($twa_i) ?>" y="152" text-anchor="middle"><?= e($twa_d[0]) ?></text>
                  <?php endforeach; ?>
                </svg>
                <p class="twa-oc__lk"><span class="twa-oc__kf">99.5% floor</span><span class="twa-oc__ku">Thursday: a release regressed and the guard rolled it back</span></p>
              </div>
              <p class="bdh-sr">Sample seven-day line of crash-free mobile sessions against a 99.5 percent floor: Monday 99.72, Tuesday 99.68, Wednesday 99.81, Thursday 99.42, Friday 99.63, Saturday 99.78, Sunday 99.74. Thursday is the only day below the floor; a release regressed, the guard rolled it back and the line recovered the next day.</p>

            <?php else: ?>
              <!-- a DORA restore-time histogram with the fifteen-minute marker -->
              <div class="twa-oc__hist" aria-hidden="true">
                <ol class="twa-oc__bars" role="list">
                  <?php foreach ($twa_oc_rest as $twa_bi => $twa_b): ?>
                    <li class="twa-oc__bar<?= $twa_b[2] ? ' is-in' : '' ?>" style="--i:<?= $twa_bi ?>">
                      <span class="twa-oc__bn"><?= $twa_b[1] ?></span>
                      <span class="twa-oc__bt"><i class="bdh-growY" style="--i:<?= $twa_bi ?>;height:<?= $twa_b[1] === 0 ? 2 : round($twa_b[1] / $twa_oc_rest_max * 100) ?>%"></i></span>
                      <span class="twa-oc__bl"><?= e($twa_b[0]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ol>
                <p class="twa-oc__hk"><b><?= $twa_oc_rest_in ?> of <?= $twa_oc_rest_tot ?></b> restores inside the 15-minute target · the marker is the target, not an average</p>
              </div>
              <p class="bdh-sr">Sample histogram of the last eighteen unplanned restores of service: nine under five minutes, six between five and fifteen, two between fifteen and thirty, one between thirty and sixty, none over an hour. Fifteen of the eighteen are inside the fifteen-minute target.</p>
            <?php endif; ?>

            <p class="twa-oc__t"><span class="twa-rt twa-rt--good">Target</span><b><?= e($twa_o['target']) ?></b></p>
            <p class="twa-oc__note"><?= e($twa_o['note']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="twa-oc__base" data-rv data-rv-d="80"><?= xt_icon('target', ['size' => 18]) ?><span><b>Business outcomes are baselined before the work starts.</b> Conversion rate, task completion and drop-off are measured on the existing product, then tracked on the same definitions afterwards, so the comparison is honest. The target for each is set with you at kick-off and reviewed at the day-90 tune.</span></p>
  </div>
</section>
