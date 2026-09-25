<?php /* DRAFT COPY — review before launch */
/* Sectors — the same six sectors the filter uses, as plates. Each tile is a link that applies the
   sector filter on the index above, so the section is navigation as well as imagery. Counts come
   from data/work.php and cannot drift from the index. */
$wrk_plates = [
    'consumer-health'    => ['s-consumer-health.jpg',    'A gloved hand using a pipette over sample trays on a laboratory bench', 800,  1200, '50% 45%'],
    'financial-services' => ['s-financial-services.jpg', 'The glass facade of an office tower with an external spiral stair',     674,  1200, '50% 50%'],
    'retail-commerce'    => ['s-retail-commerce.jpg',    'A boutique interior with clothing rails, a plinth and a pendant light',        800,  1200, '50% 50%'],
    'b2b-technology'     => ['s-b2b-technology.jpg',     'A dark server rack seen close up, its drive bays and cabling in shadow',            1200, 900,  '50% 50%'],
    'hospitality'        => ['s-hospitality.jpg',        'A hotel lobby with a stone reception desk and panelled walls',         1200, 675,  '50% 50%'],
    'telecom-media'      => ['s-telecom-media.jpg',      'Blue network cables fanning into a patch panel in a dark rack',        1600, 1066, '50% 50%'],
];
?>
<section class="band wrk-sec" id="sectors" aria-labelledby="sectors-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Sectors</p>
        <h2 class="h2" id="sectors-t"><span class="g">The constraint changes</span> with the sector.</h2>
      </div>
      <div>
        <p class="lead">The craft travels. What does not travel is the constraint — the regulator, the peak day, the aggregator, the audit. Pick a sector to see only its programmes.</p>
        <a class="tl" href="<?= xe_url('industries.php') ?>">How we work by industry <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photography (assets/imgs/work/CREDITS.md) — replace with own project photography -->
    <ul class="wrk-sec__grid" data-bdh-stagger data-bdh-in>
      <?php foreach ($WRK['industries'] as $wrk_k => $wrk_name):
          $wrk_p = $wrk_plates[$wrk_k] ?? null;
          $wrk_n2 = wrk_count_i($wrk_cases, $wrk_k, '');
      ?>
      <li class="wrk-sec__t bdh-up bdh-zoom">
        <a href="<?= xe_url('work.php') ?>?i=<?= e($wrk_k) ?>#programmes">
          <?php if ($wrk_p): ?>
            <?= wrk_img(['file' => $wrk_p[0], 'alt' => $wrk_p[1], 'w' => $wrk_p[2], 'h' => $wrk_p[3], 'pos' => $wrk_p[4]], [
                'ratio' => 'r45', 'class' => 'wrk-sec__img', 'tag' => 'span',
                'inner' => '<span class="wrk-sec__n bdh-ro">' . $wrk_n2 . '</span>']) ?>
          <?php endif; ?>
          <span class="wrk-sec__body">
            <span class="wrk-sec__h"><?= e($wrk_name) ?><i aria-hidden="true">›</i></span>
            <span class="wrk-sec__d"><?= e($WRK['sector_notes'][$wrk_k] ?? '') ?></span>
            <span class="wrk-sec__c bdh-ro"><?= $wrk_n2 ?> programme<?= $wrk_n2 === 1 ? '' : 's' ?> on this page</span>
          </span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
