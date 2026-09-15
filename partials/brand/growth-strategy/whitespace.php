<?php /* DRAFT COPY — review before launch */
/* 05 Competitive whitespace — a perceptual map. A select chooses the two axes; Brand A–F (generic
   competitors) glide to their positions on that pair; the empty zone is outlined and described.
   The HTML is the first axis pair. <!-- PLACEHOLDER: illustrative competitor positions, confirm before launch --> */
$cgs_ws_brands = ['A', 'B', 'C', 'D', 'E', 'F'];
$cgs_ws_pairs = [ // id, label, x axis [low, high], y axis [low, high], positions x/y 0–100 for A–F + Your brand,
                  // whitespace zone [x, y, w, h] in %, finding title, finding text
    ['price-expert', 'Price × expertise', ['Low price', 'Premium'], ['Generalist', 'Specialist'],
        [[22, 30], [34, 24], [70, 78], [78, 70], [28, 40], [62, 64], [46, 36]], [8, 58, 38, 36],
        'Affordable specialist', 'Nobody offers specialist depth at a mid-to-low price. Brands C and D own expertise, but only at the premium end.',
        ['Interviews · 9 of 14 raise price', 'Specialist team already in place', 'Depth takes years to build']],
    ['speed-service', 'Speed × service', ['Slow to start', 'Instant'], ['Self-serve', 'Fully managed'],
        [[70, 22], [80, 30], [30, 76], [22, 66], [64, 34], [36, 58], [48, 44]], [58, 58, 36, 36],
        'Fast and fully managed', 'The quick options leave customers to do it themselves; the managed ones take weeks. The top-right corner is empty.',
        ['Interviews · 11 of 14 want it done for them', 'Only once onboarding is faster', 'Service model takes years to build']],
    ['scale-local', 'Scale × local presence', ['Single market', 'Multi-market'], ['Remote', 'On the ground'],
        [[76, 26], [68, 18], [24, 70], [30, 80], [82, 34], [18, 62], [40, 48]], [56, 58, 38, 36],
        'Multi-market, locally present', 'Large players serve many markets from a distance; local players stay in one. A brand with both has no direct rival.',
        ['Interviews · 7 of 14 name local support', 'Checked against market footprint', 'Needs people on the ground']],
];
$cgs_ws_first = $cgs_ws_pairs[0];
$cgs_ws_pos = function (array $xy): string { return 'left:' . $xy[0] . '%;top:' . (100 - $xy[1]) . '%'; };
?>
<section class="band band--alt cgs-white" id="whitespace" aria-labelledby="whitespace-t">
  <!-- PLACEHOLDER: illustrative competitor positions and interview counts, confirm before launch -->
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>05</b><i></i>Competitive whitespace</p>
        <h2 class="h2" id="whitespace-t"><span class="g">Plot the field on what buyers weigh.</span> The gap draws itself.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">Competitors are placed on the attributes customers actually use to choose, drawn from interviews and review mining. Change the lens and the openings change with it.</p>
      </div>
    </div>

    <div class="cgs-ws" data-cgs-white data-pairs='<?= e(json_encode(array_map(fn ($p) => ['x' => $p[2], 'y' => $p[3], 'pos' => $p[4], 'zone' => $p[5], 't' => $p[6], 'd' => $p[7], 'test' => $p[8]], $cgs_ws_pairs))) ?>'>
      <div class="cgs-ws__panel">
        <label class="cgs-ws__lbl" for="whitespace-axes">Axes</label>
        <div class="cgs-ws__select">
          <select id="whitespace-axes" data-cgs-axes aria-describedby="whitespace-find">
            <?php foreach ($cgs_ws_pairs as $cgs_wi => $cgs_wp): ?><option value="<?= $cgs_wi ?>"><?= e($cgs_wp[1]) ?></option><?php endforeach; ?>
          </select>
        </div>

        <div class="cgs-ws__find" id="whitespace-find" aria-live="polite">
          <p class="cgs-ws__k">Opening found</p>
          <h3 class="cgs-ws__t" data-cgs-wt><?= e($cgs_ws_first[6]) ?></h3>
          <p class="cgs-ws__d" data-cgs-wd><?= e($cgs_ws_first[7]) ?></p>
        </div>

        <dl class="cgs-ws__test">
          <?php foreach (['Buyers want it', 'Brand can claim it', 'Hard to copy'] as $cgs_ti => $cgs_tk): ?>
            <div><dt><?= e($cgs_tk) ?></dt><dd data-cgs-test><?= e($cgs_ws_first[8][$cgs_ti]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="cgs-ws__agent"><b>Agent</b> places brands from review text and public offers. <b>Strategist</b> decides which gap the brand can credibly defend.</p>
        <span class="cgs-illus">Illustrative</span>
      </div>

      <figure class="cgs-ws__map" aria-hidden="true">
        <div class="cgs-ws__plot">
          <span class="cgs-ws__zone" data-cgs-zone style="left:<?= $cgs_ws_first[5][0] ?>%;top:<?= 100 - $cgs_ws_first[5][1] - $cgs_ws_first[5][3] ?>%;width:<?= $cgs_ws_first[5][2] ?>%;height:<?= $cgs_ws_first[5][3] ?>%">
            <b>Whitespace</b>
          </span>
          <i class="cgs-ws__ax cgs-ws__ax--x"></i><i class="cgs-ws__ax cgs-ws__ax--y"></i>
          <?php foreach ($cgs_ws_brands as $cgs_bi => $cgs_b): ?>
            <span class="cgs-ws__dot" data-cgs-dot="<?= $cgs_bi ?>" style="<?= $cgs_ws_pos($cgs_ws_first[4][$cgs_bi]) ?>"><i></i><em>Brand <?= $cgs_b ?></em></span>
          <?php endforeach; ?>
          <span class="cgs-ws__dot cgs-ws__dot--you" data-cgs-dot="6" style="<?= $cgs_ws_pos($cgs_ws_first[4][6]) ?>"><i></i><em>Your brand</em></span>
        </div>
        <span class="cgs-ws__axl cgs-ws__axl--xl" data-cgs-x0><?= e($cgs_ws_first[2][0]) ?></span>
        <span class="cgs-ws__axl cgs-ws__axl--xh" data-cgs-x1><?= e($cgs_ws_first[2][1]) ?> →</span>
        <span class="cgs-ws__axl cgs-ws__axl--yl" data-cgs-y0><?= e($cgs_ws_first[3][0]) ?></span>
        <span class="cgs-ws__axl cgs-ws__axl--yh" data-cgs-y1>↑ <?= e($cgs_ws_first[3][1]) ?></span>
      </figure>
    </div>
  </div>
</section>
