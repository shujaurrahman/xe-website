<?php /* DRAFT COPY — review before launch */
/* Candidate questions — the core [data-acc] accordion, same component the Technology hub FAQ uses.
   faq.js is not needed: core.js drives the accordion, and the <noscript> rule below leaves every
   answer open and drops the plus sign when JavaScript is off. Locals prefixed cfq_. */

/* PLACEHOLDER: confirm the answers about pay conversations, notice periods, visas and referrals
   before launch. Each one commits the company to something. */
$cfq_items = [
    ['Do you publish salary ranges?',
     'Not on this page. We tell you the range for the role in the first thirty-minute call, before you spend any more time on us, and the offer number comes from the role and the level rather than from what you earned last. If a range is the thing standing between you and applying, write and ask.'],
    ['I do not match every line of the role. Should I apply?',
     'Yes, if you match the craft and the "what you will work on" list reads like work you want. The "nice to have" list is genuinely optional, and the experience figure describes the scope of the role rather than a gate. Say in your note which parts you would be learning.'],
    ['Can I apply for more than one role?',
     'Send one application for the closest role and mention the other in your note. Two separate applications get read by two people who then have to find each other, which slows you down rather than doubling your chances.'],
    ['What happens to my application if I am not right for this role?',
     'We tell you. If your work is close to something we expect to open, we say so and roughly when, and we keep your application on file for that. Otherwise we close it out with the actual reason. You can ask us to delete it at any time by writing to ' . $SITE['company']['email'] . '.'],
    ['Is the work remote, hybrid or in-studio?',
     'Most full-time roles are hybrid, based in New Delhi or Ludhiana, with a target of three days a week in studio set by the engagement. Some contract and production roles are fully remote within India. Every listing states its own arrangement, and the location filter above is accurate.'],
    ['Do you take interns, and are they paid?',
     'Yes and yes. Internships are paid, six months, on site, with a named mentor and the same weekly critique everyone else gets. We do not run unpaid placements, and an internship is not a probation period in disguise.'],
    ['Will I be working on AI, or on ordinary work with AI in it?',
     'Both, and the second one more often. Some roles build AI systems for clients — agents, evals, retrieval, infrastructure. Every role uses AI in its own production work. If you want to only do research on models, we are not the right place; if you want to ship AI into something people depend on, we probably are.'],
    ['Do you sponsor visas or hire outside India?',
     'Our studios are in India and the roles on this page are India-based. If you are outside India and the role says remote, tell us where you are and we will tell you straight whether we can make it work. Do not assume the answer is no, and do not assume it is yes.'],
    ['Can I be referred by someone who works here?',
     'Yes, and it helps, but it does not skip a stage. A referral gets your application read sooner and with context. It still goes through the same conversations, because that is what makes the process fair to everyone else in the pile.'],
    ['What is the notice period you expect?',
     'Whatever your current contract says. Tell us on the application form so we can plan the start date around it. A long notice period has never been the reason we did not make an offer.'],
];
?>
<noscript><style>.car-faq__p{height:auto;overflow:visible}.car-faq__plus{display:none}</style></noscript>
<section class="band band--alt car-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid">
    <div class="bdh-c4 car-faq__side">
      <div class="bdh-sticky" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Asked by candidates,</span> answered straight.</h2>
        <p class="p car-faq__p2">If your question is not here, ask it. A person answers, usually the same week, and asking never counts against an application.</p>
        <div class="car-faq__act">
          <a class="btn btn--ink" href="<?= e(car_apply_url()) ?>">Apply now <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('Question about careers')) ?>">Email the team <span class="i" aria-hidden="true">›</span></a>
        </div>
        <!-- PLACEHOLDER: confirm this reply target before launch -->
        <dl class="car-faq__facts">
          <div><dt>Application reply</dt><dd>Target: 5 working days</dd></div>
          <div><dt>Process length</dt><dd>Target: 2–3 weeks</dd></div>
          <div><dt>Paid exercise</dt><dd>Only if needed, capped at a day</dd></div>
        </dl>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 car-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($cfq_items as $cfq_i => $cfq_q): $cfq_open = $cfq_i === 0; ?>
        <div class="car-faq__row">
          <h3 class="car-faq__hq">
            <button class="car-faq__q" type="button" data-acc-b aria-expanded="<?= $cfq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $cfq_i ?>" id="faq-q<?= $cfq_i ?>">
              <span class="car-faq__n" aria-hidden="true">Q<?= str_pad((string) ($cfq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="car-faq__t"><?= e($cfq_q[0]) ?></span>
              <span class="car-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="car-faq__p<?= $cfq_open ? ' is-open' : '' ?>" id="faq-a<?= $cfq_i ?>" role="region" aria-labelledby="faq-q<?= $cfq_i ?>" data-acc-p>
            <div class="car-faq__a"><p><?= e($cfq_q[1]) ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
