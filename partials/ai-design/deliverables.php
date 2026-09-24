<?php /* DRAFT COPY — review before launch */
/* Deliverables — what is handed over, per capability (.aih-card--flat + .aih-list, from data/ai-design.php). */
?>
<section class="band aih-deliverables" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What you keep</p>
        <h2 class="h2" id="deliverables-t"><span class="g">Everything we make,</span> you own and can run without us.</h2>
      </div>
      <div><p class="lead">Prompts, evaluation sets, model weights, guardrail configuration and the approval record live in your repositories and accounts from the first week.</p></div>
    </div>
    <div class="aih-cards aih-dl">
      <?php foreach ($CAPS as $aih_slug => $aih_c): ?>
        <div class="aih-card aih-card--flat">
          <div class="aih-card__body">
            <p class="aih-card__idx"><?= e($aih_c['n']) ?> · <?= e($aih_c['short']) ?></p>
            <h3 class="aih-card__t"><?= e($aih_c['name']) ?></h3>
            <ul class="aih-list" aria-label="<?= e($aih_c['name']) ?> deliverables">
              <?php foreach ($aih_c['deliver'] as $aih_dv): ?>
                <li><span><?= e($aih_dv[0]) ?></span><span><?= e($aih_dv[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
