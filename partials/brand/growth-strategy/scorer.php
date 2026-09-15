<?php /* DRAFT COPY — review before launch */
/* 04 SIGNATURE — Next-best-customer scorer. Five weighting sliders re-rank Segments A–F as a bar race
   (FLIP); an agent note explains what moved and why; the strategist signs off the shortlist.
   Autoplays weighting scenarios until the visitor touches it. The HTML is the balanced state.
   <!-- PLACEHOLDER: illustrative segment scores and sources, confirm before launch --> */
$cgs_sc_crit = [ // key, label, what it measures
    ['size', 'Size', 'Revenue pool in the segment'],
    ['growth', 'Growth', 'How fast the pool is expanding'],
    ['fit', 'Fit', 'How well the offer solves their problem'],
    ['reach', 'Reach', 'How cheaply you can get in front of them'],
    ['margin', 'Margin', 'What each customer is worth after cost to serve'],
];
$cgs_sc_segs = [ // label, descriptor, scores size/growth/fit/reach/margin (0–10)
    ['A', 'Large incumbents',      [9, 3, 7, 8, 4]],
    ['B', 'Regional chains',       [7, 5, 6, 6, 6]],
    ['C', 'Digital-first entrants', [6, 9, 7, 4, 7]],
    ['D', 'Specialist operators',  [4, 4, 9, 7, 8]],
    ['E', 'Premium niche',         [3, 8, 6, 5, 9]],
    ['F', 'Price-led volume',      [2, 6, 4, 9, 5]],
];
$cgs_sc_w = [5, 5, 5, 5, 5];
$cgs_sc_presets = [ // label, weights
    ['Balanced', [5, 5, 5, 5, 5]], ['Chase growth', [3, 10, 6, 4, 5]],
    ['Protect margin', [4, 3, 7, 4, 10]], ['Fastest to reach', [5, 4, 5, 10, 3]],
];
$cgs_sc_score = function (array $s) use ($cgs_sc_w): int {
    $t = 0; foreach ($s as $n => $v) $t += $v * $cgs_sc_w[$n];
    return (int) round($t / array_sum($cgs_sc_w) * 10);
};
$cgs_sc_rank = $cgs_sc_segs; usort($cgs_sc_rank, fn ($a, $b) => $cgs_sc_score($b[2]) <=> $cgs_sc_score($a[2]));
$cgs_sc_decide = [
    ['Which weighting reflects the goal', 'Revenue, share, margin or a new market — the strategist sets it with leadership.'],
    ['Which segments make the shortlist', 'The top three go forward only once a person has read the evidence behind each.'],
    ['Where the data is too thin', 'Low-confidence scores are sent back for interviews, not averaged away.'],
];
?>
<section class="band cgs-scorer" id="scorer" aria-labelledby="scorer-t">
  <!-- PLACEHOLDER: illustrative segment scores, sources and flags, confirm before launch -->
  <span class="cgs-survey" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>04</b><i></i>Next best customer · live model</p>
        <h2 class="h2" id="scorer-t"><span class="g">Change what matters,</span> watch the ranking move.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">An agent scores every segment against five criteria from your data and our interviews. People decide what each criterion is worth. Move a weight and the shortlist re-ranks.</p>
        <span class="cgs-illus">Illustrative model</span>
      </div>
    </div>

    <div class="cgs-sc" data-cgs-scorer data-segs='<?= e(json_encode(array_map(fn ($s) => [$s[0], $s[2]], $cgs_sc_segs))) ?>'
         data-presets='<?= e(json_encode(array_column($cgs_sc_presets, 1))) ?>' data-crit='<?= e(json_encode(array_column($cgs_sc_crit, 1))) ?>'>
      <p class="bdh-sr">Interactive demo: five weighting sliders re-rank six illustrative customer segments. It plays sample weightings until you use a control. Ranking updates are announced below the bars.</p>

      <!-- weights -->
      <div class="cgs-sc__weights">
        <div class="cgs-sc__bar"><span class="cgs-sc__k">Weighting</span><span class="cgs-sc__auto" data-cgs-auto><i></i><span>Playing scenarios</span></span></div>
        <div class="cgs-sc__presets" role="group" aria-label="Weighting scenarios">
          <?php foreach ($cgs_sc_presets as $cgs_pi => $cgs_pr): ?>
            <button type="button" class="cgs-sc__preset" data-cgs-preset="<?= $cgs_pi ?>" aria-pressed="<?= $cgs_pi === 0 ? 'true' : 'false' ?>"><?= e($cgs_pr[0]) ?></button>
          <?php endforeach; ?>
        </div>
        <?php foreach ($cgs_sc_crit as $cgs_ci => $cgs_cr): ?>
          <div class="cgs-sc__w">
            <label class="cgs-sc__wl" for="scorer-w-<?= $cgs_cr[0] ?>"><b><?= e($cgs_cr[1]) ?></b><span><?= e($cgs_cr[2]) ?></span></label>
            <output class="cgs-sc__wv" for="scorer-w-<?= $cgs_cr[0] ?>" data-cgs-wv="<?= $cgs_ci ?>"><?= $cgs_sc_w[$cgs_ci] ?></output>
            <input class="cgs-sc__range" type="range" id="scorer-w-<?= $cgs_cr[0] ?>" min="0" max="10" step="1" value="<?= $cgs_sc_w[$cgs_ci] ?>"
                   data-cgs-w="<?= $cgs_ci ?>" style="--v:<?= $cgs_sc_w[$cgs_ci] / 10 ?>" aria-describedby="scorer-live">
          </div>
        <?php endforeach; ?>
      </div>

      <!-- ranking -->
      <div class="cgs-sc__rank">
        <div class="cgs-sc__bar"><span class="cgs-sc__k">Segment ranking</span><span class="cgs-sc__k">Score / 100</span></div>
        <ol class="cgs-sc__list" data-cgs-list>
          <?php foreach ($cgs_sc_rank as $cgs_ri => $cgs_sg): $cgs_v = $cgs_sc_score($cgs_sg[2]); ?>
            <li class="cgs-sc__row<?= $cgs_ri < 3 ? ' is-short' : '' ?>" data-cgs-seg="<?= e($cgs_sg[0]) ?>">
              <span class="cgs-sc__pos" data-cgs-pos><?= $cgs_ri + 1 ?></span>
              <span class="cgs-sc__name"><b>Segment <?= e($cgs_sg[0]) ?></b><span><?= e($cgs_sg[1]) ?></span></span>
              <span class="cgs-sc__track" aria-hidden="true"><i data-cgs-fill style="--s:<?= $cgs_v / 100 ?>"></i></span>
              <span class="cgs-sc__val" data-cgs-val><?= $cgs_v ?></span>
              <span class="cgs-sc__move" data-cgs-move aria-hidden="true"></span>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="cgs-sc__cut" aria-hidden="true"><span>Shortlist line · top three</span></p>
        <?php $cgs_sc_parts = array_map(fn ($v, $wt) => $v * $wt, $cgs_sc_rank[0][2], $cgs_sc_w);
              $cgs_sc_pct = array_map(fn ($v) => (int) round($v / max(1, array_sum($cgs_sc_parts)) * 100), $cgs_sc_parts);
              $cgs_sc_max = max(1, max($cgs_sc_pct)); ?>
        <div class="cgs-sc__why" aria-hidden="true" data-cgs-why>
          <p class="cgs-sc__whyk"><span>What carries the leader</span><b data-cgs-lead>Segment <?= e($cgs_sc_rank[0][0]) ?></b></p>
          <ul class="cgs-sc__parts">
            <?php foreach ($cgs_sc_crit as $cgs_ci => $cgs_cr): ?>
              <li<?= $cgs_sc_pct[$cgs_ci] === $cgs_sc_max ? ' class="is-top"' : '' ?>><span><?= e($cgs_cr[1]) ?></span><i><b style="--p:<?= round($cgs_sc_pct[$cgs_ci] / $cgs_sc_max, 3) ?>"></b></i><em><?= $cgs_sc_pct[$cgs_ci] ?>%</em></li>
            <?php endforeach; ?>
          </ul>
          <p class="cgs-sc__whyn">Share of the leader’s score contributed by each criterion at the current weights.</p>
        </div>
        <p class="bdh-sr" id="scorer-live" aria-live="polite" data-cgs-live></p>
      </div>

      <!-- agent + people -->
      <div class="cgs-sc__side">
        <div class="cgs-sc__agent">
          <p class="cgs-sc__who"><i></i>Agent note</p>
          <p class="cgs-sc__say" data-cgs-note>With equal weights, Segment <?= e($cgs_sc_rank[0][0]) ?> leads on breadth: no single criterion carries it. Scores draw on CRM history and interview notes.</p>
          <p class="cgs-sc__src">Sources · CRM export · won/lost interviews · category data</p>
        </div>
        <div class="cgs-sc__people">
          <p class="cgs-sc__who cgs-sc__who--p"><i></i>People decide</p>
          <ol>
            <?php foreach ($cgs_sc_decide as $cgs_di => $cgs_dc): ?>
              <li><b><?= e($cgs_dc[0]) ?></b><span><?= e($cgs_dc[1]) ?></span></li>
            <?php endforeach; ?>
          </ol>
          <div class="cgs-sc__sign" data-cgs-sign>
            <span class="cgs-sc__state" data-cgs-state>Shortlist awaiting sign-off</span>
            <button type="button" class="cgs-sc__btn" data-cgs-signbtn>Sign off shortlist</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
