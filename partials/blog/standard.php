<?php /* DRAFT COPY — review before launch */
/* The standard — what we will and will not publish. It sits on the page for the same reason the
   measures sit on a case study: a rule that is written down can be held against us. The "will not"
   column is the part that matters, so it is given equal weight rather than a footnote. */
$std_will = [
    ['Show the working', 'Every claim that can be checked carries the number, the definition and the source. Where a figure is illustrative, it says so beside itself.'],
    ['Publish the constraints', 'A decision only makes sense against what could not be changed. Case studies lead with the constraints, before any solution appears.'],
    ['Name what we got wrong', 'The judgement call in each case study includes the argument we nearly lost, and sometimes the one we did.'],
    ['Date the corrections', 'A substantive change adds an updated date and a line saying what moved. Silent edits are how a record stops being one.'],
    ['Check it with someone else', 'Technical content is reviewed by a person who did not write it, from the practice that owns the subject.'],
    ['Write it ourselves', 'Drafts come from the people who did the work. AI assists with structure and edit passes; nothing is published unread or unchecked.'],
];
$std_wont = [
    ['A client’s name without written permission', 'Not in a title, not in a quote, not implied by a photograph or a logo.'],
    ['A result without approved wording', 'No outcome number is published until the client has approved the exact sentence it sits in.'],
    ['A testimonial we wrote', 'Quotes are the client’s words or they are not there.'],
    ['A benchmark we cannot source', 'Industry averages carry the study and the year, or they do not appear.'],
    ['A photograph that implies something untrue', 'Reference imagery is labelled as reference imagery, and never presented as our office, our team or a client’s site.'],
    ['A post written to rank', 'Search is a distribution channel, not a brief. If a piece has nothing to say, it is not published.'],
];
?>
<section class="band blg-std" id="standard" aria-labelledby="standard-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The standard</p>
        <h2 class="h2" id="standard-t"><span class="g">What goes in,</span> and what never will.</h2>
      </div>
      <div><p class="lead">Publishing about client work is a trust problem before it is a marketing one. These are the rules the journal is held to, written so you can hold us to them.</p></div>
    </div>

    <div class="blg-std__grid">
      <div class="blg-std__col blg-std__col--will">
        <p class="blg-std__ck"><span class="blg-std__ico blg-std__ico--yes" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="m5 12.5 4.2 4.2L19 7"/></svg>
        </span>What we publish</p>
        <ol class="blg-std__l" data-rv-s data-rv-step="50">
          <?php foreach ($std_will as $std_i => $std_row): ?>
            <li>
              <span class="blg-std__n" aria-hidden="true"><?= e(str_pad((string) ($std_i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
              <h3 class="blg-std__t"><?= e($std_row[0]) ?></h3>
              <p class="blg-std__d"><?= e($std_row[1]) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="blg-std__col blg-std__col--wont">
        <p class="blg-std__ck"><span class="blg-std__ico blg-std__ico--no" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" focusable="false"><path d="M7 7l10 10M17 7 7 17"/></svg>
        </span>What we will not</p>
        <ul class="blg-std__l blg-std__l--wont" data-rv-s data-rv-step="50">
          <?php foreach ($std_wont as $std_row): ?>
            <li>
              <h3 class="blg-std__t"><?= e($std_row[0]) ?></h3>
              <p class="blg-std__d"><?= e($std_row[1]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <p class="blg-std__foot">
      Found something wrong in a post? Tell us and we will correct it with a date on it —
      <a class="blg-a" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= rawurlencode('Correction — the Journal') ?>"><?= e($SITE['company']['email']) ?></a>.
    </p>
  </div>
</section>
