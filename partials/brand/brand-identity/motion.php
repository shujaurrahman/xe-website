<?php /* DRAFT COPY — review before launch */
/* Plate 07 — Motion & sound. Four easing curves as motion principles: the graph, an onion-skin track where
   the mark travels along the chosen curve, a scrubber and play control. Then the sonic signature: a
   waveform with a playhead and a three-note sketch synthesised in the browser (only on click). */
$mo_curves = [   // [key, name, character, cubic-bezier, ms, used for]   PLACEHOLDER: illustrative timings — confirm before launch
    ['enter', 'Enter',    'Decelerate: arrives quickly, settles gently', [0.22, 1, 0.36, 1],    600, 'Panels, cards and page content arriving'],
    ['move',  'Move',     'Ease in-out: leaves and lands with equal care', [0.65, 0, 0.35, 1],  400, 'Anything changing place or size'],
    ['exit',  'Exit',     'Accelerate: gets out of the way',             [0.55, 0, 1, 0.45],    240, 'Dismissing, closing, leaving'],
    ['emph',  'Emphasis', 'A small overshoot, used sparingly',           [0.34, 1.45, 0.64, 1], 500, 'Confirmations and the mark on first open'],
];
$mo_bez  = fn (float $s, float $a, float $b): float => 3 * $a * $s * (1 - $s) ** 2 + 3 * $b * $s * $s * (1 - $s) + $s ** 3;
$mo_path = function (array $c) use ($mo_bez): string {
    $pts = [];
    for ($i = 0; $i <= 48; $i++) { $s = $i / 48; $pts[] = round(20 + 200 * $mo_bez($s, $c[0], $c[2]), 1) . ' ' . round(200 - 150 * $mo_bez($s, $c[1], $c[3]), 1); }
    return 'M' . implode('L', $pts);
};
$mo_ease = function (array $c, float $x) use ($mo_bez): float {
    $lo = 0; $hi = 1;
    for ($k = 0; $k < 30; $k++) { $m = ($lo + $hi) / 2; if ($mo_bez($m, $c[0], $c[2]) < $x) $lo = $m; else $hi = $m; }
    return $mo_bez(($lo + $hi) / 2, $c[1], $c[3]);
};
$mo_mark = '<svg viewBox="0 0 400 400"><circle cx="150" cy="200" r="100"/><path d="M250 100h100v100h-100z" class="b"/><path d="M250 200h100a100 100 0 0 1-100 100z"/><circle cx="150" cy="200" r="50" class="k"/></svg>';
$mo_bars = [];
for ($i = 0; $i < 60; $i++) {   // three struck notes, each decaying, with a little texture
    $v = 0.04;
    foreach ([4, 17, 30] as $mo_n => $mo_at) { if ($i >= $mo_at) $v += (1 - $mo_n * 0.12) * exp(-($i - $mo_at) / (7 + $mo_n * 4)); }
    $mo_bars[] = min(1, $v * (0.72 + 0.28 * abs(sin($i * 1.9))));
}
$mo_json = array_map(fn ($c) => ['k' => $c[0], 'b' => $c[3], 'ms' => $c[4], 'use' => $c[5]], $mo_curves);
?>
<section class="cbi-sec cbi-mo" id="motion" aria-labelledby="motion-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 07 · Motion &amp; sound</span><span>Timing · easing · signature</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="motion-t"><span class="g">Move like the brand.</span> Sound like it, where it has to.</h2>
      </div>
      <p class="lead">Four curves and their timings cover almost every movement a brand makes, from a button to a film title. Pick one, scrub it, and watch the spacing of the frames: that spacing is the personality.</p>
    </div>

    <div class="cbi-mo__lab" data-curves='<?= e(json_encode($mo_json)) ?>'>
      <div class="cbi-mo__graph">
        <p class="cbi-mo__gh"><span class="cbi-lbl cbi-lbl--ink">Easing curve</span><code class="cbi-mo__bz">cubic-bezier(0.22, 1, 0.36, 1)</code></p>
        <svg class="cbi-mo__svg" viewBox="0 0 240 230" aria-hidden="true">
          <line x1="20" y1="50" x2="220" y2="50" class="ax ax--d"/><line x1="220" y1="30" x2="220" y2="200" class="ax ax--d"/>
          <line x1="20" y1="200" x2="224" y2="200" class="ax"/><line x1="20" y1="204" x2="20" y2="24" class="ax"/>
          <text x="220" y="218" text-anchor="end">time</text><text x="14" y="54" text-anchor="end">1</text><text x="14" y="204" text-anchor="end">0</text>
          <?php foreach ($mo_curves as $mo_i => $mo_c): ?><path class="cbi-mo__curve<?= $mo_i === 0 ? ' is-on' : '' ?>" data-k="<?= e($mo_c[0]) ?>" d="<?= $mo_path($mo_c[3]) ?>"/><?php endforeach; ?>
          <line class="cbi-mo__gx" x1="220" y1="200" x2="220" y2="50"/><line class="cbi-mo__gy" x1="20" y1="50" x2="220" y2="50"/>
          <circle class="cbi-mo__dot" cx="220" cy="50" r="5"/>
        </svg>
        <div class="cbi-mo__curves" role="group" aria-label="Easing curve">
          <?php foreach ($mo_curves as $mo_i => $mo_c): ?>
          <button type="button" class="cbi-mo__cb" aria-pressed="<?= $mo_i === 0 ? 'true' : 'false' ?>"><b><?= e($mo_c[1]) ?></b><span><?= (int) $mo_c[4] ?> ms</span><small><?= e($mo_c[2]) ?></small></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="cbi-mo__stage">
        <p class="cbi-mo__sh"><span class="cbi-lbl cbi-lbl--ink">Onion skin · nine frames</span><span class="cbi-ill">Illustrative · shown 3× slower</span></p>
        <div class="cbi-mo__track" style="--p:1" aria-hidden="true">
          <?php for ($mo_g = 0; $mo_g <= 8; $mo_g++): ?><span class="cbi-mo__ghost" style="--g:<?= round($mo_ease($mo_curves[0][3], $mo_g / 8), 4) ?>;--o:<?= round(0.1 + $mo_g * 0.045, 3) ?>"><?= $mo_mark ?></span><?php endfor; ?>
          <span class="cbi-mo__mark"><?= $mo_mark ?></span>
        </div>
        <div class="cbi-mo__ruler" aria-hidden="true"><?php for ($mo_r = 0; $mo_r <= 4; $mo_r++): ?><span><?= (int) round($mo_curves[0][4] * $mo_r / 4) ?> ms</span><?php endfor; ?></div>
        <div class="cbi-mo__ctl">
          <button type="button" class="cbi-btn cbi-mo__play">Play</button>
          <label class="bdh-sr" for="motion-scrub">Scrub the motion timeline</label>
          <input class="cbi-mo__scrub" id="motion-scrub" type="range" min="0" max="1000" value="1000">
          <output class="cbi-mo__ro" for="motion-scrub">600 ms · 100%</output>
        </div>
        <p class="cbi-mo__use"><span class="cbi-lbl">Used for</span><span class="cbi-mo__usev"><?= e($mo_curves[0][5]) ?></span></p>
      </div>
    </div>

    <div class="cbi-mo__sonic">
      <div class="cbi-mo__stext">
        <p class="cbi-lbl cbi-lbl--blue">Sonic signature</p>
        <h3 class="cbi-mo__st">Three notes, 1.2 seconds.</h3>
        <p class="cbi-mo__sd">Written for the few moments that are heard rather than seen: an app opening, a payment confirmed, the end of a film. Delivered with a short brief on where it plays, where it never plays, and how loud.</p>
        <button type="button" class="cbi-btn cbi-btn--blue cbi-mo__listen" aria-describedby="motion-snote">Play the sketch <span aria-hidden="true">▸</span></button>
        <p class="cbi-mo__note" id="motion-snote">Plays a short, quiet tone synthesised in your browser. A sketch, not the final signature.</p>
      </div>
      <div class="cbi-mo__wave" aria-hidden="true">
        <span class="cbi-crop"><i></i><i></i><i></i><i></i></span>
        <div class="cbi-mo__bars"><?php foreach ($mo_bars as $mo_i => $mo_v): ?><i style="--h:<?= round($mo_v, 3) ?>;--x:<?= round($mo_i / 59, 4) ?>"></i><?php endforeach; ?></div>
        <span class="cbi-mo__head"></span>
        <p class="cbi-mo__notes"><span style="--x:.067">E5</span><span style="--x:.288">B5</span><span style="--x:.508">E6</span></p>
        <p class="cbi-mo__time"><span>0.0 s</span><span>0.6 s</span><span>1.2 s</span></p>
      </div>
    </div>
  </div>
</section>
