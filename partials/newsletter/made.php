<?php /* DRAFT COPY — review before launch */
/* How an issue is made — the production line, seven steps on one rail, each with the rule that governs
   it. Then the part most newsletters leave out: exactly where AI is used in writing it and where it is
   not. The rail is built from CSS rules rather than an SVG, so there is no line running under a node
   and nothing to draw. Ink band: this is the machinery, not the sales pitch. */
$made_steps = [
    ['01', 'Noticed', 'Something changes in the work — a decision, a failure, a measurement that surprised someone.',
     'The desk that hit it writes it down the same week, while the detail is still there.'],
    ['02', 'Drafted', 'By the person who did the work, not by a marketing team from a brief.',
     'If nobody on the desk will put their name to it, it does not get written.'],
    ['03', 'Checked', 'Every technical claim goes back to a primary source — the specification, the standard, the RFC.',
     'The source is named in the issue so you can disagree with it without asking us for it.'],
    ['04', 'Reviewed', 'Someone who did not write it reads it before it can be sent.',
     'Anything a client has not approved in writing comes out at this step, including numbers.'],
    ['05', 'Built', 'An HTML part and a plain-text part that reads properly on its own, tested in the common clients.',
     'No image carries meaning, no web font is required to read it, and there is no tracking pixel.'],
    ['06', 'Sent', 'One send, in the stated window, to everyone who confirmed.',
     'No subject-line split test, no send-time optimisation, no re-send to people who did not open.'],
    ['07', 'Published', 'The web version goes into the archive on this page on the day it is sent.',
     'A correction is made in public with a date on it and a line saying what changed.'],
];
$made_ai = [
    'yes' => [
        ['Structure', 'Reordering an argument, finding the paragraph that should have been first.'],
        ['Edit passes', 'Cutting length, flattening jargon, catching the sentence that says nothing.'],
        ['Arguing back', 'Asking a model to attack the draft’s reasoning so a person has to answer it.'],
        ['Alt text', 'Drafting alternative text for any figure, then a person checks it against the figure.'],
    ],
    'no' => [
        ['Drafting from nothing', 'The first draft comes from the person who did the work. There is no other honest source for it.'],
        ['Generating claims', 'No technical claim, threshold or definition is taken from a model’s answer. It comes from the source.'],
        ['Writing the numbers', 'Figures come from the systems they describe, or they are not printed.'],
        ['Sending unread', 'Nothing is generated and sent without a person reading the whole thing.'],
    ],
];
?>
<section class="band band--ink nlt-made" id="made" aria-labelledby="made-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How an issue is made</p>
        <h2 class="h2" id="made-t"><span class="g">Seven steps,</span> and a rule at each one.</h2>
      </div>
      <div>
        <p class="lead">A newsletter is only worth an address if the thing behind it is disciplined. This is the
          line an issue goes down before it reaches you, including the steps that stop it.</p>
      </div>
    </div>

    <ol class="nlt-made__rail" data-rv-s data-rv-step="70">
      <?php foreach ($made_steps as $made_s): ?>
        <li class="nlt-made__st">
          <span class="nlt-made__node" aria-hidden="true"></span>
          <p class="nlt-made__n"><?= e($made_s[0]) ?></p>
          <h3 class="nlt-made__t"><?= e($made_s[1]) ?></h3>
          <p class="nlt-made__d"><?= e($made_s[2]) ?></p>
          <p class="nlt-made__r"><span class="nlt-made__rk">Rule</span><?= e($made_s[3]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="nlt-made__ai">
      <div class="nlt-made__aih" data-rv>
        <p class="nlt-k nlt-k--blue">AI, specifically</p>
        <h3 class="nlt-made__ait">Where a model is used in writing this, and where it is not.</h3>
        <p class="nlt-made__aid">We build AI systems for a living, so it would be strange to claim none of it touches
          the writing. Here is the line, drawn in the same place it is drawn on client work: a model can help a
          person think, and a person is accountable for every sentence that ships.</p>
        <p class="nlt-made__badge"><?= xt_badge('wcag22', ['variant' => 'chip']) ?><span>The email and its web version are built to the same accessibility standard as the rest of the site.</span></p>
      </div>

      <div class="nlt-made__cols">
        <div class="nlt-made__col">
          <header class="nlt-made__chw">
            <span class="nlt-made__cm nlt-made__cm--y" aria-hidden="true"><?= xt_icon('check', ['size' => 13]) ?></span>
            <h4 class="nlt-made__ch" id="made-yes">Used for</h4>
          </header>
          <dl class="nlt-made__cl">
            <?php foreach ($made_ai['yes'] as $made_r): ?>
              <div><dt><?= e($made_r[0]) ?></dt><dd><?= e($made_r[1]) ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </div>
        <div class="nlt-made__col">
          <header class="nlt-made__chw">
            <span class="nlt-made__cm nlt-made__cm--n" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" focusable="false"><path d="M6 6 18 18M18 6 6 18"/></svg>
            </span>
            <h4 class="nlt-made__ch" id="made-no">Never used for</h4>
          </header>
          <dl class="nlt-made__cl">
            <?php foreach ($made_ai['no'] as $made_r): ?>
              <div><dt><?= e($made_r[0]) ?></dt><dd><?= e($made_r[1]) ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</section>
