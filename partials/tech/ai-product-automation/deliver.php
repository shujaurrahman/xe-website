<?php /* DRAFT COPY — review before launch */
/* 04.10 Deliver — what you get, as the handover pull request your team reviews and merges. Left: the PR,
   one expandable diff per deliverable (native <details>: folder, deliverable, format tags, file count, then
   the description and an excerpt of its key file as added lines). Right: the CI checks that must pass before
   merge, the reviewers and the ownership terms. deliver.js ticks the checks once on entry and replays a
   diff's lines when it opens; there is no auto-rotation. Excerpts are illustrative; model names are
   placeholders on purpose. */
$tapd_items = [   // [folder, deliverable, format tags, icon, one line, key file, language, lines, files in the folder]
    ['app/', 'The AI feature, in production', ['Source', 'TypeScript', 'Python'], 'code',
     'API, streaming UI with citations and the handover path, deployed to your cloud.',
     'app/answer/answer.ts', 'ts', [
        '// Answer with sources, or hand over. Never an uncited guess.',
        'export async function answer(q: Question, user: User) {',
        '  const found = await retrieve(q, { acl: user.groups, topK: 20 });',
        '  const top = await rerank(q, found, { keep: 3, minScore: 0.5 });',
        '  if (top.length === 0) return handover(q, "no-sources");',
        '',
        '  const draft = await generate(q, top, { model: route(q) });',
        '  const checked = enforceCitations(draft, top);',
        '  if (checked.confidence < 0.7) return handover(q, "low-confidence", checked);',
        '',
        '  trace.log({ q: redact(q), sources: top.map((s) => s.id), cost: draft.cost });',
        '  return checked;',
        '}',
     ], 64],
    ['pipelines/ingest/', 'Ingestion pipelines & index', ['Code', 'Airflow DAG', 'Vector index'], 'pipeline',
     'Parse, chunk, embed and index, nightly and on change, with permissions carried through.',
     'pipelines/ingest/dag.py', 'py', [
        '# Nightly: parse, chunk, embed and index new or changed documents.',
        '@dag(schedule="0 2 * * *", start_date=datetime(2026, 1, 1), catchup=False)',
        'def ingest_knowledge_base():',
        '    docs = changed_since_last_run(sources=["sharepoint", "confluence", "drive"])',
        '    parsed = parse(docs, keep_tables=True, ocr="scanned-only")',
        '    chunks = semantic_chunk(parsed, min_tokens=300, max_tokens=500, overlap=80)',
        '    tagged = attach_meta(chunks, fields=["source", "version", "owner", "acl"])',
        '    index.upsert(embed(tagged), keyword_index=True)',
        '    retire(superseded(docs))  # old versions leave the index, not only the UI',
        '',
        'ingest_knowledge_base()',
     ], 18],
    ['config/', 'Prompt & model registry', ['YAML', 'Versioned'], 'git-branch',
     'Models, routes, retrieval settings and prompts under version control. Every change is a release.',
     'config/assistant.yaml', 'yaml', [
        '# Every change here is a release: it runs the eval gates in CI.',
        'version: 24',
        'router:',
        '  classify: small-model        # intent, language, PII, routing',
        '  answer: large-model          # drafting and reasoning',
        '  fallback: open-weights-70b   # served with vLLM in your VPC',
        'retrieval:',
        '  search: hybrid               # BM25 + vector',
        '  candidates: 20',
        '  rerank: { model: cross-encoder, keep: 3, min_score: 0.50 }',
        'prompts:',
        '  system: prompts/assistant.v24.md',
        '  handover: prompts/handover.v7.md',
     ], 9],
    ['evals/', 'Evaluation suite', ['Golden set', 'Scorers', 'CI gate'], 'eval',
     'The golden set your experts signed, the calibrated judge and the thresholds that block a release.',
     'evals/gates.yaml', 'yaml', [
        'golden_set: evals/golden-set.jsonl   # 400 questions · owner: Support ops',
        'judge: calibrated-judge-v3          # agreement with expert labels: 0.91',
        'gates:',
        '  faithfulness: { min: 0.90 }',
        '  answer_relevance: { min: 0.85 }',
        '  context_precision: { min: 0.80 }',
        '  context_recall: { min: 0.80 }',
        '  red_team: { successful_attacks: 0 }   # OWASP LLM01, 02, 05, 07, 09',
        '  pii_leakage: { found: 0 }',
        '  p95_latency_s: { max: 2.5 }',
        '  cost_per_answer_inr: { max: 0.12 }',
        'on_fail: block_release',
     ], 12],
    ['guardrails/', 'Guardrails & review queues', ['Policy', 'Workflow'], 'shield',
     'Input and output checks, redaction and the rules for when a person takes over.',
     'guardrails/policy.yaml', 'yaml', [
        'input:',
        '  prompt_injection: { detector: classifier, action: refuse_and_log }   # LLM01',
        '  pii: { detect: [card, aadhaar, phone, email], action: redact_before_log }',
        'output:',
        '  citations: required          # unsupported sentences are removed',
        '  schema: answer.schema.json   # tool calls and JSON validated',
        '  render: plain_text           # no raw HTML or links from the model (LLM05)',
        'handover:',
        '  when: [confidence_below_0.70, sources_conflict, topic_in_refunds_or_legal]',
        '  queue: support-tier-2',
        '  attach: [transcript, intent, tool_calls, sources, suggested_reply]',
     ], 7],
    ['workflows/', 'Automation workflows', ['Temporal', 'n8n'], 'workflow',
     'Durable, idempotent workflows with retries, approval gates and a dead-letter queue.',
     'workflows/invoice_to_erp.py', 'py', [
        '# Retries after 2 s, 4 s and 8 s; a fourth failure goes to the dead-letter queue.',
        'RETRY = RetryPolicy(initial_interval=timedelta(seconds=2), backoff_coefficient=2.0, maximum_attempts=4)',
        '',
        '@workflow.defn',
        'class InvoiceToERP:',
        '    def __init__(self) -> None:',
        '        self.decision: str | None = None',
        '',
        '    @workflow.signal',
        '    def decide(self, decision: str) -> None:   # "approve" or "reject", from the finance lead',
        '        self.decision = decision',
        '',
        '    @workflow.run',
        '    async def run(self, email_id: str) -> str:',
        '        doc = await workflow.execute_activity(extract_invoice, email_id, start_to_close_timeout=timedelta(seconds=60), retry_policy=RETRY)',
        '        await workflow.execute_activity(validate_against_erp, doc, start_to_close_timeout=timedelta(seconds=30), retry_policy=RETRY)',
        '        if doc.total > APPROVAL_LIMIT:',
        '            await workflow.wait_condition(lambda: self.decision is not None)',
        '            if self.decision == "reject":',
        '                return await workflow.execute_activity(notify_rejected, doc, start_to_close_timeout=timedelta(seconds=30))',
        '        return await workflow.execute_activity(post_to_erp, doc, start_to_close_timeout=timedelta(seconds=30), retry_policy=RETRY)',
     ], 23],
    ['dashboards/', 'Quality, latency & cost dashboards', ['Grafana', 'Langfuse'], 'dashboard',
     'The numbers the feature is judged on, with alerts wired to an owner.',
     'dashboards/assistant.json', 'json', [
        '{',
        '  "title": "Knowledge assistant · quality, latency, cost",',
        '  "panels": [',
        '    { "title": "Groundedness, daily sample", "threshold": 0.90 },',
        '    { "title": "Handover rate by intent", "unit": "percent" },',
        '    { "title": "p95 latency by model route", "unit": "s" },',
        '    { "title": "Cost per answer", "unit": "INR" },',
        '    { "title": "Top unanswered questions", "type": "table" }',
        '  ],',
        '  "alerts": ["groundedness_7d < 0.90", "cost_per_answer > budget"]',
        '}',
     ], 6],
    ['docs/runbook.md', 'Runbooks', ['Markdown', 'On-call'], 'wrench',
     'What to do when a number moves, written so your team can act without us.',
     'docs/runbook.md', 'md', [
        '# Runbook · knowledge assistant',
        '',
        '## Groundedness below 0.90 for a day',
        '1. Open the flagged answers in Langfuse and group them by source.',
        '2. Check index freshness: a failed nightly ingest is the usual cause.',
        '3. Re-run ingestion for that source, then re-score the sample.',
        '4. If it persists, roll config back to the last good version.',
        '',
        '## Provider outage or rate limits',
        'Traffic fails over to the fallback route. Answers stay cited.',
     ], 1],
    ['docs/model-card.md', 'Model cards', ['Markdown', 'Per release'], 'doc',
     'Intended use, limits, evaluation and owner for each release, aligned with ISO/IEC 42001 documentation.',
     'docs/model-card.md', 'card', [
        '# Model card · assistant v24',
        '',
        'Intended use    Staff questions answered from approved policy documents',
        'Out of scope    Legal or medical advice; decisions about individuals',
        'Models          small-model (routing) · large-model (answers)',
        'Data            1,284 documents, permission-filtered at query time',
        'Evaluation      Golden set of 400 · faithfulness 0.93 · relevance 0.94',
        'Known limits    Tables in scanned PDFs; questions spanning 5+ documents',
        'Owner           Head of Support operations · reviewed each release',
     ], 1],
];

