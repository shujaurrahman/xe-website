<?php /* DRAFT COPY — review before launch */
/* 01 · Lab vs field. A real-user-monitoring panel: p75 LCP on mobile for the 90 days after launch, for an unmanaged
   site (it drifts into "poor" as tags, video and scripts pile on) and a budgeted one (CI catches each addition).
   Lines draw with scroll, pins drop at each event, and a day scrubber reads both series. Beside it, two real-usage
   photographs; below, the three facts behind field data. Every number is illustrative. */
$twa_fd_ev = [   // day, what was added, unmanaged effect, what the budget did
    [12, 'Marketing tags added',       '+0.5 s', 'Loaded after consent · +0.1 s'],
    [34, 'Autoplay hero video',        '+0.9 s', 'Budget failed the PR · poster image shipped'],
    [58, 'Client-side A/B test script', '+0.5 s', 'Moved to the edge · no client script'],
    [77, 'Chat widget on every page',  '+0.5 s', 'Loads on first interaction'],
];
$twa_fd_keys = [   // [day, p75 LCP seconds] keyframes; days between are interpolated with a little daily noise
    'u' => [[0, 2.2], [11, 2.24], [12, 2.72], [33, 2.86], [34, 3.76], [57, 3.9], [58, 4.38], [76, 4.52], [77, 5.02], [90, 5.08]],
    'b' => [[0, 2.1], [11, 2.12], [12, 2.36], [14, 2.16], [33, 2.14], [34, 2.46], [36, 2.12], [57, 2.1], [58, 2.28], [60, 2.12], [76, 2.12], [77, 2.34], [79, 2.1], [90, 2.06]],
];
$twa_fd_series = function (array $k, float $seed): array {
    $out = [];
    $n = count($k);
    for ($d = 0; $d <= 90; $d++) {
        $v = $k[$n - 1][1];
        for ($j = 1; $j < $n; $j++) {
            if ($d <= $k[$j][0]) {
                $a = $k[$j - 1]; $b = $k[$j];
                $t = $b[0] === $a[0] ? 1 : ($d - $a[0]) / ($b[0] - $a[0]);
                $v = $a[1] + ($b[1] - $a[1]) * $t;
                break;
            }
        }
        $v += 0.035 * sin($d * 1.7 + $seed) + 0.025 * sin($d * 0.47 + $seed * 2);
        $out[] = round($v, 2);
    }
    return $out;
};
$twa_fd_u = $twa_fd_series($twa_fd_keys['u'], 0.4);
$twa_fd_b = $twa_fd_series($twa_fd_keys['b'], 1.9);
$twa_fd_x = fn (float $d): float => round(56 + $d / 90 * 640, 1);
$twa_fd_y = fn (float $v): float => round(272 - $v / 6 * 248, 1);
$twa_fd_path = function (array $s) use ($twa_fd_x, $twa_fd_y): string {
    $p = [];
    foreach ($s as $twa_d => $twa_v) { $p[] = $twa_fd_x($twa_d) . ' ' . $twa_fd_y($twa_v); }
    return 'M' . implode(' L', $p);
};
$twa_fd_rate = fn (float $v): array => $v <= 2.5 ? ['good', 'Good'] : ($v <= 4 ? ['ni', 'Needs improvement'] : ['poor', 'Poor']);
$twa_fd_ph = [
    ['src' => 'assets/imgs/tech/websites-apps/field-outdoor-phone.jpg', 'w' => 1400, 'h' => 920, 'pos' => '46% 38%', 'alt' => 'A woman outdoors among trees, reading something on her phone', 'k' => 'Real device', 'v' => 'Mid-range Android · 4G, two bars'],
    ['src' => 'assets/imgs/tech/websites-apps/field-rain-street.jpg',   'w' => 1400, 'h' => 937, 'pos' => '50% 55%', 'alt' => 'A man walking a dog along a wet cobbled street while checking his phone', 'k' => 'Real conditions', 'v' => 'One hand, rain, the network switching'],
];
$twa_fd_ru = $twa_fd_rate($twa_fd_u[90]);
$twa_fd_rb = $twa_fd_rate($twa_fd_b[90]);
?>
<section class="band band--alt twa-field" id="field" aria-labelledby="field-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>01 · Lab vs field</b><span>p75 LCP · mobile · 90 days after launch</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="field-t"><span class="g">Launch day is a lab score.</span> Day 90 is the truth.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">A site can score 98 on a fast laptop and still be poor for the people who use it. Tags, video and scripts arrive one reasonable request at a time. We judge the work by field data at the 75th percentile, and budgets in CI stop the drift before customers feel it.</p>
      </div>
    </div>

    <div class="twa-fd" data-fd='<?= e(json_encode(['u' => $twa_fd_u, 'b' => $twa_fd_b, 'ev' => array_map(fn ($twa_x) => [$twa_x[0], $twa_x[1]], $twa_fd_ev)], JSON_UNESCAPED_UNICODE)) ?>'>
      <div class="twa-fd__panel bdh-ui" data-rv>
        <div class="bdh-ui__bar twa-fd__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="twa-fd__src">RUM · Your platform · /product/* · mobile</span>
          <span class="twa-ill">Illustrative</span>
        </div>

        <div class="twa-fd__tools">
          <p class="twa-fd__metric"><b>p75 LCP</b><span>Largest Contentful Paint, seconds, per day</span></p>
          <div class="twa-fd__legend" role="group" aria-label="Show or hide a series">
            <button type="button" class="twa-fd__key" data-series="u" aria-pressed="true"><i class="twa-fd__sw twa-fd__sw--u" aria-hidden="true"></i>Unmanaged</button>
            <button type="button" class="twa-fd__key" data-series="b" aria-pressed="true"><i class="twa-fd__sw twa-fd__sw--b" aria-hidden="true"></i>Budgeted in CI</button>
          </div>
        </div>

        <div class="twa-fd__chart">
          <p class="bdh-sr">Line chart, illustrative. Over the 90 days after launch, an unmanaged site’s p75 LCP on mobile rises from 2.2 to 5.1 seconds, stepping up at each event listed below and ending in the poor band. A site with performance budgets in CI stays between 2.1 and 2.5 seconds, inside the good band.</p>
          <div class="twa-fd__lab" aria-hidden="true">
            <p class="twa-fd__lk">Launch day · lab</p>
            <p class="twa-fd__ls"><b>98</b><span>Lighthouse performance<br>desktop · simulated</span></p>
            <p class="twa-fd__lm"><span>LCP <b>1.2 s</b></span><span>TBT <b>40 ms</b></span><span>CLS <b>0.01</b></span></p>
          </div>
          <svg class="twa-fd__svg" viewBox="0 0 720 312" aria-hidden="true" focusable="false">
            <rect class="twa-fd__band twa-fd__band--poor" x="56" y="24" width="640" height="<?= round($twa_fd_y(4) - 24, 1) ?>"/>
            <rect class="twa-fd__band twa-fd__band--ni" x="56" y="<?= $twa_fd_y(4) ?>" width="640" height="<?= round($twa_fd_y(2.5) - $twa_fd_y(4), 1) ?>"/>
            <rect class="twa-fd__band twa-fd__band--good" x="56" y="<?= $twa_fd_y(2.5) ?>" width="640" height="<?= round(272 - $twa_fd_y(2.5), 1) ?>"/>
            <g class="twa-fd__grid">
              <?php for ($twa_s = 1; $twa_s <= 6; $twa_s++): ?><line x1="56" x2="696" y1="<?= $twa_fd_y($twa_s) ?>" y2="<?= $twa_fd_y($twa_s) ?>"/><?php endfor; ?>
              <line class="twa-fd__base" x1="56" x2="696" y1="272" y2="272"/>
            </g>
            <g class="twa-fd__ax">
              <?php for ($twa_s = 0; $twa_s <= 6; $twa_s++): ?><text x="46" y="<?= $twa_fd_y($twa_s) + 3.5 ?>" text-anchor="end"><?= $twa_s ?> s</text><?php endfor; ?>
              <?php foreach ([0, 15, 30, 45, 60, 75, 90] as $twa_dd): ?><text x="<?= $twa_fd_x($twa_dd) ?>" y="292" text-anchor="middle"><?= $twa_dd === 0 ? 'Launch' : 'Day ' . $twa_dd ?></text><?php endforeach; ?>
            </g>
            <g class="twa-fd__bl">
              <text x="688" y="262" text-anchor="end">Good ≤ 2.5 s</text>
              <text x="688" y="<?= $twa_fd_y(4) + 16 ?>" text-anchor="end">Needs improvement</text>
              <text x="688" y="<?= $twa_fd_y(4) - 8 ?>" text-anchor="end">Poor &gt; 4 s</text>
            </g>
            <path class="twa-fd__ln twa-fd__ln--u" data-s="u" pathLength="1" d="<?= $twa_fd_path($twa_fd_u) ?>"/>
            <path class="twa-fd__ln twa-fd__ln--b" data-s="b" pathLength="1" d="<?= $twa_fd_path($twa_fd_b) ?>"/>
            <?php foreach ($twa_fd_ev as $twa_ei => $twa_e):
                $twa_px = $twa_fd_x($twa_e[0]); $twa_pu = $twa_fd_y($twa_fd_u[$twa_e[0]]); $twa_pb = $twa_fd_y($twa_fd_b[$twa_e[0]]); ?>
              <g class="twa-fd__pin is-on" data-day="<?= $twa_e[0] ?>" data-s="u" transform="translate(<?= $twa_px ?> <?= $twa_pu ?>)">
                <g class="twa-fd__pinb"><line x1="0" x2="0" y1="-10" y2="-30"/><circle cx="0" cy="-38" r="9"/><text x="0" y="-34.5" text-anchor="middle"><?= $twa_ei + 1 ?></text></g>
              </g>
              <g class="twa-fd__ok is-on" data-day="<?= $twa_e[0] ?>" data-s="b" transform="translate(<?= $twa_px ?> <?= $twa_pb ?>)">
                <g class="twa-fd__pinb"><rect x="-4.5" y="-4.5" width="9" height="9" transform="rotate(45)"/></g>
              </g>
            <?php endforeach; ?>
            <g class="twa-fd__cur" transform="translate(696 0)">
              <line x1="0" x2="0" y1="24" y2="272"/>
              <circle class="twa-fd__cu" data-s="u" cx="0" cy="<?= $twa_fd_y($twa_fd_u[90]) ?>" r="5"/>
              <circle class="twa-fd__cb" data-s="b" cx="0" cy="<?= $twa_fd_y($twa_fd_b[90]) ?>" r="5"/>
            </g>
          </svg>
        </div>

        <div class="twa-fd__foot">
          <div class="twa-fd__scrub">
            <label class="twa-fd__sl" for="field-day"><span>Scrub the 90 days</span><output id="field-day-o" for="field-day">Day 90</output></label>
            <input class="twa-fd__range" id="field-day" type="range" min="0" max="90" step="1" value="90" aria-valuetext="Day 90">
          </div>
          <p class="twa-fd__rv" data-s="u"><span class="twa-fd__rk"><i class="twa-fd__sw twa-fd__sw--u" aria-hidden="true"></i>Unmanaged</span><b data-fd-v="u"><?= number_format($twa_fd_u[90], 1) ?> s</b><span class="twa-rt twa-rt--<?= $twa_fd_ru[0] ?>" data-fd-r="u"><?= $twa_fd_ru[1] ?></span></p>
          <p class="twa-fd__rv" data-s="b"><span class="twa-fd__rk"><i class="twa-fd__sw twa-fd__sw--b" aria-hidden="true"></i>Budgeted in CI</span><b data-fd-v="b"><?= number_format($twa_fd_b[90], 1) ?> s</b><span class="twa-rt twa-rt--<?= $twa_fd_rb[0] ?>" data-fd-r="b"><?= $twa_fd_rb[1] ?></span></p>
          <p class="bdh-sr" aria-live="polite" data-fd-live></p>
        </div>

        <ol class="twa-fd__events">
          <?php foreach ($twa_fd_ev as $twa_ei => $twa_e): ?>
            <li class="twa-fd__ev" data-day="<?= $twa_e[0] ?>">
              <p class="twa-fd__eh"><b><?= $twa_ei + 1 ?></b><span>Day <?= $twa_e[0] ?></span></p>
              <p class="twa-fd__et"><?= e($twa_e[1]) ?></p>
              <p class="twa-fd__eo" data-s="u"><i class="twa-fd__sw twa-fd__sw--u" aria-hidden="true"></i><span>Unmanaged <?= e($twa_e[2]) ?></span></p>
              <p class="twa-fd__eo" data-s="b"><i class="twa-fd__sw twa-fd__sw--b" aria-hidden="true"></i><span><?= e($twa_e[3]) ?></span></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="twa-fd__photos" data-rv data-rv-d="80">
        <!-- PLACEHOLDER: reference photographs (Unsplash) — confirm before launch -->
        <?php foreach ($twa_fd_ph as $twa_p): ?>
          <figure class="twa-ph">
            <span class="bdh-img"><img src="<?= xe_url($twa_p['src']) ?>" width="<?= $twa_p['w'] ?>" height="<?= $twa_p['h'] ?>" alt="<?= e($twa_p['alt']) ?>" loading="lazy" decoding="async" style="object-position:<?= e($twa_p['pos']) ?>"></span>
            <span class="twa-ph__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
            <figcaption class="bdh-cap-chip"><b><?= e($twa_p['k']) ?></b><?= e($twa_p['v']) ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="twa-fd__facts" data-rv-s>
      <article>
        <p class="twa-fd__fk"><?= xt_icon('users', ['size' => 20]) ?>Field data</p>
        <h3 class="bdh-t">Judged at the 75th percentile</h3>
        <p class="bdh-d">Core Web Vitals are assessed on real page loads: a page is good when at least 75% of visits are good. The Chrome UX Report publishes that field data over a rolling 28 days; our own real-user monitoring adds every template, device class and release.</p>
      </article>
      <article>
        <p class="twa-fd__fk"><?= xt_icon('latency', ['size' => 20]) ?>Responsiveness</p>
        <h3 class="bdh-t">INP replaced FID in March 2024</h3>
        <p class="bdh-d">Interaction to Next Paint became a Core Web Vital on 12 March 2024. It measures the latency of interactions across the whole visit, not only the first, so heavy JavaScript that looked fine at launch now shows. Good is 200 ms or less.</p>
      </article>
      <article>
        <p class="twa-fd__fk"><?= xt_icon('gauge', ['size' => 20]) ?>Budgets</p>
        <h3 class="bdh-t">Budgets fail the build, not the launch</h3>
        <p class="bdh-d">Lighthouse CI assertions and bundle-size limits run on every pull request. A new tag, video or script that breaks the budget cannot merge until it is deferred, compressed or removed, and real-user alerts watch p75 after each release.</p>
      </article>
    </div>
  </div>
</section>
