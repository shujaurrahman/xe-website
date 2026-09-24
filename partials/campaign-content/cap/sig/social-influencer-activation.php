<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — creator shortlist with fit, audience overlap and disclosure checks. Rows are the real controls. Illustrative. */
$ccd_cr = [   // [handle, niche, tier, fit, overlap brand, overlap shortlist, disclosure, safety, verdict]
    ['@creator.one',   'Personal finance', 'Mid · 180k',  86, '12%', '9%',  ['Clear #ad in line one', 1],  ['Pass', 1], 'Shortlist'],
    ['@creator.two',   'Small business',   'Micro · 42k', 78, '6%',  '14%', ['Paid-partnership tag used', 1], ['Pass', 1], 'Shortlist'],
    ['@creator.three', 'Tech reviews',     'Macro · 1.2M', 71, '31%', '22%', ['Clear labels', 1], ['Pass', 1], 'Reserve · high overlap'],
    ['@creator.four',  'Lifestyle',        'Mid · 260k',  64, '4%',  '5%',  ['Missed labels ×2 in 90 days', 0], ['Review', 0], 'Hold'],
];
?>
<div class="ccd-sig bdh-ui ccd-in" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Creator shortlist · 4 of 38', 'Your company', [], '') ?>
  <div class="ccd-sig__body ccd-in__g">
    <div class="ccd-in__list" role="group" aria-label="Choose a creator to see their checks">
      <?php foreach ($ccd_cr as $ccd_i => $ccd_c): ?>
      <button type="button" class="ccd-in__row" data-ccd-set="<?= $ccd_i + 1 ?>" aria-pressed="<?= $ccd_i ? 'false' : 'true' ?>">
        <span class="ccd-in__av" aria-hidden="true"><?= $ccd_i + 1 ?></span>
        <span class="ccd-in__who"><strong><?= e($ccd_c[0]) ?></strong><span class="bdh-ro"><?= e($ccd_c[1]) ?> · <?= e($ccd_c[2]) ?></span></span>
        <span class="ccd-in__fit"><span class="bdh-ro">Fit <?= (int) $ccd_c[3] ?></span><span class="ccd-bar" aria-hidden="true"><i style="width:<?= (int) $ccd_c[3] ?>%"></i></span></span>
      </button>
      <?php endforeach; ?>
    </div>
    <div class="ccd-in__det" aria-hidden="true">
      <?php foreach ($ccd_cr as $ccd_i => $ccd_c): ?>
      <div data-on="<?= $ccd_i + 1 ?>">
        <p class="bdh-ro ccd-in__h"><?= e($ccd_c[0]) ?> · checks</p>
        <dl class="ccd-in__dl">
          <div><dt>Audience overlap · your followers</dt><dd><?= e($ccd_c[4]) ?></dd></div>
          <div><dt>Overlap · rest of shortlist</dt><dd><?= e($ccd_c[5]) ?></dd></div>
        </dl>
        <ul class="ccd-chk">
          <li class="<?= $ccd_c[6][1] ? 'is-ok' : 'is-no' ?>">Disclosure · <?= e($ccd_c[6][0]) ?></li>
          <li class="<?= $ccd_c[7][1] ? 'is-ok' : 'is-no' ?>">Brand safety · <?= e($ccd_c[7][0]) ?></li>
          <li class="is-ok">Usage rights · 90 days paid</li>
        </ul>
        <p class="ccd-tag<?= $ccd_c[6][1] ? '' : ' ccd-tag--hold' ?>"><?= e($ccd_c[8]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <p class="bdh-sr">For each creator the panel shows audience overlap with your followers and with the rest of the shortlist, a disclosure history check, a brand-safety review and the usage rights, ending in shortlist, reserve or hold.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_cr as $ccd_i => $ccd_c): ?><span data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_c[0]) ?> · fit <?= (int) $ccd_c[3] ?> · <?= e($ccd_c[8]) ?></span><?php endforeach; ?> <em>Illustrative handles</em></p>
</div>
