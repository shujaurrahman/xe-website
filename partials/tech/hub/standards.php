<?php /* DRAFT COPY — review before launch */
/* Standards — the frameworks we build to, as a wall of code-built badges (xt_badge; never official seals) in
   four groups. Selecting a badge (aria-pressed) shows what it governs and how it shows up in delivery, and the
   panel draws a connector from the badge to every capability page that applies it (from each capability's
   'standards' list, plus a few the data does not name). A crosswalk strip shows one control (access and audit
   logging) satisfying clauses in six frameworks at once, with a live log tail. standards.js runs both. */
$std_groups = [
    ['security', 'Security & privacy',          ['iso27001', 'soc2', 'nist-csf', 'cis', 'owasp-asvs', 'owasp-top10', 'slsa', 'pci-dss', 'hipaa', 'gdpr', 'dpdp', 'iso27701', 'cert-in', 'nis2']],
    ['ai',       'AI governance',               ['iso42001', 'nist-ai-rmf', 'eu-ai-act', 'owasp-llm', 'mitre-atlas']],
    ['quality',  'Quality & accessibility',     ['wcag22', 'cwv', 'iso9001']],
    ['ops',      'Sustainability & operations', ['sci', 'dora-metrics', 'iso14001', 'iso22301']],
];
$std_first = 'iso27001';
/* where each standard applies: from the capability data, plus a few the data does not name */
$std_caps = [];
foreach ($TI as $std_cs => $std_c) { foreach ($std_c['standards'] as $std_k) { $std_caps[$std_k][] = $std_cs; } }
$std_extra = [
    'hipaa'    => ['cybersecurity-ai-trust', 'custom-software-data-platforms', 'ai-product-automation'],
    'slsa'     => ['ai-infrastructure-cloud', 'cybersecurity-ai-trust'],
    'iso27701' => ['cybersecurity-ai-trust', 'custom-software-data-platforms'],
    'nis2'     => ['cybersecurity-ai-trust', 'integration-support'],
    'cis'      => ['ai-infrastructure-cloud', 'cybersecurity-ai-trust'],
];
foreach ($std_extra as $std_k => $std_l) { $std_caps[$std_k] = array_values(array_unique(array_merge($std_caps[$std_k] ?? [], $std_l))); }
/* keep capability order (01 → 10) inside every list */
$std_order = array_flip(array_keys($TI));
foreach ($std_caps as $std_k => $std_l) { usort($std_l, fn ($std_a, $std_b) => $std_order[$std_a] <=> $std_order[$std_b]); $std_caps[$std_k] = $std_l; }
$std_url = fn (string $std_s): string => xe_url('services/technology-intelligence/' . $std_s . '.php');
/* the drawn part of a badge, reused as the panel's mark (the kit renders it; we only lift the svg) */
$std_art = function (string $std_k): string {
    return preg_match('~<svg class="xt-badge__art".*?</svg>~s', xt_badge($std_k), $std_m) ? $std_m[0] : '';
};
$std_total = array_sum(array_map(fn ($std_g) => count($std_g[2]), $std_groups));
$std_cross = [
    // [framework, clause]
    ['ISO/IEC 27001:2022',  'Annex A 8.15 · Logging'],
    ['SOC 2',               'CC7.2 · Monitoring of system components'],
    ['PCI DSS v4.0.1',      'Requirement 10 · Log and monitor all access'],
    ['HIPAA Security Rule', '§164.312(b) · Audit controls'],
    ['CERT-In 2022',        'ICT logs kept 180 days, in India'],
    ['DPDP Act 2023',       '§8(5) · Reasonable security safeguards'],
];
$std_log = [
    // [time, [key, value] …]  illustrative
    ['10:42:07.118Z', [['actor', 'svc.gateway'], ['action', 'read'], ['resource', 'cdp.profile/8813'], ['auth', 'oidc'], ['result', 'allow'], ['trace', '7f3a9c']]],
    ['10:42:07.131Z', [['actor', 'agent.support'], ['action', 'tool.call'], ['tool', 'orders.lookup'], ['model', 'route:small'], ['prompt', 'v14'], ['result', 'allow']]],
    ['10:42:08.402Z', [['actor', 'user.4021'], ['action', 'export'], ['resource', 'reports.q3'], ['auth', 'sso'], ['result', 'deny'], ['reason', 'role']]],
    ['10:42:09.017Z', [['actor', 'eng.lead'], ['action', 'deploy.approve'], ['resource', 'pr/1482'], ['auth', 'sso+mfa'], ['result', 'allow'], ['trace', '9b21e0']]],
];
$std_field = function (array $std_f): string {
    $std_cls = $std_f[1] === 'deny' ? ' is-deny' : ($std_f[1] === 'allow' ? ' is-allow' : '');
    return '<span class="tih-std__f' . $std_cls . '"><i>' . e($std_f[0]) . '=</i>' . e($std_f[1]) . '</span>';
};
?>
<section class="band tih-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Standards &amp; frameworks</p>
        <h2 class="h2" id="standards-t"><span class="g">Frameworks</span> we build to.</h2>
      </div>
      <div>
        <p class="lead">We align delivery with these frameworks, so the evidence an auditor asks for exists because the work was done that way. Every badge here is drawn in code by us; none is an official seal.</p>
      </div>
    </div>

    <div class="tih-std" data-std="<?= e($std_first) ?>">
      <div class="tih-std__wall" data-rv>
        <p class="bdh-sr">Choose a framework to see what it governs, how it shows up in delivery and which capability pages apply it. The details appear in the panel after the list.</p>
        <?php foreach ($std_groups as $std_gi => $std_g): ?>
          <div class="tih-std__group" data-group="<?= e($std_g[0]) ?>">
            <p class="tih-std__gh"><b><?= str_pad((string) ($std_gi + 1), 2, '0', STR_PAD_LEFT) ?></b><span><?= e($std_g[1]) ?></span><small><?= count($std_g[2]) ?> frameworks</small></p>
            <ul class="tih-std__list" role="list">
              <?php foreach ($std_g[2] as $std_bi => $std_k): $std_s = xt_standard($std_k); if (!$std_s) continue; $std_n = count($std_caps[$std_k] ?? []); ?>
                <li style="--i:<?= $std_bi ?>">
                  <button type="button" class="tih-std__b" data-std="<?= e($std_k) ?>" aria-pressed="<?= $std_k === $std_first ? 'true' : 'false' ?>" aria-controls="standards-panel">
                    <?= xt_badge($std_k) ?>
                    <span class="tih-std__bc"><b><?= $std_n ?></b> <?= $std_n === 1 ? 'page' : 'pages' ?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
        <div class="tih-std__notes">
          <p class="tih-note tih-std__also">Also used as vocabulary rather than badged: ISO/IEC 25010 product-quality characteristics in our definitions of done, the NIST AI 600-1 generative-AI profile alongside the AI RMF, and the FinOps Framework for cloud cost reviews. The OWASP Top 10 for LLM Applications entry follows the 2025 list.</p>
          <!-- PLACEHOLDER: confirm any certification Xterra Edze itself holds before launch -->
          <p class="tih-note"><b>Alignment describes how we work.</b> It is not a claim that Xterra Edze holds a certification: ISO 9001 and ISO 14001 are organisation-level management systems whose practices we follow in delivery. Certifications held by Xterra Edze itself: to be confirmed before launch.</p>
        </div>
      </div>

      <div class="tih-std__side">
        <div class="tih-std__panel" id="standards-panel" aria-live="polite" data-rv data-rv-d="120">
          <p class="tih-std__top"><span class="tih-k">Framework</span><span class="tih-std__pos"><b data-std-pos>1</b> / <?= $std_total ?></span></p>
          <div class="bdh-panes tih-std__panes">
            <?php foreach ($std_groups as $std_g): foreach ($std_g[2] as $std_k): $std_s = xt_standard($std_k); if (!$std_s) continue; ?>
              <div class="bdh-pane tih-std__pane<?= $std_k === $std_first ? ' is-on' : '' ?>" data-pane="<?= e($std_k) ?>">
                <div class="tih-std__ph">
                  <span class="tih-std__pmark" aria-hidden="true"><?= $std_art($std_k) ?></span>
                  <div>
                    <p class="tih-k"><?= e($std_g[1]) ?> · <?= e($std_s['kind']) ?></p>
                    <h3 class="tih-std__pt"><?= e($std_s['code']) ?></h3>
                    <p class="tih-std__pn"><?= e($std_s['name']) ?> · <?= e($std_s['body']) ?></p>
                  </div>
                </div>
                <p class="tih-k">What it governs</p>
                <p class="tih-std__pc"><?= e($std_s['covers']) ?></p>
                <p class="tih-k">How it shows up in delivery</p>
                <p class="tih-std__pa"><?= e($std_s['apply']) ?></p>
              </div>
            <?php endforeach; endforeach; ?>
          </div>

          <p class="tih-k tih-std__ck">Where it applies · <b data-std-n><?= count($std_caps[$std_first] ?? []) ?></b> of <?= count($TI) ?> capability pages</p>
          <div class="tih-std__tree">
            <span class="tih-std__spine" aria-hidden="true"></span>
            <ol class="tih-std__caps" role="list">
              <?php foreach ($TI as $std_cs => $std_c): $std_on = in_array($std_cs, $std_caps[$std_first] ?? [], true); ?>
                <li class="tih-std__cap<?= $std_on ? ' is-on' : '' ?>" data-cap="<?= e($std_cs) ?>">
                  <a href="<?= $std_url($std_cs) ?>"><b><?= e($std_c['n']) ?></b><span><?= e($std_c['name']) ?></span><i aria-hidden="true">›</i></a>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
          <script type="application/json" class="tih-std__data"><?= json_encode($std_caps, JSON_UNESCAPED_SLASHES) ?></script>
        </div>
      </div>
    </div>

    <div class="tih-std__cross" data-rv>
      <div class="tih-std__ch">
        <p class="tih-k">Crosswalk</p>
        <h3 class="tih-std__xh">One control, six frameworks.</h3>
        <p class="bdh-d tih-std__xd">Access and audit logging is built once, in the gateway and in every service. The same log lines satisfy clauses in six frameworks, which is how alignment stays affordable.</p>
        <ul class="tih-std__map" role="list" aria-label="Clauses satisfied by access and audit logging">
          <?php foreach ($std_cross as $std_ci => $std_x): ?>
            <li style="--i:<?= $std_ci ?>"><b><?= e($std_x[0]) ?></b><span><?= e($std_x[1]) ?></span><i aria-hidden="true">✓</i></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <p class="bdh-sr">An audit log tail showing access events with the actor, action, resource, authentication method, result and trace identifier, including an agent's tool call with its model route and prompt version, a denied export and a person approving a deployment.</p>
      <div class="tih-std__term tih-on-ink" aria-hidden="true" data-bdh-live>
        <p class="tih-std__th"><span class="bdh-ui__dots"><i></i><i></i><i></i></span><span class="tih-std__tt">audit.log <i>·</i> tail -f <i>·</i> 2026-09-17</span><span class="tih-live"><i class="bdh-pulse"></i>Streaming</span></p>
        <ol class="tih-std__lines">
          <?php foreach ($std_log as $std_li => $std_l): ?>
            <li style="--i:<?= $std_li ?>"><span class="tih-std__ts"><?= e($std_l[0]) ?></span><?= implode('', array_map($std_field, $std_l[1])) ?></li>
          <?php endforeach; ?>
        </ol>
        <p class="tih-std__tf"><span>retention <b>400 d</b> · in-region</span><span>tamper-evident <b>hash chain</b></span><span>clock <b>NTP · IST/UTC</b></span></p>
      </div>
    </div>
  </div>
</section>
