<?php /* DRAFT COPY — review before launch */
/* 11 Outcomes — each $CAT outcome rendered as a job report: job name, exit code, stdout,
   one illustrative figure and a completion bar. Figures count up on entry (BDH.count). */
// PLACEHOLDER: illustrative job figures — confirm before launch
$cat_jobs = [   // aligned to $CAT['outcomes']: [job id, stdout lines, figure, figure label, fill 0–1]
    ['on-brand-by-default', ['generation starts from tuned model v4.2', 'brand check runs on every output', 'flagged work fixed or returned with a reason'], '96%', 'pass the check first time', .96],
    ['volume-without-drift', ['1 approved source in', '6 formats × 9 markets out', 'people review the judgement calls only'], '54', 'renditions per approved source', 1],
    ['yours-all-of-it', ['weights, datasets, prompts, logs → your accounts', 'copies retained by us: 0', 'trained on elsewhere: never'], '0', 'copies kept by us', 1],
];
?>
<section class="band cat-room cat-rp" id="reports" aria-labelledby="reports-t">
  <span class="cat-room__grid" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl report --outcomes</b> <span>what changes once it runs</span></p>
        <h2 class="h2" id="reports-t"><span class="g">Three jobs that keep running</span> after we hand over.</h2>
      </div>
      <p class="lead">The programme ends; the outcomes do not. Each one is a job that runs every day inside your tools, and each one reports back.</p>
    </div>

    <ul class="cat-rp__grid" data-rv-s>
      <?php foreach ($CAT['outcomes'] as $cat_oi => $cat_o): $cat_j = $cat_jobs[$cat_oi]; ?>
        <li class="cat-rp__job" data-rv style="--i:<?= $cat_oi ?>">
          <p class="cat-rp__top"><span class="cat-led cat-led--pulse"></span><span class="cat-rp__id">job/<?= e($cat_j[0]) ?></span><span class="cat-rp__exit">exit 0</span></p>
          <h3 class="cat-rp__h"><?= e($cat_o[0]) ?></h3>
          <p class="cat-rp__p"><?= e($cat_o[1]) ?></p>
          <ol class="cat-rp__out" aria-label="Job output">
            <?php foreach ($cat_j[1] as $cat_ln): ?><li><?= e($cat_ln) ?></li><?php endforeach; ?>
          </ol>
          <div class="cat-rp__fig">
            <p><b data-bdh-count><?= e($cat_j[2]) ?></b><span><?= e($cat_j[3]) ?></span></p>
            <span class="cat-rp__bar" aria-hidden="true"><i style="--v:<?= $cat_j[4] ?>"></i></span>
          </div>
          <p class="cat-rp__foot"><span>owner · Your brand</span><span>schedule · continuous</span><span class="cat-illus">Illustrative</span></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
