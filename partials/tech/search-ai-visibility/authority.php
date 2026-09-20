<?php /* DRAFT COPY — review before launch */
/* Authority (ink) — the citation network. The sources answer engines already draw on for a category
   are drawn as a network; a real range input scrubs a twelve-month timeline and the links from the
   placeholder company appear and thicken month by month. Each source belongs to one of four
   families, and the family decides the colour and dash of its edge and the outline of its node, so
   the legend beside the graph reads the drawing rather than captioning it — and each legend row is
   a filter that dims the other three. Every edge is trimmed at both ends in PHP (tsv_au_edge below)
   so no line is ever drawn through a label or through the centre circle's own text.
   Under the graph, a ledger names all nine sources with the month each one landed.
   authority.js drives the scrubber and autoplays it once while the section is on screen, stopping
   the moment anyone touches the control. The server-rendered state is month 12 — the complete
   picture — so the section reads with no JS.
   Source names are generic placeholders. Every figure is illustrative. */

/* [x, y, box width, label, family key, month the first link lands, weight at month 12 (1–3)] */
$tsv_au_nodes = [
    [150,  70, 150, 'Trade publication A', 'press',  1, 3],
    [285,  40, 150, 'Trade publication B', 'press',  5, 2],
    [425,  78, 136, 'Review site B',       'review', 2, 3],
    [480, 192, 132, 'Review site E',       'review', 7, 2],
    [432, 312, 146, 'Community forum C',   'comm',   3, 2],
    [300, 356, 146, 'Q&A community F',     'comm',   8, 1],
    [152, 330, 140, 'Analyst brief D',     'docs',   4, 3],
    [ 60, 236, 130, 'Open dataset G',      'docs',   9, 1],
    [ 74, 112, 140, 'Standards body H',    'docs',   6, 2],
];

/* Trim one edge at both ends: it leaves the centre circle (r 46) 4px clear and stops 6px short of
   the node's own rect, so a line never crosses a label or the circle's text.
   Returns [x1, y1, x2, y2] rounded to one decimal. */
$tsv_au_edge = static function (int $nx, int $ny, int $w): array {
    $cx = 280; $cy = 200; $r = 50; $pad = 6; $half = 17;
    $dx = $nx - $cx; $dy = $ny - $cy;
    $len = sqrt(($dx * $dx) + ($dy * $dy));
    if ($len < 1) { return [$cx, $cy, $nx, $ny]; }
    $x1 = $cx + ($dx / $len) * $r;
    $y1 = $cy + ($dy / $len) * $r;
    $tx = abs($dx) > 0.5 ? (($w / 2) + $pad) / abs($dx) : 1.0;
    $ty = abs($dy) > 0.5 ? ($half + $pad) / abs($dy) : 1.0;
    $t  = min(1.0, $tx, $ty);
    return [round($x1, 1), round($y1, 1), round($nx - ($dx * $t), 1), round($ny - ($dy * $t), 1)];
};

$tsv_au_fam = [
    'press'  => ['Trade press',  'Commentary and data your specialists actually have'],
    'review' => ['Review sites', 'Listings kept current, customers asked properly'],
    'comm'   => ['Communities',  'Answers from named engineers, not a brand account'],
    'docs'   => ['Docs & data',  'Reference material worth linking to on its own'],
];

/* the twelve-month readout: [sources linking, share of answer %, brand mentions per week].
   Share of answer is read off the same twelve-prompt, four-engine panel as sections 02 and 08, and
   lands at month 12 on the 31% the dashboard reports, so the three readings agree. */
$tsv_au_months = [
    ['00', 0, 3,  3],  ['01', 1, 4,  4],  ['02', 2, 6,  6],  ['03', 3, 9,  8],
    ['04', 4, 12, 11], ['05', 5, 15, 14], ['06', 6, 18, 17], ['07', 7, 21, 21],
    ['08', 8, 24, 24], ['09', 9, 26, 27], ['10', 9, 28, 29], ['11', 9, 30, 31],
    ['12', 9, 31, 34],
];

