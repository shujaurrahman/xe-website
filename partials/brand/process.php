<?php
/**
 * How it runs. Expects $proc = ['title' => html, 'lead' => text,
 * 'steps' => [[phase, weeks, description, [outputs…]], …]]. Used by the hub
 * and by every capability page, each passing its own steps. The week strings
 * ('Wk 03–05') also draw the plan strip across the top of the panel.
 */
require_once __DIR__ . '/icons.php';
$steps = $proc['steps'];
$n     = count($steps);
$spans = array_map(function ($s) { return bd_weeks($s[1]); }, $steps);
$T     = max(1, max(array_map(function ($w) { return $w[1]; }, $spans)));
?>
<section class="band band--alt bd-proc" id="process" aria-labelledby="proc-t">
  <div class="wrap">
    <div class="head head--c bd-proc__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
      <h2 class="h2" id="proc-t"><?= $proc['title'] ?></h2>
      <p class="lead"><?= e($proc['lead']) ?></p>
    </div>

    <!-- PLACEHOLDER: week ranges are typical, not promised — confirm before launch -->
    <div class="bd-proc__panel" data-bd-proc style="--n:<?= $n ?>;--wk:<?= $T ?>" data-rv data-rv-d="80">
      <div class="bd-proc__top">
        <p class="bd-proc__status"><span class="bd-proc__ping" aria-hidden="true"></span><span data-bd-proc-status aria-live="off">Phase <b class="num">01</b> of <?= str_pad((string) $n, 2, '0', STR_PAD_LEFT) ?></span></p>
        <div class="bd-proc__plan" aria-hidden="true">
          <span class="bd-proc__bars">
            <?php foreach ($steps as $i => $s): [$a, $b] = $spans[$i]; ?>
              <i class="bd-proc__seg<?= $i === 0 ? ' is-on' : '' ?>" style="grid-column:<?= max(1, $a) ?> / <?= max(1, $b) + 1 ?>"><b><?= e($s[0]) ?></b></i>
            <?php endforeach; ?>
          </span>
          <span class="bd-proc__weeks">
            <?php for ($w = 1; $w <= $T; $w++): ?><i><?= str_pad((string) $w, 2, '0', STR_PAD_LEFT) ?></i><?php endfor; ?>
          </span>
        </div>
        <p class="bd-proc__total"><b class="num"><?= $T ?></b> weeks · typical</p>
      </div>

      <div class="bd-proc__body">
        <span class="bd-proc__track" aria-hidden="true"><i class="bd-proc__fill"></i></span>
        <div class="bd-proc__steps" role="tablist" aria-label="Phases">
          <?php foreach ($steps as $i => $s): $on = $i === 0; ?>
            <button class="bd-proc__step<?= $on ? ' is-on' : '' ?>" type="button" role="tab"
                    id="proc-t<?= $i ?>" aria-selected="<?= $on ? 'true' : 'false' ?>"<?= $on ? '' : ' tabindex="-1"' ?>>
              <span class="bd-proc__node" aria-hidden="true"><i></i></span>
              <span class="bd-proc__wk"><?= e($s[1]) ?></span>
              <span class="bd-proc__ph"><?= e($s[0]) ?></span>
              <span class="bd-proc__d"><?= e($s[2]) ?></span>
              <span class="bd-proc__outs">
                <?php foreach ($s[3] as $o): ?><i><?= e($o) ?></i><?php endforeach; ?>
              </span>
              <span class="bd-proc__bar" aria-hidden="true"><i></i></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
