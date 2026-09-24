<?php /* DRAFT COPY — review before launch */ ?>
<section class="band ccd-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">The rules,</span> designed in from the brief.</h2></div>
      <div><p class="lead">Standards this work is designed and checked against. They are frameworks we build to, not certifications we hold.</p></div>
    </div>
    <ul class="ccd-std__g">
      <?php foreach ($CAP['standards'] as $ccd_k): $ccd_s = xt_standard($ccd_k); if (!$ccd_s) continue; ?>
      <li class="ccd-std__i" data-rv>
        <?= xt_badge($ccd_k, ['variant' => 'chip']) ?>
        <h3 class="ccd-std__t"><?= e($ccd_s['name']) ?></h3>
        <p class="sm"><?= e($ccd_s['apply'] ?? $ccd_s['covers'] ?? '') ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
