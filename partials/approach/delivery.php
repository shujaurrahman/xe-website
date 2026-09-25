<?php /* DRAFT COPY — review before launch */
/* Delivery — the spine of the page: a project, stage by stage. Six stages, each ending at a gate that a
   named person on your side signs. The shipped HTML is a complete, readable list of all six stages with a
   jump rail above it; delivery.js folds it into a stepper at init (the rail anchors become ARIA tabs, the
   stages become panes) so nothing is hidden without JavaScript. Every duration is a typical range, never a
   promise, and every name is a role, never a person.
   Stage row: [key, name, question, typical, what happens[], agents do[], our side[], your side[],
               you keep[], gate, exit, approver, unlocks, image, alt, plate caption] */
// PLACEHOLDER: confirm typical stage lengths and team make-up before launch
$dl_st = [
  ['discover', 'Discover', 'What is true today, and what is it costing you?', '1–3 weeks',
    ['Interviews with the people who own the problem and the people who live with it.',
     'Your analytics, support tickets, search and sales data read together, not separately.',
     'The current system mapped: what exists, what it costs to run, where the work leaks.',
     'Category and competitor signal gathered, dated, and kept with its source.'],
    ['Turn transcripts, tickets and reviews into themes, with the quote that supports each one.',
     'Map systems and data flows from your documents and repositories, flagging what they could not read.',
     'Draft the first risk register for people to cut down.'],
    ['Programme lead', 'Strategy lead', 'Solution architect', 'Research analyst'],
    ['Executive sponsor', 'Domain owners', 'Whoever holds the data'],
    ['Evidence map, every claim cited', 'Interview notes and transcripts', 'Current-state system and data map', 'Opportunity shortlist, sized'],
    'Problem framed', 'One written problem statement, the measures that would prove it solved, and a shortlist you agree with.',
    'Your executive sponsor', 'Whether to spend anything more — and on which problem.',
    'stage-discover.jpg', 'A recording setup on a table, ready for a research interview', 'Discover · week 1 · the people who live with the problem, first'],

  ['define', 'Define', 'What will we build, and how will we know it worked?', '1–2 weeks',
    ['Options drafted at three sizes, each with what it costs and what it does not solve.',
     'Effort estimated as ranges that widen where the unknowns are, never as single numbers.',
     'Acceptance criteria written per outcome, in the language your team already uses.',
     'Risks, dependencies and the data you would have to supply, each with a named owner.'],
    ['Draft the requirement options from the evidence, with the trade-offs stated on each.',
     'Propose acceptance criteria and edge cases from real tickets, for people to edit.',
     'Check the plan against the risk register and flag anything with no owner.'],
    ['Programme lead', 'Solution architect', 'Product lead'],
    ['Sponsor', 'Product owner', 'Finance partner'],
    ['Scope, out of scope and assumptions, in writing', 'Acceptance criteria and a measurement plan', 'Estimate ranges with the confidence stated', 'Risk and dependency register'],
    'Scope signed', 'A statement of work carrying scope, measures and a budget model that you have signed.',
    'Sponsor and product owner', 'The money, the team and the start date.',
    'stage-define.jpg', 'Candidate ideas sorted into columns on a board', 'Define · week 2 · options sorted before anything is built'],

  ['design', 'Design', 'Does it work for the people who have to use it?', '2–6 weeks',
    ['Journeys and words designed before screens, agreed with the people who answer for them.',
     'Variants generated inside your design system, not around it.',
     'Accessibility checked on every frame as it is made, not audited at the end.',
     'Tested with real users; what failed is written down as plainly as what passed.'],
    ['Generate layout and copy variants from the approved tokens and tone rules.',
     'Run contrast, target-size and reading-level checks on every frame as it is made.',
     'Summarise usability sessions into findings with the session timestamps attached.'],
    ['Product designer', 'Content designer', 'Accessibility reviewer', 'Solution architect'],
    ['Product owner', 'Brand lead', 'Two or three real users'],
    ['Tested prototype', 'Design tokens and components', 'WCAG 2.2 AA review, issues closed', 'Usability findings, including the failures'],
    'Design approved', 'A tested prototype with no open AA issues and the content signed off.',
    'Product owner and brand lead', 'The build order, and what the first release contains.',
    'stage-design.jpg', 'Colleagues working through documentation together at a laptop', 'Design · week 4 · the words decided with the people who answer for them'],

  ['build', 'Build', 'Is it correct, fast and secure — and can you see it?', '4–16 weeks',
    ['Two-week sprints with one goal each, and a demo of working software at the end of every one.',
     'Every change carries tests, evals, performance budgets and security scans before a person reviews it.',
     'Runbooks written as features land, rather than assembled the week before go-live.',
     'Your product owner ranks the backlog each week. The order is yours.'],
    ['Pair with engineers in the editor; a person reviews, then keeps or discards every suggested line.',
     'Write unit and contract tests, and the pull-request summary a reviewer reads first.',
     'Run the eval suite and the scans on every change, and block the merge when a gate fails.'],
    ['Tech lead', 'Engineers', 'QA and eval engineer', 'Security engineer'],
    ['Product owner, weekly', 'Your IT and security reviewers'],
    ['Working software in your environment, every sprint', 'Test, eval and scan reports per release', 'Threat model and architecture decision records', 'Runbooks and a decision log kept current'],
    'Release approved', 'Every budget green, a human code review done, and your security reviewer satisfied.',
    'Tech lead with your IT or security owner', 'Go-live, and the date you can give the business.',
    'stage-build.jpg', 'Two colleagues working through a diagram on a whiteboard', 'Build · sprint 3 · the hard problem on the wall before it is in the branch'],

  ['run', 'Run', 'Is it staying healthy where it matters?', 'From go-live, ongoing',
    ['Released behind a canary: 5% of traffic, then 25, then 100, while error rate and latency hold.',
     'Uptime, Core Web Vitals, eval drift, cost and content freshness watched on one board.',
     'On-call rota staffed, runbooks rehearsed, rollback proven before it is needed.',
     'A monthly service report you can forward without editing it first.'],
    ['Watch the canary and roll back without asking if error rate or latency moves.',
     'Triage alerts, draft the incident timeline, and page a person when the rule says to.',
     'Flag cost anomalies and eval drift with a proposed fix for someone to approve.'],
    ['Service owner', 'On-call squad', 'Site reliability engineer'],
    ['Operations owner', 'Support lead'],
    ['Runbook and on-call rota', 'Live service dashboards', 'Incident and change log', 'Monthly service report'],
    'Service accepted', 'The agreed service levels met for an agreed period, with the evidence attached.',
    'Your operations owner', 'Handover to your team, or a managed service with service levels.',
    'stage-run.jpg', 'An engineer working at a laptop at night with city lights behind', 'Run · week 20 · someone is awake, and it is written down who'],

  ['improve', 'Improve', 'What should change next, and on what evidence?', 'Quarterly, continuous',
    ['Experiments ranked by expected value, not by who asked loudest.',
     'Each one shipped behind a flag, with the measurement plan written before it runs.',
     'Results read back into the backlog — including the ones that did not work.',
     'A quarterly review against the measures agreed in Define. The same numbers, not new ones.'],
    ['Rank the backlog by expected value and effort, for the product owner to reorder.',
     'Draft variants and the analysis plan, and say plainly when a result is not yet significant.',
     'Watch for eval drift after a model or data change and open the ticket with the evidence.'],
    ['Product lead', 'Data analyst', 'Engineers'],
    ['Sponsor, quarterly', 'Product owner'],
    ['Experiment log, results good and bad', 'Quarterly outcome review', 'An updated, ranked roadmap', 'The measurement plan — still the same one'],
    'Roadmap reset', 'Measured outcomes reviewed against the original measures, and the next bets agreed in writing.',
    'Sponsor, quarterly', 'Next quarter’s budget and priorities.',
    'stage-improve.jpg', 'A small team reviewing a release together at a screen', 'Improve · quarter 2 · the numbers we agreed in Define, not new ones'],
];
/* the two warm plates (an orange wall, sodium street light) are graded down in CSS to sit in the page's cool register */
$dl_grade = ['stage-define.jpg' => true, 'stage-run.jpg' => true];
$dl_sel  = 0;
$dl_tot  = count($dl_st);
$dl_fact = [
  ['Gates a project passes', (string) $dl_tot, 'One per stage. Nothing moves on without a named yes.'],
  ['Who signs them', 'Your side', 'Every gate approver is a role on your team, not on ours.'],
  ['What an agent may sign', 'Nothing', 'Agents draft, test, scan and deploy. They never approve.'],
  ['What you keep per stage', '3–4 artefacts', 'Usable on their own, whether or not the next stage happens.'],
];
?>
<section class="band apr-dl" id="delivery" aria-labelledby="delivery-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How a project runs</p>
        <h2 class="h2" id="delivery-t"><span class="g">Six stages.</span> Nothing moves on without a named yes.</h2>
      </div>
      <div>
        <p class="lead">Each stage answers one question, ends at a gate with written exit criteria, and leaves you artefacts you keep whether or not the next stage happens. Choose a stage to see what happens inside it, who is in the room on both sides, and which decision it unlocks.</p>
        <p class="apr-dl__ill"><span class="bdh-ill">Typical ranges</span> Durations vary with scope and with how fast decisions come back.</p>
      </div>
    </div>

    <p class="bdh-sr">Six delivery stages in order: Discover, ending at the gate “Problem framed”; Define, ending at “Scope signed”; Design, ending at “Design approved”; Build, ending at “Release approved”; Run, ending at “Service accepted”; and Improve, ending at “Roadmap reset”. Each stage below lists what happens, where agents do the legwork, who is in the room on each side, what you keep, and who signs the gate.</p>

    <div class="apr-dl__wrap" data-apr-dl data-sel="<?= $dl_sel ?>">
      <nav class="apr-dl__railwrap bdh-scroll-x mask-x apr-nomask" aria-label="Delivery stages" tabindex="0">
        <ol class="apr-dl__rail">
          <?php foreach ($dl_st as $dl_i => $dl_s): ?>
          <li class="apr-dl__ri<?= $dl_i === $dl_sel ? ' is-on' : '' ?>">
            <span class="apr-dl__node" aria-hidden="true"><i></i></span>
            <a class="apr-dl__tab" id="apr-dl-t<?= $dl_i ?>" href="#apr-stage-<?= e($dl_s[0]) ?>" data-apr-tab="<?= $dl_i ?>">
              <span class="apr-dl__tn"><?= str_pad((string) ($dl_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="apr-dl__tt"><?= e($dl_s[1]) ?></span>
              <span class="apr-dl__tw"><?= e($dl_s[3]) ?></span>
            </a>
            <span class="apr-dl__gt" aria-hidden="true"><i></i><em><?= e($dl_s[9]) ?></em></span>
          </li>
          <?php endforeach; ?>
        </ol>
      </nav>

      <ol class="apr-dl__stages">
        <?php foreach ($dl_st as $dl_i => $dl_s): $dl_n = str_pad((string) ($dl_i + 1), 2, '0', STR_PAD_LEFT); ?>
        <li class="apr-stg<?= $dl_i === $dl_sel ? ' is-on' : '' ?>" id="apr-stage-<?= e($dl_s[0]) ?>" data-apr-pane="<?= $dl_i ?>">
          <div class="apr-stg__media">
            <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/approach/CREDITS.md) — replace with Xterra Edze's own delivery photography before launch -->
            <figure class="bdh-img bdh-img--r43 apr-stg__fig<?= isset($dl_grade[$dl_s[13]]) ? ' apr-stg__fig--cool' : '' ?>">
              <img src="<?= xe_url('assets/imgs/approach/' . $dl_s[13]) ?>" alt="<?= e($dl_s[14]) ?>" width="1200" height="900" loading="lazy" decoding="async">
            </figure>
            <p class="apr-stg__cap"><?= e($dl_s[15]) ?></p>
            <dl class="apr-stg__facts">
              <div><dt>Typical</dt><dd><?= e($dl_s[3]) ?></dd></div>
              <div><dt>Ends at</dt><dd><?= e($dl_s[9]) ?></dd></div>
              <div><dt>Signed by</dt><dd><?= e($dl_s[11]) ?></dd></div>
            </dl>
          </div>

          <div class="apr-stg__main">
            <p class="apr-stg__k"><span class="apr-stg__n"><?= $dl_n ?></span><span class="apr-stg__of">Stage <?= $dl_n ?> of <?= $dl_tot ?></span></p>
            <h3 class="apr-stg__t"><?= e($dl_s[1]) ?></h3>
            <p class="apr-stg__q"><?= e($dl_s[2]) ?></p>

            <div class="apr-stg__cols">
              <div class="apr-stg__col">
                <p class="apr-k">What happens</p>
                <ul class="bdh-bullets apr-stg__does"><?php foreach ($dl_s[4] as $dl_x): ?><li><?= e($dl_x) ?></li><?php endforeach; ?></ul>
              </div>
              <div class="apr-stg__col apr-stg__col--ai">
                <p class="apr-k"><?= xt_icon('agent', ['size' => 14]) ?> Where agents do the legwork</p>
                <ul class="apr-stg__ai"><?php foreach ($dl_s[5] as $dl_x): ?><li><?= e($dl_x) ?></li><?php endforeach; ?></ul>
              </div>
            </div>

            <div class="apr-stg__rooms">
              <div>
                <p class="apr-k">In the room · our side</p>
                <p class="bdh-tags"><?php foreach ($dl_s[6] as $dl_x): ?><span class="bdh-tag"><?= e($dl_x) ?></span><?php endforeach; ?></p>
              </div>
              <div>
                <p class="apr-k">In the room · your side</p>
                <p class="bdh-tags"><?php foreach ($dl_s[7] as $dl_x): ?><span class="bdh-tag bdh-tag--blue"><?= e($dl_x) ?></span><?php endforeach; ?></p>
              </div>
            </div>

            <div class="apr-stg__keep">
              <p class="apr-k">What you keep at the end</p>
              <ul class="apr-stg__art"><?php foreach ($dl_s[8] as $dl_x): ?><li><?= e($dl_x) ?></li><?php endforeach; ?></ul>
            </div>
          </div>

          <div class="apr-stg__gate">
            <span class="apr-stg__gi" aria-hidden="true"><?= xt_icon('approve', ['size' => 20]) ?></span>
            <div class="apr-stg__gmain">
              <p class="apr-stg__gt"><span class="apr-k">Gate <?= $dl_n ?></span><b><?= e($dl_s[9]) ?></b></p>
              <p class="apr-stg__gx"><?= e($dl_s[10]) ?></p>
            </div>
            <dl class="apr-stg__gmeta">
              <div><dt>Approver</dt><dd><?= e($dl_s[11]) ?></dd></div>
              <div><dt>Unlocks</dt><dd><?= e($dl_s[12]) ?></dd></div>
            </dl>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <ul class="apr-dl__facts" data-rv-s data-rv-step="70">
      <?php foreach ($dl_fact as $dl_f): ?>
      <li><p class="apr-k"><?= e($dl_f[0]) ?></p><b><?= e($dl_f[1]) ?></b><span><?= e($dl_f[2]) ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
