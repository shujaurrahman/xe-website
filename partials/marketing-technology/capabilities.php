<?php /* DRAFT COPY — review before launch */
/* Capabilities — THE CARD SYSTEM, and the page's anchor targets. One card per capability, each with its
   bare slug as its id, because every capability link on this page (and in the mega menu, once the
   capability pages exist) points at #<slug> here. Copy is the approved content in
   data/marketing-technology.php: the lead, the three meta values, the six parts of the offer, the three
   outcomes, the technologies and the frameworks.
   No JavaScript: the cards are static, always in flow, never stacked in one grid cell, so nothing can
   ghost through anything else (defect class 5) and nothing depends on a class JavaScript adds. */
$cap_page = svc_page('marketing-technology');
/* which hub services belong to each capability, so its button arrives at the contact page pre-tagged */
$cap_buy = [];
foreach (($cap_page['categories'] ?? []) as $cap_cat) {
    foreach ($cap_cat['offers'] as $cap_o) {
        if (!empty($cap_o['cap'])) $cap_buy[$cap_o['cap']][] = $cap_o['key'];
    }
}
$cap_url = fn (string $cap_s): string => svc_contact_url(
    array_map(fn ($cap_k) => 'marketing-technology:' . $cap_k, array_slice($cap_buy[$cap_s] ?? [], 0, 2)),
    null,
    'marketing-technology'
);
?>
<section class="band mth-capabilities" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>In depth</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Seven capabilities,</span> in their own words.</h2>
      </div>
      <div>
        <p class="lead">Each card is the whole of one capability: what it offers, what it changes, how long a first release usually takes, the technologies it runs on and the frameworks it is built to. Nothing is held back for a sales call.</p>
        <!-- PLACEHOLDER: every timeframe below is a typical range from data/marketing-technology.php — confirm before launch -->
        <p class="mth-note">Timeframes are typical ranges for work of this shape, not commitments, and are agreed per engagement.</p>
      </div>
    </div>

    <div class="mth-cap__list">
      <?php foreach ($CAPS as $cap_slug => $cap_c):
          $cap_stage = $MTH['stages'][$MTH['stage_of'][$cap_slug]];
          $cap_n = count($cap_buy[$cap_slug] ?? []); ?>
        <article class="mth-card mth-cap__card" id="<?= e($cap_slug) ?>" aria-labelledby="<?= e($cap_slug) ?>-t" data-rv data-rv-d="40">
          <div class="mth-card__top">
            <span class="mth-card__ico" aria-hidden="true"><?= xt_icon($cap_c['icon'], ['size' => 24]) ?></span>
            <div class="mth-cap__name">
              <p class="mth-card__n"><?= e($cap_c['n']) ?></p>
              <h3 class="mth-card__t" id="<?= e($cap_slug) ?>-t"><?= e($cap_c['name']) ?></h3>
              <p class="mth-card__kick"><?= e($cap_c['kicker']) ?></p>
            </div>
            <span class="mth-cap__stage"><span class="mth-k">In the loop</span><b><?= e($cap_stage['code']) ?> · <?= e($cap_stage['name']) ?></b></span>
          </div>

          <div class="mth-card__body">
            <div class="mth-cap__grid">
              <div class="mth-cap__say">
                <p class="mth-cap__lead"><?= e($cap_c['lead']) ?></p>
                <dl class="mth-cap__meta">
                  <?php foreach ($cap_c['meta'] as $cap_mi => $cap_mv): ?>
                    <div><dt><?= e($cap_c['meta_k'][$cap_mi]) ?></dt><dd><?= e($cap_mv) ?></dd></div>
                  <?php endforeach; ?>
                </dl>
                <div class="mth-cap__out">
                  <p class="mth-k">What changes</p>
                  <ul class="mth-cap__outs">
                    <?php foreach ($cap_c['outcomes'] as $cap_o2): ?>
                      <li><b><?= e($cap_o2[0]) ?></b><span><?= e($cap_o2[1]) ?></span></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>

              <div class="mth-cap__offers">
                <p class="mth-cap__olead"><span class="mth-k">What it covers · six parts</span><?= e($cap_c['offer_lead']) ?></p>
                <ul class="mth-cap__ol">
                  <?php foreach ($cap_c['offer'] as $cap_oi => $cap_of): ?>
                    <li class="mth-cap__o" style="--i:<?= $cap_oi ?>">
                      <span class="mth-cap__oi" aria-hidden="true"><?= xt_icon($cap_of[3], ['size' => 18]) ?></span>
                      <span class="mth-cap__ot"><?= e($cap_of[0]) ?></span>
                      <span class="mth-cap__og"><?= e($cap_of[2]) ?></span>
                      <span class="mth-cap__od"><?= e($cap_of[1]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>

            <div class="mth-cap__rail">
              <div class="mth-cap__rw">
                <p class="mth-k">Technologies we work with</p>
                <?= xt_stack(array_slice($cap_c['stack'], 0, 8), ['variant' => 'chips', 'size' => 16, 'label' => 'Technologies used in ' . $cap_c['name'], 'class' => 'mth-cap__stk']) ?>
              </div>
              <div class="mth-cap__rw">
                <p class="mth-k">Frameworks it is built to</p>
                <ul class="mth-cap__std" role="list" aria-label="Frameworks <?= e($cap_c['name']) ?> is built to">
                  <?php foreach ($cap_c['standards'] as $cap_st) { echo xt_badge($cap_st, ['variant' => 'chip', 'tag' => 'li']); } ?>
                </ul>
              </div>
            </div>
          </div>

          <div class="mth-card__foot">
            <span class="mth-cap__pairs">
              <span class="mth-k">Works closely with</span>
              <?php foreach ($cap_c['pairs'] as $cap_p): $cap_pc = $CAPS[$cap_p] ?? null; if (!$cap_pc) continue; ?>
                <a class="mth-capl" href="<?= e(($MTH['cap_href'])($cap_p)) ?>"><b><?= e($cap_pc['n']) ?></b><?= e($cap_pc['short']) ?><i aria-hidden="true">›</i></a>
              <?php endforeach; ?>
            </span>
            <?php if ($cap_n): ?>
              <a class="tl mth-cap__svc" href="#services"><?= $cap_n ?> service<?= $cap_n === 1 ? '' : 's' ?> in the catalogue <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
            <a class="btn btn--ink btn--sm" href="<?= e($cap_url($cap_slug)) ?>"><?= e($cap_c['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
