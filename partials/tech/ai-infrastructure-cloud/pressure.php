<?php /* DRAFT COPY — review before launch */
/* 02 Pressure — token economics. The anatomy of one AI request as three linked bars (tokens, cost, time),
   switchable between "As shipped" and "Tuned" (cached prefix, reranked context, capped output), with the
   cost table beneath; beside it, the three places bills and latency surprise teams. HTML is the "As shipped"
   state; pressure.js grows the bars and toggles the two states. Prices and figures are illustrative. */
$tic_pr_rate = ['in' => 3.00, 'cached' => 0.30, 'out' => 15.00];   // $ per 1M tokens, illustrative list prices
$tic_pr_parts = [   // [key, label, tuned label, shipped tokens, tuned tokens, shipped rate key, tuned rate key]
    ['sys', 'System prompt & tools', 'System prompt & tools · cached prefix', 1200, 1200, 'in',  'cached'],
    ['ctx', 'Retrieved context',     'Retrieved context · reranked to top 4',  3800, 1600, 'in',  'in'],
    ['usr', 'User input',            'User input',                             150,  150,  'in',  'in'],
    ['out', 'Output',                'Output · structured and capped',         450,  300,  'out', 'out'],
];
$tic_pr_time = [   // [key, label, shipped s, tuned s]
    ['q',   'Queue',                0.05, 0.05],
    ['pre', 'Prefill → first token', 0.57, 0.24],
    ['dec', 'Decode at 75 tokens/s', 6.00, 4.00],
];
$tic_pr_monthly = 1500000;

$tic_pr_calc = function (string $mode) use ($tic_pr_parts, $tic_pr_rate, $tic_pr_time): array {
    $t = $mode === 'tuned' ? 4 : 3; $r = $mode === 'tuned' ? 6 : 5; $s = $mode === 'tuned' ? 3 : 2;
    $out = ['tok' => [], 'cost' => [], 'time' => [], 'tokT' => 0, 'costT' => 0.0, 'timeT' => 0.0];
    foreach ($tic_pr_parts as $p) {
        $c = $p[$t] * $tic_pr_rate[$p[$r]] / 1e6;
        $out['tok'][] = $p[$t]; $out['cost'][] = $c;
        $out['tokT'] += $p[$t]; $out['costT'] += $c;
    }
    foreach ($tic_pr_time as $p) { $out['time'][] = $p[$s]; $out['timeT'] += $p[$s]; }
    $out['ttft'] = $tic_pr_time[0][$s] + $tic_pr_time[1][$s];
    return $out;
};
$tic_pr_m = ['shipped' => $tic_pr_calc('shipped'), 'tuned' => $tic_pr_calc('tuned')];
$tic_pr_max = ['tok' => $tic_pr_m['shipped']['tokT'], 'cost' => $tic_pr_m['shipped']['costT'], 'time' => $tic_pr_m['shipped']['timeT']];

/* segment geometry, "x,w" as fractions of the As-shipped total */
$tic_pr_geo = function (array $vals, float $max): array {
    $x = 0; $g = [];
    foreach ($vals as $v) { $g[] = round($x / $max, 4) . ',' . round($v / $max, 4); $x += $v; }
    return $g;
};
$tic_pr_g = [];
foreach (['tok', 'cost', 'time'] as $tic_pr_k) {
    $tic_pr_g[$tic_pr_k] = ['shipped' => $tic_pr_geo($tic_pr_m['shipped'][$tic_pr_k], $tic_pr_max[$tic_pr_k]), 'tuned' => $tic_pr_geo($tic_pr_m['tuned'][$tic_pr_k], $tic_pr_max[$tic_pr_k])];
}
$tic_pr_money = fn (float $v, int $dp = 4): string => '$' . number_format($v, $dp);

