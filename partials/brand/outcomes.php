<?php /** What changes once it ships. Expects $cap. */ ?>
<section class="band band--ink bd-outcomes" aria-labelledby="outcomes-t" data-bd-live>
  <span class="bd-outcomes__dots dots-ink" aria-hidden="true"></span>
  <span class="bd-outcomes__glow" aria-hidden="true"><i></i><i></i></span>
  <div class="wrap">
    <div class="head--row bd-outcomes__head" data-rv>
      <div>
        <p class="lbl"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Three things</span><br>you will notice</h2>
      </div>
      <p class="lead">Not a launch moment. The way the work runs once it is yours.</p>
    </div>
    <ol class="bd-outcomes__grid" data-rv-s data-rv-step="140">
      <?php foreach ($cap['outcomes'] as $i => $o): ?>
        <li class="bd-outcomes__i">
          <span class="bd-outcomes__rule" aria-hidden="true"><i></i><b></b></span>
          <span class="bd-outcomes__n num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bd-outcomes__t"><?= e($o[0]) ?></h3>
          <p class="bd-outcomes__d"><?= e($o[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
