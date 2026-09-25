<?php /* DRAFT COPY — review before launch */
/* Shape — the portfolio read as data, every figure computed from data/work.php at render time so it
   can never contradict the index. Three panels: how often each discipline is involved, which pairs
   of disciplines keep arriving together, and the typical length of a programme on a shared scale.
   Bars are CSS, the scale is SVG; nothing here is a client result. */

/* how many programmes each discipline appears in */
$wrk_by_d = [];
foreach ($wrk_disc as $wrk_slug => $wrk_d) $wrk_by_d[$wrk_slug] = 0;
foreach ($wrk_cases as $wrk_c) foreach (array_unique(array_column($wrk_c['did'], 0)) as $wrk_s) {
    if (isset($wrk_by_d[$wrk_s])) $wrk_by_d[$wrk_s]++;
}
arsort($wrk_by_d);
$wrk_dmax = max(1, max($wrk_by_d));

/* which two disciplines keep arriving together */
$wrk_pairs = [];
foreach ($wrk_cases as $wrk_c) {
    $wrk_ds = array_values(array_unique(array_column($wrk_c['did'], 0)));
    sort($wrk_ds);
    for ($wrk_a = 0; $wrk_a < count($wrk_ds); $wrk_a++) {
        for ($wrk_b = $wrk_a + 1; $wrk_b < count($wrk_ds); $wrk_b++) {
            $wrk_key = $wrk_ds[$wrk_a] . '|' . $wrk_ds[$wrk_b];
            $wrk_pairs[$wrk_key] = ($wrk_pairs[$wrk_key] ?? 0) + 1;
        }
    }
}
arsort($wrk_pairs);
$wrk_pairs = array_slice($wrk_pairs, 0, 5, true);
$wrk_pmax  = $wrk_pairs ? max($wrk_pairs) : 1;

