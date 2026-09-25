<?php /* DRAFT COPY — review before launch */
/* Hero — the page's one h1, the inline sign-up, and the front of an issue rendered as a mail preview:
   the from/to/subject rows, the six blocks it is always made of with their target lengths, and the
   one-click footer. It is a preview of the format rather than a mailbox, so it carries a visible
   "sample issue" mark and a short screen-reader sentence saying what it is. hero.js cycles the subject
   line through the three sample subjects while the card is on screen; the finished first subject is in
   the HTML, so with JavaScript off or under reduced motion the card is simply complete.
   The fact strip below is targets only — no count of anything sent, because nothing has been sent. */
$hero_m = $NLT['meta'];
$hero_subjects = array_map(fn ($hero_r) => $hero_r[0], $NLT['archive']);
if (!$hero_subjects) { $hero_subjects = [$NLT['issue']['subject']]; }
$hero_facts = [
    ['Cadence',   $hero_m['cadence'],  'target'],
    ['Length',    $hero_m['length'],   'target'],
    ['Blocks',    $hero_m['blocks_n'] . ' every issue', 'fixed'],
    ['Tracking',  'None in the email', 'rule'],
];
?>
<section class="band nlt-hero" id="top" aria-labelledby="hero-t">
  <span class="nlt-hero__field dots" aria-hidden="true"></span>

  <div class="wrap nlt-hero__in">
    <div class="nlt-hero__text">
      <!-- PLACEHOLDER: confirm the newsletter's name before launch. It is set once, in data/newsletter.php
           under 'meta' => 'name', and every mention on this page and in the sign-up comes from there. -->
      <p class="lbl lbl--blue nlt-hero__up" style="--i:0"><span class="dot"></span><?= e($hero_m['name']) ?> · The newsletter</p>
      <h1 class="nlt-hero__h nlt-hero__up" id="hero-t" style="--i:1"><span class="g">One email a month,</span> written by the people doing the work.</h1>
      <p class="lead nlt-hero__lead nlt-hero__up" style="--i:2">
        One thing we changed our mind about. Three things worth your time, each with the reason. One number, with
        its definition printed beside it. <?= e($hero_m['length']) ?>, and never a press release.
      </p>

      <div class="nlt-hero__form nlt-hero__up" style="--i:3">
        <?php $nl_signup = ['variant' => 'inline', 'id' => 'hero', 'source' => 'newsletter', 'cta' => 'Subscribe', 'label' => 'Your email address']; ?>
        <?php include __DIR__ . '/signup.php'; ?>
      </div>

      <!-- PLACEHOLDER: this page is written for the pre-launch state. Confirm before launch whether an
           issue has been sent, and replace this line and the archive section if one has. -->
      <p class="nlt-hero__state nlt-hero__up" style="--i:4">
        <span class="nlt-hero__dot" aria-hidden="true"></span><?= e($hero_m['status']) ?>
        <a class="nlt-a" href="#subscribe">What happens when you subscribe</a>
      </p>
    </div>

    <div class="nlt-hero__vis nlt-hero__up" style="--i:5">
      <p class="bdh-sr">The card that follows is a preview of the format — the header lines of an issue and the six
        blocks every issue is made of. It is not a live mailbox and no issue has been sent.</p>

      <article class="nlt-hero__card nlt-paper" data-bdh-live>
        <header class="nlt-hero__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="nlt-hero__barl">Reading pane</span>
          <span class="nlt-sample">Sample issue</span>
        </header>

        <dl class="nlt-hero__rows">
          <div><dt>From</dt><dd><?= e($hero_m['name']) ?> · <?= e($hero_m['from']) ?>
            <!-- PLACEHOLDER: confirm the sending address, SPF/DKIM and the reply-to inbox before launch. -->
            <span class="nlt-hero__addr">&lt;<?= e($hero_m['sender']) ?>&gt;</span></dd></div>
          <div><dt>To</dt><dd><?= e($NLT['issue']['to']) ?></dd></div>
          <div class="nlt-hero__subj"><dt>Subject</dt><dd><span data-hero-subject><?= e($hero_subjects[0]) ?></span><span class="bdh-caret" aria-hidden="true"></span></dd></div>
        </dl>

        <ol class="nlt-hero__blocks">
          <?php foreach ($NLT['blocks'] as $hero_b): ?>
            <li>
              <span class="nlt-hero__bn"><?= e($hero_b['n']) ?></span>
              <span class="nlt-hero__bi" aria-hidden="true"><?= xt_icon($hero_b['icon'], ['size' => 16]) ?></span>
              <span class="nlt-hero__bt"><?= e($hero_b['name']) ?></span>
              <span class="nlt-hero__bw"><?= (int) $hero_b['words'] ?> w</span>
            </li>
          <?php endforeach; ?>
        </ol>

        <footer class="nlt-hero__foot">
          <!-- PLACEHOLDER: the unsubscribe link and the List-Unsubscribe header come from the email service. Confirm before launch. -->
          <span>Unsubscribe · one click, no survey</span>
          <span class="nlt-hero__foot2">Replies reach a person</span>
        </footer>
      </article>
    </div>
  </div>

  <div class="wrap">
    <dl class="nlt-hero__facts" data-rv data-rv-d="120">
      <?php foreach ($hero_facts as $hero_f): ?>
        <div>
          <dt><?= e($hero_f[0]) ?></dt>
          <dd><?= e($hero_f[1]) ?></dd>
          <dd class="nlt-hero__ft"><?= e($hero_f[2]) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
