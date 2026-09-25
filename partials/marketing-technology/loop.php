<?php /* DRAFT COPY — review before launch */
/* Loop — THE DIAGRAM IDIOM for this discipline. The customer system drawn as one closed ring of six
   stages, with the customer record in the middle. The six nodes on the ring ARE the tab controls
   (role="tab", arrow keys, Home/End through BDH.tabs), so the diagram is the interface rather than a
   picture beside one. Every pane is in the markup with the first one on, so the section is complete and
   readable with JavaScript off. loop.js runs a packet around the ring and moves the selection on a slow
   cycle until the reader takes over; under reduced motion nothing moves.
   The ring is one path and the nodes sit on it, so no connector is ever drawn through a box. */
$loo_keys = array_keys($MTH['stages']);
$loo_c    = 280;      // the 560 × 560 stage's centre
$loo_r    = 205;      // the radius the six stage nodes sit on
$loo_nw   = 150;      // node width and height in stage units, for the geometry only
$loo_nh   = 64;
$loo_pt   = [];       // node centres in stage units
$loo_pos  = [];       // the same, as percentages for the CSS
foreach ($loo_keys as $loo_i => $loo_k) {
    $loo_a = deg2rad(-90 + $loo_i * 60);
    $loo_pt[$loo_k]  = [$loo_c + $loo_r * cos($loo_a), $loo_c + $loo_r * sin($loo_a)];
    $loo_pos[$loo_k] = [round($loo_pt[$loo_k][0] / 5.6, 3), round($loo_pt[$loo_k][1] / 5.6, 3)];
}
/* The ring is not one circle through the boxes: it is six arcs, each trimmed to where it leaves one
   stage and enters the next, with a chevron at the arrival end. Concatenated into a single path it is
   still one route, so the packet can run the whole lap across the gaps (defect class 4, BUILD-BRIEF §2). */
