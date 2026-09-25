<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt ccd-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap ccd-stack__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Tools we work in</p>
      <h2 class="h2" id="stack-t"><?= ccd_h('stack', 'Your stack first.', 'Ours where it helps.') ?></h2>
      <p class="lead"><?= ccd_lead('stack', 'Technologies we work with on ' . strtolower($CAP['name']) . '. Named as tools we use, not as partnerships. AI tools run inside an approval step, never around it.') ?></p>
    </div>
    <?php /* Tiles only for slugs with a licence-clean mark; the rest as a word-chip row (no empty glyph boxes). */
    $ccd_mk = array_values(array_filter($CAP['stack'], fn ($ccd_s) => !empty($STACK[$ccd_s]['file'])));
    $ccd_wd = array_values(array_diff($CAP['stack'], $ccd_mk)); ?>
    <div class="ccd-stack__t" data-rv>
      <?= xt_stack($ccd_mk, ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?>
      <?php if ($ccd_wd): ?><div class="ccd-stack__more"><p class="bdh-ro">Also in use</p><?= xt_stack($ccd_wd, ['variant' => 'chips', 'label' => 'More ' . $CAP['name'] . ' technologies']) ?></div><?php endif; ?>
    </div>
  </div>
</section>
