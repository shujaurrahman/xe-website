<?php /* DRAFT COPY — review before launch */
$apr_wk = [
  ['Mon', 'Plan', 'Backlog triage', 'Agents pre-rank new items by value and effort; the product owner sets the order.'],
  ['Tue', 'Build', 'Working sessions', 'Pairing on the hard problems. Agents run evals on every change as it lands.'],
  ['Wed', 'Check', 'Risk and quality', 'Eval scores, guardrail holds and budgets reviewed; anything red gets an owner.'],
  ['Thu', 'Build', 'Demo prep', 'Only working software or real artefacts. No status decks.'],
  ['Fri', 'Decide', 'Weekly review', 'Demo, decisions recorded, next week agreed. Thirty to forty-five minutes.'],
];
$apr_log = [
  ['D-041', 'Launch 3 markets first, 1 later', 'Legal review time in market 4', 'Sponsor', 'Approved'],
  ['D-042', 'Raise tone eval threshold to 0.85', 'Two drafts passed that read off-brand', 'Brand lead', 'Approved'],
  ['D-043', 'Keep human review on all refund answers', 'Low volume, high risk', 'Support lead', 'Approved'],
  ['D-044', 'Move search to a hosted vector index', 'Cost vs latency trade-off', 'Tech lead', 'Open'],
];
?>
<section class="band apr-gv" id="governance" aria-labelledby="governance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Governance</p>
        <h2 class="h2" id="governance-t"><span class="g">A weekly rhythm,</span> one backlog, a decision log.</h2></div>
      <div><p class="lead">You see the same board we work from, the same scores, and every decision with its reason. Nothing important lives in someone’s inbox.</p></div>
    </div>
    <ol class="apr-gv__week">
      <?php foreach ($apr_wk as $apr_w): ?>
      <li class="apr-day<?= $apr_w[1] === 'Decide' ? ' apr-day--key' : '' ?>">
        <p class="apr-day__d"><span><?= e($apr_w[0]) ?></span><?= e($apr_w[1]) ?></p>
        <h3 class="apr-day__t"><?= e($apr_w[2]) ?></h3>
        <p class="apr-day__p"><?= e($apr_w[3]) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
    <div class="apr-gv__split">
      <div class="apr-gv__side">
        <h3 class="apr-gv__h">What you always have access to</h3>
        <ul class="apr-gv__l">
          <li><?= xt_icon('clipboard-check') ?><span><b>Shared backlog.</b> One list, ranked by your product owner, visible to everyone on both sides.</span></li>
          <li><?= xt_icon('doc') ?><span><b>Decision log.</b> What was decided, why, by whom, and what it replaced.</span></li>
          <li><?= xt_icon('dashboard') ?><span><b>Quality board.</b> Eval scores, Web Vitals, open risks and cost, live.</span></li>
          <li><?= xt_icon('log') ?><span><b>Audit log export.</b> Every agent action, on request, in a format your auditors can read.</span></li>
        </ul>
      </div>
      <div class="apr-gv__tbl">
        <p class="apr-gv__cap" id="apr-dlog-cap">Decision log · Your company · sample</p>
        <div class="bdh-scroll-x mask-x" tabindex="0" role="region" aria-labelledby="apr-dlog-cap">
          <table class="apr-dlog">
            <thead><tr><th scope="col">ID</th><th scope="col">Decision</th><th scope="col">Because</th><th scope="col">Owner</th><th scope="col">State</th></tr></thead>
            <tbody>
              <?php foreach ($apr_log as $apr_r): ?>
              <tr><th scope="row"><?= e($apr_r[0]) ?></th><td><?= e($apr_r[1]) ?></td><td><?= e($apr_r[2]) ?></td><td><?= e($apr_r[3]) ?></td><td><span class="apr-st<?= $apr_r[4] === 'Open' ? ' apr-st--open' : '' ?>"><?= e($apr_r[4]) ?></span></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
