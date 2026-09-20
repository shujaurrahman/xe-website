<?php /* DRAFT COPY — review before launch */
/* Instruments — the kit each audit is run with, as six dials. The needle shows roughly how much of
   that audit a tool can do unattended; the rest is a person reading code, logs and configuration.
   Each dial also separates what is measured (observed directly) from what is estimated (modelled),
   because the difference matters when a number ends up in a board pack.
   No JS file: the dials render at their final angle and the settle animation is an override armed by
   [data-bdh-in], so without JS — and under reduced motion — the finished state is what shows. */

/* k · icon · name · automated share % · lead · measured · estimated · logo slugs · other instruments */
$taa_in_dials = [
    ['technical', 'gauge', 'Technical & performance', 65,
     'Lab and field instrumentation, load generation and static analysis, read by an engineer who knows what a flame graph means.',
     ['Field Core Web Vitals at the 75th percentile from CrUX', 'p95 and p99 server latency, and the query plans behind them', 'Test coverage, dependency age and known CVEs', 'Change failure rate and time to restore over 90 days'],
     ['Engineering effort to remediate, with a confidence', 'Revenue effect of a faster page, from conversion elasticity'],
     ['lighthouse', 'pagespeedinsights', 'k6', 'sonarqubecloud', 'datadog'],
     'WebPageTest · Chrome UX Report · Playwright traces · flame graphs'],

    ['seo', 'search', 'SEO & AI visibility', 70,
     'Crawlers, log files and the search consoles, plus a dated panel of prompts run against the answer engines.',
     ['Crawl and index status reconciled against server logs', 'Structured data validity per template', 'Rendered HTML versus source HTML', 'Citation share across a fixed prompt panel, with model and date'],
     ['Traffic recovered from an indexation fix', 'Click-through gain from rich results'],
     ['googlesearchconsole', 'semrush', 'schemaorg', 'googleanalytics', 'perplexity'],
     'Screaming Frog · Chrome UX Report · server log analysis'],

    ['security', 'shield', 'Security & compliance', 55,
     'Scanners map the surface. A tester decides what is actually reachable, chainable and worth your attention.',
     ['Hosts, ports, subdomains and forgotten environments reachable from outside', 'Known CVEs present in code, containers and base images', 'MFA coverage, privileged access and audit logging configuration', 'Cloud settings against CIS Benchmarks'],
     ['Likelihood of exploitation in your environment', 'Expected loss, stated as a model rather than a price'],
     ['burpsuite', 'owasp', 'trivy', 'snyk', 'okta'],
     'OWASP ZAP · Nmap · Prowler · SBOM tooling'],

    ['data', 'database', 'Data & analytics', 60,
     'Profiling runs over every core table; reconciliation is the part that needs a human and a month of both sides.',
     ['Null rates, duplicates, outliers and freshness per table', 'Front-end events reconciled against server-side truth', 'Lineage from source system to dashboard', 'Consent coverage and PII classification'],
     ['Hours lost to rework and manual reconciliation', 'The cost of a decision made on a wrong number'],
     ['dbt', 'postgresql', 'python', 'jupyter', 'googlebigquery'],
     'Great Expectations · warehouse query logs · consent-mode diagnostics'],

    ['ai', 'brain', 'AI readiness', 40,
     'The least automatable audit. Retrieval quality can be measured; governance, skills and use-case fit are interviews and evidence.',
     ['Retrieval faithfulness, groundedness and answer relevance on your own corpus', 'Duplicate and contradiction rate across the knowledge base', 'Model inventory, approval gates and audit logging', 'Prompt-injection probes against any existing assistant'],
     ['Readiness score per dimension against the rubric', 'Time and prerequisites before a first production use case'],
     ['python', 'huggingface', 'mlflow', 'pgvector', 'openai'],
     'Evaluation harnesses · OWASP LLM Top 10 probes · control mapping sheets'],

    ['carbon', 'leaf', 'Carbon & efficiency', 75,
     'Cloud telemetry and billing carry most of this one. SCI = ((E × I) + M) per functional unit R, with every input written down.',
     ['Energy drawn per workload from cloud telemetry', 'Bytes transferred per visit on the highest-traffic pages', 'Utilisation at p95, idle hours and unattached storage'],
     ['SCI per functional unit, using regional grid intensity', 'Embodied emissions amortised across the hardware in use'],
     ['amazonwebservices', 'googlecloud', 'microsoftazure', 'prometheus', 'grafana'],
     'Cloud Carbon Footprint · grid intensity data · billing exports'],
];
?>
<section class="band band--alt taa-in" id="instruments" aria-labelledby="instruments-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">04</span><span>Instruments</span></p>
        <h2 class="h2" id="instruments-t"><span class="g">The instruments</span> we audit with.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Tools give breadth in hours. They also produce noise, and they cannot tell you whether a finding matters to your business. Nothing a tool reports reaches the register until a person has reproduced it.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm the automated / manual split from completed audits before launch -->
    <div class="taa-in__grid" data-bdh-in data-bdh-stagger=".taa-in__dial">
      <?php foreach ($taa_in_dials as $taa_in_d): ?>
        <article class="taa-in__dial" aria-labelledby="instruments-<?= e($taa_in_d[0]) ?>-t">
          <div class="taa-in__top">
            <div class="taa-in__gauge" aria-hidden="true">
              <svg viewBox="0 0 100 56" role="presentation" focusable="false">
                <path class="taa-in__track" d="M 10 50 A 40 40 0 0 1 90 50" fill="none" pathLength="100"/>
                <path class="taa-in__arc" d="M 10 50 A 40 40 0 0 1 90 50" fill="none" pathLength="100" style="--a:<?= (int) $taa_in_d[3] ?>"/>
                <g class="taa-in__needle" style="--a:<?= (int) $taa_in_d[3] ?>">
                  <line x1="50" y1="50" x2="50" y2="17"/>
                </g>
                <circle class="taa-in__pivot" cx="50" cy="50" r="3.5"/>
              </svg>
              <span class="taa-in__read"><span class="taa-num"><?= (int) $taa_in_d[3] ?></span>%</span>
            </div>
            <div class="taa-in__id">
              <p class="taa-in__ico"><?= xt_icon($taa_in_d[1], ['size' => 18]) ?></p>
              <h3 class="taa-in__n" id="instruments-<?= e($taa_in_d[0]) ?>-t"><?= e($taa_in_d[2]) ?></h3>
              <p class="taa-in__split"><?= (int) $taa_in_d[3] ?>% automated · <?= 100 - (int) $taa_in_d[3] ?>% expert review</p>
            </div>
          </div>
          <p class="bdh-sr">A dial showing that roughly <?= (int) $taa_in_d[3] ?> per cent of the <?= e($taa_in_d[2]) ?> audit is collected automatically; the remainder is manual review.</p>

          <p class="taa-in__lead"><?= e($taa_in_d[4]) ?></p>

          <div class="taa-in__split2">
            <div class="taa-in__col">
              <p class="taa-lbl">Measured</p>
              <ul class="taa-in__list" role="list">
                <?php foreach ($taa_in_d[5] as $taa_in_m): ?><li><?= e($taa_in_m) ?></li><?php endforeach; ?>
              </ul>
            </div>
            <div class="taa-in__col taa-in__col--est">
              <p class="taa-lbl">Estimated <span class="taa-est">Modelled</span></p>
              <ul class="taa-in__list" role="list">
                <?php foreach ($taa_in_d[6] as $taa_in_e): ?><li><?= e($taa_in_e) ?></li><?php endforeach; ?>
              </ul>
            </div>
          </div>

          <div class="taa-in__kit">
            <?= xt_stack($taa_in_d[7], ['variant' => 'logos', 'size' => 20, 'label' => 'Instruments used in the ' . $taa_in_d[2] . ' audit']) ?>
            <p class="taa-in__also"><span>Also</span><?= e($taa_in_d[8]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="taa-in__strip">
      <p class="taa-in__stript">
        <span class="taa-lbl">Technologies we work with across audits</span>
        <span>Tool coverage is a starting point, never the finding itself. Licences are ours or yours, named in the audit charter before anything is run.</span>
      </p>
      <?= xt_stack($CAP['stack'], ['variant' => 'row', 'marquee' => true, 'speed' => 72, 'size' => 22, 'label' => 'Technologies used across audits']) ?>
    </div>

  </div>
</section>
