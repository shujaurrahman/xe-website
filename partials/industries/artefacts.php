<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* One working artefact per sector — code-built mock UI, aria-hidden with a .bdh-sr sentence.
   Every figure is illustrative (labelled so on the mock); none is a client result. */
if (!function_exists('ind_art')) {
function ind_art(string $ind_id): string
{
    $ind_ok = '<span class="ind-st ind-st--ok">✓</span>';
    ob_start();
    switch ($ind_id) {

    case 'consumer-health': ?>
<figure class="bdh-ui ind-art ind-art--trail">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Claims approval trail</span><span class="bdh-ro ind-art__meta">Illustrative</span></figcaption>
  <div aria-hidden="true">
    <div class="ind-trail">
      <p class="ind-trail__claim">“Clears a blocked nose in five minutes.”</p>
      <ol class="ind-trail__steps">
        <li class="is-ok"><span>AI draft</span><em>from approved module</em></li>
        <li class="is-ok"><span>Evidence linked</span><em>study ref. attached</em></li>
        <li class="is-ok"><span>Blocked-claims check</span><em>DMR Act · Schedule J</em></li>
        <li class="is-ok"><span>Medical review</span><em>human sign-off</em></li>
        <li class="is-now"><span>Legal &amp; ASCI</span><em>in review</em></li>
      </ol>
    </div>
    <div class="ind-trail ind-trail--stop">
      <p class="ind-trail__claim">“Cures sinus infections for good.”</p>
      <p class="ind-trail__why"><span class="bdh-flag">Blocked at draft</span> Cure claim for a listed condition — never reaches review.</p>
    </div>
  </div>
  <p class="bdh-sr">An illustrative claims approval trail: one claim moves from AI draft through evidence, a blocked-claims check, medical review and legal review; a cure claim is stopped at the draft stage.</p>
</figure>
<?php break;

    case 'financial-services': ?>
<figure class="bdh-ui ind-art ind-art--funnel">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Onboarding funnel · KYC</span><span class="bdh-ro ind-art__meta">Illustrative</span></figcaption>
  <div aria-hidden="true">
    <ol class="ind-fun">
      <?php foreach ([['Application started', 100, ''], ['PAN verified', 84, 'Pre-fill from PAN'], ['Video KYC (V-CIP)', 63, 'Largest drop · slot booking added'], ['Key Fact Statement accepted', 58, 'APR shown before contract'], ['Account funded', 52, '']] as $ind_f): ?>
      <li style="--v:<?= $ind_f[1] ?>"><span class="ind-fun__l"><?= e($ind_f[0]) ?></span><span class="ind-fun__b"><i></i></span><span class="ind-fun__v bdh-ro"><?= $ind_f[1] ?></span><?php if ($ind_f[2]): ?><em class="ind-fun__n"><?= e($ind_f[2]) ?></em><?php endif; ?></li>
      <?php endforeach; ?>
    </ol>
    <p class="ind-art__log bdh-ro"><?= $ind_ok ?> KFS v3 shown · consent logged · cooling-off date sent</p>
  </div>
  <p class="bdh-sr">An illustrative onboarding funnel of one hundred applicants: 84 verify PAN, 63 finish video KYC, 58 accept the Key Fact Statement and 52 fund the account, with each disclosure logged.</p>
</figure>
<?php break;

    case 'retail-commerce': ?>
<figure class="bdh-ui ind-art ind-art--cal">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Season calendar</span><span class="bdh-ro ind-art__meta">Plan · produce · live</span></figcaption>
  <div aria-hidden="true">
    <div class="ind-cal"><span class="ind-cal__c"></span>
      <?php foreach (['J','F','M','A','M','J','J','A','S','O','N','D'] as $ind_mi => $ind_m): ?><span class="ind-cal__m" style="grid-column:<?= $ind_mi + 2 ?>"><?= $ind_m ?></span><?php endforeach; ?>
      <?php foreach ([['Summer sale', 4, 1, 5, 1, 6, 2], ['Festive · Diwali', 7, 2, 9, 1, 10, 2], ['Wedding season', 9, 1, 10, 1, 11, 2], ['Year-end sale', 10, 1, 11, 1, 12, 1]] as $ind_r): ?>
      <span class="ind-cal__t"><?= e($ind_r[0]) ?></span>
      <span class="ind-cal__row">
        <i class="ind-cal__p" style="--s:<?= $ind_r[1] ?>;--n:<?= $ind_r[2] ?>"></i><i class="ind-cal__d" style="--s:<?= $ind_r[3] ?>;--n:<?= $ind_r[4] ?>"></i><i class="ind-cal__l" style="--s:<?= $ind_r[5] ?>;--n:<?= $ind_r[6] ?>"></i>
      </span>
      <?php endforeach; ?>
    </div>
    <p class="ind-art__log bdh-ro"><span class="ind-cal__k ind-cal__p"></span>Plan <span class="ind-cal__k ind-cal__d"></span>Produce <span class="ind-cal__k ind-cal__l"></span>Live · no drip pricing, no false urgency</p>
  </div>
  <p class="bdh-sr">An illustrative retail season calendar: summer, festive, wedding and year-end campaigns each planned, produced and live across the year, with checks for drip pricing and false urgency.</p>
</figure>
<?php break;

    case 'b2b-technology': ?>
<figure class="bdh-ui ind-art ind-art--sec">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Security review tracker</span><span class="bdh-ro ind-art__meta">Illustrative</span></figcaption>
  <div aria-hidden="true">
    <ul class="ind-sec-q">
      <?php foreach ([['SSO (SAML / OIDC) and SCIM', 'ok'], ['Data-processing agreement', 'ok'], ['Data residency · India region', 'ok'], ['AI: no training on customer data', 'ok'], ['Pen-test summary', 'now'], ['Sub-processor list', 'now']] as $ind_q): ?>
      <li class="is-<?= $ind_q[1] ?>"><span><?= e($ind_q[0]) ?></span><span class="bdh-ro"><?= $ind_q[1] === 'ok' ? 'Answered' : 'In progress' ?></span></li>
      <?php endforeach; ?>
    </ul>
    <div class="ind-sec-q__foot"><span class="bdh-ro">Answers ready</span><span class="ind-sec-q__bar"><i></i></span><span class="bdh-ro">4 / 6</span></div>
  </div>
  <p class="bdh-sr">An illustrative enterprise security review tracker: SSO, data-processing agreement, data residency and AI data use are answered; the pen-test summary and sub-processor list are in progress.</p>
</figure>
<?php break;

    case 'hospitality': ?>
<figure class="bdh-ui ind-art ind-art--stay">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Guest journey · direct</span><span class="bdh-ro ind-art__meta">Illustrative</span></figcaption>
  <div aria-hidden="true">
    <ol class="ind-stay">
      <?php foreach ([['Inspire', 'Search & AI answers'], ['Book', 'Direct, all-in price'], ['Pre-arrival', 'Message · 3 days out'], ['Stay', 'Requests in chat'], ['After', 'Review, then an offer']] as $ind_k => $ind_t): ?>
      <li><span class="ind-stay__d"><?= $ind_k + 1 ?></span><b><?= e($ind_t[0]) ?></b><em><?= e($ind_t[1]) ?></em></li>
      <?php endforeach; ?>
    </ol>
    <div class="ind-stay__mix">
      <p class="bdh-ro">Bookings by channel</p>
      <span class="ind-stay__split" style="--v:34"><i>Direct 34%</i><b>Online travel agents 66%</b></span>
      <span class="ind-stay__split is-goal" style="--v:50"><i>Target 50%</i><b></b></span>
    </div>
  </div>
  <p class="bdh-sr">An illustrative direct-booking guest journey in five steps from inspiration to after the stay, with direct bookings at 34 percent against a target of half.</p>
</figure>
<?php break;

    default: /* telecom-media */ ?>
<figure class="bdh-ui ind-art ind-art--care">
  <figcaption class="ind-art__bar"><span class="bdh-ro">Care intents · routing</span><span class="bdh-ro ind-art__meta">Illustrative</span></figcaption>
  <div aria-hidden="true">
    <table class="ind-care">
      <thead><tr><th scope="col">Intent</th><th scope="col">Resolved in app</th><th scope="col">Route</th></tr></thead>
      <tbody>
      <?php foreach ([['Data balance', 92, 'Self-serve'], ['Recharge failed', 71, 'Self-serve'], ['Slow network here', 48, 'Agent + network data'], ['Bill dispute', 20, 'Human, with context'], ['Port-out request', 0, 'Human only']] as $ind_c): ?>
        <tr><th scope="row"><?= e($ind_c[0]) ?></th><td><span class="ind-care__r"><span class="ind-care__b" style="--v:<?= $ind_c[1] ?>"><i></i></span><span class="bdh-ro"><?= $ind_c[1] ?>%</span></span></td><td><span class="bdh-tag"><?= e($ind_c[2]) ?></span></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <p class="ind-art__log bdh-ro"><?= $ind_ok ?> Promotional messages checked against DND preferences (TCCCPR)</p>
  </div>
  <p class="bdh-sr">An illustrative care routing table: data balance and failed recharges are mostly resolved in the app, network complaints go to an agent with network data, bill disputes and port-out requests go to a person.</p>
</figure>
<?php break;
    }
    return (string) ob_get_clean();
}
}
