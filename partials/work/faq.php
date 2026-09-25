<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions a buyer asks about a work page. Uses the core [data-acc] accordion, so no section
   script is needed; the <noscript> rule below leaves every answer open when JavaScript is off. The first
   row ships open, which core.js picks up from aria-expanded="true". */
$wkq_items = [
    ['Why are there so few case studies here?',
     'Because the ones on this page are placeholders while the real records are cleared for publication, and because most enterprise work never clears. We publish the records we can evidence and show the rest privately. A short honest archive is more useful to you than a long invented one.'],
    ['Can we see work in our sector?',
     'Usually yes, under NDA. Tell us the sector and the problem and we will bring the closest relevant work, with the client anonymised where we are required to. Sector attribution here shows which sectors the archive covers.'],
    ['Will you name us if we work with you?',
     'Only if you tell us to, in writing, and you can withdraw that later. The default is sector attribution. Nothing about your engagement appears anywhere until you have seen it.'],
    ['Who owns what you build for us?',
     'You do. Source files, code, infrastructure definitions, prompts, eval sets and documentation are yours, transferred as they are created rather than at the end. The handover pack is a deliverable, not a favour.',
     'ownership'],
    ['Do you show work that did not succeed?',
     'In the room, yes. A programme that stopped at a gate because the data would not support it is a useful story and we will tell it. It does not get a published record, because the client rarely wants one.'],
    ['How do you arrive at the numbers you publish?',
     'The measure, the baseline, the window and the verifier are agreed in writing before delivery starts, and the reading comes from the client\'s own system at the end of the window. If any of the four is missing, the record describes what changed in words instead.',
     'measure'],
    ['Can we speak to one of your clients?',
     'We will ask. Some clients take reference calls and some are contractually unable to. We would rather tell you that than put a stranger on a call and hope.'],
];
?>
<noscript><style>.wk-faq__p{height:auto;overflow:visible}.wk-faq__plus{display:none}</style></noscript>
<section class="band wk-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid wk-faq__grid">
    <div class="bdh-c4 wk-faq__side">
      <div class="bdh-sticky wk-faq__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">The work,</span> asked directly.</h2>
        <p class="wk-faq__more">Anything else, ask the people who would run your programme. A first call is
          a conversation about your problem, not a portfolio review.</p>
        <div class="wk-faq__act">
          <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Start a conversation <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="<?= xe_url('approach.php') ?>">See how we work <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 wk-faq__list" data-acc data-rv data-rv-d="70">
      <?php foreach ($wkq_items as $wkq_i => $wkq_q): $wkq_open = $wkq_i === 0; ?>
        <div class="wk-faq__row">
          <h3 class="wk-faq__hq">
            <button class="wk-faq__q" type="button" data-acc-b id="faq-q<?= $wkq_i ?>"
                    aria-expanded="<?= $wkq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $wkq_i ?>">
              <span class="wk-faq__n"><?= str_pad((string) ($wkq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="wk-faq__t"><?= e($wkq_q[0]) ?></span>
              <span class="wk-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="wk-faq__p<?= $wkq_open ? ' is-open' : '' ?>" id="faq-a<?= $wkq_i ?>" data-acc-p role="region" aria-labelledby="faq-q<?= $wkq_i ?>">
            <div class="wk-faq__a">
              <p><?= e($wkq_q[1]) ?></p>
              <?php if (!empty($wkq_q[2])): ?>
                <p class="wk-faq__rel">
                  <span class="wk-k">Read on</span>
                  <?php if ($wkq_q[2] === 'ownership'): ?>
                    <a class="tl" href="<?= xe_url('approach.php') ?>#handover">Handover and ownership <span class="i" aria-hidden="true">›</span></a>
                  <?php else: ?>
                    <a class="tl" href="#measure">How outcomes are evidenced <span class="i" aria-hidden="true">›</span></a>
                  <?php endif; ?>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
