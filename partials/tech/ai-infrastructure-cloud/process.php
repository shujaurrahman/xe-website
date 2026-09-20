<?php /* DRAFT COPY — review before launch */
/* 10 Process — baseline, re-architect, operate. The four phases from data/technology-intelligence.php
   as numbered columns on a measurement rule, then the three numbers the work is judged on, each shown
   before and after. Timings are commercial statements and carry a PLACEHOLDER; the before/after figures
   are an illustrative engagement, not a claimed result. */
$tic_ph_steps = $CAP['process']['steps'];
/* One semantic for all three bars: the reduction against the before figure, so the lengths compare.
   [label, icon, before, after, counted value, suffix, reduction %, how] */
$tic_ph_deltas = [
    ['p95 latency, chat endpoint',            'latency', '2.9 s',  '1.21 s', '1.21', ' s', 58, 'Continuous batching, a prompt cache and a router that sends short requests to a smaller model.'],
    ['Cost per 1,000 requests',               'cost',    '$2.95',  '$1.21',  '$1.21',  '',  59, 'Right-sized GPU pools, quantised weights, caching, and batch work moved to committed capacity.'],
    ['Idle GPU-hours a week, non-production', 'gpu',     '96 h',   '12 h',   '12',   ' h', 88, 'Dev, preview and eval environments scale to zero outside working hours instead of idling on reserved capacity.'],
];
?>
<section class="band tic-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="tic-head tic-head--wide" data-rv>
      <p class="tic-ch"><b>10</b><span>How we work</span><i aria-hidden="true"></i><em>baseline · re-architect · operate</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?>.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead"><?= e($CAP['process']['lead']) ?> Nothing is rebuilt because it looks old. Work starts where a measurement says the latency, the spend or the risk actually sits.</p>
      </div>
    </div>

    <ol class="tic-ph__steps" data-rv-s data-rv-step="110">
      <?php foreach ($tic_ph_steps as $tic_ph_i => $tic_ph_s): ?>
        <li class="tic-ph__step">
          <p class="tic-ph__n"><span class="bdh-idx"><?= sprintf('%02d', $tic_ph_i + 1) ?></span><i class="tic-ph__rule bdh-grow" style="--i:<?= $tic_ph_i ?>" aria-hidden="true"></i></p>
          <h3 class="h3 tic-ph__t"><?= e($tic_ph_s[0]) ?></h3>
          <!-- PLACEHOLDER: confirm phase timings before launch -->
          <p class="tic-ph__w"><?= xt_icon('calendar', ['size' => 14, 'mono' => true]) ?><?= e($tic_ph_s[1]) ?></p>
          <p class="tic-ph__d"><?= e($tic_ph_s[2]) ?></p>
          <ul class="tic-ph__out" role="list">
            <?php foreach ($tic_ph_s[3] as $tic_ph_o): ?><li><?= e($tic_ph_o) ?></li><?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="tic-ph__deltas" data-rv>
      <div class="tic-ph__dh">
        <h3 class="h3 tic-ph__dt">The three numbers a phase is judged on</h3>
        <p class="tic-note">Measured on your traffic before the first change, then again after each release. Each bar is the reduction against the before figure, so the three compare. One illustrative engagement shown. <span class="bdh-ill">Illustrative</span></p>
      </div>
      <ul class="tic-ph__dl" role="list">
        <?php foreach ($tic_ph_deltas as $tic_ph_j => $tic_ph_d): ?>
          <li class="tic-ph__delta">
            <p class="tic-ph__dk"><?= xt_icon($tic_ph_d[1], ['size' => 16]) ?><?= e($tic_ph_d[0]) ?></p>
            <p class="tic-ph__dv">
              <span class="tic-ph__was"><?= e($tic_ph_d[2]) ?></span>
              <span class="tic-ph__arw" aria-hidden="true">→</span>
              <span class="tic-v tic-ph__now"><span data-bdh-count><?= e($tic_ph_d[4]) ?></span><?= e($tic_ph_d[5]) ?></span>
            </p>
            <p class="tic-ph__bl"><span class="tic-ph__bar" aria-hidden="true"><i class="bdh-grow" style="--w:<?= (int) $tic_ph_d[6] ?>%;--i:<?= $tic_ph_j ?>"></i></span><b>−<?= (int) $tic_ph_d[6] ?>%</b></p>
            <p class="tic-ph__dd"><?= e($tic_ph_d[7]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="tic-ph__foot"><?= xt_icon('sync', ['size' => 16]) ?><span>After go-live the cadence continues: an SLO review every month with the error budget and the incident actions, a FinOps review of unit cost and commitments, and a capacity check before anything seasonal. <!-- PLACEHOLDER: confirm review cadence and inclusions before launch --></span></p>
    </div>
  </div>
</section>
