<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions this page reliably raises. <details> so every answer is reachable, printable
   and readable with JavaScript off; the first is open in the markup. */
$wrk_faq = [
    ['Why can’t I see who you worked with?',
     'Because we did not ask for permission at the start, and asking afterwards puts a client’s communications and legal teams to work for our benefit. Where a client has given written permission, we name them. Everywhere else the sector carries the context and the rest is shared under an agreement.'],
    ['Can I see the real screens and the real numbers?',
     'Yes, under an NDA, for a programme relevant to what you are buying. That walk-through includes the baseline, the target, where it landed, and the parts that did not work. It is a conversation, not a deck.'],
    ['Are these all the programmes you have run?',
     'No. This page publishes the ones we can describe usefully without naming anyone. <!-- PLACEHOLDER: confirm the real portfolio size and the earliest date it covers before launch --> The set we can discuss in a room is larger, and it includes work that never became a public launch.'],
    ['Why do the entries list measures but not results?',
     'Because a measure is ours to state and a result is the client’s to approve. Publishing “+38% conversion” without the baseline, the period and the definition is not evidence, it is decoration. The measure tells you what we were held to; the walk-through tells you what happened.'],
    ['What size of programme do you take on?',
     'The programmes on this page typically run from two months to a year, with a team of one squad and, where a programme spans disciplines, a lead from each. Shorter pieces of work — an audit, a system, a single build — are listed under each discipline.'],
    ['Can you work alongside our in-house team or our existing agency?',
     'Usually yes, and often that is the point. Several of the programmes above were built to be handed to an in-house team, and the handover was designed from the first week rather than bolted on at the end.'],
    ['Who owns what you build?',
     'You do. Work is built in your accounts and your repositories, and the intellectual property in it is yours on payment. Anything we bring with us is named up front, with the terms it comes under. <!-- PLACEHOLDER: confirm the standard IP and licensing position with counsel before launch -->'],
    ['What happens when we want to take it in-house?',
     'That is a planned stage, not an exit event. Documentation is written as the work is built, the handover is rehearsed with the receiving team, and we stay on a reducing commitment for an agreed period rather than disappearing on a date.'],
];
?>
<section class="band wrk-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">What this page</span> does not say, and why.</h2>
      </div>
      <div>
        <p class="lead">The honest answers to the questions a portfolio without logos raises. If yours is not here, ask it — we will answer straight.</p>
        <a class="tl" href="<?= xe_url('contact.php') ?>">Ask us directly <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ul class="wrk-faq__list">
      <?php foreach ($wrk_faq as $wrk_i => $wrk_q2): ?>
      <li>
        <details class="wrk-q"<?= $wrk_i === 0 ? ' open' : '' ?>>
          <summary><span class="bdh-idx"><?= wrk_n($wrk_i + 1) ?></span><span class="wrk-q__t"><?= e($wrk_q2[0]) ?></span><span class="wrk-q__p" aria-hidden="true"></span></summary>
          <div class="wrk-q__a"><p class="p"><?= $wrk_q2[1] ?></p></div>
        </details>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<script type="application/ld+json"><?= json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($wrk_q2) => [
        '@type'          => 'Question',
        'name'           => $wrk_q2[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => trim(preg_replace('~<!--.*?-->~s', '', $wrk_q2[1]))],
    ], $wrk_faq),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