/* typical length, read out of the 'duration' strings — '4–6 months', 'Ongoing, set up in 3 months' */
$wrk_span = function (string $wrk_s): array {
    preg_match_all('~\d+~', $wrk_s, $wrk_m);
    $wrk_ns = array_map('intval', $wrk_m[0]);
    $wrk_og = stripos($wrk_s, 'ongoing') !== false;
    if (!$wrk_ns) return [0, 0, $wrk_og];
    return [min($wrk_ns), max($wrk_ns), $wrk_og];
};
$wrk_scale = 12;
$wrk_rows  = [];
foreach ($wrk_cases as $wrk_c) {
    [$wrk_lo, $wrk_hi, $wrk_og] = $wrk_span($wrk_c['duration']);
    $wrk_rows[] = ['t' => $wrk_c['title'], 'lo' => $wrk_lo, 'hi' => min($wrk_hi, $wrk_scale), 'og' => $wrk_og, 'd' => $wrk_c['duration'], 'slug' => $wrk_c['slug']];
}
usort($wrk_rows, fn ($wrk_x, $wrk_y) => [$wrk_x['lo'], $wrk_x['hi']] <=> [$wrk_y['lo'], $wrk_y['hi']]);
$wrk_mid = $wrk_rows ? $wrk_rows[intdiv(count($wrk_rows), 2)] : null;
?>
<section class="band band--ink wrk-shape" id="shape" aria-labelledby="shape-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The shape of it</p>
        <h2 class="h2" id="shape-t"><span class="g">Most programmes</span> need more than one discipline.</h2>
      </div>
      <div>
        <p class="lead">Read across the index and a pattern shows up: the work that changes anything rarely sits inside one craft. Every figure below is counted from the programmes on this page, at the moment the page is built.</p>
      </div>
    </div>

    <div class="wrk-shape__grid">

      <div class="wrk-panel" data-rv data-bdh-in>
        <p class="wrk-panel__h bdh-ro">Discipline involvement <span>programmes of <?= count($wrk_cases) ?></span></p>
        <ul class="wrk-bars">
          <?php $wrk_i = 0; foreach ($wrk_by_d as $wrk_slug => $wrk_n2): $wrk_d = $wrk_disc[$wrk_slug]; ?>
          <li>
            <a class="wrk-bars__l" href="<?= xe_url('work.php') ?>?d=<?= e($wrk_slug) ?>#programmes"><?= e($wrk_d['short'] ?? $wrk_d['name']) ?></a>
            <span class="wrk-bars__t" aria-hidden="true"><span class="wrk-bars__f bdh-grow" style="--w:<?= round($wrk_n2 / $wrk_dmax * 100) ?>%;--i:<?= $wrk_i ?>"></span></span>
            <span class="wrk-bars__v bdh-ro"><?= $wrk_n2 ?></span>
          </li>
          <?php $wrk_i++; endforeach; ?>
        </ul>
        <p class="wrk-panel__f">Counted once per programme, however many capabilities within that discipline were used.</p>
      </div>

      <div class="wrk-panel" data-rv data-rv-d="70" data-bdh-in>
        <p class="wrk-panel__h bdh-ro">Pairs that keep arriving together <span>top <?= count($wrk_pairs) ?></span></p>
        <ul class="wrk-pairs">
          <?php $wrk_i = 0; foreach ($wrk_pairs as $wrk_key => $wrk_n2): [$wrk_p1, $wrk_p2] = explode('|', $wrk_key); ?>
          <li style="--i:<?= $wrk_i ?>">
            <span class="wrk-pairs__n bdh-ro"><?= $wrk_n2 ?></span>
            <span class="wrk-pairs__l"><b><?= e($wrk_disc[$wrk_p1]['short'] ?? $wrk_p1) ?></b><i aria-hidden="true">+</i><b><?= e($wrk_disc[$wrk_p2]['short'] ?? $wrk_p2) ?></b></span>
            <span class="wrk-pairs__t" aria-hidden="true"><span class="wrk-pairs__f bdh-grow" style="--w:<?= round($wrk_n2 / $wrk_pmax * 100) ?>%;--i:<?= $wrk_i ?>"></span></span>
          </li>
          <?php $wrk_i++; endforeach; ?>
        </ul>
        <p class="wrk-panel__f">A pair is counted once for every programme both disciplines worked on.</p>
      </div>

      <div class="wrk-panel wrk-panel--wide" data-rv data-rv-d="120" data-bdh-in>
        <p class="wrk-panel__h bdh-ro">Typical length <span>months, shortest first</span></p>
        <div class="wrk-gantt">
          <ol class="wrk-gantt__rows">
            <?php foreach ($wrk_rows as $wrk_i => $wrk_r): ?>
            <li>
              <span class="wrk-gantt__l"><?= e($wrk_r['t']) ?></span>
              <span class="wrk-gantt__t" aria-hidden="true">
                <span class="wrk-gantt__b<?= $wrk_r['og'] ? ' wrk-gantt__b--og' : '' ?> bdh-grow" style="--w:<?= round($wrk_r['hi'] / $wrk_scale * 100) ?>%;--i:<?= $wrk_i ?>">
                  <i style="--s:<?= $wrk_r['hi'] ? round($wrk_r['lo'] / $wrk_r['hi'] * 100) : 100 ?>%"></i>
                  <?php if ($wrk_r['og']): ?><em>›››</em><?php endif; ?>
                </span>
              </span>
              <span class="wrk-gantt__v bdh-ro"><?= e($wrk_r['d']) ?></span>
            </li>
            <?php endforeach; ?>
          </ol>
          <p class="wrk-gantt__axis bdh-ro" aria-hidden="true"><?php for ($wrk_i = 0; $wrk_i <= $wrk_scale; $wrk_i += 3): ?><span style="--p:<?= round($wrk_i / $wrk_scale * 100) ?>%"><?= $wrk_i ?></span><?php endfor; ?></p>
        </div>
        <p class="wrk-panel__f">Ranges, not commitments. <?php if ($wrk_mid): ?>The middle of this set runs <?= e($wrk_mid['d']) ?>.<?php endif; ?> A programme that says “ongoing” was set up once and then run.</p>
      </div>

    </div>
  </div>
</section>
