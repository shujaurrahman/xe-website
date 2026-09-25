<?php /* DRAFT COPY — review before launch */
/* Routing — how a model gets chosen, and what it costs to choose the better one.
 *
 * Two components the capability subpages reuse: .aih-branch (one input, a bus, N routes — the diagram
 * idiom, with every connector trimmed to the edge of its box) and .aih-plot (the data-viz idiom: banded
 * grid, bars, axis, optional threshold rule).
 *
 * PLACEHOLDER: the comparison figures are an illustration of the shape of the trade-off, not a
 * benchmark and not a client result. Confirm the framing with the delivery team before launch.
 */
$rt_routes = [
    [
        'n'    => '01',
        'name' => 'A small model',
        'rule' => 'Short, low-risk, high-volume work: classification, extraction, routing, and most questions.',
        'on'   => [['slug', 'mistralai'], ['slug', 'ollama'], ['slug', 'meta']],
        'note' => 'Open-weight families can run inside your own network when data may not leave it.',
        'ro'   => 'fastest · cheapest · re-tested weekly',
    ],
    [
        'n'    => '02',
        'name' => 'A large model, with retrieval',
        'rule' => 'Anything that has to be grounded in your own documents, or reasoned about before it is said.',
        'on'   => [['slug', 'anthropic'], ['slug', 'openai'], ['slug', 'googlegemini'], ['slug', 'llamaindex']],
        'note' => 'The retrieved passage is kept, so the answer can carry a citation a person can open.',
        'ro'   => 'cited · slower · costed per answer',
    ],
    [
        'n'    => '03',
        'name' => 'Your brand-tuned model',
        'rule' => 'Anything that has to look or sound like the brand: imagery, packshots, product scenes, copy.',
        'on'   => [['slug', 'pytorch'], ['slug', 'huggingface'], ['slug', 'modal'], ['mark', 'Flux']],
        'note' => 'Starts on brand rather than being corrected towards it, and is scored before release.',
        'ro'   => 'on brand from the first output',
    ],
    [
        'n'    => '04',
        'name' => 'A person',
        'rule' => 'Consequential, ambiguous, or simply asked for. Offered on every answer, never buried.',
        'on'   => [['mark', 'Your team']],
        'note' => 'This is the route the other three fall back to, which is why it is designed first.',
        'ro'   => 'always available',
    ],
];
/* one illustrative task, three candidate routes, three measures. Max is the plot's ceiling. */
$rt_plot = [
    ['k' => 'quality', 'label' => 'Quality on your eval set', 'unit' => 'win rate, 0–1', 'max' => 1.0,  'fmt' => '%.2f',
     'v' => [0.62, 0.88, 0.93], 'rule' => 0.85, 'rule_l' => 'Accept at 0.85'],
    ['k' => 'latency', 'label' => 'Answer latency', 'unit' => 'p95, seconds', 'max' => 3.0, 'fmt' => '%.1f s',
     'v' => [0.4, 1.1, 2.6], 'rule' => 2.0, 'rule_l' => 'Budget 2.0 s'],
    ['k' => 'cost', 'label' => 'Cost per 1,000 answers', 'unit' => 'illustrative, USD', 'max' => 12.0, 'fmt' => '$%.2f',
     'v' => [0.90, 2.40, 11.20], 'rule' => null, 'rule_l' => ''],
];
$rt_cands = ['Small', 'Small + retrieval', 'Large + retrieval'];
$rt_chosen = 1;
/* the fallback ladder: what happens when the chosen route cannot finish the job */
$rt_fall = [
    ['Not enough context',                'Retrieve more, or ask one clarifying question. The gap is never filled with a guess.'],
    ['Low confidence, or a failed check',  'Escalate to route 02 and run the check again. Recorded as an escalation, with the reason.'],
    ['Consequential, or still unresolved', 'Hand to route 04 with the transcript and the sources already attached.'],
];
$rt_measures = [
    ['Win rate on your own eval set',   'A fixed set of your real prompts, including the awkward ones, scored against a reference answer.'],
    ['p95 latency, not the average',    'The slow tail is what people notice. Streaming buys patience; it does not buy minutes.'],
    ['Cost per unit of work',           'Per answer, per asset, per thousand requests. Not per token, which nobody can budget with.'],
    ['Refusal and grounding behaviour', 'How often it declines correctly, and how often a claim traces back to a source.'],
    ['Context and modality needs',      'Long documents, images, audio or tool calls narrow the field before quality does.'],
    ['Data residency and licence terms','Where inference may happen, and whether the terms allow your data anywhere near training.'],
];
?>
<section class="band aih-route" id="routing" aria-labelledby="routing-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Model routing</p>
        <h2 class="h2" id="routing-t"><span class="g">One model for everything</span> is a billing decision, not a design one.</h2>
      </div>
      <div>
        <p class="lead">Work is routed per step. Most of it does not need the largest model, some of it cannot be done without one, and a share of it should never have gone near a model at all. The route is chosen on your own evaluation set and re-tested when a new model ships.</p>
        <p class="aih-note">Model-agnostic by design. Changing model should be a configuration decision, not a redesign.</p>
      </div>
    </div>

    <div class="aih-route__router" data-rv data-rv-d="60">
      <div class="aih-branch">
        <div class="aih-branch__in">
          <p class="aih-k aih-k--blue">In</p>
          <p class="aih-branch__it">Every request, every brief</p>
          <p class="aih-branch__id">Read first for intent, risk, sensitivity and what it actually needs. The read is logged with the decision.</p>
          <div class="aih-route__fall">
            <p class="aih-k">When a route cannot finish</p>
            <dl>
              <?php foreach ($rt_fall as $rt_f): ?>
                <div><dt><?= e($rt_f[0]) ?></dt><dd><?= e($rt_f[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        </div>
        <span class="aih-branch__bus" aria-hidden="true"></span>
        <ol class="aih-branch__outs">
          <?php foreach ($rt_routes as $rt_r): ?>
            <li class="aih-branch__o">
              <div class="aih-branch__oh">
                <span class="bdh-idx"><?= e($rt_r['n']) ?></span>
                <h3 class="aih-branch__ot"><?= e($rt_r['name']) ?></h3>
                <span class="aih-branch__oro aih-ro"><?= e($rt_r['ro']) ?></span>
              </div>
              <p class="aih-branch__or"><?= e($rt_r['rule']) ?></p>
              <div class="aih-branch__on">
                <?php foreach ($rt_r['on'] as $rt_o): ?>
                  <?php if ($rt_o[0] === 'slug'): ?>
                    <span class="aih-route__tech"><?= xt_logo($rt_o[1], ['size' => 16, 'label' => true]) ?></span>
                  <?php else: ?>
                    <span class="aih-mark"><?= e($rt_o[1]) ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <p class="aih-note aih-branch__oz"><?= e($rt_r['note']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>

    <div class="bdh-grid aih-route__low">
      <div class="bdh-c7 aih-route__plots" data-rv data-rv-d="40">
        <div class="aih-panel aih-panel--flat">
          <div class="aih-panel__bar">
            <span class="aih-panel__title">trade-off <i>/</i> answer a product question from your documentation</span>
            <span class="aih-panel__ill aih-panel__sp">Illustrative</span>
          </div>
          <div class="aih-panel__body">
            <div class="aih-route__pg">
              <?php foreach ($rt_plot as $rt_pi => $rt_p): ?>
                <div class="aih-route__p">
                  <p class="aih-k aih-route__pk"><?= e($rt_p['label']) ?></p>
                  <p class="aih-route__pu"><?= e($rt_p['unit']) ?></p>
                  <div class="aih-plot aih-route__plot">
                    <span class="aih-plot__grid" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                    <?php if ($rt_p['rule'] !== null): ?>
                      <span class="aih-plot__rule" style="--p:<?= round($rt_p['rule'] / $rt_p['max'], 4) ?>" aria-hidden="true"><b><?= e($rt_p['rule_l']) ?></b></span>
                    <?php endif; ?>
                    <div class="aih-plot__cols">
                      <?php foreach ($rt_p['v'] as $rt_vi => $rt_v): ?>
                        <span class="aih-bar bdh-growY<?= $rt_vi === $rt_chosen ? ' aih-bar--solid' : ' aih-bar--ghost' ?>"
                              style="--v:<?= round($rt_v / $rt_p['max'], 4) ?>;--i:<?= $rt_pi * 3 + $rt_vi ?>"></span>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <div class="aih-plot__ax" aria-hidden="true">
                    <?php foreach ($rt_p['v'] as $rt_v): ?><span><?= e(sprintf($rt_p['fmt'], $rt_v)) ?></span><?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <p class="aih-note aih-route__hint">The table scrolls sideways on a narrow screen.</p>
            <div class="bdh-scroll-x aih-route__twrap" tabindex="0" role="group" aria-label="The three candidate routes compared, scroll sideways on a narrow screen">
            <table class="aih-ledger aih-route__tbl">
              <caption>The same three candidates, read across</caption>
              <thead>
                <tr>
                  <th scope="col">Candidate route</th>
                  <?php foreach ($rt_plot as $rt_p): ?><th scope="col"><?= e($rt_p['label']) ?></th><?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rt_cands as $rt_ci => $rt_c): ?>
                  <tr<?= $rt_ci === $rt_chosen ? ' class="is-on"' : '' ?>>
                    <th scope="row"><?= e($rt_c) ?><?= $rt_ci === $rt_chosen ? ' <b>chosen</b>' : '' ?></th>
                    <?php foreach ($rt_plot as $rt_p): ?><td><?= e(sprintf($rt_p['fmt'], $rt_p['v'][$rt_ci])) ?></td><?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            </div>
            <p class="aih-route__why">The large model wins on quality by 0.05. On this task that costs 4.7 times as much per thousand answers and pushes p95 latency past the two-second budget, so it is kept as the escalation route rather than the default one. The same comparison is re-run whenever a new model ships.</p>
          </div>
        </div>
      </div>

      <div class="bdh-c5 aih-route__side" data-rv data-rv-d="80">
        <h3 class="aih-route__sh">What the choice is actually made on</h3>
        <dl class="aih-route__ms">
          <?php foreach ($rt_measures as $rt_mi => $rt_m): ?>
            <div>
              <dt><span class="bdh-idx"><?= str_pad((string) ($rt_mi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($rt_m[0]) ?></dt>
              <dd><?= e($rt_m[1]) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <p class="aih-note">None of these is a vendor benchmark. They are measured on your prompts, your documents and your budget, and they are the reason the recommendation can be argued rather than asserted.</p>
      </div>
    </div>
  </div>
</section>
