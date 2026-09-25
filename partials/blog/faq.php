<?php /* DRAFT COPY — review before launch */
/* Questions about the journal itself — publishing, permission, syndication and corrections. Native
   <details>, so every answer is reachable with JavaScript off and the browser handles the keyboard. */
$faq_rows = [
    ['How often is something published?',
     'When there is something worth writing, which in practice is a handful of pieces a quarter rather than a weekly cadence. The journal is written alongside delivery by the people doing it, so it moves at the pace of the work. <!-- PLACEHOLDER: confirm the publishing cadence before launch. -->'],
    ['Why are the case studies anonymous?',
     'Because permission is specific. A client may be happy for the work to be described and unhappy for their name to sit beside a number, or bound by an agreement that settles it for them. Attribution by sector lets the useful part — the constraints, the decisions, the handover — be published without asking anyone to carry a risk they did not agree to.'],
    ['Can we be named?',
     'Yes, with written permission covering the exact words. If you are a client and would like the work attributed, tell us and we will send the passage for approval before anything changes.'],
    ['Where do the results go?',
     'A case study publishes the measures and their definitions, and publishes a result only once the client has approved the sentence it appears in. That is why several case files here end with an honest note instead of a percentage.'],
    ['Can I republish or quote a post?',
     'Quote freely with a link back. For a full republication, ask first — some posts describe client work under terms that limit where it can appear.'],
    ['Do you accept contributed posts?',
     'No. Everything here is written in-house by the practice that did the work, which is the only reason any of it is worth reading.'],
    ['How is AI used in writing these?',
     'For structure, edit passes and checking our own arguments back. Drafting comes from the people who did the work, every technical claim is verified against a primary source, and a person who did not write the post reviews it before it goes out. Nothing is generated and published unread.'],
    ['Something here is wrong. What happens?',
     'Tell us and we will fix it with a date on it. A substantive correction adds an updated date and a line saying what changed; we do not edit a record silently.'],
];
?>
<section class="band band--alt blg-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>About the journal</p>
        <h2 class="h2" id="faq-t"><span class="g">Questions about publishing,</span> permission and corrections.</h2>
      </div>
      <div>
        <p class="lead">If the answer you need is not here, write to <a class="blg-a" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a> and we will answer it — and probably add it.</p>
      </div>
    </div>

    <div class="blg-faq__l">
      <?php foreach ($faq_rows as $faq_i => $faq_row): ?>
        <details class="blg-faq__i"<?= $faq_i === 0 ? ' open' : '' ?>>
          <summary>
            <span class="blg-faq__n" aria-hidden="true"><?= e(str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
            <span class="blg-faq__q"><?= e($faq_row[0]) ?></span>
            <span class="blg-faq__mk" aria-hidden="true"></span>
          </summary>
          <div class="blg-faq__a"><p><?= $faq_row[1] ?></p></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
