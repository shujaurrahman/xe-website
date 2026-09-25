<?php /* DRAFT COPY — review before launch */
$apr_st = [
  ['discover', 'Discover', 'What is true today, and what is it costing you?', 'Synthesise interviews, analytics, reviews and competitor signals into themes with sources attached.',
     ['Evidence map with sources', 'Stakeholder interview notes', 'Opportunity shortlist'], 'Problem framed', 'Your executive sponsor', 'Agreed problem statement and success measures', '1–3 weeks'],
  ['define', 'Define', 'What will we build, and how will we know it worked?', 'Draft requirement options, estimate effort ranges, flag risks and dependencies from the evidence.',
     ['Scope and acceptance criteria', 'Measurement plan', 'Risk and dependency register'], 'Scope signed', 'Sponsor + product owner', 'Scope, budget model and measures signed', '1–2 weeks'],
  ['design', 'Design', 'Does it work for the people who will use it?', 'Generate variants inside the brand system, run accessibility and content checks on every frame.',
     ['Prototype and design system tokens', 'Accessibility review (WCAG 2.2 AA)', 'Usability test findings'], 'Design approved', 'Product owner + brand lead', 'Tested prototype, no open AA issues', '2–6 weeks'],
  ['build', 'Build', 'Is it correct, fast and secure?', 'Propose code with tests, run evals, performance budgets and security scans on every change.',
     ['Working software in staging', 'Test and eval reports', 'Threat model and security scan'], 'Release approved', 'Tech lead + your IT/security', 'All budgets green, human code review done', '4–16 weeks'],
  ['run', 'Run', 'Is it staying healthy in the real world?', 'Monitor uptime, Core Web Vitals, cost, drift and content freshness; open tickets with evidence.',
     ['Runbook and on-call rota', 'Live dashboards', 'Incident and change log'], 'Service accepted', 'Your operations owner', 'Service levels met for an agreed period', 'Ongoing'],
  ['improve', 'Improve', 'What should change next, and why?', 'Rank experiments by expected value, draft variants, and read results back into the backlog.',
     ['Experiment log', 'Quarterly outcome review', 'Updated roadmap'], 'Roadmap reset', 'Sponsor, quarterly', 'Measured outcomes reviewed, next bets agreed', 'Quarterly'],
];
?>
<section class="band apr-dl" id="delivery" aria-labelledby="delivery-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Delivery, stage by stage</p>
        <h2 class="h2" id="delivery-t"><span class="g">Six stages.</span> Nothing moves on without a named yes.</h2></div>
      <div><p class="lead">Each stage ends at a gate with written exit criteria, the artefacts you keep, and the person on your side who signs it off.</p></div>
    </div>
    <div class="apr-dl__grid">
      <nav class="apr-dl__rail bdh-scroll-x mask-x" aria-label="Delivery stages" tabindex="0">
        <ol>
          <?php foreach ($apr_st as $apr_n => $apr_s): ?>
          <li><a href="#stage-<?= $apr_s[0] ?>" data-apr-stage="<?= $apr_s[0] ?>"><span>0<?= $apr_n + 1 ?></span><?= e($apr_s[1]) ?></a></li>
          <?php endforeach; ?>
        </ol>
      </nav>
      <ol class="apr-dl__list">
        <?php foreach ($apr_st as $apr_n => $apr_s): ?>
        <li class="apr-stg" id="stage-<?= $apr_s[0] ?>">
          <div class="apr-stg__head">
            <span class="apr-stg__n">0<?= $apr_n + 1 ?></span>
            <h3 class="apr-stg__t"><?= e($apr_s[1]) ?></h3>
            <!-- PLACEHOLDER: confirm typical stage lengths before launch -->
            <span class="apr-stg__len">Typically <?= e($apr_s[8]) ?></span>
          </div>
          <p class="apr-stg__q"><?= e($apr_s[2]) ?></p>
          <div class="apr-stg__body">
            <div><p class="apr-k">Agents do</p><p class="apr-stg__d"><?= e($apr_s[3]) ?></p></div>
            <div><p class="apr-k">You keep</p><ul class="apr-stg__art"><?php foreach ($apr_s[4] as $apr_a): ?><li><?= e($apr_a) ?></li><?php endforeach; ?></ul></div>
          </div>
          <div class="apr-stg__gate">
            <span class="apr-stg__gi"><?= xt_icon('approve') ?></span>
            <p><b>Gate · <?= e($apr_s[5]) ?></b><span>Exit: <?= e($apr_s[7]) ?></span></p>
            <p class="apr-stg__who"><span class="apr-k">Approver</span><?= e($apr_s[6]) ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
