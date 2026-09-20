<?php /* DRAFT COPY — review before launch */
/* 07 · Release lane — AI in the delivery loop, people at the merge button. One pull request walks an eight-stop lane
   timed by the clock (approved design at 09:10 → released and watched on Thursday). Each stop names who acts: an
   agent drafts, a person decides, the pipeline runs. Four panels light up as the lane reaches them: the component an
   agent drafts from design-system tokens (and the lines an engineer changes), the Playwright tests an agent writes, a
   visual diff with an AI summary (a real before/after slider), and the RUM guard that rolls a release back when p75
   INP regresses by more than 20%. release.js plays the lane while on screen and stops on the first interaction; the
   stops are buttons that jump to that moment. The HTML is the finished state: every stop done, every panel lit.
   Times, counts and values are illustrative. */
$twa_rl_stops = [   // time, stop, actor key, detail, panel that lights (a–d) or ''
    ['09:10', 'Design approved',    'person',   'Designer signs off the saved-address frame in Figma', ''],
    ['09:38', 'Component drafted',  'agent',    'Agent drafts AddressCard from design-system tokens, 3 files', 'a'],
    ['10:05', 'Engineer edits',     'person',   'Engineer rewrites the empty state, 6 lines changed', 'a'],
    ['10:40', 'Tests written',      'agent',    'Agent drafts 14 Playwright tests; the engineer reviews each', 'b'],
    ['11:12', 'Preview live',       'pipeline', 'pr-418.preview.your-platform.dev, all gates green', ''],
    ['14:30', 'Diff reviewed',      'person',   'AI summary checked against the visual diff', 'c'],
    ['15:02', 'Merged by a person', 'person',   'Code-owner approval; agent accounts cannot merge', ''],
    ['Thu 10:00', 'Released, watched', 'pipeline', '10% → 50% → 100% behind a RUM guard', 'd'],
];
$twa_rl_actor = ['agent' => ['Agent', 'agent'], 'person' => ['Person', 'approve'], 'pipeline' => ['Pipeline', 'pipeline']];
$twa_rl_from  = [];   // panel => first stop index that lights it
foreach ($twa_rl_stops as $twa_i => $twa_st) { if ($twa_st[4] !== '' && !isset($twa_rl_from[$twa_st[4]])) $twa_rl_from[$twa_st[4]] = $twa_i; }
$twa_rl_last = count($twa_rl_stops) - 1;

/* component draft: code lines, [text, kind] — kind '' plain, 'add' engineer's edit.
   Every line is kept under 50 characters so the block never clips at the narrowest column it is drawn in. */
$twa_rl_code = [
    ['<span class="k">export function</span> <span class="f">AddressCard</span>(p: Props) {', ''],
    ['  <span class="k">const</span> { address, isDefault } = p;', ''],
    ['  <span class="k">return</span> (', ''],
    ['    &lt;<span class="t">Card</span> pad=<span class="s">"space.4"</span> radius=<span class="s">"radius.md"</span>&gt;', ''],
    ['      &lt;<span class="t">Text</span> variant=<span class="s">"label"</span>&gt;{address.name}&lt;/<span class="t">Text</span>&gt;', ''],
    ['      &lt;<span class="t">AddressLines</span> lines={address.lines} /&gt;', ''],
    ['      {isDefault &amp;&amp; &lt;<span class="t">Badge</span>&gt;Default&lt;/<span class="t">Badge</span>&gt;}', ''],
    ['      {!address.lines.length &amp;&amp; &lt;<span class="t">EmptyHint</span> /&gt;}', 'add'],
    ['    &lt;/<span class="t">Card</span>&gt;', ''],
    ['  );', ''],
    ['}', ''],
];
/* the design-system tokens the drafted component uses, and what each one resolves to. An agent may only reach for
   tokens the system exports; a raw value fails review. [token, resolved, what it controls] */
