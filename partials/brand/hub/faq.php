<?php /* DRAFT COPY — review before launch (questions 4, 6, 7 and 8 are new) */
/* FAQ — split layout; questions are Outfit headings inside the core [data-acc] accordion. */
$faq_items = [
    ['Where do most brand engagements start?', 'With Brand Foundation, because it is the cheapest place to be wrong. When the foundation already holds, Identity or Growth Strategy are the usual next steps.'],
    ['Can we buy one capability on its own?', 'Yes. Each of the six is scoped and priced as a sprint of its own. What changes is that the work is built to plug into the rest of the system when you are ready.'],
    ['Do you rebrand, or only build new brands?', 'Both. Most of our work is a brand that already exists and needs a sharper system around it. A new mark is the exception, not the rule.'],
    // PLACEHOLDER: confirm timeframes before launch
    ['How long does an enterprise brand programme take?', 'Typically four to six months from discovery to first rollout, longer for multi-market portfolios. A single capability sprint usually runs three to ten weeks. We scope it with you before anything starts.'],
    ['How do you use AI in brand work?', 'Research at volume, production at scale and the checks no team can do by hand. The decisions, and the taste, stay with people. Brand AI Tools is where the two meet.'],
    ['Can the AI tools run inside our own environment?', 'Yes. Models, pipelines and logs can be deployed into your cloud accounts under your security policies. Where that is not possible, data handling is agreed in writing before any asset is shared.'],
    ['Will you work alongside our existing agencies?', 'Yes. We often build the system and your agencies produce on it. Templates, checks and guidelines are designed so partners can ship on brand without routing everything through us.'],
    ['How do you handle procurement, legal and security reviews?', 'We expect them. An NDA before discovery, a statement of work per phase, and early answers to your security questionnaire, so review runs alongside the work instead of in front of it.'],
    ['What do we own at the end?', 'Everything. Source files, tokens, templates, guidelines, model weights and logs ship into your accounts. Nothing is retained, resold or trained on elsewhere.'],
];
?>
<section class="band band--alt bdh-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid bdh-faq__grid">
    <div class="bdh-c4 bdh-faq__side">
      <div class="bdh-sticky bdh-faq__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Brand Design,</span> asked directly.</h2>
        <p class="bdh-faq__more">Anything else? Ask the people who would run your programme.</p>
        <a class="btn btn--out" href="<?= xe_url('contact.php') ?>">Ask the team directly <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 bdh-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($faq_items as $faq_i => $faq_q): $faq_n = str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT); ?>
        <div class="bdh-faq__row">
          <h3 class="bdh-faq__hq">
            <button class="bdh-faq__q" type="button" data-acc-b aria-expanded="false" aria-controls="faq-a<?= $faq_i ?>" id="faq-q<?= $faq_i ?>">
              <span class="bdh-faq__n" aria-hidden="true"><?= $faq_n ?></span>
              <span class="bdh-faq__t"><?= e($faq_q[0]) ?></span>
              <span class="bdh-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="bdh-faq__p" id="faq-a<?= $faq_i ?>" role="region" aria-labelledby="faq-q<?= $faq_i ?>" data-acc-p>
            <p><?= e($faq_q[1]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
