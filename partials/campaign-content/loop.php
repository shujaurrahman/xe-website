<?php /* DRAFT COPY — review before launch */
/* Loop — SIGNATURE DIAGRAM. The discipline runs as a cycle, not a stack: four stage chips on a ring,
   four arrows between them, and "Measure" in the middle feeding the next decision. The ring is the
   tablist: each chip selects a pane describing the stage, the question it answers, the capabilities on
   it and what leaves it. Geometry comes from partials/campaign-content/_map.php, which trims every arc
   to stop clear of both chips, so no line ever runs through a box. loop.js adds the ARIA tab behaviour
   (arrow keys, Home and End) and runs a pulse around the ring while the section is on screen; with
   JavaScript off the first pane is shown and every arc is drawn. */
$loop_keys = array_keys($CCH['stages']);
?>
<section class="band band--ink cch-loop" id="loop" aria-labelledby="loop-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How the work runs</p>
        <h2 class="h2" id="loop-t"><span class="g">Not a funnel.</span> A loop that keeps turning.</h2>
      </div>
      <div>
        <p class="lead">Decide what to say, build what carries it, publish it without a gap, and reach the people who repeat it. Then measure, and decide again on evidence rather than on the last meeting.</p>
        <p class="cch-hint"><span class="cch-kbd">←</span><span class="cch-kbd">→</span> to move around the loop</p>
      </div>
    </div>

    <div class="cch-loop__body" data-rv data-rv-d="80" data-bdh-live>
      <div class="cch-loop__vis">
        <p class="bdh-sr">A cycle of four stages. Stage 01 Decide leads to 02 Build, then 03 Publish, then 04 Reach, and back to 01. Measurement sits in the middle and feeds the next decision. Each stage is a button below that opens its detail.</p>
        <div class="cch-ring cch-loop__ring">
          <svg viewBox="0 0 <?= (int) $CCH['ring']['vb'] ?> <?= (int) $CCH['ring']['vb'] ?>" fill="none" focusable="false" aria-hidden="true">
            <circle class="cch-loop__track" cx="<?= (int) $CCH['ring']['c'] ?>" cy="<?= (int) $CCH['ring']['c'] ?>" r="<?= (int) $CCH['ring']['r'] ?>"/>
            <g class="cch-loop__arcs bdh-draw">
              <?php foreach ($CCH['arcs'] as $loop_ai => $loop_a): ?>
                <path class="cch-loop__arc<?= $loop_ai === 0 ? ' is-on' : '' ?>" data-arc="<?= e($loop_a['stage']) ?>" d="<?= e($loop_a['d']) ?>" pathLength="1" style="--i:<?= $loop_ai * 2 ?>"/>
              <?php endforeach; ?>
            </g>
            <g class="cch-loop__heads">
              <?php foreach ($CCH['arcs'] as $loop_hi => $loop_a): ?>
                <path class="cch-loop__head<?= $loop_hi === 0 ? ' is-on' : '' ?>" data-arc="<?= e($loop_a['stage']) ?>" d="<?= e($loop_a['head']) ?>"/>
              <?php endforeach; ?>
            </g>
            <circle class="cch-loop__hubring" cx="<?= (int) $CCH['ring']['c'] ?>" cy="<?= (int) $CCH['ring']['c'] ?>" r="106"/>
            <g class="cch-loop__pk"><circle r="5" cx="<?= (int) $CCH['ring']['c'] ?>" cy="<?= (int) ($CCH['ring']['c'] - $CCH['ring']['r']) ?>"/></g>
          </svg>

          <span class="cch-loop__hub">
            <b>Measure</b>
            <span>One definition per metric</span>
          </span>

          <div class="cch-loop__tabs" role="tablist" aria-label="The four stages of the loop">
            <?php foreach ($CCH['stages'] as $loop_k => $loop_s): $loop_on = $loop_s['i'] === 0; ?>
              <button class="cch-ring__chip cch-loop__chip" type="button" role="tab" id="loop-t<?= $loop_s['i'] ?>"
                      aria-controls="loop-p<?= $loop_s['i'] ?>" aria-selected="<?= $loop_on ? 'true' : 'false' ?>" tabindex="<?= $loop_on ? '0' : '-1' ?>"
                      data-stage="<?= e($loop_k) ?>" style="--x:<?= $loop_s['x'] ?>;--y:<?= $loop_s['y'] ?>">
                <b><?= e($loop_s['code']) ?></b><?= e($loop_s['name']) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="cch-loop__panes bdh-panes">
        <?php foreach ($CCH['stages'] as $loop_k => $loop_s): $loop_on = $loop_s['i'] === 0; ?>
          <div class="bdh-pane cch-loop__pane<?= $loop_on ? ' is-on' : '' ?>" id="loop-p<?= $loop_s['i'] ?>" role="tabpanel"
               aria-labelledby="loop-t<?= $loop_s['i'] ?>" tabindex="0" data-stage="<?= e($loop_k) ?>">
            <p class="cch-loop__phk"><span class="cch-k">Stage <?= e($loop_s['code']) ?> of 04</span><span class="cch-loop__pnx">then <?= e($CCH['stages'][$loop_keys[($loop_s['i'] + 1) % 4]]['name']) ?> <i aria-hidden="true">›</i></span></p>
            <h3 class="cch-loop__pt"><?= e($loop_s['lbl']) ?></h3>
            <p class="cch-loop__pq"><?= e($loop_s['q']) ?></p>
            <p class="cch-loop__pl"><?= e($loop_s['lead']) ?></p>

            <p class="cch-k cch-loop__ck">On this stage · <?= count($loop_s['caps']) ?> of <?= count($CAPS) ?> capabilities</p>
            <ul class="cch-loop__caps" role="list">
              <?php foreach ($loop_s['caps'] as $loop_slug): $loop_c = $CAPS[$loop_slug]; ?>
                <li>
                  <a class="cch-loop__cap" href="#<?= e($loop_slug) ?>">
                    <span class="cch-loop__cico" aria-hidden="true"><?= xt_icon($loop_c['icon'], ['size' => 20]) ?></span>
                    <span class="cch-loop__ctx"><b><?= e($loop_c['name']) ?></b><small><?= e($loop_c['kicker']) ?></small></span>
                    <i aria-hidden="true">›</i>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>

            <p class="cch-k cch-loop__ok">What leaves this stage</p>
            <ul class="cch-loop__out" role="list">
              <?php foreach ($loop_s['out'] as $loop_o): ?><li><?= e($loop_o) ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="cch-loop__foot">
      <p class="cch-note">The loop is why the eight capabilities are sold and run together. A campaign built without the Decide stage buys channels out of habit; one built without Measure cannot tell you which half worked.</p>
    </div>
  </div>
</section>
