<?php /* DRAFT COPY — review before launch */
/* 05 Serving — four inference techniques as working micro-machines: continuous batching (a live scheduler that
   admits queued requests as lanes free up), KV / prefix caching (a second request reusing the cached prefix),
   quantisation (the bit layout shrinking FP16 → FP8 → INT4 and the GPU memory it frees for the KV cache, with the eval
   gate deciding what ships) and speculative
   decoding (a draft model proposing tokens, the target verifying them in one pass). Every card ends with its eval
   gate. HTML = the finished state; serving.js runs the machines while on screen. Figures are illustrative. */
$tic_sv_cards = [   // [key, title, gain readout, explanation, gate line]
    ['cb', 'Continuous batching', 'throughput ×2–4 per GPU',
     'Requests join the running batch the moment a slot frees, instead of waiting for the slowest request in a fixed batch. vLLM schedules at the iteration level and pages the KV cache in blocks (PagedAttention), so memory is not wasted on padding.',
     'golden set 0.94 → 0.94 · p95 −38% · pass'],
    ['kv', 'KV and prefix caching', 'time to first token −53%',
     'The system prompt, tools and few-shot examples are the same on every call. Their key-value cache is kept, so prefill only touches the new tokens. Provider prompt caches bill the cached part at about a tenth of the price.',
     'golden set 0.94 → 0.94 · TTFT 0.62 s → 0.29 s · pass'],
    ['q',  'Quantisation', 'memory −50% to −75%',
     'Weights stored in fewer bits: FP8 on Ada- and Hopper-class GPUs, weight-only INT4 (AWQ, GPTQ) where decode is memory-bound. Smaller weights leave more memory for the KV cache, so more requests fit in one batch, and the eval gate measures the quality delta rather than assuming it.',
     ''],
    ['sp', 'Speculative decoding', 'decode latency −45% to −60%',
     'A small draft model proposes several tokens; the target model verifies them in a single forward pass and keeps the accepted prefix plus one token of its own. With rejection sampling the output distribution is the target model’s, only the wall clock changes.',
     'output unchanged by construction · decode −56% · pass'],
];
$tic_sv_lanes = [   // continuous batching, finished-state lanes: [request id, progress 0–1, total output tokens]
    ['r-1042', .82, 620], ['r-1043', .35, 380], ['r-1044', .61, 810], ['r-1045', .12, 460], ['r-1046', .93, 250], ['r-1047', .48, 720],
];
$tic_sv_queue = ['r-1048', 'r-1049', 'r-1050'];
/* Every readout on this card comes out of the lanes above at the decode rate section 02 states: 75 tokens
   a second per stream. serving.js runs the same arithmetic, so the live figures continue the shipped ones. */
