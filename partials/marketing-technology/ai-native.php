<?php /* DRAFT COPY — review before launch */
/* AI-native — the concrete answer to "where does AI actually decide something". Four decision points, each
   with its model, its threshold, its rule-based fallback and its named approver; one agent run shown step by
   step with the permission scope and the check result at each step; and the two lists that matter —
   the guardrails, and what we do not let an AI do.
   The run is a transport control (previous, play, next) over seven steps. With JavaScript off every step is
   expanded and readable: ai-native.js adds .is-run to collapse them, so the page is never blank or partial. */
$ain_decisions = [
    // [decision, model, inputs, threshold, fallback, approval]
    ['Who enters a journey',    'Propensity model',        'First-party behaviour, transactions, service history', 'Enter above 0.40',             'The agreed rule-based segment',      'Journey approved once, then monitored'],
    ['What the next action is', 'Next best action model',  'Profile, recent events, offer eligibility, margin',    'Act above 0.60',               'The best-performing rule path',       'A person approves every campaign send'],
    ['When to send',            'Send-time model',         'That person’s own response history, timezone',         'Always inside your quiet hours', 'A fixed slot per segment',           'Quiet hours and caps are set by you'],
    ['Which variant to use',    'Sequential test or bandit', 'Variant exposure and outcome, fatigue signals',      'Significance or minimum exposure', 'The control variant',              'Creative approved before it can enter'],
];
$ain_run = [
    // [step, what the agent does, permission scope, the check, the log line]
    ['Brief',    'Reads the approved brief, the segment definition and the claim library.',                          'read · brief, segments, claims',     'Brief matches an approved campaign', 'agent.read brief/gc-114 segments/high-value claims/v9'],
    ['Audience', 'Builds the audience in your platform from the agreed segment, with the consent filter applied.',    'write · draft audience only',        'Consent filter applied · 0 unconsented', 'agent.build audience=high_value_lapsing size=held consent_filter=on'],
    ['Draft',    'Drafts the copy and assembles the variants from your components, inside the brand rules.',          'write · drafts, never published',    'Brand rules pass · claims pass',     'agent.draft variants=8 brand=pass claims=pass tone=approved'],
    ['Check',    'Runs pre-flight QA: links, personalisation tokens, dark mode, accessibility, suppression, caps.',   'read · test accounts only',          '1 failure found, not a warning',     'agent.qa links=ok tokens=ok dark=ok a11y=ok cap=ok legal=FAIL'],
    ['Hold',     'Anything that fails a check is blocked rather than flagged, and the agent says which rule failed.', 'none · the agent cannot override',   'Blocked on a missing legal line',    'agent.hold reason=legal_line_missing(market=IN) release=denied'],
    ['Approve',  'A named person fixes it and releases it. The log records who, which version and when.',             'human · your named approver',        'Released by a person, not a model',  'human.approve user=your-lifecycle-owner version=v4 at=10:12 IST'],
    ['Send',     'Your platform sends. Consent is re-checked at send time, not at audience build time.',              'platform · scheduled send',          'Consent re-checked at send',         'platform.send channel=email queued=held consent_recheck=pass'],
];
$ain_guards = [
    ['Scoped permissions',   'Every agent gets least privilege: drafts, test accounts and named integrations. None holds a production send scope.'],
    ['Evals before release', 'Prompt, model or rule changes run against a fixed set of real cases, and a drop below the threshold blocks the release.'],
    ['Your data stays yours','Enterprise terms that exclude training on your inputs, or models running inside your own environment.'],
    ['A log of every step',  'Who or what did it, on which version, at what time, and what the check returned.'],
    ['A kill switch',        'Any journey, agent or automated allocation can be stopped by your team without a ticket to us.'],
    ['Human release',        'A named person approves every campaign send. Triggered templates are approved once and then monitored.'],
];
$ain_never = [
    'Move budget beyond the caps and exclusions you set.',
    'Send or publish anything without a named approver.',
    'Price or discount by an individual’s characteristics or inferred willingness to pay.',
    'Use special-category data, or a proxy for it, in a model.',
    'Write to your system of record without a review step.',
];
?>
<section class="band band--ink mth-ai" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI-native, concretely</p>
        <h2 class="h2" id="ai-native-t"><span class="g">Four places a model decides.</span> Every one has a fallback and an approver.</h2>
      </div>
      <div>
        <p class="lead">AI in a marketing stack is not one feature. It is a small number of decisions taken thousands of times, plus the agents that do the assembly around them. Both are only safe when the threshold, the fallback, the check and the approver are written down.</p>
      </div>
    </div>

    <div class="mth-ai__top">
      <div class="mth-ai__dec" data-rv data-rv-d="40">
        <h3 class="mth-ai__h3">Where the model decides</h3>
        <div class="bdh-scroll-x mth-ai__scroll" tabindex="0" role="group" aria-label="The four model decisions, scroll sideways to see every column">
          <table class="mth-ai__table">
            <thead>
              <tr>
                <th scope="col">Decision</th>
                <th scope="col">Model</th>
                <th scope="col">What it reads</th>
                <th scope="col">Threshold</th>
                <th scope="col">Fallback</th>
                <th scope="col">Who approves</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ain_decisions as $ain_d): ?>
                <tr>
                  <th scope="row"><?= e($ain_d[0]) ?></th>
                  <td><?= e($ain_d[1]) ?></td>
                  <td><?= e($ain_d[2]) ?></td>
                  <td><span class="mth-flag mth-flag--on"><?= e($ain_d[3]) ?></span></td>
                  <td><?= e($ain_d[4]) ?></td>
                  <td><?= e($ain_d[5]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="mth-note">Every model is documented in a model card: the features it uses, the ones deliberately excluded, how it was tested, and who reviews it. A holdout group runs against each one, so its contribution is measurable and it can be switched off without switching off the programme.</p>
      </div>

      <div class="mth-ai__guards" data-rv data-rv-d="70">
        <h3 class="mth-ai__h3">The guardrails</h3>
        <dl class="mth-ai__gl">
          <?php foreach ($ain_guards as $ain_g): ?>
            <div><dt><?= e($ain_g[0]) ?></dt><dd><?= e($ain_g[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

    <div class="mth-ai__run" data-rv data-rv-d="60" data-bdh-live>
      <div class="mth-ai__runh">
        <div>
          <p class="mth-k mth-k--blue">One agent run · illustrative</p>
          <h3 class="mth-ai__h3">Agents draft and check. People release.</h3>
          <p class="mth-ai__runl">This is a campaign being assembled by an agent with scoped permissions. Step five is the point of the whole design: a failed check blocks the work instead of warning about it.</p>
        </div>
        <div class="mth-ai__ctl" role="group" aria-label="Step through the agent run">
          <button class="mth-ai__cb" type="button" data-act="prev">
            <span aria-hidden="true">‹</span><span class="bdh-sr">Previous step</span>
          </button>
          <button class="mth-ai__cb mth-ai__cb--play" type="button" data-act="play" aria-pressed="false">
            <span class="mth-ai__cbt">Play the run</span>
          </button>
          <button class="mth-ai__cb" type="button" data-act="next">
            <span aria-hidden="true">›</span><span class="bdh-sr">Next step</span>
          </button>
          <p class="mth-ai__pos" aria-live="polite">Step <span data-pos>1</span> of <?= count($ain_run) ?></p>
        </div>
      </div>

      <ol class="mth-ai__steps">
        <?php foreach ($ain_run as $ain_i => $ain_s): ?>
          <li class="mth-ai__step<?= $ain_i === 0 ? ' is-on' : '' ?>" data-step="<?= $ain_i ?>">
            <button class="mth-ai__sb" type="button" aria-expanded="true" aria-controls="ai-step-<?= $ain_i ?>">
              <span class="mth-ai__sn"><?= str_pad((string) ($ain_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="mth-ai__st"><?= e($ain_s[0]) ?></span>
              <span class="mth-flag<?= $ain_i === 4 ? ' mth-flag--off' : ' mth-flag--on' ?>"><?= e($ain_s[3]) ?></span>
            </button>
            <div class="mth-ai__sd" id="ai-step-<?= $ain_i ?>">
              <p class="mth-ai__sw"><?= e($ain_s[1]) ?></p>
              <p class="mth-ai__ss"><span class="mth-k">Permission scope</span><code><?= e($ain_s[2]) ?></code></p>
              <p class="mth-ai__sl" aria-hidden="true"><span class="mth-ai__lp">›</span><?= e($ain_s[4]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="mth-ai__never">
        <p class="mth-k">What we do not let an AI system do</p>
        <ul class="bdh-bullets mth-ai__nl">
          <?php foreach ($ain_never as $ain_n): ?><li><?= e($ain_n) ?></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
