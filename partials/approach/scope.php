<?php /* DRAFT COPY — review before launch */
/* Scope — what "agreed" actually means. Three blocks: a real scope card for a sample piece of work (in, out
   and the assumptions the price rests on); how estimates are given, as ranges that narrow at each gate,
   drawn as three bars over the same number; and change control, as a four-step flow with a worked change
   request. Every percentage is a typical range and is marked as such.
   This page describes the practice; the standing terms are in the Commercial Policy. */
// PLACEHOLDER: confirm estimate tolerances, the sprint buffer and change-control turnaround before launch
$sc_case = 'A customer support assistant · phase one';
$sc_cols = [
  ['in',  'In scope', 'check', [
    'Answers policy and order-status questions in English, from your approved policy pages only.',
    'Hands off to a person on low confidence, and always for refunds above the agreed limit.',
    'Embedded in the web chat you already run — no new channel, no new front end.',
    'A dashboard for volume, deflection, hand-off rate and satisfaction, with an export.',
  ]],
  ['out', 'Out of scope', 'alert', [
    'Voice, WhatsApp and any channel other than web chat.',
    'Languages beyond English.',
    'The assistant executing a refund itself, at any value.',
    'Migrating the knowledge base off its current content system.',
  ]],
  ['asm', 'Assumptions the price rests on', 'flag', [
    'The policy pages are the source of truth and are current at the start of the build.',
    'One named reviewer is available for two hours a week, every week.',
    'Your identity provider supports OIDC, and a test tenant exists in week one.',
    'Representative, masked test data is available before the eval baseline is set.',
  ]],
];
$sc_est = [
  // [when, label, tolerance percent, note]
  ['At the first conversation', 'Order of magnitude', 60, 'Enough to say whether it is a sprint, a project or a programme. Not enough to sign.'],
  ['After Discover',            'Budgetary',          30, 'The problem is framed and the systems are mapped. Good enough to plan a year around.'],
  ['After Define',              'Committed',          15, 'Scope, acceptance criteria and dependencies are signed. This is the number in the statement of work.'],
];
$sc_widen = [
  'A decision with no named owner on your side.',
  'Data or a system we have been told about but not shown.',
  'A third party whose timeline we do not control.',
  'A compliance or legal review with no date in the calendar.',
  'An existing system with no tests, where every change is a discovery.',
];
$sc_flow = [
  ['01', 'Raised',  'Either side', 'Anyone can raise one, in a sentence. A change is not an argument; it is a request for a decision.'],
  ['02', 'Sized',   'Our tech lead and product lead', 'Effort as a range, the effect on the date, the effect on the price, and what it displaces if the date holds.'],
  ['03', 'Decided', 'Your sponsor', 'Accept, decline, or accept with something else dropped. Declining is a normal outcome and costs nothing.'],
  ['04', 'Logged',  'Programme lead', 'The decision, the reason and the new numbers go into the decision log and the next invoice line.'],
];
$sc_cr = [
  ['Reference',      'CR-017'],
  ['Requested by',   'Your product owner'],
  ['Change',         'Add order-status answers for orders placed in store, not only online'],
  ['Effort',         '9–14 developer days'],
  ['Effect on date', 'Go-live moves by about one week, or the multilingual work leaves phase one'],
  ['Effect on cost', 'One change-order line at the rates in the statement of work'],
  ['Decision',       'Accepted, with the multilingual work moved to phase two'],
  ['Logged as',      'D-051 · linked to CR-017 · sponsor approved'],
];
$sc_never = [
  ['The price', 'No line is added to an invoice that is not in a signed change order.'],
  ['The date', 'A date moves only by decision, never by drift. If it is at risk, you hear it that week.'],
  ['The acceptance criteria', 'What “done” means cannot be loosened to make a date.'],
  ['The named team', 'The people in the statement of work are the people on the work, or you are told and asked.'],
];
?>
<section class="band band--alt apr-sc" id="scope" aria-labelledby="scope-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Scope, change and estimates</p>
        <h2 class="h2" id="scope-t"><span class="g">Ranges, not points.</span> Nothing added without your yes.</h2>
      </div>
      <div>
        <p class="lead">Most programmes go wrong in the gap between what was said and what was written. So the scope names what is out as carefully as what is in, estimates are ranges that narrow at each gate, and every change is a request that someone on your side decides.</p>
        <a class="tl" href="<?= e(xe_url('legal/commercial-policy.php')) ?>">The standing terms behind this <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="apr-sc__card">
      <p class="apr-sc__ck"><span class="apr-k">Worked example</span><b><?= e($sc_case) ?></b></p>
      <div class="apr-sc__cols">
        <?php foreach ($sc_cols as $sc_c): ?>
        <div class="apr-sc__col is-<?= e($sc_c[0]) ?>">
          <h3 class="apr-sc__ct"><span class="apr-sc__ci" aria-hidden="true"><?= xt_icon($sc_c[2], ['size' => 16]) ?></span><?= e($sc_c[1]) ?></h3>
          <ul class="apr-sc__cl"><?php foreach ($sc_c[3] as $sc_x): ?><li><?= e($sc_x) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endforeach; ?>
      </div>
      <p class="apr-sc__cn"><b>“Out of scope” does not mean never.</b> It means not at this price, not by this date, and not part of this decision. Phase two exists, and it starts with a conversation rather than a surprise.</p>
    </div>

    <div class="apr-sc__est">
      <div class="apr-sc__eh">
        <p class="apr-k">How an estimate is given <span class="bdh-ill">Typical tolerances</span></p>
        <h3 class="apr-sc__h">The same number, three times, getting narrower</h3>
        <p class="apr-sc__ed">A single number given early is a guess wearing a suit. We give a range and the tolerance on it, and we narrow it at each gate as the unknowns are closed. The number in the statement of work is the third one.</p>
      </div>
      <!-- PLACEHOLDER: confirm typical estimate tolerances before launch -->
      <ol class="apr-sc__bars" data-rv-s data-rv-step="110">
        <?php foreach ($sc_est as $sc_i => $sc_e): ?>
        <li style="--i:<?= $sc_i ?>;--t:<?= $sc_e[2] ?>">
          <p class="apr-sc__bw"><?= e($sc_e[0]) ?></p>
          <p class="apr-sc__bl"><b><?= e($sc_e[1]) ?></b><span>±<?= (int) $sc_e[2] ?>%</span></p>
          <span class="apr-sc__bar" aria-hidden="true"><i></i><em></em></span>
          <p class="apr-sc__bn"><?= e($sc_e[3]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
      <p class="bdh-sr">The same estimate given three times: at the first conversation it is an order-of-magnitude range at about plus or minus 60 per cent; after Discover it is budgetary, at about plus or minus 30 per cent; after Define it is committed, at about plus or minus 15 per cent, and that is the number written into the statement of work. Tolerances are typical, not guaranteed.</p>
      <div class="apr-sc__widen">
        <p class="apr-k">What keeps a range wide</p>
        <ul class="bdh-bullets"><?php foreach ($sc_widen as $sc_w): ?><li><?= e($sc_w) ?></li><?php endforeach; ?></ul>
      </div>
    </div>

    <div class="apr-sc__chg">
      <div class="apr-sc__flow">
        <p class="apr-k">Change control · four steps</p>
        <h3 class="apr-sc__h">A change is a request for a decision, not a negotiation</h3>
        <ol class="apr-sc__fl">
          <?php foreach ($sc_flow as $sc_f): ?>
          <li>
            <span class="apr-sc__fn"><?= e($sc_f[0]) ?></span>
            <h4 class="apr-sc__ft"><?= e($sc_f[1]) ?></h4>
            <p class="apr-sc__fw"><?= e($sc_f[2]) ?></p>
            <p class="apr-sc__fd"><?= e($sc_f[3]) ?></p>
          </li>
          <?php endforeach; ?>
        </ol>
        <p class="apr-sc__buf"><span class="bdh-flag" aria-hidden="true">i</span><span><b>Small things do not need a change request.</b> Each sprint carries a buffer — typically around a tenth of its capacity — for the small corrections that only appear once something is real. It is spent by your product owner, and what it was spent on is in the week note.</span></p>
      </div>

      <div class="apr-sc__cr">
        <div class="bdh-ui apr-sc__ui">
          <div class="bdh-ui__bar"><span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span><span>change-control · CR-017 · your-company</span></div>
          <dl class="apr-sc__crl">
            <?php foreach ($sc_cr as $sc_r): ?>
            <div><dt><?= e($sc_r[0]) ?></dt><dd><?= e($sc_r[1]) ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </div>
        <p class="apr-sc__crn">A sample change request for a fictional “Your company”. Effort and effects are illustrative.</p>
      </div>
    </div>

    <ul class="apr-sc__never" data-rv-s data-rv-step="60">
      <?php foreach ($sc_never as $sc_n): ?>
      <li><p class="apr-k">Never changes on its own</p><b><?= e($sc_n[0]) ?></b><span><?= e($sc_n[1]) ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
