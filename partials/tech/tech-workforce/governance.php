<?php /* DRAFT COPY — review before launch */
/* Governance — the sprint report you receive, and the swap flow behind the replacement
   commitment. The chart is a decorative mock (aria-hidden) with a .bdh-sr description; the
   figures are illustrative. Cadence and the replacement window are PLACEHOLDER. */
$ttw_gv_sprints = [
    ['19', 34, 31, 4],
    ['20', 36, 36, 3],
    ['21', 38, 35, 3],
    ['22', 40, 40, 2],
    ['23', 42, 41, 1],
    ['24', 42, 42, 1],
];
$ttw_gv_max = 46;
$ttw_gv_tiles = [
    ['Sprint predictability', '97%', 'Delivered against committed, six-sprint mean'],
    ['Escaped defects', '1', 'Reaching production last sprint, from 4 in sprint 19'],
    ['Review turnaround', '6 h', 'Median time from pull request opened to first review'],
    ['Engineer retention', '&gt; 90%', 'Engineers still on your account after 12 months — target'],
];
$ttw_gv_risks = [
    ['Open', 'Payments sandbox credentials still pending from your provider; blocks the refunds story from sprint 25.', 'Your finance team · raised sprint 23'],
    ['Watching', 'Test data for the migration is thinner than production. We are generating synthetic records rather than copying live data.', 'Data engineer · raised sprint 24'],
    ['Closed', 'Flaky checkout suite caused three failed pipelines. Quarantined, root-caused and re-enabled.', 'QA automation · closed sprint 24'],
];
$ttw_gv_swap = [
    ['01', 'You ask', 'Any reason, in writing or in the monthly review. You do not have to justify it.'],
    ['02', 'We acknowledge', 'Within one business day, with a handover plan for the work in flight.'],
    ['03', 'Shortlist', 'Replacement candidates from the vetted bench, interviewed by you if you want to.'],
    ['04', 'Handover', 'The outgoing and incoming engineers overlap for knowledge transfer. The overlap is not billed.'],
];
$ttw_gv_cadence = [
    ['Weekly', 'Written status: delivered, in flight, blocked, decisions needed.'],
    ['Fortnightly', 'Sprint demo and report to your stakeholders, run by the squad.'],
    ['Monthly', 'Service review: metrics, quality, fit, capacity and what changes next month.'],
];
?>
<section class="band band--ink ttw-gov" id="governance" aria-labelledby="governance-t">
  <div class="wrap">

    <header class="ttw-head" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Governance</p>
        <h2 class="h2" id="governance-t"><span class="g">Accountable</span> every sprint.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Capacity you cannot see is capacity you cannot manage. Every engagement reports the same numbers on the same cadence, and the report goes to you whether the sprint went well or not.</p>
      </div>
    </header>

    <div class="ttw-win ttw-win--ink ttw-gov__win" data-bdh-in data-ttw-arm>
      <p class="ttw-win__bar">
        <span class="ttw-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="ttw-win__path">sprint-report · <b>Your platform</b> · sprint 24</span>
        <span class="ttw-win__end"><span class="ttw-ill">Illustrative</span></span>
      </p>

      <div class="ttw-gov__body">

        <div class="ttw-gov__chart">
          <p class="ttw-gov__ch"><span class="ttw-lbl">Committed against delivered</span><span class="ttw-ro">Story points · last six sprints</span></p>
          <div class="ttw-gov__plot" aria-hidden="true">
            <?php foreach ($ttw_gv_sprints as $ttw_gv_i => $ttw_gv_s): ?>
              <span class="ttw-gov__col" style="--i:<?= (int) $ttw_gv_i ?>">
                <span class="ttw-gov__bars">
                  <i class="ttw-gov__cm" style="--h:<?= round($ttw_gv_s[1] / $ttw_gv_max * 100, 2) ?>%"><b><?= (int) $ttw_gv_s[1] ?></b></i>
                  <i class="ttw-gov__dl" style="--h:<?= round($ttw_gv_s[2] / $ttw_gv_max * 100, 2) ?>%"><b><?= (int) $ttw_gv_s[2] ?></b></i>
                </span>
                <span class="ttw-gov__cl">S<?= e($ttw_gv_s[0]) ?></span>
                <span class="ttw-gov__ed" data-n="<?= (int) $ttw_gv_s[3] ?>"><?= (int) $ttw_gv_s[3] ?></span>
              </span>
            <?php endforeach; ?>
          </div>
          <p class="ttw-gov__key" aria-hidden="true">
            <span class="ttw-gov__k"><i class="ttw-gov__sw ttw-gov__sw--c"></i>Committed</span>
            <span class="ttw-gov__k"><i class="ttw-gov__sw ttw-gov__sw--d"></i>Delivered</span>
            <span class="ttw-gov__k"><i class="ttw-gov__sw ttw-gov__sw--e">1</i>Escaped defects, in the row under the columns</span>
          </p>
          <p class="bdh-sr">A bar chart of the last six sprints, sprint 19 to sprint 24. Committed points rise from 34 to 42 — 34, 36, 38, 40, 42, 42 — and delivered points track them closely at 31, 36, 35, 40, 41 and 42. Under each column, the defects that escaped to production that sprint: four, three, three, two, one and one. All figures are illustrative.</p>
        </div>

        <ul class="ttw-gov__tiles" role="list">
          <?php foreach ($ttw_gv_tiles as $ttw_gv_t): ?>
            <li><span class="ttw-lbl"><?= e($ttw_gv_t[0]) ?></span><span class="ttw-fig"><?= $ttw_gv_t[1] ?></span><span class="ttw-ro"><?= e($ttw_gv_t[2]) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <!-- PLACEHOLDER: confirm retention, predictability and review-turnaround targets before launch -->

        <div class="ttw-gov__risks">
          <p class="ttw-gov__ch"><span class="ttw-lbl">Risks and blockers</span><span class="ttw-ro">Carried forward until closed</span></p>
          <ul role="list">
            <?php foreach ($ttw_gv_risks as $ttw_gv_r): ?>
              <li class="ttw-gov__risk" data-s="<?= e(strtolower($ttw_gv_r[0])) ?>">
                <span class="ttw-gov__rs"><?= e($ttw_gv_r[0]) ?></span>
                <span class="ttw-gov__rt"><?= e($ttw_gv_r[1]) ?></span>
                <span class="ttw-ro ttw-gov__ro"><?= e($ttw_gv_r[2]) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <blockquote class="ttw-gov__note">
          <p>“Sprint 24 closed on commitment. The refunds story moves to sprint 25 until the payments sandbox is open — that is on your side, and I have asked for a date. I am proposing we drop one frontend seat from sprint 27, when the redesign lands.”</p>
          <footer><span class="ttw-gov__who">Delivery manager</span><span class="ttw-ro">Monthly service review · illustrative note</span></footer>
        </blockquote>

      </div>
    </div>

    <div class="ttw-gov__after">
      <div class="ttw-card ttw-gov__cad">
        <h3 class="bdh-t">Cadence</h3>
        <!-- PLACEHOLDER: confirm reporting cadence and the replacement window before launch -->
        <dl class="ttw-gov__cl2">
          <?php foreach ($ttw_gv_cadence as $ttw_gv_c): ?>
            <div><dt><?= e($ttw_gv_c[0]) ?></dt><dd><?= e($ttw_gv_c[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>

      <div class="ttw-card ttw-gov__swap">
        <h3 class="bdh-t">If an engineer is not right, swapping them is a process, not a negotiation</h3>
        <ol class="ttw-gov__sl" role="list">
          <?php foreach ($ttw_gv_swap as $ttw_gv_s2): ?>
            <li><span class="ttw-gov__sn"><?= e($ttw_gv_s2[0]) ?></span><span class="ttw-gov__st"><b><?= e($ttw_gv_s2[1]) ?></b><?= e($ttw_gv_s2[2]) ?></span></li>
          <?php endforeach; ?>
        </ol>
        <p class="ttw-gov__sw2"><span class="ttw-chip"><span class="ttw-chip__d"></span>Replacement target<span class="ttw-chip__s">10 working days</span></span> <span class="ttw-ro">Set in the contract per engagement.</span></p>
      </div>
    </div>

  </div>
</section>
