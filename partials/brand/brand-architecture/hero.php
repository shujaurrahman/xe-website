<?php /* DRAFT COPY — review before launch */
/* 1 · Hero — the page opens as one drawing sheet. Left: the portfolio constellation (nodes drift
   loose, then settle into a hierarchy and the connecting lines draw in). Right: the sheet's vertical
   title block, which carries the headline, the brief and the drawing data. Zone references run
   along the sheet edge. The HTML is the settled final state; hero.js scatters and re-settles it. */
$cba_nodes = [
    // id, label, role, x%, y% (settled), loose x%, loose y%, level
    ['mb', 'Master brand',  'Parent',    50, 16, 62, 70, 0],
    ['sa', 'Sub-brand A',   'Sub-brand', 15, 50, 30, 20, 1],
    ['sb', 'Sub-brand B',   'Sub-brand', 38, 50, 84, 34, 1],
    ['sc', 'Sub-brand C',   'Sub-brand', 62, 50, 14, 76, 1],
    ['sd', 'Sub-brand D',   'Sub-brand', 85, 50, 46, 44, 1],
    ['pc', 'Product C',     'Product',   62, 84, 88, 82, 2],
    ['ee', 'Endorsed E',    'Endorsed',  85, 84, 22, 46, 2],
];
$cba_links = [['mb', 'sa'], ['mb', 'sb'], ['mb', 'sc'], ['mb', 'sd'], ['sc', 'pc'], ['sd', 'ee']];
$cba_pos = [];
foreach ($cba_nodes as $cba_n) $cba_pos[$cba_n[0]] = [$cba_n[3], $cba_n[4]];
$cba_hub = xe_discipline_url($BRAND);
?>
<section class="cba-hero cba-paper" id="top" aria-labelledby="hero-t">
  <div class="wrap">
    <div class="cba-hero__sheet cba-hero__stage" data-cba-constellation>
      <span class="cba-sheet__x cba-sheet__x--tl" aria-hidden="true"></span><span class="cba-sheet__x cba-sheet__x--tr" aria-hidden="true"></span>
      <span class="cba-sheet__x cba-sheet__x--bl" aria-hidden="true"></span><span class="cba-sheet__x cba-sheet__x--br" aria-hidden="true"></span>
      <ol class="cba-hero__zones" aria-hidden="true"><?php for ($cba_z = 1; $cba_z <= 8; $cba_z++): ?><li><?= $cba_z ?></li><?php endfor; ?></ol>

      <div class="cba-hero__draw">
        <p class="cba-hero__cap cba-mono" aria-hidden="true"><span>A-100 · Portfolio · <b data-cba-state>Structured</b></span><span>7 nodes · 3 levels</span></p>
        <div class="cba-hero__plot" aria-hidden="true">
          <span class="cba-hero__lvl" style="--y:16%">L0</span><span class="cba-hero__lvl" style="--y:50%">L1</span><span class="cba-hero__lvl" style="--y:84%">L2</span>
          <svg class="cba-hero__lines" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false">
            <?php foreach ($cba_links as $cba_li => $cba_l2):
                [$cba_ax, $cba_ay] = $cba_pos[$cba_l2[0]]; [$cba_bx, $cba_by] = $cba_pos[$cba_l2[1]];
                if ($cba_l2[0] !== 'mb') $cba_ay += 13;   /* start below a sub-brand's label, never through it */
                $cba_my = ($cba_ay + $cba_by) / 2; ?>
              <path d="M<?= $cba_ax ?> <?= $cba_ay ?>V<?= $cba_my ?>H<?= $cba_bx ?>V<?= $cba_by ?>" style="--i:<?= $cba_li ?>"/>
            <?php endforeach; ?>
          </svg>
          <?php foreach ($cba_nodes as $cba_n): ?>
            <span class="cba-node cba-node--l<?= $cba_n[7] ?>" data-id="<?= $cba_n[0] ?>" style="--x:<?= $cba_n[3] ?>%;--y:<?= $cba_n[4] ?>%;--lx:<?= $cba_n[5] ?>%;--ly:<?= $cba_n[6] ?>%">
              <i></i><b><?= e($cba_n[1]) ?></b><small><?= e($cba_n[2]) ?></small>
            </span>
          <?php endforeach; ?>
        </div>
        <p class="cba-hero__north cba-mono" aria-hidden="true"><span class="cba-hero__bar"><i></i><i></i><i></i><i></i></span>Scale · one level per band</p>
        <p class="bdh-sr">Diagram: a master brand above four sub-brands, with Product C beneath Sub-brand C and Endorsed E beneath Sub-brand D. The nodes start scattered and settle into this hierarchy.</p>
      </div>

      <div class="cba-hero__strip">
        <nav class="cba-crumb cba-hero__cell cba-hero__up" style="--i:0" aria-label="Breadcrumb">
          <ol>
            <li><a href="<?= xe_url('services/') ?>">Services</a></li>
            <li><a href="<?= $cba_hub ?>"><?= e($BRAND['name']) ?></a></li>
            <li><span aria-current="page"><?= e($CBA_CAP['name']) ?></span></li>
          </ol>
        </nav>
        <div class="cba-hero__cell cba-hero__cell--title cba-hero__up" style="--i:1">
          <p class="cba-eb"><b>Capability <?= e($CBA_CAP['n']) ?></b><i aria-hidden="true"></i><?= e($CBA_CAP['kicker']) ?></p>
          <h1 class="cba-hero__h" id="hero-t"><?= $CBA_CAP['title'] ?></h1>
        </div>
        <div class="cba-hero__cell cba-hero__up" style="--i:2">
          <p class="lead cba-hero__lead"><?= e($CBA_CAP['lead']) ?></p>
          <div class="cba-hero__act">
            <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CBA_CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
            <a class="btn btn--out btn--lg" href="#spectrum">Try the model spectrum <span class="i" aria-hidden="true">›</span></a>
          </div>
        </div>
        <dl class="cba-hero__meta cba-hero__up" style="--i:3">
          <?php foreach ($CBA_CAP['meta'] as $cba_mi => $cba_mv): ?>
            <div><dt><?= e($CBA_CAP['meta_k'][$cba_mi]) ?></dt><dd><?= e($cba_mv) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <dl class="cba-tb cba-hero__tb cba-hero__up" style="--i:4" aria-hidden="true">
          <div><dt>Sheet</dt><dd>A-100</dd></div>
          <div><dt>Scale</dt><dd>1 : Portfolio</dd></div>
          <div><dt>Rev</dt><dd data-cba-rev>C</dd></div>
          <div class="cba-tb__wide"><dt>Drawing</dt><dd>Your brand · portfolio structure</dd></div>
        </dl>
      </div>
    </div>
  </div>
</section>
