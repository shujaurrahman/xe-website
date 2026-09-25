<?php /* DRAFT COPY — review before launch */
/* Adjacent — the categories that are not one of the six but that the disciplines already run in, each
   pointing at the discipline hub where it is written up in depth. This section exists so the page does
   not contradict the sector sections on services/brand-design.php and
   services/technology-intelligence.php, which cover these five. Static: no JavaScript. */
$ind_adj = $IND['adjacent'];
?>
<section class="band band--alt ind-adjacent" id="adjacent" aria-labelledby="adjacent-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Adjacent categories</p>
        <h2 class="h2" id="adjacent-t"><span class="g">Six briefs here.</span> More on the discipline pages.</h2>
      </div>
      <div>
        <p class="lead">The six above are where we are deepest and where we will go into this much detail. The disciplines also run in categories next door, and those are written up where the work is: on the discipline pages.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm this adjacent-category list before launch. The six briefs above are the
         approved set; these five are taken from the sector sections already published on the
         Brand Design and Technology & Intelligence hubs, so the site stays consistent. -->
    <ul class="ind-adj__list" role="list" data-rv-s data-rv-step="60">
      <?php foreach ($ind_adj as $ind_ai => $ind_a): $ind_d = $IND_DISC($ind_a[2]); ?>
        <li>
          <a class="ind-adj__row" href="<?= $IND_URL($ind_a[2]) ?>#industries">
            <span class="ind-num"><?= str_pad((string) ($ind_ai + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="ind-adj__nm"><?= e($ind_a[0]) ?></span>
            <span class="ind-adj__ln"><?= e($ind_a[1]) ?></span>
            <span class="ind-adj__go">In <?= e($ind_d['name'] ?? 'our services') ?> <i aria-hidden="true">›</i></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="ind-foot" data-rv>
      <p class="ind-note">
        If your category is not on either list, the method does not change. We run the five questions,
        write down what we find, and say honestly whether this is a category we can be useful in.
      </p>
    </div>
  </div>
</section>