$tapd_commits = [   // last commit shown in the editor footer, one per item (illustrative)
    ['e41c09a', 'feat: hand over when nothing passes the reranker', '2 days ago'],
    ['7b2d5f0', 'fix: retire superseded versions from the index', 'last week'],
    ['c90a3e1', 'chore: v24 routes answers to large-model, open-weights fallback', 'yesterday'],
    ['3f8b6d2', 'test: add 40 billing questions to the golden set', 'yesterday'],
    ['a17e4c8', 'feat: redact Aadhaar numbers before logging', '3 days ago'],
    ['5d0c9b7', 'fix: idempotency key on the ERP post step', 'last week'],
    ['b62f1a4', 'feat: alert when 7-day groundedness is under 0.90', '4 days ago'],
    ['91e7c3d', 'docs: provider outage and rate-limit steps', 'last week'],
    ['0c4a8f6', 'docs: model card for assistant v24', 'yesterday'],
];

$tapd_checks = [   // [check, detail, duration] — CI on the handover pull request (illustrative)
    ['build · type-check · lint', 'TypeScript and Python, strict', '1 m 12 s'],
    ['unit and integration tests', '312 passed', '3 m 40 s'],
    ['evals / golden set', '400 questions · faithfulness 0.93 ≥ 0.90', '6 m 05 s'],
    ['evals / red team', '0 of 181 attacks succeeded', '2 m 18 s'],
    ['pii leakage', 'none in outputs, traces or eval sets', '48 s'],
    ['infra plan', 'Terraform · no drift in your cloud account', '36 s'],
];
$tapd_files = array_sum(array_map(fn ($tapd_x) => $tapd_x[8], $tapd_items));

