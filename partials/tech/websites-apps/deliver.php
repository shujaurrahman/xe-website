<?php /* DRAFT COPY — review before launch */
/* 10 · What you get, shown the way an engineer receives it: the repository tree. Six folders, each a real
   disclosure button; the rows are the deliverables with their format. Everything is open in the HTML, so the
   section reads in full without JavaScript; deliver.js collapses all but the first two on load. Beside the tree,
   what lives outside the repository — accounts, dashboards, stores — and the handover terms. */
$twa_dl_tree = [
    [
        'p' => 'apps/web/', 'i' => 'browser', 'n' => 'The web application',
        'f' => [
            ['app/', 'Routes, server components and streaming boundaries', 'TypeScript'],
            ['components/', 'Application components built on the shared design system', 'TypeScript'],
            ['tests/e2e/', 'End-to-end journeys, run on four device profiles', 'Playwright'],
            ['lighthouserc.json', 'Performance budgets enforced on every pull request', 'JSON'],
            ['README.md', 'Set-up, environments, conventions and who to call', 'Markdown'],
        ],
    ],
    [
        'p' => 'apps/mobile/', 'i' => 'mobile', 'n' => 'The mobile application',
        'f' => [
            ['ios/ · android/', 'Signed release builds and the keys held in your vault', 'IPA · AAB'],
            ['fastlane/', 'Store submission lanes, reproducible from a clean machine', 'Ruby'],
            ['store/', 'Listings, screenshots, privacy labels and release notes', 'Markdown · PNG'],
            ['crash/', 'Crash reporting wiring and symbol upload', 'Config'],
        ],
    ],
    [
        'p' => 'packages/ui/', 'i' => 'layers', 'n' => 'The design system, in code',
        'f' => [
            ['tokens.json', 'One token source, compiled for web and both mobile platforms', 'JSON'],
            ['components/', 'Component library with usage notes and prop tables', 'TypeScript · Storybook'],
            ['a11y/', 'Automated accessibility checks plus the manual WCAG 2.2 AA checklist', 'Playwright · axe'],
            ['CHANGELOG.md', 'Versioned releases, so upgrades are a decision and not a surprise', 'Markdown'],
        ],
    ],
    [
        'p' => 'cms/', 'i' => 'doc', 'n' => 'Content models and migrations',
        'f' => [
            ['schema/', 'Content models, validation rules and editorial previews', 'TypeScript'],
            ['migrations/', 'Reversible content migrations, run in CI against a copy first', 'TypeScript'],
            ['roles.md', 'Editor, reviewer and publisher permissions as configured', 'Markdown'],
        ],
    ],
    [
        'p' => 'docs/', 'i' => 'clipboard-check', 'n' => 'Everything a new engineer needs',
        'f' => [
            ['architecture/adr/', 'Architecture decision records: what we chose, and what we rejected', 'Markdown'],
            ['runbooks/', 'Release, rollback, incident and on-call runbooks', 'Markdown'],
            ['accessibility-statement.md', 'Conformance statement, known issues and the plan for each', 'Markdown'],
            ['performance-budget.md', 'The budget, how it was set and how to change it', 'Markdown'],
            ['handover/', 'Recorded walkthroughs of the codebase and the pipeline', 'Video · Markdown'],
        ],
    ],
    [
        'p' => '.github/workflows/', 'i' => 'pipeline', 'n' => 'The pipeline that keeps it honest',
        'f' => [
            ['ci.yml', 'Tests, performance budget, axe, visual diff and dependency scan', 'YAML'],
            ['preview.yml', 'A preview deployment for every pull request', 'YAML'],
            ['release.yml', 'Staged rollout, RUM guard and automatic rollback', 'YAML'],
            ['schedule.yml', 'Nightly field-data pull and budget drift report', 'YAML'],
        ],
    ],
];
$twa_dl_outside = [
    ['cloud',     'Your accounts, from the first commit', 'Code, cloud, CMS, app stores and analytics live in your organisation. We work inside them; we do not hold the keys after handover.'],
    ['dashboard', 'Analytics and real-user monitoring', 'Core Web Vitals at p75 by template and device, conversion and task completion, crash-free sessions and error budgets, on dashboards your team can read.'],
    ['key',       'Credentials in your vault', 'Secrets are created in your secret manager and rotated at handover. Nothing is shared over email or chat.'],
    ['handshake', 'Handover that is a session, not a folder', 'Recorded walkthroughs of the architecture, the pipeline and the runbooks, followed by a period where your engineers drive and we review.'],
];
?>
<section class="band band--alt twa-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>10 · Deliverables</b><span>Six folders · your repository · your accounts</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="deliver-t"><span class="g">What you get</span> is a repository you can run without us.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Not a slide deck of outputs. A tree your engineers can clone on day one, with the tests, budgets, runbooks and decision records that explain why it is built this way.</p>
      </div>
    </div>

    <div class="twa-dl" data-rv>
      <div class="twa-dl__repo">
        <div class="twa-dl__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="twa-dl__path"><?= xt_icon('git-branch', ['size' => 14, 'mono' => true]) ?>your-platform <span aria-hidden="true">·</span> main</span>
          <span class="twa-dl__hint">Open a folder to see what is in it</span>
        </div>
        <ul class="twa-dl__tree" role="list">
          <?php foreach ($twa_dl_tree as $twa_i => $twa_fo): ?>
            <li class="twa-dl__fo">
              <h3 class="twa-dl__fh">
                <button type="button" class="twa-dl__fb" id="deliver-f-<?= $twa_i ?>" aria-expanded="true" aria-controls="deliver-l-<?= $twa_i ?>" data-dl-fold>
                  <span class="twa-dl__caret" aria-hidden="true"></span>
                  <span class="twa-dl__fi" aria-hidden="true"><?= xt_icon($twa_fo['i'], ['size' => 18]) ?></span>
                  <span class="twa-dl__fp"><?= e($twa_fo['p']) ?></span>
                  <span class="twa-dl__fn"><?= e($twa_fo['n']) ?></span>
                  <span class="twa-dl__fc"><?= count($twa_fo['f']) ?> items</span>
                </button>
              </h3>
              <ul class="twa-dl__files" id="deliver-l-<?= $twa_i ?>" role="list" aria-labelledby="deliver-f-<?= $twa_i ?>">
                <?php foreach ($twa_fo['f'] as $twa_fi => $twa_f): ?>
                  <li class="twa-dl__file" style="--i:<?= $twa_fi ?>">
                    <span class="twa-dl__fname"><?= e($twa_f[0]) ?></span>
                    <span class="twa-dl__fd"><?= e($twa_f[1]) ?></span>
                    <span class="twa-dl__ff"><?= e($twa_f[2]) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="twa-dl__foot"><?= xt_icon('lock', ['size' => 15, 'mono' => true]) ?><span>Licensed to you outright. No proprietary framework, no runtime licence, no clause that makes leaving expensive.</span></p>
      </div>

      <aside class="twa-dl__side">
        <p class="twa-dl__sk">And everything that lives outside the repository</p>
        <ul class="twa-dl__out" role="list">
          <?php foreach ($twa_dl_outside as $twa_o): ?>
            <li>
              <span class="twa-dl__oi"><?= xt_icon($twa_o[0], ['size' => 20]) ?></span>
              <h3 class="twa-dl__ot"><?= e($twa_o[1]) ?></h3>
              <p class="twa-dl__od"><?= e($twa_o[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </aside>
    </div>
  </div>
</section>
