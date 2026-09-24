<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Onward aid: the two capabilities this one pairs with, then every other sibling and the hub. */
$ccd_rows = [];
foreach ($DISC['caps'] as $ccd_r) $ccd_rows[$ccd_r[2]] = $ccd_r;
$ccd_rest = array_values(array_filter(array_keys($CAPS), fn ($ccd_k) => $ccd_k !== $CCD_KEY && !in_array($ccd_k, $CAP['pairs'], true)));
?>
<section class="band band--ink ccd-on" id="next" aria-labelledby="next-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl"><span class="dot"></span>Works best with</p>
        <h2 class="h2" id="next-t"><?= ccd_h('on', 'One idea,', 'carried further.') ?></h2></div>
      <div><p class="lead">Each capability stands on its own. These two are the ones <?= e(strtolower($CAP['short'])) ?> most often runs alongside.</p></div>
    </div>
    <div class="ccd-on__pair">
      <?php foreach ($CAP['pairs'] as $ccd_k): $ccd_p = $CAPS[$ccd_k] ?? null; if (!$ccd_p) continue; ?>
      <a class="ccd-on__card" href="<?= e(xe_cap_url($DISC, $ccd_rows[$ccd_k])) ?>" data-rv>
        <?php if ($ccd_im = ccd_img($ccd_k)): ?><span class="ccd-on__img" aria-hidden="true"><img src="<?= e(xe_url('assets/imgs/campaign-content/' . $ccd_im[0])) ?>" alt="" width="<?= (int) $ccd_im[1] ?>" height="<?= (int) $ccd_im[2] ?>" loading="lazy" decoding="async" style="object-position:<?= e($ccd_im[4]) ?>"></span><?php endif; ?>
        <span class="ccd-on__top"><span class="bdh-ro">Capability <?= e($ccd_p['n']) ?></span><span class="ccd-on__ico" aria-hidden="true"><?= xt_icon($ccd_p['icon']) ?></span></span>
        <span class="ccd-on__k"><?= e($ccd_p['kicker']) ?></span>
        <span class="ccd-on__t"><?= e($ccd_p['name']) ?></span>
        <span class="ccd-on__d"><?= e($ccd_rows[$ccd_k][1]) ?></span>
        <span class="ccd-on__go">Explore <span class="i"></span></span>
      </a>
      <?php endforeach; ?>
    </div>
    <nav class="ccd-on__all" aria-label="Other <?= e($DISC['name']) ?> capabilities">
      <p class="bdh-ro">Also in <?= e($DISC['name']) ?></p>
      <ul>
        <?php foreach ($ccd_rest as $ccd_k): ?>
        <li><a href="<?= e(xe_cap_url($DISC, $ccd_rows[$ccd_k])) ?>"><span class="bdh-ro"><?= e($CAPS[$ccd_k]['n']) ?></span> <?= e($CAPS[$ccd_k]['name']) ?></a></li>
        <?php endforeach; ?>
        <li><a class="ccd-on__hub" href="<?= e(xe_discipline_url($DISC)) ?>">All of <?= e($DISC['name']) ?> <span class="i"></span></a></li>
      </ul>
    </nav>
  </div>
</section>
