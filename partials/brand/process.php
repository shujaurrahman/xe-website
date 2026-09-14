<?php
/**
 * How it runs: a typical plan, drawn twice — a week-by-week plan strip (one bar
 * per phase, a playhead that travels through the live phase) and a timeline of
 * phases with what each one produces. Every description stays visible; the
 * highlight advances on its own while on screen and follows the pointer.
 * Used by the hub and by every capability page, each passing its own steps.
 *
 *   $proc     required  ['title' => html, 'lead' => text,
 *                        'steps' => [[phase, 'Wk 03–05', description, [outputs…]], …]]
 *   $procId   optional  section id (default 'process')
 *   $procLbl  optional  eyebrow (default 'How it runs')
 *   $procAlt  optional  false for a white band (default: the grey alt band)
 */
require_once __DIR__ . '/icons.php';
$prSteps = $proc['steps'];
$prN     = count($prSteps);
$prSpans = array_map(function ($s) { return bd_weeks($s[1]); }, $prSteps);
$prT     = max(1, max(array_map(function ($w) { return $w[1]; }, $prSpans)));
$prId    = isset($procId) && $procId !== '' ? $procId : 'process';
$prLbl   = $procLbl ?? 'How it runs';
$prAlt   = !isset($procAlt) || $procAlt;
$prPad   = function ($x) { return str_pad((string) $x, 2, '0', STR_PAD_LEFT); };
?>
<section class="band<?= $prAlt ? ' band--alt' : '' ?> bd-proc" id="<?= e($prId) ?>" aria-labelledby="<?= e($prId) ?>-t">
  <div class="wrap">
    <div class="head head--c bd-proc__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span><?= e($prLbl) ?></p>
      <h2 class="h2" id="<?= e($prId) ?>-t"><?= $proc['title'] ?></h2>
      <p class="lead"><?= e($proc['lead']) ?></p>
    </div>

    <!-- PLACEHOLDER: week ranges are typical, not promised — confirm before launch -->
    <div class="bd-proc__panel" data-bd-proc style="--n:<?= $prN ?>;--wk:<?= $prT ?>" data-rv data-rv-d="80">
      <div class="bd-proc__top" aria-hidden="true">
        <p class="bd-proc__status"><span class="bd-proc__ping"></span><span>Phase <b class="num" data-bd-proc-n>01</b> of <?= $prPad($prN) ?></span><i>·</i><b class="bd-proc__name" data-bd-proc-name><?= e($prSteps[0][0]) ?></b></p>
        <p class="bd-proc__total"><b class="num"><?= $prPad($prT) ?></b> weeks <i>·</i> typical</p>
      </div>

      <div class="bd-proc__plan" aria-hidden="true">
        <span class="bd-proc__bars">
          <?php foreach ($prSteps as $i => $s): [$a, $b] = $prSpans[$i]; $a = max(1, $a); $b = max($a, $b); ?>
            <i class="bd-proc__seg<?= $i === 0 ? ' is-on' : '' ?>" style="grid-column:<?= $a ?> / <?= $b + 1 ?>" data-a="<?= round(($a - 1) / $prT, 4) ?>" data-b="<?= round($b / $prT, 4) ?>"><b><?= e($s[0]) ?></b><em><?= e($s[1]) ?></em></i>
          <?php endforeach; ?>
        </span>
        <span class="bd-proc__weeks"><?php for ($w = 1; $w <= $prT; $w++): ?><i><?= $prPad($w) ?></i><?php endfor; ?></span>
        <span class="bd-proc__now"><i></i></span>
      </div>

      <ol class="bd-proc__steps">
        <?php foreach ($prSteps as $i => $s): ?>
          <li class="bd-proc__step<?= $i === 0 ? ' is-on' : '' ?>" data-name="<?= e($s[0]) ?>">
            <span class="bd-proc__node" aria-hidden="true"><i></i></span>
            <span class="bd-proc__bar" aria-hidden="true"><i></i></span>
            <span class="bd-proc__wk"><?= e($s[1]) ?></span>
            <h3 class="bd-proc__ph"><?= e($s[0]) ?></h3>
            <p class="bd-proc__d"><?= e($s[2]) ?></p>
            <?php if (!empty($s[3])): ?>
              <ul class="bd-proc__outs" aria-label="Outputs"><?php foreach ($s[3] as $o): ?><li><?= e($o) ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
