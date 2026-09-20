<?php /* DRAFT COPY — review before launch */
/* Outcomes — the re-test comparison. Five measures, each with the baseline taken during the audit
   and the target at the 90-day re-test. A two-button control switches the view; the bars move
   between the two states. Numbers for both states are always in the HTML, so the readout is
   complete without JS. outcomes.js plays the baseline-to-re-test move once on entry. */
$taa_oc_rows = [   /* [measure, unit note, baseline text, re-test text, baseline fraction, re-test fraction, change, direction] */
    ['Critical and high findings open',              'count',                  '7',    '1',        0.875, 0.125, '−6',        'down'],
    ['Findings with a named owner and a date',       'share of the register',  '18%',  '100%',     0.180, 1.000, '+82 pts',          'up'],
    ['Key journeys passing Core Web Vitals',         'of six, 75th percentile','2 / 6','6 / 6',    0.333, 1.000, '+4 journeys',      'up'],
    ['Modelled monthly value recovered',             'of the value identified','$0',   '$31,600',  0.020, 0.718, '+$31,600 / month', 'up'],
    ['Cloud spend classified as waste',              'share of the bill',      '9.6%', '3%',       0.096, 0.030, '−6.6 pts',  'down'],
];
$taa_oc_notes = [
    ['Measured, not asserted', 'Every measure is re-run with the same instrument, the same sample and the same thresholds as the baseline. A different method would make the comparison meaningless.'],
    ['Owned by your team',     'The re-test reports what was closed. It does not re-open the question of who should have closed it.'],
    ['Value against the model','Recovered value is read back through the same model, with your inputs. If an assumption was wrong, it is corrected in both columns.'],
];
?>
<section class="band band--alt taa-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">

    <header class="taa-head taa-head--wide" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">11</span><span>Outcomes</span></p>
        <h2 class="h2" id="outcomes-t"><span class="g">How you know</span> the audit was worth it.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">An audit that changes nothing is a document. These are the measures we set at the readout and re-run ninety days later, against the same instruments and the same thresholds.</p>
      </div>
    </header>

    <div class="taa-oc taa-win" data-taa-outcomes data-view="retest">
      <div class="taa-win__bar">
        <span class="taa-win__t"><b>Re-test comparison</b> · Your company · baseline at readout, re-test at 90 days</span>
        <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i>Same instruments, same sample</span>
        <span class="taa-est">Targets</span>
      </div>

      <div class="taa-oc__ctl">
        <p class="taa-lbl" id="outcomes-ctl-l">Showing</p>
        <div class="taa-oc__seg" role="group" aria-labelledby="outcomes-ctl-l" data-taa-oc-seg>
          <button type="button" data-taa-oc-view="baseline" aria-pressed="false">Baseline at readout</button>
          <button type="button" data-taa-oc-view="retest" aria-pressed="true">Re-test at 90 days</button>
        </div>
        <p class="taa-ro taa-oc__hint">Each bar is scaled inside its own row — the units differ by measure.</p>
      </div>

      <ol class="taa-oc__rows" role="list">
        <?php foreach ($taa_oc_rows as $taa_oci => $taa_ocr): ?>
          <li class="taa-oc__row" style="--b:<?= number_format($taa_ocr[4], 3, '.', '') ?>;--r:<?= number_format($taa_ocr[5], 3, '.', '') ?>;--i:<?= (int) $taa_oci ?>" data-dir="<?= e($taa_ocr[7]) ?>">
            <span class="taa-oc__m">
              <b><?= e($taa_ocr[0]) ?></b>
              <i><?= e($taa_ocr[1]) ?></i>
            </span>
            <span class="taa-oc__track" aria-hidden="true">
              <i class="taa-oc__ghost"></i>
              <i class="taa-oc__fill"></i>
            </span>
            <span class="taa-oc__v">
              <em data-v="baseline"><span class="bdh-sr">Baseline </span><?= e($taa_ocr[2]) ?></em>
              <span class="taa-oc__ar" aria-hidden="true">→</span>
              <em data-v="retest"><span class="bdh-sr">Re-test target </span><?= e($taa_ocr[3]) ?></em>
            </span>
            <span class="taa-oc__ch"><?= e($taa_ocr[6]) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>

      <!-- PLACEHOLDER: confirm re-test figures are presented as targets, not past results, before launch -->
      <p class="taa-oc__foot">
        <span class="taa-est">Illustrative</span>
        <span>Figures are targets for a combined audit of a mid-sized platform, not results from a named engagement. Your baseline is measured in week one and the targets are agreed with you at the readout.</span>
      </p>
    </div>

    <ol class="taa-oc__cards" role="list" data-rv-s data-rv-step="90">
      <?php foreach ($CAP['outcomes'] as $taa_occi => $taa_occ): ?>
        <li class="bdh-card taa-oc__card">
          <span class="taa-id"><?= sprintf('%02d', $taa_occi + 1) ?></span>
          <h3 class="bdh-t bdh-t--l"><?= e($taa_occ[0]) ?></h3>
          <p class="bdh-d"><?= e($taa_occ[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <dl class="taa-oc__notes" data-rv>
      <?php foreach ($taa_oc_notes as $taa_ocn): ?>
        <div><dt><?= e($taa_ocn[0]) ?></dt><dd><?= e($taa_ocn[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

  </div>
</section>
