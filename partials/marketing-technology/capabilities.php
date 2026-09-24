<?php /* DRAFT COPY — review before launch */
/* The seven capabilities as module cards (.mth-mod). Each card's id is the capability slug, so the hub's own
   anchors stand in for the capability pages until they exist. Customer Relationship Strategy is one capability:
   its card is the wide one, listing its five practices as one loop. */
$mth_cp_url  = xe_url('services/marketing-technology.php');
$mth_cp_desc = array_column($DISC['caps'], 1, 2);
?>
<section class="band band--alt mth-caps" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span><?= count($CAPS) ?> capabilities</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Seven modules.</span> One engine underneath.</h2>
      </div>
      <div><p class="lead">Each one is scoped and delivered on its own, and each one plugs into the same data, consent and measurement layer, so the second module costs less than the first.</p></div>
    </div>

    <div class="mth-caps__grid">
      <?php foreach ($CAPS as $mth_cp_slug => $mth_cp):
        $mth_cp_wide = $mth_cp_slug === 'customer-relationship-strategy'; ?>
      <article class="mth-mod<?= $mth_cp_wide ? ' mth-mod--wide' : '' ?>" id="<?= e($mth_cp_slug) ?>" aria-labelledby="<?= e($mth_cp_slug) ?>-t">
        <div class="mth-mod__bar">
          <span class="bdh-idx"><?= e($mth_cp['n']) ?></span><?= xt_icon($mth_cp['icon']) ?><span><?= e($mth_cp['kicker']) ?></span>
        </div>
        <figure class="mth-mod__img">
          <img src="<?= e(xe_url('assets/imgs/marketing-technology/' . $mth_cp_slug . '.jpg')) ?>" width="1200" height="800" loading="lazy" decoding="async"
               alt="<?= e($mth_cp['img']['alt']) ?>" style="object-position:<?= e($mth_cp['img']['pos']) ?>">
        </figure>
        <div class="mth-mod__main">
          <div class="mth-mod__body">
            <h3 class="bdh-t bdh-t--l" id="<?= e($mth_cp_slug) ?>-t"><?= e($mth_cp['name']) ?></h3>
            <p class="bdh-d"><?= e($mth_cp_desc[$mth_cp_slug] ?? '') ?></p>
            <?php if ($mth_cp_wide): ?>
            <p class="mth-caps__one">One practice, five parts, sold and measured together.</p>
            <ol class="mth-caps__loop">
              <?php foreach (array_slice($mth_cp['offer'], 0, 5) as $mth_cp_i => $mth_cp_o): ?>
              <li><span class="mth-caps__ln"><?= sprintf('%02d', $mth_cp_i + 1) ?></span><?= xt_icon($mth_cp_o[3]) ?><span class="mth-caps__lt"><?= e($mth_cp_o[0]) ?></span><span class="mth-caps__ld"><?= e($mth_cp_o[2]) ?></span></li>
              <?php endforeach; ?>
            </ol>
            <?php else: ?>
            <ul class="mth-caps__runs" aria-label="What it runs">
              <?php foreach (array_slice($mth_cp['offer'], 0, 3) as $mth_cp_o): ?>
              <li><?= xt_icon($mth_cp_o[3]) ?><span><?= e($mth_cp_o[0]) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <div class="mth-mod__foot">
            <p class="mth-caps__meta"><span><?= e($mth_cp['meta_k'][0]) ?></span><!-- PLACEHOLDER: confirm timeframe before launch --><?= e($mth_cp['meta'][0]) ?></p>
            <a class="tl" href="<?= e($mth_cp_url) ?>#<?= e($mth_cp_slug) ?>" aria-label="<?= e($mth_cp['name']) ?>: <?= e($mth_cp['short']) ?> in detail">Explore <?= e($mth_cp['short']) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
