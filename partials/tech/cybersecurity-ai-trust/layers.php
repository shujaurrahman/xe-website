<?php /* DRAFT COPY — review before launch */
/* TM-02 Layers — defence in depth as a controllable legend. Six concentric rings around your assets
   (Detection & response wraps the rest); choosing a layer, by tab or by clicking its ring, lists its
   controls with clause references, how each is proven, the frameworks it maps to and the tools that run
   it. Requests travel inward on three radials and stop at different rings. layers.js drives the tabs. */
$tscl_layers = [   // [name, icon, purpose, [[control, ref]], proof, [maps], [tools]]
    ['Identity', 'fingerprint',
        'Every person, service and agent proves who it is, and gets only the access the task needs.',
        [
            ['Single sign-on with phishing-resistant MFA (passkeys, FIDO2) for staff and admins', 'A.8.5'],
            ['Least-privilege roles, with just-in-time elevation for admin access', 'A.8.2'],
            ['Quarterly access reviews and automated joiner, mover and leaver changes', 'A.5.18'],
            ['Short-lived workload identities (OIDC) for CI, services and agents, with no long-lived keys', 'PR.AA'],
        ],
        'Access review sign-offs, MFA coverage report, stale-account alerts',
        ['ISO/IEC 27001 A.5.15–5.18', 'NIST CSF 2.0 PR.AA'],
        ['okta', 'Microsoft Entra ID', 'auth0', 'openid'],
    ],
    ['Network & edge', 'edge',
        'Traffic reaches only what it should, and abuse is absorbed at the edge before it reaches your code.',
        [
            ['Web application firewall with managed OWASP rule sets and bot management', 'A.8.20'],
            ['Rate limits and DDoS protection on login, search and AI endpoints', 'PR.IR'],
            ['Zero-trust access to internal tools through an identity-aware proxy, not a flat VPN', 'A.8.21'],
            ['Private networking and segmentation for databases, queues and model endpoints', 'A.8.22'],
        ],
        'WAF block reports, external attack-surface scans, segmentation tests',
        ['ISO/IEC 27001 A.8.20–8.22', 'NIST CSF 2.0 PR.IR'],
        ['cloudflare', 'kong', 'istio', 'akamai'],
    ],
    ['Application', 'code',
        'Security requirements are written as acceptance criteria and checked on every pull request, not once a year.',
        [
            ['Threat model per feature (STRIDE), updated whenever the design changes', 'A.8.25'],
            ['SAST, secret scanning and dependency scanning on every pull request', 'A.8.28'],
            ['DAST against staging, plus a manual penetration test before major releases', 'A.8.29'],
            ['Signed builds, an SBOM and SLSA provenance for everything that ships', 'PR.PS'],
            ['Verification against OWASP ASVS at the level your risk profile needs', 'ASVS'],
        ],
        'Pipeline gate history, penetration test report and retest, SBOM per release',
        ['ISO/IEC 27001 A.8.25–8.29', 'OWASP ASVS', 'NIST CSF 2.0 PR.PS'],
        ['github', 'snyk', 'sonarqubecloud', 'trivy', 'burpsuite'],
    ],
    ['Data', 'database',
        'Sensitive data is encrypted, minimised and masked, and the keys are held apart from the data.',
        [
            ['Encryption at rest (AES-256) and in transit (TLS 1.2 or higher)', 'A.8.24'],
            ['Keys in a managed KMS or HSM, with rotation and separation of duties', 'PR.DS'],
            ['Tokenisation for card numbers and field-level encryption for identity numbers', 'PCI 3.5'],
            ['Masking in non-production and data-loss prevention on exports', 'A.8.11–8.12'],
            ['Immutable backups with a restore test every quarter', 'A.8.13'],
        ],
        'Key rotation logs, restore test records, data classification register',
        ['ISO/IEC 27001 A.8.10–8.13, A.8.24', 'NIST CSF 2.0 PR.DS', 'PCI DSS v4.0.1'],
        ['vault', 'amazonwebservices', 'googlecloud', 'microsoftazure'],
    ],
    ['AI & agents', 'agent',
        'Models and agents are treated as untrusted components: kept apart from instructions, limited in what they can do, and tested on every change.',
        [
            ['Retrieved content isolated from instructions, and no secrets in system prompts', 'LLM01 · LLM07'],
            ['Input and output classifiers for injection, jailbreaks and sensitive data', 'LLM02'],
            ['Tool allow-lists, least-privilege scopes and human approval for write actions', 'LLM06'],
            ['Tenant filters enforced inside the vector store, never in the prompt', 'LLM08'],
            ['Red-team suites in CI on every model, prompt or tool change, with token budgets per user', 'LLM10'],
        ],
        'Red-team pass rate per release, AI inventory, approval and tool-call logs',
        ['OWASP Top 10 for LLM Applications', 'MITRE ATLAS', 'ISO/IEC 42001', 'NIST AI RMF'],
        ['Garak', 'PyRIT', 'promptfoo', 'NeMo Guardrails', 'opentelemetry'],
    ],
    ['Detection & response', 'radar',
        'Everything inside is watched. When a control fails, the right person knows within minutes and follows a rehearsed playbook.',
        [
            ['Central SIEM with detections mapped to MITRE ATT&CK techniques', 'DE.AE'],
            ['Endpoint detection on laptops and runtime detection in containers', 'DE.CM'],
            ['Playbooks for the top incident types, with on-call rotas and escalation', 'A.5.26'],
            ['Logs kept for 180 days and clocks synced to NTP, as CERT-In directs', 'CERT-In'],
            ['Tabletop exercises twice a year, with actions tracked to closure', 'A.5.27'],
        ],
        'Detection coverage map, MTTD and MTTR trend, exercise reports',
        ['ISO/IEC 27001 A.5.24–5.28, A.8.15–8.16', 'NIST CSF 2.0 DE · RS', 'CERT-In Directions 2022'],
        ['Splunk', 'Microsoft Sentinel', 'elastic', 'Wazuh', 'falco', 'pagerduty'],
    ],
];

