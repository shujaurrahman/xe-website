<?php /* DRAFT COPY — review before launch */
/* 3 · The six offer items — a building section drawn in HTML/SVG. Six floors stacked from the
   foundation (audit) to the roof (governance); each floor carries an item and a callout line runs
   out to its description. Floors assemble bottom-up and callouts wipe in with clip-path. */
$cba_levels = ['L+00', 'L+01', 'L+02', 'L+03', 'L+04', 'L+05'];
$cba_floor_note = [
    'Foundation: what exists today',
    'Frame: the model everything hangs from',
    'Connections: how brands meet',
    'Signage: what things are called',
    'Circulation: how you move from old to new',
    'Roof: what keeps the structure sound',
];
$cba_offer = $CBA_CAP['offer'];
?>
<section class="band band--alt cba-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-102</b><i aria-hidden="true"></i>Section through the work</p>
        <h2 class="h2" id="offer-t"><?= $CBA_CAP['offer_title'] ?></h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer_lead']) ?> Read the building from the ground up: each floor rests on the one below it.</p>
      </div>
    </div>

    <div class="cba-offer__draw" data-cba-offer data-bdh-in>
      <div class="cba-offer__dim" aria-hidden="true"><span>6 floors · one structure</span></div>
      <ol class="cba-offer__floors">
        <?php foreach (array_reverse($cba_offer, true) as $cba_oi => $cba_o): ?>
          <li class="cba-offer__floor" style="--i:<?= $cba_oi ?>">
            <div class="cba-offer__slab">
              <span class="cba-offer__lv"><?= e($cba_levels[$cba_oi]) ?></span>
              <span class="cba-offer__room">
                <span class="cba-offer__n"><?= sprintf('%02d', $cba_oi + 1) ?></span>
                <h3 class="cba-offer__h"><?= e($cba_o[0]) ?></h3>
              </span>
              <span class="cba-offer__tag"><?= e($cba_o[2]) ?></span>
            </div>
            <span class="cba-offer__lead" aria-hidden="true"><i></i></span>
            <div class="cba-offer__note">
              <p class="cba-mono"><?= e($cba_floor_note[$cba_oi]) ?></p>
              <p class="cba-offer__desc"><?= e($cba_o[1]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <div class="cba-offer__ground" aria-hidden="true"><span>Ground · your portfolio today</span></div>
    </div>
  </div>
</section>
