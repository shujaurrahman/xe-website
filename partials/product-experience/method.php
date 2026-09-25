<?php /* DRAFT COPY — review before launch */
/* Method — the concept of the whole discipline: four gates a bet has to pass before it earns
   engineering. A schematic of one gate (pass forward, or change our mind and go back), then the four
   real gates with what enters, the test, what leaves and what happens when it fails. The shipped HTML
   is the finished state — every rail filled; method.js walks a marker across them while on screen. */
$mth_gates = [
    [
        'n' => 'G1', 'name' => 'Frame', 'q' => 'What decision are we actually making?',
        'in'   => 'An ambition, a new capability, or a number that will not move.',
        'test' => 'The decision, the constraints that are real rather than assumed, the people affected and the measure of success are written down and agreed by the people who will pay for it.',
        'out'  => 'A decision brief with a success measure and a named owner.',
        'fail' => 'We say so in writing. The engagement ends at a report, not a project.',
        'caps' => ['design-consulting-solutioning', 'product-strategy-vision'],
    ],
    [
        'n' => 'G2', 'name' => 'Evidence', 'q' => 'What would change our mind?',
        'in'   => 'Two or three routes to the same outcome, drawn to the same depth.',
        'test' => 'The assumption that would cost most to be wrong about is put in front of real users, and every route is sized by the engineers who would build it.',
        'out'  => 'One recommended route, the rejected ones recorded with their reasons, and an effort range with its assumptions written beside it.',
        'fail' => 'The route is dropped in week three, for the price of a prototype.',
        'caps' => ['product-strategy-vision', 'ai-product-strategy-development'],
    ],
    [
        'n' => 'G3', 'name' => 'Design', 'q' => 'Does it work for the people who have to use it?',
        'in'   => 'The chosen route, and the journeys it changes.',
        'test' => 'Every state is designed — empty, loading, error, offline, low confidence — accessibility acceptance criteria are written per screen, and a prototype goes through a round of sessions.',
        'out'  => 'Designs, interface copy, acceptance criteria and a usability baseline to measure the release against.',
        'fail' => 'The journey is redesigned before a line of production code is written.',
        'caps' => ['experience-design-development', 'ai-product-strategy-development'],
    ],
    [
        'n' => 'G4', 'name' => 'System', 'q' => 'Will the second screen be cheaper than the first?',
        'in'   => 'A designed experience, and the surfaces it will spread to.',
        'test' => 'Tokens, components and their states exist in design and in code, with keyboard behaviour, focus order and ARIA solved once inside the component.',
        'out'  => 'A versioned component package, documentation, and a contribution path teams can use.',
        'fail' => 'The build still ships. The next four teams pay for it, one focus bug at a time.',
        'caps' => ['system-design', 'experience-design-development'],
    ],
];
$mth_name = fn (string $mth_s): array => [$CAPS[$mth_s]['n'], $CAPS[$mth_s]['short']];
?>
<section class="band band--ink pxh-method" id="method" aria-labelledby="method-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How we decide</p>
        <h2 class="h2" id="method-t"><span class="g">Four gates</span> ahead of the build.</h2>
      </div>
      <div>
        <p class="lead">Nothing reaches engineering because it was argued for well. It reaches engineering because it passed four gates, each of which can send it back. The gates are cheap in that order and expensive in any other.</p>
      </div>
    </div>

    <div class="pxh-method__schema" data-rv>
      <p class="bdh-sr">A schematic of one gate: a bet enters from the left, meets a gate that asks what would change our mind, and either passes forward to the next gate or, if the evidence changes our mind, returns along a dashed path to be reshaped.</p>
      <div class="pxh-method__dia">
        <p class="pxh-k pxh-method__dk">The mechanism · one gate</p>
        <div class="bdh-scroll-x mask-x pxh-wide pxh-method__scroll" tabindex="0" role="group" aria-label="One gate, drawn. Scroll sideways to see all of it.">
        <svg viewBox="0 0 640 190" fill="none" focusable="false" aria-hidden="true">
          <!-- boxes -->
          <g class="pxh-method__box">
            <rect x="16" y="54" width="118" height="48" rx="8"/>
            <rect x="210" y="40" width="210" height="76" rx="8" class="is-gate"/>
            <rect x="496" y="54" width="128" height="48" rx="8"/>
          </g>
          <!-- edges, each trimmed to 8px short of the box it leaves and the box it enters -->
          <path class="pxh-edge" d="M142 78 H196"/>
          <path class="pxh-arrow" d="M196 73.5 L204 78 L196 82.5 Z"/>
          <path class="pxh-edge pxh-edge--live" d="M428 78 H482"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M482 73.5 L490 78 L482 82.5 Z"/>
          <path class="pxh-edge pxh-edge--dash" d="M315 124 V150 Q315 158 307 158 H83 Q75 158 75 150 V118"/>
          <path class="pxh-arrow" d="M70.5 118 L75 110 L79.5 118 Z"/>
          <!-- labels -->
          <g class="pxh-method__tx">
            <text x="75" y="83" text-anchor="middle">A bet</text>
            <text x="315" y="68" text-anchor="middle" class="is-k">GATE</text>
            <text x="315" y="94" text-anchor="middle">What would change our mind?</text>
            <text x="560" y="83" text-anchor="middle">Next gate</text>
            <text x="455" y="66" text-anchor="middle" class="is-k is-blue">PASS</text>
            <text x="195" y="174" text-anchor="middle" class="is-k">EVIDENCE CHANGED OUR MIND · RESHAPE IT</text>
          </g>
        </svg>
        </div>
      </div>
      <p class="pxh-note pxh-method__snote"><b>A gate is only real if it can say no.</b> Each one has a written pass condition, and the thing it produces when it fails is as defined as the thing it produces when it passes.</p>
    </div>

    <ol class="pxh-method__gates" data-bdh-live data-rv-s data-rv-step="90">
      <?php foreach ($mth_gates as $mth_i => $mth_g): ?>
        <li class="pxh-method__gate" style="--i:<?= $mth_i ?>" data-gate="<?= $mth_i ?>">
          <p class="pxh-method__gh"><span class="pxh-method__gn"><?= e($mth_g['n']) ?></span><span class="pxh-method__gname"><?= e($mth_g['name']) ?></span></p>
          <h3 class="pxh-method__gq"><?= e($mth_g['q']) ?></h3>
          <dl class="pxh-method__rows">
            <div><dt>Enters</dt><dd><?= e($mth_g['in']) ?></dd></div>
            <div><dt>The test</dt><dd><?= e($mth_g['test']) ?></dd></div>
            <div><dt>Leaves</dt><dd><?= e($mth_g['out']) ?></dd></div>
          </dl>
          <p class="pxh-method__fail"><span class="pxh-k">If it fails</span><?= e($mth_g['fail']) ?></p>
          <p class="pxh-method__who">
            <?php foreach ($mth_g['caps'] as $mth_c): [$mth_n, $mth_sh] = $mth_name($mth_c); ?>
              <a class="pxh-capl" href="#<?= e($mth_c) ?>"><b><?= e($mth_n) ?></b><span><?= e($mth_sh) ?></span><i aria-hidden="true">›</i></a>
            <?php endforeach; ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="pxh-method__hand">
      <span class="pxh-k">Then, and only then</span>
      <span class="pxh-method__hb">Build</span>
      <span class="pxh-method__hd">Engineered by your team, or by Technology &amp; Intelligence, from a specification that has already survived contact with the people who will use it.</span>
      <a class="tl pxh-method__hl" href="<?= xe_url('services/technology-intelligence.php') ?>">Technology &amp; Intelligence <span class="i" aria-hidden="true">›</span></a>
    </p>
  </div>
</section>
