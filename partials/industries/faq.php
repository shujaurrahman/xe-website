<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions this page raises, answered plainly. The core [data-acc] accordion does the work,
   so no script is needed here; the <noscript> rule leaves every answer open. The closing card points
   at the two instruments on this page rather than repeating the contact facts that live on the
   discipline pages. A FAQPage block is emitted from the same array, so the markup and the structured
   data cannot drift apart. */
$faq_items = [
    ['We are not one of these six. Should we stop reading?',
     'No. The six are where our work has concentrated, not a list of who we take. What decides whether we are useful is the shape of the constraint — a regulated claim, a disclosure that must appear before a decision, a customer who exists in five systems, an assistant that must refuse — and those shapes recur everywhere. Tell us the constraint and we will tell you honestly whether we have run into it before.',
     [['Read what travels between categories', '#transfer']]],
    ['Do you have experience in our exact category?',
     'We will answer that in the first call, specifically, and we will not name clients on a public page to do it. What we can show you here is the mechanism: the approval trail, the step-by-step funnel, the tenant-scoped assistant, the single customer record. If your problem is one of those wearing different clothes, the head start is real.',
     [['See the six mechanisms', '#transfer'], ['Open the Sector Console', '#console']]],
    ['Is any of this legal advice?',
     'No. Every regulatory reference on this page is a summary for orientation. We read the instrument, map it to the journeys and systems it touches, and write it into acceptance criteria your team can test. Your counsel and compliance teams keep the judgement and the sign-off — our job is to make their review short and evidenced.',
     [['See what applies where', '#rulebook']]],
    ['Who owns compliance sign-off?',
     'You do, always. What changes is how much work sign-off takes. When the evidence, the version history and the approval log are produced as the work ships rather than assembled afterwards, review stops being an event and becomes a step.',
     [['See the rulings by category', '#rulebook']]],
    ['We sell in more than one market. How is that scoped?',
     'As one brand system and several rule sets. The design system, the components and the approval mechanism are built once. The instruments, the evidence and occasionally one step of the journey are done per market, and we confirm each with your counsel before designing against it.',
     [['Same sector, different market', '#markets']]],
    ['Can we start with one thing rather than a programme?',
     'That is how most engagements begin. Each sector on this page has three usual starting points, each scoped and measured on its own and built so it plugs into the rest when you are ready. An audit, one journey or one assistant is a complete piece of work, not a foot in the door.',
     [['See the starting points', '#console']]],
    ['Our data is spread across six systems that disagree. Where does that go?',
     'Into the first phase, explicitly. We write down which system is allowed to be the truth for each field, what the joins are, and what may not be used for a decision. That document is usually more valuable than the first release, and it is the part most programmes skip.',
     [['What each sector runs on', '#systems']]],
    ['What happens when the AI gets something wrong?',
     'It is caught by an eval, refused by a guardrail, or corrected by the named person who approves that class of output — and in every case the prompt, the retrieved records, the model version and the decision are in the log. If a change made it worse, the previous version is restored without a deployment.',
     [['See the agent per sector', '#ai-native']]],
    // PLACEHOLDER: confirm typical timeframes and the first-90-day review with the owner before launch
    ['How quickly can something be live?',
     'The starting points on this page carry typical ranges — a few weeks for an audit, two to four months for a first journey or assistant, longer where a regulated review step sets the pace. We would rather tell you which step will be slow than quote a number we have to defend later.',
     [['Open the Sector Console', '#console']]],
];
?>
<noscript><style>
  .ind-faq__p{height:auto;overflow:visible}
  .ind-faq__plus{display:none}
</style></noscript>
<section class="band ind-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">Industries,</span> asked directly.</h2>
      <p class="lead">The questions this page tends to raise, answered without hedging.</p>
    </div>

    <div class="ind-faq__wrap">
      <div class="ind-faq__list" data-acc="multi" data-rv data-rv-d="60">
        <?php foreach ($faq_items as $faq_i => $faq_q): $faq_open = $faq_i === 0; ?>
          <div class="ind-faq__row">
            <h3 class="ind-faq__hq">
              <button class="ind-faq__q" type="button" data-acc-b aria-expanded="<?= $faq_open ? 'true' : 'false' ?>" aria-controls="ind-faq-a<?= $faq_i ?>" id="ind-faq-q<?= $faq_i ?>">
                <span class="ind-faq__n" aria-hidden="true">Q<?= str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="ind-faq__t"><?= e($faq_q[0]) ?></span>
                <span class="ind-faq__plus" aria-hidden="true"></span>
              </button>
            </h3>
            <?php if ($faq_i === count($faq_items) - 1): ?><!-- PLACEHOLDER: confirm the typical timeframes in this answer against real engagements before launch --><?php endif; ?>
            <div class="ind-faq__p<?= $faq_open ? ' is-open' : '' ?>" id="ind-faq-a<?= $faq_i ?>" role="region" aria-labelledby="ind-faq-q<?= $faq_i ?>" data-acc-p>
              <div class="ind-faq__a">
                <p><?= e($faq_q[1]) ?></p>
                <?php if (!empty($faq_q[2])): ?>
                  <p class="ind-faq__rel">
                    <?php foreach ($faq_q[2] as $faq_l): ?><a class="tl" href="<?= e($faq_l[1]) ?>"><?= e($faq_l[0]) ?> <span class="i" aria-hidden="true">›</span></a><?php endforeach; ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <aside class="ind-faq__aside" aria-label="Where to go next">
        <p class="ind-k">Still the wrong question?</p>
        <p class="ind-faq__ask">Describe the constraint you are actually under. We will tell you which of the six it behaves like, and whether we are the right people for it.</p>
        <div class="ind-faq__acts">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'industries')) ?>">Talk about your sector <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#console">Build a draft brief first <span class="i" aria-hidden="true">›</span></a>
        </div>
      </aside>
    </div>
  </div>
</section>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'FAQPage',
    'mainEntity' => array_map(fn ($faq_x) => [
        '@type' => 'Question', 'name' => $faq_x[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq_x[1]],
    ], $faq_items),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
