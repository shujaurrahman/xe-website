<?php /* DRAFT COPY — review before launch */
/* Subscribe — the main sign-up, and the part most pages leave out: what pressing the button actually
   does. Two tracks side by side, because they are genuinely different right now. "Today" is what this
   site does with no email service behind it; "Once connected" is confirmed opt-in, which is the
   intention rather than the current behaviour. Saying so is the only honest way to run this form.
   This is the .band--ink placement of the sign-up component — same component, no restyling. */
$sub_steps = [
    ['01', 'You send your address',
     'The form posts to this page. It is checked here, and your address never leaves this request.',
     'Unchanged.'],
    ['02', 'It reaches a person',
     'One plain email arrives in our inbox with your address in it. Nothing is written to a database, because there is no database.',
     'The email service stores the address as unconfirmed and sends you one confirmation email.'],
    ['03', 'You are on the list',
     'Only once someone adds you by hand, when the list opens. Until then you are not subscribed and we will not pretend you are.',
     'Only once you click the link in that email. Confirmed opt-in, with the date recorded.'],
];
?>
<section class="band band--ink nlt-sub" id="subscribe" aria-labelledby="subscribe-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Subscribe</p>
        <h2 class="h2" id="subscribe-t"><span class="g">What pressing subscribe does,</span> written down before you press it.</h2>
      </div>
      <div>
        <p class="lead">There is no email service connected to this site yet, so the form does something simpler
          than it will. Both versions are below, side by side, and the form says the same thing in one line.</p>
      </div>
    </div>

    <div class="nlt-sub__grid">
      <div class="nlt-sub__flow">
        <div class="nlt-sub__cols" aria-hidden="true">
          <span class="nlt-sub__ck">Today</span>
          <span class="nlt-sub__ck nlt-sub__ck--next">Once the email service is connected</span>
        </div>

        <ol class="nlt-sub__steps" data-rv-s data-rv-step="80">
          <?php foreach ($sub_steps as $sub_s): ?>
            <li class="nlt-sub__step">
              <div class="nlt-sub__sh">
                <span class="nlt-sub__sn"><?= e($sub_s[0]) ?></span>
                <h3 class="nlt-sub__st"><?= e($sub_s[1]) ?></h3>
              </div>
              <div class="nlt-sub__pair">
                <p class="nlt-sub__now"><span class="nlt-sub__tag">Today</span><?= e($sub_s[2]) ?></p>
                <p class="nlt-sub__next"><span class="nlt-sub__tag nlt-sub__tag--next">Once connected</span><?= e($sub_s[3]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>

        <!-- PLACEHOLDER: before launch, confirm the email service (Mailchimp, Buttondown, Kit or another),
             the wording of the confirmation email, the sending address with SPF/DKIM on the live domain,
             and the one-click unsubscribe link and List-Unsubscribe header. Until all four exist, this
             section must keep saying that nothing is stored. -->
        <ul class="nlt-sub__todo" aria-label="What has to be wired up before launch">
          <li><span class="nlt-sub__tk">To wire up</span>The email service and its API</li>
          <li><span class="nlt-sub__tk">To wire up</span>The confirmation email and its link</li>
          <li><span class="nlt-sub__tk">To wire up</span>The one-click unsubscribe link and header</li>
          <li><span class="nlt-sub__tk">To wire up</span>A sending address on the live domain</li>
        </ul>
      </div>

      <div class="nlt-sub__form">
        <?php $nl_signup = [
            'variant' => 'full',
            'id'      => 'subscribe',
            'source'  => 'newsletter',
            'heading' => 'Put yourself on the list for the first issue.',
            'cta'     => 'Subscribe',
        ]; ?>
        <?php include __DIR__ . '/signup.php'; ?>

        <p class="nlt-sub__alt">Would you rather talk to a person than join a list?
          <a class="nlt-a" href="<?= xe_url('contact.php') ?>">Write to us instead</a> — a contact enquiry never
          subscribes you to anything.</p>
      </div>
    </div>
  </div>
</section>
