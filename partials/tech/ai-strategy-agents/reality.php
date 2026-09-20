<?php /* DRAFT COPY — review before launch */
/* Reality — why pilots stall. A pilot funnel (illustrative index, not a statistic) with a reason at
   every drop-off, beside an editorial photograph; below, the four reasons as cards that link to the
   section of this page that answers each one. reality.js narrows the funnel on entry and links a
   hovered reason to its drop-off. The HTML is the finished chart. */
$tas_re_stages = [   // [stage, index out of 100 ideas, what it looks like]
    ['Ideas raised',         100, 'Every team has a list'],
    ['Prototypes built',      42, 'A demo on sample data'],
    ['Pilots with real users', 18, 'Real data, a handful of people'],
    ['Approved for rollout',   8, 'Owner, risk and cost signed off'],
    ['In daily use',           5, 'Measured every week'],
];
$tas_re_reasons = [  // [reason, what it looks like, how we close it, anchor, anchor label, icon]
    ['No owner, no measure',           'The demo impressed, but nobody owns the process it changes or the number it should move.',       'Every use case carries a named owner, a baseline and a target before build.',                       '#portfolio',  'The portfolio',    'target'],
    ['Data not ready',                 'The prototype ran on a clean sample. Production data is scattered, stale or has no API.',          'Data readiness is scored per use case, and every gap goes on the roadmap with an owner.',           '#workshop',   'The workshop',     'database'],
    ['Risk unclear, so legal says no', 'Nobody can say what the agent may touch or who approves it, so the safe answer is no.',             'A risk tier, an autonomy level, approvals and an audit log, mapped to NIST AI RMF and the EU AI Act.', '#governance', 'Governance',       'shield'],
    ['Unit cost unknown',              'The pilot bill was small. At full volume nobody knows the cost per task against the manual process.', 'Cost per task is an eval metric from day ten, compared with the manual baseline.',                  '#evals',      'The eval harness', 'cost'],
];
$tas_re_decide = ['A named owner for the work', 'A baseline and a target measure', 'Data readiness, scored', 'A risk tier and an autonomy level', 'A cost-per-task ceiling'];
?>
<section class="band band--alt tas-reality" id="reality" aria-labelledby="reality-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">01</span>Where AI stalls</p>
        <h2 class="h2" id="reality-t"><span class="g">Most AI pilots stall</span> between the demo and daily use.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">The model is rarely the problem. Pilots stop because nobody owns the outcome, the data is not ready, the risk cannot be explained or the running cost was never worked out. Strategy decides those four things before building.</p>
      </div>
    </div>

    <div class="tas-re__grid">
      <div class="tas-re__chart" data-tas-funnel data-rv>
        <div class="tas-re__ch">
          <p class="tas-lbl">Pilot funnel · per 100 ideas</p>
          <span class="tas-ill">Illustrative, not a statistic</span>
        </div>
        <ol class="tas-re__stages">
          <?php foreach ($tas_re_stages as $tas_ri => $tas_rs): ?>
            <li class="tas-re__st<?= $tas_ri === count($tas_re_stages) - 1 ? ' is-last' : '' ?>" style="--w:<?= number_format($tas_rs[1] / 100, 2) ?>;--i:<?= $tas_ri ?>">
              <span class="tas-re__sl"><b><?= e($tas_rs[0]) ?></b><small><?= e($tas_rs[2]) ?></small></span>
              <span class="tas-re__track" aria-hidden="true"><i class="tas-re__fill"></i></span>
              <span class="tas-re__v"><?= (int) $tas_rs[1] ?></span>
            </li>
            <?php if ($tas_ri < count($tas_re_reasons)): ?>
              <li class="tas-re__drop" data-r="<?= $tas_ri ?>" style="--i:<?= $tas_ri ?>">
                <span class="tas-re__dn"><?= sprintf('%02d', $tas_ri + 1) ?></span>
                <span class="tas-re__dt">Stalls on: <?= e($tas_re_reasons[$tas_ri][0]) ?></span>
                <span class="tas-re__dv">−<?= (int) ($tas_rs[1] - $tas_re_stages[$tas_ri + 1][1]) ?></span>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="tas-re__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="tas-re__fig" data-rv data-rv-d="80">
          <div class="bdh-img bdh-img--r169" data-bdh-parallax="0.05">
            <img src="<?= xe_url('assets/imgs/tech/ai-strategy-agents/demo-review.jpg') ?>" alt="A presenter walks colleagues through a chart on a large screen in a glass-walled meeting room" width="1800" height="1013" loading="lazy" decoding="async" style="object-position:50% 40%">
          </div>
          <figcaption class="tas-re__cap"><span class="bdh-cap-chip"><b>The demo</b>The easy part. The hard part is the Monday after.</span></figcaption>
        </figure>

        <div class="tas-re__decide" data-rv data-rv-d="140">
          <p class="tas-lbl">Decided before any build starts</p>
          <ul>
            <?php foreach ($tas_re_decide as $tas_rd): ?>
              <li><span class="tas-re__tick" aria-hidden="true"></span><?= e($tas_rd) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <ol class="tas-re__reasons" data-rv-s data-rv-step="80">
      <?php foreach ($tas_re_reasons as $tas_ri => $tas_rr): ?>
        <li class="tas-re__card" data-r="<?= $tas_ri ?>">
          <p class="tas-re__rtop"><span class="tas-re__dn"><?= sprintf('%02d', $tas_ri + 1) ?></span><?= xt_icon($tas_rr[5], ['size' => 22]) ?></p>
          <h3 class="tas-re__rt"><?= e($tas_rr[0]) ?></h3>
          <p class="tas-re__rs"><?= e($tas_rr[1]) ?></p>
          <p class="tas-re__rf"><b>How it is closed</b><?= e($tas_rr[2]) ?></p>
          <a class="tl tas-re__go" href="<?= e($tas_rr[3]) ?>"><?= e($tas_rr[4]) ?> <span class="i" aria-hidden="true">›</span></a>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
