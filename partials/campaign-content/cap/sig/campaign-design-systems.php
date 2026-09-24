<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — one master layout adapting across formats. Slots (visual, headline, logo, CTA) re-flow per ratio. Illustrative. */
$ccd_fm = [   // [ratio, placement, headline rule, checks]
    ['16:9', 'YouTube · 6 s bumper',  'Headline 1 line · lower third', '12/12'],
    ['4:5',  'Meta · feed',            'Headline 2 lines · bottom', '12/12'],
    ['9:16', 'Reels · Shorts',         'Headline above 250 px safe zone', '11/12 · CTA moved'],
    ['1:1',  'LinkedIn · feed',        'Headline 2 lines · top', '12/12'],
    ['3:1',  'Out of home · 48-sheet', 'Headline ≤ 6 words · readable at 30 m', '12/12'],
];
?>
<div class="ccd-sig bdh-ui ccd-ds" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Master layout · v3', 'Your company', array_column($ccd_fm, 0), 'Choose a format to adapt the master layout to') ?>
  <div class="ccd-sig__body ccd-ds__g" aria-hidden="true">
    <div class="ccd-ds__stage">
      <div class="ccd-ds__art">
        <span class="ccd-ds__v"><img src="<?= e(xe_url('assets/imgs/campaign-content/crowd.jpg')) ?>" alt="" width="800" height="1200" loading="lazy" decoding="async"></span>
        <span class="ccd-ds__hl">Win the first ten minutes.</span>
        <span class="ccd-ds__cta">Start today</span>
        <span class="ccd-ds__logo">Your logo</span>
      </div>
    </div>
    <div class="ccd-ds__rules">
      <?php foreach ($ccd_fm as $ccd_i => $ccd_f): ?>
      <div data-on="<?= $ccd_i + 1 ?>"><p class="bdh-ro"><?= e($ccd_f[0]) ?> · <?= e($ccd_f[1]) ?></p><p class="ccd-ds__r"><?= e($ccd_f[2]) ?></p></div>
      <?php endforeach; ?>
      <ul class="ccd-chk">
        <li class="is-ok">Type from the kit · 2 weights</li>
        <li class="is-ok">Logo safe zone · 6%</li>
        <li class="is-ok">Contrast · 4.5 : 1</li>
        <li class="is-ok">Key visual crop · focal point held</li>
      </ul>
    </div>
  </div>
  <p class="bdh-sr">An illustrative master layout with four slots — key visual, headline, call to action and logo — re-flowing into 16:9, 4:5, 9:16, 1:1 and 3:1 formats under the same rules for type, safe zone and contrast.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_fm as $ccd_i => $ccd_f): ?><span data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_f[0]) ?> · <?= e($ccd_f[1]) ?> · kit check <?= e($ccd_f[3]) ?></span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
