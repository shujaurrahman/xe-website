<?php /* DRAFT COPY — review before launch */
/* TM-04 OWASP — the Top 10 for LLM Applications (2025) as a control register. Left: the badge and a
   coverage readout (every risk has a test, a control and evidence). Right: ten rows; each expands (core
   [data-acc]) to how we test it, the control we build and what lands in the audit pack. Pips and ticks
   draw on entry; owasp.js runs one scan pass and keeps the selected-risk readout in step. */
$tsco_modes = ['ci' => 'CI suite', 'red' => 'Manual red-team', 'design' => 'Design review', 'eval' => 'Eval gate', 'load' => 'Abuse test'];
$tsco_rows = [   // [id, name, risk (one line), how we test, control we build, evidence, mode key, ATLAS technique]
    ['LLM01', 'Prompt Injection',
        'Text the model reads, typed or hidden in a document, changes what it does or what its tools do.',
        'Direct and indirect suites (Garak, PyRIT, our own cases) run in CI on every prompt, model or tool change: instructions buried in PDFs, web pages, tickets and email signatures, plus multi-turn escalation.',
        'Instructions and data kept apart, an input classifier ahead of the model, tool allow-lists with per-user scopes, and a person approving every write action.',
        'Red-team pass rate per release, blocked-attempt log, the gate that stops a release below threshold.',
        'ci', 'AML.T0051'],
    ['LLM02', 'Sensitive Information Disclosure',
        'Personal data, secrets or another tenant’s records leave through the model’s reply.',
        'Canary secrets and synthetic personal data seeded into context and documents, then extraction and cross-tenant prompts; output checked for exact and fuzzy matches.',
        'Output filter with data-loss prevention, least data in context, tenant-scoped retrieval, no secrets in prompts, and masking in non-production.',
        'DLP hit log, canary alerts, retrieval permission test results.',
        'ci', 'AML.T0057'],
    ['LLM03', 'Supply Chain',
        'A compromised model file, dataset, adapter, plugin or package ships inside the product.',
        'Provenance review of every model and dataset, an AI bill of materials beside the SBOM, dependency and container scanning, checks for pickle-based model files and unpinned versions.',
        'Signed artefacts, pinned model versions from a private registry, allow-listed plugins and tools, SLSA provenance for what we build.',
        'AIBOM and SBOM per release, signature verification log, scanner reports.',
        'design', 'AML.T0010'],
    ['LLM04', 'Data and Model Poisoning',
        'Training, fine-tuning or embedding data is manipulated so the model behaves differently on cue.',
        'Lineage review of new training data, anomaly checks on additions, and a behaviour regression eval against a golden set before any fine-tune or index rebuild goes live.',
        'Curated ingestion with approvals, versioned datasets and indexes, eval gates ahead of rollout and fast rollback to the last good version.',
        'Dataset version log, eval report per version, rollback record.',
        'eval', 'AML.T0020'],
    ['LLM05', 'Improper Output Handling',
        'Model output reaches a browser, shell, database or email unchecked, and becomes an injection.',
        'Outputs carrying markdown, HTML, SQL and shell payloads rendered or executed in the real downstream systems; DAST against the chat surface.',
        'Output treated as untrusted input: encoded, sanitised, parameterised; a Content-Security-Policy on the client; no direct execution of model text.',
        'DAST results, CSP report-only log, code review checklist.',
        'ci', 'AML.T0077'],
    ['LLM06', 'Excessive Agency',
        'An agent holds more tools, permissions or autonomy than the task needs, and a manipulated turn spends them.',
        'Tool-misuse scenarios: bulk refunds, deletes, outbound email, privilege escalation by chaining tools; run against staging with real tool bindings.',
        'Least-privilege tool scopes, tokens bound to the signed-in user, amount and rate limits, human approval for write actions and a kill switch.',
        'Tool-call audit log, approval records, scope review sign-offs.',
        'red', 'AML.T0053'],
    ['LLM07', 'System Prompt Leakage',
        'The system prompt reveals rules, keys or logic that an attacker then uses.',
        'Extraction prompts in every suite, a canary string in the system prompt watched for in output, and a review that no secret or authorisation rule lives in prompt text.',
        'Rules enforced outside the model, no secrets in prompts, canary detection in the output filter.',
        'Canary alert log, prompt review record.',
        'ci', 'AML.T0056'],
    ['LLM08', 'Vector and Embedding Weaknesses',
        'Weak access control or poisoned documents in the vector store, so retrieval leaks or misleads.',
        'Cross-tenant retrieval probes, poisoned-document insertion, and a review of permission drift between source systems and the index.',
        'Tenant and document permissions enforced inside the store, synced from the source of record, with ingestion validation.',
        'Retrieval permission test results per release, ingestion validation log.',
        'ci', 'AML.T0070'],
    ['LLM09', 'Misinformation',
        'A confident wrong answer, or a fabricated citation, is acted on by a person.',
        'Faithfulness and groundedness evals against a golden set, citation verification, and adversarial prompts that invite the model to invent.',
        'Grounded retrieval with citations, confidence thresholds, human review for high-stakes answers, and clear limits in the interface.',
        'Eval scores per release, review queue log.',
        'eval', 'AML.T0048'],
    ['LLM10', 'Unbounded Consumption',
        'Oversized inputs, loops or floods of requests run up cost or take the service down.',
        'Abuse tests with oversized prompts, recursion through tools, parallel sessions and replayed requests.',
        'Per-user token budgets, rate limits, timeouts, maximum output length and cost alerts on the provider account.',
        'Budget alert log, cost per request dashboard.',
        'load', 'AML.T0034'],
];
$tsco_by = [];
foreach ($tsco_rows as $tsco_r) { $tsco_by[$tsco_r[6]] = ($tsco_by[$tsco_r[6]] ?? 0) + 1; }
?>
<section class="band band--alt tsc-owasp" id="owasp" aria-labelledby="owasp-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-04</b><span>AI risk register</span></p>
        <h2 class="h2" id="owasp-t"><span class="g">The OWASP Top 10 for LLM Applications,</span> mapped to a test, a control and evidence.</h2>
      </div>
      <div>
        <p class="lead">The 2025 list is the shared language between your engineers, our red team and your auditor. Every risk on it gets three things: a way we test for it, a control we build, and the evidence that proves the control held.</p>
      </div>
    </div>

    <div class="tsc-ow">
      <aside class="tsc-ow__side" data-rv>
        <div class="tsc-ow__badge">
          <?= xt_badge('owasp-llm', ['detail' => true]) ?>
        </div>
        <div class="tsc-ow__cov">
          <p class="tsc-ow__k">Coverage</p>
          <p class="tsc-ow__n"><b data-ow-count><?= count($tsco_rows) ?></b><span>of <?= count($tsco_rows) ?> risks with a test, a control and evidence</span></p>
          <ul class="tsc-ow__legend" role="list" aria-label="What each risk carries"><li><i></i>Test</li><li><i></i>Control</li><li><i></i>Evidence</li></ul>
          <ul class="tsc-ow__modes" role="list" aria-label="How the tests run">
            <?php $tsco_i = 0; foreach ($tsco_modes as $tsco_mk => $tsco_mn): $tsco_c = $tsco_by[$tsco_mk] ?? 0; ?>
              <li style="--i:<?= $tsco_i++ ?>"><span><?= e($tsco_mn) ?></span><b><?= $tsco_c ?></b><span class="tsc-ow__bar" aria-hidden="true"><i style="--w:<?= round($tsco_c / count($tsco_rows) * 100) ?>%"></i></span></li>
            <?php endforeach; ?>
          </ul>
          <p class="tsc-ow__sel"><span>Open now</span><b data-ow-sel>LLM01 · MITRE ATLAS AML.T0051</b></p>
        </div>
        <p class="bdh-sr">Illustrative coverage card. Each risk in the list below carries three filled pips, one for the test, one for the control and one for the evidence; a bar chart above shows how many of the ten risks are covered by each kind of test. The three pips are written out as How we test, Control we build and Evidence in the pack inside every risk, so nothing is carried by the pips alone.</p>
      </aside>

      <ol class="tsc-ow__list" data-acc data-rv-s data-rv-step="55">
        <?php foreach ($tsco_rows as $tsco_i => $tsco_r): ?>
          <li class="tsc-ow__row" style="--i:<?= $tsco_i ?>">
            <h3 class="tsc-ow__q">
              <button type="button" data-acc-b aria-expanded="<?= $tsco_i === 0 ? 'true' : 'false' ?>" aria-controls="owasp-p<?= $tsco_i ?>" id="owasp-b<?= $tsco_i ?>" data-ow-label="<?= e($tsco_r[0]) ?> · MITRE ATLAS <?= e($tsco_r[7]) ?>">
                <span class="tsc-kbd tsc-ow__id"><?= e($tsco_r[0]) ?></span>
                <span class="tsc-ow__name"><?= e($tsco_r[1]) ?></span>
                <span class="tsc-ow__risk"><?= e($tsco_r[2]) ?></span>
                <span class="tsc-ow__pips" aria-hidden="true"><i></i><i></i><i></i></span>
                <span class="tsc-ow__mode"><?= e($tsco_modes[$tsco_r[6]]) ?></span>
                <span class="tsc-ow__pm" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="tsc-ow__p" id="owasp-p<?= $tsco_i ?>" role="region" aria-labelledby="owasp-b<?= $tsco_i ?>" data-acc-p>
              <div class="tsc-ow__grid">
                <div class="tsc-ow__cell"><p class="tsc-ow__pk"><i class="tsc-ow__pip" aria-hidden="true"></i>How we test</p><p class="tsc-ow__pd"><?= e($tsco_r[3]) ?></p></div>
                <div class="tsc-ow__cell"><p class="tsc-ow__pk"><i class="tsc-ow__pip" aria-hidden="true"></i>Control we build</p><p class="tsc-ow__pd"><?= e($tsco_r[4]) ?></p></div>
                <div class="tsc-ow__cell"><p class="tsc-ow__pk"><i class="tsc-ow__pip" aria-hidden="true"></i>Evidence in the pack</p><p class="tsc-ow__pd"><?= e($tsco_r[5]) ?></p></div>
              </div>
              <p class="tsc-ow__foot"><span class="tsc-kbd"><?= e($tsco_r[7]) ?></span><span>MITRE ATLAS technique the test cases are tagged with</span><span class="tsc-ow__ran">Last run <time>every merge</time> · <?= e($tsco_modes[$tsco_r[6]]) ?></span></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <p class="tsc-note"><span class="tsc-ill">Illustrative</span><span>Suites run from our own case library plus open tooling such as Garak, PyRIT and promptfoo. Results ship as part of the audit evidence pack, mapped to ISO/IEC 42001 and the NIST AI RMF.</span></p>
  </div>
</section>
