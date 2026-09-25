<?php /* DRAFT COPY — review before launch */
/* Standards — the frameworks this discipline's delivery is built to, and which capability each one
   actually bites on. The badge keys and the matrix are read straight out of the 'standards' arrays in
   data/ai-design.php, so the page and the content can never disagree.
 *
 * Framing, and it matters: these are frameworks we build to or align delivery with. Nothing here says
 * Xterra Edze holds a certification. Where a certificate is needed it comes from an independent
 * auditor, and the badges are code-built marks, never official seal artwork.
 */
$sd_keys = ['eu-ai-act', 'iso42001', 'nist-ai-rmf', 'owasp-llm', 'wcag22', 'gdpr', 'dpdp'];
$sd_all  = xt_standards();
$sd_keys = array_values(array_filter($sd_keys, fn ($sd_k) => isset($sd_all[$sd_k])));

/* the matrix: capability × standard, from the approved data */
$sd_caps = [];
foreach ($CAPS as $sd_s => $sd_c) { $sd_caps[$sd_s] = ['short' => $sd_c['short'], 'n' => $sd_c['n'], 'std' => $sd_c['standards']]; }
?>
<section class="band aih-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">Seven frameworks</span> that change what the work actually contains.</h2>
      </div>
      <div>
        <p class="lead">These are the ones that genuinely apply to designing AI into brand and customer experience: an AI management system, an AI risk framework, the transparency law, the LLM security list, the accessibility standard, and two data protection regimes. None of them is a security certification borrowed from work that does not involve it.</p>
        <p class="aih-note">Marks below are drawn in code, never official seal artwork. Where a certificate is required it comes from an independent auditor, not from us.</p>
      </div>
    </div>

    <ul class="xt-badges aih-std__wall" role="list" data-rv data-rv-d="50">
      <?php foreach ($sd_keys as $sd_k): ?>
        <?= xt_badge($sd_k, ['tag' => 'li', 'detail' => true, 'apply' => true, 'class' => 'aih-std__b']) ?>
      <?php endforeach; ?>
    </ul>

    <div class="aih-std__matrix" data-rv data-rv-d="70">
      <div class="aih-std__mh">
        <h3 class="aih-std__mt">Which one bites on which capability</h3>
        <p class="aih-std__md">Read down a column to see what a single capability has to satisfy. Nothing is attached to work it does not apply to.</p>
      </div>
      <div class="aih-panel aih-panel--flat aih-std__panel">
        <div class="aih-panel__bar">
          <span class="aih-panel__title">matrix <i>/</i> framework by capability</span>
        </div>
        <div class="aih-panel__body">
        <p class="aih-note aih-std__hint">The table scrolls sideways on a narrow screen.</p>
        <div class="bdh-scroll-x aih-std__wrap" tabindex="0" role="group" aria-label="Standards by capability, scroll sideways on a narrow screen">
        <table class="aih-ledger aih-std__tbl">
          <thead>
            <tr>
              <th scope="col">Framework</th>
              <?php foreach ($sd_caps as $sd_c): ?><th scope="col"><?= e($sd_c['n']) ?> · <?= e($sd_c['short']) ?></th><?php endforeach; ?>
              <th scope="col">What it governs here</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sd_keys as $sd_k): $sd_s = $sd_all[$sd_k]; ?>
              <tr>
                <th scope="row"><?= e($sd_s['code']) ?></th>
                <?php foreach ($sd_caps as $sd_c): $sd_on = in_array($sd_k, $sd_c['std'], true); ?>
                  <td class="aih-std__c">
                    <?php if ($sd_on): ?>
                      <span class="aih-std__on" aria-hidden="true"></span><span class="bdh-sr">Applies</span>
                    <?php else: ?>
                      <span class="aih-std__off" aria-hidden="true">—</span><span class="bdh-sr">Does not apply</span>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>
                <td><?= e($sd_s['kind']) ?> · <?= e($sd_s['name']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
        </div>
      </div>
      <p class="aih-std__also"><span class="aih-k aih-k--ink">Also relevant</span>C2PA Content Credentials are a provenance specification rather than a framework we are assessed against, so they are not badged here. We attach them to generated output wherever the tool and the platform support them, and keep the record ourselves where they do not.</p>
    </div>
  </div>
</section>