/* minimal highlighter: escapes first, then wraps comments, keys, strings and keywords in spans */
$tapd_hl = function (string $line, string $lang): string {
    $s = e($line);
    if ($s === '') return '&#8203;';
    $cm = '';
    if (in_array($lang, ['py', 'yaml'], true) && preg_match('/^(.*?)(\s#\s.*|^#\s.*)$/u', $s, $m)) { $s = $m[1]; $cm = $m[2]; }
    if ($lang === 'ts' && preg_match('/^(.*?)(\/\/.*)$/u', $s, $m)) { $s = $m[1]; $cm = $m[2]; }
    if ($lang === 'md' || $lang === 'card') {
        if (preg_match('/^#{1,3}\s/u', $s)) return '<span class="h">' . $s . '</span>';
        if ($lang === 'card' && preg_match('/^(\S.*?)(\s{2,})(.*)$/u', $s, $m)) return '<span class="k">' . $m[1] . '</span>' . $m[2] . $m[3];
        if (preg_match('/^(\d+\.)(.*)$/u', $s, $m)) return '<span class="n">' . $m[1] . '</span>' . $m[2];
        return $s;
    }
    /* keywords first, while the line holds no markup of ours */
    if ($lang === 'ts') $s = preg_replace('/\b(export|async|function|const|await|return|if)\b/u', '<b class="w">$1</b>', $s);
    if ($lang === 'py') $s = preg_replace('/\b(def|class|async|await|return|if|is|not|None|lambda)\b/u', '<b class="w">$1</b>', $s);
    $s = preg_replace('/&quot;(.*?)&quot;/u', '<span class="s">&quot;$1&quot;</span>', $s);
    if ($lang === 'yaml') $s = preg_replace('/^(\s*)([\w\.\-]+):/u', '$1<span class="k">$2</span>:', $s);
    if ($lang === 'json') $s = preg_replace('/<span class="s">(&quot;[\w ]+&quot;)<\/span>:/u', '<span class="k">$1</span>:', $s);
    if ($lang === 'py') $s = preg_replace('/^(\s*)(@[\w\.]+)/u', '$1<span class="d">$2</span>', $s);
    return $s . ($cm !== '' ? '<span class="c">' . $cm . '</span>' : '');
};
?>
<section class="band tap-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.10</span><span>What you get</span><span class="tap-eb__p">/deliver</span></p>
        <h2 class="h2" id="deliver-t"><span class="g">What you get:</span> a repository your team can run without us.</h2>
      </div>
      <div>
        <p class="lead">Nothing about the feature lives in a black box of ours. Code, pipelines, prompts, evals, guardrails, workflows, dashboards and the documents that explain them arrive as a pull request your team reviews and merges. Open any file.</p>
      </div>
    </div>

    <div class="tap-pr" data-rv>
      <header class="tap-pr__head">
        <p class="tap-pr__state"><span class="tap-pr__badge"><?= xt_icon('git-branch', ['size' => 14, 'mono' => true]) ?>Open · ready to merge</span><code>handover/v24 → main</code><span class="tap-pr__repo">your-company/ai-assistant</span></p>
        <h3 class="tap-pr__title">Handover #1: assistant v24 and accounts-payable automation</h3>
        <p class="tap-pr__stats"><span><b><?= count($tapd_items) ?></b> deliverables</span><span><b><?= $tapd_files ?></b> files changed</span><span><b>6 of 6</b> checks passed</span><span><b>2 of 2</b> approvals from your team</span></p>
      </header>

      <ol class="tap-pr__files" role="list">
        <?php foreach ($tapd_items as $tapd_i => $tapd_x): ?>
          <li class="tap-pr__file">
            <details class="tap-pr__d" data-pr-file<?= $tapd_i === 0 ? ' open' : '' ?>>
              <summary class="tap-pr__sum">
                <span class="tap-pr__chev" aria-hidden="true"></span>
                <span class="tap-pr__ico" aria-hidden="true"><?= xt_icon($tapd_x[3], ['size' => 18]) ?></span>
                <span class="tap-pr__txt"><code class="tap-pr__path"><?= e($tapd_x[0]) ?></code><span class="tap-pr__name"><?= e($tapd_x[1]) ?></span></span>
                <span class="tap-pr__fmt"><?= e($tapd_x[2][0]) ?></span>
                <span class="tap-pr__add"><?= $tapd_x[8] === 1 ? '1 file' : $tapd_x[8] . ' files' ?></span>
              </summary>
              <div class="tap-pr__body">
                <p class="tap-pr__desc"><?= e($tapd_x[4]) ?><span class="tap-pr__tags"><?php foreach ($tapd_x[2] as $tapd_f): ?><span class="bdh-tag"><?= e($tapd_f) ?></span><?php endforeach; ?></span></p>
                <div class="tap-pr__diff tap-on-ink">
                  <p class="tap-pr__dh"><code><?= e($tapd_x[5]) ?></code><span>+<?= count(array_filter($tapd_x[7], fn ($tapd_l) => $tapd_l !== '')) ?> · excerpt</span><span class="tap-pr__lang"><?= e(strtoupper($tapd_x[6] === 'card' ? 'md' : $tapd_x[6])) ?></span></p>
                  <ol class="tap-pr__code" aria-label="<?= e($tapd_x[5]) ?>, excerpt of added lines">
                    <?php foreach ($tapd_x[7] as $tapd_l => $tapd_line): ?>
                      <li style="--l:<?= $tapd_l ?>"><code><?= $tapd_hl($tapd_line, $tapd_x[6]) ?></code></li>
                    <?php endforeach; ?>
                  </ol>
                  <p class="tap-pr__cm"><code><?= e($tapd_commits[$tapd_i][0]) ?></code><span><?= e($tapd_commits[$tapd_i][1]) ?></span><span class="tap-pr__when"><?= e($tapd_commits[$tapd_i][2]) ?></span></p>
                </div>
              </div>
            </details>
          </li>
        <?php endforeach; ?>
      </ol>

      <aside class="tap-pr__side" aria-labelledby="pr-checks-t">
        <div class="tap-pr__box">
          <p class="tap-pr__bk" id="pr-checks-t">Checks <span data-pr-sum>6 of 6 passed</span></p>
          <ol class="tap-pr__checks" role="list" data-pr-checks>
            <?php foreach ($tapd_checks as $tapd_c): ?>
              <li class="is-pass"><span class="tap-pr__cs" aria-hidden="true"><i></i></span><span class="tap-pr__cn"><?= e($tapd_c[0]) ?><small><?= e($tapd_c[1]) ?></small></span><span class="tap-pr__ct"><?= e($tapd_c[2]) ?></span></li>
            <?php endforeach; ?>
          </ol>
        </div>
        <div class="tap-pr__box">
          <p class="tap-pr__bk">Reviewers</p>
          <ul class="tap-pr__rev" role="list">
            <li><span class="tap-pr__av" aria-hidden="true">EL</span><span>Engineering lead, your team<small>approved · 14 comments resolved</small></span></li>
            <li><span class="tap-pr__av" aria-hidden="true">PO</span><span>Product owner, your team<small>approved · model card read</small></span></li>
          </ul>
        </div>
        <!-- PLACEHOLDER: confirm handover and ownership terms before launch -->
        <p class="tap-pr__own"><?= xt_icon('key', ['size' => 16]) ?><span>In your repository and your cloud account from the first week. Your team reviews every pull request; this one is the formal handover.</span></p>
      </aside>
    </div>
  </div>
</section>
