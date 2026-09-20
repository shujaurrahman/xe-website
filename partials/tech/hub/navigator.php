<?php /* DRAFT COPY — review before launch */
/* Navigator — one index of the ten capabilities, each a real link to its page. Names and one-liners come
   straight from data/site.php (approved copy). Each tile carries its layer and a mini glyph of that page's
   signature that animates once on hover or focus. A desktop dock of the same ten links appears while the
   reader is between the index and the end of #platform (navigator.js). */
$nav_layer_i = array_flip(array_keys($TIH['layers']));
$nav_caps = [];
foreach (array_values($TI) as $nav_idx => $nav_c) {
    $nav_lk = $TIH['layer_of'][$nav_c['slug']];
    $nav_caps[] = [
        'c'     => $nav_c,
        'line'  => $TECH['caps'][$nav_idx][1],
        'layer' => $TIH['layers'][$nav_lk],
        'url'   => xe_url('services/technology-intelligence/' . $nav_c['slug'] . '.php'),
        /* the three headline deliverables and the typical length, straight from the capability's own data */
        'del'   => array_slice($nav_c['deliver'], 0, 3),   // [item, format] — the hub prints the item, the capability page the format
        'len'   => $nav_c['meta'][0],
        'lenk'  => $nav_c['meta_k'][0],
    ];
}
/* mini glyphs, 64 × 40, one per capability signature */
$nav_glyph = [
    'websites-apps' => '<path class="t" d="M12 34a20 20 0 0 1 40 0"/><path class="f" pathLength="1" d="M12 34a20 20 0 0 1 40 0"/><path class="n" d="M32 34 42 22"/><circle class="k" cx="32" cy="34" r="2"/>',
    'custom-software-data-platforms' => '<rect x="4" y="4" width="18" height="12" rx="2.5"/><rect x="42" y="4" width="18" height="12" rx="2.5"/><rect class="a" x="23" y="25" width="18" height="12" rx="2.5"/><path class="w" pathLength="1" d="M13 16v5h19v4M51 16v5H32"/>',
    'ai-strategy-agents' => '<path class="t" d="M10 20h44"/><circle class="s s1" cx="10" cy="20" r="5"/><circle class="s s2" cx="32" cy="20" r="5"/><circle class="s s3" cx="54" cy="20" r="5"/>',
    'ai-product-automation' => '<rect x="4" y="5" width="30" height="30" rx="3"/><path class="l l1" d="M10 13h18"/><path class="l l2 a" d="M10 20h14"/><path class="l l3" d="M10 27h16"/><path class="a sp" d="M50 9l2.4 6.6L59 18l-6.6 2.4L50 27l-2.4-6.6L41 18l6.6-2.4z"/>',
    'ai-infrastructure-cloud' => '<path class="t" d="M4 36h56"/><rect class="b b1" x="8" y="18" width="7" height="18" rx="1.5"/><rect class="b b2" x="19" y="10" width="7" height="26" rx="1.5"/><rect class="b b3 a" x="30" y="6" width="7" height="30" rx="1.5"/><rect class="b b4" x="41" y="14" width="7" height="22" rx="1.5"/><rect class="b b5" x="52" y="22" width="7" height="14" rx="1.5"/>',
    'cybersecurity-ai-trust' => '<circle cx="32" cy="20" r="17"/><circle class="t" cx="32" cy="20" r="9"/><g class="sw"><path class="a" d="M32 20 44 8"/></g><circle class="k" cx="40" cy="26" r="2"/>',
    'integration-support' => '<rect x="3" y="13" width="14" height="14" rx="3"/><rect x="47" y="13" width="14" height="14" rx="3"/><path class="t" d="M17 20h30"/><circle class="pk" cx="22" cy="20" r="3"/>',
    'search-ai-visibility' => '<rect class="r r1" x="4" y="5" width="44" height="7" rx="2"/><rect class="r r2" x="4" y="16.5" width="36" height="7" rx="2"/><rect class="r r3 a" x="4" y="28" width="40" height="7" rx="2"/><circle class="k" cx="56" cy="31.5" r="3"/>',
    'audits-assessments' => '<path class="c c1" pathLength="1" d="M5 9l3 3 5-6"/><path class="c c2" pathLength="1" d="M5 21l3 3 5-6"/><path class="c c3 a" pathLength="1" d="M5 33l3 3 5-6"/><path class="t" d="M20 9h38M20 21h30M20 33h34"/>',
    'tech-workforce' => '<circle class="p p1" cx="11" cy="20" r="7"/><circle class="p p2" cx="25" cy="20" r="7"/><circle class="p p3 a" cx="39" cy="20" r="7"/><circle class="p p4" cx="53" cy="20" r="7"/>',
];
?>
<section class="band tih-navigator" id="navigator" aria-labelledby="navigator-t">
  <div class="wrap">
    <div class="tih-nav__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The capabilities</p>
        <h2 class="h2" id="navigator-t"><span class="g">Ten capabilities,</span> one index.</h2>
      </div>
      <ul class="tih-nav__legend" aria-label="Platform layers">
        <?php foreach ($TIH['layers'] as $nav_l): ?>
          <li><b><?= e($nav_l['code']) ?></b><?= e($nav_l['name']) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- PLACEHOLDER: typical lengths below are ranges from data/technology-intelligence.php — confirm before launch -->
    <ol class="tih-nav__grid" data-rv-s data-rv-step="50">
      <?php foreach ($nav_caps as $nav_row): $nav_c = $nav_row['c']; ?>
        <li class="tih-nav__cell">
          <a class="tih-nav__tile" href="<?= $nav_row['url'] ?>" data-cap="<?= e($nav_c['slug']) ?>">
            <span class="tih-nav__top">
              <span class="tih-nav__n"><?= e($nav_c['n']) ?></span>
              <span class="tih-nav__layer"><?= e($nav_row['layer']['code']) ?> · <?= e($nav_row['layer']['name']) ?></span>
            </span>
            <span class="tih-nav__art" aria-hidden="true">
              <span class="tih-nav__ico"><?= xt_icon($nav_c['icon'], ['size' => 22]) ?></span>
              <svg class="tih-nav__glyph tih-nav__glyph--<?= e($nav_c['slug']) ?>" viewBox="0 0 64 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?= $nav_glyph[$nav_c['slug']] ?></svg>
            </span>
            <h3 class="tih-nav__t"><?= e($nav_c['name']) ?></h3>
            <p class="tih-nav__d"><?= e($nav_row['line']) ?></p>
            <span class="tih-nav__del">
              <span class="tih-k">What you get</span>
              <?php foreach ($nav_row['del'] as $nav_d): ?>
                <span class="tih-nav__di"><i aria-hidden="true"></i><b><?= e($nav_d[0]) ?></b></span>
              <?php endforeach; ?>
            </span>
            <span class="tih-nav__foot">
              <span class="tih-nav__len"><span class="tih-k"><?= e($nav_row['lenk']) ?></span><b><?= e($nav_row['len']) ?></b></span>
              <span class="tih-nav__go">Open capability <i aria-hidden="true">›</i></span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<div class="tih-dock-wrap">
<nav class="tih-dock" aria-label="Capability pages, quick links" inert>
  <div class="tih-dock__in">
    <span class="tih-dock__k" aria-hidden="true">Capabilities</span>
    <?php foreach ($nav_caps as $nav_row): ?>
      <a class="tih-dock__a" href="<?= $nav_row['url'] ?>"><b><?= e($nav_row['c']['n']) ?></b><?= e($nav_row['c']['short']) ?></a>
    <?php endforeach; ?>
  </div>
</nav>
</div>
