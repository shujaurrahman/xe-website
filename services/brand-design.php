<?php
$BASE = '../';
require __DIR__ . '/../partials/init.php';

$BD = require __DIR__ . '/../data/brand-design.php';
/* Named $BRAND, not the short name: partials/nav.php loops with that variable and would overwrite it. */
$BRAND = null;
foreach ($SITE['disciplines'] as $x) { if ($x['slug'] === 'brand-design') $BRAND = $x; }
$cap = null;   // the rail marks the hub as current

$page = [
    'key'   => 'services',
    'title' => 'Brand Design',
    'desc'  => $BRAND['intro'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/hub.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/hub.js'],
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<main id="main" class="bd" data-bd="hub">

  <!-- ===== hero · the brand board ===== -->
  <section class="bd-hero" aria-labelledby="bd-hero-t">
    <div class="bd-hero__bg" aria-hidden="true">
      <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
      <span class="dither dither--wide bd-hero__dither"></span>
      <span class="bd-hero__grain"></span>
    </div>

    <div class="wrap bd-hero__in">
      <div class="bd-hero__text" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= e($BRAND['n']) ?> · Brand Design</p>
        <h1 class="bd-hero__h" id="bd-hero-t">Brands that hold together,<br><span class="g">wherever they show up.</span></h1>
        <p class="lead bd-hero__lead"><?= e($BRAND['intro']) ?></p>
        <div class="bd-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Start a brand brief <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#six">The six capabilities <span class="i" aria-hidden="true">›</span></a>
        </div>
        <p class="bd-hero__meta">
          <span><?= count($BRAND['caps']) ?> capabilities</span><i aria-hidden="true">·</i>
          <span>One system</span><i aria-hidden="true">·</i>
          <span>Every touchpoint</span>
        </p>
      </div>

      <!-- the brand board: one system, six tiles, a cursor walking between them -->
      <div class="bd-hero__board" data-rv data-rv-d="140">
        <div class="bd-board" data-bd-board aria-hidden="true">
          <span class="bd-board__grid"></span>
          <div class="bd-board__top">
            <span class="bd-board__crumb">Brand system <i>›</i> v2.4</span>
            <span class="bd-board__state"><i></i>locked</span>
          </div>
          <div class="bd-board__tiles">
            <div class="bd-board__tile bd-board__tile--mark is-sel" data-tile>
              <span class="bd-board__lbl">Mark</span>
              <span class="bd-board__mark"><span class="bd-board__cs"></span><?= xe_svg('xe-mark') ?></span>
              <span class="bd-board__meta">clearspace ×1</span>
            </div>
            <div class="bd-board__tile bd-board__tile--colour" data-tile>
              <span class="bd-board__lbl">Colour</span>
              <span class="bd-board__sw">
                <i style="--c:var(--ink)"><b>ink</b></i>
                <i style="--c:var(--blue)"><b>blue</b></i>
                <i style="--c:var(--paper-3)"><b>paper</b></i>
                <i style="--c:var(--line-3)"><b>line</b></i>
              </span>
              <span class="bd-board__meta">4 tokens · 1 accent</span>
            </div>
            <div class="bd-board__tile bd-board__tile--type" data-tile>
              <span class="bd-board__lbl">Type</span>
              <span class="bd-board__type">
                <b>Aa</b>
                <span class="bd-board__scale"><i>Display 48</i><i>Heading 28</i><i>Body 15</i><i>Label 11</i></span>
              </span>
            </div>
            <div class="bd-board__tile bd-board__tile--motion" data-tile>
              <span class="bd-board__lbl">Motion</span>
              <span class="bd-board__chev"><i>›</i><i>›</i><i>›</i></span>
              <span class="bd-board__meta">.32s · ease-out</span>
            </div>
            <div class="bd-board__tile bd-board__tile--voice" data-tile>
              <span class="bd-board__lbl">Voice</span>
              <span class="bd-board__words"><i>Precise</i><i>Kinetic</i><i>Unshowy</i><i>Direct</i></span>
              <span class="bd-board__meta">never “seamless”</span>
            </div>
            <div class="bd-board__tile bd-board__tile--rules" data-tile>
              <span class="bd-board__lbl">Rules</span>
              <span class="bd-board__list"><i>Clearspace</i><i>Contrast</i><i>Scale</i><i>Tone</i></span>
              <span class="bd-board__meta">4 checks · all pass</span>
            </div>
          </div>
          <span class="bd-board__cursor"><i></i><b>XE</b></span>
        </div>
      </div>
    </div>

    <!-- the six capabilities, on a loop -->
    <div class="bd-ticker mq-hold" aria-hidden="true">
      <div class="bd-ticker__track mq mq--l" data-mq style="--mq-dur:38s">
        <?php foreach ($BD as $c): ?>
          <span class="bd-ticker__i"><b><?= e($c['n']) ?></b><?= e($c['name']) ?></span><i class="bd-ticker__sep">›</i>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../partials/brand/rail.php'; ?>

  <!-- ===== the six capabilities · bento ===== -->
  <section class="band bd-six" id="six" aria-labelledby="six-t">
    <div class="wrap">
      <div class="head--row bd-six__head" data-rv>
        <div>
          <p class="lbl lbl--blue"><span class="dot"></span>Six capabilities</p>
          <h2 class="h2" id="six-t"><span class="g">Six ways in.</span><br>One system out.</h2>
        </div>
        <p class="lead">Start with any one. Each is scoped and shipped on its own, and each is built to plug into the other five.</p>
      </div>

      <div class="bd-six__grid" data-rv-s data-rv-step="80">

        <a class="bd-six__card bd-six__card--4" href="<?= xe_url('services/brand-design/growth-strategy.php') ?>">
          <div class="bd-six__mock bdm-matrix" data-bd-live aria-hidden="true">
            <span class="bdm-matrix__ax bdm-matrix__ax--y">fit</span>
            <span class="bdm-matrix__ax bdm-matrix__ax--x">size</span>
            <i class="bdm-matrix__dot" style="--x:18%;--y:70%"></i>
            <i class="bdm-matrix__dot" style="--x:36%;--y:52%"></i>
            <i class="bdm-matrix__dot" style="--x:58%;--y:66%"></i>
            <i class="bdm-matrix__dot" style="--x:30%;--y:24%"></i>
            <i class="bdm-matrix__dot" style="--x:80%;--y:44%"></i>
            <i class="bdm-matrix__dot is-next" style="--x:72%;--y:20%"><b>next best</b></i>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['growth-strategy']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['growth-strategy']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][0][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

        <a class="bd-six__card bd-six__card--5" href="<?= xe_url('services/brand-design/brand-identity.php') ?>">
          <div class="bd-six__mock bdm-spec" data-bd-live aria-hidden="true">
            <span class="bdm-spec__mark"><?= xe_svg('xe-mark') ?></span>
            <span class="bdm-spec__sw"><i></i><i></i><i></i><i></i></span>
            <span class="bdm-spec__type"><b>Aa</b><i></i><i></i><i></i></span>
            <span class="bdm-spec__voice">Precise. Kinetic. Unshowy.</span>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['brand-identity']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['brand-identity']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][1][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

        <a class="bd-six__card bd-six__card--3" href="<?= xe_url('services/brand-design/brand-foundation.php') ?>">
          <div class="bd-six__mock bdm-stones" data-bd-live aria-hidden="true">
            <i style="--w:46%"><b>Positioning</b></i>
            <i style="--w:60%"><b>Values</b></i>
            <i style="--w:74%"><b>Mission</b></i>
            <i style="--w:88%"><b>Vision</b></i>
            <i style="--w:100%"><b>Purpose</b></i>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['brand-foundation']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['brand-foundation']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][2][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

        <a class="bd-six__card bd-six__card--3" href="<?= xe_url('services/brand-design/brand-systems.php') ?>">
          <div class="bd-six__mock bdm-comp" data-bd-live aria-hidden="true">
            <span class="bdm-comp__row">
              <i class="bdm-comp__btn">Start <b>›</b></i>
              <i class="bdm-comp__pill">On brief</i>
            </span>
            <span class="bdm-comp__card"><i></i><i></i><i></i></span>
            <span class="bdm-comp__range"><i></i><b></b></span>
            <span class="bdm-comp__lbl"><i>core</i><i>expressive</i></span>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['brand-systems']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['brand-systems']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][3][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

        <a class="bd-six__card bd-six__card--5" href="<?= xe_url('services/brand-design/brand-architecture.php') ?>">
          <div class="bd-six__mock bdm-tree" data-bd-live aria-hidden="true">
            <span class="bdm-tree__root">XE</span>
            <span class="bdm-tree__wires"><i></i><i></i><i></i></span>
            <span class="bdm-tree__kids">
              <i><b>XE</b> Cloud</i><i><b>XE</b> Studio</i><i><b>XE</b> Labs</i>
            </span>
            <span class="bdm-tree__leaf"><i></i><i></i><i></i><i></i><i></i><i></i></span>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['brand-architecture']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['brand-architecture']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][4][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

        <a class="bd-six__card bd-six__card--4" href="<?= xe_url('services/brand-design/brand-ai-tools.php') ?>">
          <div class="bd-six__mock bdm-gen" data-bd-live aria-hidden="true">
            <span class="bdm-gen__bar"><i>Launch visual, 4:5, campaign blue…</i><b>›</b></span>
            <span class="bdm-gen__grid">
              <i><b>✓</b></i><i><b>✓</b></i><i><b>✓</b></i>
              <i class="is-fix"><b>fixed</b></i><i><b>✓</b></i><i><b>✓</b></i>
            </span>
          </div>
          <div class="bd-six__cap">
            <span class="bd-six__n"><?= e($BD['brand-ai-tools']['n']) ?></span>
            <h3 class="h3 bd-six__t"><?= e($BD['brand-ai-tools']['name']) ?></h3>
            <p class="bd-six__d"><?= e($BRAND['caps'][5][1]) ?></p>
            <span class="bd-six__go">Explore <i aria-hidden="true">›</i></span>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- ===== numbers ===== -->
  <section class="band band--tight bd-stats" aria-label="Brand Design in numbers">
    <div class="wrap">
      <!-- PLACEHOLDER: the twelve-week figure is a typical programme length — confirm before launch -->
      <ul class="bd-stats__list" data-rv-s data-rv-step="80">
        <li><span class="bd-stats__n num" data-count="6">6</span><span class="bd-stats__l">Capabilities, one team</span></li>
        <li><span class="bd-stats__n num" data-count="4">4</span><span class="bd-stats__l">Phases from brief to brand</span></li>
        <li><span class="bd-stats__n num" data-count="1">1</span><span class="bd-stats__l">System every touchpoint reads from</span></li>
        <li><span class="bd-stats__n num" data-count="12">12</span><span class="bd-stats__l">Weeks, a typical programme</span></li>
      </ul>
    </div>
  </section>

  <!-- ===== how a brand is built · the stack ===== -->
  <section class="band band--alt bd-stack" id="stack" aria-labelledby="stack-t">
    <div class="wrap">
      <div class="head head--c bd-stack__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>How a brand is built</p>
        <h2 class="h2" id="stack-t"><span class="g">In this order,</span> for a reason</h2>
        <p class="lead">Each layer is built on the one below it. Skip one and the layers above start to slide.</p>
      </div>

      <div class="bd-stack__panel" data-bd-stack data-rv data-rv-d="80">
        <div class="bd-stack__steps" role="tablist" aria-label="The six layers">
          <?php
          $layers = [
              ['brand-foundation',   'Foundation',   'Beliefs, positioning, principles. What everything else stands on.'],
              ['brand-identity',     'Identity',     'The visual, verbal and behavioural code the foundation is expressed in.'],
              ['brand-systems',      'Systems',      'Tokens, components and templates, so the identity ships at speed.'],
              ['brand-architecture', 'Architecture', 'How the brands and products relate, so growth has somewhere to go.'],
              ['growth-strategy',    'Growth',       'Where to go next, ranked and sequenced, run on the system below it.'],
              ['brand-ai-tools',     'AI tools',     'The whole stack, automated. Consistent at a scale nobody can check by hand.'],
          ];
          foreach ($layers as $i => $L): $on = $i === 0; ?>
            <button class="bd-stack__step<?= $on ? ' is-on' : '' ?>" type="button" role="tab" id="stack-t<?= $i ?>"
                    aria-selected="<?= $on ? 'true' : 'false' ?>"<?= $on ? '' : ' tabindex="-1"' ?> data-href="<?= xe_url('services/brand-design/' . $L[0] . '.php') ?>">
              <span class="bd-stack__n num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="bd-stack__b">
                <span class="bd-stack__t"><?= e($L[1]) ?></span>
                <span class="bd-stack__d"><?= e($L[2]) ?></span>
              </span>
              <span class="bd-stack__bar" aria-hidden="true"><i></i></span>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="bd-stack__scene" aria-hidden="true">
          <div class="bd-stack__plates">
            <?php foreach ($layers as $i => $L): ?>
              <div class="bd-stack__plate<?= $i === 0 ? ' is-on' : '' ?>" style="--k:<?= $i ?>">
                <span class="bd-stack__pn"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="bd-stack__pt"><?= e($L[1]) ?></span>
                <span class="bd-stack__pattern"></span>
              </div>
            <?php endforeach; ?>
          </div>
          <p class="bd-stack__note"><span data-bd-stack-note>Foundation</span> · layer <b data-bd-stack-k>01</b> of 06</p>
          <a class="tl bd-stack__link" data-bd-stack-link href="<?= xe_url('services/brand-design/brand-foundation.php') ?>">Explore this layer <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </section>

  <?php
  $proc = [
      'title' => '<span class="g">From a brief</span> to a brand that runs',
      'lead'  => 'Four phases, one accountable team. Every phase ends in something you can use, not a deck about what comes next.',
      'steps' => [
          ['Discover', 'Wk 01–02', 'The category, the customers, the decisions already made and the ones still open. Everyone in the room, once.', ['Brief', 'Audit', 'Tension map']],
          ['Define',   'Wk 03–04', 'Foundation set, growth thesis written, architecture decided. The rules everything else is built on.', ['Foundation', 'Growth thesis', 'Architecture model']],
          ['Design',   'Wk 05–08', 'Identity and system built together, tested on real touchpoints, rules written as the work is made.', ['Identity', 'Tokens', 'Components']],
          ['Deploy',   'Wk 09–12', 'Templates, guidelines, AI tools and a team trained on all of it. Then a first-month review.', ['Guidelines', 'Templates', 'AI tools']],
      ],
  ];
  include __DIR__ . '/../partials/brand/process.php';
  ?>

  <!-- ===== one system, every touchpoint · marquee ===== -->
  <section class="band bd-touch" aria-labelledby="touch-t">
    <div class="wrap">
      <div class="head head--c bd-touch__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Every touchpoint</p>
        <h2 class="h2" id="touch-t"><span class="g">The same brand</span> on every surface</h2>
        <p class="lead">Same mark, same blue, same voice. From the app to the box it arrives in.</p>
      </div>
    </div>

    <?php
    $touch = [
        ['app',    'App'],       ['web',   'Website'],  ['mail',  'Email'],     ['social', 'Social'],
        ['box',    'Packaging'], ['sign',  'Signage'],  ['deck',  'Deck'],      ['card',   'Card'],
        ['motion', 'Motion'],    ['voice', 'Voice'],    ['store', 'Retail'],    ['doc',    'Document'],
    ];
    ?>
    <div class="bd-touch__rails" aria-hidden="true">
      <?php foreach ([['l', 0], ['r', 6]] as [$dir, $off]): ?>
        <div class="bd-touch__rail mq-hold">
          <div class="bd-touch__track mq mq--<?= $dir ?>" data-mq style="--mq-dur:58s">
            <?php for ($i = 0; $i < 12; $i++): $t = $touch[($i + $off) % 12]; ?>
              <div class="bd-touch__tile bdt bdt--<?= $t[0] ?>">
                <span class="bdt__lbl"><?= e($t[1]) ?></span>
                <span class="bdt__art">
                  <?php if ($t[0] === 'app'): ?>
                    <i class="bdt__phone"><b class="bdt__bar"></b><b class="bdt__line"></b><b class="bdt__line bdt__line--s"></b><b class="bdt__btn">›</b></i>
                  <?php elseif ($t[0] === 'web'): ?>
                    <i class="bdt__win"><b class="bdt__dots"></b><b class="bdt__hero"></b><b class="bdt__line"></b><b class="bdt__line bdt__line--s"></b></i>
                  <?php elseif ($t[0] === 'mail'): ?>
                    <i class="bdt__mail"><b class="bdt__bar"></b><b class="bdt__line"></b><b class="bdt__line bdt__line--s"></b><b class="bdt__btn">›</b></i>
                  <?php elseif ($t[0] === 'social'): ?>
                    <i class="bdt__sq"><b class="bdt__big">›</b><b class="bdt__line bdt__line--s"></b></i>
                  <?php elseif ($t[0] === 'box'): ?>
                    <i class="bdt__box"><b class="bdt__face"></b><b class="bdt__side"></b><b class="bdt__big">›</b></i>
                  <?php elseif ($t[0] === 'sign'): ?>
                    <i class="bdt__sign"><b class="bdt__big">›</b><b class="bdt__word">XTERRA EDZE</b></i>
                  <?php elseif ($t[0] === 'deck'): ?>
                    <i class="bdt__slide"><b class="bdt__line bdt__line--h"></b><b class="bdt__line"></b><b class="bdt__line bdt__line--s"></b><b class="bdt__dot"></b></i>
                  <?php elseif ($t[0] === 'card'): ?>
                    <i class="bdt__bcard"><b class="bdt__big">›</b><b class="bdt__line bdt__line--s"></b><b class="bdt__line bdt__line--xs"></b></i>
                  <?php elseif ($t[0] === 'motion'): ?>
                    <i class="bdt__mo"><b>›</b><b>›</b><b>›</b></i>
                  <?php elseif ($t[0] === 'voice'): ?>
                    <i class="bdt__wave"><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b><b></b></i>
                  <?php elseif ($t[0] === 'store'): ?>
                    <i class="bdt__store"><b class="bdt__awn"></b><b class="bdt__door"></b><b class="bdt__big">›</b></i>
                  <?php else: ?>
                    <i class="bdt__doc"><b class="bdt__line bdt__line--h"></b><b class="bdt__line"></b><b class="bdt__line"></b><b class="bdt__line bdt__line--s"></b></i>
                  <?php endif; ?>
                </span>
                <span class="bdt__foot"><i></i>on brand</span>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ===== selected brand work ===== -->
  <section class="band band--alt bd-work" aria-labelledby="work-t">
    <div class="wrap">
      <div class="head--row bd-work__head" data-rv>
        <div>
          <p class="lbl lbl--blue"><span class="dot"></span>Selected brand work</p>
          <h2 class="h2" id="work-t"><span class="g">Built,</span> then run</h2>
        </div>
        <a class="tl" href="<?= xe_url('work.php') ?>">All the work <span class="i" aria-hidden="true">›</span></a>
      </div>

      <!-- PLACEHOLDER: reference imagery and illustrative outcomes — replace with real, cleared case studies -->
      <div class="bd-work__grid" data-rv-s data-rv-step="90">
        <a class="bd-work__card" href="<?= xe_url('work.php') ?>">
          <span class="bd-work__img"><img src="<?= xe_url('assets/imgs/8599929a_o35xFsOzb7RHHzOvvCWvhTp3T5k.png') ?>" alt="Case study: consumer health brand system" width="2048" height="1332" loading="lazy" decoding="async"></span>
          <span class="bd-work__cap">
            <span class="bd-work__sector">Consumer health · nine markets</span>
            <span class="bd-work__line">One brand system, rebuilt so every market ships from the same rules.</span>
            <span class="bd-work__tags"><i>Identity</i><i>Systems</i><i>AI tools</i></span>
          </span>
        </a>
        <a class="bd-work__card" href="<?= xe_url('work.php') ?>">
          <span class="bd-work__img"><img src="<?= xe_url('assets/imgs/c69b0bdd_T5J8ZvGDJWsakqEOGBZNtykg3E0.webp') ?>" alt="Case study: B2B portfolio architecture" width="3200" height="2400" loading="lazy" decoding="async"></span>
          <span class="bd-work__cap">
            <span class="bd-work__sector">B2B technology</span>
            <span class="bd-work__line">Eleven products, one architecture, and a naming system the next launch fits into.</span>
            <span class="bd-work__tags"><i>Architecture</i><i>Foundation</i></span>
          </span>
        </a>
        <a class="bd-work__card" href="<?= xe_url('work.php') ?>">
          <span class="bd-work__img"><img src="<?= xe_url('assets/imgs/17973a26_j5zkzCoLjv3Nel6mPelVJ5OwCjM.png') ?>" alt="Case study: retail growth strategy and identity" width="2048" height="1536" loading="lazy" decoding="async"></span>
          <span class="bd-work__cap">
            <span class="bd-work__sector">Retail</span>
            <span class="bd-work__line">A next-best-customer shortlist, and an identity sharp enough to reach it.</span>
            <span class="bd-work__tags"><i>Growth</i><i>Identity</i></span>
          </span>
        </a>
      </div>
    </div>
  </section>

  <!-- ===== what we stand for in brand ===== -->
  <section class="band bd-why" aria-labelledby="why-t">
    <div class="wrap">
      <div class="head--row bd-why__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>How we do brand</p>
        <h2 class="h2" id="why-t"><span class="g">Three things</span> we will not trade away</h2>
      </div>
      <div class="bd-why__grid" data-rv-s data-rv-step="90">
        <article class="bd-why__card">
          <span class="bd-why__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5M4 19h16M8 15l3.5-4.5L15 14l5-6.5"/></svg>
          </span>
          <h3 class="h3 bd-why__t">Built from evidence</h3>
          <p class="bd-why__p">Every direction is tested on real touchpoints and real decisions before it is chosen. Taste decides between good options, never instead of them.</p>
        </article>
        <article class="bd-why__card">
          <span class="bd-why__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3.5 21 8l-9 4.5L3 8l9-4.5Z"/><path d="M3 12.5 12 17l9-4.5"/><path d="M3 16.8 12 21.3l9-4.5"/></svg>
          </span>
          <h3 class="h3 bd-why__t">One system, not one asset</h3>
          <p class="bd-why__p">A logo is the smallest part. We ship the tokens, the rules and the templates, so the brand looks the same on a surface nobody has designed yet.</p>
        </article>
        <article class="bd-why__card">
          <span class="bd-why__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10.5" rx="2.2"/><path d="M8 10V7.4a4 4 0 0 1 8 0V10"/></svg>
          </span>
          <h3 class="h3 bd-why__t">Yours to run</h3>
          <p class="bd-why__p">Source files, tokens, model weights and logs transfer on delivery. Your team is trained on it. We do not retain any of it.</p>
        </article>
      </div>
    </div>
  </section>

  <?php
  $faqId = 'faq';
  $faq = [
      'title' => 'Brand Design,<br><span class="g">asked directly</span>',
      'items' => [
          ['Where do most brand engagements start?', 'With Brand Foundation, because it is the cheapest place to be wrong. When the foundation already holds, Identity or Growth Strategy are the usual next steps.'],
          ['Can we buy one capability on its own?', 'Yes. Each of the six is scoped and priced as a sprint of its own. What changes is that the work is built to plug into the rest of the system when you are ready.'],
          ['Do you rebrand, or only build new brands?', 'Both. Most of our work is a brand that already exists and needs a sharper system around it. A new mark is the exception, not the rule.'],
          ['How do you use AI in brand work?', 'Research at volume, production at scale and the checks no team can do by hand. The decisions, and the taste, stay with people. Brand AI Tools is where the two meet.'],
          ['What do we own at the end?', 'Everything. Source files, tokens, templates, guidelines, model weights and logs ship into your accounts. Nothing is retained, resold or trained on elsewhere.'],
      ],
  ];
  include __DIR__ . '/../partials/brand/faq.php';
  include __DIR__ . '/../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
