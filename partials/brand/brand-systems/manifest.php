<?php /* DRAFT COPY — review before launch */
/* 03 · The six offer items as a package manifest. Each $CAP['offer'] item is a package with a
   version and the packages it requires; arcs in the left gutter draw the dependencies.
   Versions are illustrative. PLACEHOLDER: confirm before launch */
$cbs_mf_pkgs = [   // [package name, version, requires (offer indexes)] — same order as $CAP['offer']
    ['tokens',     '2.4.0', []],
    ['components', '2.4.0', [0]],
    ['templates',  '1.8.0', [0, 1]],
    ['flex-rules', '1.2.0', [0, 2]],
    ['governance', '1.0.0', [0, 1, 2, 3]],
    ['docs',       '2.4.0', [1, 2, 3, 4]],
];
?>
<section class="band cbs-mf" id="manifest" aria-labelledby="cbs-mf-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>03</b><i>/</i>what-we-build<i>/</i>manifest</p>
      <h2 class="cbs-head__h" id="cbs-mf-t"><?= $CAP['offer_title'] ?></h2>
      <p class="lead cbs-head__lead"><?= e($CAP['offer_lead']) ?> Six packages make up the system. Each one is versioned, and each one names what it depends on, so nobody has to guess what a change will touch.</p>
    </header>

    <div class="cbs-mf__box" data-cbs-mf>
      <p class="cbs-mf__cmd"><span class="cbs-mf__sh" aria-hidden="true">$</span><code data-cbs-mf-cmd>system install @yourbrand/system</code><i class="cbs-mf__caret" aria-hidden="true"></i></p>

      <div class="cbs-mf__cols" aria-hidden="true"><span>Package</span><span>What it is</span><span>Requires</span></div>

      <div class="cbs-mf__list-wrap">
        <svg class="cbs-mf__arcs" data-cbs-mf-arcs aria-hidden="true" focusable="false"></svg>
        <ol class="cbs-mf__list">
          <?php foreach ($CAP['offer'] as $cbs_oi => $cbs_o):
            $cbs_p = $cbs_mf_pkgs[$cbs_oi];
            $cbs_req = array_map(fn ($cbs_x) => $cbs_mf_pkgs[$cbs_x][0], $cbs_p[2]); ?>
            <li class="cbs-mf__row" data-cbs-mf-row data-deps="<?= e(implode(',', $cbs_p[2])) ?>" style="--i:<?= $cbs_oi ?>">
              <span class="cbs-mf__node" data-cbs-mf-node aria-hidden="true"></span>
              <div class="cbs-mf__pkg">
                <button type="button" class="cbs-mf__pick" aria-pressed="false" aria-describedby="cbs-mf-req-<?= $cbs_oi ?>">
                  <code>@yourbrand/<b><?= e($cbs_p[0]) ?></b></code><span class="cbs-mf__ver">@<?= e($cbs_p[1]) ?></span>
                </button>
                <span class="cbs-mf__ok" aria-hidden="true">installed</span>
              </div>
              <div class="cbs-mf__txt">
                <h3 class="cbs-mf__h"><?= e($cbs_o[0]) ?></h3>
                <p class="cbs-mf__d"><?= e($cbs_o[1]) ?></p>
              </div>
              <div class="cbs-mf__meta">
                <span class="cbs-tag cbs-tag--line"><?= e($cbs_o[2]) ?></span>
                <p class="cbs-mf__req" id="cbs-mf-req-<?= $cbs_oi ?>">
                  <?php if ($cbs_req): ?>
                    <span class="bdh-sr">Requires </span><?php foreach ($cbs_req as $cbs_rn): ?><code><?= e($cbs_rn) ?></code><?php endforeach; ?>
                  <?php else: ?>
                    <span class="cbs-mf__root">No dependencies · the root</span>
                  <?php endif; ?>
                </p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <p class="cbs-mf__sum"><span>6 packages · one source of truth</span><span>Select a package to trace what it depends on</span><span class="cbs-note">Versions illustrative</span></p>
    </div>
  </div>
</section>
