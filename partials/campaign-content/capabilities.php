<?php /* DRAFT COPY — review before launch */
/* Capabilities — the eight, in depth, and the anchor targets every capability link on this page points
   at (id="<capability-slug>"). Each panel is the same card system: an identity rail, the approved
   statement and lead from data/campaign-content.php, three meta facts, what changes, the six parts of
   the offer as .cch-tile cards, then a footer of frameworks, platforms and the two capabilities it
   pairs with. The eight capability subpages reuse this panel with their own content. */
$cap_cta = [
    /* the hub service each capability's enquiry should arrive tagged with (data/services/campaign-content.php) */
    'content-marketing'              => 'content-strategy',
    'social-media-marketing'         => 'social-always-on',
    'public-relations'               => 'pr-programme',
    'social-influencer-activation'   => 'influencer-activation',
    'performance-marketing'          => 'paid-media',
    'omnichannel-marketing-strategy' => 'omnichannel-strategy',
    'campaign-design-systems'        => 'campaign-system',
    'global-content-production'      => 'campaign-production',
];
?>
<section class="band cch-caps" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>In depth</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Eight capabilities,</span> what each one actually does.</h2>
      </div>
      <div>
        <p class="lead">Each panel below is one capability: what it is, what it is measured on, the six parts it is built from, the frameworks it works to and the platforms it runs in. Any one of them can be bought on its own.</p>
      </div>
    </div>

    <div class="cch-caps__list">
      <?php foreach ($CAPS as $cap_slug => $cap_c):
          $cap_stage = $CCH['stages'][$CCH['stage_of'][$cap_slug]];
          $cap_svc   = 'campaign-content:' . ($cap_cta[$cap_slug] ?? '');
          $cap_url   = svc_contact_url([$cap_svc], null, 'campaign-content'); ?>
        <article class="cch-cap" id="<?= e($cap_slug) ?>" data-rv data-rv-d="40" aria-labelledby="<?= e($cap_slug) ?>-t">
          <header class="cch-cap__hd">
            <div class="cch-cap__rail">
              <p class="cch-cap__id">
                <span class="cch-cap__n"><?= e($cap_c['n']) ?></span>
                <span class="cch-cap__ico" aria-hidden="true"><?= xt_icon($cap_c['icon'], ['size' => 26]) ?></span>
              </p>
              <span class="cch-stg" data-stage="<?= e($CCH['stage_of'][$cap_slug]) ?>"><b><?= e($cap_stage['code']) ?></b><?= e($cap_stage['name']) ?></span>
              <p class="cch-cap__kick"><?= e($cap_c['kicker']) ?></p>
            </div>

            <div class="cch-cap__main">
              <h3 class="cch-cap__t" id="<?= e($cap_slug) ?>-t"><?= e($cap_c['name']) ?></h3>
              <p class="cch-cap__st"><?= $cap_c['title'] ?></p>
              <p class="cch-cap__lead"><?= e($cap_c['lead']) ?></p>
              <p class="cch-k cch-cap__ok">What changes</p>
              <ul class="cch-cap__out" role="list">
                <?php foreach ($cap_c['outcomes'] as $cap_o): ?>
                  <li><b><?= e($cap_o[0]) ?></b><span><?= e($cap_o[1]) ?></span></li>
                <?php endforeach; ?>
              </ul>
            </div>

            <?php /* the facts and the action come after the heading in the document, so a phone reads the
                     capability's name before its price of entry; on wide screens the grid puts them back
                     under the identity rail on the left. */ ?>
            <div class="cch-cap__facts">
              <!-- PLACEHOLDER: the timeframes below are typical ranges from data/campaign-content.php — confirm before launch -->
              <dl class="cch-cap__meta">
                <?php foreach ($cap_c['meta'] as $cap_mi => $cap_m): ?>
                  <div><dt><?= e($cap_c['meta_k'][$cap_mi]) ?></dt><dd><?= e($cap_m) ?></dd></div>
                <?php endforeach; ?>
              </dl>
              <a class="btn btn--out btn--sm cch-cap__cta" href="<?= e($cap_url) ?>"><?= e($cap_c['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
            </div>
          </header>

          <div class="cch-cap__offer">
            <p class="cch-cap__oh"><span class="cch-k">The six parts</span><span><?= e($cap_c['offer_lead']) ?></span></p>
            <ol class="cch-tiles cch-cap__tiles">
              <?php foreach ($cap_c['offer'] as $cap_oi => $cap_of): ?>
                <li class="cch-tile cch-tile--lift" style="--i:<?= $cap_oi ?>">
                  <span class="cch-tile__top">
                    <span class="cch-tile__ico" aria-hidden="true"><?= xt_icon($cap_of[3], ['size' => 18]) ?></span>
                    <span class="cch-tile__t"><?= e($cap_of[0]) ?></span>
                  </span>
                  <span class="cch-tile__d"><?= e($cap_of[1]) ?></span>
                  <span class="cch-tile__tag"><?= e($cap_of[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>

          <footer class="cch-cap__ft">
            <div class="cch-cap__fc">
              <p class="cch-k">Handed over · <?= count($cap_c['deliver']) ?> items</p>
              <a class="cch-cap__dl" href="#deliverables">See the full list <i aria-hidden="true">›</i></a>
            </div>
            <div class="cch-cap__fc">
              <p class="cch-k">Frameworks it works to</p>
              <ul class="cch-cap__std" role="list"><?php foreach ($cap_c['standards'] as $cap_st) { echo xt_badge($cap_st, ['variant' => 'chip', 'tag' => 'li']); } ?></ul>
            </div>
            <div class="cch-cap__fc cch-cap__fc--stack">
              <p class="cch-k">Platforms we work in</p>
              <?= xt_stack(array_slice($cap_c['stack'], 0, 8), ['variant' => 'logos', 'size' => 20, 'label' => 'Platforms we work in for ' . $cap_c['name'], 'class' => 'cch-cap__stack']) ?>
            </div>
            <div class="cch-cap__fc">
              <p class="cch-k">Usually bought with</p>
              <p class="cch-capls">
                <?php foreach ($cap_c['pairs'] as $cap_p): $cap_pc = $CAPS[$cap_p]; ?>
                  <a class="cch-capl" href="#<?= e($cap_p) ?>"><b><?= e($cap_pc['n']) ?></b><?= e($cap_pc['short']) ?><i aria-hidden="true">›</i></a>
                <?php endforeach; ?>
              </p>
            </div>
          </footer>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="cch-note cch-caps__note"><b>Technologies we work with.</b> No partner, reseller or certification tier is implied by any mark on this page, and every framework badge is drawn in code by us rather than reproduced from an official seal.</p>
  </div>
</section>
