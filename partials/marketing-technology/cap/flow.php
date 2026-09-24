<?php /* DRAFT COPY — review before launch */ ?>
<?php $mtd_hf = $mtd_head('flow', ['Five steps,', 'every time it runs.', $MTD_CRS ? 'The five practices in the order a customer meets them. Each one hands the next a sharper definition of who the customer is and what they need.' : 'The path a single decision takes through ' . strtolower($CAP['short']) . ', from the signal that starts it to the measure that proves it. The highlighted step is where this capability does its own work.']); ?>
<?php /* Where it sits: the hub's diagram idiom (.mth-flow), five nodes from topics.php with this capability's own step highlighted. */ ?>
<section class="band mtd-flow" id="how" aria-labelledby="how-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Where it sits in the engine</p>
        <h2 class="h2" id="how-t"><span class="g"><?= e($mtd_hf[0]) ?></span> <?= e($mtd_hf[1]) ?></h2></div>
      <div><p class="lead"><?= e($mtd_hf[2]) ?></p></div>
    </div>
    <ol class="mth-flow mtd-flow__f" data-rv>
      <?php foreach ($MTD_X['flow'] as $mtd_i => $mtd_n): ?>
      <li class="mth-node<?= $mtd_i === $MTD_X['hot'] ? ' is-hot' : '' ?>">
        <span class="mth-node__k"><?= xt_icon($mtd_n[3]) ?><?= sprintf('%02d', $mtd_i + 1) ?> · <?= e($mtd_n[0]) ?></span>
        <span class="mth-node__t"><?= e($mtd_n[1]) ?></span>
        <span class="mth-node__d"><?= e($mtd_n[2]) ?></span>
        <?php if ($mtd_i === $MTD_X['hot']): ?><span class="mth-chip mth-chip--ok mtd-flow__me"><?= e($CAP['short']) ?></span><?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
