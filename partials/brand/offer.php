<?php
/**
 * What this capability offers, part by part: a section head, then one cell per
 * part (icon, number, title, description, tag) on a hairline grid. One part is
 * lit at a time while the grid is on screen; hovering a part takes over.
 *
 *   $cap       required  offer_title (html), offer_lead, offer [[title, description, tag, icon]]
 *                        — icon names are listed in partials/brand/icons.php
 *   $offerId   optional  section id (default 'offer')
 *   $offerLbl  optional  eyebrow (default 'What we offer')
 */
require_once __DIR__ . '/icons.php';
$ofItems = $cap['offer'];
$ofN     = count($ofItems);
$ofId    = isset($offerId) && $offerId !== '' ? $offerId : 'offer';
$ofLbl   = $offerLbl ?? 'What we offer';
$ofPad   = function ($x) { return str_pad((string) $x, 2, '0', STR_PAD_LEFT); };
?>
<section class="band bd-offer" id="<?= e($ofId) ?>" aria-labelledby="<?= e($ofId) ?>-t">
  <div class="wrap bd-offer__grid">
    <div class="bd-offer__side" data-rv>
      <div class="bd-offer__hl">
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($ofLbl) ?></p>
        <h2 class="h2 bd-offer__h" id="<?= e($ofId) ?>-t"><?= $cap['offer_title'] ?></h2>
      </div>
      <div class="bd-offer__hr">
        <p class="lead bd-offer__lead"><?= e($cap['offer_lead']) ?></p>
        <div class="bd-offer__meter">
          <p class="bd-offer__count"><b class="num"><?= $ofPad($ofN) ?></b><span>Parts <i aria-hidden="true">·</i> one team</span></p>
          <span class="bd-offer__segs" data-bd-segs aria-hidden="true"><?php for ($s = 0; $s < $ofN; $s++): ?><i></i><?php endfor; ?></span>
        </div>
      </div>
    </div>

    <ol class="bd-offer__list" data-bd-offer data-rv-s data-rv-step="80">
      <?php foreach ($ofItems as $i => $o): ?>
        <li class="bd-offer__i">
          <span class="bd-offer__top">
            <span class="bd-offer__ico" aria-hidden="true"><?= bd_icon($o[3] ?? 'dot') ?></span>
            <span class="bd-offer__n num" aria-hidden="true"><?= $ofPad($i + 1) ?></span>
          </span>
          <h3 class="bd-offer__t"><?= e($o[0]) ?></h3>
          <p class="bd-offer__d"><?= e($o[1]) ?></p>
          <span class="bd-offer__tag"><?= e($o[2]) ?></span>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="bd-offer__foot" data-rv>
      <span>Every part is handed over as files you own.</span>
      <a class="tl bd-offer__more" href="#deliverables">What you walk away with <span class="i" aria-hidden="true">›</span></a>
    </p>
  </div>
</section>
