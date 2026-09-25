<?php /* DRAFT COPY — review before launch */
/* Outcomes — what changes, taken word for word from the 'outcomes' arrays in data/ai-design.php, and
   then the part that makes them checkable: the measures, how each one is defined, when the baseline is
   taken and how often it is reported.
 *
 * No achieved results are claimed anywhere on this page. These are the measures agreed before the work
 * starts and reported either way, which is a different and more defensible claim.
 */
/* [capability slug, which of its three outcomes, the icon — one per card, never repeated] */
$oc_pick = [
    ['ai-application-design',  0, 'rollback'],
    ['ai-application-design',  1, 'approve'],
    ['ai-content-studio',      0, 'layers'],
    ['ai-content-studio',      1, 'clipboard-check'],
    ['brand-ai-tools',         0, 'check'],
    ['ai-strategy-consulting', 2, 'trend-up'],
];
$oc_measures = [
    ['Cycle time, brief to approved asset', 'Median working days from a brief being accepted to an approver signing it off.',   'The three months before anything changes', 'Monthly'],
    ['Rework rounds per asset',             'Review rounds an asset goes through before it is approved.',                        'The same three months',                    'Monthly'],
    ['Cost per approved asset',             'Production, tool and model cost divided by the assets actually approved.',          'The same three months',                    'Monthly'],
    ['Brand fidelity score',                'The fixed scoring set, nought to one, per criterion, against the release threshold.','The first scored version',                'Every model version'],
    ['Task completion, unaided',            'Share of a fixed task set that real users finish without help.',                    'The first tested prototype',               'Every release'],
    ['Correction effort',                   'Edits per accepted answer or asset, which is what trust looks like as a number.',   'The first tested prototype',               'Monthly'],
    ['Rights coverage',                     'Share of published outputs with a complete licence, consent and provenance record.','At launch',                                'Monthly'],
    ['Adoption',                            'Weekly active users per team, against the population that was trained.',            'The end of training',                      'Quarterly'],
];
$oc_when = [
    ['Before',  'Baseline',  'Measured in your own pipeline, on your own work, before a single tool changes.'],
    ['During',  'Pilot',     'The same measures on the same kind of work, with the policy and guardrails live from day one.'],
    ['After',   'Quarterly', 'Adoption, quality, cycle time and spend reviewed against the baseline, with next quarter’s plan attached.'],
];
?>
<section class="band band--ink aih-oc" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes &amp; measurement</p>
        <h2 class="h2" id="outcomes-t"><span class="g">What changes,</span> and the number that shows it.</h2>
      </div>
      <div>
        <p class="lead">We do not quote other people’s results at you. What we will do is agree the handful of numbers that matter before the work starts, measure them in your pipeline before anything changes, and report them either way.</p>
        <p class="aih-note">Eight measures, each with a definition, a baseline and a reporting cadence.</p>
      </div>
    </div>

    <div class="aih-cards aih-cards--3 aih-oc__cards" data-rv data-rv-d="40">
      <?php foreach ($oc_pick as $oc_i => $oc_p):
          $oc_c = $CAPS[$oc_p[0]];
          $oc_o = $oc_c['outcomes'][$oc_p[1]]; ?>
        <article class="aih-card aih-oc__card">
          <div class="aih-card__rail">
            <span class="aih-card__ico"><?= xt_icon($oc_p[2], ['size' => 20]) ?></span>
            <span class="aih-card__n"><?= str_pad((string) ($oc_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </div>
          <h3 class="aih-card__t"><?= e($oc_o[0]) ?></h3>
          <p class="aih-card__d"><?= e($oc_o[1]) ?></p>
          <div class="aih-card__f">
            <a class="aih-caplink" href="#<?= e($oc_p[0]) ?>"><b><?= e($oc_c['n']) ?></b><span><?= e($oc_c['short']) ?></span><i aria-hidden="true">›</i></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="aih-panel aih-oc__panel" data-rv data-rv-d="60">
      <div class="aih-panel__bar">
        <span class="aih-panel__title">measures <i>/</i> agreed before the work, reported either way</span>
      </div>
      <div class="aih-panel__body">
        <p class="aih-note aih-oc__hint">The table scrolls sideways on a narrow screen.</p>
        <div class="bdh-scroll-x aih-oc__wrap" tabindex="0" role="group" aria-label="The measures, their definitions and cadence, scroll sideways on a narrow screen">
          <table class="aih-ledger aih-oc__tbl">
            <thead>
              <tr><th scope="col">Measure</th><th scope="col">Definition</th><th scope="col">Baseline taken from</th><th scope="col">Reported</th></tr>
            </thead>
            <tbody>
              <?php foreach ($oc_measures as $oc_m): ?>
                <tr>
                  <th scope="row"><?= e($oc_m[0]) ?></th>
                  <td><?= e($oc_m[1]) ?></td>
                  <td><?= e($oc_m[2]) ?></td>
                  <td><b><?= e($oc_m[3]) ?></b></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="aih-oc__when">
        <?php foreach ($oc_when as $oc_wi => $oc_w): ?>
          <div class="aih-oc__w">
            <p class="aih-k aih-k--blue"><?= e($oc_w[0]) ?></p>
            <p class="aih-oc__wt"><?= e($oc_w[1]) ?></p>
            <p class="aih-oc__wd"><?= e($oc_w[2]) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
