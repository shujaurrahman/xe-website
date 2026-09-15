<?php /* DRAFT COPY — review before launch */
/* 4 · SIGNATURE — the model spectrum. A slider walks Branded house → Sub-brands → Endorsed → House
   of brands; the same seven nodes move between structures. Pick a scenario and the architecture
   agent recommends a position with its trade-offs; a person records the decision.
   Autoplays until the first interaction. HTML = final state for the first scenario. */
/* PLACEHOLDER: illustrative scoring — confirm the model logic with the strategy lead before launch */
$cba_models = ['Branded house', 'Sub-brands', 'Endorsed', 'House of brands'];
$cba_model_def = [
    'One name on everything. Offerings are described, not branded.',
    'The master brand leads; a sub-brand adds a distinct offer beside it.',
    'Each brand leads with its own name; the parent vouches for it.',
    'Standalone brands. The parent stays out of the customer’s view.',
];
$cba_scen = [
    // key, label, new node name, recommended model, rationale, [ [cost, equity, focus] × 4 ]
    ['acq', 'Acquisition', 'Brand N · acquired', 2,
        'Brand N has customers and recognition of its own. Endorsing it keeps them while trust in the parent transfers; a full rename can follow once the equity has moved.',
        [[2, 5, 1], [3, 4, 2], [3, 3, 4], [5, 1, 4]]],
    ['cat', 'New category', 'Category entry', 3,
        'The master brand has no permission in Category A and its core customers should not feel the stretch. A standalone brand protects both; revisit after the first year.',
        [[1, 2, 1], [2, 2, 2], [3, 3, 3], [5, 1, 5]]],
    ['pre', 'Premium line', 'Premium line', 1,
        'Buyers already trust the master brand. A sub-brand marks the step up in price and craft while the parent does the heavy lifting.',
        [[1, 4, 2], [2, 5, 4], [4, 2, 3], [5, 1, 3]]],
];
$cba_meters = ['Cost to run', 'Equity transfer', 'Focus'];
$cba_s0 = $cba_scen[0]; $cba_m0 = $cba_s0[3];
$cba_snodes = [['mb', 'Your brand'], ['a', 'Sub-brand A'], ['b', 'Sub-brand B'], ['c', 'Sub-brand C'], ['pc', 'Product C'], ['e', 'Endorsed E'], ['nw', $cba_s0[2]]];
?>
<section class="band cba-spec cba-paper" id="spectrum" aria-labelledby="spectrum-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-103</b><i aria-hidden="true"></i>Architecture model · live</p>
        <h2 class="h2" id="spectrum-t"><span class="g">One portfolio,</span> four structures to test.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer'][1][1]) ?> Move along the spectrum, choose the situation you face, and see what the agent recommends before a person decides.</p>
      </div>
    </div>

    <div class="cba-spec__app" data-cba-spec data-model="<?= $cba_m0 ?>" data-scen="0">
      <div class="cba-spec__stage cba-sheet">
        <span class="cba-sheet__x cba-sheet__x--tl" aria-hidden="true"></span><span class="cba-sheet__x cba-sheet__x--tr" aria-hidden="true"></span>
        <span class="cba-sheet__x cba-sheet__x--bl" aria-hidden="true"></span><span class="cba-sheet__x cba-sheet__x--br" aria-hidden="true"></span>
        <p class="cba-spec__cap cba-mono" aria-hidden="true"><span>Structure · <b data-s="model"><?= e($cba_models[$cba_m0]) ?></b></span><span class="cba-illus">Illustrative</span></p>
        <div class="cba-spec__plot" aria-hidden="true">
          <svg class="cba-spec__lines" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false"><g data-s="lines"></g></svg>
          <?php foreach ($cba_snodes as $cba_sn): ?>
            <span class="cba-snode cba-snode--<?= $cba_sn[0] ?>" data-node="<?= $cba_sn[0] ?>"><i></i><b data-s="<?= $cba_sn[0] === 'nw' ? 'newname' : '' ?>"><?= e($cba_sn[1]) ?></b><small></small></span>
          <?php endforeach; ?>
        </div>
        <p class="cba-spec__def" data-s="def"><?= e($cba_model_def[$cba_m0]) ?></p>
      </div>

      <div class="cba-spec__panel">
        <div class="cba-spec__block">
          <label class="cba-mono cba-mono--ink" for="spectrum-range">Position on the spectrum</label>
          <input class="cba-spec__range" id="spectrum-range" type="range" min="0" max="3" step="1" value="<?= $cba_m0 ?>" aria-valuetext="<?= e($cba_models[$cba_m0]) ?>">
          <ol class="cba-spec__ticks" aria-hidden="true">
            <?php foreach ($cba_models as $cba_mi => $cba_mn): ?><li class="<?= $cba_mi === $cba_m0 ? 'is-on' : '' ?>"><?= e($cba_mn) ?></li><?php endforeach; ?>
          </ol>
        </div>

        <div class="cba-spec__block">
          <p class="cba-mono cba-mono--ink" id="spectrum-scen">Situation</p>
          <div class="cba-spec__scen" role="group" aria-labelledby="spectrum-scen">
            <?php foreach ($cba_scen as $cba_si => $cba_sc): ?>
              <button type="button" class="cba-ctl" data-scen="<?= $cba_si ?>" aria-pressed="<?= $cba_si === 0 ? 'true' : 'false' ?>"><?= e($cba_sc[1]) ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="cba-spec__agent" aria-live="polite">
          <p class="cba-spec__who"><span class="cba-spec__pulse" aria-hidden="true"></span><span class="cba-mono cba-mono--blue">Architecture agent</span><span class="cba-mono">Recommends</span></p>
          <p class="cba-spec__rec" data-s="rec"><?= e($cba_models[$cba_m0]) ?></p>
          <p class="cba-spec__why" data-s="why"><?= e($cba_s0[4]) ?></p>
          <p class="cba-mono cba-spec__viewing">Trade-offs at <b data-s="at"><?= e($cba_models[$cba_m0]) ?></b></p>
          <dl class="cba-spec__meters">
            <?php foreach ($cba_meters as $cba_ti => $cba_tn): $cba_v = $cba_s0[5][$cba_m0][$cba_ti]; ?>
              <div><dt><?= e($cba_tn) ?></dt><dd><span class="cba-spec__bar" data-meter="<?= $cba_ti ?>" style="--v:<?= $cba_v ?>"><i></i><i></i><i></i><i></i><i></i></span><b data-mval="<?= $cba_ti ?>"><?= $cba_v ?>/5</b></dd></div>
            <?php endforeach; ?>
          </dl>
        </div>

        <div class="cba-spec__decide">
          <button type="button" class="cba-ctl cba-ctl--blue" data-s="decide">Record decision at this position</button>
          <p class="cba-spec__record" data-s="record" aria-live="polite">Agents propose and score. The portfolio board decides and signs the decision record.</p>
        </div>
      </div>
      <p class="bdh-sr">Interactive: a range slider moves the portfolio between four architecture models; situation buttons change the agent’s recommendation and trade-off scores; the decide button records the chosen position.</p>
    </div>
    <script type="application/json" id="spectrum-data"><?= json_encode(['models' => $cba_models, 'defs' => $cba_model_def, 'scen' => $cba_scen], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
