<?php /* DRAFT COPY — review before launch */
/* CRS — the one rule this discipline must not get wrong: Customer Relationship Strategy is ONE capability.
   Journey mapping, segmentation and insight, engagement programmes, loyalty and lifecycle marketing are its
   five parts, and customer value measurement is the hub that keeps them in step. The wheel makes that
   structure visible: five parts on the rim, the measurement in the middle, spokes trimmed to both edges.
   The rim nodes and the hub are the tab controls (BDH.tabs: click, arrow keys, Home and End). Every pane is
   in the markup with the first on, so the section is complete with JavaScript off.
   Copy is the approved content for capability 07 in data/marketing-technology.php. */
$crs = $CAPS['customer-relationship-strategy'];
$crs_parts = [];
/* the five parts, then the hub — the order of $crs['offer'] */
$crs_extra = [
    0 => [['Customer journey maps by segment', 'Prioritised fix and opportunity list'], 'Drop-off at each mapped moment, before and after the fix.'],
    1 => [['Segmentation model & definitions', 'Propensity, churn and lifetime value models'], 'Whether the new segments predict behaviour better than the ones they replaced.'],
    2 => [['Engagement programme designs', 'Contact strategy and pressure rules'], 'Incremental effect against a holdout, and contact quality per segment.'],
    3 => [['Loyalty design with earn, redeem and tiers', 'Economic model with margin, breakage and liability'], 'Member margin against non-members, with breakage and liability modelled before launch.'],
    4 => [['Lifecycle calendar with triggers and owners', 'Holdout group per stage'], 'Retention by cohort and lifetime value against a pre-programme baseline.'],
    5 => [['Retention and lifetime value dashboard', 'Quarterly operating rhythm'], 'One definition of lifetime value, retention and churn that finance and marketing both sign.'],
];
foreach ($crs['offer'] as $crs_i => $crs_o) {
    $crs_parts[] = [
        'key'   => 'p' . ($crs_i + 1),
        'n'     => $crs_i < 5 ? str_pad((string) ($crs_i + 1), 2, '0', STR_PAD_LEFT) : 'HUB',
        'title' => $crs_o[0],
        'desc'  => $crs_o[1],
        'tag'   => $crs_o[2],
        'icon'  => $crs_o[3],
        'out'   => $crs_extra[$crs_i][0],
        'meas'  => $crs_extra[$crs_i][1],
        'hub'   => $crs_i === 5,
    ];
}
/* the wheel: five parts on a 215-unit rim of a 560 × 560 stage, the hub in the middle at r 84 */
$crs_c = 280; $crs_r = 205; $crs_hub = 84; $crs_nw = 150; $crs_nh = 62;
$crs_pos = []; $crs_spokes = '';
for ($crs_i = 0; $crs_i < 5; $crs_i++) {
    $crs_a  = deg2rad(-90 + $crs_i * 72);
    $crs_nx = $crs_c + $crs_r * cos($crs_a);
    $crs_ny = $crs_c + $crs_r * sin($crs_a);
    $crs_pos[$crs_i] = [round($crs_nx / 5.6, 3), round($crs_ny / 5.6, 3)];
    $crs_p1 = [$crs_c + ($crs_hub + 8) * cos($crs_a), $crs_c + ($crs_hub + 8) * sin($crs_a)];
    $crs_p2 = mth_ray(mth_box($crs_nx, $crs_ny, $crs_nw, $crs_nh), $crs_c, $crs_c, 8);
    $crs_spokes .= sprintf('M%.1f %.1fL%.1f %.1f', $crs_p1[0], $crs_p1[1], $crs_p2[0], $crs_p2[1]);
}
$crs_faq = null;
foreach ($crs['faq'] as $crs_q) { if (strpos($crs_q[0], 'one service or five') !== false) $crs_faq = $crs_q; }
$crs_cta = svc_contact_url(
    ['marketing-technology:journey-mapping', 'marketing-technology:segmentation'],
    null,
    'marketing-technology'
);
?>
<section class="band band--ink mth-crs" id="crs" aria-labelledby="crs-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Capability 07 · one practice, five parts</p>
        <h2 class="h2" id="crs-t"><?= $crs['title'] ?></h2>
      </div>
      <div>
        <p class="lead"><?= e($crs['lead']) ?></p>
      </div>
    </div>

    <?php if ($crs_faq): ?>
      <blockquote class="mth-crs__note" data-rv data-rv-d="40">
        <p class="mth-k">Asked more than any other question</p>
        <p class="mth-crs__q"><?= e($crs_faq[0]) ?></p>
        <p class="mth-crs__a"><?= e($crs_faq[1]) ?></p>
      </blockquote>
    <?php endif; ?>

    <div class="mth-crs__body" data-rv data-rv-d="70">
      <div class="mth-crs__panes bdh-panes">
        <?php foreach ($crs_parts as $crs_i => $crs_p): $crs_on = $crs_i === 0; ?>
          <div class="bdh-pane mth-crs__pane<?= $crs_on ? ' is-on' : '' ?>" id="crs-p-<?= e($crs_p['key']) ?>" role="tabpanel"
               aria-labelledby="crs-t-<?= e($crs_p['key']) ?>" tabindex="0">
            <div class="mth-crs__ph">
              <span class="mth-crs__pico" aria-hidden="true"><?= xt_icon($crs_p['icon'], ['size' => 22]) ?></span>
              <div>
                <p class="mth-k mth-k--blue"><?= $crs_p['hub'] ? 'The hub · keeps the five in step' : 'Part ' . $crs_p['n'] . ' of five' ?></p>
                <h3 class="mth-crs__pt"><?= e($crs_p['title']) ?></h3>
                <p class="mth-crs__ptag"><?= e($crs_p['tag']) ?></p>
              </div>
            </div>
            <p class="mth-crs__pd"><?= e($crs_p['desc']) ?></p>
            <div class="mth-crs__pcols">
              <div>
                <p class="mth-k">What it produces</p>
                <ul class="bdh-bullets mth-crs__po"><?php foreach ($crs_p['out'] as $crs_o2): ?><li><?= e($crs_o2) ?></li><?php endforeach; ?></ul>
              </div>
              <div>
                <p class="mth-k">How it is judged</p>
                <p class="mth-crs__pm"><?= e($crs_p['meas']) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mth-crs__wheel">
        <p class="bdh-sr">A wheel of the five parts of Customer Relationship Strategy — <?= e(implode(', ', array_map(fn ($crs_x) => $crs_x['title'], array_slice($crs_parts, 0, 5)))) ?> — each joined by a spoke to the hub in the middle, <?= e($crs_parts[5]['title']) ?>. Choosing any of the six explains it in the panel beside the wheel.</p>
        <div class="mth-stage mth-crs__stage" style="--ar:1 / 1" role="tablist" aria-label="The parts of Customer Relationship Strategy">
          <svg viewBox="0 0 560 560" focusable="false" aria-hidden="true">
            <circle class="mth-crs__rim" cx="<?= $crs_c ?>" cy="<?= $crs_c ?>" r="<?= $crs_r ?>"/>
            <path class="mth-edge mth-crs__spokes" d="<?= e($crs_spokes) ?>"/>
            <circle class="mth-crs__hubc" cx="<?= $crs_c ?>" cy="<?= $crs_c ?>" r="<?= $crs_hub ?>"/>
          </svg>

          <?php foreach ($crs_parts as $crs_i => $crs_p): $crs_on = $crs_i === 0; ?>
            <?php if ($crs_p['hub']): ?>
              <button class="mth-node mth-crs__node mth-crs__hubn<?= $crs_on ? ' mth-node--on' : '' ?>" type="button" role="tab"
                      id="crs-t-<?= e($crs_p['key']) ?>" aria-controls="crs-p-<?= e($crs_p['key']) ?>"
                      aria-selected="<?= $crs_on ? 'true' : 'false' ?>" tabindex="<?= $crs_on ? '0' : '-1' ?>"
                      style="--x:50;--y:50;--w:28">
                <span class="mth-node__t"><b>HUB</b><?= e($crs_p['title']) ?></span>
                <span class="mth-node__s"><?= e($crs_p['tag']) ?></span>
              </button>
            <?php else: ?>
              <button class="mth-node mth-crs__node<?= $crs_on ? ' mth-node--on' : '' ?>" type="button" role="tab"
                      id="crs-t-<?= e($crs_p['key']) ?>" aria-controls="crs-p-<?= e($crs_p['key']) ?>"
                      aria-selected="<?= $crs_on ? 'true' : 'false' ?>" tabindex="<?= $crs_on ? '0' : '-1' ?>"
                      style="--x:<?= $crs_pos[$crs_i][0] ?>;--y:<?= $crs_pos[$crs_i][1] ?>;--w:26.8">
                <span class="mth-node__t"><b><?= e($crs_p['n']) ?></b><?= e($crs_p['title']) ?></span>
              </button>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <p class="mth-hint" aria-hidden="true"><span class="mth-kbd">←</span><span class="mth-kbd">→</span> move round the practice</p>
      </div>
    </div>

    <!-- PLACEHOLDER: the week ranges below are typical for a first programme — confirm before launch -->
    <div class="mth-crs__proc" data-rv data-rv-d="60">
      <div class="mth-crs__prh">
        <h3 class="mth-crs__prt"><?= $crs['process']['title'] ?></h3>
        <p class="mth-crs__prl"><?= e($crs['process']['lead']) ?></p>
      </div>
      <ol class="mth-steps" style="--cols:4">
        <?php foreach ($crs['process']['steps'] as $crs_si => $crs_s): ?>
          <li class="mth-step<?= $crs_si === 0 ? ' is-on' : '' ?>">
            <p class="mth-step__n"><?= str_pad((string) ($crs_si + 1), 2, '0', STR_PAD_LEFT) ?></p>
            <h4 class="mth-step__t"><?= e($crs_s[0]) ?></h4>
            <p class="mth-step__w"><?= e($crs_s[1]) ?></p>
            <p class="mth-step__d"><?= e($crs_s[2]) ?></p>
            <span class="mth-step__o"><?php foreach ($crs_s[3] as $crs_o3): ?><span><?= e($crs_o3) ?></span><?php endforeach; ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="mth-crs__foot" data-rv>
      <p class="mth-note">Start with the part you need most. Most brands start with journeys and segmentation, because everything after them is guesswork without them. We will always say where the next part is needed.</p>
      <a class="btn btn--white btn--sm" href="<?= e($crs_cta) ?>"><?= e($crs['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
