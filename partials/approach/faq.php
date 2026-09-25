<?php /* DRAFT COPY — review before launch */
/* FAQ — how we work, asked directly. Core [data-acc] accordion, so no section script; the <noscript>
   rule below leaves every answer open without JavaScript, and the first row ships open, which core.js
   picks up from aria-expanded="true".
   Laid out deliberately unlike the FAQ on the work page: a centred head over one wide column, and each
   question tagged with the part of this page it belongs to, so the accordion doubles as an index of the
   page. Answers link to the section rather than repeating it. */
$aprf_items = [
    ['Does AI mean we are paying for a machine to do the work?',
     'You are paying for judgement, and for the output being right. Agents make the legwork faster, which is why a stage that used to take four weeks can take two. What you buy is the decisions: which problem, which route, what may be claimed, what is allowed to ship. Those are made by named people, and they are the part that is hard.',
     '#model', 'The division of labour'],
    ['Which stage would we start at?',
     'Frame, almost always. It is short, it is the cheapest thing we sell, and it produces the two things every later decision needs: the problem written down in your words, and the baseline of the number you want to move. If you already have both, we can start at Shape.',
     '#stages', 'The stages'],
    ['How much of our own team\'s time does this take?',
     'During Build, one 45-minute review a week from your product owner, plus answering questions in the shared channel. Frame and Shape need more: a working session and a few hours of your subject experts. Prove needs your security lead for the sign-off. Everything else arrives in writing.',
     '#cadence', 'Week to week'],
    ['What happens when you miss a date?',
     'You hear it the day we know, in writing, with what we propose to do about it, in that week\'s report. We move a date rather than a standard, and the reason goes in the decision log. What we will not do is let you discover it at a gate.',
     '#quality', 'Quality'],
    ['Can our security team audit how you use AI?',
     'Yes, and we expect them to. The evals, the guardrail policy, the audit log and the agent permissions are all reviewable, and they run in your own environment where the work does. We answer your security questionnaire during Shape, not after signature.',
     '#assurance', 'Assurance'],
    ['Do you use our data to train models?',
     'No. We use enterprise model endpoints with training on your data switched off, and where data may not leave your network we run open-weight models inside it. Personal data is redacted before a model call. That is a control set in the gateway, not a promise in a policy.',
     '#assurance', 'Assurance'],
    ['What if we want to take the work in-house?',
     'That is a normal ending, and it is planned from the start. You already hold the code, the design source, the prompts and the eval sets. The remaining weeks are knowledge transfer, your team running it while we watch, and then our access being revoked.',
     '#handover', 'Ownership'],
    ['Is this the same process for a brand project and a platform build?',
     'The same six stages and the same gates, at very different lengths. A brand sprint compresses Frame and Shape into days and has no Launch in the software sense. A regulated platform programme runs months at Build and again at Prove. The decisions the gates protect do not change.',
     '#gates', 'The gates'],
];
?>
<noscript><style>.apr-faq__p{height:auto;overflow:visible}.apr-faq__plus{display:none}</style></noscript>
<section class="band band--alt apr-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c apr-faq__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
      <h2 class="h2" id="faq-t"><span class="g">How we work,</span> asked directly.</h2>
      <p class="lead">Eight questions we are asked in most first calls, each tagged with the part of this
        page it comes from.</p>
    </div>

    <div class="apr-faq__list" data-acc data-rv data-rv-d="60">
      <?php foreach ($aprf_items as $aprf_i => $aprf_q): $aprf_open = $aprf_i === 0; ?>
        <div class="apr-faq__row">
          <h3 class="apr-faq__hq">
            <button class="apr-faq__q" type="button" data-acc-b id="faq-q<?= $aprf_i ?>"
                    aria-expanded="<?= $aprf_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $aprf_i ?>">
              <span class="apr-faq__t"><?= e($aprf_q[0]) ?></span>
              <span class="apr-faq__tag"><?= e($aprf_q[3]) ?></span>
              <span class="apr-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="apr-faq__p<?= $aprf_open ? ' is-open' : '' ?>" id="faq-a<?= $aprf_i ?>" data-acc-p role="region" aria-labelledby="faq-q<?= $aprf_i ?>">
            <div class="apr-faq__a">
              <p><?= e($aprf_q[1]) ?></p>
              <p class="apr-faq__rel">
                <a class="tl" href="<?= e($aprf_q[2]) ?>">Read the full answer on this page: <?= e($aprf_q[3]) ?> <span class="i" aria-hidden="true">›</span></a>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="apr-faq__foot" data-rv data-rv-d="100">
      <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Book a first call <span class="i" aria-hidden="true">›</span></a>
      <a class="tl" href="<?= xe_url('work.php') ?>">See the work <span class="i" aria-hidden="true">›</span></a>
      <!-- PLACEHOLDER: confirm the first-call format and length before launch -->
      <span class="apr-note">Typically 45 minutes with the person who would lead the engagement. No deck.</span>
    </p>
  </div>
</section>
