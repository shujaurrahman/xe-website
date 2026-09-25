<?php /* DRAFT COPY — review before launch */
/* Apply · what happens next — shown in every state of the page, including after a send, because it
   is the thing a candidate most wants in writing. The left column is the process with its targets
   marked as targets. The right column is the mechanics: what the form actually does when you press
   send, what is kept and what is not. Locals prefixed an_. */

/* PLACEHOLDER: confirm every target below, and who reads applications, before launch */
$an_steps = [
    ['A person reads it',        'Target: 5 working days',  'The lead for the practice you applied to. Not a keyword filter, not an agency, not a scoring model.'],
    ['You hear back either way', 'Always in writing',       'A yes, a no, or a question. If a target passes and you have heard nothing, that is our mistake — write and we will answer the same week.'],
    ['A thirty-minute call',     'Video, no slide deck',    'Your work, our work, and the pay range for the role, so you are not guessing before you invest more time.'],
    ['Then the craft conversation', '60–75 minutes',        'One thing you have made, in depth, with two people you would actually work with. The full five stages are set out on the careers page.'],
];

$an_mech = [
    ['Where it goes',  'It emails your answers, and your CV if you attached one, to ' . $SITE['company']['email'] . ', with Reply-To set to your address so a reply goes straight back to you.'],
    ['What is stored here', 'Nothing. This website has no database and no file store. The page keeps nothing after the email leaves.'],
    ['Who sees it',         'The practice lead for the role and, at the offer stage, one founder. It is not circulated further and it is never shared outside the company.'],
    ['How long we keep it', 'In the mailbox while the role is open, and for a while after in case something closer opens. Ask us to delete it and we will, at any point.'],
    ['If sending fails',    'The page says so, keeps everything you typed, and hands you the same application as an email you can send yourself. It never pretends to have sent something it did not.'],
];
?>
<section class="band band--alt apl-nextb" id="what-happens" aria-labelledby="what-happens-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What happens next</p>
        <h2 class="h2" id="what-happens-t"><span class="g">After you press send,</span> in order.</h2>
      </div>
      <div>
        <p class="lead">Every time below is a target we work to, not a promise. Calendars are the usual reason one slips, and when one does we tell you rather than going quiet.</p>
      </div>
    </div>

    <div class="apl-nextb__grid">
      <!-- PLACEHOLDER: confirm the reply target, the call formats and who reads applications before launch -->
      <ol class="apl-nextb__steps" data-rv-s data-rv-step="80">
        <?php foreach ($an_steps as $an_i => $an_s): ?>
          <li class="apl-nextb__step">
            <span class="bdh-idx"><?= str_pad((string) ($an_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="bdh-t bdh-t--l apl-nextb__t"><?= e($an_s[0]) ?></h3>
            <span class="bdh-tag bdh-tag--blue apl-nextb__tag"><?= e($an_s[1]) ?></span>
            <p class="bdh-d apl-nextb__d"><?= e($an_s[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="apl-nextb__mech" data-rv data-rv-d="90">
        <p class="apl-k apl-k--blue">What this form actually does</p>
        <dl class="apl-nextb__dl">
          <?php foreach ($an_mech as $an_m): ?>
            <div><dt><?= e($an_m[0]) ?></dt><dd><?= e($an_m[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="apl-nextb__note">Prefer to send it yourself? Email <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a> with the role in the subject line. It reaches exactly the same place.</p>
      </div>
    </div>
  </div>
</section>
