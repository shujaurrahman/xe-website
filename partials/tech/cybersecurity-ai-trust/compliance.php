<?php /* DRAFT COPY — review before launch */
/* TM-06 Compliance — the control crosswalk. Eight controls we actually build, mapped across ten
   frameworks. Choosing a framework column highlights its cells and swaps the readout beside the
   matrix (what it covers, how we apply it, how many of the eight it reaches, what evidence lands).
   Matrix scrolls inside .bdh-scroll-x with a sticky control column; compliance.js owns selection. */

$tscc_fw = [   // badge key => [family label, printed in the column head and used to group them]
    'iso27001'    => ['Security'],
    'soc2'        => ['Security'],
    'nist-csf'    => ['Security'],
    'pci-dss'     => ['Sector'],
    'hipaa'       => ['Sector'],
    'gdpr'        => ['Privacy'],
    'dpdp'        => ['Privacy'],
    'iso42001'    => ['AI'],
    'nist-ai-rmf' => ['AI'],
    'eu-ai-act'   => ['AI'],
];

/* [key, control, icon, what we build, evidence that proves it, [framework => clause reference]] */
$tscc_ctl = [
    ['access', 'Access review', 'key',
        'Single sign-on with MFA, roles scoped to the job, joiner-mover-leaver automation and a quarterly review of who can still reach what.',
        'Access review export, one ticket per revocation',
        ['iso27001' => 'A.5.18', 'soc2' => 'CC6.3', 'nist-csf' => 'PR.AA', 'pci-dss' => 'Req. 7', 'hipaa' => '164.308(a)(4)', 'gdpr' => 'Art. 32', 'dpdp' => 'S. 8(4)']],
    ['crypto', 'Encryption & key management', 'lock',
        'TLS 1.2 or later in transit, AES-256 at rest, keys held in a managed KMS or Vault with rotation, separation of duties and no secrets in code.',
        'Key rotation log, cipher scan, secret-scanning results',
        ['iso27001' => 'A.8.24', 'soc2' => 'CC6.7', 'nist-csf' => 'PR.DS', 'pci-dss' => 'Req. 3', 'hipaa' => '164.312(a)(2)(iv)', 'gdpr' => 'Art. 32(1)(a)', 'dpdp' => 'S. 8(5)']],
    ['logging', 'Logging & monitoring', 'log',
        'Centralised, tamper-evident logs from applications, cloud and AI systems, with detection rules, alert routing and retention tiers that meet the obligation.',
        'Detection rule set, alert audit trail, retention policy',
        ['iso27001' => 'A.8.15', 'soc2' => 'CC7.2', 'nist-csf' => 'DE.CM', 'pci-dss' => 'Req. 10', 'hipaa' => '164.312(b)', 'gdpr' => 'Art. 5(2)', 'dpdp' => 'S. 8(4)', 'iso42001' => 'A.6.2.8', 'nist-ai-rmf' => 'MEASURE 2', 'eu-ai-act' => 'Art. 12']],
    ['vendor', 'Vendor & supply-chain risk', 'handshake',
        'A vendor register with a security review before onboarding, contractual duties for processors and sub-processors, and an SBOM plus an AI bill of materials for every release.',
        'Vendor file, SBOM and AIBOM per build, signature verification',
        ['iso27001' => 'A.5.19', 'soc2' => 'CC9.2', 'nist-csf' => 'GV.SC', 'pci-dss' => 'Req. 12.8', 'hipaa' => '164.308(b)(1)', 'gdpr' => 'Art. 28', 'dpdp' => 'S. 8(2)', 'iso42001' => 'A.10.3', 'nist-ai-rmf' => 'GOVERN 6', 'eu-ai-act' => 'Art. 25']],
    ['ir', 'Incident response', 'alert',
        'Named roles, a severity ladder, runbooks per scenario, a tested notification clock for every regulator that applies, and a tabletop exercise each quarter.',
        'Runbooks, tabletop report, notification timeline per incident',
        ['iso27001' => 'A.5.24', 'soc2' => 'CC7.4', 'nist-csf' => 'RS.MA', 'pci-dss' => 'Req. 12.10', 'hipaa' => '164.308(a)(6)', 'gdpr' => 'Art. 33', 'dpdp' => 'S. 8(6)', 'nist-ai-rmf' => 'MANAGE 4', 'eu-ai-act' => 'Art. 73']],
    ['airisk', 'AI risk assessment', 'brain',
        'An inventory of every AI system, a risk tier per use case, an impact assessment before launch and a named human accountable for oversight.',
        'AI register, impact assessment, oversight sign-off',
        ['gdpr' => 'Art. 35', 'dpdp' => 'S. 10', 'iso42001' => 'A.5.2', 'nist-ai-rmf' => 'MAP 1', 'eu-ai-act' => 'Art. 9']],
    ['rights', 'Data subject rights', 'fingerprint',
        'One intake route, identity verification, a search that reaches every system holding the record, and a response inside the statutory window.',
        'Request log, response-time report, deletion receipts',
        ['soc2' => 'P5.2', 'hipaa' => '164.524', 'gdpr' => 'Art. 12–22', 'dpdp' => 'S. 11–14']],
    ['sdlc', 'Secure SDLC', 'git-branch',
        'A threat model per feature, SAST, DAST, dependency and secret scanning as build gates, peer review, signed artefacts and AI red-team suites on every model or prompt change.',
        'Pipeline gate results, review records, red-team pass rate',
        ['iso27001' => 'A.8.25', 'soc2' => 'CC8.1', 'nist-csf' => 'PR.PS', 'pci-dss' => 'Req. 6', 'gdpr' => 'Art. 25', 'iso42001' => 'A.6.2', 'nist-ai-rmf' => 'MEASURE 2.7', 'eu-ai-act' => 'Art. 15']],
];

