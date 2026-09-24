<?php /* DRAFT COPY — review before launch */
/* Why join, shown rather than claimed: what a new hire does in weeks 1–4, each week tied to the reason it
   matters, and the artefact they leave behind. The last week's artefact is a decision-log entry, rendered
   as a mock. PLACEHOLDER: confirm this onboarding plan with the hiring leads before launch. */
$car_weeks = [
  ['Week 1', 'Ship something small, for real', 'You pair with the lead on a live engagement and push one change to production or to a client review. No sandbox project.',
   'Work that ships at scale', 'Merged change · reviewed by your lead', 'git-branch'],
  ['Week 2', 'Set up your agents', 'You get your own AI workspace and build one agent for the repetitive part of your role: drafts, checks, variants or monitoring. It runs against a small eval set before anyone relies on it.',
   'AI as your tooling, not your replacement', 'Agent + eval set · 20 cases, pass rate logged', 'agent'],
  ['Week 3', 'Sit in the other five disciplines', 'You join one weekly review outside your discipline: an engineer in a brand critique, a designer in a campaign read-out, a strategist in a model evaluation.',
   'Six disciplines in one room', 'Review notes · one question you raised', 'users'],
  ['Week 4', 'Own a decision, in writing', 'You make a call on your workstream and write it up in the decision log: the options, the trade-off, what would change your mind. It carries your name.',
   'Seniority without the politics', 'Decision-log entry · credited to you', 'doc'],
];
?>
<section class="band band--alt car-why" id="why" aria-labelledby="why-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Your first month</p>
        <h2 class="h2" id="why-t"><span class="g">Four weeks in,</span> you will have shipped, built and decided.</h2></div>
      <div><p class="lead">The reasons to join, shown as the plan we intend to run for every new hire. Each week leaves something behind that you can point to.</p></div>
    </div>

    <ol class="car-wk">
      <?php foreach ($car_weeks as $car_n => $car_w): ?>
      <li class="car-wk__i">
        <p class="car-wk__k"><span class="car-wk__node" aria-hidden="true"><?= xt_icon($car_w[5]) ?></span><span class="car-wk__w"><?= e($car_w[0]) ?></span></p>
        <h3 class="car-wk__t"><?= e($car_w[1]) ?></h3>
        <p class="car-wk__p"><?= e($car_w[2]) ?></p>
        <p class="car-wk__why"><span>Why it matters</span><?= e($car_w[3]) ?></p>
        <p class="car-wk__out"><?= xt_icon('check') ?><span><?= e($car_w[4]) ?></span></p>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="car-log">
      <div class="car-log__copy">
        <p class="lbl"><span class="dot"></span>Week 4, in practice</p>
        <p class="car-log__t">A sample decision-log entry.</p>
        <p class="car-log__p">Every call that changes scope, quality or risk goes in the log with the reasoning and a name. Reviews read the log, not the loudest voice in the room.</p>
      </div>
      <div class="car-log__ui bdh-ui" aria-hidden="true">
        <div class="car-log__bar"><span class="bdh-ro">DECISION LOG · Your platform</span><span class="bdh-tag bdh-tag--blue">D-0142</span></div>
        <dl class="car-log__dl">
          <div><dt>Decision</dt><dd>Ship onboarding copy variants through the agent, with a human approving each market.</dd></div>
          <div><dt>Options</dt><dd>A · write by hand &nbsp; B · agent drafts, human approves &nbsp; C · agent publishes</dd></div>
          <div><dt>Chose</dt><dd>B. C failed 3 of 20 eval cases on regulated claims.</dd></div>
          <div><dt>Revisit if</dt><dd>Eval pass rate holds at 20/20 for two releases.</dd></div>
        </dl>
        <div class="car-log__foot"><span class="bdh-ro">Owner · New hire, week 4</span><span class="bdh-ok">Approved by lead</span></div>
      </div>
      <p class="bdh-sr">A sample decision-log entry: a new hire chooses to have an agent draft onboarding copy with a human approving each market, because letting the agent publish failed three of twenty evaluation cases on regulated claims, and records when the choice should be revisited.</p>
    </div>
  </div>
</section>
