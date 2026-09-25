<?php /* DRAFT COPY — review before launch */
/* Premise — what actually changed, and what each change asks in return. Four rows, each read left to
   right: what the work used to be, what is now possible, and the obligation that comes with it. No
   motion beyond the shared reveal: the argument is the component. */
$pr_rows = [
    [
        'Imagery and film',
        'A shoot for the hero work and a compromise for everything after it. Every extra market, format or product variant cost another day.',
        'One approved idea produced into every format, market and moment, from material the brand already holds the rights to.',
        'Direction set before production, a licence and consent record for every input, and a named person approving before anything publishes. Without those three, the work drifts towards a model’s default look.',
        'ai-content-studio',
    ],
    [
        'Interfaces',
        'Software answered exactly what it was asked. A wrong answer was a bug, and an uncertain answer was not a state anyone designed.',
        'Assistants that hold a conversation, and agents that plan a piece of work and then carry it out on someone’s behalf.',
        'A designed state for uncertain, slow and incorrect; sources a person can open; and a stop button that always works. The model is probabilistic, so the experience has to absorb that.',
        'ai-application-design',
    ],
    [
        'The brand itself',
        'Guidelines a person read, interpreted and applied, at the speed a person works and with the variance a person brings.',
        'A model that has learned the identity and starts on brand, served inside the tools the team already designs and writes in.',
        'A rights-cleared dataset that includes counter-examples, a fidelity score run on every version, and a threshold a release has to clear. Four good samples are not a release decision.',
        'brand-ai-tools',
    ],
    [
        'The way work happens',
        'A linear brief-to-asset pipeline, judged by how busy it looked rather than by what it cost per approved asset.',
        'The repetition moves to machines, and the scarce thing becomes direction, review and judgement.',
        'A baseline measured before anything changes, a written policy on what may be generated and what must be disclosed, and training for the people whose Monday changes.',
        'ai-strategy-consulting',
    ],
];
?>
<section class="band band--alt aih-premise" id="premise" aria-labelledby="premise-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The premise</p>
        <h2 class="h2" id="premise-t"><span class="g">Using AI under the hood is table stakes.</span> The work is what it now makes possible.</h2>
      </div>
      <div>
        <p class="lead">Four things changed about brand work once the medium began to generate. Each one opened something that was not available before, and each one arrived with an obligation attached. This discipline exists for both halves.</p>
        <p class="aih-note">Every obligation in the third column has a section of its own further down this page.</p>
      </div>
    </div>

    <div class="aih-pr" data-rv data-rv-d="60">
      <div class="aih-pr__head" aria-hidden="true">
        <span class="aih-k">Subject</span>
        <span class="aih-k">What it was</span>
        <span class="aih-k aih-k--blue">What is now possible</span>
        <span class="aih-k">What it asks in return</span>
      </div>

      <?php foreach ($pr_rows as $pr_i => $pr_r): ?>
        <article class="aih-pr__r">
          <div class="aih-pr__s">
            <span class="bdh-idx"><?= str_pad((string) ($pr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="aih-pr__h"><?= e($pr_r[0]) ?></h3>
            <a class="aih-caplink aih-pr__l" href="#<?= e($pr_r[4]) ?>"><span><?= e($CAPS[$pr_r[4]]['short']) ?></span><i aria-hidden="true">›</i></a>
          </div>
          <div class="aih-pr__c aih-pr__c--then">
            <p class="aih-k aih-pr__ck">What it was</p>
            <p class="aih-pr__t"><?= e($pr_r[1]) ?></p>
          </div>
          <div class="aih-pr__c aih-pr__c--now">
            <p class="aih-k aih-k--blue aih-pr__ck">What is now possible</p>
            <p class="aih-pr__t"><?= e($pr_r[2]) ?></p>
          </div>
          <div class="aih-pr__c aih-pr__c--ask">
            <p class="aih-k aih-pr__ck">What it asks in return</p>
            <p class="aih-pr__t"><?= e($pr_r[3]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
