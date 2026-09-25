<?php /* DRAFT COPY — review before launch */
/* Navigator — one index of the eight capabilities. The capability subpages do not exist yet, so every
   tile links to that capability's card on this page (#<slug>), never to a file. Names and one-line
   descriptions come straight from data/site.php (the client's approved copy); the three headline
   deliverables and the typical length come from data/campaign-content.php. Each tile carries the loop
   stage it belongs to and a small code-built glyph of that capability's signature. */
$nav_glyph = [
    /* 64 × 40, stroke currentColor — a pillar with its clusters, feeds, a broadcast, creators,
       the auction, a route, master artwork and sized adaptations, a production globe */
    'content-marketing'               => '<rect x="3" y="4" width="26" height="8" rx="2"/><rect class="a" x="3" y="16" width="18" height="6" rx="2"/><rect class="a" x="3" y="26" width="22" height="6" rx="2"/><path class="w" pathLength="1" d="M38 8h20M38 19h14M38 30h18"/>',
    'social-media-marketing'          => '<rect x="3" y="5" width="16" height="30" rx="2.5"/><rect x="24" y="9" width="16" height="22" rx="2.5"/><rect class="a" x="45" y="13" width="16" height="14" rx="2.5"/>',
    'public-relations'                => '<circle class="a" cx="14" cy="20" r="4"/><path class="w" pathLength="1" d="M24 11a13 13 0 0 1 0 18M33 5a21 21 0 0 1 0 30M42 1.5a28 28 0 0 1 0 37"/>',
    'social-influencer-activation'    => '<circle cx="11" cy="20" r="6"/><circle class="a" cx="30" cy="20" r="6"/><circle cx="49" cy="20" r="6"/><path class="w" pathLength="1" d="M17 20h7M36 20h7"/>',
    'performance-marketing'           => '<rect x="4" y="24" width="7" height="12" rx="1.5"/><rect x="16" y="18" width="7" height="18" rx="1.5"/><rect x="28" y="21" width="7" height="15" rx="1.5"/><rect class="a" x="40" y="10" width="7" height="26" rx="1.5"/><path class="w" pathLength="1" d="M4 16 22 9l14 6 22-6"/>',
    'omnichannel-marketing-strategy'  => '<circle cx="6" cy="30" r="3"/><circle cx="24" cy="12" r="3"/><circle cx="40" cy="28" r="3"/><circle class="a" cx="58" cy="10" r="3"/><path class="w" pathLength="1" d="M9 30h6l6-15M27 14l10 12M43 27l11-15"/>',
    'campaign-design-systems'         => '<rect x="3" y="5" width="24" height="30" rx="2.5"/><rect class="a" x="33" y="5" width="12" height="12" rx="2"/><rect class="a" x="33" y="22" width="28" height="7" rx="2"/><rect class="a" x="50" y="5" width="11" height="12" rx="2"/>',
    'global-content-production'       => '<circle cx="20" cy="20" r="15"/><path d="M5 20h30M20 5a20 20 0 0 1 0 30 20 20 0 0 1 0-30"/><path class="a" d="M44 12h14v16H44z"/><path class="a" d="m58 17 5-3v12l-5-3"/>',
];
$nav_rows = [];
foreach (array_values($CAPS) as $nav_i => $nav_c) {
    $nav_rows[] = [
        'c'     => $nav_c,
        'line'  => $DISC['caps'][$nav_i][1],
        'stage' => $CCH['stages'][$CCH['stage_of'][$nav_c['slug']]],
        'del'   => array_slice($nav_c['deliver'], 0, 3),
        'len'   => $nav_c['meta'][0],
        'lenk'  => $nav_c['meta_k'][0],
    ];
}
?>
<section class="band band--alt cch-navigator" id="navigator" aria-labelledby="navigator-t">
  <div class="wrap">
    <div class="cch-nav__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The capabilities</p>
        <h2 class="h2" id="navigator-t"><span class="g">Eight capabilities,</span> one loop.</h2>
      </div>
      <div class="cch-nav__intro">
        <p class="lead">Each one sits on a stage of the same loop, and each is bought on its own or as part of a season. Every card below opens in full further down this page.</p>
      </div>
      <ul class="cch-nav__legend" aria-label="The four stages of the loop">
        <?php foreach ($CCH['stages'] as $nav_sk => $nav_s): ?>
          <li><span class="cch-stg" data-stage="<?= e($nav_sk) ?>"><b><?= e($nav_s['code']) ?></b><?= e($nav_s['name']) ?></span><span><?= e($nav_s['lbl']) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- PLACEHOLDER: the typical lengths below are ranges from data/campaign-content.php — confirm before launch -->
    <ol class="cch-nav__grid" data-rv-s data-rv-step="50">
      <?php foreach ($nav_rows as $nav_row): $nav_c = $nav_row['c']; ?>
        <li class="cch-nav__cell">
          <a class="cch-nav__tile" href="#<?= e($nav_c['slug']) ?>" data-cap="<?= e($nav_c['slug']) ?>">
            <span class="cch-nav__top">
              <span class="cch-nav__n"><?= e($nav_c['n']) ?></span>
              <span class="cch-stg" data-stage="<?= e($CCH['stage_of'][$nav_c['slug']]) ?>"><b><?= e($nav_row['stage']['code']) ?></b><?= e($nav_row['stage']['name']) ?></span>
            </span>
            <span class="cch-nav__art" aria-hidden="true">
              <span class="cch-nav__ico"><?= xt_icon($nav_c['icon'], ['size' => 22]) ?></span>
              <svg class="cch-nav__glyph" viewBox="0 0 64 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?= $nav_glyph[$nav_c['slug']] ?></svg>
            </span>
            <h3 class="cch-nav__t"><?= e($nav_c['name']) ?></h3>
            <p class="cch-nav__d"><?= e($nav_row['line']) ?></p>
            <span class="cch-nav__del">
              <span class="cch-k">What you get</span>
              <?php foreach ($nav_row['del'] as $nav_d): ?>
                <span class="cch-nav__di"><i aria-hidden="true"></i><b><?= e($nav_d[0]) ?></b></span>
              <?php endforeach; ?>
            </span>
            <span class="cch-nav__foot">
              <span class="cch-nav__len"><span class="cch-k"><?= e($nav_row['lenk']) ?></span><b><?= e($nav_row['len']) ?></b></span>
              <span class="cch-nav__go">Read it in full <i aria-hidden="true">›</i></span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
