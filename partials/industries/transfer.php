<?php /* DRAFT COPY — review before launch */
/* Transfer — two ledgers on ink. What we carry from one category to the next (the machinery) against what
   is rebuilt every time (the claims, the approvals, the baselines). It is the commercial argument for a
   group that operates in several of these categories, and the honest limit on it. Static: no JavaScript. */
$ind_tr = $IND['transfer'];
?>
<section class="band band--ink ind-transfer" id="transfer" aria-labelledby="transfer-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What travels</p>
        <h2 class="h2" id="transfer-t"><span class="g">Some of the work travels.</span> The rest is rebuilt every time.</h2>
      </div>
      <div>
        <p class="lead">Working across several of these categories saves real money, but only on the machinery. Claim language, approval routes and what counts as a good number are category property, and treating them as reusable is the most expensive mistake in this page.</p>
      </div>
    </div>

    <div class="ind-tr__cols">
      <section class="ind-tr__col ind-tr__col--yes" aria-labelledby="transfer-yes" data-rv data-rv-d="40">
        <header class="ind-tr__ch">
          <span class="ind-tr__ci ind-ico--fill" aria-hidden="true"><?= xt_icon('sync', ['size' => 20]) ?></span>
          <h3 class="ind-tr__ct" id="transfer-yes">Carries across</h3>
          <span class="ind-tr__cn"><?= count($ind_tr['carries']) ?> things</span>
        </header>
        <div class="ind-led ind-tr__led">
          <?php foreach ($ind_tr['carries'] as $ind_t): ?>
            <p><b><?= e($ind_t[0]) ?></b><span><?= e($ind_t[1]) ?></span></p>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="ind-tr__col ind-tr__col--no" aria-labelledby="transfer-no" data-rv data-rv-d="120">
        <header class="ind-tr__ch">
          <span class="ind-tr__ci" aria-hidden="true"><?= xt_icon('flag', ['size' => 20, 'mono' => true]) ?></span>
          <h3 class="ind-tr__ct" id="transfer-no">Never carries</h3>
          <span class="ind-tr__cn"><?= count($ind_tr['never']) ?> things</span>
        </header>
        <div class="ind-led ind-tr__led">
          <?php foreach ($ind_tr['never'] as $ind_t): ?>
            <p><b><?= e($ind_t[0]) ?></b><span><?= e($ind_t[1]) ?></span></p>
          <?php endforeach; ?>
        </div>
      </section>
    </div>

    <div class="ind-foot" data-rv>
      <p class="ind-note">
        A proposal that reuses the second list is a proposal written for a different category.
        When we quote work in two of these categories, the shared machinery is quoted once and the
        category work is quoted twice, on purpose.
      </p>
    </div>
  </div>
</section>
