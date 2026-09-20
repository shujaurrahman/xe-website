<?php /* DRAFT COPY — review before launch */
/* TM-11 Outcomes — the two pictures a board actually compares: the risk heatmap at baseline and the
   same map ninety days later, plus the measures underneath. Both states ship in the markup (each cell
   carries data-b and data-a); outcomes.js swaps between them. Values are targets, not claimed results. */

$tscoc_like = ['Almost certain', 'Likely', 'Possible', 'Unlikely', 'Rare'];
$tscoc_imp  = ['Negligible', 'Minor', 'Moderate', 'Major', 'Severe'];
/* findings per cell, [likelihood row][impact column] */
$tscoc_b = [[0, 2, 4, 3, 2], [1, 3, 6, 5, 3], [2, 5, 8, 4, 1], [3, 4, 3, 2, 0], [2, 2, 1, 0, 0]];
$tscoc_a = [[0, 0, 0, 0, 0], [1, 1, 0, 0, 0], [2, 3, 2, 0, 0], [3, 4, 2, 1, 0], [3, 3, 2, 1, 0]];
$tscoc_bt = 0; $tscoc_at = 0;
foreach ($tscoc_b as $tscoc_r) { $tscoc_bt += array_sum($tscoc_r); }
foreach ($tscoc_a as $tscoc_r) { $tscoc_at += array_sum($tscoc_r); }

/* [measure, baseline, target, what it tells you] */
$tscoc_kpi = [
    ['Critical findings open',            '14',      '0',        'Nothing exploitable is knowingly left open. Anything that cannot be fixed carries a dated, approved exception.'],
    ['Mean time to remediate (critical)',  '61 days', '7 days',   'How fast a serious finding actually closes, measured from discovery to verified retest.'],
    ['Mean time to detect',                '4 h 20 m','9 min',    'How long an attack runs before anyone knows. The single biggest lever on blast radius.'],
    ['Mean time to respond',               '2 days',  '3 h 40 m', 'From alert to containment, including the decision time that most teams forget to measure.'],
    ['Control coverage',                   '38%',     '96%',      'Share of the controls on the crosswalk that are implemented, owned and evidenced.'],
    ['Evidence ready without chasing',     '20%',     '90%',      'Share of an auditor request list that can be answered from the locker the same day.'],
];
?>
<section class="band band--ink tsc-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-11</b><span>Measures</span></p>
        <h2 class="h2" id="outcomes-t"><span class="g">Measures a board</span> understands.</h2>
      </div>
      <div>
        <p class="lead">Security reporting fails when it counts activity: scans run, tickets raised, training completed. These six measure exposure and speed, and they move in a direction anyone can read without a translator.</p>
      </div>
    </div>

    <div class="tsc-oc" data-oc data-state="b">
      <div class="tsc-oc__map" data-rv>
        <div class="tsc-oc__mh">
          <div>
            <h3 class="tsc-oc__mt">Risk heatmap</h3>
            <p class="tsc-oc__ms tsc-mono"><b data-oc-total><?= $tscoc_bt ?></b> open findings · <span data-oc-when>baseline, week 0</span></p>
          </div>
          <div class="bdh-seg tsc-oc__seg" role="group" aria-label="Heatmap state">
            <button type="button" data-oc-b="b" aria-pressed="true">Baseline</button>
            <button type="button" data-oc-b="a" aria-pressed="false">Day 90 target</button>
          </div>
        </div>

        <div class="bdh-scroll-x tsc-oc__scroll" tabindex="0" role="group" aria-label="Risk heatmap, scrolls sideways">
          <table class="tsc-oc__t">
            <caption class="bdh-sr">Open findings plotted by likelihood against impact. Switching to the day-90 target moves findings towards lower likelihood and lower impact, and empties the severe row.</caption>
            <thead>
              <tr>
                <th scope="col" class="tsc-oc__corner"><span>Impact &#8594;<br>Likelihood &#8595;</span></th>
                <?php foreach ($tscoc_imp as $tscoc_c): ?><th scope="col" class="tsc-oc__ch"><?= e($tscoc_c) ?></th><?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tscoc_like as $tscoc_ri => $tscoc_rn): ?>
                <tr>
                  <th scope="row" class="tsc-oc__rh"><?= e($tscoc_rn) ?></th>
                  <?php foreach ($tscoc_imp as $tscoc_ci => $tscoc_cn):
                      $tscoc_vb = $tscoc_b[$tscoc_ri][$tscoc_ci];
                      $tscoc_va = $tscoc_a[$tscoc_ri][$tscoc_ci];
                      $tscoc_zone = ($tscoc_ri <= 1 && $tscoc_ci >= 3) ? 'crit' : (($tscoc_ri + (4 - $tscoc_ci)) <= 4 ? 'high' : 'low'); ?>
                    <td class="tsc-oc__c<?= $tscoc_vb === 0 ? ' is-zero' : '' ?>" data-b="<?= $tscoc_vb ?>" data-a="<?= $tscoc_va ?>" data-zone="<?= $tscoc_zone ?>" style="--n:<?= $tscoc_vb ?>;--i:<?= $tscoc_ri * 5 + $tscoc_ci ?>">
                      <span class="tsc-oc__fill" aria-hidden="true"></span>
                      <span class="tsc-oc__v" data-oc-v><?= $tscoc_vb ?></span>
                      <span class="bdh-sr"><?= e($tscoc_rn) ?> likelihood, <?= e($tscoc_cn) ?> impact</span>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="tsc-oc__mf"><span class="tsc-ill">Illustrative</span><span>A worked example of the shape a first programme takes: severe and almost-certain cells emptied first, the long tail accepted, documented and monitored.</span></p>
      </div>

      <div class="tsc-oc__kpi" data-rv>
        <ol class="tsc-oc__list" data-rv-s data-rv-step="55">
          <?php foreach ($tscoc_kpi as $tscoc_i => $tscoc_k): ?>
            <li class="tsc-oc__row" style="--i:<?= $tscoc_i ?>">
              <h3 class="tsc-oc__kn"><?= e($tscoc_k[0]) ?></h3>
              <p class="tsc-oc__kv">
                <span class="tsc-oc__kb tsc-mono"><?= e($tscoc_k[1]) ?></span>
                <span class="tsc-oc__karr" aria-hidden="true"></span>
                <b class="tsc-oc__ka"><?= e($tscoc_k[2]) ?></b>
              </p>
              <p class="tsc-oc__kw"><?= e($tscoc_k[3]) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
        <!-- PLACEHOLDER: confirm before launch — these are targets agreed at kick-off, never achieved results for a named client -->
        <p class="tsc-oc__kf">Figures are targets of the kind we agree with you in week one, against your own measured baseline. We do not publish another organisation's results, and we do not promise a number before we have seen the estate.</p>
      </div>
    </div>

    <ul class="tsc-oc__out" data-rv-s data-rv-step="70" role="list">
      <?php foreach ($CAP['outcomes'] as $tscoc_i => $tscoc_o): ?>
        <li class="bdh-card bdh-card--ink tsc-oc__oc" style="--i:<?= $tscoc_i ?>">
          <p class="bdh-idx"><?= str_pad((string) ($tscoc_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="tsc-oc__ot"><?= e($tscoc_o[0]) ?></h3>
          <p class="tsc-oc__ow"><?= e($tscoc_o[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
