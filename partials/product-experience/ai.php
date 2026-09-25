<?php /* DRAFT COPY — review before launch */
/* AI — two halves. First, designing an AI feature from its failure modes: a segmented control moves a
   mock assistant through the five states that decide whether people keep using it, and each state
   lists what the interface has to do. Second, how AI is used in our own work, with the limits written
   down. All five states are in the markup (the first is on); ai.js switches them with BDH.tabs. */
$ai_states = [
    [
        'key' => 'streaming', 'label' => 'Streaming', 'chip' => 'Answering',
        'title' => 'While the answer is arriving',
        'body'  => 'Delivery to a UK address usually clears customs in two to three working days. For the order you are looking at, the carrier',
        'partial' => true,
        'act'   => [['Stop', 'is-primary'], ['Copy', ''], ['Sources', 'is-dim']],
        'must'  => [
            'Say it is AI before the first word arrives, not after the answer.',
            'Give an obvious way to stop, because a long answer is a long wait.',
            'Never move or resize the content under the reader as the text streams in.',
        ],
    ],
    [
        'key' => 'cited', 'label' => 'Cited', 'chip' => 'Answered · 3 sources',
        'title' => 'When it is confident and can prove it',
        'body'  => 'Delivery to a UK address usually clears customs in two to three working days. For order 41-8802 the carrier scanned the parcel at Heathrow this morning, so Thursday is the realistic date.',
        'cites' => [['Shipping policy', '§4 · customs'], ['Order 41-8802', 'carrier scan · 07:14'], ['Carrier SLA', 'UK inbound'] ],
        'act'   => [['Apply to the reply', 'is-primary'], ['Edit', ''], ['Sources · 3', '']],
        'must'  => [
            'Show where each claim came from, and let the source be opened.',
            'Let the person edit the answer before it is used anywhere.',
            'Keep the action reversible, and say what "apply" will actually do.',
        ],
    ],
    [
        'key' => 'unsure', 'label' => 'Low confidence', 'chip' => 'Unsure · 1 source',
        'title' => 'When it is not sure, and says so',
        'body'  => 'I could not find a customs record for this order. Comparable orders to the same address cleared in two to three working days, but I would check the carrier record before promising a date.',
        'warn'  => 'Low confidence · no record found for this order',
        'act'   => [['Open the carrier record', 'is-primary'], ['Ask a person', ''], ['Sources · 1', '']],
        'must'  => [
            'Say what it is unsure about, in the words of the task rather than a percentage.',
            'Demote the confident action: checking the source becomes the primary button.',
            'Make it as easy to reach a person as it is to accept the answer.',
        ],
    ],
    [
        'key' => 'refused', 'label' => 'Refused', 'chip' => 'Declined',
        'title' => 'When it should not answer at all',
        'body'  => 'I am not able to change a delivery address after a parcel has been scanned by the carrier. A person on the fulfilment team can, and I have put the order and the conversation in front of them.',
        'warn'  => 'Out of scope · address changes need a person',
        'act'   => [['Send to fulfilment', 'is-primary'], ['See the order', ''], ['Why was this declined?', '']],
        'must'  => [
            'Say what it will not do and why, in one sentence, without apologising twice.',
            'Offer the thing that will work instead, in the same breath.',
            'Log the refusal, so the pattern can be read later rather than guessed at.',
        ],
    ],
    [
        'key' => 'human', 'label' => 'Handed over', 'chip' => 'With a person',
        'title' => 'When a person takes it',
        'body'  => 'Asha on your fulfilment team has this, with the order, the carrier record and everything said here already attached. She is working through the queue and expects to reply within the hour.',
        'warn'  => 'Handed over at 11:42 · context attached',
        'act'   => [['Add something', 'is-primary'], ['See what was sent', ''], ['Back to the assistant', '']],
        'must'  => [
            'Name who has it and when a reply is realistic, not "soon".',
            'Hand over the context, so nobody is asked the same question twice.',
            'Show the person exactly what the assistant already said.',
        ],
    ],
];
$ai_work = [
    ['icon' => 'search', 'n' => '01',
     't' => 'Synthesis that can only quote',
     'd' => 'Session transcripts are indexed and an assistant proposes themes. It cannot propose one without at least two participant quotes and their timestamps attached, and a researcher accepts or rejects every theme by hand. The decision is logged against the theme.',
     'tag' => 'Human accepts each theme'],
    ['icon' => 'eval', 'n' => '02',
     't' => 'Evaluation sets before a release',
     'd' => 'Task-level graded criteria agreed with your experts, scored automatically and calibrated against human review, run over many inputs so the result is a distribution rather than a single pass or fail. Thresholds gate the release.',
     'tag' => 'Eval gate in CI'],
    ['icon' => 'accessibility', 'n' => '03',
     't' => 'Accessibility and visual checks on every merge',
     'd' => 'Automated accessibility rules and visual regression run against the component library and the key journeys on every merge, with manual keyboard and screen-reader passes before each release. Machines find the regressions; people find the barriers.',
     'tag' => 'Automated, then manual'],
    ['icon' => 'shield', 'n' => '04',
     't' => 'What it is not allowed to do',
     'd' => 'Write a finding no session supports. Choose between design directions. Approve its own output. Send anything to one of your customers without a person reading it first. Those four are written into how we work, not left to judgement on the day.',
     'tag' => 'Written limits'],
];
?>
<section class="band band--alt pxh-ai" id="ai" aria-labelledby="ai-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI, concretely</p>
        <h2 class="h2" id="ai-t"><span class="g">The model is not the product.</span> The experience around it is.</h2>
      </div>
      <div>
        <p class="lead">An AI feature is designed around its failure modes first: what the person sees when confidence is low, how they correct it, and what the product learns from the correction. Everything below is an interface decision, not a tone of voice.</p>
        <p class="pxh-capls pxh-ai__caps"><a class="pxh-capl" href="#ai-product-strategy-development"><b><?= e($CAPS['ai-product-strategy-development']['n']) ?></b><span><?= e($CAPS['ai-product-strategy-development']['name']) ?></span><i aria-hidden="true">›</i></a></p>
      </div>
    </div>

    <div class="pxh-panel pxh-ai__demo" data-rv data-rv-d="60" data-bdh-live>
      <div class="pxh-panel__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="pxh-panel__name">Assistant patterns <i>/</i> the five states that matter</span>
        <span class="pxh-panel__ill">Mock · your platform</span>
      </div>

      <div class="pxh-ai__ctl">
        <p class="pxh-k pxh-ai__ck">Choose a state</p>
        <div class="bdh-seg pxh-ai__seg" role="tablist" aria-label="Assistant states">
          <?php foreach ($ai_states as $ai_i => $ai_s): ?>
            <button type="button" role="tab" id="ai-t<?= $ai_i ?>" aria-controls="ai-p<?= $ai_i ?>"
                    aria-selected="<?= $ai_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $ai_i === 0 ? '0' : '-1' ?>"><?= e($ai_s['label']) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="pxh-ai__panes">
        <?php foreach ($ai_states as $ai_i => $ai_s): ?>
          <div class="pxh-ai__pane" role="tabpanel" id="ai-p<?= $ai_i ?>" aria-labelledby="ai-t<?= $ai_i ?>" tabindex="0">
            <div class="pxh-ai__mock">
              <div class="pxh-ai__mh">
                <span class="pxh-ai__mt">Assistant</span>
                <span class="pxh-ai__mc"><?= e($ai_s['chip']) ?></span>
              </div>
              <p class="pxh-ai__disc"><?= xt_icon('sparkle', ['size' => 14, 'mono' => true]) ?>AI-generated. Check anything you act on.</p>
              <?php if (!empty($ai_s['warn'])): ?>
                <p class="pxh-ai__warn"><?= xt_icon('alert', ['size' => 16, 'mono' => true]) ?><?= e($ai_s['warn']) ?></p>
              <?php endif; ?>
              <p class="pxh-ai__body"><?= e($ai_s['body']) ?><?php if (!empty($ai_s['partial'])): ?><span class="bdh-caret" aria-hidden="true"></span><?php endif; ?></p>
              <?php if (!empty($ai_s['cites'])): ?>
                <ul class="pxh-ai__cites" role="list">
                  <?php foreach ($ai_s['cites'] as $ai_ci => $ai_c): ?>
                    <li><b><?= $ai_ci + 1 ?></b><span><?= e($ai_c[0]) ?></span><em><?= e($ai_c[1]) ?></em></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <p class="pxh-ai__acts">
                <?php foreach ($ai_s['act'] as $ai_a): ?>
                  <span class="pxh-ai__act <?= e($ai_a[1]) ?>"><?= e($ai_a[0]) ?></span>
                <?php endforeach; ?>
              </p>
              <p class="pxh-ai__log"><span class="pxh-k">Logged</span>prompt version, model, sources returned, what the person did next</p>
            </div>

            <div class="pxh-ai__must">
              <p class="pxh-k"><?= e($ai_s['label']) ?></p>
              <h3 class="pxh-ai__mtitle"><?= e($ai_s['title']) ?></h3>
              <p class="pxh-k pxh-k--blue pxh-ai__mk">What the interface has to do</p>
              <ul class="bdh-bullets">
                <?php foreach ($ai_s['must'] as $ai_m): ?><li><?= e($ai_m) ?></li><?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="pxh-ai__work">
      <div class="pxh-ai__wh" data-rv>
        <div>
          <p class="pxh-k">AI in our own work</p>
          <p class="pxh-ai__wt">We use it where it is checkable, and say where we do not.</p>
        </div>
        <p class="pxh-note pxh-ai__wn">Research and design work is judged on evidence, so anything an assistant produces has to be traceable to a session, a transcript or a test result. Where it cannot be, a person does the work.</p>
      </div>

      <ul class="pxh-cards pxh-cards--4 pxh-ai__cards" role="list" data-rv-s data-rv-step="70">
        <?php foreach ($ai_work as $ai_w): ?>
          <li class="pxh-card pxh-card--lift pxh-ai__card">
            <span class="pxh-card__top">
              <span class="pxh-card__n"><?= e($ai_w['n']) ?></span>
              <span class="pxh-card__ico" aria-hidden="true"><?= xt_icon($ai_w['icon'], ['size' => 22]) ?></span>
            </span>
            <h3 class="pxh-card__t"><?= e($ai_w['t']) ?></h3>
            <p class="pxh-card__d"><?= e($ai_w['d']) ?></p>
            <span class="pxh-card__foot"><span class="bdh-tag bdh-tag--blue"><?= e($ai_w['tag']) ?></span></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="pxh-ai__law" data-rv>
        <p class="pxh-k">The EU AI Act, on a product feature</p>
        <p>It can apply, including to organisations outside the EU, when the system is placed on the EU market or its output is used there. Most product features sit in the transparency tier, which asks mainly that people are told they are interacting with AI and that generated content is marked. We classify the use case early and design the notices in rather than bolting them on.</p>
        <ul class="pxh-ai__badges" role="list" aria-label="Frameworks AI product work is built to">
          <?php foreach (['eu-ai-act', 'nist-ai-rmf', 'iso42001', 'owasp-llm'] as $ai_b) { echo xt_badge($ai_b, ['variant' => 'chip', 'tag' => 'li']); } ?>
        </ul>
        <a class="tl" href="#standards">All the standards this discipline works to <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