$twa_rl_tokens = [
    ['space.4',    '16 px',        'Card padding, both axes'],
    ['radius.md',  '10 px',        'Corner radius on the card'],
    ['text.label', '13 px / 1.3',  'The address name line'],
    ['tone.neutral', 'ink-2 on paper-2', 'The default badge'],
];
/* agent-written tests: [name, time]. All fourteen specs in the file are listed — nothing is hidden behind "… more". */
$twa_rl_tests = [
    ['Selects a saved address with the keyboard', '1.2s'],
    ['Adds an address at 320 px without sideways scrolling', '1.8s'],
    ['Announces the default address to screen readers', '0.9s'],
    ['Keeps focus visible under the sticky footer (WCAG 2.4.11)', '1.1s'],
    ['Tap targets at least 24 × 24 px (WCAG 2.5.8)', '0.7s'],
    ['Survives a dropped connection mid-submit', '2.4s'],
    ['Rejects a postcode the address service cannot resolve', '1.3s'],
    ['Keeps the chosen address after a refresh', '1.0s'],
    ['Edits an address without emptying the cart', '1.6s'],
    ['Deletes the default and promotes the next address', '1.4s'],
    ['Reflows to one column at 200% browser zoom', '1.5s'],
    ['Honours prefers-reduced-motion on the card transition', '0.6s'],
    ['Blocks submit until the required fields are valid', '1.1s'],
    ['Restores the queued address when the signal returns', '2.8s'],
];
/* Playwright projects: 14 specs run against each profile, so 56 runs in total. [profile, engine, passed] */
$twa_rl_profiles = [
    ['Chromium', 'Desktop · 1440 × 900', 14],
    ['WebKit',   'Desktop · 1440 × 900', 14],
    ['Pixel 7',  'Android · Chrome',     14],
    ['iPhone 15', 'iOS · Safari',        14],
];
$twa_rl_specs = count($twa_rl_tests);
$twa_rl_runs  = $twa_rl_specs * count($twa_rl_profiles);
$twa_rl_secs  = array_sum(array_map(fn ($twa_t) => (float) $twa_t[1], $twa_rl_tests));
/* visual diff: AI summary items, keyed to the numbered boxes on the "after" render */
$twa_rl_diff = [
    ['Saved addresses listed above the form', 'expected · in the ticket'],
    ['Continue button 40 → 48 px tall', 'expected · design system v4'],
    ['Delivery estimate moved under the total', 'flagged for a person · approved'],
];

