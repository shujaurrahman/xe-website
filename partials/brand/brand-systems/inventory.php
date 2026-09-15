<?php /* DRAFT COPY — review before launch */
/* 05 · Component inventory — the audit. Each column is one kind of component: a pile of the
   near-duplicates found across files, and the canonical set they merge into.
   All counts illustrative. PLACEHOLDER: confirm before launch */
$cbs_inv_groups = [   // [key, name, found, canonical, canonical variants label]
    ['btn',    'Buttons',       23, 3, 'primary · secondary · text'],
    ['input',  'Inputs',        14, 2, 'default · with hint'],
    ['card',   'Cards',         19, 4, 'product · article · stat · quote'],
    ['badge',  'Badges',        11, 2, 'status · count'],
    ['header', 'Email headers',  9, 1, 'one header, three slots'],
    ['tile',   'Social tiles',  16, 3, 'square · portrait · story'],
];
$cbs_inv_fills = ['var(--blue)', 'var(--blue-d)', 'var(--ink)', 'var(--muted)', 'var(--ghost)', 'var(--ink-2)'];
$cbs_inv_radii = [0, 3, 6, 10, 14, 24];
$cbs_inv_found = array_sum(array_column($cbs_inv_groups, 2));
$cbs_inv_canon = array_sum(array_column($cbs_inv_groups, 3));
?>
<section class="band cbs-inv" id="inventory" aria-labelledby="cbs-inv-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>05</b><i>/</i>audit<i>/</i>component-inventory</p>
      <h2 class="cbs-head__h" id="cbs-inv-t"><span class="g">Find the duplicates.</span> Keep one of each.</h2>
      <p class="lead cbs-head__lead">Most brands already have a component library. It is just spread across files, agencies and markets, with a slightly different button in each. The audit finds every near-duplicate, and the system keeps the few that earn their place.</p>
    </header>

    <div class="cbs-inv__board" data-cbs-inv>
      <div class="cbs-inv__top">
        <div class="cbs-inv__switch" role="group" aria-label="Audit view">
          <button type="button" class="cbs-btn" aria-pressed="true" data-cbs-inv-set="0">Found in audit</button>
          <button type="button" class="cbs-btn" aria-pressed="false" data-cbs-inv-set="1">After consolidation</button>
        </div>
        <dl class="cbs-inv__stats">
          <div><dt>Variants</dt><dd class="num" data-cbs-inv-total data-a="<?= $cbs_inv_found ?>" data-b="<?= $cbs_inv_canon ?>"><?= $cbs_inv_found ?></dd></div>
          <div><dt>Retired</dt><dd class="num" data-cbs-inv-retired data-a="0" data-b="<?= $cbs_inv_found - $cbs_inv_canon ?>">0</dd></div>
          <div><dt>Source</dt><dd>7 files · 3 agencies</dd></div>
        </dl>
      </div>
      <p class="bdh-sr" role="status" aria-live="polite" data-cbs-inv-sr>Showing the audit: <?= $cbs_inv_found ?> component variants found.</p>

      <div class="cbs-inv__cols">
        <?php foreach ($cbs_inv_groups as $cbs_gi => $cbs_g): ?>
          <div class="cbs-inv__col cbs-inv__col--<?= e($cbs_g[0]) ?>">
            <h3 class="cbs-inv__h"><?= e($cbs_g[1]) ?></h3>
            <p class="cbs-inv__n num"><span class="cbs-inv__a"><?= $cbs_g[2] ?> found</span><span class="cbs-inv__b"><?= $cbs_g[2] ?> → <?= $cbs_g[3] ?></span></p>
            <div class="cbs-inv__canon" data-cbs-inv-canon aria-hidden="true">
              <span class="cbs-inv__mock cbs-inv__mock--<?= e($cbs_g[0]) ?>" style="--f:var(--blue);--r:10px"><i></i><i></i></span>
              <span class="cbs-inv__cl"><?= e($cbs_g[4]) ?></span>
            </div>
            <div class="cbs-inv__pile" aria-hidden="true">
              <?php for ($cbs_t = 0; $cbs_t < 8; $cbs_t++):
                $cbs_f = $cbs_inv_fills[($cbs_gi * 5 + $cbs_t * 3) % count($cbs_inv_fills)];
                $cbs_rr = $cbs_inv_radii[($cbs_gi * 2 + $cbs_t * 5) % count($cbs_inv_radii)];
                $cbs_w = 62 + (($cbs_gi * 11 + $cbs_t * 17) % 38); ?>
                <span class="cbs-inv__tile" data-cbs-inv-tile style="--i:<?= $cbs_t ?>;--f:<?= $cbs_f ?>;--r:<?= $cbs_rr ?>px;--w:<?= $cbs_w ?>%">
                  <span class="cbs-inv__mock cbs-inv__mock--<?= e($cbs_g[0]) ?>"><i></i><i></i></span>
                </span>
              <?php endfor; ?>
              <span class="cbs-inv__gone"><?= $cbs_g[2] - $cbs_g[3] ?> retired</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="cbs-inv__split">
        <p><b>Agent</b>Clusters near-duplicates by look, props and where they are used, and proposes a canonical for each cluster.</p>
        <p><b>People</b>Designers and engineers choose the canonical, name it, and decide which differences are real variants.</p>
        <span class="cbs-note">Counts illustrative</span>
      </div>
    </div>
  </div>
</section>
