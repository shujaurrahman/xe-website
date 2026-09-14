<?php
/**
 * What changes once it ships — the outcomes, on ink.
 *
 *   $cap       required  outcomes [[title, description], …]
 *   $outTitle  optional  heading html (default: '<span class="g">Three things</span> you will notice')
 *   $outLead   optional  lead text
 */
$ocItems = $cap['outcomes'];
$ocWords = [2 => 'Two things', 3 => 'Three things', 4 => 'Four things', 5 => 'Five things'];
$ocTitle = $outTitle ?? '<span class="g">' . ($ocWords[count($ocItems)] ?? 'What') . '</span> you will notice';
$ocLead  = $outLead ?? 'Not a launch moment. The way the work runs once it is yours.';
?>
<section class="band band--ink bd-outcomes" aria-labelledby="outcomes-t" data-bd-live>
  <span class="bd-outcomes__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="bd-outcomes__dots dots-ink"></span>
  </span>
  <div class="wrap">
    <div class="head--row bd-outcomes__head" data-rv>
      <div class="bd-outcomes__hl">
        <p class="lbl"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><?= $ocTitle ?></h2>
      </div>
      <p class="lead"><?= e($ocLead) ?></p>
    </div>
    <ol class="bd-outcomes__grid" data-rv-s data-rv-step="140">
      <?php foreach ($ocItems as $i => $o): ?>
        <li class="bd-outcomes__i" style="--i:<?= $i ?>">
          <span class="bd-outcomes__rule" aria-hidden="true"><i></i></span>
          <span class="bd-outcomes__n num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bd-outcomes__t"><?= e($o[0]) ?></h3>
          <p class="bd-outcomes__d"><?= e($o[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
