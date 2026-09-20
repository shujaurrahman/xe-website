<?php /* DRAFT COPY — review before launch */
/* 04.11 Outcomes — the numbers a feature is judged on, as the production dashboard your team watches after
   launch. Five KPI tiles (value, baseline, target, sparkline); a trend chart switched by the three outcomes in
   $CAP['outcomes'] (each with its threshold and one annotated event); and the feature flag that stays on only
   while its guard conditions hold. Every figure is illustrative, not a client result. outcomes.js draws. */
$tapo_kpis = [   // [label, value, unit suffix for sparkline title, baseline, target, series (12 weeks), direction: up | down, delta]
    ['Deflection rate',            '41%',     'Questions resolved with no ticket', 'was 18% via search', 'target ≥ 40%',  [22, 26, 29, 31, 33, 35, 36, 37, 38, 39, 40, 41], 'up',   '+23 pts', '18', 'pts'],
    ['Average handle time',        '6.1 min', 'Handed-over conversations',          'was 9.4 min',        'target ≤ 7 min', [9.1, 8.6, 8.2, 7.8, 7.5, 7.1, 6.9, 6.7, 6.5, 6.3, 6.2, 6.1], 'down', '−35%', '9.4', 'pct'],
    ['Straight-through processing','78%',     'Invoices posted with no touch',      'was 0%, all manual', 'target ≥ 75%',  [52, 58, 63, 66, 69, 71, 72, 74, 75, 76, 77, 78], 'up',   '+78 pts', '0', 'pts'],
    ['Cost per resolution',        '₹0.55',   'Model and infrastructure, about six answers at ₹0.09', 'was ₹1.10 in week 1', 'budget ≤ ₹0.70', [1.10, 1.02, 0.95, 0.84, 0.76, 0.72, 0.70, 0.64, 0.60, 0.58, 0.56, 0.55], 'down', '−50%', '1.10', 'pct'],
    ['Groundedness',               '0.96',    'Daily sample of 200 answers',        'floor 0.90',         'target ≥ 0.93', [0.91, 0.92, 0.93, 0.93, 0.94, 0.93, 0.92, 0.93, 0.94, 0.95, 0.95, 0.96], 'up', '+0.05', '0.91', 'abs'],
];   // [8] = baseline the tile counts from, [9] = how its delta badge is derived (pts | pct | abs), so every mid-count frame agrees with its badge
$tapo_charts = [   // one per $CAP['outcomes'] row: [chart title, series, y min, y max, line value, line label, y format, annotate week, note, readout]
    ['Groundedness · weekly mean of the daily sample', [0.91, 0.92, 0.93, 0.93, 0.94, 0.93, 0.92, 0.93, 0.94, 0.95, 0.95, 0.96], 0.80, 1.00, 0.90, 'floor 0.90', '%.2f', 7,
        'Week 7: a policy upload failed to index and answers cited a stale version. One day’s sample fell to 0.87 (daily low; weekly mean 0.92). The alert fired the same day; fixed in 26 hours.', 'Every answer carries its sources; 0 uncited answers shown to users'],
    ['Straight-through rate · invoices posted with no touch', [52, 58, 63, 66, 69, 71, 72, 74, 75, 76, 77, 78], 40, 80, 75, 'target 75%', '%d%%', 6,
        'Week 6: the review threshold moved from 0.95 to 0.92 after 1,200 checked cases showed no loss in accuracy.', 'Exceptions reach a named person with the document, the fields and the reason'],
    ['Cost per resolution · model and infrastructure', [1.10, 1.02, 0.95, 0.84, 0.76, 0.72, 0.70, 0.64, 0.60, 0.58, 0.56, 0.55], 0.40, 1.20, 0.70, 'budget ₹0.70', '₹%.2f', 4,
        'Week 4: the semantic cache went live and now serves about a third of questions with no model call.', 'Cost per answer tracked from the prototype, not found on the first invoice'],
];
$tapo_log = [   // flag history, newest first: [week, what happened, kind: ok | back | alert]
    ['W12', 'v24 widened to 100% · every condition held', 'ok'],
    ['W9',  'v21 rolled back at 5% canary · p95 3.1 s', 'back'],
    ['W7',  'Alert only · daily sample 0.87, 7-day mean 0.92', 'alert'],
];
$tapo_guards = [   // [condition, current value]
    ['Groundedness, 7-day mean ≥ 0.90', '0.96'],
    ['Handover rate ≤ 25%', '19%'],
    ['p95 latency ≤ 2.5 s', '2.1 s'],
    ['Cost per answer ≤ ₹0.12', '₹0.09'],
    ['Complaints about answers ≤ baseline', '−34%'],
];

