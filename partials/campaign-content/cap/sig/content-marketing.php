<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature — topic cluster map with briefs. One pillar, three clusters; choosing a cluster opens its brief. Illustrative data. */
$ccd_cl = [   // [cluster, pages, searches/mo, brief question, angle, expert, measure, status]
    ['Pricing models',  ['Usage vs seat pricing', 'Pricing a free tier', 'Metering, explained'], '2.4k', 'How do we move customers to usage pricing without a revenue dip?', 'A migration plan finance can sign off, with the maths shown', 'Head of Revenue · 45-min interview', 'Demo requests from cluster pages', 'Brief approved'],
    ['Migration',       ['Parallel billing runs', 'Contract re-papering', 'Customer comms kit'], '1.1k', 'What breaks when billing changes mid-contract?', 'The five failure points, from support tickets', 'Billing Ops lead · ticket review', 'Assisted conversions · time on guide', 'Draft · editor review'],
    ['Revenue ops',     ['Forecasting usage', 'Board reporting', 'Dunning that keeps customers'], '1.8k', 'How do you forecast revenue you cannot see yet?', 'A worked model with a downloadable sheet', 'CFO · written answers', 'Sheet downloads → sales meetings', 'Research'],
];
?>
<div class="ccd-sig bdh-ui ccd-cm" data-ccd-sig data-state="1">
  <?= ccd_sig_head('Topic map · Q3', 'Your company', array_column($ccd_cl, 0), 'Choose a cluster to open its brief') ?>
  <div class="ccd-sig__body" aria-hidden="true">
    <div class="ccd-cm__map">
      <div class="ccd-cm__pillar"><span class="bdh-ro">Pillar</span><strong>Usage-based billing, explained</strong></div>
      <ul class="ccd-cm__cls">
        <?php foreach ($ccd_cl as $ccd_i => $ccd_c): ?>
        <li class="ccd-cm__cl" data-hl="<?= $ccd_i + 1 ?>">
          <span class="bdh-ro">C<?= $ccd_i + 1 ?> · <?= e($ccd_c[2]) ?>/mo</span>
          <strong><?= e($ccd_c[0]) ?></strong>
          <?php foreach ($ccd_c[1] as $ccd_p): ?><span class="ccd-cm__pg"><?= e($ccd_p) ?></span><?php endforeach; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php foreach ($ccd_cl as $ccd_i => $ccd_c): ?>
    <dl class="ccd-cm__brief" data-on="<?= $ccd_i + 1 ?>">
      <div class="ccd-cm__bh"><span class="bdh-ro">Brief · <?= e($ccd_c[1][0]) ?></span><span class="ccd-tag"><?= e($ccd_c[7]) ?></span></div>
      <div><dt>Question</dt><dd><?= e($ccd_c[3]) ?></dd></div>
      <div><dt>Angle</dt><dd><?= e($ccd_c[4]) ?></dd></div>
      <div><dt>Expert</dt><dd><?= e($ccd_c[5]) ?></dd></div>
      <div><dt>Measure</dt><dd><?= e($ccd_c[6]) ?></dd></div>
    </dl>
    <?php endforeach; ?>
  </div>
  <p class="bdh-sr">An illustrative topic map: one pillar page linked to three clusters of three pages each, with a brief per piece naming its question, angle, expert and measure.</p>
  <p class="ccd-sig__ro" aria-live="off"><?php foreach ($ccd_cl as $ccd_i => $ccd_c): ?><span data-on="<?= $ccd_i + 1 ?>"><?= e($ccd_c[0]) ?> · 3 pages · <?= e($ccd_c[2]) ?> monthly searches · <?= e($ccd_c[7]) ?></span><?php endforeach; ?> <em>Illustrative</em></p>
</div>
