<?php /* DRAFT COPY — review before launch */
/* 02 · What we build. Six cards, each opening on a small code-built surface of the thing itself: a headless CMS entry
   publishing, a portal table updating, one component on two phones, a storefront basket, an offline queue syncing,
   a design-system sheet. Each surface plays once when the card enters (offer.js); the HTML is the finished state.
   Cards list the technologies we work with for that surface. $TWA_OFFER comes from the shell. */
$twa_of_mock = function (string $k): string {
    ob_start();
    switch ($k):
        case 'cms': ?>
      <span class="twa-om twa-om--cms">
        <span class="twa-om__side"><b>CMS</b><i class="is-on">Journal</i><i>Pages</i><i>Products</i><i>Media</i></span>
        <span class="twa-om__main">
          <span class="twa-om__row"><b>Title</b><span class="twa-om__in"><span data-om-type>Autumn tableware edit</span></span></span>
          <span class="twa-om__row"><b>Hero</b><span class="twa-om__in twa-om__in--img"><i></i>vase-1600.avif · 64 KB</span></span>
          <span class="twa-om__row"><b>Slug</b><span class="twa-om__in">/journal/autumn-edit</span></span>
          <span class="twa-om__pub"><span class="twa-om__swap"><em class="twa-om__a">Draft · preview link ready</em><em class="twa-om__b"><i></i>Published · edge cache purged 38 ms</em></span><span class="twa-om__btn">Publish</span></span>
        </span>
      </span>
    <?php break;
        case 'portal': ?>
      <span class="twa-om twa-om--portal">
        <span class="twa-om__hd"><b>Orders</b><span class="twa-om__role">Role · Operations</span></span>
        <span class="twa-om__kpis"><span><small>Open</small><b data-bdh-count>128</b></span><span><small>Shipped today</small><b data-bdh-count>1,284</b></span><span><small>p75 INP</small><b>90 ms</b></span></span>
        <span class="twa-om__tbl">
          <span class="twa-om__tr twa-om__tr--h"><i>Order</i><i>Items</i><i>Status</i></span>
          <span class="twa-om__tr is-hl"><i>#10482</i><i>3</i><i><span class="twa-om__swap"><em class="twa-om__a twa-om__chip">Pending</em><em class="twa-om__b twa-om__chip is-ok">Shipped</em></span></i></span>
          <span class="twa-om__tr"><i>#10481</i><i>1</i><i><em class="twa-om__chip is-ok">Shipped</em></i></span>
          <span class="twa-om__tr"><i>#10479</i><i>6</i><i><em class="twa-om__chip">Packing</em></i></span>
        </span>
      </span>
    <?php break;
        case 'mobile': ?>
      <span class="twa-om twa-om--mobile">
        <?php foreach (['iOS · Swift', 'Android · Kotlin'] as $twa_om_i => $twa_om_p): ?>
          <span class="twa-om__ph">
            <span class="twa-om__os"><?= e($twa_om_p) ?></span>
            <span class="twa-om__card"><i class="twa-om__av"></i><span><b></b><b></b></span></span>
            <span class="twa-om__card"><i class="twa-om__av"></i><span><b></b><b></b></span></span>
            <span class="twa-om__toast" style="--d:<?= $twa_om_i ?>"><i></i>Synced · 3 changes</span>
          </span>
        <?php endforeach; ?>
        <span class="twa-om__shared">One shared component · two platforms</span>
      </span>
    <?php break;
        case 'shop': ?>
      <span class="twa-om twa-om--shop">
        <span class="twa-om__hd"><b>Your platform</b><span class="twa-om__cart">Basket<span class="twa-om__swap twa-om__badge"><em class="twa-om__a">1</em><em class="twa-om__b">2</em></span></span></span>
        <span class="twa-om__prod">
          <span class="twa-om__img"><img src="<?= xe_url('assets/imgs/tech/websites-apps/product-jug.jpg') ?>" width="1400" height="933" alt="" loading="lazy" decoding="async"></span>
          <span class="twa-om__pd"><b>Tall stoneware jug</b><small>36.00 · in stock</small><span class="twa-om__add"><span class="twa-om__swap"><em class="twa-om__a">Add to basket</em><em class="twa-om__b">Added</em></span></span></span>
        </span>
        <span class="twa-om__steps"><i class="is-on">Basket</i><i class="is-on">Delivery</i><i>Pay</i></span>
      </span>
    <?php break;
        case 'pwa': ?>
      <span class="twa-om twa-om--pwa">
        <span class="twa-om__net"><span class="twa-om__swap"><em class="twa-om__a"><i></i>Offline · 3 actions queued</em><em class="twa-om__b"><i></i>Back online · 3 synced</em></span></span>
        <?php foreach (['Stock count · aisle 14', 'Photo · damaged pallet', 'Signature · delivery 2291'] as $twa_om_i => $twa_om_q): ?>
          <span class="twa-om__q" style="--d:<?= $twa_om_i ?>"><span class="twa-om__swap twa-om__qi"><em class="twa-om__a"></em><em class="twa-om__b"></em></span><span><?= e($twa_om_q) ?></span><small>queued</small></span>
        <?php endforeach; ?>
        <span class="twa-om__sw">Service worker · background sync · IndexedDB</span>
      </span>
    <?php break;
        default: ?>
      <span class="twa-om twa-om--ds">
        <span class="twa-om__tok"><i style="--c:var(--ink)"></i><i style="--c:var(--blue)"></i><i style="--c:var(--paper-3)"></i><i style="--c:var(--line-3)"></i><small>color.* · 24 tokens</small></span>
        <span class="twa-om__type"><b class="t1">Aa</b><b class="t2">Aa</b><b class="t3">Aa</b><small>type.scale · 1.25</small></span>
        <span class="twa-om__btns"><em class="p">Primary</em><em class="s">Secondary</em><em class="d">Disabled</em></span>
        <span class="twa-om__sb"><i></i>Storybook · 142 stories · axe 0 violations</span>
      </span>
    <?php endswitch;
    return (string) ob_get_clean();
};
?>
<section class="band twa-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>02 · What we build</b><span>Six surfaces · one release train</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="offer-t"><span class="g">Six things we build.</span> Every one measured after launch.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Each starts from the same foundations: a design system in code, budgets in CI, accessibility checks and real-user monitoring from the first release. The surface changes; the standard does not.</p>
      </div>
    </div>

    <ul class="twa-of" role="list">
      <?php foreach ($TWA_OFFER as $twa_oi => $twa_o): ?>
        <li class="twa-of__card" data-rv data-rv-d="<?= ($twa_oi % 3) * 60 ?>">
          <div class="twa-of__mock" aria-hidden="true"><?= $twa_of_mock($twa_o[5]) ?></div>
          <div class="twa-of__body">
            <p class="twa-of__top"><span class="twa-of__ico"><?= xt_icon($twa_o[3], ['size' => 22]) ?></span><span class="bdh-idx"><?= sprintf('%02d', $twa_oi + 1) ?></span></p>
            <h3 class="bdh-t"><?= e($twa_o[0]) ?></h3>
            <p class="bdh-d"><?= e($twa_o[1]) ?></p>
            <div class="twa-of__foot">
              <?= xt_stack($twa_o[4], ['variant' => 'logos', 'size' => 20, 'label' => 'Technologies we work with for ' . $twa_o[0], 'class' => 'twa-of__logos']) ?>
              <span class="twa-of__tag"><?= e($twa_o[2]) ?></span>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
