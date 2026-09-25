<?php /* DRAFT COPY — review before launch */
/* Rules — the instruments, once, with what each one changes in the work. Several of them follow the
   activity rather than the sector, which is why the same instrument appears in more than one brief
   above; the per-category lists say what it decides there, this section says what it changes here.
   The rows use the shared core accordion ([data-acc="multi"]); the <noscript> rule below leaves every
   row open, so the section is complete with JavaScript off. No section script is needed. */
$ind_rules = $IND['rules'];
?>
<noscript><style>.ind-rules__p{height:auto;overflow:visible}.ind-rules__plus{display:none}</style></noscript>
<section class="band band--alt ind-rules" id="rules" aria-labelledby="rules-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What binds the work</p>
        <h2 class="h2" id="rules-t"><span class="g">The instruments,</span> and what each one changes.</h2>
      </div>
      <div>
        <p class="lead">Most of these follow the activity, not the sector. Take card payments and the payment standard follows you into hospitality, retail and lending alike. What matters commercially is not the list, it is what each one changes in the design, the data model and the release.</p>
        <p class="ind-note">Named only where it applies. A summary for orientation, not legal advice. <!-- PLACEHOLDER: have counsel review every regulatory summary in this section and in data/industries.php before launch, and confirm the DPDP Act rules' current commencement position --></p>
      </div>
    </div>

    <div class="ind-rules__list" data-acc="multi" data-rv data-rv-d="60">
      <?php foreach ($ind_rules as $ind_ri => $ind_r):
          $ind_open = $ind_ri === 0;
          $ind_n = str_pad((string) ($ind_ri + 1), 2, '0', STR_PAD_LEFT); ?>
        <div class="ind-rules__row">
          <h3 class="ind-rules__hq">
            <button class="ind-rules__q" type="button" data-acc-b aria-expanded="<?= $ind_open ? 'true' : 'false' ?>" aria-controls="rules-a<?= $ind_ri ?>" id="rules-q<?= $ind_ri ?>">
              <span class="ind-rules__n" aria-hidden="true"><?= $ind_n ?></span>
              <span class="ind-rules__nm"><?= e($ind_r[1]) ?><small><?= e($ind_r[2]) ?></small></span>
              <span class="ind-rules__cnt"><?= count($ind_r[5]) ?> of 6 briefs</span>
              <span class="ind-rules__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="ind-rules__p<?= $ind_open ? ' is-open' : '' ?>" id="rules-a<?= $ind_ri ?>" role="region" aria-labelledby="rules-q<?= $ind_ri ?>" data-acc-p>
            <div class="ind-rules__a">
              <dl class="ind-rules__dl">
                <div><dt>What it binds</dt><dd><?= e($ind_r[3]) ?></dd></div>
                <div><dt>What it changes in the work</dt><dd><?= e($ind_r[4]) ?></dd></div>
              </dl>
              <div class="ind-rules__meta">
                <?php if ($ind_r[0] !== null): ?>
                  <p class="ind-rules__badge"><?= xt_badge($ind_r[0], ['variant' => 'chip']) ?></p>
                <?php endif; ?>
                <p class="ind-k">Central to</p>
                <p class="ind-capls ind-rules__cats">
                  <?php foreach ($ind_r[5] as $ind_cs): $ind_cc = $IND_SET[$ind_cs] ?? null; if (!$ind_cc) continue; ?>
                    <a class="ind-capl" href="#<?= e($ind_cs) ?>"><b><?= e($ind_cc['n']) ?></b><?= e($ind_cc['short']) ?><i aria-hidden="true">›</i></a>
                  <?php endforeach; ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
