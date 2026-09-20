<?php /* DRAFT COPY — review before launch */
/* TM-10 Deliver — the evidence locker. One folder per hand-over from data/technology-intelligence.php,
   each with its format, an illustrative file count and three representative filenames so the artefacts
   read as real work rather than a bullet list. Folders lift on hover and focus; CSS only, no JS. */

$tscd_items = $CAP['deliver'];
/* index => [icon, illustrative file count, three representative filenames] */
$tscd_extra = [
    ['layers', 12, ['threat-model-checkout-v3.md', 'trust-boundaries.drawio', 'architecture-review.pdf']],
    ['bug',     9, ['pentest-web-2026-q1.pdf', 'redteam-assistant-llm01.json', 'retest-summary.pdf']],
    ['target',  5, ['risk-register.xlsx', 'remediation-board.csv', 'exceptions-approved.pdf']],
    ['pipeline',14, ['security-gates.yml', 'sbom-policy.rego', 'secret-scan-baseline.json']],
    ['doc',    18, ['information-security-policy.pdf', 'ai-use-policy.pdf', 'access-control-standard.pdf']],
    ['clipboard-check', 7, ['control-matrix.xlsx', 'statement-of-applicability.pdf', 'evidence-index.csv']],
    ['alert',  11, ['ir-playbook-ransomware.md', 'ir-playbook-data-breach.md', 'cert-in-notification.md']],
];
$tscd_total = 0;
foreach ($tscd_extra as $tscd_x) { $tscd_total += $tscd_x[1]; }
?>
<section class="band tsc-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-10</b><span>Hand-over</span></p>
        <h2 class="h2" id="deliver-t"><span class="g">What you keep</span> when the engagement ends.</h2>
      </div>
      <div>
        <p class="lead">Everything lands in your tenancy, in formats your team and your auditor can open without us. No portal you have to keep paying for, no report that only makes sense while we are in the room.</p>
      </div>
    </div>

    <div class="tsc-lk" data-rv>
      <div class="tsc-lk__bar">
        <p class="tsc-lk__bk"><span class="tsc-led tsc-led--ping" aria-hidden="true"></span>Evidence locker · your tenancy</p>
        <p class="tsc-lk__bn tsc-mono"><b data-bdh-count><?= $tscd_total ?></b> artefacts · <?= count($tscd_items) ?> folders · versioned</p>
        <p class="tsc-lk__bi"><span class="tsc-ill">Illustrative counts</span></p>
      </div>

      <ul class="tsc-lk__grid" data-rv-s data-rv-step="60" role="list">
        <?php foreach ($tscd_items as $tscd_i => $tscd_it):
            $tscd_x = $tscd_extra[$tscd_i] ?? ['doc', 6, []]; ?>
          <li class="tsc-lk__f" style="--i:<?= $tscd_i ?>">
            <span class="tsc-lk__tab" aria-hidden="true"></span>
            <div class="tsc-lk__fh">
              <span class="tsc-lk__fico" aria-hidden="true"><?= xt_icon($tscd_x[0], ['size' => 18]) ?></span>
              <p class="tsc-lk__fn tsc-mono"><?= str_pad((string) ($tscd_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
              <p class="tsc-lk__fc tsc-mono"><?= $tscd_x[1] ?> files</p>
            </div>
            <h3 class="tsc-lk__ft"><?= e($tscd_it[0]) ?></h3>
            <p class="bdh-tag bdh-tag--blue tsc-lk__fmt"><?= e($tscd_it[1]) ?></p>
            <ul class="tsc-lk__files" role="list" aria-label="Representative files">
              <?php foreach ($tscd_x[2] as $tscd_f): ?>
                <li><span class="tsc-lk__doc" aria-hidden="true"></span><?= e($tscd_f) ?></li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="bdh-sr">Illustrative evidence locker. The seven hand-overs are drawn as labelled folder tiles, each showing its format, an illustrative file count and three representative filenames. Every folder's contents are listed in full above; the drawing adds nothing the text does not already say.</p>

      <div class="tsc-lk__foot">
        <ul class="tsc-lk__rules" role="list">
          <li><span class="tsc-tick" aria-hidden="true"></span><span class="tsc-lk__rt"><b>Open formats.</b> Markdown, PDF, CSV, YAML and diagram sources &#8212; nothing locked to a tool you do not own.</span></li>
          <li><span class="tsc-tick" aria-hidden="true"></span><span class="tsc-lk__rt"><b>In your systems.</b> Your repository, your document store, your GRC tool. We work inside them rather than beside them.</span></li>
          <li><span class="tsc-tick" aria-hidden="true"></span><span class="tsc-lk__rt"><b>Kept current by the pipeline.</b> Scan results, SBOMs and gate outcomes are written on every build, so the pack does not age between audits.</span></li>
          <li><span class="tsc-tick" aria-hidden="true"></span><span class="tsc-lk__rt"><b>Findings redacted for sharing.</b> A customer-safe summary sits beside the full technical report, so security questionnaires stop being a rewrite.</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>
