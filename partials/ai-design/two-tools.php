<?php /* DRAFT COPY — review before launch */
/* Two tools — "Brand AI Tools" is a capability of both Brand Design and AI Design. A flow diagram (.aih-flow,
   the discipline's diagram idiom) shows where each sits, and a comparison table says it in words. */
$aih_bd_url = xe_url('services/brand-design/brand-ai-tools.php');
$aih_rows = [
    ['What it is',      'Custom-tuned generative models: image, product and language models trained on your rights-cleared material.', 'Brand governance tooling: the rules, checks and templates that keep every output on brand.'],
    ['What it produces','New assets that already look and sound like the brand.', 'A verdict on any asset, from any source: on brand, off brand, and why.'],
    ['Built with',      'Flux, Adobe Firefly, ComfyUI and open-weight model families, tuned and scored.', 'The brand system, encoded as tokens, rules and a brand-check agent.'],
    ['You own',         'The dataset, the scoring set and the model weights.', 'The rulebook, the templates and the checking workflow.'],
    ['Start here when', 'Generation is off brand, slow or dependent on a few people.', 'Output from many teams and tools is drifting away from the brand.'],
];
?>
<section class="band aih-two" id="two-tools" aria-labelledby="two-tools-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Brand AI Tools, twice</p>
        <h2 class="h2" id="two-tools-t"><span class="g">One name, two jobs.</span> Models that make, and rules that check.</h2>
      </div>
      <div><p class="lead">Brand Design owns the brand system and the governance that enforces it. AI Design builds the models that learn it. Most brands at scale need both, joined at the scoring step.</p></div>
    </div>

    <div class="aih-two__dg" role="group" aria-label="Diagram: where each Brand AI Tools capability sits">
      <div class="aih-flow">
        <div class="aih-node"><span class="aih-node__k">Brand Design</span><span class="aih-node__t">Brand system</span><p class="aih-node__d">Identity, voice, tokens and rules.</p></div>
        <span class="aih-edge" aria-hidden="true"></span>
        <div class="aih-node aih-node--blue"><span class="aih-node__k">AI Design · Brand AI Tools</span><span class="aih-node__t">Brand-tuned models</span><p class="aih-node__d">Trained on the system, scored against it.</p></div>
        <span class="aih-edge" aria-hidden="true"></span>
        <div class="aih-node"><span class="aih-node__k">Brand Design · Brand AI Tools</span><span class="aih-node__t">Governance checks</span><p class="aih-node__d">Every asset checked, from any source.</p></div>
        <span class="aih-edge" aria-hidden="true"></span>
        <div class="aih-node aih-node--ghost"><span class="aih-node__k">A named person</span><span class="aih-node__t">Approved asset</span><p class="aih-node__d">Signed, logged, published.</p></div>
      </div>
    </div>

    <div class="aih-two__tbl">
      <table class="aih-cmp" aria-label="Comparison of the two Brand AI Tools capabilities">
        <colgroup><col class="aih-cmp__c1"><col><col></colgroup>
        <thead>
          <tr><th scope="col"><span class="bdh-sr">Question</span></th><th scope="col">AI Design · Brand AI Tools</th><th scope="col">Brand Design · Brand AI Tools</th></tr>
        </thead>
        <tbody>
          <?php foreach ($aih_rows as $aih_r): ?>
            <tr><th scope="row"><?= e($aih_r[0]) ?></th><td data-l="AI Design"><?= e($aih_r[1]) ?></td><td data-l="Brand Design"><?= e($aih_r[2]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr><td></td>
            <td><a class="tl" href="<?= e(xe_url('services/ai-design/brand-ai-tools.php')) ?>">Brand-tuned models <span class="i" aria-hidden="true"></span></a></td>
            <td><a class="tl" href="<?= e($aih_bd_url) ?>">Brand governance tooling <span class="i" aria-hidden="true"></span></a></td></tr>
        </tfoot>
      </table>
    </div>
  </div>
</section>
