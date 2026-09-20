<?php /* DRAFT COPY — review before launch */
/* TM-05 Detect & respond — an incident console on ink. Six stages of one illustrative incident (the A2 indirect
   injection from the range) run along a track; each stage is a real tab with its own pane, the CERT-In
   reporting clock counts the six-hour window, the AI triage card types its summary and the analyst confirms.
   Beside it: target KPI tiles and a photograph. Below: proportionate log retention, tiered so storage and
   energy stay in step with the 180-day obligation. Every stage carries the artefact it produced, so the
   console is the same height whichever stage is open and the section reads as evidence rather than a claim.
   HTML = the finished incident (Lessons); soc.js replays. */
$tscs_stages = [   // [key, label, clock label, elapsed minutes since notice (-1 = window closed), pct of window, title, body, [facts], artefact]
/* artefact = [icon, filename or record id, what it is and when, [[column one, column two] x 4], the line under it].
   On Triage the artefact is the AI draft card below, so that stage carries no artefact array. */
    ['alert',   'Alert',       '09:42', 0,   0,   'SIEM correlation fired at 09:42',
        'Three signals in ninety seconds: the support agent called issue_refund on an order outside the signed-in customer’s account, the approval step rejected it twice, and the retrieved help article that started the turn had been edited an hour earlier.',
        [['Source', 'Tool-call audit log · approval queue · CMS change feed'], ['Severity', 'High · auto-assigned'], ['On call', 'Paged within 40 s']],
        ['log', 'correlation-rule SEC-214-R3', 'Audit record · written by the agent runtime',
            [['09:40:51', 'tool_call issue_refund order=#51877 · outside the caller’s scope'],
             ['09:41:16', 'approval_queue reject · order not owned by this session'],
             ['09:41:44', 'approval_queue reject · second attempt, same order'],
             ['09:42:07', 'rule SEC-214-R3 fired · 3 signals in 96 s · severity High']],
            'Written by the runtime, not by the agent. Clocks synced to NTP, entries append-only.']],
    ['triage',  'Triage',      '09:47', 5,   1.4, 'AI drafted the picture. An analyst confirmed it.',
        'The triage assistant read 1,912 log lines, the agent transcript and the article diff, and drafted a one-paragraph summary with the evidence linked. The analyst on call checked the transcript and confirmed the classification at 09:47.',
        [['Summary drafted', '09:44 · 1,912 log lines'], ['Confirmed by', 'Analyst on call · 09:47'], ['Classified as', 'Indirect prompt injection · LLM01']]],
    ['contain', 'Containment', '09:58', 16,  4.4, 'Contained in sixteen minutes',
        'The agent’s tool token was revoked and refunds frozen for the assistant, the poisoned article was pulled from the index, and session keys for the affected customer were rotated. No refund left the account.',
        [['Actions', 'Token revoked · refunds frozen · article removed · keys rotated'], ['Customer impact', 'None confirmed · one session reset'], ['MTTR', '16 min to containment']],
        ['lock', 'containment-actions.log', 'Change record · 09:49 to 09:58',
            [['09:49', 'agent tool token revoked · scope refunds:write withdrawn'],
             ['09:52', 'refund tool disabled for the assistant · flag, no deploy'],
             ['09:55', 'KB-2210 pulled from the retriever index · reindex queued'],
             ['09:58', 'session keys rotated · one customer session reset']],
            'Every action names the analyst who approved it and the ticket it was raised under.']],
    ['report',  'CERT-In report', '12:10', 148, 41.1, 'Reported inside the six-hour window',
        'CERT-In’s 2022 Directions require specified incidents to be reported within six hours of noticing them. The report went at 12:10, two hours and twenty-eight minutes after notice, drafted by the assistant from the incident record and signed off by the security lead.',
        [['Window', '6 h from notice · CERT-In Directions 2022'], ['Filed at', '12:10 · 2 h 28 min elapsed'], ['Also notified', 'Data Protection Board assessment · no personal data breach found']],
        ['doc', 'cert-in-notification.md', 'Filed 12:10 · signed by the security lead',
            [['Noticed', '09:42 IST · SIEM correlation SEC-214-R3'],
             ['Nature', 'Unauthorised transaction attempt via an AI assistant'],
             ['Systems', 'Support assistant · help-centre index · order service'],
             ['Contact', 'Named incident contact and 24×7 number already on file']],
            'Drafted from the incident record by the assistant. A human reads it and signs it.']],
    ['rca',     'Root cause',  'Day 2', -1,  100, 'A new ingest path skipped content isolation',
        'Help articles added through a new CMS integration reached the retriever without being marked as quoted data, so the model treated an edited article as instructions. The control existed; the new path bypassed it.',
        [['Cause', 'Missing content isolation on one ingest path'], ['Detected by', 'Tool scopes and human approval (L3, L4)'], ['Evidence kept', 'Logs held 180 days · clocks synced to NTP']],
        ['git-branch', 'retriever-ingest.diff', 'Control change · reviewed and shipped Day 2',
            [['−', 'isolate_untrusted() called per ingest adapter · 3 of 4 paths'],
             ['+', 'isolate_untrusted() called inside retrieve() · every path'],
             ['+', 'contract test: an unquoted document reaching the model fails the build'],
             ['?', 'CMS adapter added in week 14 never called the helper']],
            'The control existed. The finding is that it sat where a new path could miss it.']],
    ['lessons', 'Lessons',     'Day 3', -1,  100, 'Fixed, tested, rehearsed',
        'Content isolation now sits inside the retriever rather than at each ingest path, the A2 case is in the CI red-team suite, and the next tabletop exercise walks the support team through the same scenario.',
        [['Control change', 'Isolation moved to the retriever · shipped Day 2'], ['Suite', '+3 cases · runs on every model or prompt change'], ['Follow-up', 'Tabletop scheduled · action tracked to closure']],
        ['bug', 'redteam-suite/a2-kb-inject.yaml', 'Case added · runs on every model or prompt change',
            [['case', 'A2 · indirect injection through an edited help article'],
             ['expect', 'blocked at L2 content isolation · no tool call issued'],
             ['gate', 'a critical case that passes blocks the release'],
             ['drill', 'support and security walk the same scenario at the next tabletop']],
            'A closed incident becomes a test. That is what stops it being a repeat.']],
];
$tscs_cur = count($tscs_stages) - 1;   // the finished incident in the HTML
$tscs_summary = 'Likely indirect prompt injection via help article KB-2210 (edited 08:41). The support agent attempted issue_refund on order #51877, outside the customer’s scope; the approval queue rejected the call twice. No refund executed. Recommend: revoke the agent tool token, freeze refunds, pull KB-2210 from the index.';
$tscs_kpi = [   // [label, value, note, kind]
    ['MTTD', '< 15 min', 'Target for critical alerts, from event to a paged human', 'target'],
    ['MTTR to containment', '< 4 h', 'Target for critical incidents; the example above ran in 16 min', 'target'],
    ['Reporting window', '6 h', 'CERT-In Directions 2022, from noticing the incident', 'rule'],
    ['Log retention', '180 d', 'ICT logs kept for a rolling 180 days, within India', 'rule'],
];
$tscs_tiers = [   // [tier, keep, where, relative cost per GB (illustrative index), what for]
    ['Hot',  '0–30 days',   'SIEM, indexed and searchable',        100, 'Live detections, triage, threat hunting'],
    ['Warm', '31–90 days',  'Compressed, queried on demand',        28, 'Investigations that reach back, audit sampling'],
    ['Cold', '91–180 days+', 'Object storage, immutable, in-region', 6, 'The CERT-In obligation and legal hold'],
];
$tscs_tools = ['Splunk', 'Microsoft Sentinel', 'elastic', 'Wazuh', 'falco', 'CrowdStrike', 'pagerduty', 'opentelemetry'];
?>
<section class="band band--ink tsc-soc" id="soc" aria-labelledby="soc-t">
  <span class="tsc-soc__bg dots-ink" aria-hidden="true"></span>
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-05</b><span>Detect &amp; respond</span></p>
        <h2 class="h2" id="soc-t"><span class="g">Detect in minutes.</span> Report on time.</h2>
      </div>
      <div>
        <p class="lead">Detection is only useful if someone acts on it. AI reads the logs and drafts the summary and the report; analysts decide, contain and sign. Here is one illustrative incident, stage by stage, with the clock that India’s CERT-In Directions start the moment you notice it.</p>
      </div>
    </div>

    <div class="tsc-soc__grid">
      <div class="bdh-ui bdh-ui--ink tsc-soc__console" data-rv>
        <div class="bdh-ui__bar tsc-soc__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tsc-soc__title">incidents <i>/</i> SEC-214 <i>/</i> support-assistant</span>
          <span class="tsc-sev tsc-sev--ok tsc-soc__state" data-soc-state>Closed</span>
        </div>

        <div class="tsc-soc__track" role="tablist" aria-label="Incident stages">
          <span class="tsc-soc__line" aria-hidden="true"><i data-soc-line style="--p:1"></i></span>
          <?php foreach ($tscs_stages as $tscs_i => $tscs_s): ?>
            <button type="button" role="tab" class="tsc-soc__stage<?= $tscs_i <= $tscs_cur ? ' is-done' : '' ?>" id="soc-tab<?= $tscs_i ?>" aria-controls="soc-p<?= $tscs_i ?>" aria-selected="<?= $tscs_i === $tscs_cur ? 'true' : 'false' ?>" tabindex="<?= $tscs_i === $tscs_cur ? '0' : '-1' ?>"
                    data-min="<?= $tscs_s[3] ?>" data-pct="<?= $tscs_s[4] ?>">
              <span class="tsc-soc__dot" aria-hidden="true"></span>
              <span class="tsc-soc__st"><?= e($tscs_s[2]) ?></span>
              <span class="tsc-soc__sn"><?= e($tscs_s[1]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="tsc-soc__body">
          <div class="bdh-panes tsc-soc__panes">
            <?php foreach ($tscs_stages as $tscs_i => $tscs_s): ?>
              <div class="bdh-pane tsc-soc__pane<?= $tscs_i === $tscs_cur ? ' is-on' : '' ?>" id="soc-p<?= $tscs_i ?>" role="tabpanel" aria-labelledby="soc-tab<?= $tscs_i ?>">
                <p class="tsc-soc__pk">Stage <?= $tscs_i + 1 ?> of <?= count($tscs_stages) ?> <i>·</i> <?= e($tscs_s[1]) ?></p>
                <h3 class="tsc-soc__pt"><?= e($tscs_s[5]) ?></h3>
                <p class="tsc-soc__pd"><?= e($tscs_s[6]) ?></p>
                <?php if ($tscs_s[0] === 'triage'): ?>
                  <div class="tsc-soc__ai" aria-hidden="true">
                    <p class="tsc-soc__aik"><span class="tsc-soc__aiico"><?= xt_icon('sparkle', ['size' => 14]) ?></span>Triage assistant <i>·</i> draft 09:44</p>
                    <p class="tsc-soc__ait"><span data-soc-type><?= e($tscs_summary) ?></span><span class="bdh-caret"></span></p>
                    <p class="tsc-soc__aic"><span class="tsc-tick"></span>Confirmed by the analyst on call · 09:47 · model and prompt version logged</p>
                  </div>
                <?php elseif (!empty($tscs_s[8])): $tscs_e = $tscs_s[8]; ?>
                  <figure class="tsc-soc__ev">
                    <figcaption class="tsc-soc__evk">
                      <span class="tsc-soc__aiico" aria-hidden="true"><?= xt_icon($tscs_e[0], ['size' => 14]) ?></span>
                      <b><?= e($tscs_e[1]) ?></b><i>·</i><span><?= e($tscs_e[2]) ?></span>
                    </figcaption>
                    <dl class="tsc-soc__evl">
                      <?php foreach ($tscs_e[3] as $tscs_ri => $tscs_r): ?><div style="--i:<?= $tscs_ri ?>"><dt><?= e($tscs_r[0]) ?></dt><dd><?= e($tscs_r[1]) ?></dd></div><?php endforeach; ?>
                    </dl>
                    <p class="tsc-soc__evf"><span class="tsc-tick" aria-hidden="true"></span><?= e($tscs_e[4]) ?></p>
                  </figure>
                <?php endif; ?>
                <dl class="tsc-soc__facts">
                  <?php foreach ($tscs_s[7] as $tscs_f): ?><div><dt><?= e($tscs_f[0]) ?></dt><dd><?= e($tscs_f[1]) ?></dd></div><?php endforeach; ?>
                </dl>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="tsc-soc__clock" aria-hidden="true">
            <p class="tsc-soc__ck">Reporting window</p>
            <div class="tsc-soc__ring">
              <svg viewBox="0 0 120 120">
                <circle class="tsc-soc__rbg" cx="60" cy="60" r="52" pathLength="100"/>
                <circle class="tsc-soc__rfg" cx="60" cy="60" r="52" pathLength="100" data-soc-ring style="--p:100"/>
              </svg>
              <p class="tsc-soc__rt"><b data-soc-elapsed>Filed</b><span data-soc-left>window closed</span></p>
            </div>
            <p class="tsc-soc__cn">6 h from noticing <i>·</i> CERT-In Directions 2022</p>
            <p class="tsc-soc__cf"><span class="tsc-tick"></span>Filed 12:10 · 2 h 28 min after notice</p>
          </div>
        </div>
        <p class="bdh-sr">Illustrative incident console. Six stages, alert, triage, containment, CERT-In report, root cause and lessons, run along a track. A clock shows the six-hour reporting window; the report was filed two hours and twenty-eight minutes after notice. An AI assistant drafts the triage summary and the report; an analyst confirms each.</p>
      </div>

      <aside class="tsc-soc__aside">
        <ul class="tsc-soc__kpis" role="list" data-rv-s data-rv-step="70">
          <?php foreach ($tscs_kpi as $tscs_k): ?>
            <li class="tsc-soc__kpi is-<?= $tscs_k[3] ?>">
              <p class="tsc-soc__kk"><?= e($tscs_k[0]) ?></p>
              <p class="tsc-soc__kv"><?= e($tscs_k[1]) ?></p>
              <p class="tsc-soc__kn"><?= e($tscs_k[2]) ?></p>
              <span class="tsc-soc__kt"><?= $tscs_k[3] === 'target' ? 'Target' : 'Rule' ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r43 tsc-soc__img" data-rv>
          <img src="<?= xe_url('assets/imgs/tech/cybersecurity-ai-trust/team-at-monitors.jpg') ?>" alt="Three people work at a row of monitors in a bright office, one screen showing code and another a ticket board" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:50% 62%">
          <span class="bdh-cap-chip tsc-soc__chip" aria-hidden="true"><b>Who decides</b>AI drafts. Analysts confirm, contain and sign.</span>
        </figure>
      </aside>
    </div>

    <div class="tsc-soc__tiers" data-rv>
      <div class="tsc-soc__th">
        <div>
          <p class="tsc-soc__tk"><?= xt_icon('leaf', ['size' => 16]) ?> Proportionate logging</p>
          <h3 class="tsc-soc__tt">Keep every log the law needs. Pay for hot search only where it earns its place.</h3>
        </div>
        <p class="tsc-soc__td">Telemetry is filtered at source (debug noise, health checks, duplicate events) and tiered by age. Investigation stays fast on the hot tier; the 180-day obligation sits on cold, immutable storage that costs a fraction of the compute and energy. Nothing evidential is dropped.</p>
      </div>
      <ol class="tsc-soc__tlist" aria-label="Log retention tiers">
        <?php foreach ($tscs_tiers as $tscs_i => $tscs_t): ?>
          <li class="tsc-soc__tier" style="--i:<?= $tscs_i ?>">
            <p class="tsc-soc__tn"><b><?= e($tscs_t[0]) ?></b><span><?= e($tscs_t[1]) ?></span></p>
            <p class="tsc-soc__tw"><?= e($tscs_t[2]) ?></p>
            <p class="tsc-soc__tb" aria-hidden="true"><i class="bdh-grow" style="--w:<?= $tscs_t[3] ?>%;--i:<?= $tscs_i + 2 ?>"></i></p>
            <p class="tsc-soc__tc"><span>Relative cost per GB</span><b><?= $tscs_t[3] ?></b></p>
            <p class="tsc-soc__tf"><?= e($tscs_t[4]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <div class="tsc-soc__tfoot">
        <p class="tsc-soc__tsum"><span class="tsc-ill">Illustrative</span><span>Typical result of source filtering and tiering: about 40% less ingested volume and most bytes on cold storage, with detection latency unchanged.</span></p>
        <ul class="tsc-soc__tools" role="list" aria-label="Detection tools we work with">
          <?php foreach ($tscs_tools as $tscs_t): ?><li title="<?= e(tsc_tool_name($tscs_t)) ?>"><?= tsc_tool($tscs_t, ['size' => 20, 'hidden' => true]) ?><span><?= e(tsc_tool_name($tscs_t)) ?></span></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
