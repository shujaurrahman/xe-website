<?php /* DRAFT COPY — review before launch */
/* 12 Outcomes — what gets measured every month, shown as five instruments rather than five bars.
   Each row carries the agreed band on a real scale, this month's reading on it, last month's reading as a
   ghost mark behind it, and the verdict. One of the five sits outside its band on purpose: an all-green
   sample dashboard would be a claim, and this page's argument is measured honesty, so the row that is out
   states why and what is being done. Then the three outcome statements from data/technology-intelligence.php.
   These are targets we work to, not results we claim: every reading is sample data for a sample platform. */
$tic_oc_rows = [
    // [icon, name, definition, prefix, suffix, scale min, scale max, band lo, band hi, reading, last month, verdict, kind, why, action]
    ['latency', 'p95 latency, chat endpoint', 'Ninety-nine per cent of chat requests answered inside the agreed p95, measured per endpoint class.',
     '', ' s', 0, 3.0, 0, 1.5, 1.21, 1.34, 'Inside the objective', 'ok',
     'Set per endpoint class and held under load tests at forecast peak, rather than assumed from average traffic.', ''],
    ['cost', 'Cost per 1,000 requests', 'Within ten per cent either side of the cost model agreed at forecast volume.',
     '$', '', 0, 2.4, 1.17, 1.43, 1.21, 1.41, 'On the cost model', 'ok',
     'Tracked per feature and per team, so a price rise or a prompt that grew shows up as a line, not a surprise invoice.', ''],
    ['gpu', 'GPU utilisation at peak', 'Between 55 and 75 per cent at the daily peak — busy enough to be economic, with headroom left.',
     '', '%', 0, 100, 55, 75, 81, 68, 'Above the band', 'out',
     'Below the band you are paying for idle accelerators. Above it, queues build and tail latency runs away.',
     'A launch in week three tripled one route’s traffic. The pool is being resized and the autoscaler’s queue-depth target lowered — owner and date are in the review log.'],
    ['leaf', 'SCI per 1,000 requests', 'Lower each quarter against a ceiling agreed at the start of it, measured the same way each time.',
     '', ' g', 0, 60, 0, 32, 26.4, 29.8, 'Trending down', 'ok',
     'Carbon falls with the same levers as cost: batching, caching, quantisation, and batch work scheduled into cleaner hours.', ''],
    ['shield', 'Error budget spent', 'No month where the availability budget is exhausted without a decision behind it.',
     '', '%', 0, 100, 0, 60, 40.3, 52.0, 'Inside the allowance', 'ok',
     'A planned burn during a migration is a decision. An unplanned one is a design or a monitoring gap, and it gets a review.', ''],
];
$tic_oc_pos = fn (float $v, float $lo, float $hi): float => round(max(0, min(1, ($v - $lo) / ($hi - $lo))) * 100, 2);
$tic_oc_num = fn (float $v): string => rtrim(rtrim(number_format($v, 2, '.', ','), '0'), '.');
/* currency keeps both decimals so the scale, the band and the reading line up as one mono column */
$tic_oc_fmt = fn (float $v, string $p, string $s): string => $p . ($p === '$' ? number_format($v, 2) : $tic_oc_num($v)) . $s;
$tic_oc_out = array_values(array_filter($tic_oc_rows, fn ($tic_oc_r) => $tic_oc_r[12] === 'out'));
?>
<section class="band tic-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>12</b><span>Outcomes</span><i aria-hidden="true"></i><em>reviewed monthly, against the same definitions</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="outcomes-t"><span class="g">Five numbers,</span> measured every month.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Infrastructure work is easy to describe and hard to prove. These are the targets we agree at the start, the definitions we hold to, and the review that puts them in front of you with the evidence attached — including the ones that are out.</p>
      </div>
    </div>

    <div class="tic-oc" data-rv>
      <p class="tic-oc__bar">
        <span class="tic-oc__bk"><span class="tic-led tic-led--blink" aria-hidden="true"></span>monthly review · your-platform · September</span>
        <span class="tic-oc__bs"><?= count($tic_oc_rows) - count($tic_oc_out) ?> of <?= count($tic_oc_rows) ?> inside the agreed band<?php if ($tic_oc_out): ?> · <?= count($tic_oc_out) ?> out, with an owner<?php endif; ?></span>
      </p>

      <ul class="tic-oc__rows" role="list" data-rv-s data-rv-step="100">
        <?php foreach ($tic_oc_rows as $tic_oc_i => $tic_oc_r):
            [$tic_oc_ic, $tic_oc_nm, $tic_oc_def, $tic_oc_p, $tic_oc_s, $tic_oc_lo, $tic_oc_hi,
             $tic_oc_bl, $tic_oc_bh, $tic_oc_now, $tic_oc_was, $tic_oc_vd, $tic_oc_kd, $tic_oc_why, $tic_oc_act] = $tic_oc_r;
            $tic_oc_a = $tic_oc_pos($tic_oc_bl, $tic_oc_lo, $tic_oc_hi);
            $tic_oc_b = $tic_oc_pos($tic_oc_bh, $tic_oc_lo, $tic_oc_hi); ?>
          <li class="tic-oc__row<?= $tic_oc_kd === 'out' ? ' is-out' : '' ?>">
            <div class="tic-oc__t">
              <span class="tic-oc__ico" aria-hidden="true"><?= xt_icon($tic_oc_ic, ['size' => 18]) ?></span>
              <h3 class="h3 tic-oc__h"><?= e($tic_oc_nm) ?></h3>
              <p class="tic-oc__tg"><?= e($tic_oc_def) ?></p>
            </div>

            <div class="tic-oc__gauge">
              <p class="tic-oc__read">
                <span class="tic-v tic-oc__val"><?= e($tic_oc_fmt($tic_oc_now, $tic_oc_p, $tic_oc_s)) ?></span>
                <span class="tic-oc__was">was <?= e($tic_oc_fmt($tic_oc_was, $tic_oc_p, $tic_oc_s)) ?></span>
                <span class="tic-oc__st"><span class="tic-led<?= $tic_oc_kd === 'out' ? ' tic-led--ink' : '' ?>" aria-hidden="true"></span><?= e($tic_oc_vd) ?></span>
              </p>
              <span class="tic-oc__track" aria-hidden="true">
                <i class="tic-oc__band bdh-grow" style="--a:<?= $tic_oc_a ?>%;--w:<?= round($tic_oc_b - $tic_oc_a, 2) ?>%;--i:<?= $tic_oc_i ?>"></i>
                <?php foreach ([25, 50, 75] as $tic_oc_g): ?><i class="tic-oc__gl" style="--t:<?= $tic_oc_g ?>%"></i><?php endforeach; ?>
                <b class="tic-oc__prev" style="--m:<?= $tic_oc_pos($tic_oc_was, $tic_oc_lo, $tic_oc_hi) ?>%"></b>
                <b class="tic-oc__mark" style="--m:<?= $tic_oc_pos($tic_oc_now, $tic_oc_lo, $tic_oc_hi) ?>%;--i:<?= $tic_oc_i ?>"></b>
              </span>
              <p class="tic-oc__scale">
                <span><?= e($tic_oc_fmt($tic_oc_lo, $tic_oc_p, $tic_oc_s)) ?></span>
                <span class="tic-oc__bl">agreed band <?= e($tic_oc_fmt($tic_oc_bl, $tic_oc_p, '')) ?>–<?= e($tic_oc_fmt($tic_oc_bh, $tic_oc_p, $tic_oc_s)) ?></span>
                <span><?= e($tic_oc_fmt($tic_oc_hi, $tic_oc_p, $tic_oc_s)) ?></span>
              </p>
            </div>

            <div class="tic-oc__d">
              <p><?= e($tic_oc_why) ?></p>
              <?php if ($tic_oc_act !== ''): ?>
                <p class="tic-oc__act"><?= xt_icon('wrench', ['size' => 14]) ?><span><b>Why it is out, and what happens next.</b> <?= e($tic_oc_act) ?></span></p>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="tic-oc__legend" aria-hidden="true">
        <span class="is-band">agreed band</span><span class="is-mark">this month</span><span class="is-prev">last month</span>
      </p>
    </div>

    <div class="tic-oc__foot">
      <ul class="tic-oc__three" role="list" data-rv-s data-rv-step="90">
        <?php foreach ($CAP['outcomes'] as $tic_oc_j => $tic_oc_o): ?>
          <li class="bdh-card tic-oc__card">
            <span class="bdh-idx"><?= sprintf('%02d', $tic_oc_j + 1) ?></span>
            <h3 class="h3 tic-oc__ct"><?= e($tic_oc_o[0]) ?></h3>
            <p><?= e($tic_oc_o[1]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="tic-note tic-oc__note" data-rv><?= xt_icon('clipboard-check', ['size' => 16]) ?><span>Bands and readings shown here are illustrative sample data for a sample platform, including the one that is out of band. Your targets are set against your own baseline in the first phase, and the review that reports them is the same one every month. <span class="bdh-ill">Illustrative</span></span></p>
    </div>
  </div>
</section>
