<?php /* DRAFT COPY — review before launch */
/* Agents — the register. Not a claim that "we use AI": the six agents that actually run on a programme,
   what each one is permitted to do on its own, what it may never do, the guardrail that enforces it and
   the named person who owns it. The permission matrix is the argument — four columns of "never" against a
   person's row — and a filter narrows it to the actions that need a person. The filter is hidden in the
   markup and revealed by agents.js, so without JavaScript the full matrix is already on the page.
   Agent names, ids and log lines are illustrative; the permissions are the policy. */
$ag_cols = [
  ['Read the data you gave it', 'read'],
  ['Draft and propose',         'draft'],
  ['Test, scan and evaluate',   'test'],
  ['Merge to main',             'merge'],
  ['Deploy to production',      'deploy'],
  ['Change a guardrail or threshold', 'guard'],
  ['Spend money',               'spend'],
  ['Speak to your customers',   'speak'],
];
/* yes = on its own · gate = only after a named person approves · no = never · na = not part of its job */
$ag_rows = [
  ['research.synthesise', 'agent', ['yes', 'yes', 'na',  'no', 'no',   'no', 'no', 'no']],
  ['spec.draft',          'agent', ['yes', 'yes', 'na',  'no', 'no',   'no', 'no', 'no']],
  ['make.variants',       'agent', ['yes', 'yes', 'yes', 'no', 'no',   'no', 'no', 'no']],
  ['code.pair',           'agent', ['yes', 'yes', 'yes', 'no', 'no',   'no', 'no', 'no']],
  ['guard.release',       'agent', ['yes', 'na',  'yes', 'no', 'no',   'no', 'no', 'no']],
  ['watch.live',          'agent', ['yes', 'yes', 'yes', 'no', 'gate', 'no', 'no', 'no']],
  ['A named person',      'human', ['yes', 'yes', 'yes', 'yes', 'yes', 'gate', 'gate', 'gate']],
];
$ag_key = [
  'yes'  => ['On its own',        '✓'],
  'gate' => ['Needs an approval', '◆'],
  'no'   => ['Never',             '—'],
  'na'   => ['Not its job',       '·'],
];
$ag_filters = [
  ['all',  'Everything',        'Every action in the matrix'],
  ['solo', 'Allowed alone',     'What runs without waiting for anyone'],
  ['gate', 'Needs a person',    'What stops until someone named says yes'],
];
$ag_cards = [
  ['research.synthesise', 'radar', 'Research synthesiser', 'Discover',
   'Reads the transcripts, tickets and reviews you gave it and clusters them into themes, quoting the line that supports each one.',
   'A theme with no verbatim quote and a source id attached is dropped, not softened.',
   'Citation accuracy ≥ 0.95 on a labelled sample, re-checked each engagement.',
   'Strategy lead', 'research.synthesise · 214 sources · 9 themes · 0 uncited'],
  ['spec.draft', 'doc', 'Spec drafter', 'Define · Build',
   'Turns a ticket into acceptance criteria and edge cases, and says plainly where the ticket is ambiguous.',
   'It refuses to write criteria for anything outside the signed scope. It raises a change request instead.',
   'Edge-case coverage ≥ 0.90 against a golden set built from your own past tickets.',
   'Tech lead', 'spec.draft · XE-1482 · 6 criteria · 3 edge cases · 1 ambiguity raised'],
  ['make.variants', 'sparkle', 'Variant maker', 'Design',
   'Generates layout and copy variants inside your design tokens and tone rules, then checks its own output.',
   'A colour, typeface, spacing value or claim that is not in the approved system is held with the reason written.',
   'Brand-rule pass rate ≥ 0.95 and 4.5:1 contrast on all text before anything reaches a person.',
   'Your brand lead, with our product designer', 'make.variants · 152 drafts · 149 pass · 3 held'],
  ['code.pair', 'code', 'Code pair', 'Build',
   'Suggests code in the editor, writes unit and contract tests, and drafts the pull-request summary a reviewer reads first.',
   'Scoped, short-lived tokens only. Secrets never enter a prompt, and it has no access to production data.',
   'Tests pass, coverage does not fall, and performance budgets hold — or the change does not move.',
   'Tech lead', 'code.pair · PR #1482 · +212 −38 · 31 of 38 suggested lines kept'],
  ['guard.release', 'shield', 'Release guard', 'Build · Run',
   'Runs the eval suite, the security scans and the performance budgets on every change, and blocks the merge when one fails.',
   'It cannot unblock itself. An override needs a named person, in writing, and the reason is logged with the release.',
   'It is the evals: the golden set, the scan set and the budget set, versioned like code.',
   'QA and eval engineer', 'guard.release · golden-set@v14 148/148 · sast 0 · secrets 0 · merge unlocked'],
  ['watch.live', 'dashboard', 'Live watcher', 'Run',
   'Watches service levels, Core Web Vitals, eval drift and cost, canaries a release and rolls it back if the numbers move.',
   'It rolls back only to the previous known-good release. It cannot change configuration, and it cannot close an incident.',
   'Drift detection reviewed monthly against labelled incidents, so a silent regression is a finding, not a surprise.',
   'Service owner', 'watch.live · canary 25% · error 0.08% · rollback armed'],
];
$ag_signs = [
  ['rocket',  'Anything that reaches production',      'A named engineer reviews the diff, the eval report and the scan results before the merge.'],
  ['chat',    'Anything that speaks in your name',     'Public copy, customer messages and anything a claim could be read into.'],
  ['cost',    'Anything that spends money',            'Cloud commitments, media budgets, paid tools and model spend above the agreed cap.'],
  ['doc',     'Any change to scope, price or date',    'A written change request, sized as a range, decided by your sponsor.'],
  ['shield',  'Any change to a guardrail or threshold', 'Two signatures: ours and yours. The old value stays in the log.'],
  ['lock',    'Any new purpose for personal data',     'Assessed first, then agreed in writing. Never inferred from an old consent.'],
];
?>
<section class="band band--alt apr-ag" id="agents" aria-labelledby="agents-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The agent register</p>
        <h2 class="h2" id="agents-t"><span class="g">Six agents,</span> and four things none of them may do.</h2>
      </div>
      <div>
        <p class="lead">Every agent on a programme is registered: what it does, what it may do on its own, what it may never do, the guardrail that enforces it and the person who owns it. The register is part of the handover, so your team inherits it.</p>
      </div>
    </div>

    <div class="apr-ag__matrix" data-apr-agents>
      <div class="apr-ag__top">
        <p class="apr-k apr-ag__cap" id="apr-ag-cap">Permission matrix · what each actor may do without asking</p>
        <div class="apr-ag__filter" hidden data-apr-filter>
          <span class="apr-k" id="apr-ag-fl">Narrow to</span>
          <div class="bdh-seg" role="group" aria-labelledby="apr-ag-fl">
            <?php foreach ($ag_filters as $ag_i => $ag_f): ?>
            <button type="button" data-apr-f="<?= e($ag_f[0]) ?>" aria-pressed="<?= $ag_i === 0 ? 'true' : 'false' ?>" title="<?= e($ag_f[2]) ?>"><?= e($ag_f[1]) ?></button>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="bdh-scroll-x mask-x apr-nomask apr-ag__scroll" tabindex="0" role="region" aria-labelledby="apr-ag-cap">
        <p class="bdh-sr" id="apr-ag-desc">Which actions each agent, and a named person, may take. Tick means on its own; diamond means only after a named person approves; dash means never; dot means it is not part of that actor’s job.</p>
        <table class="apr-ag__tbl" aria-labelledby="apr-ag-cap" aria-describedby="apr-ag-desc">
          <thead>
            <tr>
              <th scope="col" class="apr-ag__rh">Actor</th>
              <?php foreach ($ag_cols as $ag_c): ?><th scope="col"><?= e($ag_c[0]) ?></th><?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ag_rows as $ag_r): ?>
            <tr class="apr-ag__r is-<?= e($ag_r[1]) ?>">
              <th scope="row"><span class="apr-ag__who"><?= xt_icon($ag_r[1] === 'human' ? 'users' : 'agent', ['size' => 16]) ?><code><?= e($ag_r[0]) ?></code></span></th>
              <?php foreach ($ag_r[2] as $ag_ci => $ag_v): ?>
              <td class="apr-ag__c is-<?= e($ag_v) ?>" data-v="<?= e($ag_v) ?>">
                <span class="apr-ag__mk" aria-hidden="true"><?= e($ag_key[$ag_v][1]) ?></span>
                <span class="sr"><?= e($ag_key[$ag_v][0]) ?></span>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <p class="apr-ag__legend"><?php foreach ($ag_key as $ag_k => $ag_v): ?><span class="is-<?= e($ag_k) ?>"><i aria-hidden="true"><?= e($ag_v[1]) ?></i><?= e($ag_v[0]) ?></span><?php endforeach; ?></p>
      <p class="apr-ag__note">A named person’s own approvals are bounded too: changing a guardrail, spending beyond the agreed cap and publishing in your name each need your side’s signature as well as ours.</p>
    </div>

    <ol class="apr-ag__cards" data-rv-s data-rv-step="60">
      <?php foreach ($ag_cards as $ag_c): ?>
      <li class="apr-agc">
        <p class="apr-agc__k"><span class="apr-agc__i" aria-hidden="true"><?= xt_icon($ag_c[1], ['size' => 18]) ?></span><code><?= e($ag_c[0]) ?></code><span class="apr-agc__st"><?= e($ag_c[3]) ?></span></p>
        <h3 class="apr-agc__t"><?= e($ag_c[2]) ?></h3>
        <p class="apr-agc__d"><?= e($ag_c[4]) ?></p>
        <dl class="apr-agc__dl">
          <div><dt>Guardrail</dt><dd><?= e($ag_c[5]) ?></dd></div>
          <div><dt>Eval gate</dt><dd><?= e($ag_c[6]) ?></dd></div>
          <div><dt>Named owner</dt><dd><?= e($ag_c[7]) ?></dd></div>
        </dl>
        <p class="apr-agc__log"><span class="sr">Sample log line: </span><code><?= e($ag_c[8]) ?></code></p>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="apr-ag__signs">
      <div class="apr-ag__sh">
        <p class="apr-k">Always</p>
        <h3 class="apr-ag__st">What a person always signs</h3>
        <p class="apr-ag__sd">These six do not move because a deadline is close. If one of them is blocking, the answer is a faster decision, not a lower bar.</p>
      </div>
      <ul class="apr-ag__sl">
        <?php foreach ($ag_signs as $ag_s): ?>
        <li><span class="apr-ag__si" aria-hidden="true"><?= xt_icon($ag_s[0], ['size' => 18]) ?></span><div><b><?= e($ag_s[1]) ?></b><span><?= e($ag_s[2]) ?></span></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
