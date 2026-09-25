<?php /* DRAFT COPY — review before launch */
/**
 * Book · after — the only ink band on the page, because this is the part that is a commitment.
 *
 * Every timing here is stated as typical and carries a PLACEHOLDER above it. The first step is the
 * important one: the booking is the confirmation email, not the button. That is said plainly rather
 * than buried, because the home page's booking section is a mock that reserves nothing and this page
 * must not be read as the same thing.
 *
 * The stepper's connector is trimmed to leave each node's edge with a gap on both sides, so a line
 * never runs through the circle it connects (brief §2 defect class 4).
 *
 * Requires $BK (book.php). Locals are prefixed af_.
 */
$af_steps = [
    ['Within a minute', 'The confirmation arrives',
     'Cal.com sends the confirmation and the calendar invitation, with the joining link and the reschedule and cancel links inside it. That email is the booking.'],
    ['Before the call', 'We ask for anything we need',
     'By email, and only if it changes the half hour. If you have asked for an NDA, it is signed and returned before the call rather than at the start of it.'],
    ['On the day', 'Thirty minutes, on time',
     'Notes are taken on our side, so nobody on yours has to write while listening. If we are going to run over, we ask rather than assume.'],
    // PLACEHOLDER: confirm the follow-up commitment and its timing before launch
    ['Typically two working days', 'A written read on fit',
     'What we heard, an honest answer on whether we are the right team, and either the shape of a first piece of work with a range, or the name of someone better placed.'],
];
?>
<section class="band band--ink bk-af" id="after" aria-labelledby="after-t">
  <span class="bk-af__dots dots-ink" aria-hidden="true"></span>
  <div class="wrap bk-af__wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>After you confirm</p>
        <h2 class="h2" id="after-t"><span class="g">The booking is the email.</span> Not the button.</h2>
      </div>
      <div>
        <p class="lead bk-af__lead">Four things happen, in this order. The timings below are typical
          rather than guaranteed, and the first one is the one that matters.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm the follow-up commitment, its timing, and whether the Cal.com event type
         requires manual confirmation (which would make the first email a request, not a confirmation) before launch -->
    <ol class="bk-af__steps" data-rv data-rv-d="60">
      <?php foreach ($af_steps as $af_i => $af_s): ?>
        <li class="bk-af__s<?= $af_i === 0 ? ' is-now' : '' ?>">
          <span class="bk-af__node" aria-hidden="true"><?= str_pad((string) ($af_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <p class="bk-k bk-af__when"><?= e($af_s[0]) ?></p>
          <h3 class="bdh-t bdh-t--s"><?= e($af_s[1]) ?></h3>
          <p class="bdh-d"><?= e($af_s[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="bk-af__notes" data-rv data-rv-d="100">
      <p class="bk-note">
        <b>Moving it is normal</b>
        Use the reschedule link in your confirmation rather than emailing. It puts the slot back for
        someone else the moment you change it, which is the polite version of a cancellation.
      </p>
      <p class="bk-note">
        <b>No confirmation, no booking</b>
        If nothing arrives within a few minutes, the booking did not complete. Check the spam folder,
        then try again, then email <a href="mailto:<?= e($BK['email']) ?>"><?= e($BK['email']) ?></a> and
        we will put a time in by hand.
      </p>
      <p class="bk-note">
        <b>What we do with the notes</b>
        They are used to write your follow-up and nothing else. There is no marketing sequence behind
        this page, and no analytics on it.
      </p>
    </div>

  </div>
</section>
