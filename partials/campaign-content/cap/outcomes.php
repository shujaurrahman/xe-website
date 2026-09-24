<?php /* DRAFT COPY — review before launch */ ?>
<section class="band ccd-out" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Three things</span> you should notice.</h2></div>
      <div><p class="lead">Outcomes we design for and measure against an agreed baseline. They are aims, not guarantees.</p></div>
    </div>
    <ol class="ccd-out__g">
      <?php foreach ($CAP['outcomes'] as $ccd_i => $ccd_o): ?>
      <li class="ccd-out__i" data-rv>
        <span class="ccd-out__n" aria-hidden="true"><?= sprintf('%02d', $ccd_i + 1) ?></span>
        <h3 class="h3"><?= e($ccd_o[0]) ?></h3>
        <p class="p"><?= e($ccd_o[1]) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
