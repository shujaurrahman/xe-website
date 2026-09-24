<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Eight capabilities in four lanes: plan it, make it, earn it, run it. Card = .cch-card (shared component). */
$cch_lanes = [
    ['Plan the idea', 'Who to reach, what to say and the system that keeps it consistent.', ['omnichannel-marketing-strategy', 'campaign-design-systems']],
    ['Make it',       'Original content and production that feeds every channel.',          ['global-content-production', 'content-marketing']],
    ['Earn it',       'Credibility that comes from other people talking about you.',         ['public-relations', 'social-influencer-activation']],
    ['Run it',        'Always-on channels, optimised against the numbers that matter.',      ['social-media-marketing', 'performance-marketing']],
];
$cch_desc = [];
foreach ($DISC['caps'] as $cch_c) $cch_desc[$cch_c[2]] = $cch_c[1];
?>
<section class="band cch-caps" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span><?= count($CAPS) ?> capabilities · four lanes</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Plan it, make it, earn it, run it.</span> One team across all four.</h2></div>
      <div><p class="lead">Each capability can be engaged on its own. Together they cover paid, earned, shared and owned media, so the idea and the numbers stay in one place.</p></div>
    </div>
    <div class="cch-caps__lanes">
      <?php foreach ($cch_lanes as $cch_li => $cch_lane): ?>
      <div class="cch-caps__lane" data-rv>
        <div class="cch-caps__lh">
          <span class="bdh-idx">Lane <?= $cch_li + 1 ?></span>
          <h3 class="cch-caps__lt"><?= e($cch_lane[0]) ?></h3>
          <p class="sm"><?= e($cch_lane[1]) ?></p>
        </div>
        <?php foreach ($cch_lane[2] as $cch_slug): $cch_cap = $CAPS[$cch_slug]; ?>
        <article class="cch-card" id="<?= e($cch_slug) ?>">
          <div class="cch-card__top">
            <span class="bdh-idx"><?= e($cch_cap['n']) ?></span>
            <span class="cch-card__ico"><?= xt_icon($cch_cap['icon']) ?></span>
          </div>
          <p class="cch-card__k"><?= e($cch_cap['kicker']) ?></p>
          <h3 class="cch-card__t"><?= e($cch_cap['name']) ?></h3>
          <p class="cch-card__d"><?= e($cch_desc[$cch_slug] ?? '') ?></p>
          <ul class="cch-card__l">
            <?php foreach (array_slice($cch_cap['offer'], 0, 3) as $cch_o): ?><li><?= e($cch_o[0]) ?></li><?php endforeach; ?>
          </ul>
          <div class="cch-card__f">
            <span class="bdh-ro"><?= e($cch_cap['meta'][0]) ?><!-- PLACEHOLDER: confirm typical set-up time before launch --></span>
            <a class="tl" href="<?= e(xe_url('services/campaign-content.php') . '#' . $cch_slug) ?>" aria-label="Explore <?= e($cch_cap['name']) ?>">Explore <span class="i"></span></a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
