<?php /* DRAFT COPY — review before launch */
/* Measures — one headline number per sector, with the definition and the baseline method printed
   beside it, because a number without either is decoration. Nothing here is a result: these are the
   measures we agree before work starts, and the baselines come from the client's own data. */
$mea_rules = [
    ['doc',      'The definition is written first', 'Before anything ships, in a sentence both your team and ours would defend in a board meeting. Ambiguity in the definition shows up later as an argument about the result.'],
    ['chart',    'The baseline comes from your data', 'Drawn from your own history over a stated window, so a seasonal high is not mistaken for a change. If the history does not exist, the first phase creates it.'],
    ['users',    'One named owner per number',       'Someone on your side owns each measure and reports it. We instrument it, review it with them, and never grade our own homework.'],
];
?>
<section class="band band--alt ind-mea" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it is measured</p>
        <h2 class="h2" id="measures-t"><span class="g">One number per category,</span> defined before the work starts.</h2>
      </div>
      <div>
        <p class="lead">Every sector has a number its leadership already argues about. We agree that one, write down what it counts, draw the baseline from your own history, and report it on a fixed rhythm.</p>
        <p class="ind-note"><b>None of the figures on this page is a result we have achieved.</b> They are the measures we work to; baselines and outcomes belong to the engagement and to your data.</p>
      </div>
    </div>

    <ol class="ind-mea__rules" data-rv data-rv-d="60">
      <?php foreach ($mea_rules as $mea_i => $mea_r): ?>
        <li>
          <span class="bdh-idx"><?= str_pad((string) ($mea_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="ind-mea__ri" aria-hidden="true"><?= xt_icon($mea_r[0], ['size' => 18]) ?></span>
          <h3 class="bdh-t ind-mea__rt"><?= e($mea_r[1]) ?></h3>
          <p class="bdh-d"><?= e($mea_r[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <ul class="ind-mea__board" data-rv-s data-rv-step="60">
      <?php foreach ($IND as $mea_s): ?>
        <li class="ind-plate ind-mea__plate">
          <p class="ind-plate__h"><span class="ind-plate__n"><?= e($mea_s['n']) ?></span><a class="ind-mea__pn" href="#<?= e($mea_s['id']) ?>"><?= e($mea_s['name']) ?></a></p>
          <div class="ind-plate__b">
            <p class="ind-mea__kpi"><?= e($mea_s['kpi']) ?></p>
            <dl class="ind-mea__def">
              <div><dt>Counts</dt><dd><?= e($mea_s['kpi_def']) ?></dd></div>
              <div><dt>Baseline</dt><dd><?= e($mea_s['kpi_base']) ?></dd></div>
              <div><dt>Reported</dt><dd><?= e($mea_s['cadence']) ?></dd></div>
            </dl>
            <div class="ind-mea__also">
              <p class="ind-k">Reported beside it</p>
              <ul>
                <?php foreach ($mea_s['measure'] as $mea_m):
                    /* the headline number is printed above; do not print it twice under it */
                    if (stripos($mea_m, $mea_s['kpi']) === 0) continue; ?>
                  <li><?= xt_icon('gauge', ['size' => 16]) ?><span><?= e($mea_m) ?></span></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
