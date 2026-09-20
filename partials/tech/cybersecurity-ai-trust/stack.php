<?php /* DRAFT COPY — review before launch */
/* TM-07 Stack — the security toolchain as a coverage board rather than a shopping list. Six shelves,
   grouped by the job the tool does. Every tool is a toggle: on means "you already run this", off means
   "not covered yet". Two illustrative starting estates set the whole board at once, and the shelf meters,
   the coverage rail and the "where we would start" list recompute from whatever is on.

   That mechanism is the section's argument: the AI shelf is empty in both starting estates, which is the
   point the lead copy makes. Marks come from tsc_tool(): a library slug renders the kit logo beside the
   name; anything the library has no licence-clean mark for renders the kit's mono wordmark chip as the
   card title. Technologies we work with — never a partnership, tier or reseller claim.

   The shipped HTML is the Microsoft-centred estate, already counted: every meter, the rail and the gap
   list are rendered by PHP, so the board reads correctly with no JavaScript. stack.js only recomputes. */

/* [key (slug or exact product name), why it is on the shelf, open source, in the Microsoft-centred
   estate, in the AWS and open-source estate] */
$tscst_shelves = [
    ['identity', 'Identity & access', 'key',
        'Who is allowed in, as whom, for how long. Most breaches start here, so this shelf is built first.',
        [
            ['okta', 'Single sign-on, MFA and lifecycle automation across staff and customer identity.', false, false, true],
            ['Microsoft Entra ID', 'Conditional access and privileged identity management where the estate is already Microsoft.', false, true, false],
            ['auth0', 'Customer identity for products: passwordless, social sign-in and tenant isolation.', false, false, false],
            ['cloudflare', 'Zero-trust access to internal tools, plus WAF and bot management at the edge.', false, false, true],
            ['1password', 'Shared credential hygiene for teams, with breach and reuse reporting.', false, true, true],
        ]],
    ['code', 'Code & supply chain', 'git-branch',
        'Vulnerabilities found at the pull request cost minutes. The same ones found in production cost weeks.',
        [
            ['snyk', 'Dependency, container and IaC scanning wired into the pull request, not a nightly email.', false, false, true],
            ['github', 'Advanced Security: code scanning, secret scanning and push protection on every branch.', false, true, true],
            ['sonarqubecloud', 'Static analysis with a quality gate that fails the build on new security hotspots.', false, false, false],
            ['trivy', 'Image and filesystem scanning in CI, plus SBOM generation for every release.', true, false, true],
            ['OWASP ZAP', 'Automated dynamic scans against staging on each deploy, tuned to cut false positives.', true, false, false],
            ['Semgrep', 'Custom rules for the patterns your codebase keeps getting wrong.', true, false, false],
        ]],
    ['cloud', 'Cloud posture & secrets', 'cloud',
        'A misconfigured bucket or an over-broad role is a breach waiting for someone to notice it.',
        [
            ['vault', 'Central secret storage with dynamic credentials, leases and rotation.', false, false, false],
            ['Wiz', 'Agentless cloud posture and attack-path analysis across accounts and workloads.', false, true, false],
            ['Prowler', 'Open-source CIS Benchmark checks run on a schedule, with findings raised as tickets.', true, false, true],
            ['terraform', 'Infrastructure as code, so a hardened configuration is the default and drift is visible.', false, true, true],
            ['kubernetes', 'Network policies, pod security standards and workload identity in the cluster itself.', false, false, true],
        ]],
    ['runtime', 'Runtime & detection', 'radar',
        'Assume something gets through. The question is how quickly you see it and how far it gets.',
        [
            ['Splunk', 'SIEM correlation across application, cloud and identity logs, with detection as code.', false, false, true],
            ['elastic', 'Elastic Security for search-led investigation and long-tail log retention.', false, false, true],
            ['Wazuh', 'Open-source host detection and file integrity monitoring where licensing matters.', true, false, false],
            ['Microsoft Sentinel', 'Cloud-native SIEM and automated playbooks for Microsoft-centred estates.', false, true, false],
            ['falco', 'Runtime detection inside containers: unexpected shells, mounts and outbound calls.', true, false, false],
            ['opentelemetry', 'One instrumentation standard, so security and reliability read the same traces.', true, true, true],
        ]],
    ['ai', 'AI security & guardrails', 'scan',
        'The newest shelf, and the one most teams have nothing on. Attacks here arrive as ordinary text.',
        [
            ['Garak', 'Scanner for prompt injection, jailbreaks, toxicity and data leakage across model versions.', true, false, false],
            ['PyRIT', 'Automated adversarial generation for multi-turn attacks and tool-misuse scenarios.', true, false, false],
            ['promptfoo', 'Red-team and eval suites that run in CI and gate a release on the pass rate.', true, false, false],
            ['Llama Guard', 'Input and output classification ahead of and behind the model.', true, false, false],
            ['Presidio', 'Personal-data detection and redaction on the way into context and out of a reply.', true, false, false],
        ]],
    ['evidence', 'Evidence & GRC', 'clipboard-check',
        'If it is not recorded, it did not happen. Evidence is collected by the pipeline, not by a person chasing screenshots.',
        [
            ['Vanta', 'Continuous control monitoring with evidence pulled straight from cloud and code.', false, true, true],
            ['Drata', 'Policy management, access reviews and auditor workspace in one place.', false, false, false],
            ['jira', 'Findings, owners and due dates in the same board engineering already works from.', false, true, true],
            ['confluence', 'Policies, runbooks and the statement of applicability, versioned and approved.', false, true, false],
        ]],
];

