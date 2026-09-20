<?php /* DRAFT COPY — review before launch */
/* Global — New Delhi and Ludhiana, working your hours. A typographic band, not a mock window: four facts
   about the working day, two studio plates (city, live IST clock, the address from data/site.php and what
   runs there) and a 24-hour overlap ribbon on India Standard Time set straight on the paper: the studio day,
   an extended shift by agreement and the on-call rota, against the working day in the UK, Europe, the Gulf,
   Singapore and US East.
   The overlap is computed here, for northern summer and winter (daylight saving moves the UK, EU and US by an
   hour); a switch shows either season, and a "now" marker sits at the current time in India.
   PLACEHOLDER: studio hours, the extended shift and on-call coverage are to be confirmed before launch. */
$gl_studios = $SITE['company']['studios'] ?? [];
/* PLACEHOLDER: confirm which teams sit in which studio before launch */
$gl_runs = [
    'New Delhi' => ['Client and programme leadership', 'Solution architecture and AI engineering', 'Security, audit and assessment work'],
    'Ludhiana'  => ['Platform, product and web engineering', 'Data, QA and eval engineering', 'Managed service, support and the on-call rota'],
];
$gl_core = [10, 19];     // studio day, IST
$gl_ext  = [19, 22.5];   // extended shift, by agreement
$gl_regions = [
    // [name, city, zone label summer, zone label winter, local start, local end, UTC offset summer, UTC offset winter]
    ['United Kingdom', 'London',    'BST · UTC+1',  'GMT · UTC+0',  9, 17.5, 1,  0],
    ['Europe',         'Frankfurt', 'CEST · UTC+2', 'CET · UTC+1',  9, 17.5, 2,  1],
    ['Gulf',           'Dubai',     'GST · UTC+4',  'GST · UTC+4',  9, 18,   4,  4],
    ['Singapore',      'Singapore', 'SGT · UTC+8',  'SGT · UTC+8',  9, 18,   8,  8],
    ['US East',        'New York',  'EDT · UTC−4',  'EST · UTC−5',  9, 17.5, -4, -5],
];
$gl_ist = 5.5;
$gl_seasons = ['summer' => 'Northern summer', 'winter' => 'Northern winter'];
$gl_season = (new DateTime('now', new DateTimeZone('Europe/London')))->format('I') === '1' ? 'summer' : 'winter';   // today's daylight saving
/* a local working day on the IST axis, split where it wraps past midnight */
$gl_span = function (float $gl_s, float $gl_e, float $gl_off) use ($gl_ist): array {
    $gl_a = $gl_s - $gl_off + $gl_ist; $gl_b = $gl_e - $gl_off + $gl_ist;
    while ($gl_a < 0) { $gl_a += 24; $gl_b += 24; }
    while ($gl_a >= 24) { $gl_a -= 24; $gl_b -= 24; }
    return $gl_b <= 24 ? [[$gl_a, $gl_b]] : [[$gl_a, 24], [0, $gl_b - 24]];
};
$gl_ov = function (array $gl_parts, array $gl_win): float {
    $gl_t = 0;
    foreach ($gl_parts as $gl_p) { $gl_t += max(0, min($gl_p[1], $gl_win[1]) - max($gl_p[0], $gl_win[0])); }
    return $gl_t;
};
$gl_clip = function (array $gl_parts, array $gl_win): array {
    $gl_out = [];
    foreach ($gl_parts as $gl_p) { $gl_a = max($gl_p[0], $gl_win[0]); $gl_b = min($gl_p[1], $gl_win[1]); if ($gl_b > $gl_a) $gl_out[] = [$gl_a, $gl_b]; }
    return $gl_out;
};
$gl_pct = fn (float $gl_h): string => round($gl_h / 24 * 100, 3) . '%';
$gl_hm = fn (float $gl_h): string => sprintf('%02d:%02d', (int) floor(fmod($gl_h, 24)), (int) round(($gl_h - floor($gl_h)) * 60));
$gl_h = fn (float $gl_v): string => rtrim(rtrim(number_format($gl_v, 1), '0'), '.') . ' h';
$gl_bar = fn (array $gl_p, string $gl_cls): string => '<i class="' . $gl_cls . '" style="left:' . round($gl_p[0] / 24 * 100, 3) . '%;width:' . round(($gl_p[1] - $gl_p[0]) / 24 * 100, 3) . '%"></i>';
$gl_now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$gl_now_h = (int) $gl_now->format('G') + (int) $gl_now->format('i') / 60;
?>
<section class="band tih-global" id="global" aria-labelledby="global-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Where we work</p>
        <h2 class="h2" id="global-t"><span class="g">New Delhi and Ludhiana,</span> working your hours.</h2>
      </div>
      <div>
        <p class="lead">Two studios in North India on India Standard Time, UTC+5:30. The working day overlaps most of Europe, the Gulf and South-East Asia, and an extended shift can cover the US East morning.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm studio hours, the extended shift and on-call coverage before launch -->
    <dl class="tih-gl__facts" data-rv-s data-rv-step="70">
      <div><dt>Time zone</dt><dd>UTC+5:30<span>India Standard Time, no daylight saving</span></dd></div>
      <div><dt>Studio day</dt><dd>10:00–19:00<span>Nine hours, Monday to Friday</span></dd></div>
      <div><dt>Extended shift</dt><dd>+ 3.5 h<span>To 22:30 IST, by agreement</span></dd></div>
      <div><dt>On call</dt><dd>24 / 7<span>Rota and escalation path, by agreement</span></dd></div>
    </dl>

    <div class="tih-gl__studios" data-rv-s data-rv-step="100">
      <?php foreach ($gl_studios as $gl_i => $gl_st): ?>
        <article class="tih-gl__studio">
          <div class="tih-gl__sb">
            <div>
              <p class="tih-k">Studio <?= str_pad((string) ($gl_i + 1), 2, '0', STR_PAD_LEFT) ?> · India</p>
              <h3 class="tih-gl__city"><?= e($gl_st['city']) ?></h3>
              <p class="tih-gl__local"><i class="bdh-pulse" aria-hidden="true"></i><span data-ist><?= e($gl_now->format('H:i')) ?></span> IST · UTC+5:30</p>
            </div>
            <?php if ($gl_st['city'] === 'New Delhi'): ?><!-- PLACEHOLDER: confirm the New Delhi address before launch --><?php endif; ?>
            <address class="tih-gl__addr">
              <?php foreach ($gl_st['units'] as $gl_u): ?><span><?= e($gl_u) ?></span><?php endforeach; ?>
              <?php foreach ($gl_st['lines'] as $gl_l): ?><span><?= e($gl_l) ?></span><?php endforeach; ?>
            </address>
          </div>
          <!-- PLACEHOLDER: confirm which teams sit in which studio before launch -->
          <p class="tih-k tih-gl__rk">What runs here</p>
          <ul class="tih-gl__runs" role="list">
            <?php foreach ($gl_runs[$gl_st['city']] ?? [] as $gl_r2): ?><li><?= e($gl_r2) ?></li><?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="tih-gl" data-season="<?= e($gl_season) ?>" data-rv data-rv-d="60">
      <div class="tih-gl__head">
        <div class="tih-gl__ht">
          <p class="tih-k">Overlap</p>
          <p class="tih-gl__hh">Your working day against ours, hour by hour</p>
        </div>
        <div class="bdh-seg tih-gl__seg" role="group" aria-label="Season, for daylight saving">
          <?php foreach ($gl_seasons as $gl_sk => $gl_sl): ?>
            <button type="button" data-season="<?= e($gl_sk) ?>" aria-pressed="<?= $gl_sk === $gl_season ? 'true' : 'false' ?>" aria-controls="global-ribbon"><?= e($gl_sl) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tih-gl__body" id="global-ribbon" style="--now:<?= round($gl_now_h / 24 * 100, 3) ?>">
        <div class="tih-gl__axis" aria-hidden="true">
          <span class="tih-gl__rl"><span class="tih-k">Hours in India</span></span>
          <span class="tih-gl__ticks"><?php for ($gl_t = 0; $gl_t <= 24; $gl_t += 3): ?><i style="left:<?= $gl_pct($gl_t) ?>"><?= sprintf('%02d', $gl_t) ?></i><?php endfor; ?></span>
          <span class="tih-gl__rv"><span class="tih-k">Shared</span></span>
        </div>

        <div class="tih-gl__rows">
          <?php for ($gl_t = 3; $gl_t < 24; $gl_t += 3): ?><span class="tih-gl__vl" style="--h:<?= $gl_t ?>" aria-hidden="true"></span><?php endfor; ?>
          <div class="tih-gl__row tih-gl__row--us">
            <p class="tih-gl__rl"><b>Studios · India</b><small>IST · UTC+5:30</small></p>
            <div class="tih-gl__track" aria-hidden="true">
              <?= $gl_bar($gl_core, 'tih-gl__core') ?>
              <?= $gl_bar($gl_ext, 'tih-gl__ext') ?>
              <i class="tih-gl__oncall"></i>
              <span class="tih-gl__ho" style="left:<?= $gl_pct($gl_ext[0]) ?>"><b>H1</b></span>
              <span class="tih-gl__ho" style="left:<?= $gl_pct($gl_ext[1]) ?>"><b>H2</b></span>
            </div>
            <p class="tih-gl__rv"><span class="tih-gl__rvv"><b><?= $gl_h($gl_core[1] - $gl_core[0]) ?></b><small>studio day</small></span></p>
          </div>

          <?php foreach ($gl_regions as $gl_ri => $gl_r): ?>
            <div class="tih-gl__row" style="--i:<?= $gl_ri ?>">
              <p class="tih-gl__rl"><b><?= e($gl_r[0]) ?></b><small><span class="tih-gl__s tih-gl__s--summer"><?= e($gl_r[1]) ?> · <?= e($gl_r[2]) ?></span><span class="tih-gl__s tih-gl__s--winter"><?= e($gl_r[1]) ?> · <?= e($gl_r[3]) ?></span></small></p>
              <div class="tih-gl__track" aria-hidden="true">
                <?php foreach (['summer' => 6, 'winter' => 7] as $gl_sk => $gl_oi):
                    $gl_parts = $gl_span($gl_r[4], $gl_r[5], $gl_r[$gl_oi]); ?>
                  <span class="tih-gl__set tih-gl__s tih-gl__s--<?= $gl_sk ?>">
                    <?php foreach ($gl_parts as $gl_p) echo $gl_bar($gl_p, 'tih-gl__day'); ?>
                    <?php foreach ($gl_clip($gl_parts, $gl_ext) as $gl_p) echo $gl_bar($gl_p, 'tih-gl__oe'); ?>
                    <?php foreach ($gl_clip($gl_parts, $gl_core) as $gl_p) echo $gl_bar($gl_p, 'tih-gl__oc'); ?>
                  </span>
                <?php endforeach; ?>
              </div>
              <p class="tih-gl__rv">
                <?php foreach (['summer' => 6, 'winter' => 7] as $gl_sk => $gl_oi):
                    $gl_parts = $gl_span($gl_r[4], $gl_r[5], $gl_r[$gl_oi]);
                    $gl_c = $gl_ov($gl_parts, $gl_core); $gl_x = $gl_ov($gl_parts, $gl_ext);
                    $gl_local = $gl_hm($gl_r[4]) . '–' . $gl_hm($gl_r[5]); ?>
                  <span class="tih-gl__s tih-gl__s--<?= $gl_sk ?>"><span class="tih-gl__rvv" aria-hidden="true"><b><?= $gl_h($gl_c) ?></b><small><?= $gl_x > 0 ? '+ ' . $gl_h($gl_x) . ' extended' : 'in the studio day' ?></small></span>
                    <span class="bdh-sr"><?= e($gl_r[0] . ', ' . $gl_seasons[$gl_sk] . ': a ' . $gl_local . ' local working day shares ' . $gl_h($gl_c) . ' with the studio day' . ($gl_x > 0 ? ' and ' . $gl_h($gl_x) . ' more with the extended shift.' : '.')) ?></span></span>
                <?php endforeach; ?>
              </p>
            </div>
          <?php endforeach; ?>

          <span class="tih-gl__now" aria-hidden="true"><b>Now <span data-ist><?= e($gl_now->format('H:i')) ?></span></b></span>
        </div>
      </div>

      <div class="tih-gl__foot">
        <p class="tih-gl__legend" aria-hidden="true">
          <span><i class="is-core"></i>Studio day 10:00–19:00</span>
          <span><i class="is-ext"></i>Extended shift, by agreement</span>
          <span><i class="is-call"></i>On-call rota, by agreement</span>
          <span><i class="is-oc"></i>Shared hours</span>
          <span><i class="is-ho"></i>H1 · H2 handovers</span>
        </p>
        <p class="tih-note">Local working days shown as 09:00–17:30 (09:00–18:00 in the Gulf and Singapore). Handovers are written down: open incidents, deploys in flight and anything waiting for approval.</p>
      </div>
    </div>
  </div>
</section>
