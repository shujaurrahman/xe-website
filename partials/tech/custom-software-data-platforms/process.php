<?php /* DRAFT COPY — review before launch */
/* 11 Process — model, build, migrate, run. A sticky column (heading, the modelling-wall photograph with an
   event-storming legend) beside a vertical timeline of five stages. Each stage: its weeks, what happens, the
   artefacts it leaves in your repositories, where agents help and what people decide, and a one-line readout of
   the moment the stage is done (a terminal line on the three delivery stages only). Each stage is one heading
   row, the description, a plain two-column "agents help / people decide" row and a mono artefact line, so the
   timeline stays short. process.js fills the spine with the scroll and lights each stage as it passes.
   The HTML is the finished timeline. Timings are placeholders. */
$tcs_pr_steps = [   // [key, name, weeks, description, artefacts, agents help, people decide, readout]
    ['model', 'Model the domain', 'Wk 01–03',
        'Event storming with the people who do the work: events, commands and rules, then the entities behind them. Build, buy or extend is decided per module.',
        ['Event-storming board', 'ERD', 'Decision records', 'Quality targets'],
        'Transcribe the workshop wall into a draft event catalogue and ERD overnight, and flag words the business uses two ways.',
        'The boundaries, the names, and which module ships first.',
        ''],
    ['slice', 'Ship a thin slice', 'Wk 04–08',
        'One real flow in production behind a flag: single sign-on, real data, CI/CD and observability from the first deploy. Every later module lands on it.',
        ['Walking skeleton', 'CI/CD pipeline', 'Infrastructure as code', 'Alerts'],
        'Scaffold admin screens, API clients and contract tests from the schema and the OpenAPI 3.1 spec.',
        'Every merge, reviewed by an engineer. Acceptance of the slice by its users.',
        'deploy #1 → prod · flag onboarding.v1 on for 12 users · p95 180 ms'],
    ['build', 'Build module by module', 'Wk 09+ · every sprint',
        'Two-week sprints in priority order, each ending in a demo on production data and a release behind a flag. The domain model grows by migration, never by a side table.',
        ['Module releases', 'OpenAPI 3.1 reference', 'Test suites in CI', 'Release notes'],
        'Draft tests, schema migrations, documentation and release notes; propose refactors when a module drifts from the model.',
        'Design, priorities and code review. Nothing merges on an agent’s approval.',
        'sprint 06 · 3 modules live · 1,184 tests · 0 failed'],
    ['migrate', 'Migrate in waves', 'Per module',
        'Data migrated in rehearsed dry runs, parallel runs with nightly reconciliation, then traffic moved by percentage. Training happens before a team’s cutover, not after.',
        ['Migration scripts', 'Reconciliation reports', 'Rollback plans', 'Training'],
        'Compare sampled records between old and new, cluster the differences and summarise them for the owner.',
        'Sign-off per wave. Finance signs the money modules.',
        'wave 3 · 4.8 M rows compared · 0 diffs · signed 14:20'],
    ['run', 'Run and improve', 'Ongoing',
        'SLOs with error budgets, weekly adoption and data-quality reviews, and a backlog your team owns. The platform keeps changing as the business does.',
        ['SLOs', 'Runbooks', 'Adoption dashboard', 'Architecture reviews'],
        'Triage alerts, draft incident timelines, and answer “where does this number come from” from the lineage.',
        'On-call decisions, the roadmap, and what to retire.',
        ''],
];
?>
<section class="band tcs-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="tcs-pr">
      <div class="tcs-pr__side">
        <div class="tcs-pr__sticky">
          <div class="bdh-head tcs-pr__head" data-rv>
            <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>How we work · five stages</p>
            <h2 class="h2" id="process-t"><span class="g">Model, build,</span> migrate, run.</h2>
            <p class="lead">The domain model is agreed before the first screen, so every later feature has somewhere to land. A thin slice reaches production early; after that, modules ship every sprint.</p>
          </div>

          <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
          <figure class="bdh-img bdh-img--r43 tcs-pr__img" data-rv>
            <img src="<?= xe_url('assets/imgs/tech/custom-software-data-platforms/process-modelling-wall.jpg') ?>" alt="A whiteboard covered in sticky notes in rows, with boxes and arrows drawn between them" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:40% 45%">
          </figure>
          <div class="tcs-pr__legend" data-rv>
          <p class="tcs-pr__kk" id="process-key-l">Notation in our models</p>
          <ul class="tcs-pr__key" aria-labelledby="process-key-l">
            <li><i class="is-ev"></i><b>Domain event</b><span>order.placed</span></li>
            <li><i class="is-cmd"></i><b>Command</b><span>place order</span></li>
            <li><i class="is-pol"></i><b>Policy</b><span>when paid, ship</span></li>
            <li><i class="is-hot"></i><b>Hotspot</b><span>who approves?</span></li>
          </ul>
          </div>
        </div>
      </div>

      <div class="tcs-pr__main">
        <!-- PLACEHOLDER: confirm typical stage timings before launch -->
        <div class="tcs-pr__tlw">
        <span class="tcs-pr__spine" aria-hidden="true"><i></i></span>
        <ol class="tcs-pr__tl" aria-label="Five stages">
          <?php foreach ($tcs_pr_steps as $tcs_pr_i => $tcs_pr_s): ?>
            <li class="tcs-pr__st is-on is-seen" data-st="<?= $tcs_pr_s[0] ?>">
              <span class="tcs-pr__node" aria-hidden="true"><?= sprintf('%02d', $tcs_pr_i + 1) ?></span>
              <div class="tcs-pr__card">
                <div class="tcs-pr__hd">
                  <h3 class="tcs-pr__t"><?= e($tcs_pr_s[1]) ?></h3>
                  <p class="tcs-pr__wk"><?= e($tcs_pr_s[2]) ?></p>
                </div>
                <p class="tcs-pr__d"><?= e($tcs_pr_s[3]) ?></p>
                <dl class="tcs-pr__roles">
                  <div><dt><?= xt_icon('agent', ['size' => 14]) ?>Agents help</dt><dd><?= e($tcs_pr_s[5]) ?></dd></div>
                  <div><dt><?= xt_icon('approve', ['size' => 14]) ?>People decide</dt><dd><?= e($tcs_pr_s[6]) ?></dd></div>
                </dl>
                <p class="tcs-pr__arts"><span class="tcs-pr__lk"><?= xt_icon('git-branch', ['size' => 14, 'mono' => true]) ?>In your repo</span><span class="tcs-pr__al"><?= e(implode(' · ', $tcs_pr_s[4])) ?></span></p>
                <?php if ($tcs_pr_s[7] !== ''): ?><p class="tcs-pr__ro"><span class="tcs-pr__pr" aria-hidden="true">$</span><span><?= e($tcs_pr_s[7]) ?></span></p><?php endif; ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
        </div>
      </div>
    </div>
  </div>
</section>