$tsv_au_work = [
    ['Digital PR with something to say', 'doc',
     'Pitches built on data we can actually show — our own benchmarks, a survey, an analysis of public filings. Journalists take the number, and the link comes with it.'],
    ['Named experts, on the record', 'users',
     'Your engineers and specialists quoted under their own names, with profiles that confirm who they are. Expert commentary is the cheapest authority most companies leave on the table.'],
    ['A review programme that asks everyone', 'check',
     'Reviews requested from every customer at the same moment in the lifecycle, never filtered for the happy ones. Review sites are among the most frequently cited sources in comparison answers.'],
    ['Presence where the questions are asked', 'chat',
     'Community and forum answers written by people who do the work, under their own accounts, answering the question rather than advertising. Disclosed affiliation, every time.'],
];
?>
<section class="band band--ink tsv-auth" id="authority" aria-labelledby="authority-t">
  <div class="wrap">

    <header class="tsv-head tsv-head--wide" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">06 · Authority</span><span>Citations &amp; mentions</span></p>
        <h2 class="h2" id="authority-t"><span class="g">Earn mentions</span> where answers look.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Answer engines do not invent their sources. They reach for the same handful of publications, review sites, communities and reference pages every time. Authority work is simply making sure you are in that set — earned, disclosed, and never bought.</p>
      </div>
    </header>

    <div class="tsv-net" data-tsv-net data-net-months="<?= e(json_encode($tsv_au_months, JSON_UNESCAPED_SLASHES)) ?>">

      <div class="tsv-net__side">
        <div class="tsv-net__read">
          <p class="tsv-net__mk">Month <b data-net-month>12</b> <span class="tsv-ill">Illustrative</span></p>
          <dl class="tsv-net__stats">
            <div><dt>Sources linking to you</dt><dd data-net-src>9</dd></div>
            <div><dt>Share of answer<small>12-prompt panel · 4 engines</small></dt><dd><span data-net-share>31</span>%</dd></div>
            <div><dt>Brand mentions / week</dt><dd data-net-men>34</dd></div>
          </dl>
        </div>

        <div class="tsv-net__ctrl">
          <label class="tsv-net__lab" for="authority-scrub">Timeline · drag or use the arrow keys</label>
          <input class="tsv-net__range" id="authority-scrub" type="range" min="0" max="12" step="1" value="12"
                 data-net-range aria-describedby="authority-scrub-h">
          <p class="tsv-net__ticks" aria-hidden="true"><span>Month 00</span><span>06</span><span>12</span></p>
          <p class="bdh-sr" id="authority-scrub-h">Moves an illustrative twelve-month timeline. As the month rises, more of the nine generic sources link to the placeholder company and the existing links thicken.</p>
        </div>

        <div class="tsv-net__famw">
          <p class="tsv-net__faml" id="authority-fam-l">Source families · select one to isolate it</p>
          <ul class="tsv-net__fam" role="list" data-net-fam>
            <?php foreach ($tsv_au_fam as $tsv_auk => $tsv_auf): ?>
              <li data-fam="<?= e($tsv_auk) ?>">
                <button type="button" class="tsv-net__famb" aria-pressed="false" data-fam-b="<?= e($tsv_auk) ?>">
                  <i aria-hidden="true"></i><b><?= e($tsv_auf[0]) ?></b><small><?= e($tsv_auf[1]) ?></small>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="tsv-net__graph">
        <div class="bdh-scroll-x mask-x tsv-net__scroll" tabindex="0" role="group" aria-label="Citation network, scroll sideways on a narrow screen">
        <svg viewBox="0 0 560 400" class="tsv-net__svg" role="img"
             aria-label="A citation network: the placeholder company at the centre, linked to nine generic sources — two trade publications, two review sites, two communities, an analyst brief, an open dataset and a standards body.">
          <g class="tsv-net__edges">
            <?php foreach ($tsv_au_nodes as $tsv_ann):
                $tsv_ae = $tsv_au_edge((int) $tsv_ann[0], (int) $tsv_ann[1], (int) $tsv_ann[2]); ?>
              <line class="tsv-net__e is-on" x1="<?= $tsv_ae[0] ?>" y1="<?= $tsv_ae[1] ?>" x2="<?= $tsv_ae[2] ?>" y2="<?= $tsv_ae[3] ?>"
                    style="--w:<?= (int) $tsv_ann[6] ?>"
                    data-m="<?= (int) $tsv_ann[5] ?>" data-w="<?= (int) $tsv_ann[6] ?>" data-fam="<?= e($tsv_ann[4]) ?>"/>
            <?php endforeach; ?>
          </g>
          <g class="tsv-net__nodes">
            <?php foreach ($tsv_au_nodes as $tsv_ann):
                $tsv_anw = (int) $tsv_ann[2]; ?>
              <g class="tsv-net__n is-on" transform="translate(<?= (int) $tsv_ann[0] ?>,<?= (int) $tsv_ann[1] ?>)"
                 data-m="<?= (int) $tsv_ann[5] ?>" data-fam="<?= e($tsv_ann[4]) ?>">
                <rect x="<?= -intdiv($tsv_anw, 2) ?>" y="-17" width="<?= $tsv_anw ?>" height="34" rx="8"/>
                <text text-anchor="middle" y="4"><?= e($tsv_ann[3]) ?></text>
              </g>
            <?php endforeach; ?>
          </g>
          <g class="tsv-net__c" transform="translate(280,200)">
            <circle r="46"/>
            <text text-anchor="middle" y="-2">Your</text>
            <text text-anchor="middle" y="14">company</text>
          </g>
        </svg>
        </div>

        <?php
          $tsv_au_led = $tsv_au_nodes;
          usort($tsv_au_led, static fn ($a, $b) => $a[5] <=> $b[5]);
        ?>
        <ol class="tsv-net__ledger" role="list">
          <?php foreach ($tsv_au_led as $tsv_al): ?>
            <li class="tsv-net__led is-on" data-fam="<?= e($tsv_al[4]) ?>" data-m="<?= (int) $tsv_al[5] ?>">
              <i aria-hidden="true"></i>
              <b><?= e($tsv_al[3]) ?></b>
              <span><?= e($tsv_au_fam[$tsv_al[4]][0]) ?> · linked month <?= str_pad((string) $tsv_al[5], 2, '0', STR_PAD_LEFT) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

    </div>

    <div class="tsv-auth__foot">
      <ul class="tsv-work" role="list" data-rv data-bdh-stagger>
        <?php foreach ($tsv_au_work as $tsv_aw): ?>
          <li class="bdh-card bdh-card--ink tsv-work__c">
            <span class="tsv-work__i"><?= xt_icon($tsv_aw[1], ['size' => 22]) ?></span>
            <h3 class="bdh-t"><?= e($tsv_aw[0]) ?></h3>
            <p class="bdh-d"><?= e($tsv_aw[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="tsv-note tsv-auth__note" data-rv>
        <?= xt_icon('shield', ['size' => 18]) ?>
        <span><b>What we will not do.</b> No paid links, no link exchanges, no private blog networks, no guest posts written to place an anchor. Google’s spam policies treat link schemes as manipulative, and a manual action costs more than the links were ever worth. Every placement here is earned by having something worth publishing, and paid or sponsored placements are marked as such.</span>
      </p>
    </div>

  </div>
</section>
