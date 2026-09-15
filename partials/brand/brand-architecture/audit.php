<?php /* DRAFT COPY — review before launch */
/* 2 · Portfolio audit — every brand plotted by awareness (x) and role clarity (y), sized by share of
   revenue. Each node is a button; focus or click opens its role card. All figures Illustrative. */
/* PLACEHOLDER: illustrative portfolio data — confirm before launch */
$cba_audit = [
    // name, role, awareness, clarity, share %, run cost, finding, provisional read
    ['Master brand', 'Parent',       88, 82, 34, 'High',   'Carries trust for most of the portfolio.', 'Keep · anchor'],
    ['Sub-brand A',  'Sub-brand',    72, 70, 18, 'Medium', 'Clear role, strong recognition in Segment A.', 'Keep'],
    ['Sub-brand B',  'Sub-brand',    64, 28, 12, 'High',   'Known, but customers cannot say what it is for.', 'Clarify role'],
    ['Sub-brand C',  'Sub-brand',    38, 66, 9,  'Medium', 'Clear offer, little recognition outside Market 03.', 'Endorse'],
    ['Sub-brand D',  'Sub-brand',    46, 52, 8,  'Medium', 'Overlaps with Sub-brand A on two of three needs.', 'Merge candidate'],
    ['Product C',    'Product',      24, 74, 6,  'Low',    'Customers search for it by its descriptor, not its name.', 'Descriptor'],
    ['Endorsed E',   'Acquired',     60, 40, 7,  'High',   'Equity of its own; relationship to the parent unclear.', 'Endorse · review'],
    ['Label F',      'Label',        14, 22, 3,  'Medium', 'Low awareness, unclear role, separate identity to maintain.', 'Retire candidate'],
    ['Range G',      'Range',        30, 36, 3,  'Low',    'Named range that confuses the tier structure.', 'Fold into tiers'],
];
?>
<section class="band cba-audit" id="audit" aria-labelledby="audit-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-101</b><i aria-hidden="true"></i>Portfolio audit</p>
        <h2 class="h2" id="audit-t"><span class="g">Before any model,</span> a survey of what stands.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer'][0][1]) ?> Each brand is plotted by how well it is known and how clearly customers understand its role.</p>
      </div>
    </div>

    <div class="cba-audit__grid" data-cba-audit>
      <div class="cba-audit__chart cba-sheet" data-rv>
        <span class="cba-sheet__x cba-sheet__x--tl" aria-hidden="true"></span><span class="cba-sheet__x cba-sheet__x--br" aria-hidden="true"></span>
        <div class="cba-audit__top">
          <p class="cba-mono cba-mono--ink">Portfolio · 9 brands · sized by share of revenue</p>
          <span class="cba-illus">Illustrative</span>
        </div>
        <div class="cba-audit__plot">
          <span class="cba-audit__q cba-audit__q--1" aria-hidden="true">Known · clear role</span>
          <span class="cba-audit__q cba-audit__q--2" aria-hidden="true">Clear role · little known</span>
          <span class="cba-audit__q cba-audit__q--3" aria-hidden="true">Little known · unclear</span>
          <span class="cba-audit__q cba-audit__q--4" aria-hidden="true">Known · unclear role</span>
          <span class="cba-audit__ax cba-audit__ax--x" aria-hidden="true">Awareness →</span>
          <span class="cba-audit__ax cba-audit__ax--y" aria-hidden="true">Role clarity →</span>
          <ul class="cba-audit__nodes" role="list" aria-label="Brands in the portfolio">
            <?php foreach ($cba_audit as $cba_ai => $cba_a): ?>
              <li style="--x:<?= $cba_a[2] ?>;--y:<?= $cba_a[3] ?>;--s:<?= $cba_a[4] ?>;--i:<?= $cba_ai ?>">
                <button type="button" class="cba-audit__node<?= $cba_ai === 0 ? ' is-on' : '' ?>" data-i="<?= $cba_ai ?>" aria-pressed="<?= $cba_ai === 0 ? 'true' : 'false' ?>" aria-controls="audit-card" aria-label="<?= e($cba_a[0]) ?>">
                  <span class="cba-audit__dot" aria-hidden="true"></span>
                  <span class="cba-audit__name" aria-hidden="true"><?= e($cba_a[0]) ?></span>
                  <span class="cba-audit__num" aria-hidden="true"><?= sprintf('%02d', $cba_ai + 1) ?></span>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <aside class="cba-audit__side">
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own imagery before launch -->
        <figure class="cba-plate cba-audit__photo" data-rv>
          <img src="<?= xe_url('assets/imgs/brand/brand-architecture/shop-product-shelves.jpg') ?>" alt="Lit shelving lined with rows of unbranded products above a counter" width="900" height="1200" loading="lazy" decoding="async">
          <figcaption><b>Fig. 01</b>What the customer faces</figcaption>
        </figure>
        <article class="cba-audit__card" id="audit-card" aria-live="polite" data-rv>
          <?php $cba_a = $cba_audit[0]; ?>
          <p class="cba-mono">Role card · <span data-f="role"><?= e($cba_a[1]) ?></span></p>
          <h3 class="cba-audit__h" data-f="name"><?= e($cba_a[0]) ?></h3>
          <p class="cba-audit__find" data-f="find"><?= e($cba_a[6]) ?></p>
          <dl class="cba-audit__stats">
            <div><dt>Awareness</dt><dd data-f="aw"><?= $cba_a[2] ?></dd></div>
            <div><dt>Role clarity</dt><dd data-f="cl"><?= $cba_a[3] ?></dd></div>
            <div><dt>Revenue share</dt><dd data-f="sh"><?= $cba_a[4] ?>%</dd></div>
            <div><dt>Cost to run</dt><dd data-f="co"><?= e($cba_a[5]) ?></dd></div>
          </dl>
          <p class="cba-audit__read"><span class="cba-mono">Provisional read</span><b data-f="read"><?= e($cba_a[7]) ?></b></p>
          <p class="cba-audit__who"><span class="cba-mono cba-mono--blue">Agent</span> drafts the inventory from catalogues, sites and search data. <span class="cba-mono cba-mono--ink">People</span> confirm each role with the brand owners.</p>
        </article>
      </aside>
    </div>
    <script type="application/json" id="audit-data"><?= json_encode($cba_audit, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
