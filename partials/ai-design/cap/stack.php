<?php /* DRAFT COPY — review before launch */
/* Stack — technologies we work with for this capability (xt_stack tiles). No partnership is implied. */
?>
<section class="band aid-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Technologies we work with</p>
        <h2 class="h2" id="stack-t"><span class="g">Chosen per task,</span> never locked in.</h2>
      </div>
      <div><p class="lead">The tools most used on <?= e($CAP['name']) ?> work, most relevant first. Each is picked on your evaluation set; prompts, evaluation sets and configuration stay yours when a tool changes.</p></div>
    </div>
    <?= xt_stack($CAP['stack'], ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?>
  </div>
</section>
