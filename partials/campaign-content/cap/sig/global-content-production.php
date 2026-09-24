<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — shoot schedule across markets, with rights and usage per market. Bars placed by start/length over 15 days. Illustrative. */
$ccd_mk = [   // [market, start day, days, crew, talent usage, music, location, language]
    ['Mumbai',     1, 3, 'Local producer · DoP · 2 AC', 'Paid + organic social · IN · 12 months', 'Library · worldwide · perpetual', 'Permit granted', 'Hindi · English'],
    ['Dubai',      4, 2, 'Local producer · DoP',        'Paid social · GCC · 12 months',          'Library · worldwide · perpetual', 'Permit granted', 'Arabic · English'],
    ['London',     6, 2, 'Producer · DoP · gaffer',     'All digital · UK · 24 months',           'Library · worldwide · perpetual', 'Permit filed',   'English'],
    ['São Paulo',  9, 3, 'Local producer · DoP · 2 AC', 'Paid social · BR · 12 months',           'Commissioned · buy-out',          'Permit granted', 'Portuguese'],
    ['Singapore', 13, 2, 'Local producer · DoP',        'All digital + OOH · SG · 12 months',     'Library · worldwide · perpetual', 'Permit filed',   'English · Mandarin'],
];
?>
<div class="ccd-sig bdh-ui ccd-gp" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Production wave · 15 days', 'Your company', array_column($ccd_mk, 0), 'Choose a market to see its rights and usage') ?>
  <div class="ccd-sig__body" aria-hidden="true">
    <div class="ccd-gp__sch">
      <p class="ccd-gp__ax bdh-ro"><span>D1</span><span>D5</span><span>D10</span><span>D15</span></p>
      <?php foreach ($ccd_mk as $ccd_i => $ccd_m): ?>
      <div class="ccd-gp__row" data-hl="<?= $ccd_i + 1 ?>"><span class="bdh-ro"><?= e($ccd_m[0]) ?></span><span class="ccd-gp__tr"><i style="left:<?= round(($ccd_m[1] - 1) / 15 * 100, 2) ?>%;width:<?= round($ccd_m[2] / 15 * 100, 2) ?>%"></i></span></div>
      <?php endforeach; ?>
    </div>
    <?php foreach ($ccd_mk as $ccd_i => $ccd_m): ?>
    <dl class="ccd-gp__rt" data-on="<?= $ccd_i + 1 ?>">
      <div><dt>Crew</dt><dd><?= e($ccd_m[3]) ?></dd></div>
      <div><dt>Talent usage</dt><dd><?= e($ccd_m[4]) ?></dd></div>
      <div><dt>Music</dt><dd><?= e($ccd_m[5]) ?></dd></div>
      <div><dt>Location</dt><dd><?= e($ccd_m[6]) ?></dd></div>
      <div><dt>Versions</dt><dd><?= e($ccd_m[7]) ?> · transcreated</dd></div>
    </dl>
    <?php endforeach; ?>
  </div>
  <p class="bdh-sr">An illustrative production schedule across five markets over fifteen days, with each market's crew, talent usage rights, music licence, location permit and language versions recorded in one rights register.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_mk as $ccd_i => $ccd_m): ?><span data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_m[0]) ?> · days <?= $ccd_m[1] ?>–<?= $ccd_m[1] + $ccd_m[2] - 1 ?> · <?= e($ccd_m[4]) ?></span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