$tscst_presets = [   // key => [label, index in the tool row that holds this preset's flag]
    'ms'   => ['Microsoft-centred', 3],
    'aws'  => ['AWS &amp; open source', 4],
    'none' => ['Nothing yet', -1],
];
$tscst_start = 'ms';   // the estate the shipped HTML is counted for

/* Counted in PHP so the board is right with no JavaScript. */
$tscst_flag  = $tscst_presets[$tscst_start][1];
$tscst_count = 0;
$tscst_on    = 0;
$tscst_data  = [];            // for stack.js: shelf key => [tool on/off per preset]
$tscst_cov   = [];            // shelf key => [name, on, total]
foreach ($tscst_shelves as $tscst_s) {
    $tscst_shelf_on = 0;
    $tscst_rows = [];
    foreach ($tscst_s[4] as $tscst_t) {
        $tscst_count++;
        $tscst_shelf_on += $tscst_t[$tscst_flag] ? 1 : 0;
        $tscst_rows[] = ['ms' => (bool) $tscst_t[3], 'aws' => (bool) $tscst_t[4]];
    }
    $tscst_on  += $tscst_shelf_on;
    $tscst_cov[$tscst_s[0]] = [$tscst_s[1], $tscst_shelf_on, count($tscst_s[4])];
    $tscst_data[$tscst_s[0]] = $tscst_rows;
}
$tscst_gaps = $tscst_count - $tscst_on;
$tscst_pct  = $tscst_count ? round($tscst_on / $tscst_count * 100) : 0;

