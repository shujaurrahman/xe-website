<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['brand-identity'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/brand-identity.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/brand-identity.js'],
];

$MARK    = xe_svg('xe-mark');
$LOCKUP  = xe_svg('xe-lockup');
$IMG     = 'assets/imgs/brand/brand-identity/';

/* the voice lines typed in the hero specimen */
$voice = ['Precise. Kinetic. Unshowy.', 'Say less. Mean it.', 'Confidence through restraint.', 'Real detail over adjectives.'];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

/* ---- the hero stage: a live identity specimen that flips to dark ---- */
ob_start(); ?>
<div class="bd-stage bi-spec" data-bd-live data-bd-spec role="group" aria-label="Identity specimen">
  <div class="bd-stage__bar">
    <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
    <span class="bd-stage__title">Identity specimen <i aria-hidden="true">›</i> v2.4</span>
    <button class="bi-spec__toggle" type="button" data-bd-theme aria-pressed="false">
      <span class="sr">Dark theme</span>
      <span class="bi-spec__lbl" data-bd-theme-lbl aria-hidden="true">Light</span>
      <span class="bi-spec__track" aria-hidden="true"><span class="bi-spec__knob"></span></span>
    </button>
  </div>
  <div class="bd-stage__body bi-spec__body">

    <div class="bi-spec__cell bi-spec__markc" aria-hidden="true">
      <span class="bi-spec__k">Mark <em>01</em></span>
      <div class="bi-spec__mark">
        <span class="bi-spec__cs"><i></i><i></i><i></i><i></i></span>
        <span class="bi-spec__svg"><?= $MARK ?></span>
        <span class="bi-spec__dim bi-spec__dim--t"><b>×1</b></span>
        <span class="bi-spec__dim bi-spec__dim--l"><b>×1</b></span>
      </div>
      <span class="bi-spec__meta">Clearspace ×1 <i>·</i> min 24px</span>
    </div>

    <div class="bi-spec__cell bi-spec__colours" aria-hidden="true">
      <span class="bi-spec__k">Colour <em>02</em></span>
      <div class="bi-spec__chips">
        <i class="bi-spec__chip bi-spec__chip--ink"><b>Ink</b><em>#19191D</em></i>
        <i class="bi-spec__chip bi-spec__chip--blue"><b>Blue</b><em>#0082FB</em></i>
        <i class="bi-spec__chip bi-spec__chip--paper"><b>Paper</b><em>#FFFFFF</em></i>
        <i class="bi-spec__chip bi-spec__chip--muted"><b>Muted</b><em>#75757E</em></i>
      </div>
    </div>

    <div class="bi-spec__cell bi-spec__type" aria-hidden="true">
      <span class="bi-spec__k">Type <em>JetBrains Mono · one family</em></span>
      <div class="bi-spec__scale">
        <p class="bi-spec__row"><span class="bi-spec__t1">Recognisable.</span><span class="bi-spec__tm">Display · 34 · 500</span></p>
        <p class="bi-spec__row"><span class="bi-spec__t2">One brand, everywhere</span><span class="bi-spec__tm">Heading · 20 · −0.04em</span></p>
        <p class="bi-spec__row"><span class="bi-spec__t3">Real detail over adjectives.</span><span class="bi-spec__tm">Body · 15 / 1.65</span></p>
        <p class="bi-spec__row"><span class="bi-spec__t4">Label · uppercase</span><span class="bi-spec__tm">Label · 11 · 0.16em</span></p>
      </div>
    </div>

    <div class="bi-spec__cell bi-spec__voice">
      <span class="bi-spec__k" aria-hidden="true">Voice <em>03</em></span>
      <p class="bi-spec__line">
        <span class="bi-spec__typed" data-bd-type="<?= e(implode('|', $voice)) ?>" aria-live="off" aria-hidden="true"><?= e($voice[0]) ?></span><i class="bi-spec__caret" aria-hidden="true"></i>
        <span class="sr">Voice: <?= e(implode(' ', $voice)) ?></span>
      </p>
      <span class="bi-spec__never" aria-hidden="true"><em>Never</em><s>seamless</s><s>elevate</s><s>unlock</s></span>
    </div>

    <div class="bi-spec__cell bi-spec__glyphs" aria-hidden="true">
      <span class="bi-spec__k">Glyphs <em>04</em></span>
      <div class="bi-spec__gl"><i>›</i><i>×</i><i>·</i><i>—</i></div>
    </div>

  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="identity">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · three codes, one brand ===== -->
  <section class="band band--alt bi-codes" aria-labelledby="codes-t">
    <span class="bi-codes__dots" aria-hidden="true"></span>
    <div class="wrap">
      <div class="head head--c bi-codes__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Three codes</p>
        <h2 class="h2" id="codes-t"><span class="g">How it looks, how it sounds,</span> how it behaves</h2>
        <p class="lead">Designed together by one team, so a brand does not look calm and sound frantic.</p>
      </div>

      <div class="bi-codes__grid" data-rv-s data-rv-step="110">

        <!-- visual · the construction grid -->
        <article class="bi-code">
          <div class="bi-code__top">
            <p class="bi-code__lbl"><span class="num">01</span>Visual</p>
            <span class="bi-code__state">Construction</span>
          </div>
          <div class="bi-code__mock bi-clear" data-bd-live aria-hidden="true">
            <span class="bi-clear__grid"></span>
            <span class="bi-clear__axis bi-clear__axis--x"></span>
            <span class="bi-clear__axis bi-clear__axis--y"></span>
            <span class="bi-clear__box"><i></i><i></i><i></i><i></i></span>
            <span class="bi-clear__bound"></span>
            <span class="bi-clear__mark"><?= $MARK ?></span>
            <span class="bi-clear__guide bi-clear__guide--t"><i></i><b>×1</b></span>
            <span class="bi-clear__guide bi-clear__guide--l"><i></i><b>×1</b></span>
            <span class="bi-clear__min"><span class="bi-clear__tiny"><?= $MARK ?></span>min 24px</span>
            <span class="bi-clear__unit"><i></i>×1 = chevron width</span>
          </div>
          <h3 class="h3 bi-code__t">Clearspace, construction, minimum size</h3>
          <p class="bi-code__d">The mark is drawn with its own rules: how much room it needs, how small it can go, what it may sit on.</p>
        </article>

        <!-- verbal · the tone slider -->
        <article class="bi-code">
          <div class="bi-code__top">
            <p class="bi-code__lbl"><span class="num">02</span>Verbal</p>
            <span class="bi-code__state"><i class="bi-code__lock" aria-hidden="true"></i>Voice locked</span>
          </div>
          <div class="bi-code__mock bi-tone" data-bd-tone>
            <div class="bi-tone__msg">
              <span class="bi-tone__from" aria-hidden="true"><span class="bi-tone__av"><?= $MARK ?></span>Order update<em>now</em></span>
              <!-- the three variants of one message, from plain to warm -->
              <p class="bi-tone__line" data-bd-tone-line aria-live="polite"
                 data-v0="Your order has shipped. It arrives Friday."
                 data-v1="Your order is on its way. Expect it on Friday."
                 data-v2="Good news: your order is on its way. See you Friday.">Your order has shipped. It arrives Friday.</p>
            </div>
            <div class="bi-tone__ctl">
              <div class="bi-tone__head">
                <label class="bi-tone__lab" for="bi-tone-range">Tone</label>
                <span class="bi-tone__val" data-bd-tone-val aria-hidden="true">Plain</span>
              </div>
              <div class="bi-tone__rail">
                <input class="bi-tone__range" id="bi-tone-range" type="range" min="0" max="2" step="1" value="0" aria-valuetext="Plain" data-bd-tone-range>
                <span class="bi-tone__ticks" aria-hidden="true"><i></i><i></i><i></i></span>
              </div>
              <span class="bi-tone__ends" aria-hidden="true"><i>Plain</i><i>Neutral</i><i>Warm</i></span>
            </div>
            <div class="bi-tone__lex" aria-hidden="true">
              <span class="bi-tone__lr"><em>Use</em><b>arrives</b><b>ready</b><b>fixed</b></span>
              <span class="bi-tone__lr"><em>Never</em><s>delight</s><s>journey</s></span>
            </div>
          </div>
          <h3 class="h3 bi-code__t">Voice fixed, tone moves</h3>
          <p class="bi-code__d">One voice, a range of tone for the moment, and a lexicon of words the brand uses and words it never does.</p>
        </article>

        <!-- behavioural · the moments -->
        <article class="bi-code">
          <div class="bi-code__top">
            <p class="bi-code__lbl"><span class="num">03</span>Behavioural</p>
            <span class="bi-code__state">Moments</span>
          </div>
          <div class="bi-code__mock bi-moments" data-bd-cycle="2600" aria-hidden="true">
            <span class="bi-moments__rail"></span>
            <div class="bi-moments__row is-on" data-bd-cycle-i>
              <span class="bi-moments__node"></span>
              <span class="bi-moments__m">First open</span>
              <span class="bi-moments__bub">Welcome. Here is the one thing to do first.</span>
            </div>
            <div class="bi-moments__row" data-bd-cycle-i>
              <span class="bi-moments__node"></span>
              <span class="bi-moments__m">Something broke</span>
              <span class="bi-moments__bub">That was us. Fixed in 40 seconds. Nothing was lost.</span>
            </div>
            <div class="bi-moments__row" data-bd-cycle-i>
              <span class="bi-moments__node"></span>
              <span class="bi-moments__m">Goodbye</span>
              <span class="bi-moments__bub">Your data is exported and deleted. Thank you for the time.</span>
            </div>
          </div>
          <h3 class="h3 bi-code__t">Principles for the moments that matter</h3>
          <p class="bi-code__d">How the brand acts when it matters most, written as principles with worked examples the team can copy.</p>
        </article>

      </div>
    </div>
  </section>

  <!-- ===== identity, applied · the mockup wall ===== -->
  <section class="band bi-applied" aria-labelledby="applied-t" data-bi-applied>
    <div class="wrap">
      <div class="head head--row bi-applied__head" data-rv>
        <div class="bi-applied__hl">
          <p class="lbl lbl--blue"><span class="dot"></span>Identity, applied</p>
          <h2 class="h2" id="applied-t"><span class="g">Tested on the surfaces</span> it has to live on</h2>
        </div>
        <div class="bi-applied__hr">
          <p class="lead">Directions are judged on real touchpoints, never on a poster. The same rules hold on a card, a screen, a sign and a box.</p>
          <p class="bi-applied__hint"><i aria-hidden="true"></i>Hover or focus a surface to see the rule it follows</p>
        </div>
      </div>

      <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/brand-identity/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
      <div class="bi-wall" data-rv-s data-rv-step="70">

        <figure class="bi-tile bi-tile--cards" tabindex="0" aria-describedby="bi-r1">
          <div class="bi-tile__stage" style="--ar:1400/933" data-w="1400" data-h="933">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'business-cards.jpg') ?>" width="1400" height="933" alt="Two stacks of business cards, one printed with the Xterra Edze mark, the other reversed out of ink with the lockup" loading="lazy" decoding="async">
              <div class="bi-art bi-art--card" data-quad="540,510 933,296 1107,495 722,737" style="width:340px;height:220px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__mark"><?= $MARK ?></span>
                <span class="bi-art__meta"><b>Studio</b>New Delhi · New York · Singapore</span>
              </div>
              <div class="bi-art bi-art--cardback" data-quad="197,362 583,158 742,352 350,567" style="width:340px;height:220px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__lock"><?= $LOCKUP ?></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">01</span><span class="bi-tile__nm">Business cards</span>
            <span class="bi-tile__rule" id="bi-r1"><b>Rule</b>Mark on the front. Lockup reversed out of ink on the back. Clearspace ×1 on both.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--phone" tabindex="0" aria-describedby="bi-r2">
          <div class="bi-tile__stage" style="--ar:1100/927" data-w="1100" data-h="927">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'phone-hand.jpg') ?>" width="1100" height="927" alt="A hand holding a phone showing an app launch screen with the Xterra Edze mark on ink" loading="lazy" decoding="async">
              <div class="bi-art bi-art--app" data-quad="525,57 762,160 497,655 254,537" style="width:240px;height:520px" aria-hidden="true">
                <span class="bi-art__notch"></span>
                <span class="bi-art__status"><b>9:41</b><i></i></span>
                <span class="bi-art__cs"></span>
                <span class="bi-art__mark"><?= $MARK ?></span>
                <span class="bi-art__load"><i></i></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">02</span><span class="bi-tile__nm">Launch screen</span>
            <span class="bi-tile__rule" id="bi-r2"><b>Rule</b>Mark centred on ink. The chevron is the only blue on the screen.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--letter" tabindex="0" aria-describedby="bi-r3">
          <div class="bi-tile__stage" style="--ar:1/1" data-w="1100" data-h="1100">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'letterhead.jpg') ?>" width="1100" height="1100" alt="Two sheets of letterhead with the Xterra Edze lockup set top left" loading="lazy" decoding="async">
              <div class="bi-art bi-art--letter" data-quad="453,222 863,342 698,920 287,800" style="width:420px;height:594px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__lock"><?= $LOCKUP ?></span>
                <span class="bi-art__addr"><i></i><i></i><i></i></span>
                <span class="bi-art__lines"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></span>
                <span class="bi-art__foot"><b>›</b><i></i></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">03</span><span class="bi-tile__nm">Letterhead</span>
            <span class="bi-tile__rule" id="bi-r3"><b>Rule</b>Lockup top left at ×1 clearspace. One typeface, one text size, one rule.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--sign" tabindex="0" aria-describedby="bi-r4">
          <div class="bi-tile__stage" style="--ar:1400/933" data-w="1400" data-h="933">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'signage-lightbox.jpg') ?>" width="1400" height="933" alt="A hanging lightbox sign in a concourse showing the Xterra Edze lockup and a wayfinding arrow" loading="lazy" decoding="async">
              <div class="bi-art bi-art--sign" data-quad="352,109 1121,110 1122,543 354,541" style="width:720px;height:405px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__lock"><?= $LOCKUP ?></span>
                <span class="bi-art__way"><b>Studio</b><em>Level 02</em><i>›</i></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">04</span><span class="bi-tile__nm">Wayfinding</span>
            <span class="bi-tile__rule" id="bi-r4"><b>Rule</b>Lockup reversed on ink. Arrows are the chevron, never a new icon.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--tote" tabindex="0" aria-describedby="bi-r5">
          <div class="bi-tile__stage" style="--ar:1100/733" data-w="1100" data-h="733">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'tote-carried.jpg') ?>" width="1100" height="733" alt="A canvas tote bag carried at arm's length, printed with the Xterra Edze mark" loading="lazy" decoding="async">
              <div class="bi-art bi-art--tote" data-quad="486,372 618,374 617,485 485,484" style="width:200px;height:170px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__mark"><?= $MARK ?></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">05</span><span class="bi-tile__nm">Tote</span>
            <span class="bi-tile__rule" id="bi-r5"><b>Rule</b>Mark only, centred. Never stretched to fill the bag.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--box" tabindex="0" aria-describedby="bi-r6">
          <div class="bi-tile__stage" style="--ar:1200/800" data-w="1200" data-h="800">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'mailer-box.jpg') ?>" width="1200" height="800" alt="A white mailer box, top view, with the Xterra Edze mark bleeding off one edge" loading="lazy" decoding="async">
              <div class="bi-art bi-art--box" data-quad="238,186 959,186 957,606 238,607" style="width:720px;height:420px" aria-hidden="true">
                <span class="bi-art__big"><?= $MARK ?></span>
                <span class="bi-art__cs"></span>
                <span class="bi-art__lock"><?= $LOCKUP ?></span>
                <span class="bi-art__code">XE—PK·01</span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">06</span><span class="bi-tile__nm">Packaging</span>
            <span class="bi-tile__rule" id="bi-r6"><b>Rule</b>Mark bleeds off the edge at a fixed crop. Lockup small, top left.</span>
          </figcaption>
        </figure>

        <figure class="bi-tile bi-tile--cup" tabindex="0" aria-describedby="bi-r7">
          <div class="bi-tile__stage" style="--ar:1100/733" data-w="1100" data-h="733">
            <div class="bi-tile__px">
              <img src="<?= xe_url($IMG . 'cup-hand.jpg') ?>" width="1100" height="733" alt="A hand resting on a takeaway cup printed with a small Xterra Edze mark" loading="lazy" decoding="async">
              <div class="bi-art bi-art--cup" data-quad="352,318 446,318 444,398 354,398" style="width:150px;height:128px" aria-hidden="true">
                <span class="bi-art__cs"></span>
                <span class="bi-art__mark"><?= $MARK ?></span>
              </div>
            </div>
          </div>
          <figcaption class="bi-tile__cap">
            <span class="bi-tile__n">07</span><span class="bi-tile__nm">Takeaway cup</span>
            <span class="bi-tile__rule" id="bi-r7"><b>Rule</b>Below 30 mm the mark stands alone. The lockup never goes that small.</span>
          </figcaption>
        </figure>

      </div>
    </div>
  </section>

  <!-- ===== drift ⇄ system · a before and after you can drag ===== -->
  <section class="band band--alt bi-drift" aria-labelledby="drift-t">
    <div class="wrap">
      <div class="head head--c bi-drift__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Drift, then system</p>
        <h2 class="h2" id="drift-t"><span class="g">Same three touchpoints.</span> One set of rules.</h2>
        <p class="lead">On the left, every team made its own call. On the right, every call was already made in the identity. Drag across to compare.</p>
      </div>

      <!-- PLACEHOLDER: illustrative before and after, drawn for layout — not a client's real work -->
      <div class="bi-cmp" data-bi-cmp data-rv data-rv-d="80" style="--pos:50%">

        <?php foreach (['drift', 'system'] as $mode): $d = $mode === 'drift'; ?>
        <div class="bi-cmp__layer bi-cmp__layer--<?= $mode ?>" aria-hidden="true">
          <div class="bi-board bi-board--<?= $mode ?>">

            <div class="bi-pc bi-pc--web">
              <span class="bi-pc__k">Website</span>
              <div class="bi-web">
                <div class="bi-web__nav">
                  <span class="bi-web__mark"><?= $MARK ?><?php if ($d): ?><i class="bi-pin">1</i><?php endif; ?></span>
                  <span class="bi-web__links"><i>Work</i><i>Approach</i><i>Studio</i></span>
                  <span class="bi-web__btn">Start a project<?php if ($d): ?><i class="bi-pin">3</i><?php endif; ?></span>
                </div>
                <p class="bi-web__h"><?= $d ? 'The Future Of Brand Is HERE' : 'Build what happens next.' ?><?php if ($d): ?><i class="bi-pin">5</i><?php endif; ?></p>
                <p class="bi-web__p"><?= $d ? 'Next-level synergy for forward-thinking teams.' : 'Strategy, craft and technology in one team.' ?></p>
                <span class="bi-web__cta"><?= $d ? 'Learn more' : 'See the work' ?> <i>›</i></span>
              </div>
            </div>

            <div class="bi-pc bi-pc--post">
              <span class="bi-pc__k">Social post</span>
              <div class="bi-post">
                <p class="bi-post__h"><?= $d ? 'BIG NEWS. WE HAVE A NEW LOOK' : 'Say less. Mean it.' ?><?php if ($d): ?><i class="bi-pin">6</i><?php endif; ?></p>
                <span class="bi-post__foot">
                  <span class="bi-post__mark"><?= $MARK ?><?php if ($d): ?><i class="bi-pin">2</i><?php endif; ?></span>
                  <span class="bi-post__meta">Brand notes <i>·</i> 04</span>
                </span>
              </div>
            </div>

            <div class="bi-pc bi-pc--mail">
              <span class="bi-pc__k">Email</span>
              <div class="bi-mail">
                <span class="bi-mail__from"><span class="bi-mail__av"><?= $MARK ?></span><b>Xterra Edze</b><em>09:12</em></span>
                <p class="bi-mail__s"><?= $d ? 'Hey there, exciting stuff inside' : 'Your brief is booked for Thursday' ?></p>
                <span class="bi-mail__lines"><i></i><i></i><i></i></span>
                <span class="bi-mail__btn"><?= $d ? 'CLICK HERE' : 'Open the brief' ?><?php if ($d): ?><i class="bi-pin">4</i><?php endif; ?></span>
                <span class="bi-mail__lock"><?= $LOCKUP ?></span>
              </div>
            </div>

          </div>
        </div>
        <?php endforeach; ?>

        <span class="bi-cmp__tag bi-cmp__tag--l" aria-hidden="true"><i></i>Drift</span>
        <span class="bi-cmp__tag bi-cmp__tag--r" aria-hidden="true">System<i></i></span>

        <div class="bi-cmp__handle" role="slider" tabindex="0" aria-label="Compare drift with system" aria-orientation="horizontal"
             aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" aria-valuetext="50% system" data-bi-cmp-h>
          <span class="bi-cmp__line" aria-hidden="true"></span>
          <span class="bi-cmp__knob" aria-hidden="true"><i>‹</i><i>›</i></span>
        </div>
      </div>

      <div class="bi-drift__legend" data-rv data-rv-d="140">
        <div class="bi-drift__col bi-drift__col--drift">
          <p class="bi-drift__lh"><span>Drift</span><em>6 calls made six ways</em></p>
          <ol class="bi-drift__list">
            <li><i>1</i>Mark squeezed to fit the bar</li>
            <li><i>2</i>Mark recoloured, chevron lost</li>
            <li><i>3</i>Three button styles, four radii</li>
            <li><i>4</i>A call to action that says nothing</li>
            <li><i>5</i>Title case, then capitals</li>
            <li><i>6</i>Copy that shouts</li>
          </ol>
        </div>
        <div class="bi-drift__col bi-drift__col--system">
          <p class="bi-drift__lh"><span>System</span><em>Every call made once</em></p>
          <ul class="bi-drift__list">
            <li><i>›</i>One mark, one clearspace, one size step</li>
            <li><i>›</i>One button, one radius, ink on paper</li>
            <li><i>›</i>The chevron is the only blue</li>
            <li><i>›</i>Sentence case, short active sentences</li>
            <li><i>›</i>The same voice on every surface</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== the guidelines, as a product ===== -->
  <section class="band bi-guide" aria-labelledby="guide-t">
    <div class="wrap bi-guide__grid">
      <div class="bi-guide__text" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Guidelines that get used</p>
        <h2 class="h2" id="guide-t"><span class="g">Not a PDF.</span> A living reference.</h2>
        <p class="p">Every rule lives online, next to the asset it governs, with the code and the design side by side. Searchable, versioned, and updated the day the identity changes.</p>
        <ul class="bi-guide__list">
          <li><i class="chev" aria-hidden="true">›</i>Every asset downloadable in the format each team needs</li>
          <li><i class="chev" aria-hidden="true">›</i>Do and do-not examples for every rule</li>
          <li><i class="chev" aria-hidden="true">›</i>Versioned, with a changelog the team can read</li>
        </ul>
        <a class="tl" href="<?= xe_url('services/brand-design/brand-systems.php') ?>">See how it becomes a system <span class="i" aria-hidden="true">›</span></a>
      </div>

      <div class="bd-stage bi-guide__stage" data-bd-live data-rv data-rv-d="120" aria-hidden="true">
        <div class="bd-stage__bar">
          <span class="bd-stage__dots"><i></i><i></i><i></i></span>
          <span class="bi-guide__url"><i class="bi-guide__lock"></i>brand.xterraedze.com<em>/guidelines</em></span>
          <span class="bd-stage__state"><i></i>v2.4</span>
        </div>
        <div class="bi-guide__body">
          <div class="bi-guide__nav" data-bd-cycle="3200" data-bi-guide-nav>
            <span class="bi-guide__brand"><?= $MARK ?>Guidelines</span>
            <p class="bi-guide__nh">Identity</p>
            <span class="bi-guide__ni is-on" data-bd-cycle-i><i></i>Logo</span>
            <span class="bi-guide__ni" data-bd-cycle-i><i></i>Colour</span>
            <span class="bi-guide__ni" data-bd-cycle-i><i></i>Type</span>
            <span class="bi-guide__ni" data-bd-cycle-i><i></i>Voice</span>
            <span class="bi-guide__ni" data-bd-cycle-i><i></i>Motion</span>
            <p class="bi-guide__nh">System</p>
            <span class="bi-guide__ni"><i></i>Tokens</span>
            <span class="bi-guide__ni"><i></i>Components</span>
            <span class="bi-guide__log"><b>Changelog</b>v2.4 · clearspace updated</span>
          </div>

          <div class="bi-guide__main">
            <div class="bi-guide__top">
              <span class="bi-guide__search"><i class="bi-guide__glass"></i><span class="bi-guide__q" data-bi-guide-q>logo</span><kbd>⌘K</kbd></span>
            </div>

            <div class="bi-guide__panes">
              <!-- logo -->
              <div class="bi-guide__pane is-on" data-bi-guide-pane>
                <p class="bi-guide__ph">Identity <i>›</i> <b>Logo</b></p>
                <p class="bi-guide__pd">Keep ×1 clear on every side. Never distort, rotate or recolour the mark.</p>
                <div class="bi-guide__ex">
                  <span class="bi-guide__card bi-guide__card--do"><span class="bi-guide__art"><span class="bi-guide__cs"></span><?= $MARK ?></span><b class="bi-guide__badge bi-guide__badge--do">✓</b><em>Clearspace ×1</em></span>
                  <span class="bi-guide__card bi-guide__card--stretch"><span class="bi-guide__art"><?= $MARK ?></span><b class="bi-guide__badge">×</b><em>Stretched</em></span>
                  <span class="bi-guide__card bi-guide__card--rotate"><span class="bi-guide__art"><?= $MARK ?></span><b class="bi-guide__badge">×</b><em>Rotated</em></span>
                  <span class="bi-guide__card bi-guide__card--clash"><span class="bi-guide__art"><?= $MARK ?></span><b class="bi-guide__badge">×</b><em>On blue</em></span>
                </div>
                <div class="bi-guide__dl"><span><i></i>xe-mark.svg</span><span><i></i>xe-mark.png</span><span><i></i>xe-lockup.svg</span></div>
              </div>
              <!-- colour -->
              <div class="bi-guide__pane" data-bi-guide-pane>
                <p class="bi-guide__ph">Identity <i>›</i> <b>Colour</b></p>
                <p class="bi-guide__pd">Ink and paper carry the brand. Blue is the accent, used once per surface.</p>
                <div class="bi-guide__sw">
                  <span class="bi-guide__swi bi-guide__swi--ink"><i></i><b>Ink</b><em>--ink · #19191D</em></span>
                  <span class="bi-guide__swi bi-guide__swi--blue"><i></i><b>Blue</b><em>--blue · #0082FB</em></span>
                  <span class="bi-guide__swi bi-guide__swi--paper"><i></i><b>Paper</b><em>--paper · #FFFFFF</em></span>
                </div>
                <div class="bi-guide__ratio"><span class="bi-guide__bar"><i style="--w:78%"></i><i style="--w:18%"></i><i style="--w:4%"></i></span><em>Paper 78 · Ink 18 · Blue 4</em></div>
                <div class="bi-guide__dl"><span><i></i>tokens.json</span><span><i></i>palette.ase</span></div>
              </div>
              <!-- type -->
              <div class="bi-guide__pane" data-bi-guide-pane>
                <p class="bi-guide__ph">Identity <i>›</i> <b>Type</b></p>
                <p class="bi-guide__pd">One family at every size. Headings 500, tight tracking. Body 400.</p>
                <div class="bi-guide__ts">
                  <span class="bi-guide__tr"><em>D1</em><b class="bi-guide__t1">Aa Recognisable</b></span>
                  <span class="bi-guide__tr"><em>H2</em><b class="bi-guide__t2">Aa One brand, everywhere</b></span>
                  <span class="bi-guide__tr"><em>Body</em><b class="bi-guide__t3">Aa Real detail over adjectives, set at 15 / 1.65.</b></span>
                </div>
                <div class="bi-guide__dl"><span><i></i>type-scale.css</span><span><i></i>fonts.zip</span></div>
              </div>
              <!-- voice -->
              <div class="bi-guide__pane" data-bi-guide-pane>
                <p class="bi-guide__ph">Identity <i>›</i> <b>Voice</b></p>
                <p class="bi-guide__pd">Precise. Kinetic. Unshowy. Short active sentences, no exclamation marks.</p>
                <div class="bi-guide__vo">
                  <span class="bi-guide__vr bi-guide__vr--do"><b class="bi-guide__badge bi-guide__badge--do">✓</b>Fixed in 40 seconds. Nothing was lost.</span>
                  <span class="bi-guide__vr"><b class="bi-guide__badge">×</b><s>We sincerely apologise for any inconvenience caused</s></span>
                </div>
                <div class="bi-guide__dl"><span><i></i>lexicon.csv</span><span><i></i>voice.pdf</span></div>
              </div>
              <!-- motion -->
              <div class="bi-guide__pane" data-bi-guide-pane>
                <p class="bi-guide__ph">Identity <i>›</i> <b>Motion</b></p>
                <p class="bi-guide__pd">Things arrive fast and settle slowly. One easing curve, three durations.</p>
                <div class="bi-guide__mo">
                  <svg class="bi-guide__curve" viewBox="0 0 120 80" fill="none"><path class="bi-guide__cg" d="M4 76H116M4 76V4"/><path class="bi-guide__cp" d="M4 76C30 76 30 4 116 4"/></svg>
                  <span class="bi-guide__dur"><b>0.18s</b><b>0.32s</b><b>0.60s</b><em>cubic-bezier(.22,1,.36,1)</em></span>
                </div>
                <div class="bi-guide__dl"><span><i></i>motion.json</span><span><i></i>easing.css</span></div>
              </div>
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
  include __DIR__ . '/../../partials/brand/outcomes.php';
  include __DIR__ . '/../../partials/brand/pairs.php';
  $faqId = 'faq';
  $faq = ['title' => 'Brand Identity,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
