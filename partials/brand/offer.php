<?php
/** What this capability offers. Expects $cap; each offer item is [title, description, tag, icon]. */
require_once __DIR__ . '/icons.php';
$ofN = count($cap['offer']);
?>
<section class="band bd-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap bd-offer__grid">
    <div class="bd-offer__side" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What we offer</p>
      <h2 class="h2 bd-offer__h" id="offer-t"><?= $cap['offer_title'] ?></h2>
      <p class="lead bd-offer__lead"><?= e($cap['offer_lead']) ?></p>
      <div class="bd-offer__meter">
        <p class="bd-offer__count"><b class="num"><?= str_pad((string) $ofN, 2, '0', STR_PAD_LEFT) ?></b><span>parts<br>one engagement<br>one team</span></p>
        <span class="bd-offer__segs" data-bd-segs aria-hidden="true"><?php for ($s = 0; $s < $ofN; $s++): ?><i></i><?php endfor; ?></span>
      </div>
      <a class="tl bd-offer__more" href="#deliverables">What you walk away with <span class="i" aria-hidden="true">›</span></a>
    </div>

    <ol class="bd-offer__list" data-bd-offer data-rv-s data-rv-step="70">
      <?php foreach ($cap['offer'] as $i => $o): ?>
        <li class="bd-offer__i">
          <span class="bd-offer__top">
            <span class="bd-offer__ico"><?= bd_icon($o[3] ?? 'dot') ?></span>
            <span class="bd-offer__n num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </span>
          <h3 class="bd-offer__t"><?= e($o[0]) ?></h3>
          <p class="bd-offer__d"><?= e($o[1]) ?></p>
          <span class="bd-offer__tag"><?= e($o[2]) ?></span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
