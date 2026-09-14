<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['growth-strategy'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/growth-strategy.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/growth-strategy.js'],
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

/* ---- the hero stage: an opportunity map that scores itself ---- */
$rank = [
    // seg key, full name, short name, score
    ['mid', 'Mid-market ops teams', 'Mid-market ops', 92],
    ['fdr', 'Founders, series A–B', 'Founders',       74],
    ['ent', 'Enterprise IT',        'Enterprise IT',  61],
    ['agy', 'Agencies',             'Agencies',       38],
];
ob_start(); ?>
<div class="bg-hero" data-bg-hero>
  <div class="bd-stage bg-map" data-bd-live data-bg-map>
    <div class="bd-stage__bar" aria-hidden="true">
      <span class="bd-stage__dots"><i></i><i></i><i></i></span>
      <span class="bd-stage__title">Opportunity map <i>›</i> next best customers</span>
      <span class="bd-stage__state"><i></i>scoring</span>
    </div>
    <div class="bd-stage__body bg-map__body">
      <div class="bg-map__plot" aria-hidden="true">
        <span class="bg-map__rule bg-map__rule--v"></span>
        <span class="bg-map__rule bg-map__rule--h"></span>
        <span class="bg-map__q bg-map__q--tl">Defend</span>
        <span class="bg-map__q bg-map__q--tr">Own</span>
        <span class="bg-map__q bg-map__q--bl">Ignore</span>
        <span class="bg-map__q bg-map__q--br">Watch</span>
        <span class="bg-map__ax bg-map__ax--y">Fit with the brand <i>›</i></span>
        <span class="bg-map__ax bg-map__ax--x">Size of the opening <i>›</i></span>
        <span class="bg-map__scan"></span>
        <i class="bg-map__dot" style="--x:14%;--y:63%;--d:.05s;--s:8px"></i>
        <i class="bg-map__dot" style="--x:37%;--y:41%;--d:.12s;--s:7px"></i>
        <i class="bg-map__dot" style="--x:44%;--y:80%;--d:.19s;--s:9px"></i>
        <i class="bg-map__dot" style="--x:90%;--y:55%;--d:.26s;--s:7px"></i>
        <i class="bg-map__dot" style="--x:22%;--y:79%;--d:.3s;--s:6px"></i>
        <i class="bg-map__dot bg-map__dot--named" data-seg="ent" style="--x:59%;--y:59%;--d:.36s;--s:11px"><b>Enterprise IT</b></i>
        <i class="bg-map__dot bg-map__dot--named" data-seg="agy" style="--x:79%;--y:75%;--d:.44s;--s:9px"><b class="is-l">Agencies</b></i>
        <i class="bg-map__dot bg-map__dot--named" data-seg="fdr" style="--x:27%;--y:24%;--d:.52s;--s:12px"><b>Founders</b></i>
        <i class="bg-map__dot bg-map__dot--named is-next" data-seg="mid" style="--x:71%;--y:21%;--d:.64s;--s:14px"></i>
        <span class="bg-map__call" style="--cx:71%;--cy:21%"><em>Next best</em><strong>Mid-market ops · 92</strong></span>
      </div>
      <div class="bg-map__rank">
        <p class="bg-map__rh"><span>Ranked segments</span><span>Score</span></p>
        <ul class="bg-map__list">
          <?php foreach ($rank as $i => $r): ?>
            <li>
              <button class="bg-map__row<?= $i === 0 ? ' is-top' : '' ?>" type="button" aria-pressed="false"
                      data-seg="<?= e($r[0]) ?>" data-short="<?= e($r[2]) ?>" data-score="<?= (int) $r[3] ?>" style="--i:<?= $i ?>">
                <span class="bg-map__n num" aria-hidden="true">0<?= $i + 1 ?></span>
                <span class="bg-map__nm"><?= e($r[1]) ?></span>
                <em class="bg-map__sc num"><span class="sr">score </span><span data-count="<?= (int) $r[3] ?>"><?= (int) $r[3] ?></span></em>
                <i class="bg-map__bar" aria-hidden="true"><b style="--w:<?= (int) $r[3] ?>%"></b></i>
              </button>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="bg-map__note" aria-hidden="true"><i></i>Scored on fit · reach · margin</p>
      </div>
    </div>
  </div>

  <!-- floating read-outs, drifting off the stage edges -->
  <div class="bg-float bg-float--a" aria-hidden="true">
    <p class="bg-float__l">Whitespace</p>
    <p class="bg-float__v"><b class="num">02</b><span>rows nobody serves</span></p>
    <span class="bg-float__rows"><i></i><i class="is-open"></i><i></i><i class="is-open"></i><i></i></span>
  </div>
  <div class="bg-float bg-float--b" aria-hidden="true">
    <p class="bg-float__l"><span>Interviews</span><span class="num">18 / 24</span></p>
    <span class="bg-float__pips"><?php for ($p = 0; $p < 24; $p++): ?><i<?= $p < 18 ? ' class="is-on"' : '' ?>></i><?php endfor; ?></span>
  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="growth">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · where growth comes from ===== -->
  <section class="band band--alt bg-explore" aria-labelledby="explore-t">
    <div class="wrap">
      <div class="head head--c bg-explore__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Where growth comes from</p>
        <h2 class="h2" id="explore-t"><span class="g">Segments, openings,</span> then moves</h2>
        <p class="lead">Three views of the same market. Each one narrows the last, until what is left is a sequence.</p>
      </div>

      <div class="bd-tabs bg-explore__panel" data-bd-tabs data-bd-auto="6500" data-rv data-rv-d="80">
        <div class="bd-tabs__rail" role="tablist" aria-label="Three views">
          <button class="bd-tabs__tab is-on" type="button" role="tab" id="bg-t0" aria-controls="bg-p0" aria-selected="true" data-bd-tab>
            <span class="bd-tabs__lbl">01 · Segments</span>
            <span class="bd-tabs__t">Who is most likely to buy next</span>
            <span class="bd-tabs__d">Every segment scored on fit, reach and margin. Loud is not the same as likely.</span>
            <span class="bd-tabs__bar" aria-hidden="true"><i></i></span>
          </button>
          <button class="bd-tabs__tab" type="button" role="tab" id="bg-t1" aria-controls="bg-p1" aria-selected="false" tabindex="-1" data-bd-tab>
            <span class="bd-tabs__lbl">02 · Openings</span>
            <span class="bd-tabs__t">Where nobody is looking</span>
            <span class="bd-tabs__d">Needs the category serves badly, or not at all. The rows with nothing in them.</span>
            <span class="bd-tabs__bar" aria-hidden="true"><i></i></span>
          </button>
          <button class="bd-tabs__tab" type="button" role="tab" id="bg-t2" aria-controls="bg-p2" aria-selected="false" tabindex="-1" data-bd-tab>
            <span class="bd-tabs__lbl">03 · Moves</span>
            <span class="bd-tabs__t">Now, next and later</span>
            <span class="bd-tabs__d">Each move with an owner, a measure and a date. The order is the strategy.</span>
            <span class="bd-tabs__bar" aria-hidden="true"><i></i></span>
          </button>
        </div>

        <div class="bd-tabs__stage">
          <!-- 01 segments -->
          <div class="bd-tabs__pane is-on" role="tabpanel" id="bg-p0" aria-labelledby="bg-t0" data-bd-pane>
            <div class="bg-seg" aria-hidden="true">
              <?php
              $segs = [
                  // name, score, fit, reach, margin, top, size (illustrative)
                  ['Mid-market ops teams', 92, 'high', 'high', 'high', true,  '1.4k accounts'],
                  ['Founders, series A–B', 74, 'high', 'mid',  'mid',  false, '6.2k accounts'],
                  ['Enterprise IT',        61, 'mid',  'low',  'high', false, '320 accounts'],
              ];
              foreach ($segs as $k => $s): ?>
                <div class="bg-seg__card<?= $s[5] ? ' is-top' : '' ?>">
                  <span class="bg-seg__rank num">0<?= $k + 1 ?></span>
                  <?php if ($s[5]): ?><span class="bg-seg__flag">Next best</span><?php endif; ?>
                  <span class="bg-seg__dial">
                    <svg class="bg-seg__ring" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="none" stroke="currentColor" stroke-width="3" opacity=".12"/><circle class="bg-seg__ringv" cx="24" cy="24" r="20" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" pathLength="100" stroke-dasharray="100" style="--off:<?= 100 - $s[1] ?>" transform="rotate(-90 24 24)"/></svg>
                    <span class="bg-seg__score num" data-bg-score="<?= $s[1] ?>"><?= $s[1] ?></span>
                  </span>
                  <span class="bg-seg__name"><?= e($s[0]) ?></span>
                  <span class="bg-seg__size"><?= e($s[6]) ?></span>
                  <span class="bg-seg__rows">
                    <i><span>Fit</span><b class="is-<?= $s[2] ?>"></b></i>
                    <i><span>Reach</span><b class="is-<?= $s[3] ?>"></b></i>
                    <i><span>Margin</span><b class="is-<?= $s[4] ?>"></b></i>
                  </span>
                </div>
              <?php endforeach; ?>
            </div>
            <p class="bd-tabs__note">Seven segments in. Three worth the effort.</p>
          </div>

          <!-- 02 openings -->
          <div class="bd-tabs__pane" role="tabpanel" id="bg-p1" aria-labelledby="bg-t1" data-bd-pane>
            <div class="bg-white" aria-hidden="true">
              <div class="bg-white__top">
                <span class="bg-white__t">Needs × competitors</span>
                <span class="bg-white__key"><span><i class="on"></i>Serves</span><span><i class="half"></i>Partly</span><span><i></i>Not at all</span></span>
              </div>
              <div class="bg-white__hd"><span>Customer need</span><span class="is-you">You</span><span>A</span><span>B</span><span>C</span><span>D</span></div>
              <div class="bg-white__row"><span>Speed to launch</span><i class="on"></i><i class="on"></i><i class="on"></i><i class="half"></i><i class="on"></i></div>
              <div class="bg-white__row is-open"><span>One system across markets</span><i class="on you"></i><i></i><i></i><i></i><i></i><b>open</b></div>
              <div class="bg-white__row"><span>Lowest price</span><i></i><i class="on"></i><i class="on"></i><i class="on"></i><i class="half"></i></div>
              <div class="bg-white__row is-open"><span>Owns the model</span><i class="on you"></i><i></i><i class="half"></i><i></i><i></i><b>open</b></div>
              <div class="bg-white__row"><span>Local presence</span><i class="on"></i><i class="on"></i><i></i><i class="on"></i><i class="on"></i></div>
            </div>
            <p class="bd-tabs__note">Two rows nobody serves. Both fit what the brand can claim.</p>
          </div>

          <!-- 03 moves -->
          <div class="bd-tabs__pane" role="tabpanel" id="bg-p2" aria-labelledby="bg-t2" data-bd-pane>
            <div class="bg-moves" aria-hidden="true">
              <div class="bg-moves__col is-now">
                <p class="bg-moves__h"><span class="bg-moves__live"></span><span class="bg-moves__nm">Now</span><i>Q3</i><em class="num">2</em></p>
                <div class="bg-moves__card">
                  <b>Launch the ops offer</b>
                  <span class="bg-moves__kv"><span>Owner</span><span>Growth lead</span><span>Measure</span><span>Qualified pipeline</span></span>
                  <span class="bg-moves__prog" style="--p:.62"><i></i></span>
                </div>
                <div class="bg-moves__card">
                  <b>One-system proof case</b>
                  <span class="bg-moves__kv"><span>Owner</span><span>Brand</span><span>Measure</span><span>Cited in 3 pitches</span></span>
                  <span class="bg-moves__prog" style="--p:.34"><i></i></span>
                </div>
              </div>
              <div class="bg-moves__col">
                <p class="bg-moves__h"><span class="bg-moves__nm">Next</span><i>Q4</i><em class="num">2</em></p>
                <div class="bg-moves__card">
                  <b>Founder programme</b>
                  <span class="bg-moves__kv"><span>Owner</span><span>Partnerships</span></span>
                </div>
                <div class="bg-moves__card">
                  <b>Owns-the-model campaign</b>
                  <span class="bg-moves__kv"><span>Owner</span><span>Campaign</span></span>
                </div>
              </div>
              <div class="bg-moves__col">
                <p class="bg-moves__h"><span class="bg-moves__nm">Later</span><i>Q1</i><em class="num">1</em></p>
                <div class="bg-moves__card bg-moves__card--gate">
                  <b>Enterprise IT pilot</b>
                  <span class="bg-moves__gate"><svg viewBox="0 0 12 12" width="11" height="11" fill="none"><rect x="2" y="5.2" width="8" height="5.6" rx="1.2" stroke="currentColor" stroke-width="1.2"/><path d="M4 5.2V3.8a2 2 0 0 1 4 0v1.4" stroke="currentColor" stroke-width="1.2"/></svg>Gate · two proof cases</span>
                </div>
              </div>
            </div>
            <p class="bd-tabs__note">Five moves. One owner each. The first ships this quarter.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== inside the six weeks · the working wall ===== -->
  <!-- PLACEHOLDER: section copy written for layout, confirm with the client. -->
  <?php
  $wall = [
      // x, y, side of the note, vertical anchor, weeks (gantt start/end columns), title, weeks label, note
      ['85%', '44%', 'l', 'm', 1, 3, 'Customer interviews', 'Wk 01–02', 'Buyers and lost deals, in their own words. Clustered by what they were trying to get done.'],
      ['58%', '63%', 'l', 'm', 3, 4, 'Segment scoring',     'Wk 03',    'Each cluster becomes a segment, scored on fit, reach and margin. The loud ones rarely win.'],
      ['41%', '81%', 'r', 'u', 4, 5, 'Whitespace map',      'Wk 04',    'Needs set against what competitors actually deliver. The empty rows get circled.'],
      ['71%', '16%', 'l', 'd', 5, 7, 'Move roadmap',        'Wk 05–06', 'Moves laid along the tape: now, next, later. Owners are written on before anyone leaves.'],
  ];
  $shots = [
      ['desk-research.jpg',      'An open notebook of handwritten research notes with reading glasses beside a laptop', 'Wk 01–02', 'Desk research',          'The category, the competitors and your own data, read before the first interview.'],
      ['customer-interview.jpg', 'A researcher taking notes across a desk from an interviewee',                          'Wk 01–02', 'Customer conversations', 'Buyers, lost deals and the people who talk to customers every day.'],
      ['leadership-session.jpg', 'A strategist presenting charts on a screen to a small leadership group',              'Wk 06',    'Leadership session',     'The thesis read aloud, challenged, then signed by the people who decide.'],
  ];
  ?>
  <section class="band bg-inside" aria-labelledby="inside-t">
    <div class="wrap">
      <div class="bg-inside__grid">
        <div class="bg-inside__text" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>Inside the six weeks</p>
          <h2 class="h2" id="inside-t"><span class="g">The wall comes first.</span> The deck comes last.</h2>
          <p class="lead">Most of the thinking happens in the room, on paper, with the people who talk to customers. Each pin marks a part of the wall and what it turns into.</p>

          <div class="bg-inside__ctl" data-bg-ctl>
            <p class="bg-inside__now" aria-live="off">
              <span class="bg-inside__idx num">01</span><span class="bg-inside__of num">/ 04</span>
              <span class="bg-inside__cur"><?= e($wall[0][6]) ?></span>
            </p>
            <span class="bg-inside__btns">
              <button class="bg-inside__btn" type="button" data-bg-step="-1" aria-label="Previous note"><span aria-hidden="true">‹</span></button>
              <button class="bg-inside__btn" type="button" data-bg-step="1" aria-label="Next note"><span aria-hidden="true">›</span></button>
            </span>
          </div>

          <div class="bg-gantt" aria-hidden="true">
            <div class="bg-gantt__ph"><span style="--a:1;--b:3">Discover</span><span style="--a:3;--b:5">Define</span><span style="--a:5;--b:7">Sequence</span></div>
            <?php foreach ($wall as $k => $w): ?>
              <div class="bg-gantt__row<?= $k === 0 ? ' is-on' : '' ?>">
                <b class="num">0<?= $k + 1 ?></b>
                <span class="bg-gantt__lane"><i style="--a:<?= $w[4] ?>;--b:<?= $w[5] ?>"><em></em></i></span>
              </div>
            <?php endforeach; ?>
            <div class="bg-gantt__wk"><b></b><span class="bg-gantt__lane"><span>W1</span><span>W2</span><span>W3</span><span>W4</span><span>W5</span><span>W6</span></span></div>
          </div>
        </div>

        <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/growth-strategy/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
        <figure class="bg-wall" data-bg-wall data-rv data-rv-d="100">
          <div class="bg-wall__media">
            <img src="<?= xe_url('assets/imgs/brand/growth-strategy/workshop-wall.jpg') ?>" width="2000" height="1336" loading="lazy" decoding="async"
                 alt="A strategist writing on a kraft-paper wall covered in sticky notes, arranged in lanes along lines of tape">
            <span class="bg-wall__shade" aria-hidden="true"></span>
            <?php foreach ($wall as $k => $w): ?>
              <button class="bg-wall__pin<?= $k === 0 ? ' is-on' : '' ?>" type="button" style="--x:<?= $w[0] ?>;--y:<?= $w[1] ?>"
                      aria-expanded="<?= $k === 0 ? 'true' : 'false' ?>" aria-controls="bg-note-<?= $k ?>" data-i="<?= $k ?>">
                <span aria-hidden="true"><?= $k + 1 ?></span><span class="sr"><?= e($w[6]) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
          <div class="bg-wall__notes">
            <?php foreach ($wall as $k => $w): ?>
              <div class="bg-wall__note<?= $k === 0 ? ' is-on' : '' ?>" id="bg-note-<?= $k ?>" data-side="<?= $w[2] ?>" data-v="<?= $w[3] ?>" style="--x:<?= $w[0] ?>;--y:<?= $w[1] ?>">
                <p class="bg-wall__nk"><span class="num">0<?= $k + 1 ?></span><span><?= e($w[7]) ?></span></p>
                <p class="bg-wall__nt"><?= e($w[6]) ?></p>
                <p class="bg-wall__nd"><?= e($w[8]) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </figure>
      </div>

      <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/growth-strategy/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
      <ul class="bg-inside__strip" data-rv-s data-rv-step="90">
        <?php foreach ($shots as $s): ?>
          <li class="bg-shot">
            <figure>
              <span class="bg-shot__img">
                <img src="<?= xe_url('assets/imgs/brand/growth-strategy/' . $s[0]) ?>" width="900" height="675" loading="lazy" decoding="async" alt="<?= e($s[1]) ?>">
              </span>
              <figcaption class="bg-shot__cap">
                <span class="bg-shot__k"><?= e($s[2]) ?></span>
                <span class="bg-shot__t"><?= e($s[3]) ?></span>
                <span class="bg-shot__d"><?= e($s[4]) ?></span>
              </figcaption>
            </figure>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- ===== the thesis on one page ===== -->
  <section class="band band--line bg-thesis" aria-labelledby="thesis-t">
    <div class="wrap bg-thesis__grid">
      <div class="bg-thesis__text" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>The growth thesis</p>
        <h2 class="h2" id="thesis-t"><span class="g">One page.</span><br>Signed by the people who decide.</h2>
        <p class="p">Everything the six weeks produce reduces to a single page: where growth comes from, in what order, and what has to be true. If it cannot fit on the page, it is not decided yet.</p>
        <ul class="bg-thesis__list" data-bg-list>
          <li class="is-on"><i class="chev" aria-hidden="true">›</i><span>Where growth comes from, ranked</span><em aria-hidden="true">Title</em></li>
          <li><i class="chev" aria-hidden="true">›</i><span>What has to be true, and who is checking</span><em aria-hidden="true">§ 01</em></li>
          <li><i class="chev" aria-hidden="true">›</i><span>The first three moves, with dates</span><em aria-hidden="true">§ 02</em></li>
          <li><i class="chev" aria-hidden="true">›</i><span>The four numbers that say it is working</span><em aria-hidden="true">§ 03</em></li>
        </ul>
      </div>

      <div class="bg-thesis__doc" data-bd-live data-bg-doc data-rv data-rv-d="120" aria-hidden="true">
        <span class="bg-thesis__desk"></span>
        <span class="bg-thesis__sheet bg-thesis__sheet--2"></span>
        <span class="bg-thesis__sheet bg-thesis__sheet--1"></span>
        <div class="bg-doc has-hl">
          <p class="bg-doc__hd">
            <span class="bg-doc__brand"><span class="bg-doc__mark"><?= xe_svg('xe-mark') ?></span>Growth thesis</span>
            <span class="bg-doc__ver">v1.0 · signed</span>
          </p>
          <div class="bg-doc__part is-hl">
            <p class="bg-doc__kick">Where growth comes from</p>
            <p class="bg-doc__title">Growth comes from mid-market ops teams first, founders second.</p>
          </div>
          <div class="bg-doc__part">
            <p class="bg-doc__sh"><span>01 · What has to be true</span><span>3</span></p>
            <span class="bg-doc__row"><i class="bg-doc__ck is-ok"></i><span class="bg-doc__line" style="--w:88%;--i:0"></span><em>holds</em></span>
            <span class="bg-doc__row"><i class="bg-doc__ck is-ok"></i><span class="bg-doc__line" style="--w:72%;--i:1"></span><em>holds</em></span>
            <span class="bg-doc__row"><i class="bg-doc__ck"></i><span class="bg-doc__line" style="--w:60%;--i:2"></span><em>testing</em></span>
          </div>
          <div class="bg-doc__part">
            <p class="bg-doc__sh"><span>02 · First three moves</span><span>Q3</span></p>
            <span class="bg-doc__row"><b class="num">01</b><span class="bg-doc__line" style="--w:74%;--i:3"></span><em>Sep</em></span>
            <span class="bg-doc__row"><b class="num">02</b><span class="bg-doc__line" style="--w:58%;--i:4"></span><em>Oct</em></span>
            <span class="bg-doc__row"><b class="num">03</b><span class="bg-doc__line" style="--w:66%;--i:5"></span><em>Nov</em></span>
          </div>
          <div class="bg-doc__part">
            <p class="bg-doc__sh"><span>03 · Measures</span><span>4</span></p>
            <span class="bg-doc__chips"><i>Qualified pipeline</i><i>Win rate</i><i>Cycle length</i><i>Margin</i></span>
          </div>
          <div class="bg-doc__sign">
            <span class="bg-doc__sl">Signed</span>
            <svg class="bg-doc__sig" viewBox="0 0 150 40" fill="none"><path pathLength="1" d="M4 29c7-9 12-20 18-19 5 1-3 21 3 22 6 1 10-17 16-16 5 1 0 14 5 14 6 0 9-12 15-11 4 1 1 9 6 9 7 0 10-8 17-8 5 0 5 6 10 6 9 0 16-7 26-9 9-2 18 0 28-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="bg-doc__who">Leadership · wk 06</span>
          </div>
        </div>
        <div class="bg-thesis__stamp">
          <p class="bg-thesis__sl"><span>Sign-off</span><b class="num">4 / 4</b></p>
          <span class="bg-thesis__roles"><i style="--i:0">CEO</i><i style="--i:1">CFO</i><i style="--i:2">CMO</i><i style="--i:3">COO</i></span>
        </div>
      </div>
    </div>
  </section>

  <?php
  $proc = $cap['process'];
  include __DIR__ . '/../../partials/brand/process.php';
  include __DIR__ . '/../../partials/brand/deliver.php';
  include __DIR__ . '/../../partials/brand/outcomes.php';
  include __DIR__ . '/../../partials/brand/pairs.php';
  $faqId = 'faq';
  $faq = ['title' => 'Growth Strategy,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
