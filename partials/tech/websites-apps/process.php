<?php /* DRAFT COPY — review before launch */
/* 09 · Discovery to day 90. A five-stop stepper: the first four are the delivery arc, the fifth is the one most
   agencies skip — the tune ninety days after launch, when the first honest field data exists. Real ARIA tabs with
   prev / next buttons; the rail fills to the current stop.
   Each stop is described by what it hands over: the artefact itself, drawn as the file you receive, then what has
   to be true before the work moves on and who signs that. Nothing here is a status; it is all a deliverable.
   Timings are typical ranges, not commitments; the figures inside the artefacts are illustrative. */
$twa_ps_steps = [
    [
        /* 'search', not 'compass': the compass mark is a ring with a small needle, and inside the
           round marker it reads as an empty circle once the marker is filled for the active stop. */
        'k' => 'discover', 'n' => 'Discover', 't' => 'Wk 01–02', 'i' => 'search',
        'h' => 'Find the real constraints before anyone draws a screen',
        'd' => 'We start from the evidence you already have: analytics, support tickets, the device and network mix of the people who actually use the product. That decides the performance budget, the browser floor and the first slice to ship.',
        'o' => ['Product brief and first slice', 'Architecture sketch with trade-offs written down', 'Performance budget set against the slowest quarter of traffic', 'Release plan and measurement plan'],
        'art' => ['performance-budget.json', 'JSON · committed to the repository', [
            ['{', ''],
            ['  "route":        "/product/[slug]",', ''],
            ['  "javascript":   "250 kB",', 'k'],
            ['  "images":       "200 kB",', 'k'],
            ['  "lcp_p75":      "2.5 s",', 'k'],
            ['  "inp_p75":      "200 ms",', 'k'],
            ['  "measured_on":  "low-end Android · Slow 4G"', ''],
            ['}', ''],
        ]],
        'gate' => ['The budget is agreed with you and committed, not held in a slide', 'The device and network mix comes from your analytics, not an assumption', 'The first slice is small enough to ship inside two sprints'],
        'team' => ['A principal engineer, a product designer and a delivery lead, part-time for two weeks', 'A product owner, and whoever holds the analytics'],
        'sign' => 'Your product owner and our delivery lead',
        'photo' => ['process-usability.jpg', 'A researcher writing notes beside a laptop mirroring the phone screen a participant is using'],
    ],
    [
        'k' => 'design', 'n' => 'Design', 't' => 'Wk 02–05', 'i' => 'layers',
        'h' => 'Design in the system, test with people, then build once',
        'd' => 'Flows and interfaces are designed against real content and the design-system tokens, prototyped and put in front of five to eight users. Accessibility is a design decision here — contrast, target size, focus order and the 320 px reflow — not a retrofit.',
        'o' => ['Clickable prototype on real devices', 'Design tokens for web and mobile', 'Usability findings and the changes made', 'Accessibility annotations on every flow'],
        'art' => ['adr-012-native-or-web.md', 'Markdown · architecture decision record', [
            ['# ADR-012 · Native, cross-platform or web', 'h'],
            ['', ''],
            ['Status     Accepted · week 4', ''],
            ['Context    62% Android · offline capture · one team', ''],
            ['Options    Two native apps · React Native · web', ''],
            ['Decision   React Native, native module for scanning', 'k'],
            ['Cost       The scanner is platform code, kept twice', ''],
        ]],
        'gate' => ['Every flow is prototyped on a real device, not a desktop browser', 'Contrast, target size, focus order and 320 px reflow are annotated, not deferred', 'Each decision records what it costs as well as what it buys'],
        'team' => ['A product designer, a content designer and a front-end engineer', 'A product owner, and five to eight of your users for the sessions'],
        'sign' => 'Your product owner, our design lead and our principal engineer',
    ],
    [
        'k' => 'build', 'n' => 'Build', 't' => 'Wk 04–11', 'i' => 'code',
        'h' => 'Two-week sprints, a demo each time, a preview URL per change',
        'd' => 'Every pull request gets its own preview environment and runs the full gate: tests, performance budget, accessibility checks, visual diff and dependency scan. Agents draft components and tests; engineers review and merge. Nothing waits for a big-bang integration.',
        'o' => ['Working increments you can use, every sprint', 'Unit, integration and end-to-end test suites', 'Preview deploys on every pull request', 'Instrumentation and dashboards wired as features land'],
        'art' => ['sprint-06-demo.md', 'Markdown · sent the day before the demo', [
            ['# Sprint 06 · what you can use on Thursday', 'h'],
            ['', ''],
            ['Shipped    Product page · search · saved addresses', ''],
            ['Flagged    Checkout v2, on for staff accounts only', ''],
            ['Budget     JS 214 / 250 kB · images 402 / 500 kB', 'k'],
            ['Moved      Reviews to sprint 07, after the field read', ''],
            ['Preview    pr-412.preview.your-platform.dev', ''],
        ]],
        'gate' => ['Every change has its own preview URL and clears the seven gates in §06', 'The increment is used by your team, not only demonstrated to it', 'Instrumentation lands with the feature, never after it'],
        'team' => ['Two to four engineers, a designer part-time and a delivery lead', 'A product owner at every demo, and one technical reviewer'],
        'sign' => 'Your product owner, at the demo',
    ],
    [
        'k' => 'launch', 'n' => 'Launch', 't' => 'Wk 11–12', 'i' => 'rocket',
        'h' => 'Stage the rollout, watch the field data, keep the rollback close',
        'd' => 'Release behind flags to a slice of traffic, with real-user monitoring watching Core Web Vitals and errors from the first minute. App store submissions, redirect maps and search parity checks run alongside. If the guard trips, the release reverts on its own.',
        'o' => ['Production release, staged behind flags', 'Store submissions and listings', 'Redirect map and search parity report', 'RUM, error and uptime dashboards live'],
        'art' => ['release-1.0-plan.md', 'Markdown · agreed before traffic moves', [
            ['# Release 1.0 · rollout and rollback', 'h'],
            ['', ''],
            ['Ramp       10% → 50% → 100% over 48 hours', ''],
            ['Guard      p75 INP +20% on baseline, or errors > 0.5%', 'k'],
            ['Rollback   Automatic, under a minute, to 0.9.4', 'k'],
            ['Watching   LCP · INP · CLS · crash-free · error rate', ''],
            ['On call    A named engineer, for the first 72 hours', ''],
        ]],
        'gate' => ['Redirect map and search parity checked against the live site', 'Store submissions accepted, listings and screenshots current', 'Dashboards live and alerting to a named person before traffic moves'],
        'team' => ['The build team, plus a reliability engineer for the ramp and the guard', 'A product owner, marketing, and whoever owns the DNS'],
        'sign' => 'Your product owner and our delivery lead',
    ],
    [
        'k' => 'tune', 'n' => 'Day-90 tune', 't' => 'Wk 12+', 'i' => 'gauge',
        'h' => 'Ninety days of field data is the first honest read',
        'd' => 'Launch-day numbers come from a handful of sessions. At day 90 there is enough real traffic to see what actually happens: which pages drifted, which third party crept in, where people stall. We review the field data with you, fix the top three regressions and reset the budget for the next quarter.',
        'o' => ['Field review at p75, by page template and device class', 'The top three regressions fixed and released', 'Budgets reset for the next quarter', 'A backlog ordered by field impact, not opinion'],
        'art' => ['day-90-field-review.md', 'Markdown · reviewed with you, then acted on', [
            ['# Day 90 · what the field actually says', 'h'],
            ['', ''],
            ['Read       CrUX 28-day beside your own RUM, by template', ''],
            ['Passing    Product 81% · listing 68% · checkout 77%', 'k'],
            ['Cause      Listing: a marketing tag added in week 6', ''],
            ['Fixing     Tag deferred · images re-encoded · JS split', ''],
            ['Next       Budgets reset; backlog ordered by field impact', ''],
        ]],
        'gate' => ['The read is at p75 on real traffic, by template and device class', 'The top three regressions are fixed and released, not only logged', 'Budgets are reset for the next quarter and written down'],
        'team' => ['A performance engineer and the delivery lead, two to three days', 'A product owner, plus marketing if the tags changed'],
        'sign' => 'Your product owner and our delivery lead, at the review',
    ],
];
$twa_ps_last = count($twa_ps_steps) - 1;
?>
<section class="band twa-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>09 · How we work</b><span>Five stops · each one hands over a file</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="process-t"><span class="g">Discovery to day 90,</span> not discovery to launch.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Four stops get the product live. The fifth is the one that decides whether it stays fast: a tune ninety days in, when there is finally enough real traffic to tell the truth. Every stop ends with something you can open, and a person who signs it.</p>
        <!-- PLACEHOLDER: confirm typical stage timings before launch -->
        <span class="twa-ill">Typical timings · sample artefacts</span>
      </div>
    </div>

    <div class="twa-ps" data-rv>
      <div class="twa-ps__rail">
        <div class="twa-ps__line" aria-hidden="true"><i data-ps-fill style="transform:scaleX(0)"></i></div>
        <div class="twa-ps__tabs" role="tablist" aria-label="Delivery stages">
          <?php foreach ($twa_ps_steps as $twa_i => $twa_s): ?>
            <button type="button" class="twa-ps__tab" role="tab" id="process-tab-<?= e($twa_s['k']) ?>"
                    aria-controls="process-pane-<?= e($twa_s['k']) ?>" aria-selected="<?= $twa_i === 0 ? 'true' : 'false' ?>" data-ps-tab>
              <span class="twa-ps__dot" aria-hidden="true"><?= xt_icon($twa_s['i'], ['size' => 16]) ?></span>
              <span class="twa-ps__no" aria-hidden="true"><?= str_pad((string) ($twa_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="twa-ps__nm"><?= e($twa_s['n']) ?></span>
              <span class="twa-ps__tm"><?= e($twa_s['t']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="twa-ps__panes bdh-panes">
        <?php foreach ($twa_ps_steps as $twa_i => $twa_s): ?>
          <article class="bdh-pane twa-ps__pane<?= $twa_i === 0 ? ' is-on' : '' ?>" id="process-pane-<?= e($twa_s['k']) ?>"
                   role="tabpanel" aria-labelledby="process-tab-<?= e($twa_s['k']) ?>" tabindex="0">
            <div class="twa-ps__main">
              <p class="twa-ps__k"><span class="bdh-idx"><?= str_pad((string) ($twa_i + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($twa_s['n']) ?> · <?= e($twa_s['t']) ?></p>
              <h3 class="twa-ps__h"><?= e($twa_s['h']) ?></h3>
              <p class="twa-ps__d"><?= e($twa_s['d']) ?></p>

              <dl class="twa-ps__team">
                <div><dt>On it from us</dt><dd><?= e($twa_s['team'][0]) ?></dd></div>
                <div><dt>On it from you</dt><dd><?= e($twa_s['team'][1]) ?></dd></div>
              </dl>

              <div class="twa-ps__block">
                <p class="twa-ps__bk">What has to be true before we move on</p>
                <ul class="twa-ps__gate" role="list">
                  <?php foreach ($twa_s['gate'] as $twa_g): ?><li><?= e($twa_g) ?></li><?php endforeach; ?>
                </ul>
              </div>

              <?php if (!empty($twa_s['photo'])): ?>
                <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
                <figure class="bdh-img twa-ps__ph">
                  <img src="<?= e(xe_url('assets/imgs/tech/websites-apps/' . $twa_s['photo'][0])) ?>" alt="<?= e($twa_s['photo'][1]) ?>" width="1200" height="675" loading="lazy" decoding="async">
                </figure>
              <?php endif; ?>
            </div>

            <div class="twa-ps__aside">
              <p class="twa-ps__bk">The artefact you receive</p>
              <figure class="twa-ps__file">
                <figcaption class="twa-ps__fh"><?= xt_icon('doc', ['size' => 14]) ?><b><?= e($twa_s['art'][0]) ?></b><span><?= e($twa_s['art'][1]) ?></span></figcaption>
                <pre class="twa-ps__fb" aria-hidden="true"><code><?php foreach ($twa_s['art'][2] as $twa_li => $twa_l): ?><span class="twa-ps__fl<?= $twa_l[1] ? ' twa-ps__fl--' . e($twa_l[1]) : '' ?>" style="--i:<?= $twa_li ?>"><?= $twa_l[0] === '' ? '&nbsp;' : e($twa_l[0]) ?></span>
<?php endforeach; ?></code></pre>
              </figure>

              <div class="twa-ps__block twa-ps__block--a">
                <p class="twa-ps__bk">What comes out of this stop</p>
                <ul class="bdh-bullets twa-ps__out" role="list">
                  <?php foreach ($twa_s['o'] as $twa_o): ?><li><?= e($twa_o) ?></li><?php endforeach; ?>
                </ul>
              </div>

              <p class="twa-ps__sign"><?= xt_icon('approve', ['size' => 15]) ?><span><em>Signed off by</em><?= e($twa_s['sign']) ?></span></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="twa-ps__nav">
        <button type="button" class="twa-btn twa-ps__prev" data-ps-prev>&larr; Previous stop</button>
        <p class="twa-ps__count" aria-live="polite"><b data-ps-now>01</b> / <?= str_pad((string) ($twa_ps_last + 1), 2, '0', STR_PAD_LEFT) ?> · <span data-ps-name><?= e($twa_ps_steps[0]['n']) ?></span></p>
        <button type="button" class="twa-btn twa-ps__next" data-ps-next>Next stop &rarr;</button>
      </div>
    </div>
  </div>
</section>
