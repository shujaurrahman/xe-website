<?php /* DRAFT COPY — review before launch */
/* 11 Outcomes — each $CAP outcome as an editorial split statement: the decision as it is usually made
   (before) against the decision this work makes possible (after). Before-lines are draft copy.
   A thin rule draws across each pair as it enters (CSS on [data-rv].is-in). */
$cgs_oc_before = [
    'Twelve segments on a slide, each with a champion, and no agreed way to choose between them.',
    'Gaps spotted on a chart that the brand has no right to claim, and no plan to defend.',
    'A strategy deck approved in the boardroom, then left unread by the teams meant to act on it.',
];
?>
<section class="band cgs-out" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="cgs-head cgs-head--solo" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>11</b><i></i>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Three decisions</span> leadership gets to make differently.</h2>
      </div>
    </div>

    <ol class="cgs-oc">
      <?php foreach ($CAP['outcomes'] as $cgs_oi => $cgs_oc): ?>
        <li class="cgs-oc__pair" data-rv>
          <p class="cgs-oc__n"><?= sprintf('%02d', $cgs_oi + 1) ?></p>
          <div class="cgs-oc__side cgs-oc__side--before">
            <p class="cgs-oc__k">Before</p>
            <p class="cgs-oc__was"><?= e($cgs_oc_before[$cgs_oi] ?? '') ?></p>
          </div>
          <span class="cgs-oc__rule" aria-hidden="true"><i></i></span>
          <div class="cgs-oc__side cgs-oc__side--after">
            <p class="cgs-oc__k">After</p>
            <h3 class="cgs-oc__h"><?= e($cgs_oc[0]) ?></h3>
            <p class="cgs-oc__p"><?= e($cgs_oc[1]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
