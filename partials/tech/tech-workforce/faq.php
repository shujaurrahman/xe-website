<?php /* DRAFT COPY — review before launch */
/* FAQ — the eight questions an engineering leader asks before signing, returned the way a buyer
   actually receives them: as a written answer sheet. Each row is a numbered question, our answer in
   full, and the part of this page that evidences it — the same shape as the response we send to a
   security or procurement questionnaire.
   Deliberately NOT an accordion: sibling pages in this discipline use one, and an answer that is
   already on the page is the point here. Every answer is real page text, open, and findable.
   Five answers come from $CAP['faq']; the start time, interview rights and replacement answers are
   the page's own. */
$ttw_fq_c = $CAP['faq'] ?? [];
$ttw_fq = [
    ['Starting', 'How fast can someone actually start?',
        'Profiles reach you within about five working days of an agreed brief, interviews run the week after, and a typical start date is two to four weeks from signature. Notice periods are the usual constraint. Where an engineer is between engagements, or the role matches someone already on your account, it can be sooner.',
        'The thirty-day onboarding track', 'onboarding'],
    ['Starting', 'Can we interview candidates ourselves, and say no?',
        'Yes, and we expect you to. Every profile arrives with the assessment record behind it, and you interview whoever you want to before a start date is agreed. You can decline without giving a reason and we send the next profile. Nobody is introduced to you before they have passed our own stages.',
        'The six-stage vetting funnel', 'vetting'],
    ['Managing', $ttw_fq_c[1][0] ?? 'Who manages the engineers day to day?',
        $ttw_fq_c[1][1] ?? 'Embedded engineers take direction from your team leads, in your rituals.',
        'Who directs the work, by model', 'models'],
    ['Managing', $ttw_fq_c[3][0] ?? 'Which time zones do you cover?',
        $ttw_fq_c[3][1] ?? 'Teams work from India, with overlap hours agreed per engagement.',
        'The overlap windows, hour by hour', 'overlap'],
    ['Delivery', $ttw_fq_c[0][0] ?? 'How is this different from a recruitment agency?',
        $ttw_fq_c[0][1] ?? 'Engineers are vetted by engineers and supported by a delivery lead.',
        'What is reported every sprint', 'governance'],
    ['Delivery', 'What happens if someone is not the right fit?',
        'Tell the delivery manager. Inside the first two weeks we replace the engineer at our cost and you are not charged for the time. After that, a replacement runs to the window written into your contract, with a handover from the outgoing engineer wherever notice allows it. The reason is recorded and fed back into how we brief and assess for your account.',
        'The replacement commitment', 'governance'],
    ['Security', $ttw_fq_c[2][0] ?? 'What about IP, security and confidentiality?',
        $ttw_fq_c[2][1] ?? 'Work happens in your repositories and tools under your security policies.',
        'The controls in full', 'security'],
    ['Commercial', $ttw_fq_c[4][0] ?? 'Can we hire the engineers permanently?',
        $ttw_fq_c[4][1] ?? 'Conversion terms can be agreed in the contract.',
        'Build–operate–transfer terms', 'models'],
];
$ttw_fq_ask = [
    ['doc', 'A sample sprint report', 'Redacted, from a comparable engagement'],
    ['clipboard-check', 'An anonymised assessment scorecard', 'So you can see what we actually test'],
    ['shield', 'Our answers to your security questionnaire', 'Returned inside five working days'],
    ['users', 'A reference call', 'With a client running a similar squad'],
];
?>
<section class="band band--alt ttw-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Asked directly</p>
        <h2 class="h2" id="faq-t"><span class="g">Eight questions</span> worth asking before you sign anything.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">These come up in almost every first call. The answers are the same ones we would give you on that call, written out, each one pointing at the part of this page that evidences it. Nothing here is hidden behind a click.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm the two-week no-charge replacement and the contractual replacement window before launch -->
    <div class="ttw-faq__sheet" data-rv>
      <p class="ttw-faq__sh">
        <span class="ttw-lbl">Answer sheet · Tech Workforce</span>
        <span class="ttw-ro"><?= count($ttw_fq) ?> of <?= count($ttw_fq) ?> answered · every answer evidenced on this page</span>
      </p>

      <ol class="ttw-faq__rows">
        <?php foreach ($ttw_fq as $ttw_fq_i => $ttw_fq_it): ?>
          <li class="ttw-faq__r" data-rv data-rv-s>
            <p class="ttw-faq__meta">
              <span class="ttw-faq__ref">Q-<?= str_pad((string) ($ttw_fq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="ttw-faq__cat"><?= e($ttw_fq_it[0]) ?></span>
            </p>
            <div class="ttw-faq__qa">
              <h3 class="ttw-faq__q"><?= e($ttw_fq_it[1]) ?></h3>
              <p class="ttw-faq__a"><?= e($ttw_fq_it[2]) ?></p>
            </div>
            <p class="ttw-faq__ev">
              <span class="ttw-lbl">Evidenced by</span>
              <a class="tl" href="#<?= e($ttw_fq_it[4]) ?>"><?= e($ttw_fq_it[3]) ?> <span class="i" aria-hidden="true">›</span></a>
            </p>
          </li>
        <?php endforeach; ?>
      </ol>

      <p class="ttw-faq__foot">Send your own sheet and we will answer it the same way — in writing, against the same evidence, whether or not it looks like this one.</p>
    </div>

    <div class="ttw-faq__after">
      <div class="ttw-card ttw-faq__c">
        <p class="ttw-lbl">Before you decide</p>
        <h3 class="bdh-t ttw-faq__ch">Ask us for the evidence</h3>
        <p class="bdh-d">A brief is easier to write once you have seen what the work looks like. Any of these can be sent before a contract exists.</p>
        <ul class="ttw-faq__ask" role="list">
          <?php foreach ($ttw_fq_ask as $ttw_fq_a): ?>
            <li>
              <span class="ttw-faq__aic" aria-hidden="true"><?= xt_icon($ttw_fq_a[0], ['size' => 17]) ?></span>
              <span class="ttw-faq__atx"><b><?= e($ttw_fq_a[1]) ?></b><span><?= e($ttw_fq_a[2]) ?></span></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <!-- PLACEHOLDER: confirm that sample reports, scorecards and reference calls can be offered, and the questionnaire turnaround, before launch -->
      </div>

      <div class="ttw-card ttw-faq__c ttw-faq__c--go">
        <h3 class="bdh-t ttw-faq__ch">Still an unanswered question?</h3>
        <p class="bdh-d">Send the roles, the stack and the date you need people working. You will get a written answer, not a call-back form.</p>
        <p class="ttw-faq__cta">
          <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>?from=tech-workforce"><?= e($CAP['cta'] ?? 'Start a team brief') ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="ttw-btn" href="#composer">Build a squad first</a>
        </p>
      </div>
    </div>

  </div>
</section>
