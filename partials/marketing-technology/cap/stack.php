<?php /* DRAFT COPY — review before launch */ ?>
<section class="band mtd-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap mtd-stack__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Technologies we work with</p>
      <h2 class="h2" id="stack-t"><span class="g">Your platforms first.</span> Ours where they help.</h2>
      <p class="lead">Tools we use on <?= e(strtolower($CAP['name'])) ?>, named as technologies we work with, not partnerships. Model providers run inside an approval step, never around it.</p>
    </div>
    <div class="mtd-stack__t" data-rv><?= xt_stack($CAP['stack'], ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?></div>
  </div>
</section>
