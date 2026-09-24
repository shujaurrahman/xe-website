<?php /* DRAFT COPY — review before launch */
/* How the seven fit: a layered reference architecture. Signals rise from the data layer, decisions come down to
   the channels, and measurement runs alongside every layer. Capability chips link to their cards. */
$mth_ar_names = array_column($DISC['caps'], 0, 2);
$mth_ar_layers = [
    ['05', 'Strategy',               'Who the customer is, which moments matter, what each stage is worth.', ['customer-relationship-strategy'], ['Journey maps', 'Segments', 'Loyalty design']],
    ['04', 'Channels',               'Where a decision becomes a message, an ad or a sales action.',            ['automated-dynamic-sales'], ['Email', 'SMS', 'WhatsApp', 'Push · in-app', 'Paid media', 'Sales desk']],
    ['03', 'Content & creative',     'What is said, assembled from approved facts and components.',            ['content-communication-infrastructure', 'ai-creative-solutions'], ['Headless CMS', 'Asset library', 'Variant engine']],
    ['02', 'Decisioning',            'Journeys, next best action, scoring and budget, each with a fallback.',   ['ai-driven-marketing-automation', 'ai-lead-generation'], ['Journey orchestration', 'Propensity models', 'Lead scoring', 'Approval queue']],
    ['01', 'Data, identity & consent','The ground truth every other layer reads from.',                         [], ['Server-side events', 'Identity resolution', 'Warehouse', 'Consent ledger']],
];
?>
<section class="band band--ink mth-arch" id="architecture" aria-labelledby="architecture-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Reference architecture</p>
        <h2 class="h2" id="architecture-t"><span class="g">Five layers, one direction of travel.</span> Signals up, decisions down.</h2>
      </div>
      <div><p class="lead">Most martech problems are layer problems: a model with no clean events under it, or content that cannot reach the channel that needs it. We build from the bottom layer up and measure all the way through.</p></div>
    </div>

    <div class="mth-arch__fig">
      <ol class="mth-arch__stack">
        <?php foreach ($mth_ar_layers as $mth_ar): ?>
        <li class="mth-arch__layer">
          <p class="mth-arch__k"><span class="bdh-idx">L<?= e($mth_ar[0]) ?></span><?= e($mth_ar[1]) ?></p>
          <p class="mth-arch__d"><?= e($mth_ar[2]) ?></p>
          <div class="mth-arch__parts">
            <?php foreach ($mth_ar[3] as $mth_ar_s): ?>
            <a class="mth-arch__cap" href="<?= e(xe_cap_url($DISC, [2 => $mth_ar_s])) ?>"><?= e($mth_ar_names[$mth_ar_s] ?? '') ?> <span class="i" aria-hidden="true">›</span></a>
            <?php endforeach; ?>
            <?php foreach ($mth_ar[4] as $mth_ar_p): ?><span class="mth-arch__el"><?= e($mth_ar_p) ?></span><?php endforeach; ?>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
      <aside class="mth-arch__rail" aria-label="Measurement across all layers">
        <p class="mth-arch__k"><span class="bdh-idx">∥</span>Measurement</p>
        <p class="mth-arch__d">Runs beside every layer: holdouts on journeys, incrementality tests on media, mix models across the budget.</p>
        <a class="mth-arch__cap" href="<?= e(xe_cap_url($DISC, [2 => 'ai-campaign-optimization'])) ?>"><?= e($mth_ar_names['ai-campaign-optimization']) ?> <span class="i" aria-hidden="true">›</span></a>
        <ul class="mth-arch__ms">
          <li>Holdout groups</li><li>Geo experiments</li><li>Mix modelling</li><li>One conversion definition</li>
        </ul>
      </aside>
    </div>
    <p class="mth-arch__note"><span class="mth-arch__arrow" aria-hidden="true">↑</span> Events and outcomes flow up from L01. <span class="mth-arch__arrow" aria-hidden="true">↓</span> Decisions flow down to L04, checked against consent on the way.</p>
  </div>
</section>
