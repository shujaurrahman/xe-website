<?php /* DRAFT COPY — review before launch */
/* FAQ — twelve questions, taken verbatim from the capability data so the hub and the capability pages
   can never answer the same question two different ways. Each row carries the capability it came from,
   as a link to that capability's card in #capabilities.
   The core [data-acc] accordion does the work — this page allows several rows open at once — and the
   <noscript> rule below leaves every answer open when there is no JavaScript. */
$faq_pick = [
    ['design-consulting-solutioning', 0],
    ['design-consulting-solutioning', 1],
    ['product-strategy-vision', 0],
    ['product-strategy-vision', 2],
    ['experience-design-development', 0],
    ['experience-design-development', 2],
    ['experience-design-development', 3],
    ['experience-design-development', 4],
    ['ai-product-strategy-development', 0],
    ['system-design', 0],
    ['system-design', 2],
    ['design-consulting-solutioning', 4],
];
$faq_items = [];
foreach ($faq_pick as $faq_p) {
    $faq_c = $CAPS[$faq_p[0]] ?? null;
    if (!$faq_c || !isset($faq_c['faq'][$faq_p[1]])) continue;
    $faq_items[] = ['q' => $faq_c['faq'][$faq_p[1]][0], 'a' => $faq_c['faq'][$faq_p[1]][1], 'cap' => $faq_c];
}
/* the commercial facts people want before they write in.
   PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch */
$faq_facts = [
    ['First reply',    'One working day, from a designer'],
    ['First call',     '45 minutes, and we will ask about the decision, not the budget'],
    ['Under NDA',      'Signed before anything of yours is shared'],
    ['Outline plan',   'Scope, shape and a price range within a week'],
];
?>
<noscript><style>.pxh-faq__p{height:auto;overflow:visible}.pxh-faq__sign{display:none}</style></noscript>
<section class="band pxh-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Product and experience design,</span> asked directly.</h2>
      </div>
      <div>
        <p class="lead">Twelve questions we are asked most, answered in the same words on every page of this discipline. Each one says which capability it belongs to.</p>
      </div>
    </div>

    <div class="pxh-faq__list" data-acc="multi" data-rv data-rv-d="60">
      <?php foreach ($faq_items as $faq_i => $faq_q): $faq_open = $faq_i === 0; ?>
        <div class="pxh-faq__row">
          <p class="pxh-faq__side">
            <span class="pxh-faq__n" aria-hidden="true">Q<?= str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <a class="pxh-capl" href="#<?= e($faq_q['cap']['slug']) ?>"><b><?= e($faq_q['cap']['n']) ?></b><span><?= e($faq_q['cap']['short']) ?></span><i aria-hidden="true">›</i></a>
          </p>
          <h3 class="pxh-faq__hq">
            <button class="pxh-faq__q" type="button" data-acc-b aria-expanded="<?= $faq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $faq_i ?>" id="faq-q<?= $faq_i ?>">
              <span class="pxh-faq__t"><?= e($faq_q['q']) ?></span>
              <span class="pxh-faq__sign" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="pxh-faq__p<?= $faq_open ? ' is-open' : '' ?>" id="faq-a<?= $faq_i ?>" role="region" aria-labelledby="faq-q<?= $faq_i ?>" data-acc-p>
            <p class="pxh-faq__a"><?= e($faq_q['a']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pxh-faq__foot" data-rv>
      <div class="pxh-faq__ways">
        <p class="pxh-k">Two ways forward</p>
        <p class="pxh-faq__wt">Ask the designers who would run it, or put your own bet through the proof first.</p>
        <div class="pxh-faq__act">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'product-experience')) ?>">Start a product brief <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#proving">Try the Proving Ground <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
      <!-- PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch -->
      <dl class="pxh-faq__facts">
        <?php foreach ($faq_facts as $faq_f): ?>
          <div><dt><?= e($faq_f[0]) ?></dt><dd><?= e($faq_f[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
  </div>
</section>
