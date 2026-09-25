<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions this discipline is actually asked, with the approved answers from
   data/marketing-technology.php (each one belongs to a capability, and the answer is quoted as written).
   A sticky rail on the left carries the two ways forward and the commercial facts people want before they
   write in; an accordion on the right uses the core [data-acc] behaviour, so no section script is needed
   and the <noscript> rule below leaves every answer open without JavaScript. */
$faq_pick = [
    // [capability slug, the question to quote, related capability slugs for the chips]
    ['customer-relationship-strategy', 'Is this one service or five?',                                   ['customer-relationship-strategy', 'ai-driven-marketing-automation']],
    ['ai-driven-marketing-automation', 'Do we need to change our marketing automation platform?',        ['ai-driven-marketing-automation', 'content-communication-infrastructure']],
    ['ai-driven-marketing-automation', 'Where does AI actually decide something?',                       ['ai-driven-marketing-automation', 'ai-campaign-optimization']],
    ['ai-driven-marketing-automation', 'Who approves what goes out?',                                    ['ai-driven-marketing-automation', 'ai-creative-solutions']],
    ['ai-driven-marketing-automation', 'How do you handle consent and preferences?',                     ['ai-driven-marketing-automation', 'customer-relationship-strategy']],
    ['ai-campaign-optimization',       'Does signal loss from privacy changes break this?',              ['ai-campaign-optimization']],
    ['ai-campaign-optimization',       'Attribution, incrementality or mix modelling — which do we need?', ['ai-campaign-optimization']],
    ['ai-lead-generation',             'Do you buy contact lists?',                                      ['ai-lead-generation', 'automated-dynamic-sales']],
    ['ai-creative-solutions',          'Is our brand or customer data used to train public models?',     ['ai-creative-solutions', 'ai-driven-marketing-automation']],
    ['ai-lead-generation',             'Where does all of this live?',                                   ['ai-lead-generation', 'automated-dynamic-sales']],
];
$faq_items = [];
foreach ($faq_pick as $faq_p) {
    foreach ($CAPS[$faq_p[0]]['faq'] as $faq_q) {
        if ($faq_q[0] === $faq_p[1]) { $faq_items[] = ['q' => $faq_q[0], 'a' => $faq_q[1], 'rel' => $faq_p[2], 'from' => $faq_p[0]]; break; }
    }
}
/* what happens when you write in — the commercial facts people look for before they do
   PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch */
$faq_facts = [
    ['First reply',  'One working day, from someone who would work on it'],
    ['First call',   '45 minutes, no slide deck'],
    ['Under NDA',    'Signed before anything about your data is shared'],
    ['Outline plan', 'Scope, shape and a price range within a week'],
];
?>
<noscript><style>.mth-faq__p{height:auto;overflow:visible}.mth-faq__plus{display:none}</style></noscript>
<section class="band mth-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid mth-faq__grid">
    <div class="bdh-c4 mth-faq__side">
      <div class="bdh-sticky mth-faq__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Marketing Technology,</span> asked directly.</h2>
        <p class="mth-faq__more">Anything else? Ask the people who would run your programme, or see a journey take shape first.</p>
        <div class="mth-faq__act">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'marketing-technology')) ?>">Ask the team <span class="i" aria-hidden="true">›</span></a>
          <a class="tl mth-faq__tl" href="#studio">Open the Journey Studio <span class="i" aria-hidden="true">›</span></a>
        </div>
        <!-- PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch -->
        <dl class="mth-faq__facts">
          <?php foreach ($faq_facts as $faq_f): ?>
            <div><dt><?= e($faq_f[0]) ?></dt><dd><?= e($faq_f[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 mth-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($faq_items as $faq_i => $faq_it): $faq_n = str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT); $faq_open = $faq_i === 0; ?>
        <div class="mth-faq__row">
          <h3 class="mth-faq__hq">
            <button class="mth-faq__q" type="button" data-acc-b aria-expanded="<?= $faq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $faq_i ?>" id="faq-q<?= $faq_i ?>">
              <span class="mth-faq__n" aria-hidden="true">Q<?= $faq_n ?></span>
              <span class="mth-faq__t"><?= e($faq_it['q']) ?></span>
              <span class="mth-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="mth-faq__p<?= $faq_open ? ' is-open' : '' ?>" id="faq-a<?= $faq_i ?>" role="region" aria-labelledby="faq-q<?= $faq_i ?>" data-acc-p>
            <div class="mth-faq__a">
              <p><?= e($faq_it['a']) ?></p>
              <p class="mth-faq__rel"><span class="mth-k">Related</span><?php foreach ($faq_it['rel'] as $faq_rs): $faq_rc = $CAPS[$faq_rs]; ?><a class="mth-capl" href="<?= e(($MTH['cap_href'])($faq_rs)) ?>"><b><?= e($faq_rc['n']) ?></b><?= e($faq_rc['short']) ?><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
