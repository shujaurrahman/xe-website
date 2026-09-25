<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — platform-native post composer. One idea rebuilt per platform: frame, hook, length, checks. Illustrative. */
$ccd_pf = [   // [platform, ratio label, hook, count, limit, tags, slot, pillar]
    ['LinkedIn',  '1:1 · 1080²',   'Most billing migrations fail in week three. Here is what we check on day one.', '214', '3,000', '#finance #saas', 'Tue 08:30', 'Point of view'],
    ['Instagram', '4:5 · 1080×1350', 'Three numbers we watch before any pricing change. Swipe for the sheet.', '138', '2,200', '#behindthework', 'Thu 18:00', 'Behind the work'],
    ['TikTok',    '9:16 · 1080×1920', 'POV: the invoice finally matches the usage.', '46', '4,000', '#fintok', 'Sat 11:00', 'Culture'],
];
?>
<div class="ccd-sig bdh-ui ccd-sm" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Composer · one idea', 'Your company', array_column($ccd_pf, 0), 'Choose a platform to rebuild the post for') ?>
  <div class="ccd-sig__body ccd-sm__g" aria-hidden="true">
    <div class="ccd-sm__stage">
      <figure class="cch-frame ccd-sm__f">
        <img src="<?= e(xe_url('assets/imgs/campaign-content/social-b.jpg')) ?>" alt="" width="1200" height="800" loading="lazy" decoding="async">
        <?php foreach ($ccd_pf as $ccd_i => $ccd_p): ?><span class="cch-frame__tag" data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_p[1]) ?></span><?php endforeach; ?>
        <span class="ccd-sm__safe"></span>
      </figure>
    </div>
    <div class="ccd-sm__ed">
      <p class="bdh-ro">Hook · first line</p>
      <?php foreach ($ccd_pf as $ccd_i => $ccd_p): ?>
      <div data-on="<?= $ccd_i + 1 ?>">
        <p class="ccd-sm__txt"><?= e($ccd_p[2]) ?><span class="bdh-caret"></span></p>
        <p class="ccd-sm__meta bdh-ro"><span><?= e($ccd_p[3]) ?> / <?= e($ccd_p[4]) ?></span><span><?= e($ccd_p[5]) ?></span></p>
        <p class="ccd-sm__meta bdh-ro"><span>Pillar · <?= e($ccd_p[7]) ?></span><span>Slot · <?= e($ccd_p[6]) ?></span></p>
      </div>
      <?php endforeach; ?>
      <ul class="ccd-chk">
        <li class="is-ok">Captions burned in</li>
        <li class="is-ok">Alt text written</li>
        <li class="is-ok">Safe zone clear</li>
        <li class="is-ok">Editor approved</li>
      </ul>
    </div>
  </div>
  <p class="bdh-sr">An illustrative post composer: one idea rebuilt for LinkedIn, Instagram and TikTok, each with its own frame ratio, first-line hook, caption length, publishing slot and accessibility checks.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_pf as $ccd_i => $ccd_p): ?><span data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_p[0]) ?> · <?= e($ccd_p[1]) ?> · scheduled <?= e($ccd_p[6]) ?> · 4 of 4 checks passed</span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
