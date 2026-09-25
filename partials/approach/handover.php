<?php /* DRAFT COPY — review before launch */
/* Handover — the position stated elsewhere on the site, shown as a manifest you could audit: what transfers,
   what stays ours, and the test your own engineer runs before we call it done. The commercial position lives
   in the Commercial Policy and the IP page; this section is the practice, not the terms. */
// PLACEHOLDER: confirm the hypercare window and the post-handover support position with counsel before launch
$hv_groups = [
  ['code', 'Code and infrastructure', [
    'Repositories with their full history, in your organisation — not a zip file at the end',
    'CI and CD pipelines, with the pipeline definitions in the repository',
    'Infrastructure as code for every environment, and the state files',
    'Secrets rotated into your vault at handover, ours revoked the same day',
  ]],
  ['agent', 'AI: prompts, evals, guardrails', [
    'Prompts and system instructions with their version history',
    'The eval suites and the golden sets built from your own cases',
    'Guardrail policies and thresholds, with the reason each value was set',
    'Model routing configuration, so a model can be swapped without us',
  ]],
  ['sparkle', 'Design', [
    'Editable source files, not exports',
    'Design tokens and the component library the build actually uses',
    'Typeface and image licences issued in your name from the start',
    'The accessibility review and the open issues, if any remain',
  ]],
  ['database', 'Content and data', [
    'Content in a portable, documented format',
    'The data model, the migrations and a working export',
    'Retention and deletion settings, with what they are set to and why',
    'Any training or fine-tuning dataset built from your data',
  ]],
  ['log', 'Operations', [
    'Runbooks, written as features landed and rehearsed before go-live',
    'The on-call rota, the escalation path and the alert thresholds',
    'Dashboards and alerts in your accounts, not on our screens',
    'The decision log and an audit log export your auditors can read',
  ]],
  ['key', 'Accounts and access', [
    'Cloud, domain, analytics and third-party accounts in your name from day one',
    'Billing in your name, so nothing stops when we stop',
    'Named roles and least-privilege access, documented',
    'A list of every third party in the stack, with what it costs and what it holds',
  ]],
];
$hv_test = [
  ['Deploy it',       'Your engineer runs a release to production from your pipeline, with us watching and not touching.'],
  ['Restore it',      'A restore from backup into a clean environment, timed, with the result written down.'],
  ['Rotate a key',    'A credential is rotated end to end using the runbook, to prove the runbook is true.'],
  ['Handle an incident', 'A rehearsed failure: your on-call engineer follows the runbook to a fix, and a rollback.'],
  ['Re-run the evals', 'The eval suite is run from your own pipeline and the scores match the ones we reported.'],
];
$hv_keep = [
  ['Yours', 'Everything we made for you', 'Deliverables are assigned to you on payment: the code, the designs, the prompts, the evals, the data and the documentation.'],
  ['Ours',  'Our pre-existing tools and know-how', 'The internal tooling, methods and components we brought with us stay ours, and you get a licence to everything you need to run what we built.'],
  ['Never', 'Your data in a shared model', 'Client data is never used to train shared models. What we take away is what we learned, not what you own.'],
];
$hv_after = [
  ['Two weeks of overlap', 'Your team drives; we sit behind them. Every question that comes up becomes a runbook line the same day.'],
  ['A defined support window', 'Agreed in the statement of work, with what is covered and what is not, so there is no silent dependency on us.'],
  ['No lock-in by design', 'Standard formats, your cloud, your repositories, no proprietary runtime. Leaving should be a decision, not a project.'],
];
?>
<section class="band band--alt apr-hv" id="handover" aria-labelledby="handover-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Handover and IP</p>
        <h2 class="h2" id="handover-t"><span class="g">You own the output.</span> And you can leave with it.</h2>
      </div>
      <div>
        <p class="lead">Every model, dataset, prompt and system we build belongs to you, assigned on payment. Handover is not a folder at the end: the accounts are in your name from day one, and the last week of the engagement is your engineer proving they can run it without us.</p>
        <p class="apr-hv__legl"><a href="<?= e(xe_url('legal/intellectual-property.php')) ?>">Intellectual property</a> and <a href="<?= e(xe_url('legal/commercial-policy.php')) ?>">Commercial Policy</a> carry the terms behind this.</p>
      </div>
    </div>

    <div class="apr-hv__top">
      <div class="apr-hv__man">
        <p class="apr-k">The handover manifest · six groups, checked line by line</p>
        <ol class="apr-hv__gl">
          <?php foreach ($hv_groups as $hv_i => $hv_g): ?>
          <li class="apr-hvg">
            <p class="apr-hvg__k"><span class="apr-hvg__i" aria-hidden="true"><?= xt_icon($hv_g[0], ['size' => 17]) ?></span><span class="apr-hvg__n"><?= str_pad((string) ($hv_i + 1), 2, '0', STR_PAD_LEFT) ?></span></p>
            <h3 class="apr-hvg__t"><?= e($hv_g[1]) ?></h3>
            <ul class="apr-hvg__l"><?php foreach ($hv_g[2] as $hv_x): ?><li><?= e($hv_x) ?></li><?php endforeach; ?></ul>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>
      <div class="apr-hv__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/approach/CREDITS.md) — replace with Xterra Edze's own photography before launch -->
        <figure class="bdh-img bdh-img--r43 apr-hv__fig" data-rv>
          <img src="<?= xe_url('assets/imgs/approach/handover-signing.jpg') ?>" alt="A document being signed at a desk" width="1400" height="1050" loading="lazy" decoding="async">
          <span class="bdh-cap-chip apr-hv__chip"><b>Handover · the last week</b>Signed by your engineer, not by ours</span>
        </figure>
        <dl class="apr-hv__keep">
          <?php foreach ($hv_keep as $hv_k): ?>
          <div><dt><span class="apr-hv__tag is-<?= e(strtolower($hv_k[0])) ?>"><?= e($hv_k[0]) ?></span><?= e($hv_k[1]) ?></dt><dd><?= e($hv_k[2]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

    <div class="apr-hv__exit">
      <div class="apr-hv__eh">
        <p class="apr-k">The exit test</p>
        <h3 class="apr-hv__h">Could another team run this on Monday?</h3>
        <p class="apr-hv__ed">Five things your own engineer does, with us in the room and our hands off the keyboard. If any of them does not work, it is not handed over yet — whatever the calendar says.</p>
      </div>
      <ol class="apr-hv__el" data-rv-s data-rv-step="70">
        <?php foreach ($hv_test as $hv_i => $hv_t): ?>
        <li>
          <span class="apr-hv__en"><?= str_pad((string) ($hv_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h4 class="apr-hv__et"><?= e($hv_t[0]) ?></h4>
          <p class="apr-hv__ep"><?= e($hv_t[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
      <p class="apr-hv__sign"><span class="apr-hv__si" aria-hidden="true"><?= xt_icon('approve', ['size' => 18]) ?></span><span><b>Signed off by your engineer, not ours.</b> The result is written down, with the timings, and it is the last entry in the decision log.</span></p>
    </div>

    <ul class="apr-hv__after" data-rv-s data-rv-step="70">
      <?php foreach ($hv_after as $hv_a): ?>
      <li><h3 class="bdh-t bdh-t--s"><?= e($hv_a[0]) ?></h3><p class="bdh-d"><?= e($hv_a[1]) ?></p></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