$tscc_n = [];   // controls reached, per framework
foreach ($tscc_fw as $tscc_k => $tscc_meta) {
    $tscc_n[$tscc_k] = 0;
    foreach ($tscc_ctl as $tscc_c) { if (!empty($tscc_c[5][$tscc_k])) $tscc_n[$tscc_k]++; }
}
$tscc_cells = array_sum($tscc_n);
$tscc_first = 'iso27001';
?>
<section class="band tsc-compliance" id="compliance" aria-labelledby="compliance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-06</b><span>Control crosswalk</span></p>
        <h2 class="h2" id="compliance-t"><span class="g">One set of controls,</span> many frameworks.</h2>
      </div>
      <div>
        <p class="lead">Frameworks overlap far more than they differ. We build the control once, wire the evidence into the pipeline that already runs, and map it to every standard you answer to. Choose a column to see what it reaches.</p>
        <!-- PLACEHOLDER: confirm any certification or attestation Xterra Edze itself holds before launch -->
        <p class="tsc-compliance__caveat">Frameworks we align delivery with and prepare you for. Certificates are issued by accredited certification bodies and SOC 2 reports by licensed CPA firms, never by us.</p>
      </div>
    </div>

    <div class="tsc-cw" data-cw data-sel="<?= e($tscc_first) ?>">

      <div class="tsc-cw__panel" data-rv>
        <?php foreach ($tscc_fw as $tscc_k => $tscc_meta): $tscc_s = xt_standard($tscc_k); if (!$tscc_s) continue; ?>
          <article class="tsc-cw__fw" data-cw-panel="<?= e($tscc_k) ?>"<?= $tscc_k === $tscc_first ? '' : ' hidden' ?>>
            <div class="tsc-cw__fwtop"><?= xt_badge($tscc_k, ['class' => 'tsc-cw__badge']) ?></div>
            <p class="tsc-cw__fwbody"><span>Issued by</span><b><?= e($tscc_s['body']) ?></b><span><?= e($tscc_s['kind']) ?></span></p>
            <dl class="tsc-cw__fwmeta">
              <div><dt>Covers</dt><dd><?= e($tscc_s['covers']) ?></dd></div>
              <div><dt>How we apply it</dt><dd><?= e($tscc_s['apply']) ?></dd></div>
            </dl>
            <p class="tsc-cw__fwn">
              <b><?= str_pad((string) $tscc_n[$tscc_k], 2, '0', STR_PAD_LEFT) ?></b>
              <span>of <?= count($tscc_ctl) ?> controls on this matrix carry a reference to it</span>
            </p>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="tsc-cw__matrix" data-rv>
        <div class="tsc-cw__bar">
          <p class="tsc-cw__bk"><span class="tsc-led tsc-led--ping" aria-hidden="true"></span>Control coverage</p>
          <p class="tsc-cw__bn tsc-mono"><b data-bdh-count><?= $tscc_cells ?></b> mappings · <?= count($tscc_ctl) ?> controls · <?= count($tscc_fw) ?> frameworks</p>
        </div>
        <div class="bdh-scroll-x tsc-cw__scroll" tabindex="0" role="group" aria-label="Control crosswalk matrix, scrolls sideways">
          <table class="tsc-cw__t">
            <caption class="bdh-sr">Eight security, privacy and AI controls and the clause each framework maps them to. An em dash means the framework does not address that control directly.</caption>
            <thead>
              <tr>
                <th scope="col" class="tsc-cw__corner"><span>Control we build</span></th>
                <?php foreach ($tscc_fw as $tscc_k => $tscc_meta): $tscc_s = xt_standard($tscc_k); if (!$tscc_s) continue; ?>
                  <th scope="col" class="tsc-cw__ch" data-f="<?= e($tscc_k) ?>">
                    <button type="button" data-cw-b="<?= e($tscc_k) ?>" aria-pressed="<?= $tscc_k === $tscc_first ? 'true' : 'false' ?>">
                      <?= xt_badge($tscc_k, ['variant' => 'chip']) ?>
                      <span class="tsc-cw__cfam"><?= e($tscc_meta[0]) ?></span>
                    </button>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tscc_ctl as $tscc_i => $tscc_c): ?>
                <tr>
                  <th scope="row" class="tsc-cw__rh">
                    <span class="tsc-cw__rico"><?= xt_icon($tscc_c[2], ['size' => 18]) ?></span>
                    <span class="tsc-cw__rn"><?= e($tscc_c[1]) ?></span>
                    <span class="tsc-cw__rw"><?= e($tscc_c[3]) ?></span>
                    <span class="tsc-cw__rev"><span class="tsc-kbd">Evidence</span><?= e($tscc_c[4]) ?></span>
                  </th>
                  <?php foreach ($tscc_fw as $tscc_k => $tscc_meta): $tscc_ref = $tscc_c[5][$tscc_k] ?? ''; ?>
                    <td class="tsc-cw__c<?= $tscc_ref ? ' is-on' : '' ?>" data-f="<?= e($tscc_k) ?>" style="--i:<?= $tscc_i ?>">
                      <?php if ($tscc_ref): ?>
                        <span class="tsc-cw__ref"><?= e($tscc_ref) ?></span>
                      <?php else: ?>
                        <span class="tsc-cw__non" aria-label="not addressed directly">&#8212;</span>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="tsc-cw__hint tsc-mono" aria-hidden="true">Scroll sideways for the remaining frameworks</p>
      </div>
    </div>

    <p class="tsc-note">
      <span class="tsc-ill">Illustrative mapping</span>
      <span>Clause references are the common anchors, not a substitute for a scoped gap assessment. Your statement of applicability is written against your systems, your data and the regulators that actually apply to you.</span>
    </p>
  </div>
</section>
