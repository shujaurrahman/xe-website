<?php /* DRAFT COPY — review before launch */
/* Method — evidence first, opinion second. The evidence chain runs across the top: six stages from
   scope to recommendation, each with what happens and the evidence it produces. Below it one real
   finding (TA-03, the slow checkout from the register) travels the chain, collecting its evidence
   as it goes: the marker rides the rail and the card lights the rows each stage produced.
   method.js walks the chain once when the section comes on screen, then rests on the completed
   record. Every evidence row is present the whole time — the walk dims and lights, it never hides —
   and the HTML ships the finished state, so nothing here depends on JS to be readable. */

$taa_me_chain = [
    ['k' => 'scope',     'icon' => 'target',          'n' => 'Scope',
     'd' => 'Systems in scope, owners, access, and the decision the audit has to inform. Security testing only under signed rules of engagement.',
     'o' => ['Audit charter', 'Access checklist', 'Rules of engagement']],
    ['k' => 'collect',   'icon' => 'scan',            'n' => 'Collect',
     'd' => 'Automated scans, field and lab performance data, server logs, configuration exports, warehouse profiling and interviews with the people who run the system.',
     'o' => ['Scan output', 'Log sample', 'Interview notes']],
    ['k' => 'verify',    'icon' => 'eye',             'n' => 'Verify',
     'd' => 'Every candidate finding reproduced by hand on a clean profile. Anything that cannot be reproduced is logged as a false positive and dropped, not padded into the count.',
     'o' => ['Reproduction steps', 'Trace or screenshot', 'False-positive log']],
    ['k' => 'rate',      'icon' => 'gauge',           'n' => 'Rate',
     'd' => 'Severity and likelihood against a published rubric. Vulnerabilities start from their CVSS v3.1 base score and are re-rated for your environment and exposure.',
     'o' => ['Severity', 'Likelihood', 'Rating rationale']],
    ['k' => 'cost',      'icon' => 'cost',            'n' => 'Cost',
     'd' => 'Impact modelled with your numbers — your traffic, your conversion rate, your cloud bill, your engineering rates — with the assumptions written down and a range, not a single figure.',
     'o' => ['Model inputs', 'Sensitivity range', 'Assumptions']],
    ['k' => 'recommend', 'icon' => 'clipboard-check', 'n' => 'Recommend',
     'd' => 'The fix, the effort, the dependencies, a named owner and the re-test that proves it closed. Written so your team can execute it without us.',
     'o' => ['Fix and effort', 'Owner', 'Re-test']],
];

/* The finding that walks the chain: TA-03 from the register. */
$taa_me_ev = [
    ['st' => 0, 'k' => 'Scope',       'v' => 'Checkout funnel, mobile web, 28-day window'],
    ['st' => 1, 'k' => 'Field data',  'v' => 'CrUX p75 LCP 4.6 s — outside the good threshold of 2.5 s'],
    ['st' => 1, 'k' => 'Lab trace',   'v' => '6.1 s on a mid-range Android device over emulated 4G'],
    ['st' => 2, 'k' => 'Reproduced',  'v' => '5 of 5 runs on a clean profile, cache empty'],
    ['st' => 2, 'k' => 'Cause',       'v' => 'Third-party payment script loads in the head — 1.9 s of blocking time'],
    ['st' => 3, 'k' => 'Rating',      'v' => 'Severity High · Likelihood 5 · Risk 20 of 25'],
    ['st' => 4, 'k' => 'Cost model',  'v' => 'Conversion elasticity × mobile revenue — $18,400 a month, ±30%'],
    ['st' => 5, 'k' => 'Fix',         'v' => 'Defer the payment script until interaction, self-host the two web fonts, server-render the order summary'],
    ['st' => 5, 'k' => 'Effort',      'v' => '8 engineering days · depends on TA-11 · web platform team'],
];