/* ring geometry, viewBox 480 × 480: drawn outermost first. [layer index, outer r, inner r] */
$tscl_c = 240;
$tscl_rings = [[5, 232, 204], [0, 204, 172], [1, 172, 140], [2, 140, 108], [3, 108, 76], [4, 76, 46]];
$tscl_ann = function (float $R, float $r) use ($tscl_c): string {
    $c = $tscl_c;
    return "M" . ($c - $R) . " $c a$R $R 0 1 0 " . (2 * $R) . " 0 a$R $R 0 1 0 " . (-2 * $R) . " 0Z"
         . "M" . ($c - $r) . " $c a$r $r 0 1 0 " . (2 * $r) . " 0 a$r $r 0 1 0 " . (-2 * $r) . " 0Z";
};
$tscl_pt = function (float $deg, float $r) use ($tscl_c): array {
    $a = deg2rad($deg);
    return [round($tscl_c + $r * sin($a), 1), round($tscl_c - $r * cos($a), 1)];
};
/* three probes: [angle°, stop radius (the ring that blocks it), delay s] */
$tscl_probes = [[52, 188, 0], [148, 124, 1.5], [292, 61, 3]];
?>
<section class="band tsc-layers" id="layers" aria-labelledby="layers-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-02</b><span>Defence in depth</span></p>
        <h2 class="h2" id="layers-t"><span class="g">Defence in depth,</span> layer by layer.</h2>
      </div>
      <div>
        <p class="lead">No single control holds on its own. Each layer assumes the one outside it will fail, and each has named controls, a way to prove they work and the tools that run them.</p>
      </div>
    </div>

    <div class="tsc-layers__ui" data-rv>
      <div class="tsc-layers__left">
        <div class="tsc-layers__diag" data-on="0" aria-hidden="true">
          <svg class="tsc-layers__svg" viewBox="0 0 480 480" fill="none">
            <defs>
              <?php foreach ($tscl_rings as $tscl_r): $tscl_m = ($tscl_r[1] + $tscl_r[2]) / 2 - 4; ?>
                <path id="tscl-arc<?= $tscl_r[0] ?>" d="M<?= $tscl_c - $tscl_m ?> <?= $tscl_c ?>A<?= $tscl_m ?> <?= $tscl_m ?> 0 1 1 <?= $tscl_c + $tscl_m ?> <?= $tscl_c ?>A<?= $tscl_m ?> <?= $tscl_m ?> 0 1 1 <?= $tscl_c - $tscl_m ?> <?= $tscl_c ?>"/>
              <?php endforeach; ?>
            </defs>
            <?php foreach ($tscl_rings as $tscl_r): ?>
              <g class="tsc-ring tsc-ring--<?= $tscl_r[0] ?><?= $tscl_r[0] === 0 ? ' is-on' : '' ?>" data-l="<?= $tscl_r[0] ?>">
                <path class="tsc-ring__band" fill-rule="evenodd" d="<?= $tscl_ann($tscl_r[1], $tscl_r[2]) ?>"/>
                <text class="tsc-ring__t"><textPath href="#tscl-arc<?= $tscl_r[0] ?>" startOffset="25%" text-anchor="middle"><?= e($tscl_layers[$tscl_r[0]][0]) ?></textPath></text>
                <?php $tscl_n = count($tscl_layers[$tscl_r[0]][3]); for ($tscl_k = 0; $tscl_k < $tscl_n; $tscl_k++):
                    [$tscl_x, $tscl_y] = $tscl_pt(200 + $tscl_k * 13, ($tscl_r[1] + $tscl_r[2]) / 2); ?>
                  <circle class="tsc-ring__node" cx="<?= $tscl_x ?>" cy="<?= $tscl_y ?>" r="3"/>
                <?php endfor; ?>
              </g>
            <?php endforeach; ?>
            <circle class="tsc-layers__core" cx="240" cy="240" r="46"/>
            <?php foreach ($tscl_probes as $tscl_i => $tscl_p):
                [$tscl_x0, $tscl_y0] = $tscl_pt($tscl_p[0], 236);
                [$tscl_x1, $tscl_y1] = $tscl_pt($tscl_p[0], $tscl_p[1]); ?>
              <line class="tsc-probe__path" x1="<?= $tscl_x0 ?>" y1="<?= $tscl_y0 ?>" x2="<?= $tscl_x1 ?>" y2="<?= $tscl_y1 ?>"/>
              <g class="tsc-probe" style="--x0:<?= $tscl_x0 ?>px;--y0:<?= $tscl_y0 ?>px;--x1:<?= $tscl_x1 ?>px;--y1:<?= $tscl_y1 ?>px;--dl:<?= $tscl_p[2] ?>s">
                <circle class="tsc-probe__dot" r="4.5"/>
              </g>
              <g class="tsc-probe__stop" transform="translate(<?= $tscl_x1 ?> <?= $tscl_y1 ?>)" style="--dl:<?= $tscl_p[2] ?>s">
                <circle r="9"/><path d="M-3.5 -3.5l7 7M3.5 -3.5l-7 7"/>
              </g>
            <?php endforeach; ?>
          </svg>
          <p class="tsc-layers__corelbl">Your assets</p>
        </div>
        <p class="bdh-sr">Illustrative defence-in-depth diagram. Six concentric rings surround your assets: detection and response outermost, then identity, network and edge, application, data, and AI and agents at the centre. Three probes travel inward from outside and are stopped at different rings. Selecting a ring is the same as choosing its tab below, and each of the six layers is written out in full in the control sheet.</p>

        <div class="tsc-layers__tabs" role="tablist" aria-label="Security layers">
          <?php foreach ($tscl_layers as $tscl_i => $tscl_l): ?>
            <button type="button" role="tab" class="tsc-layers__tab" id="layers-tab<?= $tscl_i ?>" aria-controls="layers-p<?= $tscl_i ?>" aria-selected="<?= $tscl_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tscl_i === 0 ? '0' : '-1' ?>">
              <span class="tsc-layers__ti"><?= xt_icon($tscl_l[1], ['size' => 18]) ?></span>
              <span class="tsc-layers__tn"><?= e($tscl_l[0]) ?></span>
              <span class="tsc-layers__tk">L<?= $tscl_i + 1 ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bdh-panes tsc-layers__panes">
        <?php foreach ($tscl_layers as $tscl_i => $tscl_l): ?>
          <div class="bdh-pane tsc-layers__pane<?= $tscl_i === 0 ? ' is-on' : '' ?>" id="layers-p<?= $tscl_i ?>" role="tabpanel" aria-labelledby="layers-tab<?= $tscl_i ?>">
            <div class="tsc-layers__ph">
              <span class="tsc-layers__pico"><?= xt_icon($tscl_l[1], ['size' => 26]) ?></span>
              <div>
                <p class="tsc-layers__pk">Layer <?= $tscl_i + 1 ?> of <?= count($tscl_layers) ?> <i>·</i> <?= count($tscl_l[3]) ?> controls</p>
                <h3 class="tsc-layers__pt"><?= e($tscl_l[0]) ?></h3>
              </div>
            </div>
            <p class="tsc-layers__pd"><?= e($tscl_l[2]) ?></p>

            <ul class="tsc-layers__ctl" role="list">
              <?php foreach ($tscl_l[3] as $tscl_k => $tscl_ctl): ?>
                <li style="--i:<?= $tscl_k ?>"><span class="tsc-tick" aria-hidden="true"></span><span class="tsc-layers__cn"><?= e($tscl_ctl[0]) ?></span><span class="tsc-kbd"><?= e($tscl_ctl[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>

            <dl class="tsc-layers__foot">
              <div><dt>Proven by</dt><dd><?= e($tscl_l[4]) ?></dd></div>
              <div><dt>Maps to</dt><dd class="tsc-layers__maps"><?php foreach ($tscl_l[5] as $tscl_m): ?><span><?= e($tscl_m) ?></span><?php endforeach; ?></dd></div>
              <div class="tsc-layers__tools"><dt>Tools we work with</dt><dd><ul class="tsc-layers__tl" role="list"><?php foreach ($tscl_l[6] as $tscl_t): ?><li title="<?= e(tsc_tool_name($tscl_t)) ?>"><?= tsc_tool($tscl_t, ['size' => 20, 'hidden' => true]) ?><span><?= e(tsc_tool_name($tscl_t)) ?></span></li><?php endforeach; ?></ul></dd></div>
            </dl>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
