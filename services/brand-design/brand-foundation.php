<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['brand-foundation'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/brand-foundation.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/brand-foundation.js'],
];

$img = function (string $f): string { return xe_url('assets/imgs/brand/brand-foundation/' . $f); };
$pad = function (int $n): string { return str_pad((string) $n, 2, '0', STR_PAD_LEFT); };

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

/* ---- the hero stage: the foundation stacks itself, and the positioning writes itself ---- */
$stones = [
    ['Positioning', 'For whom, against what, why you', 4, 58],
    ['Values',      'What we will not trade away',     3, 69],
    ['Mission',     'What we do about it',             2, 80],
    ['Vision',      'Where this is going',             1, 90],
    ['Purpose',     'Why the brand exists',            0, 100],
];
$fills = [
    ['For ', 'operations leads at mid-market firms'],
    [', ', 'Xterra Edze'],
    [' is the ', 'creative company'],
    [' that ', 'builds brand systems that compound'],
    [', because ', 'every model and system stays theirs'],
];
ob_start(); ?>
<!-- PLACEHOLDER: illustrative positioning statement, written for layout -->
<div class="bd-stage bf-found" data-bd-live data-bf-found aria-hidden="true">
  <div class="bd-stage__bar">
    <span class="bd-stage__dots"><i></i><i></i><i></i></span>
    <span class="bd-stage__title">Foundation <i>›</i> on a page</span>
    <span class="bd-stage__state"><i></i>signed</span>
  </div>
  <div class="bd-stage__body bf-found__body">
    <div class="bf-found__top">
      <span class="bf-found__lbl">Five layers · built bottom up</span>
      <span class="bf-found__ver">draft 3</span>
    </div>
    <div class="bf-stones">
      <?php foreach ($stones as $s): ?>
        <div class="bf-stone<?= $s[2] === 4 ? ' bf-stone--top' : '' ?>" style="--k:<?= $s[2] ?>;--w:<?= $s[3] ?>%">
          <span class="bf-stone__n num"><?= $pad($s[2] + 1) ?></span>
          <b class="bf-stone__t"><?= e($s[0]) ?></b>
          <span class="bf-stone__d"><?= e($s[1]) ?></span>
        </div>
      <?php endforeach; ?>
      <span class="bf-stones__ground"><i></i></span>
    </div>
    <div class="bf-builder">
      <p class="bf-builder__lbl"><span>Positioning statement</span><span class="bf-builder__step">layer 05</span></p>
      <p class="bf-builder__s">
        <?php foreach ($fills as $f): ?><?= e($f[0]) ?><b class="bf-slot" data-fill="<?= e($f[1]) ?>"><span class="bf-slot__t"><?= e($f[1]) ?></span><span class="bf-slot__r"></span></b><?php endforeach; ?>.
      </p>
      <div class="bf-builder__foot">
        <span class="bf-builder__who"><i></i><i></i><i></i><i></i><em>4 of 4 agreed</em></span>
        <span class="bf-builder__stamp">Signed · leadership · wk 05</span>
      </div>
    </div>
  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="foundation">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>

  <!-- ===== when to call us · image-led ===== -->
  <section class="bf-sec band--alt bf-signs" aria-labelledby="signs-t">
    <div class="wrap">
      <div class="bf-head" data-rv>
        <div class="bf-head__l">
          <p class="lbl lbl--blue"><span class="dot"></span>When to call us</p>
          <h2 class="h2" id="signs-t"><span class="g">The same argument,</span><br>every quarter</h2>
        </div>
        <p class="lead">A foundation is overdue when the company keeps re-deciding what it is. These are the signs we hear first, usually from the people closest to the work.</p>
      </div>

      <div class="bf-signs__grid">
        <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/brand-foundation/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
        <figure class="bf-signs__fig" data-bf-par data-rv>
          <img src="<?= $img('room-wall-of-notes.jpg') ?>" alt="A person reading a wall covered floor to ceiling in hundreds of handwritten notes" width="1100" height="1375" loading="lazy" decoding="async">
          <span class="bf-signs__shade" aria-hidden="true"></span>
          <!-- PLACEHOLDER: illustrative interview synthesis, written for layout -->
          <div class="bf-float bf-signs__card" data-depth="14" aria-hidden="true">
            <p class="bf-float__hd"><span>Interview synthesis</span><span>wk 02</span></p>
            <p class="bf-signs__q">“What are we?”</p>
            <div class="bf-signs__bars">
              <span><b>Leadership</b><i style="--v:.82"></i></span>
              <span><b>Product</b><i style="--v:.46"></i></span>
              <span><b>Sales</b><i style="--v:.64"></i></span>
              <span><b>Customers</b><i class="is-blue" style="--v:.3"></i></span>
            </div>
            <p class="bf-float__meta">5 interviews · 5 different answers</p>
          </div>
          <span class="bf-float bf-signs__chip" data-depth="24" aria-hidden="true"><i></i>Notes clustered · 14 themes</span>
        </figure>

        <ul class="bf-signs__list" data-rv-s data-rv-step="70">
          <?php
          $signs = [
              ['talk',   'Every team tells a different story', 'Ask five leaders what the company is. You get five reasonable answers, and none of them match.'],
              ['loop',   'Close calls get argued twice',       'Decisions travel up the chain because nothing written down settles them further down.'],
              ['page',   'The identity brief starts blank',    'A rebrand is planned, but nobody can say what the new identity has to stay true to.'],
              ['fork',   'Something big has changed',          'A merger, a new market or a new product line has blurred what the brand stands for.'],
              ['frame',  'The values live on a wall',          'They are printed and framed, and have never been used to decide anything.'],
              ['ask',    'Every partner asks the same questions', 'Each new agency starts with discovery, because there is no single page to hand them.'],
          ];
          $ico = [
              'talk'  => '<path d="M3.5 5.5h9a1.5 1.5 0 0 1 1.5 1.5v4.5a1.5 1.5 0 0 1-1.5 1.5H8l-3 2.5V13H3.5A1.5 1.5 0 0 1 2 11.5V7a1.5 1.5 0 0 1 1.5-1.5Z"/><path d="M7 3h9.5A1.5 1.5 0 0 1 18 4.5V9a1.5 1.5 0 0 1-1.5 1.5H16"/>',
              'loop'  => '<path d="M15.5 7.5A6 6 0 0 0 4.3 6.2"/><path d="M4 3v3.4h3.4"/><path d="M4.5 12.5a6 6 0 0 0 11.2 1.3"/><path d="M16 17v-3.4h-3.4"/>',
              'page'  => '<path d="M5 2.5h6.5L15.5 6.5v11H5Z"/><path d="M11.5 2.5v4h4"/><path d="M8 11h4.5M8 14h2.5"/>',
              'fork'  => '<path d="M10 17.5V11"/><path d="M10 11 5 6.5V2.5"/><path d="M10 11l5-4.5V2.5"/><path d="M3 4.5 5 2.5l2 2M13 4.5l2-2 2 2"/>',
              'frame' => '<rect x="3" y="4.5" width="14" height="12" rx="1"/><path d="M7.5 4.5 10 2l2.5 2.5"/><path d="M6.5 13.5l2.5-3 2 2 1.5-1.5 1.5 2.5"/>',
              'ask'   => '<circle cx="10" cy="10" r="7.5"/><path d="M7.8 7.9A2.3 2.3 0 0 1 10 6.3c1.3 0 2.3.9 2.3 2.1 0 1.6-2.3 1.9-2.3 3.4"/><path d="M10 14.2v.1"/>',
          ];
          foreach ($signs as $i => $s): ?>
            <li class="bf-sign">
              <span class="bf-sign__top">
                <span class="bf-sign__ico" aria-hidden="true"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><?= $ico[$s[0]] ?></svg></span>
                <span class="bf-sign__n num" aria-hidden="true"><?= $pad($i + 1) ?></span>
              </span>
              <h3 class="bf-sign__t"><?= e($s[1]) ?></h3>
              <p class="bf-sign__d"><?= e($s[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <p class="bf-signs__foot" data-rv><i class="chev" aria-hidden="true">›</i>Two or more sound familiar? Foundation is the most common place to start, and everything else we do plugs into it.</p>
    </div>
  </section>

  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · principles that settle decisions ===== -->
  <section class="bf-sec band--alt bf-principles" aria-labelledby="princ-t">
    <div class="wrap">
      <div class="bf-head" data-rv>
        <div class="bf-head__l">
          <p class="lbl lbl--blue"><span class="dot"></span>Principles</p>
          <h2 class="h2" id="princ-t"><span class="g">Written to settle</span><br>real decisions</h2>
        </div>
        <p class="lead">A value that cannot lose you anything is not a value. Each principle below comes with a decision it made easier. Turn a card to see it.</p>
      </div>

      <!-- PLACEHOLDER: illustrative principles, written for layout — each client's are their own -->
      <div class="bf-flip__grid" data-rv-s data-rv-step="80">
        <?php
        $princ = [
            ['Say less. Mean it.',                      'Cut the launch deck from 40 slides to 9. The nine were signed in one meeting.'],
            ['Evidence before taste.',                  'Two logo directions tested on real packaging. The favourite lost. The winner shipped.'],
            ['The customer’s time is ours to protect.', 'Dropped a feature that added a step to sign-up. The flow stayed short.'],
            ['One system, not one asset.',              'Declined a one-off campaign look. Built a flexible range instead, used in every market.'],
            ['What we build, they own.',                'Wrote IP transfer into the first contract. It is now in every one.'],
            ['Judgement stays human.',                  'Kept a reviewer on every AI output above a set risk level. Volume rose and quality held.'],
        ];
        foreach ($princ as $i => $p): ?>
          <button class="bf-flip" type="button" aria-pressed="false" data-bf-flip>
            <span class="bf-flip__in">
              <span class="bf-flip__face bf-flip__front">
                <span class="bf-flip__row"><span class="bf-flip__n num"><?= $pad($i + 1) ?></span><span class="bf-flip__k">Principle</span></span>
                <span class="bf-flip__t"><?= e($p[0]) ?></span>
                <span class="bf-flip__hint">In practice <i aria-hidden="true">›</i></span>
              </span>
              <span class="bf-flip__face bf-flip__back">
                <span class="bf-flip__row"><span class="bf-flip__n num"><?= $pad($i + 1) ?></span><span class="bf-flip__k">In practice</span></span>
                <span class="bf-flip__bt"><?= e($p[1]) ?></span>
                <span class="bf-flip__hint">Back to the principle <i aria-hidden="true">‹</i></span>
              </span>
            </span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== the room where it gets decided · image-led ===== -->
  <section class="bf-sec bf-room" aria-labelledby="room-t">
    <div class="wrap">
      <div class="bf-head" data-rv>
        <div class="bf-head__l">
          <p class="lbl lbl--blue"><span class="dot"></span>Working sessions</p>
          <h2 class="h2" id="room-t"><span class="g">The room where</span><br>it gets decided</h2>
        </div>
        <p class="lead">The people who make the calls, a draft on the wall and short sessions. The foundation is argued into shape, not presented at the end.</p>
      </div>

      <div class="bf-room__grid">
        <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/brand-foundation/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
        <figure class="bf-room__fig" data-bf-par data-rv>
          <div class="bf-room__photo">
            <img src="<?= $img('notes-grid-hand.jpg') ?>" alt="A hand placing the last sticky note into a neat grid of notes on a grey wall" width="1800" height="1192" loading="lazy" decoding="async">
            <div class="bf-room__notes" aria-hidden="true">
              <?php
              $notes = [['Purpose', 0, 0], ['Vision', 1, 0], ['Mission', 2, 0], ['Values', 0, 1], ['Positioning', 1, 1], ['Audience', 2, 1], ['Insight', 0, 2], ['Narrative', 1, 2]];
              foreach ($notes as $i => $n): ?>
                <span class="bf-note" style="--c:<?= $n[1] ?>;--r:<?= $n[2] ?>;--i:<?= $i ?>"><b><?= $pad($i + 1) ?></b><?= e($n[0]) ?></span>
              <?php endforeach; ?>
              <span class="bf-note bf-note--held"><b>09</b>Test it</span>
            </div>
          </div>
          <!-- PLACEHOLDER: illustrative session notes, written for layout -->
          <div class="bf-float bf-room__card bf-room__card--kept" data-depth="16" aria-hidden="true">
            <p class="bf-float__hd"><span>Draft principle 02</span><span>session 2</span></p>
            <p class="bf-room__ct">Evidence before taste.</p>
            <p class="bf-room__pill"><i>✓</i>Kept · settled 3 of 3 past calls</p>
          </div>
          <div class="bf-float bf-room__card bf-room__card--cut" data-depth="26" aria-hidden="true">
            <p class="bf-float__hd"><span>Cut in session 1</span></p>
            <p class="bf-room__ct"><s>Always be innovative.</s></p>
            <p class="bf-float__meta">Could not lose us anything</p>
          </div>
        </figure>

        <ol class="bf-room__list" data-rv-s data-rv-step="80">
          <li class="bf-room__i">
            <span class="bf-room__n num" aria-hidden="true">01</span>
            <div><h3 class="bf-room__t">Who is in the room</h3><p class="bf-room__d">The people who make the calls. Founders or the executive team, and whoever owns brand day to day. We keep the group small.</p></div>
          </li>
          <li class="bf-room__i">
            <span class="bf-room__n num" aria-hidden="true">02</span>
            <div><h3 class="bf-room__t">What is on the wall</h3><p class="bf-room__d">The tension map from the interviews, the positioning options and the draft principles, each paired with a decision it would have settled.</p></div>
          </li>
          <li class="bf-room__i">
            <span class="bf-room__n num" aria-hidden="true">03</span>
            <div><h3 class="bf-room__t">How it runs</h3><p class="bf-room__d">Two working sessions in weeks three and four. The draft is argued with line by line, then tightened between sessions.</p></div>
          </li>
          <li class="bf-room__i">
            <span class="bf-room__n num" aria-hidden="true">04</span>
            <div><h3 class="bf-room__t">What leaves the room</h3><p class="bf-room__d">A foundation the leadership team has already disagreed with, which is why they can sign it.</p></div>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <!-- ===== tension map ===== -->
  <section class="bf-sec band--alt bf-tension" aria-labelledby="tension-t">
    <div class="wrap">
      <div class="bf-head bf-head--c" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Tension map</p>
        <h2 class="h2" id="tension-t"><span class="g">Where the brand</span><br>disagrees with itself</h2>
        <p class="lead">In the first two weeks we set what leadership says beside what customers say. The gaps are not failures. They are where the positioning has to choose.</p>
      </div>

      <!-- PLACEHOLDER: illustrative tensions, written for layout — every client's map is their own -->
      <div class="bf-tmap" data-bf-tmap data-rv data-rv-d="80">
        <span class="bf-tmap__dots" aria-hidden="true"></span>
        <svg class="bf-tmap__wires" aria-hidden="true" focusable="false"></svg>
        <?php
        $tens = [
            ['We are a technology company.',     'Board deck',     'They make the complicated part simple.', 'Customer call'],
            ['Built for the enterprise.',        'Sales deck',     'Easy to start with on a small team.',    'Product review'],
            ['We do everything, end to end.',    'Leadership interview', 'I use them for one thing. It works.', 'Customer call'],
            ['Speed is our edge.',               'All-hands',      'I stayed because they were careful.',    'Renewal call'],
        ];
        ?>
        <div class="bf-tmap__col bf-tmap__col--l">
          <p class="bf-tmap__h"><span class="bf-tmap__av">L</span>Leadership says</p>
          <ul class="bf-tmap__list">
            <?php foreach ($tens as $i => $t): ?>
              <li class="bf-tq" data-bf-tq="<?= $i ?>"><span class="bf-tq__src"><?= e($t[1]) ?></span><span class="bf-tq__t">“<?= e($t[0]) ?>”</span></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="bf-tmap__mid">
          <div class="bf-tcore" data-bf-tcore>
            <p class="bf-tcore__hd"><span class="bf-tcore__dot" aria-hidden="true"></span>One answer · wk 04</p>
            <p class="bf-tcore__t">Simple to start. Careful at scale.</p>
            <p class="bf-tcore__d">Four tensions named. Two settled in the positioning, two written as principles.</p>
            <div class="bf-tcore__meter" aria-hidden="true">
              <?php foreach ($tens as $i => $t): ?><i data-bf-tm="<?= $i ?>"></i><?php endforeach; ?>
            </div>
            <p class="bf-tcore__count" aria-hidden="true">Tension <b data-bf-tcount>01</b> of 04</p>
          </div>
        </div>

        <div class="bf-tmap__col bf-tmap__col--r">
          <p class="bf-tmap__h"><span class="bf-tmap__av">C</span>Customers say</p>
          <ul class="bf-tmap__list">
            <?php foreach ($tens as $i => $t): ?>
              <li class="bf-tq" data-bf-tq="<?= $i ?>"><span class="bf-tq__src"><?= e($t[3]) ?></span><span class="bf-tq__t">“<?= e($t[2]) ?>”</span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <ul class="bf-tension__foot" data-rv-s data-rv-step="80">
        <li><b>Heard, not averaged</b><span>Every voice is kept in its own words. We do not blend them into something nobody said.</span></li>
        <li><b>Named, then chosen</b><span>Each tension is written down as a choice, with what the brand gains and gives up either way.</span></li>
        <li><b>Written into the foundation</b><span>The choices become the positioning and the principles, so the argument does not return next quarter.</span></li>
      </ul>
    </div>
  </section>

  <!-- ===== the foundation test ===== -->
  <section class="bf-sec bf-test" aria-labelledby="test-t">
    <div class="wrap">
      <div class="bf-head" data-rv>
        <div class="bf-head__l">
          <p class="lbl lbl--blue"><span class="dot"></span>The foundation test</p>
          <h2 class="h2" id="test-t"><span class="g">If it would not have helped,</span><br>it is not finished</h2>
        </div>
        <p class="lead">Before the foundation is signed, we run it against decisions you already faced. A foundation that says yes to everything has decided nothing.</p>
      </div>

      <div class="bf-test__grid">
        <div class="bf-test__side" data-rv>
          <ol class="bf-test__steps">
            <li><span class="num">01</span><div><b>Three past decisions, re-run</b><p>Real proposals from the last two years, taken back to the moment they were decided.</p></div></li>
            <li><span class="num">02</span><div><b>Each principle helps or it goes</b><p>Every principle is scored against every proposal. One that never changes a call is cut.</p></div></li>
            <li><span class="num">03</span><div><b>The verdicts are recorded</b><p>So the next close call starts from a precedent, not a blank page.</p></div></li>
          </ol>
          <div class="bf-test__legend" aria-hidden="true">
            <span><i class="bf-score__c is-y">✓</i>Principle helps</span>
            <span><i class="bf-score__c is-n">×</i>Does not</span>
            <span><b class="bf-score__v is-go">go</b><b class="bf-score__v is-hold">hold</b><b class="bf-score__v is-no">no</b></span>
          </div>
        </div>

        <!-- PLACEHOLDER: illustrative proposals and scores, written for layout -->
        <div class="bd-stage bf-test__stage" data-bd-live data-bf-score data-rv data-rv-d="120">
          <div class="bd-stage__bar" aria-hidden="true">
            <span class="bd-stage__dots"><i></i><i></i><i></i></span>
            <span class="bd-stage__title">Foundation test <i>›</i> three past decisions</span>
            <span class="bd-stage__state"><i></i>running</span>
          </div>
          <div class="bd-stage__body bf-score__body">
            <div class="bf-score__scroll">
              <div class="bf-score" role="table" aria-label="Foundation test: three past decisions scored against four principles">
                <div class="bf-score__hd" role="row">
                  <span role="columnheader">Proposal</span>
                  <span role="columnheader">Then</span>
                  <span role="columnheader"><em>01</em>Say less</span>
                  <span role="columnheader"><em>02</em>Evidence</span>
                  <span role="columnheader"><em>03</em>Time</span>
                  <span role="columnheader"><em>04</em>System</span>
                  <span role="columnheader">Now</span>
                </div>
                <?php
                $tests = [
                    ['Launch a budget tier',    'Q2 · approved', ['y', 'y', 'y', 'n'], 'hold'],
                    ['Sponsor the tech summit', 'Q3 · approved', ['n', 'n', 'y', 'n'], 'no'],
                    ['Rebuild onboarding',      'Q4 · approved', ['y', 'y', 'y', 'y'], 'go'],
                ];
                foreach ($tests as $r => $t): ?>
                  <div class="bf-score__row" role="row" style="--r:<?= $r ?>" data-bf-row>
                    <span class="bf-score__p" role="cell"><b><?= e($t[0]) ?></b><em><?= e($t[1]) ?></em></span>
                    <span class="bf-score__then" role="cell">Yes</span>
                    <?php foreach ($t[2] as $c => $v): ?>
                      <span class="bf-score__cell" role="cell" style="--c:<?= $c ?>"><i class="bf-score__c is-<?= $v ?>" aria-hidden="true"><?= $v === 'y' ? '✓' : '×' ?></i><span class="sr"><?= $v === 'y' ? 'helps' : 'does not help' ?></span></span>
                    <?php endforeach; ?>
                    <span class="bf-score__now" role="cell"><b class="bf-score__v is-<?= $t[3] ?>"><?= $t[3] ?></b></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="bf-score__note">
              <span class="bf-score__tally" aria-hidden="true"><b>1</b> go <i>·</i> <b>1</b> hold <i>·</i> <b>1</b> no</span>
              <p>Two of three calls changed. The foundation earned its place.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $proc = $cap['process'];
  include __DIR__ . '/../../partials/brand/process.php';
  include __DIR__ . '/../../partials/brand/deliver.php';
  ?>

  <!-- ===== foundation on a page · image-led ===== -->
  <section class="bf-sec band--alt bf-poster" aria-labelledby="poster-t">
    <div class="wrap">
      <div class="bf-head" data-rv>
        <div class="bf-head__l">
          <p class="lbl lbl--blue"><span class="dot"></span>Foundation on a page</p>
          <h2 class="h2" id="poster-t"><span class="g">Everything above,</span><br>on one sheet</h2>
        </div>
        <p class="lead">The full foundation runs to a document. The version people use fits on one page: pinned by a desk, open in a first meeting, handed to a new hire on day one.</p>
      </div>

      <div class="bf-poster__grid" data-bf-poster>
        <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/brand-foundation/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
        <figure class="bf-poster__fig" data-bf-tilt data-rv>
          <div class="bf-poster__plane">
            <img src="<?= $img('blank-sheet-on-wall.jpg') ?>" alt="A single printed sheet held to a plain wall with a binder clip, showing a one-page brand foundation" width="1100" height="1268" loading="lazy" decoding="async">
            <!-- PLACEHOLDER: illustrative one-page foundation, written for layout -->
            <div class="bf-sheet" aria-hidden="true">
              <div class="bf-sheet__in">
                <div class="bf-sheet__hd">
                  <span class="bf-sheet__mark"><?= xe_svg('xe-mark') ?></span>
                  <span class="bf-sheet__ttl">Foundation<br>on a page</span>
                  <span class="bf-sheet__v">v1.0</span>
                </div>
                <div class="bf-sheet__b" data-bf-pi="0"><em>Purpose</em><p class="bf-sheet__big">Build things that matter, to businesses and everyone they touch.</p></div>
                <div class="bf-sheet__b" data-bf-pi="1"><em>Positioning</em><p>For operations leads at mid-market firms, the creative company that builds brand systems that compound.</p></div>
                <div class="bf-sheet__b" data-bf-pi="2"><em>Principles</em>
                  <ol class="bf-sheet__cols"><li>Say less</li><li>Evidence first</li><li>Protect time</li><li>One system</li><li>They own it</li><li>Human judgement</li></ol>
                </div>
                <div class="bf-sheet__b" data-bf-pi="3"><em>Audience</em><p>Leaders who need brand, product and campaigns to agree.</p></div>
                <div class="bf-sheet__b" data-bf-pi="4"><em>Narrative</em>
                  <span class="bf-sheet__lines"><i style="--l:38%"></i><i style="--l:72%"></i><i style="--l:100%"></i></span>
                </div>
                <div class="bf-sheet__ft" data-bf-pi="5"><span class="bf-sheet__stamp">Signed</span><span>Leadership · wk 05</span></div>
              </div>
            </div>
            <div class="bf-poster__pins" aria-hidden="true">
              <?php foreach ([24.5, 38, 51.5, 65, 75.5, 85] as $i => $y): ?>
                <span class="bf-pin" data-bf-pin="<?= $i ?>" style="--y:<?= $y ?>%"><b class="num"><?= $pad($i + 1) ?></b><i></i></span>
              <?php endforeach; ?>
            </div>
          </div>
        </figure>

        <div class="bf-poster__side">
          <ol class="bf-poster__list" data-rv-s data-rv-step="70">
            <?php
            $parts = [
                ['Purpose',               'One sentence on why the brand exists, written so anyone in the company can repeat it.'],
                ['Positioning',           'The signed statement: for whom, against what, and why you.'],
                ['Values & principles',   'The handful of things the brand will not trade away, one line each.'],
                ['Audience & insight',    'Who the brand is for, and the insight that makes the positioning true.'],
                ['Narrative',             'Three lengths of the same story: the deck, the lift and the new hire.'],
                ['Signed',                'By the leadership team, with a date and a version, so it can be revised on purpose.'],
            ];
            foreach ($parts as $i => $p): ?>
              <li class="bf-part" data-bf-part="<?= $i ?>">
                <span class="bf-part__n num" aria-hidden="true"><?= $pad($i + 1) ?></span>
                <div><h3 class="bf-part__t"><?= e($p[0]) ?></h3><p class="bf-part__d"><?= e($p[1]) ?></p></div>
              </li>
            <?php endforeach; ?>
          </ol>
          <p class="bf-poster__fmt" data-rv><span class="pill">PDF</span><span class="pill">Print</span><span class="bf-poster__fmtl">Alongside the full foundation document and narrative deck</span></p>
        </div>
      </div>
    </div>
  </section>

  <?php
  include __DIR__ . '/../../partials/brand/outcomes.php';
  include __DIR__ . '/../../partials/brand/pairs.php';
  $faqId = 'faq';
  $faq = ['title' => 'Brand Foundation,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
