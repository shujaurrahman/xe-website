<?php /* DRAFT COPY — review before launch */
/* 04.7 Quality — release gates for features that change. Left: a CI run for "assistant v24" (a prompt edit
   plus a model upgrade) passing eight gates one by one; the red-team gate blocks on one successful indirect
   prompt injection through a retrieved document, the fix is shown (retrieved text fenced as untrusted data,
   tool calls allow-listed, the attack added to the suite), the re-run passes; the last gate waits for a person. Gate rows are buttons that
   open the matching detail on the right (what it tests, which risks, which tools). Below: the frameworks we
   build to, as code-built badges. HTML = the finished, released run. quality.js replays it. Illustrative. */
$tapq_gates = [   // [key, name, check (mono), threshold, result, detail: [title, what, risks, tools]]
    ['golden', 'Golden-set evals', '400 questions · 4 metrics', 'faithfulness ≥ 0.90 · relevance ≥ 0.85', '0.93 · 0.94',
        ['Golden-set evals', 'Every question in the golden set is answered by the candidate release and scored for faithfulness, answer relevance, context precision and context recall by a judge model calibrated against your experts’ labels. A score under threshold blocks the release; the failing answers are listed with their retrieved chunks so the fix is obvious.', ['Regression on prompt or model change', 'Retrieval drift after re-indexing'], ['Ragas', 'Langfuse', 'GitHub Actions']]],
    ['regress', 'Production regression', '1,200 sampled real questions', 'no new “not in sources” sentences', '0 new · 3 fewer',
        ['Production regression', 'Last month’s real questions, anonymised, are replayed through the candidate. Any sentence that the citation check newly flags as unsupported, and any answer whose route changed from answered to handed over without a reason, is listed for review.', ['Silent behaviour change', 'Handover rate creeping up'], ['Replay harness', 'Langfuse']]],
    ['redteam', 'Red-team suite', '181 attack prompts · 5 OWASP LLM risks', '0 successful attacks', '0 of 181 (first run 1 of 180, fixed)',
        ['Red-team suite', 'Attack prompts cover direct and indirect prompt injection (LLM01), attempts to extract other users’ data or secrets (LLM02), outputs that would be unsafe if rendered or executed downstream (LLM05), system prompt leakage (LLM07) and confident misinformation on questions the sources do not answer (LLM09). Every attack must fail. An attack that once succeeded stays in the suite for good.', ['LLM01 prompt injection', 'LLM02 sensitive information disclosure', 'LLM05 improper output handling', 'LLM07 system prompt leakage', 'LLM09 misinformation'], ['Promptfoo', 'Garak', 'Custom suites']]],
    ['pii', 'PII leakage tests', 'synthetic PANs · phones · ID formats', 'none in outputs or logs', 'none found',
        ['PII leakage tests', 'Synthetic card numbers, phone numbers and government-ID formats are planted in retrieved context and in user turns. The release passes only when none appear in answers, traces, analytics events or evaluation datasets, which proves the redaction step runs before logging.', ['Personal data in logs', 'Personal data in eval sets'], ['Presidio', 'Regex + checksum', 'Trace assertions']]],
    ['budget', 'Latency & cost budget', 'p95 latency · cost per answer', 'p95 ≤ 2.5 s · ≤ ₹0.12 per answer', '2.1 s · ₹0.09',
        ['Latency and cost budget', 'The eval run doubles as a load run: p95 latency and cost per answer are computed from the traces and compared with the budget agreed at prototype stage. A model upgrade that is better but three times the cost is a conversation, not a surprise on the invoice.', ['Cost regression', 'Latency regression'], ['OpenTelemetry', 'Grafana', 'Cost model']]],
    ['a11y', 'Accessibility of the AI UI', 'WCAG 2.2 AA · streamed answers', 'announced · focusable · 4.5:1', 'pass · 0 violations',
        ['Accessibility of the AI UI', 'Streamed answers are announced to screen readers as they complete, not token by token. Citations are real links with names, the stop button is reachable by keyboard, and contrast holds in both themes. Automated checks run in CI; a manual pass runs before each major release.', ['WCAG 2.2 AA', 'Screen-reader announcements'], ['axe-core', 'Playwright', 'Manual pass']]],
    ['prov', 'Content credentials', 'generated images and audio', 'C2PA manifest attached · verified', 'signed · verified',
        ['Content credentials', 'Where a feature generates images, audio or video, a C2PA content credential is attached at generation time, stating that the media is AI-generated and by which model. The gate verifies the manifest survives the delivery pipeline, so the disclosure reaches the person who sees it.', ['Undisclosed synthetic media', 'Manifest stripped by resizing'], ['c2pa-rs', 'Signing key in KMS']]],
    ['signoff', 'Human sign-off', 'product owner · canary', 'approval recorded', 'approved · canary 5% → 100%',
        ['Human sign-off', 'A person with accountability for the feature reads the eval summary, the flagged answers and the red-team report, then approves the release to a 5% canary. The rollout widens over 24 hours only if production groundedness holds. The approval, the evidence and the rollout are one audit record.', ['Unowned releases', 'Big-bang rollouts'], ['Release record', 'Feature flags']]],
];
$tapq_badges = ['owasp-llm', 'iso42001', 'nist-ai-rmf', 'wcag22', 'gdpr', 'dpdp', 'eu-ai-act'];
?>
<section class="band band--alt tap-quality" id="quality" aria-labelledby="quality-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.7</span><span>Quality gates</span><span class="tap-eb__p">/quality</span></p>
        <h2 class="h2" id="quality-t"><span class="g">Quality gates for features that change.</span> Nothing ships on a feeling.</h2>
      </div>
      <div>
        <p class="lead">A prompt edit, a model upgrade or a new set of documents is a release. Each one runs the same gates in CI, against a golden set your experts signed, before it reaches a single user. Select a gate to see what it tests.</p>
      </div>
    </div>

    <div class="tap-qg" data-rv>
      <div class="tap-qg__run tap-strip">
        <div class="tap-win__bar tap-qg__bar">
          <span class="tap-win__path"><b>release</b> · assistant v24 · prompt v23 → v24 · model upgrade</span>
          <span class="tap-win__end">
            <span class="tap-qg__status" data-qg-status><span class="tap-led"></span>Released · canary 5% → 100%</span>
            <button type="button" class="tap-btn tap-qg__btn" data-qg-run>Run the gates <span class="tap-btn__i" aria-hidden="true">↻</span></button>
            <span class="tap-ill">Illustrative</span>
          </span>
        </div>
        <ol class="tap-qg__gates" role="list">
          <?php foreach ($tapq_gates as $tapq_i => $tapq_g): ?>
            <li class="tap-qg__gate is-pass" data-gate="<?= e($tapq_g[0]) ?>" style="--i:<?= $tapq_i ?>">
              <button type="button" class="tap-qg__gb" aria-pressed="<?= $tapq_i === 0 ? 'true' : 'false' ?>" aria-controls="qg-d<?= $tapq_i ?>" data-qg-sel="<?= $tapq_i ?>">
                <span class="tap-qg__st" aria-hidden="true"><i></i></span>
                <span class="tap-qg__n"><?= sprintf('%02d', $tapq_i + 1) ?></span>
                <span class="tap-qg__name"><?= e($tapq_g[1]) ?><small><?= e($tapq_g[2]) ?></small></span>
                <span class="tap-qg__th"><?= e($tapq_g[3]) ?></span>
                <span class="tap-qg__res" data-qg-res><span data-qg-final><?= e($tapq_g[4]) ?></span></span>
              </button>
              <?php if ($tapq_g[0] === 'redteam'): ?>
                <p class="tap-qg__fix" data-qg-fix hidden><span>fix</span>retrieved text fenced as untrusted data · tool calls allow-listed · attack added to the suite · re-run</p>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="tap-qg__foot"><span><b>8</b> gates · <b>1</b> blocked then fixed · <b>1</b> human approval</span><span data-qg-time>12 m 40 s</span></p>
        <p class="bdh-sr" aria-live="polite" data-qg-live></p>
      </div>

      <div class="tap-qg__detail bdh-panes">
        <?php foreach ($tapq_gates as $tapq_i => $tapq_g): $tapq_d = $tapq_g[5]; ?>
          <article class="bdh-pane tap-qg__pane<?= $tapq_i === 0 ? ' is-on' : '' ?>" id="qg-d<?= $tapq_i ?>">
            <p class="tap-qg__dk">Gate <?= sprintf('%02d', $tapq_i + 1) ?> of <?= count($tapq_gates) ?></p>
            <h3 class="tap-qg__dt"><?= e($tapq_d[0]) ?></h3>
            <p class="tap-qg__dd"><?= e($tapq_d[1]) ?></p>
            <p class="tap-qg__dl">Catches</p>
            <ul class="tap-qg__risks" role="list"><?php foreach ($tapq_d[2] as $tapq_r): ?><li><?= e($tapq_r) ?></li><?php endforeach; ?></ul>
            <p class="tap-qg__dl">Runs with</p>
            <ul class="tap-qg__tools" role="list"><?php foreach ($tapq_d[3] as $tapq_t): ?><li><?= e($tapq_t) ?></li><?php endforeach; ?></ul>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tap-qg__std" data-rv>
      <div class="tap-qg__sh">
        <p class="tap-qg__sk">Frameworks we build to</p>
        <p class="tap-qg__sd">Code-built badges for the frameworks our gates align with. They describe how we work, not a certificate we hold.</p>
      </div>
      <ul class="xt-badges tap-qg__badges" role="list">
        <?php foreach ($tapq_badges as $tapq_b) { echo xt_badge($tapq_b, ['tag' => 'li', 'detail' => true]); } ?>
        <li class="xt-badge tap-qg__c2pa" data-standard="c2pa">
          <svg class="xt-badge__art" viewBox="0 0 64 64" aria-hidden="true" focusable="false"><rect class="xt-badge__ln" x="5.5" y="5.5" width="53" height="53" rx="13"/><rect class="xt-badge__ln2" x="11" y="11" width="42" height="42" rx="9"/><path class="xt-badge__ac" d="M26 11h12"/><text class="xt-badge__mk" x="32" y="34" text-anchor="middle" style="font-size:11px">C2PA</text><text class="xt-badge__sb" x="32" y="43" text-anchor="middle">PROVENANCE</text></svg>
          <span class="xt-badge__txt"><span class="xt-badge__code">C2PA content credentials</span><span class="xt-badge__name">Provenance for generated media</span><span class="xt-badge__covers">An open technical standard for attaching signed provenance to images, audio and video, including whether a model generated or edited them.</span></span>
        </li>
      </ul>
    </div>
  </div>
</section>
