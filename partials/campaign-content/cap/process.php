<?php /* DRAFT COPY — review before launch */ ?>
<?php $ccd_steps = $CAP['process']['steps']; ?>
<section class="band ccd-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How it runs · <?= count($ccd_steps) ?> stages</p>
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?></h2></div>
      <div><!-- PLACEHOLDER: confirm typical timeline before launch --><p class="lead"><?= e($CAP['process']['lead']) ?></p></div>
    </div>
    <ol class="cch-steps ccd-steps" style="--ccd-sn:<?= count($ccd_steps) ?>">
      <?php foreach ($ccd_steps as $ccd_i => $ccd_s): ?>
      <li class="cch-steps__i" data-rv>
        <span class="cch-steps__n"><?= sprintf('%02d', $ccd_i + 1) ?></span>
        <p class="cch-steps__w bdh-ro"><?= e($ccd_s[1]) ?></p>
        <h3 class="h3 cch-steps__t"><?= e($ccd_s[0]) ?></h3>
        <p class="sm cch-steps__d"><?= e($ccd_s[2]) ?></p>
        <ul class="cch-steps__o"><?php foreach ($ccd_s[3] as $ccd_o): ?><li><?= e($ccd_o) ?></li><?php endforeach; ?></ul>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
