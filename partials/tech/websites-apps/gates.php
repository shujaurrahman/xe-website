<?php /* DRAFT COPY — review before launch */
/* 06 · The merge queue. Not a status list: a queue the reader drives. Three pull requests wait in line behind the
   same seven budgets; the reader picks one and reads its ledger — every gate as a measured number against a written
   ceiling, with a meter showing how much of the budget the change spends. #414 spends 318 KB of a 250 KB JavaScript
   ceiling, so the queue holds and nothing behind it lands. A labelled button applies the agent's fix and releases
   the queue; pressing it again puts the queue back. Under the ledger, the WCAG 2.2 criteria the accessibility gate
   adds, and the frameworks the ceilings are written from.
   The HTML is the finished state: every ledger complete, every number printed, the queue held at #414.
   All figures are illustrative. */

/* key, gate, what it runs, the measure, ceiling, unit, [value for #412, #414, #415], value after the fix on #414 */
$twa_gq_gates = [
    ['perf', 'Performance budget', 'Lighthouse CI against the preview URL, with bundle ceilings enforced at build time.',
     'JavaScript shipped to this route', 250, 'KB', [248, 318, 244], 226],
    ['a11y', 'Accessibility', 'axe-core across every story and route, plus the manual WCAG 2.2 AA checks no tool can make.',
     'Violations, automated and manual', 0, '', [0, 0, 0], 0],
    ['vis', 'Visual regression', 'Storybook screenshots compared by Playwright on four device profiles.',
     'Unreviewed pixel diffs, of 312 stories', 0, '', [0, 0, 0], 0],
    ['test', 'Unit and end-to-end', 'Vitest for the units, Playwright for the flows a customer actually walks.',
     'Failing or flaky, of 1,380 tests', 0, '', [0, 0, 0], 0],
    ['sec', 'Security', 'OWASP ASVS Level 2 checks on the changed surface, with a dependency and secret scan.',
     'Critical and high advisories', 0, '', [0, 0, 0], 0],
    ['mob', 'Mobile', 'A device-farm run across iOS 17–18 and Android 12–15, measured on a mid-range handset.',
     'Cold start at p75, Pixel 6a', 1.8, 's', [1.4, 1.5, 1.4], 1.5],
    ['seo', 'Search parity', 'Redirect map, canonicals, metadata and structured data checked against the live site.',
     'Broken redirects, of 1,240 rules', 0, '', [0, 0, 0], 0],
];

/* number, title, who, lane state, one line of queue reasoning */
$twa_gq_prs = [
    ['412', 'feat(product): gallery zoom and AVIF hero images', 'Engineer · 3 commits · +412 −96',
     'ready', 'First in line', 'A code owner approved at 14:02. The queue rebases it onto main and reruns every gate before it lands, so it merges against the code it was tested with.'],
    ['414', 'feat(search): faceted filters on the listing page', 'Engineer · 7 commits · +1,204 −212',
     'held', 'The queue stops here', 'The listing route ships 318 KB of JavaScript against a 250 KB ceiling. The budget is not advisory: the queue holds, and nothing behind this change lands until it is met or the change is dropped.'],
    ['415', 'chore(deps): weekly dependency bump', 'Agent-opened · 1 commit · +18 −18',
     'waiting', 'Third in line', 'Every gate is green. It still waits, because a queue is a queue: it merges when #414 clears or an engineer drops #414 out of the lane.'],
];

/* the fix an agent proposes for #414, offered as a real button the reader can press */
$twa_gq_fix = ['9c8d7e6', 'fix(search): lazy-load the facet panel, −92 KB', 'Agent-suggested · an engineer commits it'];

