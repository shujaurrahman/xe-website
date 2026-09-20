<?php /* DRAFT COPY — review before launch */
/* Types — six audits, one method. A vertical tablist on the left with a photograph under it; the
   pane on the right carries what we examine, the checks that actually run, the frameworks the
   ratings map to, the instruments used, how long it takes and what you get.
   types.js wires the ARIA tablist and re-runs the checklist tick on every pane change. */
$taa_ty = [
    [
        'k' => 'technical', 'icon' => 'gauge',
        'n' => 'Technical & performance', 's' => 'Technical',
        'lead' => 'How the system is built, how fast it is for real users and how safely your team can change it.',
        'exam' => [
            'Architecture, service boundaries and coupling, against what the roadmap needs next',
            'Code quality, test coverage, dependency age and licence exposure',
            'Core Web Vitals from field data (CrUX) alongside lab traces',
            'Back-end p95 and p99 latency, database plans and N+1 queries',
            'Delivery: DORA metrics, pipeline stages, rollback path, environment parity',
        ],
        'checks' => [
            'Field LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1 at the 75th percentile',
            'Load test to 3× peak traffic; find the first component to fail',
            'Dependency tree scanned for known CVEs and abandoned packages',
            'Change failure rate and time to restore from the last 90 days of releases',
        ],
        'std' => ['cwv', 'dora-metrics', 'wcag22'],
        'stack' => ['lighthouse', 'pagespeedinsights', 'k6', 'sonarqubecloud', 'datadog'],
        'dur' => '2–4 weeks', 'out' => 'Architecture map, performance budget, ranked remediation backlog',
    ],
    [
        'k' => 'seo', 'icon' => 'search',
        'n' => 'SEO & AI visibility', 's' => 'SEO & AI',
        'lead' => 'Whether search engines can reach you, whether they rank you, and whether answer engines cite you.',
        'exam' => [
            'Crawl budget, indexation, canonical logic, redirect chains and log-file evidence',
            'Structured data validity and entity coverage against schema.org types',
            'Content depth and topical gaps versus the queries that convert',
            'Citation share in ChatGPT, Perplexity and AI Overviews for your key prompts',
            'Internal linking, orphan pages and rendering under JavaScript',
        ],
        'checks' => [
            'Full crawl reconciled against Search Console coverage and server logs',
            'Structured data validated; invalid or ignored types listed with the fix',
            '40 prompt tests across answer engines, recorded with date and model',
            'Rendered-HTML diff: what a crawler sees versus what a user sees',
        ],
        'std' => ['cwv', 'wcag22'],
        'stack' => ['googlesearchconsole', 'semrush', 'googleanalytics', 'schemaorg', 'perplexity'],
        'dur' => '2–3 weeks', 'out' => 'Indexation report, entity and content gap list, citation baseline',
    ],
    [
        'k' => 'security', 'icon' => 'shield',
        'n' => 'Security & compliance', 's' => 'Security',
        'lead' => 'What an attacker can reach, what they could do with it, and where you sit against the frameworks you are held to.',
        'exam' => [
            'External attack surface: exposed hosts, ports, subdomains and forgotten environments',
            'Application testing against the OWASP Top 10 and ASVS verification levels',
            'Cloud posture against CIS Benchmarks — IAM, storage, network and logging',
            'Identity: MFA coverage, privileged access, joiner-mover-leaver, session handling',
            'Secrets in code and CI, dependency and container vulnerabilities, SBOM coverage',
        ],
        'checks' => [
            'Authenticated and unauthenticated testing, under signed rules of engagement',
            'Findings rated with CVSS v3.1 and re-rated for your environment',
            'Container images scanned; base image age and critical CVEs reported',
            'Gap analysis against ISO/IEC 27001 Annex A or SOC 2 Trust Services Criteria',
        ],
        'std' => ['owasp-asvs', 'owasp-top10', 'cis', 'iso27001', 'soc2'],
        'stack' => ['burpsuite', 'owasp', 'trivy', 'snyk', 'vault'],
        'dur' => '2–4 weeks', 'out' => 'Vulnerability register with CVSS, posture gaps, remediation plan',
    ],
    [
        'k' => 'data', 'icon' => 'database',
        'n' => 'Data & analytics', 's' => 'Data',
        'lead' => 'Whether the numbers you decide on are right, where they come from, and who is allowed to see them.',
        'exam' => [
            'Data quality: completeness, uniqueness, validity, timeliness, referential integrity',
            'Lineage from source system to dashboard, and the transformations in between',
            'Tracking accuracy: event loss, duplicate events, consent and server-side coverage',
            'Governance: ownership, catalogue, retention, access reviews, PII classification',
            'Warehouse cost and query efficiency — what the slow, expensive models are',
        ],
        'checks' => [
            'Profiling across every core table: null rates, duplicates, outliers, freshness',
            'Front-end events reconciled against server-side truth for one full month',
            'Consent flows tested against GDPR and the DPDP Act 2023 requirements',
            'Critical metrics traced end to end and recomputed independently',
        ],
        'std' => ['gdpr', 'dpdp', 'iso27001'],
        'stack' => ['dbt', 'postgresql', 'python', 'jupyter', 'googleanalytics'],
        'dur' => '2–4 weeks', 'out' => 'Quality scorecard, lineage map, tracking fix list, governance gaps',
    ],
    [
        'k' => 'ai', 'icon' => 'brain',
        'n' => 'AI readiness', 's' => 'AI readiness',
        'lead' => 'Whether your data, platform, governance and people can carry an AI programme — before you fund one.',
        'exam' => [
            'Data readiness: coverage, quality, labelling, rights to use and refresh cadence',
            'Infrastructure: inference path, vector storage, cost per request, latency budget',
            'Governance: model inventory, approval gates, evaluation practice, audit logging',
            'Skills and operating model: who owns models, who reviews output, who is on call',
            'Use-case fit: value, feasibility and risk scored for the candidates on the list',
        ],
        'checks' => [
            'Retrieval test on your own corpus: faithfulness, groundedness and answer relevance',
            'Duplicate and contradiction rate across the knowledge base',
            'Control mapping against the NIST AI RMF functions and ISO/IEC 42001 clauses',
            'Prompt-injection probes on any existing assistant (OWASP LLM01)',
        ],
        'std' => ['nist-ai-rmf', 'iso42001', 'owasp-llm', 'eu-ai-act'],
        'stack' => ['python', 'huggingface', 'mlflow', 'pgvector', 'openai'],
        'dur' => '3–4 weeks', 'out' => 'Readiness score by dimension, prerequisite list, ranked use cases',
    ],
    [
        'k' => 'carbon', 'icon' => 'leaf',
        'n' => 'Carbon & efficiency', 's' => 'Carbon',
        'lead' => 'What the system wastes — in cloud spend and in emissions. The two almost always move together.',
        'exam' => [
            'Software Carbon Intensity baseline: SCI = ((E × I) + M) per functional unit R',
            'Idle and oversized compute, unattached storage, cross-region transfer',
            'Page weight, image payload, third-party scripts and cache hit ratio',
            'Batch scheduling against grid carbon intensity where the region allows it',
            'Model choice and inference cost for any AI workload already running',
        ],
        'checks' => [
            'Cloud bill reconciled to workloads; waste separated from useful spend',
            'Energy estimated per request, then converted with regional grid intensity',
            'Transferred bytes per visit measured on the ten highest-traffic pages',
            'Right-sizing modelled against p95 utilisation, not peak',
        ],
        'std' => ['sci', 'iso14001'],
        'stack' => ['amazonwebservices', 'googlecloud', 'microsoftazure', 'prometheus', 'grafana'],
        'dur' => '1–2 weeks', 'out' => 'SCI baseline, waste register, efficiency backlog with cost and carbon',
    ],
];
?>
<section class="band band--alt taa-types" id="types" aria-labelledby="types-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">01</span><span>Audit types</span></p>
        <h2 class="h2" id="types-t"><span class="g">Six audits,</span> one method.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Each audit looks at a different surface. All six use the same discipline: automated collection for breadth, senior review for depth, evidence attached to every finding, a rating you can challenge.</p>
      </div>
    </header>

    <div class="taa-ty" data-taa-types>
      <div class="taa-ty__rail">
        <div class="bdh-tabs taa-ty__tabs" role="tablist" aria-label="Audit types" aria-orientation="vertical" data-taa-tabs>
          <?php foreach ($taa_ty as $taa_tyi => $taa_t): ?>
            <button type="button" role="tab" id="types-tab-<?= e($taa_t['k']) ?>" aria-controls="types-pane-<?= e($taa_t['k']) ?>"
                    aria-selected="<?= $taa_tyi === 0 ? 'true' : 'false' ?>" tabindex="<?= $taa_tyi === 0 ? '0' : '-1' ?>">
              <?= xt_icon($taa_t['icon'], ['size' => 18]) ?>
              <span class="taa-ty__tl"><?= e($taa_t['n']) ?></span>
              <span class="taa-ty__ts"><?= e($taa_t['s']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r43 taa-ty__photo">
          <img src="<?= xe_url('assets/imgs/tech/audits-assessments/types-code-review.jpg') ?>" width="1200" height="900"
               alt="Two monitors of source code on a dark desk, lit keyboards in front of them" loading="lazy" decoding="async" style="object-position:50% 45%">
        </figure>
        <p class="taa-cap">Collection runs automated and unattended. Verification is a person reading the code, the logs and the configuration by hand.</p>
      </div>

      <div class="bdh-panes taa-ty__panes">
        <?php foreach ($taa_ty as $taa_tyi => $taa_t): ?>
          <div class="bdh-pane taa-ty__pane<?= $taa_tyi === 0 ? ' is-on' : '' ?>" id="types-pane-<?= e($taa_t['k']) ?>"
               role="tabpanel" aria-labelledby="types-tab-<?= e($taa_t['k']) ?>" tabindex="0">
            <div class="taa-ty__top">
              <h3 class="bdh-t bdh-t--l"><?= e($taa_t['n']) ?></h3>
              <p class="bdh-d taa-ty__lead"><?= e($taa_t['lead']) ?></p>
            </div>

            <div class="taa-ty__cols">
              <div class="taa-ty__col">
                <p class="taa-lbl">What we examine</p>
                <ul class="bdh-bullets taa-ty__exam" role="list">
                  <?php foreach ($taa_t['exam'] as $taa_te): ?><li><?= e($taa_te) ?></li><?php endforeach; ?>
                </ul>
              </div>
              <div class="taa-ty__col">
                <p class="taa-lbl">Checks that actually run</p>
                <ul class="taa-ty__checks" role="list">
                  <?php foreach ($taa_t['checks'] as $taa_tci => $taa_tc): ?>
                    <li style="--i:<?= (int) $taa_tci ?>">
                      <span class="taa-ty__tick" aria-hidden="true"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 8.4l3 3 6-6.8"/></svg></span>
                      <span><?= e($taa_tc) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>

            <div class="taa-ty__foot">
              <div class="taa-ty__fb">
                <p class="taa-lbl">Rated against</p>
                <ul class="xt-badges taa-ty__badges" role="list">
                  <?php foreach ($taa_t['std'] as $taa_ts) { echo xt_badge($taa_ts, ['variant' => 'chip', 'tag' => 'li']); } ?>
                </ul>
              </div>
              <div class="taa-ty__fb">
                <p class="taa-lbl">Instruments</p>
                <?= xt_stack($taa_t['stack'], ['variant' => 'logos', 'size' => 20, 'label' => 'Instruments used in the ' . $taa_t['n'] . ' audit']) ?>
              </div>
              <!-- PLACEHOLDER: confirm typical durations before launch -->
              <dl class="taa-ty__fm">
                <div><dt>Typical length</dt><dd><?= e($taa_t['dur']) ?></dd></div>
                <div><dt>Output</dt><dd><?= e($taa_t['out']) ?></dd></div>
              </dl>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>
