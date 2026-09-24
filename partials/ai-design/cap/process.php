<?php /* DRAFT COPY — review before launch */
/* Process — the hub's stepper (.aih-steps, filled on scroll by assets/js/ai-design/process.js), per-capability steps. */
$aid_steps = $CAP['process']['steps'];
?>
<section class="band aid-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?></h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm typical timeframes before launch -->
        <p class="lead"><?= e($CAP['process']['lead']) ?> Timings are typical, set per engagement.</p>
      </div>
    </div>
    <div class="aih-stepper" data-aih-steps>
      <span class="aih-steps__bar" aria-hidden="true"></span>
      <ol class="aih-steps" style="--n:<?= count($aid_steps) ?>">
        <?php foreach ($aid_steps as $aid_i => $aid_s): ?>
          <li class="aih-step">
            <span class="aih-step__i" aria-hidden="true"><?= str_pad((string) ($aid_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="aih-step__time"><?= e($aid_s[1]) ?></span>
            <h3 class="aih-step__t"><?= e($aid_s[0]) ?></h3>
            <p class="aih-step__d"><?= e($aid_s[2]) ?></p>
            <ul class="aih-step__out" aria-label="Outputs">
              <?php foreach ($aid_s[3] as $aid_o): ?><li><?= e($aid_o) ?></li><?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