/* The three thinnest shelves, worst first — where a programme actually starts. */
$tscst_weak = $tscst_cov;
uasort($tscst_weak, function ($a, $b) {
    $r = ($a[1] / max(1, $a[2])) <=> ($b[1] / max(1, $b[2]));
    return $r !== 0 ? $r : ($b[2] - $a[2]);
});
$tscst_weak = array_slice($tscst_weak, 0, 3, true);
?>
<section class="band band--alt tsc-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-07</b><span>Toolchain</span></p>
        <h2 class="h2" id="stack-t"><span class="g">The security toolchain,</span> organised by job.</h2>
      </div>
      <div>
        <p class="lead">Tools are chosen for the job and for what your team can actually run. We work with what you already own wherever it holds up, and we say plainly when it does not. Switch a tool on to mark it as something you already run; the shelves below tell you where the thin cover is.</p>
        <p class="tsc-stack__meta bdh-meta"><span><?= $tscst_count ?> tools</span><span><?= count($tscst_shelves) ?> shelves</span><span>Technologies we work with</span></p>
      </div>
    </div>

    <div class="tsc-sh" data-sh data-rv>
      <div class="tsc-sh__bar">
        <div class="tsc-sh__bl">
          <p class="tsc-sh__bk"><span class="tsc-led tsc-led--ping" aria-hidden="true"></span>Coverage board</p>
          <p class="tsc-sh__bw">Start from an estate, then correct it tool by tool.</p>
        </div>
        <div class="tsc-sh__pre" role="group" aria-label="Start from a typical estate">
          <?php foreach ($tscst_presets as $tscst_pk => $tscst_p): ?>
            <button type="button" class="tsc-sh__preb" data-sh-pre="<?= e($tscst_pk) ?>" aria-pressed="<?= $tscst_pk === $tscst_start ? 'true' : 'false' ?>"><?= $tscst_p[0] ?></button>
          <?php endforeach; ?>
        </div>
        <p class="tsc-sh__read" role="status" aria-live="polite"><span><b data-sh-on><?= $tscst_on ?></b> of <?= $tscst_count ?> already in place</span><i>·</i><span><b data-sh-gap><?= $tscst_gaps ?></b> we would assess or add</span></p>
        <p class="tsc-sh__rail" aria-hidden="true"><i data-sh-rail style="--w:<?= $tscst_pct ?>%"></i></p>
      </div>

      <div class="tsc-sh__rows">
        <?php foreach ($tscst_shelves as $tscst_i => $tscst_s):
            $tscst_n = $tscst_cov[$tscst_s[0]][1]; $tscst_tot = $tscst_cov[$tscst_s[0]][2]; ?>
          <section class="tsc-sh__row" style="--i:<?= $tscst_i ?>" data-sh-row="<?= e($tscst_s[0]) ?>" data-sh-empty="<?= $tscst_n === 0 ? '1' : '0' ?>" aria-labelledby="stack-<?= e($tscst_s[0]) ?>">
            <header class="tsc-sh__head">
              <p class="tsc-sh__n tsc-mono"><?= str_pad((string) ($tscst_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
              <span class="tsc-sh__ico" aria-hidden="true"><?= xt_icon($tscst_s[2], ['size' => 20]) ?></span>
              <h3 class="tsc-sh__t" id="stack-<?= e($tscst_s[0]) ?>"><?= e($tscst_s[1]) ?></h3>
              <p class="tsc-sh__w"><?= e($tscst_s[3]) ?></p>
              <p class="tsc-sh__m">
                <span class="tsc-sh__mn tsc-mono"><b data-sh-n><?= $tscst_n ?></b> / <?= $tscst_tot ?> in place</span>
                <span class="tsc-sh__mb" aria-hidden="true"><i data-sh-bar style="--w:<?= round($tscst_n / max(1, $tscst_tot) * 100) ?>%"></i></span>
              </p>
            </header>
            <ul class="tsc-sh__list" role="list">
              <?php foreach ($tscst_s[4] as $tscst_j => $tscst_t):
                  $tscst_isword = !xt_tech($tscst_t[0]);
                  $tscst_ison   = (bool) $tscst_t[$tscst_flag]; ?>
                <li class="tsc-sh__item" style="--j:<?= $tscst_j ?>">
                  <button type="button" class="tsc-sh__tog<?= $tscst_isword ? ' is-word' : '' ?>" data-sh-t aria-pressed="<?= $tscst_ison ? 'true' : 'false' ?>">
                    <span class="tsc-sh__name">
                      <?php if (!$tscst_isword): ?><span class="tsc-sh__mark" aria-hidden="true"><?= xt_logo($tscst_t[0], ['size' => 20, 'hidden' => true]) ?></span><?php endif; ?>
                      <?= $tscst_isword ? tsc_tool($tscst_t[0], ['size' => 22]) : '<span>' . e(tsc_tool_name($tscst_t[0])) . '</span>' ?>
                      <?php if ($tscst_t[2]): ?><span class="tsc-sh__oss tsc-mono">OSS</span><?php endif; ?>
                    </span>
                    <span class="tsc-sh__why"><?= e($tscst_t[1]) ?></span>
                    <span class="tsc-sh__state tsc-mono"><i aria-hidden="true"></i><?= $tscst_ison ? 'In place' : 'Not covered' ?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
          </section>
        <?php endforeach; ?>
      </div>

      <div class="tsc-sh__foot">
        <div>
          <p class="tsc-sh__fk">Where we would start</p>
          <ol class="tsc-sh__gaps" data-sh-gaps>
            <?php $tscst_r = 1; foreach ($tscst_weak as $tscst_wk => $tscst_w): ?>
              <li><span class="tsc-kbd"><?= str_pad((string) $tscst_r++, 2, '0', STR_PAD_LEFT) ?></span><b><?= e($tscst_w[0]) ?></b><span><?= $tscst_w[1] ?> of <?= $tscst_w[2] ?> in place</span></li>
            <?php endforeach; ?>
          </ol>
        </div>
        <p class="tsc-note tsc-sh__fn">
          <span class="tsc-ill">Illustrative estates</span>
          <span>A shelf is not a shopping list. The two starting points are typical shapes, not your inventory. We begin from what you actually run, remove overlap, and add only where a real gap is costing you detection time or evidence.</span>
        </p>
      </div>
    </div>

    <p class="bdh-sr">Illustrative coverage board. Thirty-one security tools sit on six shelves by the job they do. Each tool is a switch marking whether you already run it, and the shelf meters, the overall count and the list of the three thinnest shelves recalculate as you change them. Both starting estates leave the AI security shelf empty.</p>

    <script type="application/json" id="stack-presets"><?= json_encode($tscst_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
  </div>
</section>
