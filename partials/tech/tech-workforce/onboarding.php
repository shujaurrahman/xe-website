<?php /* DRAFT COPY — review before launch */
/* Onboarding — the day-by-day track from a signed contract to a first merged pull request and a
   first sprint demo. The axis is a true 0–30 day scale: each pin sits at day ÷ 30, so the cluster
   in the first week is the picture and the gap from day 10 to day 30 is drawn at its real width.
   It is an axis, not a row of headings — it deliberately does not line up with the card grid below,
   which is a plain ordered list. Timings are typical and flagged.
   The photograph that used to head this section was removed in review: its alt described a desk
   being set up with a notebook and pen, which is not what the image showed. */
$ttw_ob = [
    [0,  'Day 0', 'Contract, NDA and IP assignment', 'Ours', 'Signed before anyone is named, with background verification complete.',
        ['NDA and IP assignment executed', 'Background verification on file', 'Named engineer confirmed to you']],
    [1,  'Day 1', 'Accounts through your SSO', 'Yours', 'Identity stays in your directory, so access is yours to grant and yours to revoke.',
        ['SSO account, least privilege', 'Repository and ticket access', 'Security briefing on your policy']],
    [2,  'Day 2', 'Codebase walkthrough', 'Both', 'Ninety minutes with your tech lead, recorded once so the next joiner does not need it live.',
        ['Architecture and service map', 'Branching and review rules', 'Runbook and on-call basics']],
    [3,  'Day 3', 'Local environment running', 'Ours', 'The environment builds from your README. Where it does not, we fix the README as the first contribution.',
        ['App running locally', 'Test suite green', 'README corrections raised']],
    [5,  'Day 5', 'First pull request merged', 'Both', 'Small and real: a bug, a test, a documentation fix. It proves access, environment and review path all work.',
        ['Change reviewed by your team', 'CI passing end to end', 'Deployed through your pipeline']],
    [10, 'Day 10', 'First sprint demo', 'Ours', 'The engineer presents their own work to your stakeholders at the end of the first sprint.',
        ['Committed work delivered', 'Demo to your stakeholders', 'Velocity baseline recorded']],
    [30, 'Day 30', 'Fit review', 'Both', 'A short structured review with your team lead: quality, communication, pace and anything to change.',
        ['Written fit review', 'Actions agreed', 'Replacement option still open']],
];
$ttw_ob_span = 30;                                   // the axis runs day 0 to day 30
$ttw_ob_p    = fn (float $d): string => round($d / $ttw_ob_span * 100, 3) . '%';
$ttw_ob_ticks = [0, 5, 10, 15, 20, 25, 30];
?>
<section class="band ttw-onb" id="onboarding" aria-labelledby="onboarding-t">
  <div class="wrap">

    <header class="ttw-head" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Onboarding</p>
        <h2 class="h2" id="onboarding-t"><span class="g">From signed</span> to first merged pull request.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Onboarding is a plan with owners and dates, not an introduction email. The target is a merged change in the first week — the fastest honest proof that access, environment and review path all work.</p>
        <span class="ttw-ill">Typical timings</span>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm typical onboarding timings and the fit-review window before launch -->
    <div class="ttw-onb__track" data-bdh-in data-ttw-arm>

      <figure class="ttw-onb__axis" aria-hidden="true">
        <p class="ttw-onb__scale">
          <?php foreach ($ttw_ob_ticks as $ttw_ob_t): ?>
            <span class="ttw-onb__tk" style="--p:<?= $ttw_ob_p((float) $ttw_ob_t) ?>"><?= $ttw_ob_t === 0 ? 'Day 0' : (int) $ttw_ob_t ?></span>
          <?php endforeach; ?>
        </p>
        <div class="ttw-onb__rail">
          <span class="ttw-onb__band ttw-onb__band--a" style="--s:0%;--w:<?= $ttw_ob_p(5) ?>"></span>
          <span class="ttw-onb__band ttw-onb__band--b" style="--s:<?= $ttw_ob_p(5) ?>;--w:<?= $ttw_ob_p(5) ?>"></span>
          <?php foreach ($ttw_ob as $ttw_ob_i => $ttw_ob_d): ?>
            <span class="ttw-onb__pin<?= in_array($ttw_ob_d[0], [5, 10, 30], true) ? ' ttw-onb__pin--k' : '' ?>" style="--i:<?= (int) $ttw_ob_i ?>;--p:<?= $ttw_ob_p((float) $ttw_ob_d[0]) ?>"></span>
          <?php endforeach; ?>
        </div>
        <figcaption class="ttw-onb__ann">
          <span class="ttw-onb__an" style="--p:0%">0–5 · first merged PR</span>
          <span class="ttw-onb__an" style="--p:<?= $ttw_ob_p(5) ?>">5–10 · first sprint demo</span>
          <span class="ttw-onb__an ttw-onb__an--end" style="--p:100%">Day 30 · fit review</span>
        </figcaption>
      </figure>
      <p class="bdh-sr">A thirty-day axis. Six of the seven milestones fall inside the first ten days — day 0, 1, 2, 3, 5 and 10 — and the seventh, the fit review, sits at day 30. The first merged pull request is targeted for day 5 and the first sprint demo for day 10. Every date is repeated in the cards below.</p>

      <ol class="ttw-onb__days" role="list">
        <?php foreach ($ttw_ob as $ttw_ob_i => $ttw_ob_d): ?>
          <li class="ttw-onb__day" style="--i:<?= (int) $ttw_ob_i ?>">
            <article class="ttw-card ttw-onb__c">
              <p class="ttw-onb__dh"><span class="ttw-onb__dd"><?= e($ttw_ob_d[1]) ?></span><span class="bdh-tag ttw-onb__own"><?= e($ttw_ob_d[3]) ?></span></p>
              <h3 class="bdh-t ttw-onb__t"><?= e($ttw_ob_d[2]) ?></h3>
              <p class="bdh-d ttw-onb__d"><?= e($ttw_ob_d[4]) ?></p>
              <ul class="ttw-onb__ck" role="list">
                <?php foreach ($ttw_ob_d[5] as $ttw_ob_c): ?>
                  <li><span class="ttw-tick" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span><?= e($ttw_ob_c) ?></li>
                <?php endforeach; ?>
              </ul>
            </article>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <p class="ttw-onb__note">“Ours” means we do it without taking your team's time. “Yours” needs someone on your side for about an hour. Nothing on this track depends on a manager being free on a particular afternoon.</p>

  </div>
</section>
