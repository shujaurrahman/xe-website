<?php /* DRAFT COPY — review before launch */
/* 04 · Flex rules — each element has a range from strict to expressive with a safe band.
   Drag a marker (native range input) and the status and example update. Bands are illustrative.
   PLACEHOLDER: ranges, presets and wording are examples — confirm before launch */
$cbs_fx_rows = [   // [key, element, what is measured, floor, ceiling, start, rule, too-low, too-high]
    ['colour',  'Colour',  'Blue coverage of the surface',   10, 60, 35, 'Blue leads, paper carries. Accents may grow for campaigns.',          'The accent disappears and the surface reads as unbranded.', 'Blue floods the surface and the brand reads as someone else’s.'],
    ['type',    'Type',    'Display size against body',      25, 80, 55, 'Outfit display, Montserrat reading. Scale may grow, never flatten.',  'No hierarchy: headlines and body sit at the same weight.',   'The headline overruns its frame and crops on small screens.'],
    ['imagery', 'Imagery', 'Crop and treatment',              0, 50, 20, 'People at work, natural light. Crops may tighten, subjects stay.',     '',                                                           'The crop loses the subject and the picture stops saying anything.'],
    ['layout',  'Layout',  'Departure from the 12-column grid', 0, 40, 15, 'Twelve columns. Campaigns may break the grid on one element per view.', '',                                                        'Every element leaves the grid, so nothing reads as the system.'],
];
$cbs_fx_presets = [   // [label, colour, type, imagery, layout]
    ['Core product',      22, 40, 12, 8],
    ['Seasonal campaign', 48, 72, 38, 30],
    ['Market 03 launch',  34, 58, 26, 18],
    ['Sub-brand B pitch', 74, 88, 62, 52],
];
?>
<section class="band cbs-fx" id="flex" aria-labelledby="cbs-fx-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>04</b><i>/</i>flex-rules<i>/</i>ranges</p>
      <h2 class="cbs-head__h" id="cbs-fx-t"><span class="g">Ranges,</span> not opinions.</h2>
      <p class="lead cbs-head__lead">Every element gets a floor and a ceiling. Inside the band, a campaign, a market or a sub-brand can stretch without asking. Outside it, the change goes to the system owner. Drag a marker, or load a brief, and the rule answers.</p>
    </header>

    <div class="cbs-fx__box" data-cbs-fx>
      <div class="cbs-fx__top">
        <div class="cbs-fx__presets" role="group" aria-label="Load a brief">
          <span class="cbs-fx__pl">Load a brief</span>
          <?php foreach ($cbs_fx_presets as $cbs_pi => $cbs_pr): ?>
            <button type="button" class="cbs-btn" aria-pressed="false" data-cbs-fx-preset="<?= e(implode(',', array_slice($cbs_pr, 1))) ?>"><?= e($cbs_pr[0]) ?></button>
          <?php endforeach; ?>
        </div>
        <p class="cbs-fx__verdict" role="status" aria-live="polite" data-cbs-fx-verdict><b>4 of 4 in range</b><span>Ships without review</span></p>
      </div>

      <div class="cbs-fx__scale" aria-hidden="true"><span>Strict</span><span>Expressive</span></div>

      <ol class="cbs-fx__rows">
        <?php foreach ($cbs_fx_rows as $cbs_ri => $cbs_r): ?>
          <li class="cbs-fx__row cbs-fx__row--<?= e($cbs_r[0]) ?>" data-cbs-fx-row data-floor="<?= $cbs_r[3] ?>" data-ceil="<?= $cbs_r[4] ?>" data-low="<?= e($cbs_r[7]) ?>" data-high="<?= e($cbs_r[8]) ?>" style="--v:<?= $cbs_r[5] ?>;--lo:<?= $cbs_r[3] ?>;--hi:<?= $cbs_r[4] ?>">
            <div class="cbs-fx__lab">
              <p class="cbs-fx__n"><?= sprintf('%02d', $cbs_ri + 1) ?> · <?= e($cbs_r[2]) ?></p>
              <h3 class="cbs-fx__h"><label for="cbs-fx-<?= e($cbs_r[0]) ?>"><?= e($cbs_r[1]) ?></label></h3>
              <p class="cbs-fx__rule"><?= e($cbs_r[6]) ?></p>
            </div>

            <div class="cbs-fx__track">
              <span class="cbs-fx__ticks" aria-hidden="true"></span>
              <span class="cbs-fx__band" aria-hidden="true"><i>floor <?= $cbs_r[3] ?></i><i>ceiling <?= $cbs_r[4] ?></i></span>
              <span class="cbs-fx__needle" aria-hidden="true"><b data-cbs-fx-val><?= $cbs_r[5] ?></b></span>
              <input class="cbs-fx__in" type="range" id="cbs-fx-<?= e($cbs_r[0]) ?>" min="0" max="100" step="1" value="<?= $cbs_r[5] ?>" aria-describedby="cbs-fx-st-<?= e($cbs_r[0]) ?>">
              <p class="cbs-fx__st" id="cbs-fx-st-<?= e($cbs_r[0]) ?>" data-cbs-fx-status><span class="cbs-fx__badge">In range</span><span class="cbs-fx__why">Inside the band. Ships without review.</span></p>
            </div>

            <div class="cbs-fx__ex" aria-hidden="true">
              <?php if ($cbs_r[0] === 'colour'): ?>
                <span class="cbs-fx__paint"><i></i><b>Your brand</b></span>
              <?php elseif ($cbs_r[0] === 'type'): ?>
                <span class="cbs-fx__type"><b>Built for Segment A</b><i>Three ways teams use Product C in the first month.</i></span>
              <?php elseif ($cbs_r[0] === 'imagery'): ?>
                <!-- PLACEHOLDER: reference photo (Unsplash) — confirm before launch -->
                <span class="cbs-fx__img"><img src="<?= xe_url('assets/imgs/brand/brand-systems/flex-crop.jpg') ?>" alt="" width="800" height="600" loading="lazy" decoding="async"></span>
              <?php else: ?>
                <span class="cbs-fx__grid"><i></i><i></i><i></i><i></i><i></i><i></i></span>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="cbs-fx__foot"><span class="cbs-note">Bands illustrative</span><span>The agent measures each asset against the bands before it ships. People decide every exception.</span></p>
    </div>
  </div>
</section>
