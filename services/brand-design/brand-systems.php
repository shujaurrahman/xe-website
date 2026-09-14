<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['brand-systems'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/brand-systems.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/brand-systems.js'],
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

/* ---- the hero stage: drag the range, the components re-skin, the check holds the floor ---- */
ob_start(); ?>
<div class="bd-stage bs-flex" data-bd-live data-bd-flex style="--f:0">
  <div class="bd-stage__bar">
    <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
    <span class="bd-stage__title">Flex range <i aria-hidden="true">›</i> core to expressive</span>
    <span class="bd-stage__state"><i aria-hidden="true"></i><b class="num" data-bd-flex-val>0</b>% flex</span>
  </div>
  <div class="bd-stage__body bs-flex__body">
    <div class="bs-flex__stage" aria-hidden="true">
      <span class="bs-flex__wash"></span>
      <p class="bs-flex__h">Turn every signal into an advantage</p>
      <div class="bs-flex__row">
        <span class="bs-flex__btn">Start a project <i>›</i></span>
        <span class="bs-flex__pill">On brief</span>
      </div>
      <div class="bs-flex__card">
        <span class="bs-flex__ct">Brand system <i>›</i> v2.4</span>
        <span class="bs-flex__cl"></span>
        <span class="bs-flex__cl bs-flex__cl--s"></span>
        <span class="bs-flex__sw"><i></i><i></i><i></i></span>
      </div>
      <span class="bs-flex__mark"><?= xe_svg('xe-mark') ?></span>
    </div>

    <div class="bs-flex__ctl">
      <label class="bs-flex__lbl" for="bs-range">Expression</label>
      <input id="bs-range" class="bs-flex__range" type="range" min="0" max="100" value="0" step="1" data-bd-flex-range>
      <span class="bs-flex__ticks" aria-hidden="true"><i>Core</i><i>Campaign</i><i>Sub-brand</i><i>Limit</i></span>
    </div>

    <ul class="bs-flex__check" aria-hidden="true">
      <li><i>✓</i>Contrast 4.5:1</li>
      <li><i>✓</i>Clearspace ×1</li>
      <li><i>✓</i>Type scale</li>
      <li data-bd-flex-warn><i>✓</i><span data-bd-flex-warn-t>Palette in range</span></li>
    </ul>
  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="systems">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · tokens → components → templates ===== -->
  <section class="band band--alt bs-pipe" aria-labelledby="pipe-t">
    <div class="wrap">
      <div class="head head--c bs-pipe__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>One source</p>
        <h2 class="h2" id="pipe-t"><span class="g">Change the token,</span><br>everything downstream changes</h2>
        <p class="lead">Tokens feed components. Components feed templates. Nothing is drawn twice.</p>
      </div>

      <div class="bs-pipe__panel" data-bd-live data-bd-pipe data-rv data-rv-d="80">
        <div class="bs-pipe__col bs-pipe__col--tok">
          <p class="bs-pipe__ch">Tokens <b class="num">12</b></p>
          <button class="bs-pipe__tok" type="button" data-tok="blue"><i style="--c:var(--blue)"></i><span>colour.blue.500</span><em>#0082FB</em></button>
          <button class="bs-pipe__tok" type="button" data-tok="ink"><i style="--c:var(--ink)"></i><span>colour.ink</span><em>#19191D</em></button>
          <button class="bs-pipe__tok" type="button" data-tok="radius"><i class="bs-pipe__ti bs-pipe__ti--r"></i><span>radius.md</span><em>14px</em></button>
          <button class="bs-pipe__tok" type="button" data-tok="type"><i class="bs-pipe__ti">Aa</i><span>type.display</span><em>48 / 1.02</em></button>
          <button class="bs-pipe__tok" type="button" data-tok="space"><i class="bs-pipe__ti bs-pipe__ti--s"></i><span>space.4</span><em>16px</em></button>
          <button class="bs-pipe__tok" type="button" data-tok="motion"><i class="bs-pipe__ti">›</i><span>motion.out</span><em>.32s</em></button>
        </div>

        <div class="bs-pipe__wires" aria-hidden="true"><span><i></i></span><span><i></i></span><span><i></i></span><span><i></i></span></div>

        <div class="bs-pipe__col bs-pipe__col--comp">
          <p class="bs-pipe__ch">Components <b class="num">38</b></p>
          <div class="bs-pipe__item" data-uses="blue radius type motion"><span class="bs-pipe__cbtn">Button <i>›</i></span><em>Button</em></div>
          <div class="bs-pipe__item" data-uses="ink radius space"><span class="bs-pipe__ccard"><i></i><i></i><i></i></span><em>Card</em></div>
          <div class="bs-pipe__item" data-uses="blue ink space motion"><span class="bs-pipe__cnav"><i></i><i class="on"></i><i></i></span><em>Nav</em></div>
          <div class="bs-pipe__item" data-uses="blue type radius"><span class="bs-pipe__cbadge">On brief</span><em>Badge</em></div>
        </div>

        <div class="bs-pipe__wires" aria-hidden="true"><span><i></i></span><span><i></i></span><span><i></i></span><span><i></i></span></div>

        <div class="bs-pipe__col bs-pipe__col--tpl">
          <p class="bs-pipe__ch">Templates <b class="num">16</b></p>
          <div class="bs-pipe__item" data-uses="blue ink radius type space motion"><span class="bs-pipe__tland"><i></i><i></i><b></b></span><em>Landing</em></div>
          <div class="bs-pipe__item" data-uses="blue ink space type"><span class="bs-pipe__tmail"><i></i><i></i><b></b></span><em>Email</em></div>
          <div class="bs-pipe__item" data-uses="blue radius type"><span class="bs-pipe__tsocial"><b>›</b></span><em>Social 1:1</em></div>
          <div class="bs-pipe__item" data-uses="ink type space"><span class="bs-pipe__tdeck"><i></i><i></i><i></i></span><em>Deck</em></div>
        </div>
      </div>
      <p class="bs-pipe__note" data-bd-pipe-note aria-live="polite">Hover a token to see where it lands.</p>
    </div>
  </section>

  <!-- ===== versioned, governed, released ===== -->
  <section class="band bs-ver" aria-labelledby="ver-t">
    <div class="wrap bs-ver__grid">
      <div class="bs-ver__text" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Governance</p>
        <h2 class="h2" id="ver-t"><span class="g">Versioned, governed,</span><br>released like software.</h2>
        <p class="p">A brand system that nobody can change is dead in a year. One that anybody can change is dead in a month. Governance is the difference: who proposes, who reviews, how a change ships, and how every team knows which version it is on.</p>
        <ul class="bs-ver__flow" aria-label="How a change ships">
          <li><b>Propose</b><span>Any team, with a reason</span></li>
          <li><b>Review</b><span>The system owner, within a week</span></li>
          <li><b>Release</b><span>Tagged, noted, pushed to design and code</span></li>
        </ul>
      </div>

      <div class="bd-stage bs-ver__stage" data-bd-live data-rv data-rv-d="120" aria-hidden="true">
        <div class="bd-stage__bar">
          <span class="bd-stage__dots"><i></i><i></i><i></i></span>
          <span class="bd-stage__title">Changelog <i>›</i> brand system</span>
          <span class="bd-stage__state"><i></i>v2.4 current</span>
        </div>
        <div class="bd-stage__body bs-log">
          <div class="bs-log__row is-new">
            <span class="bs-log__v num">v2.4</span>
            <span class="bs-log__b"><b>Added</b> motion tokens · six easings, four durations</span>
            <span class="bs-log__who">Systems · this week</span>
          </div>
          <div class="bs-log__row">
            <span class="bs-log__v num">v2.3</span>
            <span class="bs-log__b"><b>Changed</b> colour.blue.500 contrast on paper-3 · now 4.6:1</span>
            <span class="bs-log__who">Product · 3 wks ago</span>
          </div>
          <div class="bs-log__row">
            <span class="bs-log__v num">v2.2</span>
            <span class="bs-log__b"><b>Added</b> campaign flex range · up to 70%</span>
            <span class="bs-log__who">Campaign · 6 wks ago</span>
          </div>
          <div class="bs-log__row">
            <span class="bs-log__v num">v2.1</span>
            <span class="bs-log__b"><b>Removed</b> legacy gradient · replaced by wash tokens</span>
            <span class="bs-log__who">Systems · 9 wks ago</span>
          </div>
          <p class="bs-log__foot"><span>Figma variables</span><i>synced</i><span>CSS · JSON</span><i>synced</i><span>Docs</span><i>synced</i></p>
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
  $faq = ['title' => 'Brand Systems,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
