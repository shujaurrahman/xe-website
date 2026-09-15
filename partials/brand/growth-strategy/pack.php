<?php /* DRAFT COPY — review before launch */
/* 10 Deliverables — the evidence pack. Each $CAP deliverable is a document spine standing in a box file;
   hovering or focusing a spine pulls it out and shows what is inside (pack.js keeps one pulled on touch).
   Spine descriptions are draft copy. */
$cgs_pk_inside = [ // per deliverable, in $CAP['deliver'] order
    'Category boundaries, segment sizes, who wins where, and the openings worth testing.',
    'Every segment scored on the five criteria, with the weights leadership signed and the evidence behind each score.',
    'Competitors placed on the attributes buyers use, with the gaps the brand can credibly claim.',
    'Where growth comes from, in what order, what has to be true, and what the brand will not do.',
    'Moves in three horizons, each with an owner, a measure and a date.',
    'North-star, drivers and leading indicators with definitions, sources, baselines and targets.',
];
$cgs_pk_n = count($CAP['deliver']);
?>
<section class="band band--alt cgs-pack" id="pack" aria-labelledby="pack-t">
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>10</b><i></i>What you keep</p>
        <h2 class="h2" id="pack-t"><span class="g"><?= $cgs_pk_n ?> documents,</span> one evidence pack.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">Everything the ranking and the roadmap rest on is handed over in formats your teams already use, so the reasoning survives after we leave.</p>
      </div>
    </div>

    <div class="cgs-pk" data-cgs-pack>
      <div class="cgs-pk__box">
        <p class="cgs-pk__label" aria-hidden="true"><span>Evidence pack</span><span>Your brand · growth strategy</span></p>
        <ul class="cgs-pk__shelf">
          <?php foreach ($CAP['deliver'] as $cgs_pi => $cgs_dl): ?>
            <li class="cgs-pk__doc<?= $cgs_pi === 1 ? ' is-out' : '' ?>" style="--i:<?= $cgs_pi ?>">
              <button type="button" class="cgs-pk__spine" aria-expanded="<?= $cgs_pi === 1 ? 'true' : 'false' ?>" aria-controls="pack-d<?= $cgs_pi ?>">
                <span class="cgs-pk__no"><?= sprintf('%02d', $cgs_pi + 1) ?></span>
                <span class="cgs-pk__name"><?= e($cgs_dl[0]) ?></span>
                <span class="cgs-pk__fmt"><?= e($cgs_dl[1]) ?></span>
              </button>
              <div class="cgs-pk__sheet" id="pack-d<?= $cgs_pi ?>">
                <h3 class="bdh-sr"><?= e($cgs_dl[0]) ?></h3>
                <p class="cgs-pk__h" aria-hidden="true">What is inside</p>
                <p class="cgs-pk__p"><?= e($cgs_pk_inside[$cgs_pi] ?? '') ?></p>
                <p class="cgs-pk__formats"><?php foreach (array_map('trim', explode('·', $cgs_dl[1])) as $cgs_fm): ?><span><?= e($cgs_fm) ?></span><?php endforeach; ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <p class="cgs-pk__foot"><span class="cgs-note">Handover</span> Files are yours, editable, and referenced to the interviews and data they draw on.</p>
    </div>
  </div>
</section>
