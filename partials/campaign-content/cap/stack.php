<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt ccd-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap ccd-stack__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Tools we work in</p>
      <h2 class="h2" id="stack-t"><span class="g">Your stack first.</span> Ours where it helps.</h2>
      <p class="lead">Technologies we work with on <?= e(strtolower($CAP['name'])) ?>. Named as tools we use, not as partnerships. AI tools run inside an approval step, never around it.</p>
    </div>
    <div class="ccd-stack__t" data-rv><?= xt_stack($CAP['stack'], ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?></div>
  </div>
</section>
