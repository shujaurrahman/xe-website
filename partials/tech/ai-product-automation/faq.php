<?php /* DRAFT COPY — review before launch */
/* 04.12 FAQ — asked directly, answered like the assistants on this page: every answer cites its sources, and
   the sources are the sections above where the thing is shown working (§04.x chips link to them). Accordion
   via core [data-acc]; one open at a time. Questions merge the brief with $CAP['faq']. */
$tapq_src = [   // anchor => label
    'inspector' => ['04.2', 'RAG inspector'], 'conversation' => ['04.3', 'Conversation'], 'vision' => ['04.4', 'Vision'],
    'automation' => ['04.5', 'Automation'], 'stack' => ['04.6', 'Stack'], 'quality' => ['04.7', 'Quality gates'],
    'efficiency' => ['04.8', 'Cost & energy'], 'process' => ['04.9', 'Process'], 'outcomes' => ['04.11', 'Outcomes'],
];
$tapq_faq = [   // [question, answer, [source anchors]]
    ['Will it make things up?',
     'Any language model can produce a fluent sentence that is wrong, so the design assumes it will try. Answers are generated only from retrieved sources, every sentence must cite one, a check after generation removes sentences that do not, and a faithfulness gate blocks any release that scores under 0.90 on your golden set. When the sources are missing or disagree, the assistant says so and hands over to a person.',
     ['inspector', 'quality']],
    [$CAP['faq'][0][0], $CAP['faq'][0][1], ['inspector', 'stack']],
    ['Can it use our private documents securely?',
     'Yes. Documents are indexed with their permissions, and every search is filtered by what the person asking is allowed to open, so the model never sees a passage the user could not read. Data stays in your cloud or with providers under enterprise terms that exclude training on your data. Personal data is redacted before anything is logged, and every answer is traced for audit.',
     ['conversation', 'stack']],
    ['Which model do you use?',
     'The one that wins on your golden set for quality, latency and cost, which is rarely a single model. A small model classifies and routes, a larger one drafts, and an open-weight model can serve as the fallback or as the whole stack when data must stay put. Models sit behind adapters we own, so changing one is a configuration change and an eval run.',
     ['stack', 'efficiency']],
    ['Can it run in India?',
     'Yes. Hosted models are available from Indian cloud regions for a growing list of providers, and open-weight models can run on GPUs in an Indian data centre or in your own VPC, so documents, prompts and logs stay in the country. We map the design against the DPDP Act 2023 and sector rules such as RBI requirements for payment data before anything is built.',
     ['stack']],
    [$CAP['faq'][2][0], $CAP['faq'][2][1], ['stack', 'efficiency']],
    [$CAP['faq'][1][0], $CAP['faq'][1][1] . ' After launch the same measures run on a daily sample of production answers, beside the business numbers the feature was built to move.',
     ['inspector', 'quality', 'outcomes']],
    ['What happens when the model changes?',
     'Model versions are pinned, never “latest”. A provider update, a deprecation or a better open model is treated as a release: it runs the full gates in CI, then a canary to 5% of traffic, widening only while production groundedness holds. If a number slips, the flag rolls back to the last good version automatically.',
     ['quality', 'outcomes']],
    [$CAP['faq'][4][0], $CAP['faq'][4][1], ['efficiency']],
    [$CAP['faq'][3][0], $CAP['faq'][3][1], ['stack']],
];
?>
<section class="band band--alt tap-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="tap-fq">
      <div class="tap-fq__side" data-rv>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.12</span><span>Questions</span><span class="tap-eb__p">/faq</span></p>
        <h2 class="h2 tap-fq__h" id="faq-t"><span class="g">AI Product &amp; Automation,</span> asked directly.</h2>
        <p class="lead tap-fq__lead">Answered the way our assistants answer: with sources. Each answer points to the section of this page where you can see it working.</p>
        <div class="tap-fq__ask">
          <p class="tap-fq__askt"><?= xt_icon('chat', ['size' => 18]) ?>Not answered here?</p>
          <p class="tap-fq__askd">Bring it to a scoping call. We will answer it against your own documents and data.</p>
          <a class="tl" href="<?= xe_url('contact.php') ?>">Scope an AI feature <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

      <div class="tap-fq__list" data-acc data-rv>
        <?php foreach ($tapq_faq as $tapq_i => $tapq_f): ?>
          <div class="tap-fq__item">
            <h3 class="tap-fq__q">
              <button type="button" data-acc-b id="faq-b<?= $tapq_i ?>" aria-expanded="<?= $tapq_i === 0 ? 'true' : 'false' ?>" aria-controls="faq-p<?= $tapq_i ?>">
                <span class="tap-fq__n" aria-hidden="true">Q<?= sprintf('%02d', $tapq_i + 1) ?></span>
                <span class="tap-fq__qt"><?= e($tapq_f[0]) ?></span>
                <span class="tap-fq__pm" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="tap-fq__a" id="faq-p<?= $tapq_i ?>" role="region" aria-labelledby="faq-b<?= $tapq_i ?>" data-acc-p>
              <div class="tap-fq__ai">
                <p><?= e($tapq_f[1]) ?></p>
                <p class="tap-fq__src"><span class="tap-fq__sk">Sources on this page</span>
                  <?php foreach ($tapq_f[2] as $tapq_s): ?>
                    <a class="tap-fq__chip" href="#<?= e($tapq_s) ?>"><b>§<?= e($tapq_src[$tapq_s][0]) ?></b><?= e($tapq_src[$tapq_s][1]) ?></a>
                  <?php endforeach; ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
