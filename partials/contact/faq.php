<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions people ask before they send anything. Core accordion ([data-acc] in
   assets/js/core.js); the <noscript> rule leaves every answer open, so the section is complete
   without JavaScript. Left rail: the three other ways in, and the facts that decide whether it is
   worth writing at all.
   PLACEHOLDER: confirm every response time and commercial statement on this page before launch. */
$ct_fq = [
    ['Is there a minimum engagement?',
     'There is a smallest sensible piece of work rather than a minimum invoice: a sprint of one to three weeks with a fixed fee and a decision at the end. Below that we would be guessing, and you would be paying for the guess.'],
    ['We only have a rough idea. Is it too early to write?',
     'No. Most useful briefs start as a paragraph. Choose “Say hello”, describe the problem in your own words, and we will send back the three questions that would let us price it. Half the time the answer is a smaller first step than you expected.'],
    ['Do you sign NDAs before the first call?',
     'Yes. Tick the NDA box in the brief and we will send ours, or sign yours, before anything confidential is discussed. It happens before the call, not after it.'],
    ['Can we send our own RFQ document instead of filling this in?',
     'Yes. Attach it in block 06 — PDF, DOC, DOCX, PPT or PPTX. Fill in your name, an address to reply to and one line of context, and skip the rest; the fields only exist to route the document to the right lead before anyone opens it.'],
    ['Do you respond to formal tenders?',
     'We read every invitation and tell you within three working days whether we will bid. We decline more than we accept, and we say which of the three reasons applies: not our work, timing we cannot hold, or a better-suited firm we can name.'],
    ['What happens to what we send you?',
     'It becomes one email to a named lead, with your document attached if you sent one. Nothing is written to this website — no database, no copy of the file, no third-party form service. The Privacy Notice says how long the email is kept and how to have it deleted.'],
    ['We are an agency, not an end client. Do you work white-label?',
     'Sometimes, under our commercial policy, and only where the end client knows a specialist partner is involved. Say so in the brief so we can tell you quickly rather than three calls in.'],
    ['Do you work with teams outside India?',
     'Yes. Most engagements run remotely across time zones, with a working overlap agreed at the start. Tell us your hours in block 01 and we will propose a call inside them rather than at the edge of yours.'],
    ['How do you charge, and when do we pay?',
     'Fixed fee for a sprint, fixed price for a defined project, per milestone for a larger programme, monthly for a retainer or squad. Nothing is payable until a statement of work is signed, and a quotation costs nothing.'],
];
?>
<noscript><style>.ct-fq__p{height:auto;overflow:visible}.ct-fq__plus{display:none}</style></noscript>
<section class="band band--alt ct-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid ct-faq__grid">

    <div class="bdh-c4 ct-faq__side">
      <div class="bdh-sticky ct-faq__stick" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Before you write</p>
        <h2 class="h2" id="faq-t"><span class="g">Asked before every brief,</span> answered here.</h2>
        <p class="ct-faq__more">Anything this does not cover, ask in the brief itself — the same person who would run the work is the one who answers it.</p>
        <div class="ct-faq__act">
          <?php if ($ct_sent): ?>
            <a class="btn btn--ink" href="<?= xe_url('services/') ?>">See what we do <span class="i" aria-hidden="true">›</span></a>
          <?php else: ?>
            <a class="btn btn--ink" href="#brief">Go to the brief <span class="i" aria-hidden="true">›</span></a>
          <?php endif; ?>
          <a class="tl ct-faq__tl" href="<?= xe_url('index.php#book') ?>">Book a thirty-minute call <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 ct-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($ct_fq as $ct_i => $ct_q): $ct_n2 = str_pad((string) ($ct_i + 1), 2, '0', STR_PAD_LEFT); $ct_op = $ct_i === 0; ?>
        <div class="ct-fq__row">
          <h3 class="ct-fq__hq">
            <button class="ct-fq__q" type="button" data-acc-b aria-expanded="<?= $ct_op ? 'true' : 'false' ?>" aria-controls="ct-fa<?= $ct_i ?>" id="ct-fq<?= $ct_i ?>">
              <span class="ct-fq__n" aria-hidden="true">Q<?= $ct_n2 ?></span>
              <span class="ct-fq__t"><?= e($ct_q[0]) ?></span>
              <span class="ct-fq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="ct-fq__p<?= $ct_op ? ' is-open' : '' ?>" id="ct-fa<?= $ct_i ?>" role="region" aria-labelledby="ct-fq<?= $ct_i ?>" data-acc-p>
            <div class="ct-fq__a"><p><?= e($ct_q[1]) ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
