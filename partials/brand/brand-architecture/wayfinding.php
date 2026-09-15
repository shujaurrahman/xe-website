<?php /* DRAFT COPY — review before launch */
/* 7 · Customer navigation — a wayfinding plan of the portfolio. Toggle Before / After architecture:
   the zones re-organise and the customer's route to one need redraws, shorter. Routes run in the
   aisles between zones, never through a label. Illustrative. SVG keeps the default
   preserveAspectRatio and plain strokes, so pathLength dash-drawing is safe. */
/* PLACEHOLDER: illustrative navigation figures — confirm with the navigation read before launch */
$cba_way = [
    'before' => [
        'zones' => [ // x, y, w, h, name — a 4 × 3 grid with aisles at x 210 / 400 / 590 and y 170 / 310
            [40, 40, 155, 115, 'Sub-brand B'], [225, 40, 160, 115, 'Label F'], [415, 40, 160, 115, 'Master brand'], [605, 40, 155, 115, 'Endorsed E'],
            [40, 185, 155, 110, 'Range G'], [225, 185, 160, 110, 'Sub-brand D'], [415, 185, 160, 110, 'Product C'], [605, 185, 155, 110, 'Sub-brand A'],
            [225, 325, 350, 85, 'Sub-brand C'],
        ],
        'path'  => 'M210 470 L210 310 L110 310 L210 310 L210 170 L400 170 L400 62 L400 170 L400 310 L590 310 L590 240',
        'dead'  => [[110, 310], [400, 62]],
        'stats' => [['Stops', '11'], ['Dead ends', '2'], ['Names met', '9'], ['Time to find', '≈ 4 min']],
        'note'  => 'Zones follow the order brands were launched or acquired. The customer meets nine names and turns back twice.',
        'dir'   => ['Sub-brand B', 'Label F', 'Master brand', 'Endorsed E', 'Range G', 'Sub-brand D', 'Product C', 'Sub-brand A', 'Sub-brand C'],
    ],
    'after' => [
        'zones' => [
            [40, 40, 340, 150, 'Sub-brand A · Segment A'], [410, 40, 350, 150, 'Sub-brand C · Segment B'],
            [40, 215, 340, 95, 'Core · Plus · Pro'], [410, 215, 350, 95, 'Endorsed E · by Your brand'],
            [40, 340, 720, 70, 'Your brand · entry'],
        ],
        'path'  => 'M210 470 L210 325 L395 325 L395 202 L300 202',
        'dead'  => [],
        'stats' => [['Stops', '3'], ['Dead ends', '0'], ['Names met', '3'], ['Time to find', '≈ 1 min']],
        'note'  => 'Zones follow the needs customers arrive with. One entry, one sub-brand per segment, descriptors for the tiers.',
        'dir'   => ['Segment A · Sub-brand A', 'Segment B · Sub-brand C', 'Tiers · Core · Plus · Pro', 'Endorsed E'],
    ],
];
?>
<section class="band band--alt cba-way" id="wayfinding" aria-labelledby="wayfinding-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-106</b><i aria-hidden="true"></i>Customer navigation</p>
        <h2 class="h2" id="wayfinding-t"><span class="g">Structure is wayfinding.</span> Walk the route a customer takes.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead">A portfolio is a building customers walk through. When zones follow the order brands arrived in, people turn back and give up. One customer, one need: find the right option for Segment A. Switch the plan and watch the route.</p>
      </div>
    </div>

    <div class="cba-way__app" data-cba-way data-state="before">
      <div class="cba-way__plan cba-sheet">
        <div class="cba-way__top">
          <div class="cba-way__switch" role="group" aria-label="Portfolio plan">
            <button type="button" class="cba-ctl" data-way="before" aria-pressed="true">Before architecture</button>
            <button type="button" class="cba-ctl" data-way="after" aria-pressed="false">After architecture</button>
          </div>
          <span class="cba-illus">Illustrative</span>
        </div>
        <p class="cba-way__hint cba-mono" aria-hidden="true">Scroll the plan →</p>
        <div class="cba-way__svgwrap" tabindex="0" role="region" aria-label="Portfolio plan, scroll sideways on small screens">
          <svg class="cba-way__svg" viewBox="0 0 800 500" role="img" aria-labelledby="wayfinding-svgt">
            <title id="wayfinding-svgt">Plan of the portfolio with a customer route from the entrance to Sub-brand A</title>
            <rect class="cba-way__outline" x="20" y="20" width="760" height="410"/>
            <?php foreach ($cba_way as $cba_wk => $cba_ws): ?>
              <g class="cba-way__layer cba-way__layer--<?= $cba_wk ?>">
                <?php foreach ($cba_ws['zones'] as $cba_zi => $cba_z): ?>
                  <g class="cba-way__zone" style="--i:<?= $cba_zi ?>">
                    <rect x="<?= $cba_z[0] ?>" y="<?= $cba_z[1] ?>" width="<?= $cba_z[2] ?>" height="<?= $cba_z[3] ?>"/>
                    <text x="<?= $cba_z[0] + 12 ?>" y="<?= $cba_z[1] + 26 ?>"><?= e($cba_z[4]) ?></text>
                  </g>
                <?php endforeach; ?>
                <path class="cba-way__route" d="<?= $cba_ws['path'] ?>" pathLength="1"/>
                <?php [$cba_gx, $cba_gy] = array_map('intval', array_slice(preg_split('/[ L]+/', trim(substr($cba_ws['path'], strrpos($cba_ws['path'], 'L')))), -2)); ?>
                <g class="cba-way__goal" transform="translate(<?= $cba_gx ?> <?= $cba_gy ?>)"><circle r="14"/><circle class="cba-way__goal-c" r="6"/></g>
                <?php foreach ($cba_ws['dead'] as $cba_dd): ?>
                  <g class="cba-way__dead" transform="translate(<?= $cba_dd[0] ?> <?= $cba_dd[1] ?>)"><path d="M-8 -8 L8 8 M8 -8 L-8 8"/></g>
                <?php endforeach; ?>
              </g>
            <?php endforeach; ?>
            <g class="cba-way__door"><rect x="190" y="426" width="40" height="8"/><text x="242" y="462">Entrance</text></g>
            <circle class="cba-way__walker" r="9" cx="210" cy="470"/>
          </svg>
        </div>
        <p class="cba-way__legend cba-mono" aria-hidden="true"><span><i class="is-route"></i>Customer route</span><span><i class="is-goal"></i>Goal · the right option</span><span><i class="is-dead"></i>Dead end</span><span>Sheet A-106 · 1 : Portfolio</span></p>
      </div>

      <aside class="cba-way__side">
        <dl class="cba-way__stats" aria-live="polite">
          <?php foreach ($cba_way['before']['stats'] as $cba_si => $cba_st): ?>
            <div><dt><?= e($cba_st[0]) ?></dt><dd data-w="s<?= $cba_si ?>"><?= e($cba_st[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="cba-way__note" data-w="note"><?= e($cba_way['before']['note']) ?></p>
        <!-- PLACEHOLDER: reference photography (Unsplash) — the directory on the panel is composited in CSS; replace before launch -->
        <figure class="cba-plate cba-way__photo" aria-hidden="true">
          <img src="<?= xe_url('assets/imgs/brand/brand-architecture/wayfinding-panel-blank.jpg') ?>" alt="" width="1000" height="1250" loading="lazy" decoding="async">
          <span class="cba-way__dir">
            <b>Directory</b>
            <?php foreach (['before', 'after'] as $cba_dk): ?>
              <ul class="cba-way__dirlist cba-way__dirlist--<?= $cba_dk ?>"><?php foreach ($cba_way[$cba_dk]['dir'] as $cba_dn): ?><li><?= e($cba_dn) ?></li><?php endforeach; ?></ul>
            <?php endforeach; ?>
          </span>
          <figcaption><b>Fig. 03</b>A directory is only as clear as the structure</figcaption>
        </figure>
        <p class="cba-way__who"><span class="cba-mono cba-mono--blue">Agent</span> maps real journeys from search logs, site paths and service transcripts. <span class="cba-mono cba-mono--ink">People</span> walk the route with customers and decide what the plan must fix.</p>
      </aside>
    </div>
    <script type="application/json" id="wayfinding-data"><?= json_encode(array_map(fn ($cba_x) => ['stats' => $cba_x['stats'], 'note' => $cba_x['note']], $cba_way), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
