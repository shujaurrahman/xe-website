<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions buyers actually open with, grouped by what they are worried about: the rights and
   the law, the models and the tools, and how the work runs with their team. Answers are the approved
   copy from the capability FAQs in data/ai-design.php, at hub level.
 *
 * Deliberately not the Technology hub's sticky-rail FAQ: three labelled groups, each its own core
 * [data-acc] accordion, so one answer stays open per group rather than one for the whole page. Every
 * answer ends with the capability it belongs to, as an anchor on this page.
 *
 * The <noscript> rule leaves every answer open, because the core accordion is what closes them.
 */
$fq_groups = [
    [
        'n'    => '01',
        'name' => 'Rights, disclosure and the law',
        'items' => [
            ['Can we use generative content commercially?',
             'It depends on the tool’s licence and on how the model was trained. We record the licence and indemnity position for every tool before production, prefer tools with commercial terms and an indemnity where the exposure warrants it, and put anything borderline in front of your counsel.',
             ['ai-content-studio'], 'the legal review step with the client’s counsel'],
            ['Do we have to disclose that content is AI-generated?',
             'Often, yes. The EU AI Act requires synthetic image, audio and video to be marked in a machine-readable way, with deepfakes disclosed. Several platforms require a label of their own. We attach C2PA Content Credentials where they are supported and agree a disclosure standard with you before production.',
             ['ai-content-studio']],
            ['Can the model generate a real person or a competitor’s brand?',
             'No. Guardrails block named people without recorded consent, and third-party marks, and every output is logged. Misuse testing is part of release rather than an afterthought.',
             ['brand-ai-tools']],
            ['Which regulations apply to marketing use of AI?',
             'Commonly the EU AI Act’s transparency duties for synthetic content, GDPR and India’s DPDP Act 2023 for personal data used in targeting or training, advertising codes on misleading claims, and each platform’s own labelling rules. We map which apply in your markets and prepare the position with your counsel.',
             ['ai-strategy-consulting']],
        ],
    ],
    [
        'n'    => '02',
        'name' => 'Models, tools and ownership',
        'items' => [
            ['Which tools do you use?',
             'It depends on the output. Image work often uses Flux, Adobe Firefly or Midjourney; film uses Runway or Veo; voice uses ElevenLabs; language uses Gemini, OpenAI or Anthropic models. We choose per output on evidence, and we hold no partner badges.',
             ['ai-content-studio']],
            ['Do you design for one model or several?',
             'The interface is designed to be model-agnostic. We prototype on the models that suit the task, including Gemini, OpenAI, Anthropic, Mistral and open-weight families, and design so that changing model is a configuration decision rather than a redesign.',
             ['ai-application-design']],
            ['Who owns the trained model?',
             'You do. Weights, adapters, datasets, prompts and logs are delivered into your accounts. We do not retain them and we do not train anything else on them.',
             ['brand-ai-tools']],
            ['How much material do we need to tune a model?',
             'Less than most people expect for style, more than most expect for likeness. A style adapter can work from a few dozen consistent, well-labelled images; product or person likeness needs controlled, varied captures. We test on a small set first and tell you plainly if the material is not there.',
             ['brand-ai-tools'], 'dataset guidance with the delivery team'],
            ['Will everything look like AI?',
             'Only if nobody directs it. Output drifts toward a model’s default look unless art direction, a brand-tuned model and a review step pull it back. That is what the direction and the brand model are for.',
             ['ai-content-studio', 'brand-ai-tools']],
        ],
    ],
    [
        'n'    => '03',
        'name' => 'Working together',
        'items' => [
            ['How is this different from the AI work in Technology &amp; Intelligence?',
             'That discipline engineers AI into business systems: agents, retrieval, infrastructure and production evaluation. AI Design shapes the experience people meet — the conversation, the controls and the way trust is earned on screen. On larger programmes the two run together, with design setting the acceptance criteria and engineering meeting them.',
             ['ai-application-design']],
            ['Can you work with our engineers rather than build it?',
             'Yes. Most engagements end in a specification, components and a prompt set your team builds against. Where you need hands, engineers can join the build through Technology &amp; Intelligence.',
             ['ai-application-design']],
            ['Can an AI interface be accessible?',
             'It has to be. We design to WCAG 2.2 AA: streaming output announced to assistive technology, keyboard control of every agent action, no meaning carried by motion alone, and a typed equivalent for every voice interaction.',
             ['ai-application-design']],
            ['Does this replace photography and film?',
             'No. It changes what is worth shooting. Hero work, real people and real places are still photographed; the variants, formats, markets and the long tail are produced in the studio from that material.',
             ['ai-content-studio']],
            ['Will this cost people their jobs?',
             'We plan for redeployment rather than headcount reduction, and we say so in the diagnostic. What we see is output rising and the work moving up: more direction, review and judgement, less repetition. Anything more specific would be a guess about your business.',
             ['ai-strategy-consulting'], 'this position with leadership'],
        ],
    ],
];
$fq_i = 0;
?>
<noscript><style>
  .aih-fq__p{height:auto;overflow:visible}
  .aih-fq__plus{display:none}
</style></noscript>
<section class="band aih-fq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">AI Design,</span> asked directly.</h2>
      </div>
      <div>
        <p class="lead">Grouped by what people are actually worried about. Anything else, ask the team who would run the work — the first conversation is a conversation, not a deck.</p>
        <div class="aih-fq__act">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'ai-design')) ?>">Ask the team <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#run">Open a generation run <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <div class="aih-fq__groups">
      <?php foreach ($fq_groups as $fq_g): ?>
        <div class="aih-fq__g" role="group" aria-labelledby="faq-g<?= e($fq_g['n']) ?>">
          <p class="aih-fq__gt" id="faq-g<?= e($fq_g['n']) ?>"><span class="bdh-idx"><?= e($fq_g['n']) ?></span><?= $fq_g['name'] ?></p>
          <div class="aih-fq__list" data-acc data-rv data-rv-d="50">
            <?php foreach ($fq_g['items'] as $fq_k => $fq_q): $fq_i++; $fq_open = $fq_k === 0; ?>
              <?php if (!empty($fq_q[3])): ?><!-- PLACEHOLDER: confirm <?= e($fq_q[3]) ?> before launch --><?php endif; ?>
              <div class="aih-fq__row">
                <h3 class="aih-fq__hq">
                  <button class="aih-fq__q" type="button" data-acc-b aria-expanded="<?= $fq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $fq_i ?>" id="faq-q<?= $fq_i ?>">
                    <span class="aih-fq__t"><?= $fq_q[0] ?></span>
                    <span class="aih-fq__plus" aria-hidden="true"></span>
                  </button>
                </h3>
                <div class="aih-fq__p<?= $fq_open ? ' is-open' : '' ?>" id="faq-a<?= $fq_i ?>" role="region" aria-labelledby="faq-q<?= $fq_i ?>" data-acc-p>
                  <div class="aih-fq__a">
                    <p><?= $fq_q[1] ?></p>
                    <p class="aih-fq__rel">
                      <span class="aih-k">Covered in</span>
                      <?php foreach ($fq_q[2] as $fq_s): ?>
                        <a class="aih-caplink" href="#<?= e($fq_s) ?>"><b><?= e($CAPS[$fq_s]['n']) ?></b><span><?= e($CAPS[$fq_s]['name']) ?></span><i aria-hidden="true">›</i></a>
                      <?php endforeach; ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
