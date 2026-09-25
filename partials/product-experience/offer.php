<?php /* DRAFT COPY — review before launch */
/* Offer — what each capability actually does, six practices at a time. One tab per capability
   (ARIA tablist, arrow keys via BDH.tabs); each panel carries that capability's own heading and lead
   from data/product-experience.php and its six practices as cards. With JavaScript off every panel is
   shown in turn, each under its own heading, which is the finished readable state.
   The "six services it covers" links in #capabilities open the matching tab through offer.js. */
$off_caps = array_values($CAPS);
$off_total = array_sum(array_map(fn ($off_c) => count($off_c['offer']), $off_caps));
?>
<section class="band band--alt pxh-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What we do</p>
        <h2 class="h2" id="offer-t"><span class="g">Thirty practices,</span> six per capability.</h2>
      </div>
      <div>
        <p class="lead">This is the work itself: the research, the design, the writing, the front end and the system work a product needs. Choose a capability to see its six.</p>
        <p class="pxh-offer__count"><span class="pxh-k">In total</span><b><?= $off_total ?></b> practices · <b><?= count($off_caps) ?></b> capabilities</p>
      </div>
    </div>

    <div class="pxh-offer__in" data-rv data-rv-d="60">
      <div class="bdh-tabs pxh-offer__tabs" role="tablist" aria-label="Capabilities">
        <?php foreach ($off_caps as $off_i => $off_c): ?>
          <button class="pxh-offer__tab" type="button" role="tab" id="offer-t<?= $off_i ?>" aria-controls="offer-p<?= $off_i ?>"
                  aria-selected="<?= $off_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $off_i === 0 ? '0' : '-1' ?>">
            <span class="pxh-offer__tn"><?= e($off_c['n']) ?></span>
            <span class="pxh-offer__tt"><?= e($off_c['short']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="pxh-offer__panes">
        <?php foreach ($off_caps as $off_i => $off_c): ?>
          <div class="pxh-offer__pane" role="tabpanel" id="offer-p<?= $off_i ?>" aria-labelledby="offer-t<?= $off_i ?>" tabindex="0">
            <div class="pxh-offer__ph">
              <div>
                <p class="pxh-k"><?= e($off_c['n']) ?> · <?= e($off_c['name']) ?></p>
                <p class="pxh-offer__pt"><?= $off_c['offer_title'] ?></p>
              </div>
              <div>
                <p class="lead pxh-offer__pl"><?= e($off_c['offer_lead']) ?></p>
                <a class="tl" href="#<?= e($off_c['slug']) ?>">Back to <?= e($off_c['short']) ?> in the index <span class="i" aria-hidden="true">›</span></a>
              </div>
            </div>

            <ul class="pxh-cards pxh-cards--3 pxh-offer__cards" role="list">
              <?php foreach ($off_c['offer'] as $off_oi => $off_o): ?>
                <li class="pxh-card pxh-card--flat pxh-card--lift pxh-offer__card">
                  <span class="pxh-card__top">
                    <span class="pxh-card__n"><?= str_pad((string) ($off_oi + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="pxh-card__ico" aria-hidden="true"><?= xt_icon($off_o[3], ['size' => 22]) ?></span>
                  </span>
                  <h3 class="pxh-card__t"><?= e($off_o[0]) ?></h3>
                  <p class="pxh-card__d"><?= e($off_o[1]) ?></p>
                  <span class="pxh-card__foot"><span class="bdh-tag bdh-tag--blue"><?= e($off_o[2]) ?></span></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="pxh-note pxh-offer__note">Practices are how the work is done. What you can buy, in packages and with prices scoped to your brief, is in <a href="#services">Services &amp; packages</a> further down this page.</p>
  </div>
</section>