/* chart geometry: 12 weekly points in a 640 × 220 frame with a 44px y-axis and a 26px x-axis */
$tapo_W = 640; $tapo_H = 220; $tapo_L = 44; $tapo_R = 16; $tapo_T = 16; $tapo_B = 26;
$tapo_x = function (int $i) use ($tapo_W, $tapo_L, $tapo_R): float { return $tapo_L + $i * ($tapo_W - $tapo_L - $tapo_R) / 11; };
$tapo_y = function (float $v, float $lo, float $hi) use ($tapo_H, $tapo_T, $tapo_B): float { return $tapo_T + (1 - ($v - $lo) / ($hi - $lo)) * ($tapo_H - $tapo_T - $tapo_B); };
$tapo_spark = function (array $s): string {
    $lo = min($s); $hi = max($s); $pts = [];
    foreach ($s as $i => $v) { $pts[] = round(2 + $i * 236 / 11, 1) . ',' . round(4 + (1 - ($v - $lo) / max(0.0001, $hi - $lo)) * 24, 1); }
    return implode(' ', $pts);
};
?>
<section class="band band--ink tap-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.11</span><span>Outcomes</span><span class="tap-eb__p">/outcomes</span></p>
        <h2 class="h2" id="outcomes-t"><span class="g">Numbers that decide</span> whether it stays switched on.</h2>
      </div>
      <div>
        <p class="lead">In week one we agree which numbers the feature is judged on, what they were before, and the floor that switches it off. After launch they live on one dashboard your team owns. These are the ones we usually track.</p>
      </div>
    </div>

    <div class="tap-oc tap-win" data-rv>
      <div class="tap-win__bar">
        <span class="tap-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tap-win__path"><b>production</b> · assistant and AP automation · 12 weeks after launch</span>
        <span class="tap-win__end"><span class="tap-oc__live"><span class="tap-led tap-led--pulse" aria-hidden="true"></span>live</span><span class="tap-ill">Illustrative</span></span>
      </div>

      <ul class="tap-oc__kpis" role="list" data-bdh-stagger>
        <?php foreach ($tapo_kpis as $tapo_i => $tapo_k): ?>
          <li class="tap-oc__kpi">
            <p class="tap-oc__kk"><?= e($tapo_k[0]) ?></p>
            <p class="tap-oc__kv"><span data-oc-from="<?= e($tapo_k[8]) ?>"><?= e($tapo_k[1]) ?></span><span class="tap-oc__kd" data-oc-dt="<?= e($tapo_k[9]) ?>"><?= e($tapo_k[7]) ?></span></p>
            <svg class="tap-oc__spark bdh-draw" viewBox="0 0 240 32" preserveAspectRatio="none" aria-hidden="true"><polyline pathLength="1" style="--i:<?= $tapo_i ?>" points="<?= $tapo_spark($tapo_k[5]) ?>"/></svg>
            <p class="tap-oc__kb"><span><?= e($tapo_k[3]) ?></span><span><?= e($tapo_k[4]) ?></span></p>
            <p class="bdh-sr"><?= e($tapo_k[2]) ?>. Twelve weeks: <?= e(implode(', ', $tapo_k[5])) ?>.</p>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="tap-oc__main">
        <div class="tap-oc__trend">
          <div class="bdh-seg tap-oc__seg" role="tablist" aria-label="Outcome">
            <?php foreach ($CAP['outcomes'] as $tapo_i => $tapo_o): ?>
              <button type="button" role="tab" id="oc-t<?= $tapo_i ?>" aria-controls="oc-p<?= $tapo_i ?>" aria-selected="<?= $tapo_i === 0 ? 'true' : 'false' ?>"<?= $tapo_i ? ' tabindex="-1"' : '' ?>><?= e($tapo_o[0]) ?></button>
            <?php endforeach; ?>
          </div>

          <div class="bdh-panes">
            <?php foreach ($CAP['outcomes'] as $tapo_i => $tapo_o):
                $tapo_c = $tapo_charts[$tapo_i];
                [$tapo_lo, $tapo_hi] = [$tapo_c[2], $tapo_c[3]];
                $tapo_pts = [];
                foreach ($tapo_c[1] as $tapo_j => $tapo_v) { $tapo_pts[] = round($tapo_x($tapo_j), 1) . ',' . round($tapo_y((float) $tapo_v, $tapo_lo, $tapo_hi), 1); }
                $tapo_area = round($tapo_x(0), 1) . ',' . ($tapo_H - $tapo_B) . ' ' . implode(' ', $tapo_pts) . ' ' . round($tapo_x(11), 1) . ',' . ($tapo_H - $tapo_B);
                $tapo_ly = round($tapo_y((float) $tapo_c[4], $tapo_lo, $tapo_hi), 1);
                $tapo_aw = $tapo_c[7] - 1;
                $tapo_ax = round($tapo_x($tapo_aw), 1); $tapo_ay = round($tapo_y((float) $tapo_c[1][$tapo_aw], $tapo_lo, $tapo_hi), 1);
                $tapo_last = end($tapo_c[1]);
            ?>
              <div class="bdh-pane tap-oc__pane<?= $tapo_i === 0 ? ' is-on' : '' ?>" id="oc-p<?= $tapo_i ?>" role="tabpanel" aria-labelledby="oc-t<?= $tapo_i ?>">
                <div class="tap-oc__ph">
                  <h3 class="tap-oc__pt"><?= e($tapo_o[0]) ?></h3>
                  <p class="tap-oc__pd"><?= e($tapo_o[1]) ?></p>
                </div>
                <figure class="tap-oc__chart">
                  <figcaption class="tap-oc__ct"><span><?= e($tapo_c[0]) ?></span><b><?= e(sprintf($tapo_c[6], $tapo_last)) ?></b></figcaption>
                  <svg class="tap-oc__svg" viewBox="0 0 <?= $tapo_W ?> <?= $tapo_H ?>" role="img" aria-label="<?= e($tapo_c[0]) ?>, weeks 1 to 12: <?= e(implode(', ', array_map(fn ($tapo_v) => sprintf($tapo_c[6], $tapo_v), $tapo_c[1]))) ?>. <?= e($tapo_c[5]) ?>. <?= e($tapo_c[8]) ?>">
                    <?php for ($tapo_g = 0; $tapo_g <= 4; $tapo_g++):
                        $tapo_gv = $tapo_lo + ($tapo_hi - $tapo_lo) * $tapo_g / 4; $tapo_gy = round($tapo_y($tapo_gv, $tapo_lo, $tapo_hi), 1); ?>
                      <line class="tap-oc__grid" x1="<?= $tapo_L ?>" x2="<?= $tapo_W - $tapo_R ?>" y1="<?= $tapo_gy ?>" y2="<?= $tapo_gy ?>"/>
                      <text class="tap-oc__ax" x="<?= $tapo_L - 10 ?>" y="<?= $tapo_gy + 3.5 ?>" text-anchor="end"><?= e(sprintf($tapo_c[6], $tapo_gv)) ?></text>
                    <?php endfor; ?>
                    <?php for ($tapo_j = 0; $tapo_j < 12; $tapo_j++): ?>
                      <text class="tap-oc__ax" x="<?= round($tapo_x($tapo_j), 1) ?>" y="<?= $tapo_H - 6 ?>" text-anchor="middle"><?= $tapo_j + 1 ?></text>
                    <?php endfor; ?>
                    <line class="tap-oc__th" x1="<?= $tapo_L ?>" x2="<?= $tapo_W - $tapo_R ?>" y1="<?= $tapo_ly ?>" y2="<?= $tapo_ly ?>"/>
                    <text class="tap-oc__tht" x="<?= $tapo_W - $tapo_R - 4 ?>" y="<?= $tapo_ly + 15 ?>" text-anchor="end"><?= e($tapo_c[5]) ?></text>
                    <polygon class="tap-oc__area" points="<?= $tapo_area ?>"/>
                    <polyline class="tap-oc__line" pathLength="1" points="<?= implode(' ', $tapo_pts) ?>"/>
                    <?php foreach ($tapo_pts as $tapo_j => $tapo_p): [$tapo_px, $tapo_py] = explode(',', $tapo_p); ?>
                      <circle class="tap-oc__pt<?= $tapo_j === $tapo_aw ? ' is-note' : '' ?>" cx="<?= $tapo_px ?>" cy="<?= $tapo_py ?>" r="<?= $tapo_j === $tapo_aw ? 5 : 3 ?>" style="--j:<?= $tapo_j ?>"/>
                    <?php endforeach; ?>
                    <line class="tap-oc__nl" x1="<?= $tapo_ax ?>" x2="<?= $tapo_ax ?>" y1="<?= $tapo_T ?>" y2="<?= $tapo_H - $tapo_B ?>"/>
                    <text class="tap-oc__nt" x="<?= $tapo_ax + 8 ?>" y="<?= $tapo_T + 10 ?>">W<?= $tapo_c[7] ?></text>
                  </svg>
                </figure>
                <p class="tap-oc__note"><span class="tap-oc__nk" aria-hidden="true">W<?= $tapo_c[7] ?></span><?= e($tapo_c[8]) ?></p>
                <p class="tap-oc__ro"><?= xt_icon('check', ['size' => 14, 'mono' => true]) ?><?= e($tapo_c[9]) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <aside class="tap-oc__flag" aria-labelledby="oc-flag-t">
          <div class="tap-oc__fh">
            <div>
              <p class="tap-oc__fk">Feature flag</p>
              <h3 class="tap-oc__ft" id="oc-flag-t">Stays switched on while</h3>
            </div>
            <span class="tap-oc__sw" aria-hidden="true"><i></i></span>
          </div>
          <p class="tap-oc__fv"><code>assistant.v24</code><span>live · 100%</span></p>
          <ul class="tap-oc__guards" role="list" data-bdh-stagger>
            <?php foreach ($tapo_guards as $tapo_g): ?>
              <li><span class="tap-oc__gs" aria-hidden="true"></span><span class="tap-oc__gc"><?= e($tapo_g[0]) ?></span><b><?= e($tapo_g[1]) ?></b><span class="bdh-sr">, passing</span></li>
            <?php endforeach; ?>
          </ul>
          <p class="tap-oc__lk">Flag history</p>
          <ol class="tap-oc__log" role="list">
            <?php foreach ($tapo_log as $tapo_l): ?>
              <li class="is-<?= $tapo_l[2] ?>"><b><?= e($tapo_l[0]) ?></b><span><?= e($tapo_l[1]) ?></span></li>
            <?php endforeach; ?>
          </ol>
          <p class="tap-oc__rb"><?= xt_icon('rollback', ['size' => 18]) ?><span>If any condition fails three days running, the flag rolls back to the last good version and pages the owner. A person decides what ships next.</span></p>
        </aside>
      </div>
    </div>
  </div>
</section>
