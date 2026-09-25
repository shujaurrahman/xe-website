<?php /* DRAFT COPY — review before launch */
/* What we look for — the four signals we actually read, what we deliberately do not screen on, and
   four practical things that make an application easy to say yes to. No JavaScript: the whole section
   is static text. Locals prefixed bar_. */

$bar_signals = [
    ['ico' => 'eval', 'k' => 'Evidence over adjectives',
     'p'  => 'Show the work and the reasoning behind it. Three projects explained properly beats twenty thumbnails. For engineering, a repository or a written breakdown of something you built and then had to live with.',
     'ex' => 'A case that includes the constraint you were given and the thing you got wrong.'],
    ['ico' => 'layers', 'k' => 'Depth in one craft, literacy in the next',
     'p'  => 'We hire specialists, not generalists. But you will sit next to four other practices, so you need enough literacy to read their work and argue with it usefully.',
     'ex' => 'A designer who can read a pull request. An engineer who can tell a good grid from a bad one.'],
    ['ico' => 'doc', 'k' => 'You write clearly',
     'p'  => 'Two studios and client teams in other cities mean most decisions travel as writing. Short, specific, no hedging. This is the single most common reason an otherwise strong application does not progress.',
     'ex' => 'Your covering note is a work sample. We read it as one.'],
    ['ico' => 'approve', 'k' => 'You can be wrong in public',
     'p'  => 'Weekly critique only works if people can hear "this is not there yet" and come back with a better version. We look for that in the conversation, not on the CV.',
     'ex' => 'Tell us about a decision you reversed and what changed your mind.'],
];

$bar_not = [
    'Where you went to university, or whether you did. No degree filter, at any level.',
    'Whether you have worked at a name we recognise. We read the work, not the logo beside it.',
    'Algorithm puzzles on a whiteboard. Engineering conversations are about code you have actually written.',
    'Years of experience as a hard gate. The number in a role is a guide to the scope, not a door policy.',
    'Gaps on a CV. Tell us what happened if you want to; we will not read anything into silence.',
];

$bar_tips = [
    ['Apply once, for the closest role.',   'One considered application reads better than five. If two roles genuinely fit, say so in the note and we will route it.'],
    ['Lead with the work.',                 'A link that opens straight onto the work, not a landing page. If it needs a password, put the password in the note.'],
    ['Say what you did, specifically.',     'On team projects, name your part. "I led the identity; the motion was by someone else" costs you nothing and buys trust.'],
    ['Tell us what you want next.',         'The best applications say what they want to get better at. It is how we work out whether this role would actually do that for you.'],
];
?>
<section class="band car-bar" id="bar" aria-labelledby="bar-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What we look for</p>
        <h2 class="h2" id="bar-t"><span class="g">Four signals we read,</span> and five we ignore.</h2>
      </div>
      <div>
        <p class="lead">The bar is high and it is specific. It is not a personality test, and it is not a list of tools. Here is what a reviewer is actually looking for when your application lands.</p>
      </div>
    </div>

    <ul class="car-bar__grid" role="list" data-rv-s data-rv-step="70">
      <?php foreach ($bar_signals as $bar_i => $bar_s): ?>
        <li class="bdh-card bdh-card--lift car-bar__card">
          <span class="car-bar__ico" aria-hidden="true"><?= xt_icon($bar_s['ico'], ['size' => 26]) ?></span>
          <p class="bdh-idx"><?= str_pad((string) ($bar_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="bdh-t bdh-t--l car-bar__t"><?= e($bar_s['k']) ?></h3>
          <p class="bdh-d car-bar__d"><?= e($bar_s['p']) ?></p>
          <p class="car-bar__ex"><?= e($bar_s['ex']) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="car-bar__split">
      <div class="car-bar__not" data-rv>
        <p class="car-k car-k--warn">What we do not screen on</p>
        <ul class="bdh-bullets">
          <?php foreach ($bar_not as $bar_x): ?><li><?= e($bar_x) ?></li><?php endforeach; ?>
        </ul>
      </div>

      <div class="car-bar__tips" data-rv data-rv-d="90">
        <p class="car-k car-k--blue">How to make it easy to say yes</p>
        <ol class="car-bar__tiplist">
          <?php foreach ($bar_tips as $bar_i => $bar_t): ?>
            <li>
              <span class="bdh-idx"><?= str_pad((string) ($bar_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <b><?= e($bar_t[0]) ?></b>
              <span><?= e($bar_t[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>
