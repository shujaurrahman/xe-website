<?php /* DRAFT COPY — review before launch */
/* 04.8 Efficiency — cost and energy per answer for three pipeline designs (large model for everything ·
   routed, small-first · routed + cached), as segmented bars that rebalance when a design is chosen, with a
   volume slider for the monthly totals, and golden-set faithfulness per design (all three clear the 0.90
   gate). Then the five techniques and the SCI framing. Every figure is illustrative; the ratios are what
   matter. Design C comes to ₹0.09 per answer, the figure the quality gate and the outcomes dashboard use.
   HTML = design C selected. */
$tape_designs = [   // key => [letter, name, sub, cost segs ₹ [retrieval (+ rerank), small, large, cache], energy segs Wh, tokens, p95, how, faithfulness]
    'a' => ['A', 'Large model for everything', 'no routing · 5 chunks · no reranker', [25, 0, 975, 0], [30, 0, 970, 0], 5200, '3.4 s',
        'Every question goes to the largest model with five unranked chunks of context. The large model mostly compensates for the noisier context, landing just on the 0.90 gate, at about eleven times the cost of design C.', '0.90'],
    'b' => ['B', 'Routed, small-first', 'classify · 3 reranked chunks', [40, 30, 57, 0], [45, 60, 115, 0], 1420, '1.9 s',
        'A small model classifies the question and answers the routine seventy percent. The rest goes to a larger model with three reranked chunks instead of five.', '0.93'],
    'c' => ['C', 'Routed + cached', 'as B · semantic + prompt cache', [28, 20, 36, 6], [30, 40, 75, 5], 940, '1.2 s',
        'As B, plus a semantic cache that serves the thirty-five percent of questions asked before, and prompt caching for the static system prompt and tool schemas. ₹90 per 1,000 answers is ₹0.09 each, inside the ₹0.12 release budget.', '0.93'],
];
$tape_segs  = ['Retrieval & rerank', 'Small model', 'Large model', 'Cache'];
$tape_scale = [1000, 1000];   // bar scale: design A totals (₹ per 1,000 answers · Wh per 1,000 answers)
$tape_vols  = [20000, 50000, 100000, 200000, 500000, 1000000];
$tape_cur   = 'c';
$tape_tech  = [
    ['sync',    'Semantic caching',            'Questions asked before are answered from a verified cache keyed on meaning, not exact words. Cached answers carry their sources and expire when the sources change.', '35% of traffic · 0 model tokens'],
    ['prompt',  'Prompt caching',              'The system prompt, tool schemas and policy text are identical on every call; providers and vLLM can cache that prefix, cutting its input cost by most of the price.', 'static prefix · up to 90% off input'],
    ['filter',  'Shorter context via reranking', 'A cross-encoder keeps the three chunks that matter out of twenty candidates. The model reads a fifth of the tokens and answers more precisely.', '5,000 → 1,100 tokens'],
    ['chip',    'Small models for the small jobs', 'Intent, language, personal-data detection and routing run on small models. The large model is reserved for the questions that need it.', '70% routed small'],
    ['clock',   'Batch work, carbon-aware',     'Re-indexing, embeddings and nightly evals run as batch jobs scheduled into the region’s lowest-carbon window, from a grid carbon-intensity forecast rather than the clock, and at off-peak rates.', 'carbon-aware window'],
];
?>
<section class="band tap-efficiency" id="efficiency" aria-labelledby="efficiency-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.8</span><span>Cost &amp; energy</span><span class="tap-eb__p">/efficiency</span></p>
        <h2 class="h2" id="efficiency-t"><span class="g">Cheaper per answer,</span> lighter per answer.</h2>
      </div>
      <div>
        <p class="lead">The same question can cost ten times more depending on how the pipeline is designed. We model cost and energy per answer during the prototype, then route, cache and trim context until the numbers hold at your volume, with no loss on the golden set.</p>
      </div>
    </div>

    <div class="tap-eff tap-calc" data-rv data-design="<?= $tape_cur ?>">
      <div class="tap-win__bar tap-eff__bar">
        <span class="tap-win__path"><b>cost lab</b> · knowledge-assistant · per 1,000 answers</span>
        <span class="tap-win__end"><span class="tap-ill">Illustrative</span></span>
      </div>

      <div class="tap-eff__ctl">
        <div class="tap-eff__designs" role="radiogroup" aria-label="Pipeline design">
          <?php foreach ($tape_designs as $tape_k => $tape_d): ?>
            <button type="button" role="radio" class="tap-eff__dz" data-eff-design="<?= $tape_k ?>" aria-checked="<?= $tape_k === $tape_cur ? 'true' : 'false' ?>" tabindex="<?= $tape_k === $tape_cur ? '0' : '-1' ?>">
              <span class="tap-eff__dl"><?= e($tape_d[0]) ?></span>
              <span class="tap-eff__dn"><?= e($tape_d[1]) ?><small><?= e($tape_d[2]) ?></small></span>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="tap-eff__vol">
          <label for="eff-vol">Answers per month <output for="eff-vol" data-eff-volout>2,00,000</output></label>
          <input id="eff-vol" type="range" min="0" max="<?= count($tape_vols) - 1 ?>" step="1" value="3" data-eff-vol aria-valuetext="2,00,000 answers per month">
          <span class="tap-eff__volk" aria-hidden="true"><span>20k</span><span>1M</span></span>
        </div>
      </div>

      <div class="tap-eff__body">
        <div class="tap-eff__bars">
          <?php foreach ([['cost', 'Cost per 1,000 answers', '₹'], ['energy', 'Energy per 1,000 answers', 'Wh']] as $tape_j => $tape_bar):
              $tape_v = $tape_designs[$tape_cur][3 + $tape_j]; $tape_tot = array_sum($tape_v); $tape_o = 0; ?>
            <div class="tap-eff__row">
              <p class="tap-eff__rk"><?= e($tape_bar[1]) ?><b data-eff-total="<?= $tape_bar[0] ?>"><?= $tape_bar[2] === '₹' ? '₹' : '' ?><?= number_format($tape_tot) ?><?= $tape_bar[2] === 'Wh' ? ' Wh' : '' ?></b></p>
              <div class="tap-eff__track" aria-hidden="true">
                <?php foreach ($tape_v as $tape_s => $tape_x): ?>
                  <span class="tap-eff__seg tap-eff__seg--<?= $tape_s ?>" data-eff-seg="<?= $tape_bar[0] ?>-<?= $tape_s ?>" style="--o:<?= round($tape_o / $tape_scale[$tape_j], 4) ?>;--w:<?= round($tape_x / $tape_scale[$tape_j], 4) ?>"></span>
                  <?php $tape_o += $tape_x; ?>
                <?php endforeach; ?>
                <span class="tap-eff__ref" style="--w:1"><i>A</i></span>
              </div>
              <ul class="tap-eff__legend" role="list" aria-label="<?= e($tape_bar[1]) ?> by stage">
                <?php foreach ($tape_segs as $tape_s => $tape_n): ?>
                  <li><i class="tap-eff__sw tap-eff__sw--<?= $tape_s ?>"></i><span<?= $tape_s === 0 ? ' data-eff-segname' : '' ?>><?= e($tape_n) ?></span> <b data-eff-val="<?= $tape_bar[0] ?>-<?= $tape_s ?>"><?= $tape_bar[2] === '₹' ? '₹' : '' ?><?= number_format($tape_v[$tape_s]) ?><?= $tape_bar[2] === 'Wh' ? ' Wh' : '' ?></b></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
          <p class="tap-eff__how" data-eff-how><?= e($tape_designs[$tape_cur][7]) ?></p>
        </div>

        <dl class="tap-eff__kpis">
          <div><dt>Tokens to the model per answer</dt><dd data-eff-tokens><?= number_format($tape_designs[$tape_cur][5]) ?></dd></div>
          <div><dt>p95 latency</dt><dd data-eff-p95><?= e($tape_designs[$tape_cur][6]) ?></dd></div>
          <div><dt>Monthly cost at volume</dt><dd data-eff-month>₹18,000</dd></div>
          <div><dt>Monthly energy at volume</dt><dd data-eff-kwh>30 kWh</dd></div>
          <div class="tap-eff__same"><dt>Golden-set faithfulness</dt><dd><span data-eff-faith><?= e($tape_designs[$tape_cur][8]) ?></span> <span>A 0.90 · B 0.93 · C 0.93 · all clear the 0.90 gate</span></dd></div>
          <div class="tap-eff__delta"><dt>Against design A</dt><dd data-eff-delta>−91% cost · −85% energy</dd></div>
        </dl>
      </div>
      <p class="bdh-sr" aria-live="polite" data-eff-live></p>
    </div>

    <div class="tap-eff__tech" data-rv-s>
      <?php foreach ($tape_tech as $tape_t): ?>
        <article class="tap-eff__t">
          <span class="tap-eff__ti"><?= xt_icon($tape_t[0], ['size' => 20]) ?></span>
          <div>
            <h3 class="tap-eff__tt"><?= e($tape_t[1]) ?></h3>
            <p class="tap-eff__td"><?= e($tape_t[2]) ?></p>
            <p class="tap-eff__tm"><?= e($tape_t[3]) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
      <article class="tap-eff__t tap-eff__t--sci">
        <?= xt_badge('sci', ['apply' => true]) ?>
        <p class="tap-eff__sci"><code>SCI = ((E × I) + M) per R</code> Energy used, times the carbon intensity of the grid it ran on, plus embodied emissions of the hardware, per functional unit. Here R is one answered question, which is why tokens per answer is the number we watch.</p>
      </article>
    </div>
  </div>
</section>
