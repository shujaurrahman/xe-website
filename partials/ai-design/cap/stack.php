<?php /* DRAFT COPY — review before launch */
/* Stack — technologies we work with for this capability (xt_stack tiles). No partnership is implied. */
?>
<section class="band aid-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Technologies we work with</p>
        <h2 class="h2" id="stack-t"><?= aid_h('stack', 'Chosen per task,', 'never locked in.') ?></h2>
      </div>
      <div><p class="lead"><?= aid_lead('stack', 'The tools most used on ' . $CAP['name'] . ' work, most relevant first. Each is picked on your evaluation set; prompts, evaluation sets and configuration stay yours when a tool changes.') ?></p></div>
    </div>
    <?php /* Tiles only for slugs with a licence-clean mark; word-only names as chips beneath (no empty glyph boxes). */
      $aid_mk = array_values(array_filter($CAP['stack'], fn ($aid_s) => !empty($STACK[$aid_s]['file'])));
      $aid_wd = array_values(array_diff($CAP['stack'], $aid_mk)); ?>
    <?= xt_stack($aid_mk, ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?>
    <?php if ($aid_wd): ?><div class="aid-stack__more"><p class="aid-stack__k">Also in use</p><?= xt_stack($aid_wd, ['variant' => 'chips', 'label' => 'More ' . $CAP['name'] . ' technologies']) ?></div><?php endif; ?>
  </div>
</section>