/* RUM guard chart: p75 INP (ms) per minute after release 43 starts at 10% of traffic. Guard = baseline × 1.2. */
$twa_rl_base  = 150;
$twa_rl_guard = (int) round($twa_rl_base * 1.2);
$twa_rl_pts   = [[0, 148], [4, 151], [8, 149], [12, 152], [15, 150], [17, 166], [19, 188], [21, 203], [22, 205], [23, 196], [25, 172], [27, 156], [30, 150], [36, 149], [42, 151], [48, 148], [54, 150], [60, 149]];
$twa_rl_x = fn (float $m): float => round(44 + $m / 60 * 340, 1);
$twa_rl_y = fn (float $v): float => round(156 - ($v - 100) / 140 * 132, 1);
$twa_rl_d = 'M' . implode(' L', array_map(fn ($twa_p) => $twa_rl_x($twa_p[0]) . ' ' . $twa_rl_y($twa_p[1]), $twa_rl_pts));
$twa_rl_log = [
    ['+0 m',  'Release 43 to 10% of traffic', ''],
    ['+22 m', 'p75 INP 205 ms · guard ' . $twa_rl_guard . ' ms (+20% on ' . $twa_rl_base . ' ms)', 'is-warn'],
    ['+22 m', 'Rolled back to release 42 · automatic · 48 s', 'is-roll'],
    ['+30 m', 'p75 INP back to 150 ms · incident note drafted by an agent', ''],
    ['+31 m', 'Engineer owns the fix · next release waits for a person', ''],
];
$twa_rl_guards = [
    ['lock',  'Agents never merge', 'Branch protection needs a code-owner approval. Agent accounts can open, comment and suggest; they cannot approve or merge.'],
    ['log',   'Every agent step is logged', 'Prompts, tool calls and diffs stay attached to the pull request, so the reviewer sees what the agent saw.'],
    ['shield', 'Your code stays yours', 'Enterprise tools with retention off. No client code goes into a tool that trains on it.'],
    ['rollback', 'Rollback is automatic; fixes are not', 'The guard reverts in seconds. A person decides what ships next, and when.'],
];
$twa_rl_tools = ['figma', 'githubcopilot', 'cursor', 'github', 'githubactions', 'playwright', 'storybook', 'vercel', 'sentry', 'datadog'];
?>
<section class="band band--ink twa-release" id="release" aria-labelledby="release-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>07 · Release lane</b><span>Agents draft · people decide · the pipeline guards</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="release-t"><span class="g">AI in the delivery loop,</span> people at the merge button.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Agents do the drafting that used to take days: components from the design system, end-to-end tests, a summary of every visual change. Engineers edit, review and merge. After release, real-user data decides whether the change stays.</p>
      </div>
    </div>

    <div class="twa-rl" data-rv>
      <p class="bdh-sr">Illustration of one pull request moving through the release lane in a day. At 09:10 a designer approves the design. At 09:38 an agent drafts the component from design-system tokens, and at 10:05 an engineer edits it. At 10:40 an agent drafts fourteen Playwright tests that the engineer reviews. At 11:12 a preview deploy is live with every gate green. At 14:30 a person checks the AI summary of the visual diff. At 15:02 a person merges it; agents cannot merge. On Thursday the release rolls out behind a real-user monitoring guard, which rolls back automatically if p75 Interaction to Next Paint rises more than 20 percent. Times and values are illustrative.</p>

      <div class="twa-rl__lane bdh-ui bdh-ui--ink">
        <div class="bdh-ui__bar twa-rl__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="twa-rl__pr"><?= xt_icon('git-branch', ['size' => 14, 'mono' => true]) ?>#418 · feat(checkout): saved addresses</span>
          <span class="twa-rl__clock" aria-hidden="true"><span class="bdh-pulse"></span><span data-rl-clock>Thu 10:00 · released</span></span>
        </div>
        <div class="twa-rl__lanebody">
          <div class="twa-rl__legend" aria-hidden="true">
            <?php foreach ($twa_rl_actor as $twa_ak => $twa_a): ?><span class="twa-rl__actor twa-rl__actor--<?= e($twa_ak) ?>"><?= xt_icon($twa_a[1], ['size' => 14]) ?><?= e($twa_a[0]) ?></span><?php endforeach; ?>
          </div>
          <ol class="twa-rl__stops" aria-label="Jump to a moment in the release lane">
            <li class="twa-rl__track" aria-hidden="true"><i data-rl-fill></i></li>
            <?php foreach ($twa_rl_stops as $twa_i => $twa_st): ?>
              <li class="twa-rl__stop is-done<?= $twa_i === $twa_rl_last ? ' is-now' : '' ?>" data-actor="<?= e($twa_st[2]) ?>">
                <button type="button" class="twa-rl__sb"<?= $twa_i === $twa_rl_last ? ' aria-current="step"' : '' ?> data-rl-stop="<?= $twa_i ?>">
                  <span class="twa-rl__node" aria-hidden="true"><?= xt_icon($twa_rl_actor[$twa_st[2]][1], ['size' => 16]) ?></span>
                  <span class="twa-rl__time"><?= e($twa_st[0]) ?></span>
                  <span class="twa-rl__name"><?= e($twa_st[1]) ?></span>
                  <span class="twa-rl__who"><?= e($twa_rl_actor[$twa_st[2]][0]) ?></span>
                  <span class="bdh-sr">. <?= e($twa_st[3]) ?>.</span>
                </button>
              </li>
            <?php endforeach; ?>
          </ol>
          <p class="twa-rl__now" aria-live="polite"><b data-rl-now-t><?= e($twa_rl_stops[$twa_rl_last][0]) ?></b><span data-rl-now><?= e($twa_rl_stops[$twa_rl_last][3]) ?></span></p>
        </div>
        <!-- PLACEHOLDER: confirm typical design-to-preview and release-cadence figures before launch -->
        <dl class="twa-rl__pace">
          <div><dt>Approved design → preview URL</dt><dd>2 h 02 m</dd></div>
          <div><dt>Preview → merged by a person</dt><dd>3 h 50 m</dd></div>
          <div><dt>Release cadence</dt><dd>Weekly or faster</dd></div>
          <div><dt>Rollback, when the guard trips</dt><dd>Under 1 minute</dd></div>
        </dl>
      </div>

      <div class="twa-rl__grid">
        <article class="twa-rl__p twa-rl__p--a is-on" data-rl-panel="a" data-from="<?= $twa_rl_from['a'] ?>">
          <header class="twa-rl__ph"><span class="twa-rl__pk"><b>A</b>09:38 → 10:05</span><h3 class="twa-rl__pt">Design to component</h3><span class="twa-rl__actor twa-rl__actor--agent"><?= xt_icon('agent', ['size' => 14]) ?>Agent drafts</span></header>
          <div class="twa-rl__cmp" aria-hidden="true">
            <div class="twa-rl__frame">
              <p class="twa-rl__fk"><?= xt_logo('figma', ['size' => 12, 'hidden' => true]) ?>Checkout / Saved address</p>
              <div class="twa-rl__card">
                <span class="twa-rl__cn">Home <em>Default</em></span>
                <span class="twa-rl__cl"></span><span class="twa-rl__cl twa-rl__cl--s"></span>
                <span class="twa-rl__tok twa-rl__tok--1">space.4</span>
                <span class="twa-rl__tok twa-rl__tok--2">radius.md</span>
              </div>
              <div class="twa-rl__card twa-rl__card--2"><span class="twa-rl__cn">Office</span><span class="twa-rl__cl"></span></div>
            </div>
            <pre class="twa-rl__code"><code><?php foreach ($twa_rl_code as $twa_ci => $twa_c): ?><span class="twa-rl__ln<?= $twa_c[1] === 'add' ? ' twa-rl__ln--add' : '' ?>" style="--i:<?= $twa_ci ?>"><i><?= $twa_ci + 1 ?></i><?= $twa_c[0] ?></span>
