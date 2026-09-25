<?php /* DRAFT COPY — review before launch */
/* Route — what happens between pressing send and having a scope in writing. Five stations on one
   line, each with the hour or day it is aimed at, then the three things you get back and the
   commercial facts people ask for before they write in. Shown in the form state and again after a
   brief is sent, where it reads as "what happens next".
   PLACEHOLDER: every time on this page is a target, not a guarantee — confirm all of them before launch. */
$ct_rt_stations = [
    ['workflow', 'Hour 0',            'It arrives as one email',
     'Routed by the services you ticked to the lead for that discipline. No auto-reply pretends to be a person, and no sequence starts.'],
    ['users',    'Same working day',  'A practitioner reads it',
     'The discipline lead, with an engineer or a designer alongside them when the brief is technical. Your attachment is opened here, not before.'],
    ['chat',     'Within 1 working day', 'You hear back either way',
     'Questions, a time to talk, or a straight no with the reason — and the name of someone better suited when we know one.'],
    ['calendar', 'That week',         'Thirty minutes, with the people who would do it',
     'No slide deck and no account manager. We use the time to test whether the problem is the one you think it is.'],
    ['doc',      'Within a week of the call', 'A scope, in writing',
     'What we would do, who would do it, how long it would take, a price range, and what we would need from you. Under NDA if you asked for one.'],
];
/* PLACEHOLDER: confirm each of these commitments and its timing before launch */
$ct_rt_facts = [
    ['First reply',    'One working day, from a practitioner'],
    ['First call',     'Thirty minutes, no slide deck'],
    ['Under NDA',      'Signed before anything detailed is shared'],
    ['Outline scope',  'Within a week of the call'],
    ['Cost to you',    'Nothing until a statement of work is signed'],
];
$ct_rt_back = [
    ['approve', 'A straight yes',
     'The shape of the work, the team, the length and a price range — enough to take to whoever holds the budget.'],
    ['filter',  'Or a straight no',
     'We say no when it is not our work, when the timing cannot hold, or when you would be better served elsewhere. We say which of the three it is.'],
    ['sync',    'Or a smaller first step',
     'Often the honest answer is that the brief is too big to price. Then we propose a one-to-three week sprint that makes it pricable.'],
];
?>
<section class="band ct-route" id="route" aria-labelledby="route-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row ct-route__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span><?= $ct_sent ? 'What happens now' : 'After you press send' ?></p>
        <h2 class="h2" id="route-t"><span class="g">From your inbox to a scope,</span> in five moves.</h2>
      </div>
      <div>
        <p class="lead">Every step below has a person attached to it. The times are what we aim for and hold ourselves to, not a promise printed on a contract.</p>
      </div>
    </div>

    <ol class="ct-rt" data-rv-s data-rv-step="70">
      <?php foreach ($ct_rt_stations as $ct_i => $ct_st): ?>
        <li class="ct-rt__i" style="--i:<?= $ct_i ?>">
          <span class="ct-rt__line" aria-hidden="true"></span>
          <span class="ct-rt__node" aria-hidden="true"><?= xt_icon($ct_st[0], ['size' => 20]) ?></span>
          <p class="ct-rt__when"><?= e($ct_st[1]) ?></p>
          <h3 class="ct-rt__t"><span class="ct-rt__n"><?= str_pad((string) ($ct_i + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($ct_st[2]) ?></h3>
          <p class="ct-rt__d"><?= e($ct_st[3]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="ct-route__grid">
      <ul class="ct-back">
        <?php foreach ($ct_rt_back as $ct_b): ?>
          <li class="ct-back__i">
            <span class="ct-back__ico" aria-hidden="true"><?= xt_icon($ct_b[0], ['size' => 22]) ?></span>
            <h3 class="bdh-t bdh-t--s"><?= e($ct_b[1]) ?></h3>
            <p class="bdh-d"><?= e($ct_b[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="ct-facts">
        <p class="ct-facts__k">What we commit to</p>
        <!-- PLACEHOLDER: confirm every response time and commitment below before launch -->
        <dl class="ct-facts__l">
          <?php foreach ($ct_rt_facts as $ct_f): ?>
            <div><dt><?= e($ct_f[0]) ?></dt><dd><?= e($ct_f[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <?php if (!$ct_sent): ?>
          <a class="tl ct-facts__go" href="#brief">Back to the brief <span class="i" aria-hidden="true">›</span></a>
        <?php else: ?>
          <a class="tl ct-facts__go" href="<?= xe_url('services/') ?>">See what we do <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
