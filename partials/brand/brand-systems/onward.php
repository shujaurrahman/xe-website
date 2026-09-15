<?php /* DRAFT COPY — review before launch */
/* 13 · Onward — the other five capabilities as a dependency graph: what feeds Brand Systems and what
   reads from it. Pairs ($CAP['pairs']) are marked. Edges are drawn by onward.js on wide screens. */
$cbs_ow_rel = [   // slug => [column, relation label, why]
    'growth-strategy'    => [1, 'upstream',   'Decides which customers and markets the system has to serve.'],
    'brand-foundation'   => [2, 'upstream',   'Sets the principles the flex ranges are written from.'],
    'brand-identity'     => [3, 'upstream',   'Supplies the visual and verbal code that becomes tokens.'],
    'brand-architecture' => [3, 'upstream',   'Defines the sub-brands and products the system must hold.'],
    'brand-ai-tools'     => [5, 'downstream', 'Reads tokens and ranges to check and make content at scale.'],
];
$cbs_ow_edges = [['growth-strategy', 'brand-foundation'], ['brand-foundation', 'brand-identity'], ['brand-foundation', 'brand-architecture'], ['brand-identity', 'brand-systems'], ['brand-architecture', 'brand-systems'], ['brand-systems', 'brand-ai-tools']];
$cbs_ow_caps = [];
foreach ($BRAND['caps'] as $cbs_cap) { if (!empty($cbs_cap[2])) $cbs_ow_caps[$cbs_cap[2]] = $cbs_cap; }
$cbs_ow_cols = [1 => [], 2 => [], 3 => [], 5 => []];
foreach ($cbs_ow_rel as $cbs_slug => $cbs_rel) { if (isset($cbs_ow_caps[$cbs_slug])) $cbs_ow_cols[$cbs_rel[0]][] = $cbs_slug; }
?>
<section class="band cbs-ow" id="onward" aria-labelledby="cbs-ow-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>13</b><i>/</i>brand-design<i>/</i>dependencies</p>
      <h2 class="cbs-head__h" id="cbs-ow-t"><span class="g">What the system reads from,</span> and what reads from it.</h2>
      <p class="lead cbs-head__lead">Brand Systems sits in the middle of the Brand Design practice. Strategy, foundation, identity and architecture feed it; AI tooling runs on it. The two capabilities it pairs with most often are marked.</p>
    </header>

    <div class="cbs-ow__graph" data-cbs-ow data-edges="<?= e(json_encode($cbs_ow_edges)) ?>">
      <div class="cbs-ow__ws">
        <p><span class="cbs-ow__wsl">workspace</span><code>@yourbrand/brand-design</code></p>
        <a class="cbs-ow__back" href="<?= xe_discipline_url($BRAND) ?>"><span aria-hidden="true">‹</span> Back to <?= e($BRAND['name']) ?></a>
      </div>
      <svg class="cbs-ow__edges" data-cbs-ow-svg aria-hidden="true" focusable="false"></svg>

      <ol class="cbs-ow__cols">
        <?php foreach ([1, 2, 3, 4, 5] as $cbs_colno): ?>
          <li class="cbs-ow__col cbs-ow__col--<?= $cbs_colno ?>">
            <?php if ($cbs_colno === 4): ?>
              <div class="cbs-ow__node cbs-ow__node--self" data-cbs-ow-node="brand-systems">
                <span class="cbs-ow__pkg">@brand/systems</span>
                <p class="cbs-ow__h"><?= e($CAP['name']) ?></p>
                <span class="cbs-ow__rel">You are here · <?= e($CAP['n']) ?></span>
              </div>
            <?php else: foreach ($cbs_ow_cols[$cbs_colno] as $cbs_slug):
              $cbs_c = $cbs_ow_caps[$cbs_slug]; $cbs_r = $cbs_ow_rel[$cbs_slug];
              $cbs_pair = in_array($cbs_slug, $CAP['pairs'], true); ?>
              <a class="cbs-ow__node<?= $cbs_pair ? ' is-pair' : '' ?>" href="<?= xe_cap_url($BRAND, $cbs_c) ?>" data-cbs-ow-node="<?= e($cbs_slug) ?>">
                <span class="cbs-ow__pkg">@brand/<?= e(str_replace('brand-', '', $cbs_slug)) ?></span>
                <h3 class="cbs-ow__h"><?= e($cbs_c[0]) ?></h3>
                <span class="cbs-ow__why"><?= e($cbs_r[2]) ?></span>
                <span class="cbs-ow__rel"><?= e($cbs_r[1]) ?><?php if ($cbs_pair): ?><b>Pairs with Systems</b><?php endif; ?></span>
                <span class="cbs-ow__go" aria-hidden="true">›</span>
              </a>
            <?php endforeach; endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
