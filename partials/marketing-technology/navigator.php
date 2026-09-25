<?php /* DRAFT COPY — review before launch */
/* Navigator — one index of the seven capabilities. Names and one-liners come straight from data/site.php
   (the client's approved copy). The seven capability pages are not built yet, so every tile links to that
   capability's card further down this page (#<slug>) — never to a file that does not exist. Each tile
   carries the loop stage it leads, a mini glyph of its signature, its three headline deliverables and its
   typical first release. No JavaScript: the tiles are links and the glyphs animate on hover and focus. */
$nav_rows = [];
foreach (array_values($CAPS) as $nav_i => $nav_c) {
    $nav_sk = $MTH['stage_of'][$nav_c['slug']];
    $nav_rows[] = [
        'c'     => $nav_c,
        'line'  => $DISC['caps'][$nav_i][1],
        'stage' => $MTH['stages'][$nav_sk],
        'href'  => ($MTH['cap_href'])($nav_c['slug']),
        /* the seventh capability spans two columns, so it can show more of what it hands over */
        'del'   => array_slice($nav_c['deliver'], 0, $nav_c['slug'] === 'customer-relationship-strategy' ? 6 : 3),
        'wide'  => $nav_c['slug'] === 'customer-relationship-strategy',
        'parts' => $nav_c['slug'] === 'customer-relationship-strategy' ? array_map(fn ($nav_o) => $nav_o[0], $nav_c['offer']) : [],
        'len'   => $nav_c['meta'][0],
        'lenk'  => $nav_c['meta_k'][0],
    ];
}
/* mini glyphs, 64 × 40 — one per capability signature */
$nav_glyph = [
    'ai-driven-marketing-automation' => '<rect class="b" x="2" y="14" width="15" height="12" rx="3"/><rect class="b b2" x="47" y="3" width="15" height="12" rx="3"/><rect class="b b3 a" x="47" y="25" width="15" height="12" rx="3"/><path class="w" pathLength="1" d="M17 20h13v-11h17M17 20h13v11h17"/>',
    'content-communication-infrastructure' => '<rect class="b" x="2" y="12" width="17" height="16" rx="3"/><path class="w" pathLength="1" d="M19 20h10M29 20V6h12M29 20v14h12M29 20h12"/><circle class="d d1" cx="45" cy="6" r="3"/><circle class="d d2 a" cx="45" cy="20" r="3"/><circle class="d d3" cx="45" cy="34" r="3"/>',
    'ai-campaign-optimization' => '<rect class="r r1" x="4" y="24" width="8" height="13" rx="1.5"/><rect class="r r2" x="18" y="18" width="8" height="19" rx="1.5"/><rect class="r r3" x="32" y="22" width="8" height="15" rx="1.5"/><rect class="r r4" x="46" y="12" width="8" height="25" rx="1.5"/><path class="w a" pathLength="1" d="M6 18 22 11l14 5 14-8"/>',
    'ai-creative-solutions' => '<rect class="t t1" x="3" y="4" width="20" height="14" rx="2"/><rect class="t t2" x="3" y="22" width="12" height="14" rx="2"/><rect class="t t3" x="19" y="22" width="16" height="14" rx="2"/><rect class="t t4 a" x="27" y="4" width="34" height="14" rx="2"/><rect class="t t5" x="39" y="22" width="22" height="14" rx="2"/>',
    'ai-lead-generation' => '<path class="w" d="M4 6h56L38 22v13l-12 5V22z"/><circle class="d d1" cx="14" cy="3" r="2.4"/><circle class="d d2" cx="32" cy="3" r="2.4"/><circle class="d d3" cx="50" cy="3" r="2.4"/><circle class="d d4 a" cx="32" cy="36" r="3"/>',
    'automated-dynamic-sales' => '<rect class="s s1" x="2" y="15" width="13" height="10" rx="2"/><rect class="s s2" x="19" y="15" width="13" height="10" rx="2"/><rect class="s s3" x="36" y="15" width="13" height="10" rx="2"/><path class="w" pathLength="1" d="M15 20h4M32 20h4"/><path class="c a" pathLength="1" d="m52 20 3 3 6-8"/>',
    'customer-relationship-strategy' => '<circle class="h" cx="32" cy="20" r="6"/><circle class="p p1" cx="32" cy="4" r="3.2"/><circle class="p p2" cx="47" cy="12" r="3.2"/><circle class="p p3 a" cx="47" cy="29" r="3.2"/><circle class="p p4" cx="17" cy="29" r="3.2"/><circle class="p p5" cx="17" cy="12" r="3.2"/><path class="w" pathLength="1" d="M32 14V7M37 17l7-3.5M37 23l7 3.5M27 23l-7 3.5M27 17l-7-3.5"/>',
];
?>
<section class="band mth-navigator" id="navigator" aria-labelledby="navigator-t">
  <div class="wrap">
    <div class="mth-nav__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The capabilities</p>
        <h2 class="h2" id="navigator-t"><span class="g">Seven capabilities,</span> one system.</h2>
      </div>
      <div class="mth-nav__side">
        <p class="lead">Each one earns its place by closing a gap in the same loop: collect, resolve, decide, produce, activate, measure. Buy one, or connect them in the order that pays first.</p>
        <p class="mth-note"><b>Customer Relationship Strategy is one capability, not five.</b> Journey mapping, segmentation and insight, engagement programmes, loyalty and lifecycle marketing are the five parts of a single practice, sold, built and measured together.</p>
      </div>
    </div>

    <ul class="mth-nav__legend" aria-label="The six stages of the customer loop">
      <?php foreach ($MTH['stages'] as $nav_s): ?>
        <li><b><?= e($nav_s['code']) ?></b><?= e($nav_s['name']) ?></li>
      <?php endforeach; ?>
    </ul>

    <!-- PLACEHOLDER: the typical first-release ranges below come from data/marketing-technology.php — confirm before launch -->
    <ol class="mth-nav__grid" data-rv-s data-rv-step="50">
      <?php foreach ($nav_rows as $nav_r): $nav_c = $nav_r['c']; ?>
        <li class="mth-nav__cell<?= $nav_r['wide'] ? ' mth-nav__cell--wide' : '' ?>">
          <a class="mth-nav__tile<?= $nav_r['wide'] ? ' mth-nav__tile--wide' : '' ?>" href="<?= e($nav_r['href']) ?>" data-cap="<?= e($nav_c['slug']) ?>">
            <span class="mth-nav__top">
              <span class="mth-nav__n"><?= e($nav_c['n']) ?></span>
              <span class="mth-nav__stage"><?= e($nav_r['stage']['code']) ?> · <?= e($nav_r['stage']['name']) ?></span>
            </span>
            <span class="mth-nav__art" aria-hidden="true">
              <span class="mth-nav__ico"><?= xt_icon($nav_c['icon'], ['size' => 22]) ?></span>
              <svg class="mth-nav__glyph mth-nav__glyph--<?= e($nav_c['slug']) ?>" viewBox="0 0 64 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?= $nav_glyph[$nav_c['slug']] ?></svg>
            </span>
            <span class="mth-nav__say">
              <h3 class="mth-nav__t"><?= e($nav_c['name']) ?></h3>
              <p class="mth-nav__d"><?= e($nav_r['line']) ?></p>
              <?php if ($nav_r['parts']): ?>
                <span class="mth-nav__parts">
                  <span class="mth-k">The five parts, plus the measurement that keeps them in step</span>
                  <span class="bdh-tags"><?php foreach ($nav_r['parts'] as $nav_p): ?><span class="bdh-tag"><?= e($nav_p) ?></span><?php endforeach; ?></span>
                </span>
              <?php endif; ?>
            </span>
            <span class="mth-nav__del">
              <span class="mth-k">What you get</span>
              <?php foreach ($nav_r['del'] as $nav_d): ?>
                <span class="mth-nav__di"><i aria-hidden="true"></i><b><?= e($nav_d[0]) ?></b></span>
              <?php endforeach; ?>
            </span>
            <span class="mth-nav__foot">
              <span class="mth-nav__len"><span class="mth-k"><?= e($nav_r['lenk']) ?></span><b><?= e($nav_r['len']) ?></b></span>
              <span class="mth-nav__go">See what it covers <i aria-hidden="true">›</i></span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