$twa_gq_wcag = [   // criterion, name, level, what it means for the build
    ['2.4.11', 'Focus Not Obscured (Minimum)', 'AA', 'Sticky headers and cookie bars never hide the focused element.'],
    ['2.5.7',  'Dragging Movements',           'AA', 'Every drag has a click or keyboard alternative.'],
    ['2.5.8',  'Target Size (Minimum)',        'AA', 'Targets at least 24 × 24 px; we build to 44 px on touch.'],
    ['3.2.6',  'Consistent Help',              'A',  'Help and contact sit in the same place on every screen.'],
    ['3.3.7',  'Redundant Entry',              'A',  'Nothing already entered is asked for twice in a flow.'],
    ['3.3.8',  'Accessible Authentication (Minimum)', 'AA', 'Sign-in never depends on memorising or transcribing.'],
];
$twa_gq_badges = ['wcag22', 'cwv', 'owasp-asvs', 'owasp-top10', 'dora-metrics'];

/* meter fill: how much of the ceiling this change spends. A zero ceiling has no room to spend, so a clear gate
   reads as an empty track and a breach as a full one. Capped at 100% so an over-budget bar never escapes its track. */
$twa_gq_pct = function (float $twa_v, float $twa_c): float {
    if ($twa_c <= 0) return $twa_v > 0 ? 100.0 : 0.0;
    return round(min(100, $twa_v / $twa_c * 100), 1);
};
$twa_gq_num = function (float $twa_v, string $twa_u): string {
    $twa_s = $twa_u === 's' ? number_format($twa_v, 1) : number_format($twa_v);
    return $twa_u === '' ? $twa_s : $twa_s . ' ' . $twa_u;
};
$twa_gq_lim = function (float $twa_c, string $twa_u) use ($twa_gq_num): string {
    return $twa_c <= 0 ? 'none allowed' : $twa_gq_num($twa_c, $twa_u) . ' allowed';
};
?>
<section class="band twa-gates" id="gates" aria-labelledby="gates-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>06 · The merge queue</b><span>Seven budgets · written as numbers · enforced in line</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="gates-t"><span class="g">Every gate is a number,</span> and the queue stops at the first one missed.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Quality on a build is not a feeling about a pull request. It is seven ceilings written into the repository — kilobytes, seconds, violations — checked on the merged result, not the branch. Pick a change in the queue and read its ledger.</p>
        <span class="twa-ill">Illustrative pull requests</span>
      </div>
    </div>

    <div class="twa-gq" data-rv>
      <p class="bdh-sr">Illustration of a merge queue holding three pull requests against seven written budgets. Pull request 412, gallery zoom and AVIF hero images, is first in line and meets every ceiling. Pull request 414, faceted filters on the listing page, ships 318 kilobytes of JavaScript against a 250 kilobyte ceiling, so the queue holds there. Pull request 415, a dependency bump, is green but waits in third place. The other six ceilings are zero violations, zero unreviewed pixel diffs, zero failing or flaky tests of 1,380, zero critical or high advisories, a 1.8 second cold start at the 75th percentile on a Pixel 6a, and zero broken redirects of 1,240 rules. An agent proposes lazy-loading the facet panel, which takes 414 to 226 kilobytes and releases the queue; a person commits it.</p>

      <div class="twa-gq__console">
        <div class="twa-gq__lane">
          <p class="twa-gq__lk"><span class="bdh-pulse" aria-hidden="true"></span>Merge queue · your-platform / web <em data-gq-lane>held at #414</em></p>
          <div class="twa-gq__list" role="tablist" aria-label="Pull requests in the merge queue" aria-orientation="vertical">
            <?php foreach ($twa_gq_prs as $twa_pi => $twa_p): ?>
              <button type="button" class="twa-gq__pr" role="tab" id="gates-tab-<?= e($twa_p[0]) ?>"
                      aria-controls="gates-pane-<?= e($twa_p[0]) ?>" aria-selected="<?= $twa_pi === 0 ? 'true' : 'false' ?>"
                      data-gq-pr="<?= $twa_pi ?>" data-st="<?= e($twa_p[3]) ?>"<?= $twa_p[3] === 'held' ? ' data-fix-state="Second in line"' : '' ?>>
                <span class="twa-gq__pos" aria-hidden="true"><?= $twa_pi + 1 ?></span>
                <span class="twa-gq__pn">#<?= e($twa_p[0]) ?></span>
                <span class="twa-gq__pt"><?= e($twa_p[1]) ?></span>
                <span class="twa-gq__pw"><?= e($twa_p[2]) ?></span>
                <span class="twa-gq__ps" data-gq-state="<?= $twa_pi ?>"><?= e($twa_p[4]) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
          <p class="twa-gq__ln">A queue merges the result, not the branch: each change is rebased onto the one in front and rechecked, so two changes that pass alone cannot break main together.</p>
        </div>

        <div class="twa-gq__panes bdh-panes">
          <?php foreach ($twa_gq_prs as $twa_pi => $twa_p): ?>
            <article class="bdh-pane twa-gq__pane<?= $twa_pi === 0 ? ' is-on' : '' ?>" id="gates-pane-<?= e($twa_p[0]) ?>"
                     role="tabpanel" aria-labelledby="gates-tab-<?= e($twa_p[0]) ?>" tabindex="0" data-gq-pane="<?= $twa_pi ?>">
              <header class="twa-gq__ph">
                <p class="twa-gq__pk"><span class="bdh-idx">#<?= e($twa_p[0]) ?></span><?= e($twa_p[2]) ?></p>
                <h3 class="twa-gq__pttl"><?= e($twa_p[1]) ?></h3>
                <p class="twa-gq__pd"<?= $twa_p[3] === 'held' ? ' data-fix-why="The facet panel now loads when a shopper opens it, so the listing route ships 226 KB against the 250 KB ceiling. Every gate is met, the queue releases, and the change waits behind #412 for a code owner to press merge."' : '' ?>><?= e($twa_p[5]) ?></p>
              </header>

              <ol class="twa-gq__ledger" role="list">
                <?php foreach ($twa_gq_gates as $twa_gi => $twa_g):
                    $twa_v   = $twa_g[6][$twa_pi];
                    $twa_ok  = $twa_v <= $twa_g[4];
                    /* the state this gate reaches once the fix is committed — read by gates.js, so PHP stays the
                       one source for every number the panel can show */
                    $twa_fx  = $twa_p[3] === 'held' ? $twa_g[7] : null;
                    $twa_flat = $twa_g[4] <= 0;   // a zero ceiling has no room to spend, so it carries no meter
                    $twa_fxa = $twa_fx === null ? '' :
                        ' data-fix-val="' . e($twa_gq_num($twa_fx, $twa_g[5])) . '"'
                        . ' data-fix-pct="' . $twa_gq_pct($twa_fx, $twa_g[4]) . '"'
                        . ' data-fix-ok="' . ($twa_fx <= $twa_g[4] ? '1' : '0') . '"'
                        . ' data-fix-res="' . e($twa_fx <= $twa_g[4] ? 'Within budget' : 'Over by ' . $twa_gq_num($twa_fx - $twa_g[4], $twa_g[5])) . '"'; ?>
                  <li class="twa-gq__g<?= $twa_flat ? ' twa-gq__g--flat' : '' ?>" data-gate="<?= e($twa_g[0]) ?>" data-ok="<?= $twa_ok ? '1' : '0' ?>"<?= $twa_fxa ?>>
                    <span class="twa-gq__gx" aria-hidden="true"><?= str_pad((string) ($twa_gi + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="twa-gq__gn"><?= e($twa_g[1]) ?></span>
                    <span class="twa-gq__gr"><?= e($twa_g[2]) ?></span>
                    <span class="twa-gq__gm">
                      <span class="twa-gq__gml"><?= e($twa_g[3]) ?></span>
                      <span class="twa-gq__gv"><b data-gq-val="<?= e($twa_g[0]) ?>"><?= e($twa_gq_num($twa_v, $twa_g[5])) ?></b><em>of <?= e($twa_gq_lim($twa_g[4], $twa_g[5])) ?></em></span>
                      <?php if (!$twa_flat): ?><span class="twa-gq__meter" aria-hidden="true"><i class="bdh-grow" style="--i:<?= $twa_gi ?>;--p:<?= $twa_gq_pct($twa_v, $twa_g[4]) ?>%" data-gq-meter="<?= e($twa_g[0]) ?>"></i></span><?php endif; ?>
                    </span>
                    <span class="twa-gq__gs" data-gq-res="<?= e($twa_g[0]) ?>"><?= $twa_ok ? 'Within budget' : 'Over by ' . e($twa_gq_num($twa_v - $twa_g[4], $twa_g[5])) ?></span>
                  </li>
                <?php endforeach; ?>
              </ol>

              <?php
                /* every pane carries the same footer shape — kicker, the commit or approval it turns on, the rule
                   behind it and one control on the right — so switching change does not change the card's height */
                $twa_pf = [
                    'ready' => ['approve', 'Cleared · waiting for the lane', '14:02 · approved by a code owner',
                        'Code-owner review on every change, including the ones an agent opens. The queue can hold a change; only a person can land it.',
                        'Merges in turn'],
                    'held' => ['agent', 'An agent has already written the fix', $twa_gq_fix[0] . ' · ' . $twa_gq_fix[1],
                        $twa_gq_fix[2] . '. Agents can open, comment and suggest; branch protection still needs a code-owner approval, so nothing merges on an agent\'s word.',
                        null],
                    'waiting' => ['queue', 'Green, and still waiting', '#415 · opened by an agent, reviewed by an engineer',
                        'A dependency bump that passes every ceiling on its own is still rebased onto whatever lands in front of it and rechecked, so it cannot pass alone and break main together.',
                        'Holds behind #414'],
                ][$twa_p[3]]; ?>
              <footer class="twa-gq__pf">
                <div class="twa-gq__fix">
                  <p class="twa-gq__fk"><?= xt_icon($twa_pf[0], ['size' => 16]) ?><?= e($twa_pf[1]) ?></p>
                  <p class="twa-gq__fm"><?= e($twa_pf[2]) ?></p>
                  <p class="twa-gq__fw"><?= e($twa_pf[3]) ?></p>
                  <?php if ($twa_pf[4] === null): ?>
                    <button type="button" class="twa-btn twa-btn--blue twa-gq__apply" data-gq-apply>Commit the fix and release the queue</button>
                  <?php else: ?>
                    <p class="twa-gq__fs"><?= e($twa_pf[4]) ?></p>
                  <?php endif; ?>
                </div>
              </footer>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="twa-gq__base">
        <div class="twa-gq__wcag">
          <p class="twa-gq__bk">What the accessibility gate adds in WCAG 2.2</p>
          <table class="twa-gq__tbl">
            <caption class="bdh-sr">The six success criteria new in WCAG 2.2, the conformance level of each, and what each one means in the build</caption>
            <thead><tr><th scope="col">Criterion</th><th scope="col">Level</th><th scope="col">What it means in the build</th></tr></thead>
            <tbody>
              <?php foreach ($twa_gq_wcag as $twa_w): ?>
                <tr><th scope="row"><b><?= e($twa_w[0]) ?></b><span><?= e($twa_w[1]) ?></span></th><td><?= e($twa_w[2]) ?></td><td><?= e($twa_w[3]) ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="twa-gq__std">
          <p class="twa-gq__bk">Where the ceilings come from</p>
          <ul class="xt-badges twa-gq__badges" role="list">
            <?php foreach ($twa_gq_badges as $twa_bk): ?><?= xt_badge($twa_bk, ['tag' => 'li']) ?><?php endforeach; ?>
          </ul>
          <p class="twa-gq__note">The numbers are not invented. The kilobyte and second ceilings come from Core Web Vitals at p75; the violation ceiling from WCAG 2.2 AA; the security ceiling from OWASP ASVS Level 2 and the OWASP Top 10; the delivery measures from DORA. Mobile builds are additionally checked against OWASP MASVS, and the quality characteristics we report against — performance efficiency, reliability, usability, security and maintainability — follow ISO/IEC 25010. These are frameworks we build to and align delivery with; the badges are our own marks, not certifications.</p>
        </div>
      </div>
    </div>
  </div>
</section>
