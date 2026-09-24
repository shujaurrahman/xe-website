<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature showcase: the campaign board. Five stages as a real tablist; a mode switch (campaign burst /
   always-on) re-plans the flighting and the result. Without JavaScript every stage is shown in order and the
   burst view is the one printed. Figures are illustrative. */
$cch_kv = xe_url('assets/imgs/campaign-content/social-b.jpg');
$cch_stages = [
    ['idea',    'Idea',       'Brief signed off'],
    ['kv',      'Key visual', 'Master v3 locked'],
    ['cuts',    'Cut-downs',  '6 of 6 formats pass'],
    ['flight',  'Flighting',  '8 channels · 8 weeks'],
    ['result',  'Result',     'Measured vs holdout'],
];
$cch_cuts = [   // [modifier, channel, spec, object-position, headline]
    ['r45',  'Meta · feed',        '4:5 · 1080 × 1350',  '50% 55%', 'Win the first ten minutes.'],
    ['r916', 'Reels · Stories',    '9:16 · 1080 × 1920 · 15s', '46% 50%', 'The first ten minutes.'],
    ['r169', 'YouTube · bumper',   '16:9 · 6s',          '50% 45%', 'Win the first ten minutes.'],
    ['r11',  'LinkedIn · feed',    '1:1 · 1200 × 1200',  '55% 50%', 'Ten minutes that set the day.'],
    ['r65',  'Display · MPU',      '6:5 · 300 × 250',    '60% 55%', 'Ten minutes.'],
    ['r21',  'Email · hero',       '2:1 · 600 w',        '50% 40%', 'Win the first ten minutes.'],
];
/* Flighting: [lane, [[start week, end week, weight]] burst, [[…]] always-on]; weight 2 = heavy, 1 = light */
$cch_lanes = [
    ['Video',    [[1, 3, 2], [4, 5, 1]],           [[1, 8, 1]]],
    ['Social',   [[1, 4, 2], [5, 8, 1]],           [[1, 8, 1], [3, 3, 2], [6, 6, 2]]],
    ['Search',   [[1, 8, 1]],                      [[1, 8, 1]]],
    ['Creators', [[1, 2, 2], [4, 4, 1]],           [[2, 2, 1], [5, 5, 1], [8, 8, 1]]],
    ['PR',       [[1, 1, 2], [3, 3, 1]],           [[4, 4, 1]]],
    ['Display',  [[2, 6, 1]],                      [[1, 8, 1]]],
    ['Email',    [[1, 1, 2], [3, 3, 1], [6, 6, 1]],[[1, 1, 1], [3, 3, 1], [5, 5, 1], [7, 7, 1]]],
    ['OOH',      [[1, 4, 2]],                      []],
];
$cch_kpis = [   // mode => [[label, figure, unit, note]]
    'burst' => [['Reach at 3+ frequency', '62', '%', 'of the target audience'], ['Ad recall', '+7', 'pts', 'brand lift study'], ['Incremental conversions', '+18', '%', 'vs geo holdout'], ['Cost per incremental customer', '84', 'idx', 'baseline = 100']],
    'ao'    => [['Monthly reach', '41', '%', 'of the target audience'], ['Ad recall', '+3', 'pts', 'brand lift study'], ['Incremental conversions', '+9', '%', 'vs geo holdout'], ['Cost per incremental customer', '71', 'idx', 'baseline = 100']],
];
/* test vs holdout, weekly index (holdout = what would have happened anyway) */
$cch_series = [
    'burst' => [[100, 118, 131, 127, 119, 112, 108, 106], [100, 101, 99, 102, 100, 101, 100, 99]],
    'ao'    => [[100, 103, 106, 108, 110, 112, 113, 115], [100, 100, 101, 101, 102, 101, 102, 102]],
];
$cch_pts = function (array $cch_v): string {
    $cch_o = [];
    foreach ($cch_v as $cch_i => $cch_y) $cch_o[] = (24 + $cch_i * 64) . ',' . round(140 - ($cch_y - 90) * 2.4, 1);
    return implode(' ', $cch_o);
};
?>
<section class="band band--ink cch-board" id="board" aria-labelledby="board-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The campaign board</p>
        <h2 class="h2" id="board-t"><span class="g">Follow one idea</span> from the brief to the number it moved.</h2></div>
      <div><p class="lead">This is how a campaign looks inside our working board. Step through the five stages, then switch between a launch burst and an always-on programme to see the plan and the result change.</p></div>
    </div>

    <div class="cch-bd" data-mode="burst">
      <div class="cch-bd__bar">
        <span class="cch-bd__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="bdh-ro cch-bd__name"><i class="cch-dot"></i>Campaign board · Your brand · “Win the first ten minutes”</span>
        <div class="bdh-seg cch-bd__seg" role="group" aria-label="Planning mode" hidden>
          <button type="button" data-cch-mode="burst" aria-pressed="true">Campaign burst</button>
          <button type="button" data-cch-mode="ao" aria-pressed="false">Always-on</button>
        </div>
        <span class="cch-bd__ill bdh-ro">Illustrative</span>
      </div>

      <div class="cch-bd__g">
        <div class="cch-bd__rail" role="tablist" aria-label="Campaign stages">
          <?php foreach ($cch_stages as $cch_i => $cch_s): ?>
          <button type="button" role="tab" id="cch-bt-<?= $cch_s[0] ?>" aria-controls="cch-bp-<?= $cch_s[0] ?>" aria-selected="<?= $cch_i ? 'false' : 'true' ?>" tabindex="<?= $cch_i ? '-1' : '0' ?>" class="cch-bd__tab<?= $cch_i ? '' : ' is-on' ?>">
            <span class="cch-bd__n"><?= sprintf('%02d', $cch_i + 1) ?></span>
            <span class="cch-bd__tt"><span class="cch-bd__tn"><?= e($cch_s[1]) ?></span><span class="cch-bd__ts"><?= e($cch_s[2]) ?></span></span>
            <i class="cch-bd__prog" aria-hidden="true"></i>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="cch-bd__panes">
          <!-- 01 Idea -->
          <div class="cch-bd__pane" role="tabpanel" id="cch-bp-idea" aria-labelledby="cch-bt-idea" tabindex="0">
            <p class="cch-bd__ph bdh-ro">01 · Idea — the brief</p>
            <dl class="cch-brief">
              <div class="cch-brief__i"><dt>Insight</dt><dd>People judge a whole day by how it starts.</dd></div>
              <div class="cch-brief__i"><dt>Tension</dt><dd>Mornings are the most planned and least protected part of the day.</dd></div>
              <div class="cch-brief__i cch-brief__i--idea"><dt>Idea</dt><dd>Win the first ten minutes.</dd></div>
              <div class="cch-brief__i"><dt>Proposition</dt><dd>Your product gives those ten minutes back.</dd></div>
              <div class="cch-brief__i"><dt>Audience</dt><dd>Busy professionals, 25–44, who plan their mornings the night before.</dd></div>
              <div class="cch-brief__i cch-brief__i--w"><dt>Objective · measure</dt><dd>New customers in launch markets · incremental conversions vs a geo holdout.</dd></div>
            </dl>
            <ul class="cch-bd__sign bdh-ro"><li><span class="bdh-ok" aria-hidden="true">✓</span>Strategy lead</li><li><span class="bdh-ok" aria-hidden="true">✓</span>Creative director</li><li><span class="bdh-ok" aria-hidden="true">✓</span>Your marketing lead</li></ul>
          </div>

          <!-- 02 Key visual -->
          <div class="cch-bd__pane" role="tabpanel" id="cch-bp-kv" aria-labelledby="cch-bt-kv" tabindex="0">
            <p class="cch-bd__ph bdh-ro">02 · Key visual — master v3</p>
            <div class="cch-kv">
              <figure class="cch-frame cch-frame--r169 cch-kv__f">
                <img src="<?= e($cch_kv) ?>" alt="A person holds a white mug in both hands at a wooden table beside an open book" width="900" height="596" loading="lazy" decoding="async" style="object-position:50% 45%">
                <figcaption class="cch-frame__hl cch-kv__hl">Win the first<br>ten minutes.</figcaption>
                <span class="cch-kv__lock" aria-hidden="true">Your brand</span>
                <span class="cch-kv__safe" aria-hidden="true"></span>
              </figure>
              <div class="cch-kv__rules">
                <p class="bdh-ro cch-kv__rh">Locked</p>
                <ul><li>Headline typeface and size ratio</li><li>Lockup zone, bottom right</li><li>Warm light, hands in frame</li></ul>
                <p class="bdh-ro cch-kv__rh">Flexible</p>
                <ul><li>Crop and focal point per format</li><li>Headline length: three cuts</li><li>Call to action per channel</li></ul>
                <ul class="cch-kv__checks bdh-ro"><li><span class="bdh-ok" aria-hidden="true">✓</span>Contrast 4.5 : 1</li><li><span class="bdh-ok" aria-hidden="true">✓</span>Safe zone clear</li><li><span class="bdh-ok" aria-hidden="true">✓</span>Usage rights logged</li></ul>
              </div>
            </div>
          </div>

          <!-- 03 Cut-downs -->
          <div class="cch-bd__pane" role="tabpanel" id="cch-bp-cuts" aria-labelledby="cch-bt-cuts" tabindex="0">
            <p class="cch-bd__ph bdh-ro">03 · Cut-downs — one master, six formats</p>
            <ul class="cch-cuts">
              <?php foreach ($cch_cuts as $cch_c): ?>
              <li class="cch-cuts__i">
                <figure class="cch-frame cch-frame--<?= $cch_c[0] ?>" aria-hidden="true">
                  <img src="<?= e($cch_kv) ?>" alt="" width="900" height="596" loading="lazy" decoding="async" style="object-position:<?= $cch_c[3] ?>">
                  <span class="cch-frame__hl"><?= e($cch_c[4]) ?></span>
                </figure>
                <span class="cch-cuts__ch"><?= e($cch_c[1]) ?></span>
                <span class="cch-cuts__sp bdh-ro"><?= e($cch_c[2]) ?></span>
                <span class="cch-cuts__ok bdh-ro"><span class="bdh-ok" aria-hidden="true">✓</span>Brand check · copy fit</span>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- 04 Flighting -->
          <div class="cch-bd__pane" role="tabpanel" id="cch-bp-flight" aria-labelledby="cch-bt-flight" tabindex="0">
            <p class="cch-bd__ph bdh-ro">04 · Flighting — <span class="cch-m cch-m--burst">launch burst, then sustain</span><span class="cch-m cch-m--ao">steady weight, monthly peaks</span></p>
            <div class="bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Flighting plan, eight channels over eight weeks">
              <div class="cch-fl" aria-hidden="true">
                <div class="cch-fl__row cch-fl__row--h"><span></span><?php for ($cch_w = 1; $cch_w <= 8; $cch_w++): ?><span>W<?= $cch_w ?></span><?php endfor; ?></div>
                <?php foreach ($cch_lanes as $cch_l): ?>
                <div class="cch-fl__row">
                  <span class="cch-fl__lane"><?= e($cch_l[0]) ?></span>
                  <?php foreach (['burst' => $cch_l[1], 'ao' => $cch_l[2]] as $cch_m => $cch_bars): foreach ($cch_bars as $cch_b): ?>
                  <i class="cch-fl__bar cch-m cch-m--<?= $cch_m ?><?= $cch_b[2] > 1 ? ' is-heavy' : '' ?>" style="grid-column:<?= $cch_b[0] + 1 ?> / <?= $cch_b[1] + 2 ?>"></i>
                  <?php endforeach; endforeach; ?>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <p class="bdh-sr">Flighting plan. Launch burst: heavy video, social, creators, PR, email and out of home in weeks one to four, search always on, lighter sustain after. Always-on: steady weight in every channel with small social and creator peaks and a fortnightly email.</p>
            <p class="cch-fl__key bdh-ro"><span><i class="is-heavy"></i>Heavy weight</span><span><i></i>Sustain</span></p>
          </div>

          <!-- 05 Result -->
          <div class="cch-bd__pane" role="tabpanel" id="cch-bp-result" aria-labelledby="cch-bt-result" tabindex="0">
            <p class="cch-bd__ph bdh-ro">05 · Result — what the campaign caused</p>
            <?php foreach ($cch_kpis as $cch_m => $cch_set): ?>
            <div class="cch-res cch-m cch-m--<?= $cch_m ?>">
              <div class="cch-res__kpis">
                <?php foreach ($cch_set as $cch_k): ?>
                <div class="cch-kpi"><span class="cch-kpi__l"><?= e($cch_k[0]) ?></span><span class="cch-kpi__v"><?= e($cch_k[1]) ?><small><?= e($cch_k[2]) ?></small></span><span class="cch-kpi__n"><?= e($cch_k[3]) ?></span></div>
                <?php endforeach; ?>
              </div>
              <figure class="cch-viz cch-viz--ink">
                <figcaption class="bdh-ro"><span><i class="cch-viz__k cch-viz__k--t"></i>Exposed regions</span><span><i class="cch-viz__k cch-viz__k--h"></i>Holdout regions</span><span>Weekly conversions · index</span></figcaption>
                <svg viewBox="0 0 496 150" aria-hidden="true" focusable="false">
                  <?php foreach ([40, 80, 120] as $cch_y): ?><line class="cch-viz__grid" x1="24" x2="472" y1="<?= $cch_y ?>" y2="<?= $cch_y ?>"/><?php endforeach; ?>
                  <polygon class="cch-viz__lift" points="<?= $cch_pts($cch_series[$cch_m][0]) ?> <?= implode(' ', array_reverse(explode(' ', $cch_pts($cch_series[$cch_m][1])))) ?>"/>
                  <polyline class="cch-viz__h" points="<?= $cch_pts($cch_series[$cch_m][1]) ?>"/>
                  <polyline class="cch-viz__t" points="<?= $cch_pts($cch_series[$cch_m][0]) ?>"/>
                </svg>
                <div class="cch-viz__x bdh-ro" aria-hidden="true"><?php for ($cch_w = 1; $cch_w <= 8; $cch_w++): ?><span>W<?= $cch_w ?></span><?php endfor; ?></div>
              </figure>
              <p class="bdh-sr"><?= $cch_m === 'burst' ? 'Launch burst: conversions in exposed regions rise to an index of 131 in week three against a flat holdout, then settle near 106.' : 'Always-on: conversions in exposed regions climb steadily to an index of 115 by week eight against a nearly flat holdout.' ?></p>
            </div>
            <?php endforeach; ?>
            <p class="cch-res__note">Figures are illustrative, not client results. The shaded gap is the lift the campaign caused.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
