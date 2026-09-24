<?php /* DRAFT COPY — review before launch */ ?>
<?php $mtd_ht = $mtd_head('std', ['Consent and oversight,', 'designed in from the brief.', 'Standards this work is designed and documented against. They are frameworks we build to, not certifications we hold.']); ?>
<section class="band band--alt mtd-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g"><?= e($mtd_ht[0]) ?></span> <?= e($mtd_ht[1]) ?></h2></div>
      <div><p class="lead"><?= e($mtd_ht[2]) ?></p></div>
    </div>
    <ul class="mtd-std__g">
      <?php foreach ($CAP['standards'] as $mtd_k): $mtd_s = xt_standard($mtd_k); if (!$mtd_s) continue; ?>
      <li class="mtd-std__i" data-rv>
        <?= xt_badge($mtd_k, ['variant' => 'chip']) ?>
        <h3 class="bdh-t"><?= e($mtd_s['name']) ?></h3>
        <p class="bdh-d"><?= e($MTD_HS['_apply'][$mtd_k] ?? $mtd_s['apply'] ?? $mtd_s['covers'] ?? '') ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
