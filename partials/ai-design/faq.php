<?php /* DRAFT COPY — review before launch */
/* FAQ — native <details>, so every answer works without JS. Left rail: the way forward. */
$aih_faq = [
    ['Which AI models do you use?', 'The ones that win on your evaluation set. We work across Gemini, OpenAI, Anthropic, Mistral and open-weight families for language, and Flux, Adobe Firefly, Runway, Veo and ElevenLabs for image, film and voice. Every lane has a fallback, so a model change is a configuration decision.'],
    ['Who owns the prompts, the evaluation sets and the model weights?', 'You do. They live in your repositories and cloud accounts from the first week, and the intellectual property is assigned to you as it is created. A tuned brand model is yours to run, retrain or retire.'],
    ['How is AI Design different from the AI work in Technology & Intelligence?', 'Technology & Intelligence engineers AI into business systems: agents, retrieval, infrastructure and production evaluation. AI Design shapes what people meet: the conversation, the controls, the generated content and the models that learn your brand. Many engagements use both.'],
    ['What is the difference between this Brand AI Tools and the one in Brand Design?', 'Ours builds the custom-tuned generative models that produce on-brand assets. Brand Design’s builds the governance tooling that checks any asset against the brand system. One makes, the other checks; they meet at the scoring step.'],
    ['How do you handle rights in generated content?', 'Inputs are cleared before they are used: licensed or owned imagery, consented voices, and nothing scraped. Outputs carry content credentials and an audit record of the model, inputs and approver. Where a platform’s terms limit commercial use, we say so before it is chosen.'],
    ['Does the EU AI Act apply to our marketing content?', 'Its transparency duties can: people must be told when they talk to a chatbot, and synthetic image, audio and video must be marked as such. We classify each system at the start and design disclosure into the interface rather than adding it at the end.'],
    ['Can our data stay in our own cloud or region?', 'Yes. We use enterprise endpoints with training on your data switched off, and where material may not leave your network we run open-weight models in your own cloud account, including India regions.'],
];
?>
<section class="band aih-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap aih-faq__grid">
    <div class="aih-faq__rail">
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">Asked plainly,</span> answered plainly.</h2>
      <p class="p">What buyers ask before an AI Design engagement. Anything else, ask a designer directly.</p>
      <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'ai-design')) ?>">Ask the team <span class="i" aria-hidden="true"></span></a>
    </div>
    <div class="aih-faq__list">
      <?php foreach ($aih_faq as $aih_i => $aih_q): ?>
        <details class="aih-faq__i"<?= $aih_i === 0 ? ' open' : '' ?>>
          <summary><span><?= e($aih_q[0]) ?></span><span class="aih-faq__pm" aria-hidden="true"></span></summary>
          <p><?= e($aih_q[1]) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