<?php endforeach; ?></code></pre>
          </div>
          <div class="twa-rl__tok-t">
            <p class="twa-rl__prk">Tokens the draft used, and what they resolve to</p>
            <ul class="twa-rl__toks" role="list">
              <?php foreach ($twa_rl_tokens as $twa_ti => $twa_tk): ?>
                <li style="--i:<?= $twa_ti ?>"><b><?= e($twa_tk[0]) ?></b><em><?= e($twa_tk[1]) ?></em><span><?= e($twa_tk[2]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <p class="twa-rl__pf"><span>AddressCard.tsx · 3 files drafted</span><span class="twa-rl__edit">+1 −5 by an engineer</span><span>A raw value fails review</span></p>
          <p class="bdh-sr">An agent drafts an AddressCard component from the design-system tokens in the Figma frame, using space.4 for padding, radius.md for the corner, text.label for the name and the neutral badge tone; an engineer then edits the empty state to add a hint and an action. A raw value in place of a token fails review.</p>
        </article>

        <article class="twa-rl__p twa-rl__p--b is-on" data-rl-panel="b" data-from="<?= $twa_rl_from['b'] ?>">
          <header class="twa-rl__ph"><span class="twa-rl__pk"><b>B</b>10:40</span><h3 class="twa-rl__pt">Agent-written end-to-end tests</h3><span class="twa-rl__actor twa-rl__actor--agent"><?= xt_icon('agent', ['size' => 14]) ?>Agent drafts</span></header>
          <div class="twa-rl__term" aria-hidden="true">
            <p class="twa-rl__cmd"><i>$</i> npx playwright test checkout/saved-address.spec.ts</p>
            <p class="twa-rl__tl twa-rl__tl--m" style="--i:0">Running <?= $twa_rl_runs ?> tests (<?= $twa_rl_specs ?> specs × <?= count($twa_rl_profiles) ?> projects) using 4 workers</p>
            <?php foreach ($twa_rl_tests as $twa_ti => $twa_t): ?>
              <p class="twa-rl__tl" style="--i:<?= $twa_ti + 1 ?>"><b>✓</b><span><?= e($twa_t[0]) ?></span><em><?= e($twa_t[1]) ?></em></p>
            <?php endforeach; ?>
            <p class="twa-rl__tl twa-rl__tl--sum" style="--i:<?= $twa_rl_specs + 1 ?>"><b><?= $twa_rl_runs ?> passed</b> · <?= number_format($twa_rl_secs, 1) ?> s of test time per project, across 4 workers</p>
          </div>
          <div class="twa-rl__profiles" aria-hidden="true">
            <p class="twa-rl__prk">Every spec, on every profile</p>
            <ul class="twa-rl__prl" role="list">
              <?php foreach ($twa_rl_profiles as $twa_pi => $twa_pf): ?>
                <li style="--i:<?= $twa_pi ?>"><b><?= e($twa_pf[0]) ?></b><span><?= e($twa_pf[1]) ?></span><em><?= $twa_pf[2] ?> / <?= $twa_rl_specs ?></em></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <p class="twa-rl__pf"><span>saved-address.spec.ts · drafted by an agent</span><span class="twa-rl__edit">2 assertions tightened by an engineer</span><span>No test counts until a person has read it</span></p>
          <p class="bdh-sr">An agent drafts fourteen Playwright specs covering keyboard use, 320 pixel reflow, screen-reader announcements, focus visibility, target size, 200 percent zoom, reduced motion, validation and a dropped connection. Each spec runs on four device profiles — Chromium and WebKit on the desktop, Pixel 7 on Android and iPhone 15 on iOS — so fifty-six runs pass in total, and an engineer reviews each spec before it counts.</p>
        </article>

        <article class="twa-rl__p twa-rl__p--c is-on" data-rl-panel="c" data-from="<?= $twa_rl_from['c'] ?>">
          <header class="twa-rl__ph"><span class="twa-rl__pk"><b>C</b>11:12 → 14:30</span><h3 class="twa-rl__pt">Visual diff, summarised</h3><span class="twa-rl__actor twa-rl__actor--person"><?= xt_icon('approve', ['size' => 14]) ?>Person approves</span></header>
          <div class="twa-rl__diffwrap">
            <div class="twa-rl__diff" style="--p:50%" data-rl-diff>
              <div class="twa-rl__shot twa-rl__shot--before" aria-hidden="true">
                <span class="twa-rl__sk">Before · main</span>
                <span class="twa-rl__ui">
                  <b class="twa-rl__uh">Delivery address</b>
                  <span class="twa-rl__f"><em>Full name</em></span>
                  <span class="twa-rl__f"><em>Address line 1</em></span>
                  <span class="twa-rl__f twa-rl__f--h"><em>City</em><em>Postcode</em></span>
                  <span class="twa-rl__tot"><span>Total</span><b>84.00</b></span>
                  <span class="twa-rl__est">Delivery in 2–3 days</span>
                  <span class="twa-rl__go twa-rl__go--s">Continue</span>
                </span>
              </div>
              <div class="twa-rl__after" aria-hidden="true">
                <div class="twa-rl__afterin">
                  <div class="twa-rl__shot twa-rl__shot--after">
                    <span class="twa-rl__sk">After · #418</span>
                    <span class="twa-rl__ui">
                      <b class="twa-rl__uh">Delivery address</b>
                      <span class="twa-rl__saved"><span class="twa-rl__opt is-sel"><i></i><span><b>Home</b>12 Harbour Road</span><em>Default</em></span><span class="twa-rl__opt"><i></i><span><b>Office</b>4 Station Street</span></span><span class="twa-rl__box twa-rl__box--1">1</span></span>
                      <span class="twa-rl__add">+ Add a new address</span>
                      <span class="twa-rl__tot"><span>Total</span><b>84.00</b></span>
                      <span class="twa-rl__est twa-rl__est--moved">Delivery in 2–3 days<span class="twa-rl__box twa-rl__box--3">3</span></span>
                      <span class="twa-rl__go">Continue<span class="twa-rl__box twa-rl__box--2">2</span></span>
                    </span>
                  </div>
                </div>
              </div>
              <span class="twa-rl__handle" aria-hidden="true"><i></i></span>
            </div>
            <div class="twa-rl__slide">
              <label class="twa-rl__sl" for="release-diff"><span>Before</span><span>Drag to compare</span><span>After</span></label>
              <input class="twa-rl__range" id="release-diff" type="range" min="0" max="100" step="1" value="50" aria-valuetext="Half before, half after">
            </div>
          </div>
          <div class="twa-rl__sum">
            <p class="twa-rl__sumk"><?= xt_icon('sparkle', ['size' => 16]) ?>AI summary · 3 visual changes · 0 unexpected</p>
            <ol class="twa-rl__sl2">
              <?php foreach ($twa_rl_diff as $twa_di => $twa_d): ?><li><b><?= $twa_di + 1 ?></b><span><?= e($twa_d[0]) ?><small><?= e($twa_d[1]) ?></small></span></li><?php endforeach; ?>
            </ol>
            <p class="twa-rl__ok"><?= xt_icon('check', ['size' => 14, 'mono' => true]) ?>Engineer confirmed against the diff · 14:30</p>
          </div>
        </article>

        <article class="twa-rl__p twa-rl__p--d is-on" data-rl-panel="d" data-from="<?= $twa_rl_from['d'] ?>">
          <header class="twa-rl__ph"><span class="twa-rl__pk"><b>D</b>Thu 10:00</span><h3 class="twa-rl__pt">Released, then watched</h3><span class="twa-rl__actor twa-rl__actor--pipeline"><?= xt_icon('pipeline', ['size' => 14]) ?>Pipeline guards</span></header>
          <div class="twa-rl__rum">
            <p class="twa-rl__rk"><span>p75 INP · mobile · release 43</span><span class="twa-ill">Illustrative</span></p>
            <svg class="twa-rl__chart" viewBox="0 0 400 186" aria-hidden="true" focusable="false">
              <g class="twa-rl__gy">
                <?php foreach ([100, 150, 200, 240] as $twa_gv): ?><line x1="44" x2="384" y1="<?= $twa_rl_y($twa_gv) ?>" y2="<?= $twa_rl_y($twa_gv) ?>"/><text x="36" y="<?= $twa_rl_y($twa_gv) + 3.5 ?>" text-anchor="end"><?= $twa_gv ?></text><?php endforeach; ?>
                <?php foreach ([0, 15, 30, 45, 60] as $twa_gm): ?><text x="<?= $twa_rl_x($twa_gm) ?>" y="176" text-anchor="middle"><?= $twa_gm ?> m</text><?php endforeach; ?>
              </g>
              <rect class="twa-rl__over" x="44" y="<?= $twa_rl_y(240) ?>" width="340" height="<?= round($twa_rl_y($twa_rl_guard) - $twa_rl_y(240), 1) ?>"/>
              <line class="twa-rl__guard" x1="44" x2="384" y1="<?= $twa_rl_y($twa_rl_guard) ?>" y2="<?= $twa_rl_y($twa_rl_guard) ?>"/>
              <text class="twa-rl__gl" x="380" y="<?= $twa_rl_y($twa_rl_guard) - 6 ?>" text-anchor="end">Guard <?= $twa_rl_guard ?> ms · +20%</text>
              <text class="twa-rl__gl twa-rl__gl--b" x="380" y="<?= $twa_rl_y($twa_rl_base) + 14 ?>" text-anchor="end">Baseline <?= $twa_rl_base ?> ms</text>
              <path class="twa-rl__line" pathLength="1" d="<?= $twa_rl_d ?>"/>
              <g class="twa-rl__roll" transform="translate(<?= $twa_rl_x(22) ?> <?= $twa_rl_y(205) ?>)">
                <circle r="5"/>
                <path class="twa-rl__arrow" d="M8 -2 C 40 -26, 64 -8, 56 22"/>
                <path class="twa-rl__head" d="M51 17 L56 23 L61 16"/>
                <g transform="translate(66 -22)"><rect x="0" y="-12" width="118" height="20" rx="4"/><text x="8" y="2">Rolled back → 42</text></g>
              </g>
            </svg>
            <ol class="twa-rl__log">
              <?php foreach ($twa_rl_log as $twa_li => $twa_l): ?><li class="<?= e($twa_l[2]) ?>" style="--i:<?= $twa_li ?>"><b><?= e($twa_l[0]) ?></b><span><?= e($twa_l[1]) ?></span></li><?php endforeach; ?>
            </ol>
          </div>
          <p class="twa-rl__pf"><span>RUM guard · p75 INP · 10% ramp</span><span class="twa-rl__edit">Rollback 48 s, automatic</span><span>Incident note drafted by an agent, owned by a person</span></p>
          <p class="bdh-sr">Chart of p75 Interaction to Next Paint for the hour after release 43 reaches 10 percent of traffic. It holds near the 150 millisecond baseline, rises to 205 milliseconds at 22 minutes, crosses the 180 millisecond guard, and the release rolls back automatically to release 42 in 48 seconds. INP returns to 150 milliseconds by 30 minutes, and an engineer owns the fix.</p>
        </article>
      </div>

      <div class="twa-rl__rules">
        <ul class="twa-rl__guards" role="list">
          <?php foreach ($twa_rl_guards as $twa_g): ?>
            <li><span class="twa-rl__gi"><?= xt_icon($twa_g[0], ['size' => 20]) ?></span><h3 class="twa-rl__gt"><?= e($twa_g[1]) ?></h3><p class="twa-rl__gd"><?= e($twa_g[2]) ?></p></li>
          <?php endforeach; ?>
        </ul>
        <div class="twa-rl__tools">
          <p class="twa-rl__tk">Tools in this lane · technologies we work with</p>
          <?= xt_stack($twa_rl_tools, ['variant' => 'row', 'size' => 18, 'label' => 'Tools in the release lane', 'class' => 'twa-rl__stack']) ?>
        </div>
      </div>
    </div>
  </div>
</section>
