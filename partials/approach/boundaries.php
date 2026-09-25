<?php /* DRAFT COPY — review before launch */
/* Boundaries — the eight things we decline, each with the reason and what we do instead. A page about how
   we work is not complete without what we refuse, and every line here is enforceable somewhere else on the
   page: a guardrail, a gate, a clause or a named owner. Typographic, no mock, no motion beyond the reveal. */
$bd = [
  ['Put AI in front of your customers with nobody accountable for what it says',
   'An assistant that answers in your name is your voice. A voice needs an owner, not a disclaimer.',
   'A named owner, a written guardrail policy, an escalation rule for anything sensitive, and a weekly human review of a sample of real answers.',
   'agents'],
  ['Train shared models on your data',
   'Your data is the part of this that competitors cannot copy. A shared model gives it away quietly and permanently.',
   'Enterprise endpoints with training turned off, in your region where it matters, and retention set per project and written into the contract.',
   'responsible'],
  ['Publish a claim we cannot source',
   'An unsupported superlative is a legal problem and a trust problem in the same sentence.',
   'The claims guardrail holds it before a person sees it. We come back for the evidence, or we change the line.',
   'agents'],
  ['Hit a date by skipping a gate',
   'The gates are the only thing standing between a deadline and a defect in production. Removing them does not make the work faster; it moves the cost.',
   'You hear that a date is at risk in the week it becomes at risk, with what could come out of scope to protect it.',
   'delivery'],
  ['Staff a programme with people we will not name',
   '“A team of experts” with no names is how a good proposal becomes a poor delivery.',
   'The statement of work names the people. If one has to change, you are told and asked, not informed afterwards.',
   'scope'],
  ['Design something to work against the person using it',
   'Dark patterns work once and cost for years — in refunds, in complaints, and now in regulation.',
   'Consent that can be refused as easily as it is given, cancellation as easy as sign-up, and defaults we would be happy to explain in public.',
   'quality'],
  ['Hold your work hostage',
   'Leaving should be a decision, not a project. A dependency you cannot exit is a price rise waiting to happen.',
   'Accounts in your name from day one, standard formats, your repositories, and an exit test your own engineer signs.',
   'handover'],
  ['Take work we cannot do well',
   'Saying yes to everything is how agencies become unreliable. We would rather lose the work than be the reason it goes badly.',
   'We say so early, tell you what we would need to do it properly, and where we can, point you at someone who already does it well.',
   'contracts'],
];
$bd_at = [
  'agents' => 'The agent register', 'responsible' => 'Responsible AI', 'delivery' => 'How a project runs',
  'scope' => 'Scope and change', 'quality' => 'Quality bars', 'handover' => 'Handover and IP', 'contracts' => 'Six ways to engage',
];
?>
<section class="band band--alt apr-wn" id="boundaries" aria-labelledby="boundaries-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What we will not do</p>
        <h2 class="h2" id="boundaries-t"><span class="g">Eight things</span> we decline, and what we do instead.</h2>
      </div>
      <div>
        <p class="lead">A page about how we work is not honest without the refusals. Each of these is enforced somewhere real — a guardrail, a gate, a clause or a named owner — and each one links to the part of this page that carries it.</p>
      </div>
    </div>

    <ol class="apr-wn__list" data-rv-s data-rv-step="60">
      <?php foreach ($bd as $bd_i => $bd_r): ?>
      <li class="apr-wn__row">
        <p class="apr-wn__n"><span class="apr-wn__x" aria-hidden="true"></span><?= str_pad((string) ($bd_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
        <h3 class="apr-wn__t"><span class="apr-wn__pre">We will not</span> <?= e($bd_r[0]) ?></h3>
        <div class="apr-wn__why">
          <p class="apr-k">Why</p>
          <p class="apr-wn__p"><?= e($bd_r[1]) ?></p>
        </div>
        <div class="apr-wn__do">
          <p class="apr-k">What we do instead</p>
          <p class="apr-wn__p"><?= e($bd_r[2]) ?></p>
          <a class="apr-wn__lk" href="#<?= e($bd_r[3]) ?>">Enforced in <?= e($bd_at[$bd_r[3]]) ?> <span class="i" aria-hidden="true">›</span></a>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
