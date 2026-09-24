<?php /* DRAFT COPY — review before launch */
/* Outcomes — the three changes from data/ai-design.php, each with its measure drawn in the hub's bar idiom
   (.aih-oc + .aih-bars). PLACEHOLDER: baselines and targets are illustrative typical ranges — confirm before launch. */
?>
<section class="band band--ink aid-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Three changes,</span> each with a number attached.</h2>
      </div>
      <div><p class="lead">Measures are agreed in the first week and baselined before anything is designed. The ranges below are typical targets, not promises; yours are set per engagement.</p></div>
    </div>
    <div class="aih-oc">
      <?php foreach ($CAP['outcomes'] as $aid_i => $aid_o): $aid_m = $AID_X['m'][$aid_i]; ?>
        <article class="aih-oc__i">
          <p class="aih-oc__n"><?= str_pad((string) ($aid_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="aih-oc__t"><?= e($aid_o[0]) ?></h3>
          <p class="aih-oc__d"><?= e($aid_o[1]) ?></p>
          <!-- PLACEHOLDER: confirm illustrative baseline and target before launch -->
          <p class="aid-oc__k"><?= e($aid_m[0]) ?></p>
          <ul class="aih-bars" data-aih-bars aria-label="<?= e($aid_m[0]) ?>: typical baseline <?= e($aid_m[4]) ?>, typical target <?= e($aid_m[5]) ?>">
            <li class="aih-bar" style="--i:0"><span class="aih-bar__l">Before</span><span class="aih-bar__track" aria-hidden="true"><span class="aih-bar__fill" style="--v:<?= e((string) $aid_m[2]) ?>"></span></span><span class="aih-bar__v"><?= e($aid_m[4]) ?></span></li>
            <li class="aih-bar aih-bar--pass" style="--i:1"><span class="aih-bar__l">Target</span><span class="aih-bar__track" aria-hidden="true"><span class="aih-bar__fill" style="--v:<?= e((string) $aid_m[3]) ?>"></span></span><span class="aih-bar__v"><?= e($aid_m[5]) ?></span></li>
          </ul>
          <p class="aih-oc__m"><span>Measured by</span> <?= e($aid_m[1]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