$taa_me_carry = [
    ['Reproduction steps',  'Written so an engineer who was not in the room can see it happen.'],
    ['The evidence itself', 'The trace, the log line, the query plan, the screenshot, the export.'],
    ['A rating and why',    'The rubric, the inputs and the judgement, stated so you can challenge it.'],
    ['A cost or a reason',  'A modelled figure with its inputs, or an explicit “rated, not priced”.'],
    ['An owner and effort', 'A named team and an engineering estimate with its confidence.'],
    ['A re-test',           'The check that proves the finding is closed, that your team can run.'],
];
$taa_me_last = count($taa_me_chain) - 1;
?>
<section class="band taa-me" id="method" aria-labelledby="method-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">03</span><span>Method</span></p>
        <h2 class="h2" id="method-t"><span class="g">Evidence first,</span> opinion second.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">A scanner produces candidates. An audit produces findings. The difference is the chain between them: nothing is written up until it has been reproduced, rated against a rubric and costed with your own numbers.</p>
      </div>
    </header>

    <div class="taa-me__wrap" data-taa-method data-step="<?= (int) $taa_me_last ?>">

      <ol class="taa-me__chain" role="list">
        <span class="taa-me__rail" aria-hidden="true"></span>
        <span class="taa-me__rider" aria-hidden="true" data-taa-rider>
          <span class="taa-me__riderid">TA-03</span>
        </span>
        <?php foreach ($taa_me_chain as $taa_me_i => $taa_me_s): ?>
          <li class="taa-me__st is-done<?= $taa_me_i === $taa_me_last ? ' is-on' : '' ?>" data-st="<?= (int) $taa_me_i ?>">
            <p class="taa-me__stn">
              <span class="taa-me__dot" aria-hidden="true"><?= xt_icon($taa_me_s['icon'], ['size' => 16]) ?></span>
              <span class="taa-me__num"><?= sprintf('%02d', $taa_me_i + 1) ?></span>
            </p>
            <h3 class="taa-me__sth"><?= e($taa_me_s['n']) ?></h3>
            <p class="taa-me__std"><?= e($taa_me_s['d']) ?></p>
            <ul class="taa-me__out" role="list">
              <?php foreach ($taa_me_s['o'] as $taa_me_o): ?><li><?= e($taa_me_o) ?></li><?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="bdh-sr">The evidence chain runs Scope, Collect, Verify, Rate, Cost, Recommend. A marker showing finding TA-03 moves along it as the finding below collects its evidence.</p>

      <div class="taa-me__demo">
        <div class="taa-win taa-me__card">
          <div class="taa-win__bar">
            <span class="taa-win__t"><b>TA-03</b> · Checkout LCP 4.6 s on mobile · evidence record</span>
            <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i><span data-taa-stage><?= e($taa_me_chain[$taa_me_last]['n']) ?></span></span>
          </div>
          <ul class="taa-me__ev" role="list">
            <?php foreach ($taa_me_ev as $taa_me_ei => $taa_me_e): ?>
              <li class="taa-me__evr is-on" data-st="<?= (int) $taa_me_e['st'] ?>" style="--i:<?= (int) $taa_me_ei ?>">
                <span class="taa-me__evk"><?= e($taa_me_e['k']) ?></span>
                <span class="taa-me__evv"><?= e($taa_me_e['v']) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="taa-me__foot">
            <span class="taa-est">Illustrative</span>
            <span>Nine evidence records attach to this one finding. The report carries them in an appendix, indexed by finding ID, so any number in the executive summary can be traced back to the thing it came from.</span>
          </p>
        </div>

        <aside class="taa-me__aside" aria-labelledby="method-carry-t">
          <h3 class="taa-me__asideh" id="method-carry-t">What every finding carries</h3>
          <dl class="taa-me__carry" data-rv-s data-rv-step="70">
            <?php foreach ($taa_me_carry as $taa_me_c): ?>
              <div>
                <dt><?= e($taa_me_c[0]) ?></dt>
                <dd><?= e($taa_me_c[1]) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>

          <div class="taa-me__fig">
            <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
            <figure class="bdh-img bdh-img--r43 taa-me__photo">
              <img src="<?= xe_url('assets/imgs/tech/audits-assessments/method-evidence-review.jpg') ?>" width="700" height="467"
                   alt="Two people at a table reading printed pages, one holding a pen" loading="lazy" decoding="async" style="object-position:50% 45%">
            </figure>
            <!-- PLACEHOLDER: confirm the false-positive rate from completed audits before launch -->
            <p class="taa-cap">Verification is where the count shrinks. A meaningful share of automated findings do not survive reproduction, and those are logged as false positives rather than carried into the register to make it look thorough.</p>
          </div>
        </aside>
      </div>

    </div>
  </div>
</section>