$tic_pr_cards = [   // [title, text, fix, spark kind]
    ['Context grows silently', 'Chat history and retrieved passages are resent on every turn. By turn 12 a request can carry seven times the input tokens of turn 1, and the bill follows.', 'Summarise history, cap retrieval, cache the stable prefix.', 'grow'],
    ['Retries multiply spend', 'A slow provider plus three blind retries can bill the same answer up to four times, and adds load exactly when capacity is short.', 'Retry budgets, jittered backoff, idempotency keys and a fallback route.', 'retry'],
    ['GPUs sit idle between peaks', 'Self-hosted capacity sized for the evening peak spends the small hours near a tenth of it, and averages under half across the day. Idle GPU-hours cost exactly what busy ones cost.', 'Autoscale on queue depth, scale to zero off-peak, move batch work into the troughs.', 'idle'],
];
$tic_pr_grow = [2.1, 3.0, 3.9, 4.9, 5.8, 6.9, 7.8, 9.0, 10.2, 11.5, 13.1, 14.8];   // thousand input tokens per turn
$tic_pr_idle = [22, 14, 10, 9, 11, 18, 34, 52, 61, 58, 55, 57, 60, 54, 49, 47, 52, 66, 80, 86, 78, 61, 42, 30];   // % utilisation by hour
$tic_pr_idle_avg  = (int) round(array_sum($tic_pr_idle) / count($tic_pr_idle));
$tic_pr_idle_peak = (int) max($tic_pr_idle);
?>
<section class="band tic-pressure" id="pressure" aria-labelledby="pressure-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>02</b><span>Token economics</span><i aria-hidden="true"></i><em>where latency and spend come from</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="pressure-t"><span class="g">Where AI bills and latency</span> surprise teams.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">A model call is priced by the token and timed by the token. Most overruns come from tokens nobody decided to send: prompts that grew, retries nobody capped and capacity nobody turned down.</p>
      </div>
    </div>

    <div class="tic-pr">
      <?php $tic_pr_js = [];
        foreach ($tic_pr_m as $tic_pr_k => $tic_pr_v) { $tic_pr_js[$tic_pr_k] = ['cost1k' => round($tic_pr_v['costT'] * 1000, 2), 'ttft' => round($tic_pr_v['ttft'], 2), 'month' => round($tic_pr_v['costT'] * $tic_pr_monthly), 'tokT' => $tic_pr_v['tokT'], 'costT' => round($tic_pr_v['costT'], 5), 'timeT' => round($tic_pr_v['timeT'], 2)]; } ?>
      <div class="tic-panel tic-pr__anat" data-rv data-mode="shipped" data-pr="<?= e(json_encode($tic_pr_js)) ?>">
        <div class="tic-pr__top">
          <div>
            <p class="tic-k">Anatomy of one request</p>
            <h3 class="tic-pr__h">A support answer grounded in your documents</h3>
          </div>
          <div class="bdh-seg tic-pr__seg-ctl" role="group" aria-label="Request configuration">
            <button type="button" aria-pressed="true" data-pr-mode="shipped">As shipped</button>
            <button type="button" aria-pressed="false" data-pr-mode="tuned">Tuned</button>
          </div>
        </div>

        <dl class="tic-pr__kpis">
          <div><dt>Cost per 1k of this request</dt><dd class="tic-v"><span data-pr-kpi="cost1k"><?= e($tic_pr_money($tic_pr_m['shipped']['costT'] * 1000, 2)) ?></span></dd><dd class="tic-pr__delta" data-pr-delta="cost">baseline</dd></div>
          <div><dt>Time to first token</dt><dd class="tic-v"><span data-pr-kpi="ttft"><?= number_format($tic_pr_m['shipped']['ttft'], 2) ?> s</span></dd><dd class="tic-pr__delta" data-pr-delta="ttft">baseline</dd></div>
          <div><dt>Monthly · 1.5M req</dt><dd class="tic-v"><span data-pr-kpi="month"><?= e('$' . number_format($tic_pr_m['shipped']['costT'] * $tic_pr_monthly)) ?></span></dd><dd class="tic-pr__delta" data-pr-delta="month">baseline</dd></div>
        </dl>

        <div class="tic-pr__bars" aria-hidden="true">
          <?php foreach ([['tok', 'Tokens', 4], ['cost', 'Cost', 4], ['time', 'Time', 3]] as $tic_pr_b): ?>
            <div class="tic-pr__row">
              <p class="tic-pr__rl"><span><?= e($tic_pr_b[1]) ?></span><b data-pr-total="<?= $tic_pr_b[0] ?>"><?php
                if ($tic_pr_b[0] === 'tok') echo number_format($tic_pr_m['shipped']['tokT']);
                elseif ($tic_pr_b[0] === 'cost') echo e($tic_pr_money($tic_pr_m['shipped']['costT']));
                else echo number_format($tic_pr_m['shipped']['timeT'], 2) . ' s'; ?></b></p>
              <div class="tic-pr__bar tic-pr__bar--<?= $tic_pr_b[0] ?>">
                <?php for ($tic_pr_s = 0; $tic_pr_s < $tic_pr_b[2]; $tic_pr_s++):
                    $tic_pr_sh = explode(',', $tic_pr_g[$tic_pr_b[0]]['shipped'][$tic_pr_s]);
                    $tic_pr_key = $tic_pr_b[0] === 'time' ? $tic_pr_time[$tic_pr_s][0] : $tic_pr_parts[$tic_pr_s][0]; ?>
                  <span class="tic-pr__sg tic-pr__sg--<?= e($tic_pr_key) ?>" style="--x:<?= $tic_pr_sh[0] ?>;--w:<?= $tic_pr_sh[1] ?>;--i:<?= $tic_pr_s ?>" data-shipped="<?= e($tic_pr_g[$tic_pr_b[0]]['shipped'][$tic_pr_s]) ?>" data-tuned="<?= e($tic_pr_g[$tic_pr_b[0]]['tuned'][$tic_pr_s]) ?>"></span>
                <?php endfor; ?>
                <?php if ($tic_pr_b[0] === 'time'): ?><span class="tic-pr__ft" style="--x:<?= round($tic_pr_m['shipped']['ttft'] / $tic_pr_max['time'], 4) ?>" data-shipped="<?= round($tic_pr_m['shipped']['ttft'] / $tic_pr_max['time'], 4) ?>" data-tuned="<?= round($tic_pr_m['tuned']['ttft'] / $tic_pr_max['time'], 4) ?>"><b>first token</b></span><?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
          <ul class="tic-pr__legend">
            <li class="is-sys">System prompt</li><li class="is-ctx">Retrieved context</li><li class="is-usr">User input</li><li class="is-out">Output</li>
            <li class="is-q">Queue</li><li class="is-pre">Prefill</li><li class="is-dec">Decode</li>
          </ul>
        </div>

        <div class="tic-pr__tablewrap">
          <table class="tic-pr__table">
            <caption class="bdh-sr">Tokens, rate and cost for each part of one request</caption>
            <thead><tr><th scope="col">Part</th><th scope="col">Tokens</th><th scope="col">Rate per 1M</th><th scope="col">Cost</th></tr></thead>
            <tbody>
              <?php foreach ($tic_pr_parts as $tic_pr_i => $tic_pr_p): ?>
                <tr data-pr-row="<?= $tic_pr_i ?>">
                  <th scope="row"><span class="tic-pr__sw tic-pr__sw--<?= e($tic_pr_p[0]) ?>" aria-hidden="true"></span><span data-pr-cell="label" data-shipped="<?= e($tic_pr_p[1]) ?>" data-tuned="<?= e($tic_pr_p[2]) ?>"><?= e($tic_pr_p[1]) ?></span></th>
                  <td data-pr-cell="tok" data-shipped="<?= number_format($tic_pr_p[3]) ?>" data-tuned="<?= number_format($tic_pr_p[4]) ?>"><?= number_format($tic_pr_p[3]) ?></td>
                  <td data-pr-cell="rate" data-shipped="<?= e('$' . number_format($tic_pr_rate[$tic_pr_p[5]], 2)) ?>" data-tuned="<?= e('$' . number_format($tic_pr_rate[$tic_pr_p[6]], 2)) ?>">$<?= number_format($tic_pr_rate[$tic_pr_p[5]], 2) ?></td>
                  <td data-pr-cell="cost" data-shipped="<?= e($tic_pr_money($tic_pr_m['shipped']['cost'][$tic_pr_i])) ?>" data-tuned="<?= e($tic_pr_money($tic_pr_m['tuned']['cost'][$tic_pr_i])) ?>"><?= e($tic_pr_money($tic_pr_m['shipped']['cost'][$tic_pr_i])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot><tr><th scope="row">Per request</th><td data-pr-cell="tok" data-shipped="<?= number_format($tic_pr_m['shipped']['tokT']) ?>" data-tuned="<?= number_format($tic_pr_m['tuned']['tokT']) ?>"><?= number_format($tic_pr_m['shipped']['tokT']) ?></td><td></td><td data-pr-cell="cost" data-shipped="<?= e($tic_pr_money($tic_pr_m['shipped']['costT'])) ?>" data-tuned="<?= e($tic_pr_money($tic_pr_m['tuned']['costT'])) ?>"><?= e($tic_pr_money($tic_pr_m['shipped']['costT'])) ?></td></tr></tfoot>
          </table>
        </div>

        <div class="tic-pr__explain">
          <p><b>Time to first token</b> is prefill: the model reads every input token before it can say anything, so long prompts wait longer.</p>
          <p><b>Tokens per second</b> is decode: the answer streams at a steady rate, so long answers take longer to finish.</p>
        </div>
        <p class="tic-note tic-pr__note">Illustrative list prices: $3 per million input tokens, $0.30 per million cached input tokens, $15 per million output tokens. Real rates vary by model, provider and commitment. <span class="bdh-ill">Illustrative</span></p>
        <p class="tic-note tic-pr__unit">One expensive retrieval-grounded call. The platform blend across every feature is $1.21 per thousand requests — the FinOps console below shows how the mix gets there.</p>
        <p class="bdh-sr" aria-live="polite" data-pr-status>Showing the request as shipped: 5,600 tokens, $22.20 per thousand of this request, 0.62 seconds to first token.</p>
      </div>

      <ul class="tic-pr__cards" data-rv-s data-rv-step="90">
        <?php foreach ($tic_pr_cards as $tic_pr_i => $tic_pr_c): ?>
          <li class="tic-pr__card">
            <div class="tic-pr__spark tic-pr__spark--<?= e($tic_pr_c[3]) ?>" aria-hidden="true">
              <?php if ($tic_pr_c[3] === 'grow'): ?>
                <?php foreach ($tic_pr_grow as $tic_pr_j => $tic_pr_v): ?><i style="--h:<?= round($tic_pr_v / 14.8, 3) ?>;--i:<?= $tic_pr_j ?>"></i><?php endforeach; ?>
                <span class="tic-pr__sk">turn 1 · 2.1k</span><span class="tic-pr__sk tic-pr__sk--r">turn 12 · 14.8k</span>
              <?php elseif ($tic_pr_c[3] === 'retry'): ?>
                <span class="tic-pr__try is-fail" style="--i:0"><b>1</b><span>timeout</span></span><span class="tic-pr__try is-fail" style="--i:1"><b>2</b><span>timeout</span></span><span class="tic-pr__try is-fail" style="--i:2"><b>3</b><span>timeout</span></span><span class="tic-pr__try is-ok" style="--i:3"><b>4</b><span>200 OK</span></span>
                <span class="tic-pr__sk tic-pr__sk--r">billed ×4</span>
              <?php else: $tic_pr_pts = ''; foreach ($tic_pr_idle as $tic_pr_j => $tic_pr_v) { $tic_pr_pts .= ($tic_pr_j ? 'L' : 'M') . round($tic_pr_j * 200 / 23, 1) . ',' . (60 - round($tic_pr_v * .6, 1)); } ?>
                <svg viewBox="0 0 200 60" preserveAspectRatio="none" class="tic-pr__idle">
                  <defs><clipPath id="tic-pr-wipe" clipPathUnits="userSpaceOnUse"><rect class="tic-wipe" x="-3" y="-6" width="206" height="72"/></clipPath></defs>
                  <line class="tic-pr__avg" x1="0" y1="<?= 60 - round($tic_pr_idle_avg * .6, 1) ?>" x2="200" y2="<?= 60 - round($tic_pr_idle_avg * .6, 1) ?>"/>
                  <path class="tic-pr__util" d="<?= $tic_pr_pts ?>" clip-path="url(#tic-pr-wipe)"/>
                </svg>
                <span class="tic-pr__sk">00:00</span><span class="tic-pr__sk tic-pr__sk--m">avg <?= $tic_pr_idle_avg ?>% · peak <?= $tic_pr_idle_peak ?>%</span><span class="tic-pr__sk tic-pr__sk--r">24:00</span>
              <?php endif; ?>
            </div>
            <div class="tic-pr__ct">
              <span class="bdh-idx"><?= str_pad((string) ($tic_pr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <h3 class="bdh-t"><?= e($tic_pr_c[0]) ?></h3>
              <p class="bdh-d"><?= e($tic_pr_c[1]) ?></p>
              <p class="tic-pr__fix"><b>Fix</b><?= e($tic_pr_c[2]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