$loo_ring = '';
$loo_arrows = '';
foreach ($loo_keys as $loo_i => $loo_k) {
    $loo_n = $loo_keys[($loo_i + 1) % count($loo_keys)];
    $loo_a = mth_box($loo_pt[$loo_k][0], $loo_pt[$loo_k][1], $loo_nw, $loo_nh);
    $loo_b = mth_box($loo_pt[$loo_n][0], $loo_pt[$loo_n][1], $loo_nw, $loo_nh);
    $loo_p1 = mth_ray($loo_a, $loo_pt[$loo_n][0], $loo_pt[$loo_n][1], 9);
    $loo_p2 = mth_ray($loo_b, $loo_pt[$loo_k][0], $loo_pt[$loo_k][1], 13);
    /* control point: the chord's midpoint pushed away from the centre, so the arc bows outwards */
    $loo_mx = ($loo_p1[0] + $loo_p2[0]) / 2;
    $loo_my = ($loo_p1[1] + $loo_p2[1]) / 2;
    $loo_ml = max(0.001, hypot($loo_mx - $loo_c, $loo_my - $loo_c));
    $loo_cx = $loo_c + ($loo_mx - $loo_c) / $loo_ml * ($loo_ml + 30);
    $loo_cy = $loo_c + ($loo_my - $loo_c) / $loo_ml * ($loo_ml + 30);
    $loo_ring .= sprintf('M%.1f %.1fQ%.1f %.1f %.1f %.1f', $loo_p1[0], $loo_p1[1], $loo_cx, $loo_cy, $loo_p2[0], $loo_p2[1]);
    /* the chevron points along the arc's tangent where it arrives */
    $loo_tx = $loo_p2[0] - $loo_cx;
    $loo_ty = $loo_p2[1] - $loo_cy;
    $loo_tl = max(0.001, hypot($loo_tx, $loo_ty));
    $loo_ux = $loo_tx / $loo_tl; $loo_uy = $loo_ty / $loo_tl;
    $loo_arrows .= sprintf(
        'M%.1f %.1fL%.1f %.1fL%.1f %.1f',
        $loo_p2[0] - $loo_ux * 7 - $loo_uy * 5, $loo_p2[1] - $loo_uy * 7 + $loo_ux * 5,
        $loo_p2[0], $loo_p2[1],
        $loo_p2[0] - $loo_ux * 7 + $loo_uy * 5, $loo_p2[1] - $loo_uy * 7 - $loo_ux * 5
    );
}
/* the one-line readout for each stage: what the system actually did to this record */
$loo_trace = [
    'collect'  => 'evt.order_placed · src=commerce · consent_state=granted · 09:14:02',
    'resolve'  => 'match sha256(email) · 4 records → prf_8f21c · survivorship=crm',
    'decide'   => 'segment=high-value/lapsing · nba=whatsapp:service_reminder · p=0.71',
    'produce'  => 'template=svc_reminder · locale=en-IN · brand_check=pass · claims=pass',
    'activate' => 'queued 19:10 IST · frequency_cap=1/7d ok · quiet_hours ok · consent ok',
    'measure'  => 'holdout=B 10% · incremental revenue vs control · ltv refit weekly',
];
$loo_first = $loo_keys[0];
?>
<section class="band band--ink mth-loop" id="loop" aria-labelledby="loop-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The loop</p>
        <h2 class="h2" id="loop-t"><span class="g">Six stages.</span> One customer, going round.</h2>
      </div>
      <div>
        <p class="lead">Marketing technology is not a stack of products, it is a loop. Signal is collected, one person is resolved out of it, a decision is made, something is produced, it is activated in a channel, and the result is measured — then the measurement changes the next decision. Choose a stage.</p>
      </div>
    </div>

    <div class="mth-loo" data-stage="<?= e($loo_first) ?>" data-rv data-rv-d="70" data-bdh-live>
      <div class="mth-loo__left">
        <p class="bdh-sr">The six stages of the customer loop, in order: <?php $loo_sr = [];
          foreach ($MTH['stages'] as $loo_s) { $loo_sr[] = $loo_s['name'] . ', ' . lcfirst(rtrim($loo_s['line'], '.')); }
          echo e(implode('; ', $loo_sr)); ?>. The measurement feeds the next decision, which is what makes it a loop.</p>

        <div class="mth-stage mth-loo__stage" style="--ar:1 / 1" role="tablist" aria-label="Stages of the customer loop">
          <svg viewBox="0 0 560 560" focusable="false" aria-hidden="true">
            <circle class="mth-loo__ring2" cx="<?= $loo_c ?>" cy="<?= $loo_c ?>" r="<?= $loo_r - 64 ?>"/>
            <path class="mth-loo__ring" d="<?= e($loo_ring) ?>"/>
            <path class="mth-loo__arrow" d="<?= e($loo_arrows) ?>"/>
            <path class="mth-loo__pk" d="<?= e($loo_ring) ?>" pathLength="1"/>
          </svg>

          <span class="mth-loo__hub" aria-hidden="true">
            <span class="mth-k">In the middle</span>
            <b>One consented<br>customer record</b>
            <span class="mth-loo__hubs">identity · consent · segments · scores · history</span>
          </span>

          <?php foreach ($MTH['stages'] as $loo_k => $loo_s): $loo_on = $loo_k === $loo_first; ?>
            <button class="mth-node mth-loo__node<?= $loo_on ? ' mth-node--on' : '' ?>" type="button" role="tab"
                    id="loop-t-<?= e($loo_k) ?>" aria-controls="loop-p-<?= e($loo_k) ?>"
                    aria-selected="<?= $loo_on ? 'true' : 'false' ?>" tabindex="<?= $loo_on ? '0' : '-1' ?>"
                    data-stage="<?= e($loo_k) ?>"
                    style="--x:<?= $loo_pos[$loo_k][0] ?>;--y:<?= $loo_pos[$loo_k][1] ?>;--w:26.8">
              <span class="mth-node__t"><b><?= e($loo_s['code']) ?></b><?= e($loo_s['name']) ?></span>
              <span class="mth-node__s"><?= e(implode(' · ', array_slice($loo_s['out'], 0, 2))) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <p class="mth-loo__trace" aria-hidden="true">
          <span class="mth-k">One record, one lap</span>
          <span class="mth-loo__tx"><?= e($loo_trace[$loo_first]) ?></span>
        </p>
        <p class="mth-hint" aria-hidden="true"><span class="mth-kbd">←</span><span class="mth-kbd">→</span> move round the loop</p>
      </div>

      <div class="mth-loo__panes bdh-panes">
        <?php foreach ($MTH['stages'] as $loo_k => $loo_s): $loo_on = $loo_k === $loo_first; ?>
          <div class="bdh-pane mth-loo__pane<?= $loo_on ? ' is-on' : '' ?>" id="loop-p-<?= e($loo_k) ?>" role="tabpanel"
               aria-labelledby="loop-t-<?= e($loo_k) ?>" tabindex="0" data-stage="<?= e($loo_k) ?>" data-trace="<?= e($loo_trace[$loo_k]) ?>">
            <div class="mth-loo__ph">
              <span class="mth-loo__pico"><?= xt_icon($loo_s['icon'], ['size' => 22]) ?></span>
              <div>
                <p class="mth-k mth-k--blue"><?= e($loo_s['code']) ?> · Stage <?= array_search($loo_k, $loo_keys, true) + 1 ?> of 6</p>
                <h3 class="mth-loo__pt"><?= e($loo_s['name']) ?></h3>
              </div>
            </div>
            <p class="mth-loo__pl"><?= e($loo_s['line']) ?></p>

            <div class="mth-loo__cols">
              <div>
                <p class="mth-k">What we build here</p>
                <ul class="bdh-bullets mth-loo__does"><?php foreach ($loo_s['does'] as $loo_d): ?><li><?= e($loo_d) ?></li><?php endforeach; ?></ul>
              </div>
              <div class="mth-loo__side">
                <p class="mth-k">What comes out</p>
                <span class="bdh-tags"><?php foreach ($loo_s['out'] as $loo_o): ?><span class="bdh-tag"><?= e($loo_o) ?></span><?php endforeach; ?></span>
                <p class="mth-k">Technologies we work with here</p>
                <?= xt_stack($loo_s['stack'], ['variant' => 'chips', 'size' => 16, 'label' => 'Technologies used in the ' . $loo_s['name'] . ' stage', 'class' => 'mth-loo__stk']) ?>
              </div>
            </div>

            <div class="mth-loo__caps">
              <p class="mth-k">Capabilities that do this work</p>
              <span class="mth-capls">
                <?php foreach ($loo_s['caps'] as $loo_cs): $loo_c = $CAPS[$loo_cs]; ?>
                  <a class="mth-capl" href="<?= e(($MTH['cap_href'])($loo_cs)) ?>"><b><?= e($loo_c['n']) ?></b><?= e($loo_c['name']) ?><i aria-hidden="true">›</i></a>
                <?php endforeach; ?>
              </span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="mth-note mth-loo__note">The loop is the reason the seven capabilities are one team. A decision is only as good as the record under it, and a record is only worth keeping if something acts on it and reports back.</p>
  </div>
</section>