$tic_sv_tps  = 75;
$tic_sv_agg  = count($tic_sv_lanes) * $tic_sv_tps;                                  // aggregate output tokens/s
$tic_sv_wait = 0.0;
foreach ($tic_sv_lanes as $tic_sv_l) { $tic_sv_wait = max($tic_sv_wait, (1 - $tic_sv_l[1]) * $tic_sv_l[2] / $tic_sv_tps); }
$tic_sv_wait = round($tic_sv_wait + 0.4, 1);                                        // a fixed batch waits for the slowest lane
$tic_sv_q = [   // precision states for an 8B model with grouped-query attention on one 24 GB GPU:
            // [key, label, bit fields [sign, exponent, mantissa|value], format note, weights GB, KV headroom GB, concurrent 4k-token sequences, decode, golden set, verdict, verdict key]
    ['fp16', 'FP16', [1, 5, 10], 'IEEE half · 1 sign · 5 exponent · 10 mantissa',          16,  6,    12, '1.0×', '0.94', 'baseline · ships', 'pass'],
    ['fp8',  'FP8',  [1, 4, 3],  'E4M3 · 1 sign · 4 exponent · 3 mantissa · per-tensor scale', 8,  14,   28, '1.6×', '0.93', '−0.01 · inside the 0.02 tolerance · ships', 'pass'],
    ['int4', 'INT4', [0, 0, 4],  '4-bit integer · one FP16 scale per group of 128 weights',   4.5, 17.5, 35, '2.1×', '0.90', '−0.04 · below tolerance · held for review', 'hold'],
];
$tic_sv_gpu = 24; $tic_sv_rt = 2;   // GB on the card, GB for runtime and activations
$tic_sv_sp = [   // speculative decoding rounds: [draft tokens, accepted count, target's own token]
    [['The', 'invoice', 'total', 'was'], 3, 'is'],
    [['₹4,820', ',', 'due', 'by'], 4, 'the'],
    [['30th', '.', 'Pay', 'now'], 2, 'Payment'],
];
$tic_sv_out = 'The invoice total is ₹4,820, due by the 30th. Payment';
$tic_sv_engines = [   // [logo slug or null, name, note]
    ['vllm', 'vLLM', 'PagedAttention · continuous batching · prefix caching'],
    ['nvidia', 'NVIDIA TensorRT-LLM', 'in-flight batching · FP8 · speculative decoding'],
    [null, 'SGLang', 'RadixAttention prefix cache · structured output'],
    ['ray', 'Ray Serve', 'multi-model serving · autoscaling replicas'],
    ['huggingface', 'Hugging Face', 'open-weight models · TGI'],
];
?>
<section class="band tic-serving" id="serving" aria-labelledby="serving-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>05</b><span>Inference engineering</span><i aria-hidden="true"></i><em>batching · caching · quantisation · speculation</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="serving-t"><span class="g">Four techniques that make inference</span> faster and cheaper.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Same model, same answers, fewer GPU-seconds. Each technique is switched on behind the gateway and gated by an eval run, so speed never costs quality that nobody measured.</p>
      </div>
    </div>

    <ul class="tic-sv" data-rv-s data-rv-step="90">
      <?php foreach ($tic_sv_cards as $tic_sv_i => $tic_sv_c): ?>
        <li class="tic-sv__card tic-sv__card--<?= e($tic_sv_c[0]) ?>" data-sv="<?= e($tic_sv_c[0]) ?>">
          <div class="tic-sv__head">
            <span class="bdh-idx"><?= str_pad((string) ($tic_sv_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="bdh-t bdh-t--l"><?= e($tic_sv_c[1]) ?></h3>
            <p class="tic-sv__gain"><?= e($tic_sv_c[2]) ?></p>
          </div>

          <?php if ($tic_sv_c[0] === 'cb'): ?>
            <p class="bdh-sr">A scheduler with six GPU lanes, each decoding a request at about 75 tokens a second, <?= number_format($tic_sv_agg) ?> tokens a second between them, and a queue of three waiting requests. As a lane finishes, the next queued request joins the batch at once; a fixed batch would hold the queue for another <?= number_format($tic_sv_wait, 1) ?> seconds.</p>
            <div class="tic-sv__stage tic-sv__cb" aria-hidden="true">
              <div class="tic-sv__cbq">
                <p class="tic-sv__lbl">Queue</p>
                <ul class="tic-sv__pills" data-cb-queue>
                  <?php foreach ($tic_sv_queue as $tic_sv_r): ?><li><?= e($tic_sv_r) ?></li><?php endforeach; ?>
                </ul>
                <p class="tic-sv__lbl tic-sv__lbl--muted">a fixed batch would still be waiting <b data-cb-wait><?= number_format($tic_sv_wait, 1) ?> s</b></p>
              </div>
              <div class="tic-sv__cbg">
                <p class="tic-sv__lbl">GPU · running batch <b data-cb-n>6/6</b><span data-cb-tps><?= number_format($tic_sv_agg) ?> tok/s</span></p>
                <ul class="tic-sv__lanes" data-cb-lanes>
                  <?php foreach ($tic_sv_lanes as $tic_sv_l): ?>
                    <li data-tok="<?= $tic_sv_l[2] ?>" data-p="<?= $tic_sv_l[1] ?>"><span class="tic-sv__lid"><?= e($tic_sv_l[0]) ?></span><span class="tic-sv__bar"><i style="--p:<?= $tic_sv_l[1] ?>"></i></span><b><?= round($tic_sv_l[1] * $tic_sv_l[2]) ?>/<?= $tic_sv_l[2] ?></b></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>

          <?php elseif ($tic_sv_c[0] === 'kv'): ?>
            <p class="bdh-sr">Two requests shown as rows of twelve token blocks. The first request computes every block. The second request shares the same seven-block prefix, which is served from the cache, and only computes the five new blocks.</p>
            <div class="tic-sv__stage tic-sv__kv" aria-hidden="true">
              <div class="tic-sv__kvrow">
                <p class="tic-sv__lbl">request 1 · cold <span>prefill 5,600 tokens</span></p>
                <div class="tic-sv__blocks"><?php for ($tic_sv_b = 0; $tic_sv_b < 12; $tic_sv_b++): ?><i class="is-comp" style="--i:<?= $tic_sv_b ?>"></i><?php endfor; ?></div>
              </div>
              <div class="tic-sv__kvrow tic-sv__kvrow--2">
                <p class="tic-sv__lbl">request 2 · same system prompt <span data-kv-note>7 blocks from cache · prefill 2,300 tokens</span></p>
                <div class="tic-sv__blocks"><?php for ($tic_sv_b = 0; $tic_sv_b < 12; $tic_sv_b++): ?><i class="<?= $tic_sv_b < 7 ? 'is-hit' : 'is-comp' ?>" style="--i:<?= $tic_sv_b ?>"></i><?php endfor; ?></div>
              </div>
              <ul class="tic-sv__kvlegend"><li class="is-hit">cache hit · billed at 10%</li><li class="is-comp">computed</li></ul>
              <p class="tic-sv__kvttft"><span>TTFT</span><b data-kv-ttft>0.29 s</b><em>was 0.62 s</em></p>
            </div>

          <?php elseif ($tic_sv_c[0] === 'q'): ?>
            <div class="tic-sv__stage tic-sv__q" data-q="fp8">
              <div class="tic-sv__qtop">
                <div class="bdh-seg tic-sv__qseg" role="group" aria-label="Weight precision">
                  <?php foreach ($tic_sv_q as $tic_sv_s): ?>
                    <button type="button" data-q-set="<?= e($tic_sv_s[0]) ?>" aria-pressed="<?= $tic_sv_s[0] === 'fp8' ? 'true' : 'false' ?>"><?= e($tic_sv_s[1]) ?></button>
                  <?php endforeach; ?>
                </div>
                <p class="tic-sv__lbl tic-sv__lbl--muted">8B model · one 24 GB GPU</p>
              </div>
              <div class="tic-sv__qviz" aria-hidden="true">
                <p class="tic-sv__lbl">bits per weight <b data-q-bits>8</b></p>
                <div class="tic-sv__qbits">
                  <?php for ($tic_sv_b = 0; $tic_sv_b < 16; $tic_sv_b++):
                      $tic_sv_f = $tic_sv_b < 1 ? 's' : ($tic_sv_b < 5 ? 'e' : ($tic_sv_b < 8 ? 'm' : 'x')); ?><i class="is-<?= $tic_sv_f ?>" style="--i:<?= $tic_sv_b ?>"></i><?php endfor; ?>
                </div>
                <?php foreach ($tic_sv_q as $tic_sv_s): ?><p class="tic-sv__qfmt" data-q-fmt="<?= e($tic_sv_s[0]) ?>"<?= $tic_sv_s[0] === 'fp8' ? '' : ' hidden' ?>><?= e($tic_sv_s[3]) ?></p><?php endforeach; ?>
                <p class="tic-sv__lbl tic-sv__qml">GPU memory <span>24 GB</span></p>
                <div class="tic-sv__qmem" style="--w:<?= round(8 / $tic_sv_gpu, 4) ?>;--r:<?= round($tic_sv_rt / $tic_sv_gpu, 4) ?>">
                  <i class="tic-sv__qw"></i><i class="tic-sv__qkvb"></i><i class="tic-sv__qrt"></i>
                </div>
                <ul class="tic-sv__qlegend"><li class="is-w">weights</li><li class="is-kv">free for KV cache</li><li class="is-rt">runtime</li></ul>
              </div>
              <dl class="tic-sv__qkv">
                <?php foreach ($tic_sv_q as $tic_sv_s): ?>
                  <div class="tic-sv__qst" data-q-state="<?= e($tic_sv_s[0]) ?>"<?= $tic_sv_s[0] === 'fp8' ? '' : ' hidden' ?>>
                    <div><dt>Weights</dt><dd><?= e((string) $tic_sv_s[4]) ?> GB</dd></div>
                    <div><dt>4k-token seqs</dt><dd>~<?= (int) $tic_sv_s[6] ?></dd></div>
                    <div><dt>Decode</dt><dd><?= e($tic_sv_s[7]) ?></dd></div>
                    <div><dt>Golden set</dt><dd><?= e($tic_sv_s[8]) ?></dd></div>
                  </div>
                <?php endforeach; ?>
              </dl>
              <p class="bdh-sr" aria-live="polite" data-q-status>FP8 selected: 8 bits per weight, 8 gigabytes of weights on a 24 gigabyte GPU, room for about 28 concurrent 4,000-token sequences, 1.6 times decode speed, golden-set score 0.93, inside tolerance, ships.</p>
            </div>

          <?php else: ?>
            <p class="bdh-sr">A draft model proposes four tokens at a time. The target model checks all four in one pass, keeps the accepted ones and adds one token of its own; the rest is discarded. The output line grows by the accepted tokens: twelve tokens take three target passes instead of twelve.</p>
            <div class="tic-sv__stage tic-sv__sp" aria-hidden="true" data-sp="<?= e(json_encode($tic_sv_sp)) ?>">
              <div class="tic-sv__sprow">
                <p class="tic-sv__lbl">draft · small model</p>
                <ul class="tic-sv__toks" data-sp-draft>
                  <?php foreach ($tic_sv_sp[2][0] as $tic_sv_j => $tic_sv_tk): ?><li class="<?= $tic_sv_j < $tic_sv_sp[2][1] ? 'is-ok' : 'is-no' ?>" style="--i:<?= $tic_sv_j ?>"><?= e($tic_sv_tk) ?></li><?php endforeach; ?>
                </ul>
              </div>
              <div class="tic-sv__sprow">
                <p class="tic-sv__lbl">target · one verify pass <b data-sp-acc>accepted 2 of 4 + 1 own</b></p>
                <p class="tic-sv__out"><span data-sp-out><?= e($tic_sv_out) ?></span><span class="bdh-caret"></span></p>
              </div>
              <div class="tic-sv__passes">
                <p class="tic-sv__lbl">target forward passes for the same 12 tokens</p>
                <div class="tic-sv__prow"><span>one token a pass</span><ol><?php for ($tic_sv_b = 0; $tic_sv_b < 12; $tic_sv_b++): ?><li></li><?php endfor; ?></ol><b>12</b></div>
                <div class="tic-sv__prow is-spec"><span>draft + verify</span><ol data-sp-passes><?php foreach ($tic_sv_sp as $tic_sv_r): ?><li class="is-done" style="flex-grow:<?= $tic_sv_r[1] + 1 ?>"><?= $tic_sv_r[1] + 1 ?></li><?php endforeach; ?></ol><b>3</b></div>
              </div>
              <p class="tic-sv__lbl tic-sv__lbl--muted">draft acceptance <b data-sp-rate>75%</b> · tokens per target pass <b data-sp-step>4.0</b></p>
            </div>
          <?php endif; ?>

          <p class="bdh-d"><?= e($tic_sv_c[3]) ?></p>
          <p class="tic-sv__gate">
            <span class="tic-sv__gk"><?= xt_icon('eval', ['size' => 14]) ?> Eval gate</span>
            <?php if ($tic_sv_c[0] === 'q'): ?>
              <?php foreach ($tic_sv_q as $tic_sv_s): ?><span class="tic-sv__gv is-<?= e($tic_sv_s[10]) ?>" data-q-gate="<?= e($tic_sv_s[0]) ?>"<?= $tic_sv_s[0] === 'fp8' ? '' : ' hidden' ?>><?= e($tic_sv_s[9]) ?></span><?php endforeach; ?>
            <?php else: ?>
              <span class="tic-sv__gv is-pass"><?= e($tic_sv_c[4]) ?></span>
            <?php endif; ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="tic-sv__engines" data-rv>
      <div class="tic-sv__et">
        <p class="tic-k">Serving engines we work with</p>
        <p class="bdh-d">Engines move monthly. A new version is load-tested and run through the eval gate on a canary pool before the router sends it real traffic.</p>
      </div>
      <ul class="tic-sv__elist" role="list">
        <?php foreach ($tic_sv_engines as $tic_sv_e): ?>
          <li>
            <span class="tic-sv__en"><?php if ($tic_sv_e[0] && isset($STACK[$tic_sv_e[0]])): ?><?= xt_logo($tic_sv_e[0], ['size' => 20, 'hidden' => true]) ?><?php else: ?><i class="tic-sv__edot" aria-hidden="true"></i><?php endif; ?><?= e($tic_sv_e[1]) ?></span>
            <span class="tic-sv__ed"><?= e($tic_sv_e[2]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="tic-note tic-sv__note">Gains are typical ranges for chat and retrieval workloads and depend on the model, prompt shape and traffic. <span class="bdh-ill">Illustrative</span></p>
    </div>
  </div>
</section>
