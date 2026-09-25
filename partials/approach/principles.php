<?php /* DRAFT COPY — review before launch */
/* Principles — the second half of the hero paid off: "what has not changed is what we stand for". Six
   positions, each written as something that costs us something, because a principle that costs nothing
   is a slogan. On ink, so it reads as the page's closing statement before the questions. */
$aprp_items = [
    ['We say what we think',
     'If the brief is wrong, we say so before we quote for it. If a route we proposed turns out worse than the alternative, we say that too, in the weekly report, in writing.',
     'It has cost us work. It has never cost us a client.'],
    ['One name, answerable',
     'Every engagement has one senior lead who stays for the whole thing and a named deputy. When something goes wrong, that person calls you before you call us.',
     'No account manager between you and the people building it.'],
    ['You own the output',
     'Code, design source, prompts, eval sets, infrastructure, documentation. Transferred as created, not at the end, and with nothing that needs a licence from us to keep running.',
     'Leaving is a handover, not a negotiation.'],
    ['We measure what we promised',
     'The measure, the baseline, the window and the verifier are agreed before delivery starts. We report against that number even when it has not moved.',
     'The number is the client\'s, taken from the client\'s systems.'],
    ['We will not ship what we would not run',
     'If we would not be on call for it, it does not go live. That applies to accessibility and security as firmly as it applies to uptime.',
     'It is why a date moves before a standard does.'],
    ['AI does the work, people carry the responsibility',
     'Agents draft, test, scan and deploy, and they are faster than us at all four. Nobody gets to blame a model for a decision a person signed.',
     'Every approval has a name on it.'],
];
?>
<section class="band band--ink apr-principles" id="principles" aria-labelledby="principles-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What has not changed</p>
      <h2 class="h2" id="principles-t"><span class="g">The tools changed.</span> These did not.</h2>
      <p class="lead">Six positions we hold when they are inconvenient, which is the only time a position
        means anything.</p>
    </div>

    <ol class="apr-pr__grid" data-rv-s data-rv-step="70">
      <?php foreach ($aprp_items as $aprp_i => $aprp_p): ?>
        <li class="apr-pr__card">
          <span class="bdh-idx"><?= str_pad((string) ($aprp_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bdh-t bdh-t--l"><?= e($aprp_p[0]) ?></h3>
          <p class="bdh-d"><?= e($aprp_p[1]) ?></p>
          <p class="apr-pr__cost"><?= e($aprp_p[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
