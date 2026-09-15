<?php /* DRAFT COPY — review before launch */
/* 04 SIGNATURE — Generation playground. A brand-locked prompt builder → Generate → four variants
   cropped to the format → automated brand check per variant → a person approves one → publish fans
   it out to formats × markets. playground.js runs a full cycle until the first touch, then hands over.
   HTML = the finished run (variant B approved and published). */
$cat_fields = [   // [key, label, options, default index]
    ['product', 'Product', ['Product A', 'Product C', 'Sub-brand B'], 1],
    ['market',  'Market',  ['Market 01', 'Market 03', 'Market 07'], 1],
    ['format',  'Format',  ['4:5', '9:16', '1:1', '16:9'], 0],
    ['mood',    'Mood',    ['Calm', 'Warm', 'Bold'], 0],
];
$cat_locks = ['Palette v7', 'Lockup', 'Clear space', 'Type scale', 'Voice'];
$cat_vars = [   // [id, image|null, alt position, checks [colour, clear space, tone, rights] (1 pass / 0 fail), note]
    ['A', 'out-vase-drape.jpg',  '50% 55%', [1, 1, 1, 1], 'Pass · 0.91'],
    ['B', 'out-vase-grapes.jpg', '46% 50%', [1, 1, 1, 1], 'Pass · 0.94'],
    ['C', 'out-vase-shadow.jpg', '50% 45%', [1, 0, 1, 1], 'Fail · clear space'],
    ['D', null,                  '50% 50%', [1, 1, 1, 0], 'Blocked · rights'],
];
$cat_checks = ['Colour', 'Clear space', 'Tone', 'Rights'];
$cat_pub_f = ['4:5', '9:16', '1:1', '16:9', '3:2', '2:3'];
$cat_pub_m = 9;
?>
<section class="band cat-room cat-pg" id="playground" aria-labelledby="playground-t">
  <span class="cat-room__grid" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl run --watch</b> <span>one brief · checked · approved · live</span></p>
        <h2 class="h2" id="playground-t"><span class="g">One brief in.</span> Checked, approved and live in every format.</h2>
      </div>
      <div>
        <p class="lead">Generation starts from the tuned model with the identity locked. Every variant is scored by the brand check, only passing work reaches a person, and nothing publishes until someone approves it. Try a run, or watch one.</p>
      </div>
    </div>

    <div class="cat-pg__ui" data-rv data-pg-stage="done">
      <p class="bdh-sr">Interactive demo. Choose a product, market, format and mood, then press Generate. Four variants are scored for colour, clear space, tone and rights; variants that pass wait for your approval; approving one publishes it to six formats in nine markets.</p>

      <ol class="cat-pg__rail" aria-hidden="true">
        <li data-pg-step="brief"><b>01</b> Brief</li><li data-pg-step="gen"><b>02</b> Generate</li><li data-pg-step="check"><b>03</b> Check</li><li data-pg-step="review"><b>04</b> Review</li><li data-pg-step="publish"><b>05</b> Publish</li>
      </ol>

      <div class="cat-pg__top">
        <form class="cat-pg__brief" onsubmit="return false" aria-labelledby="pg-brief-t">
          <h3 class="cat-pg__h" id="pg-brief-t">Brief <span class="cat-mono">brand-locked</span></h3>
          <?php foreach ($cat_fields as $cat_f): ?>
            <fieldset class="cat-pg__field">
              <legend><?= e($cat_f[1]) ?></legend>
              <div class="cat-pg__chips">
                <?php foreach ($cat_f[2] as $cat_oi => $cat_opt): ?>
                  <label class="cat-pg__chip"><input type="radio" name="pg-<?= e($cat_f[0]) ?>" value="<?= e($cat_opt) ?>"<?= $cat_oi === $cat_f[3] ? ' checked' : '' ?>><span><?= e($cat_opt) ?></span></label>
                <?php endforeach; ?>
              </div>
            </fieldset>
          <?php endforeach; ?>
          <p class="cat-pg__locks" aria-label="Locked by the brand system"><?php foreach ($cat_locks as $cat_lk): ?><span><?= e($cat_lk) ?></span><?php endforeach; ?></p>
          <p class="cat-pg__prompt" data-pg-prompt>Product C · still life · Market 03 · 4:5 · calm — locked: palette v7, lockup, clear space, type, voice</p>
          <div class="cat-pg__go">
            <button type="button" class="btn btn--ink cat-pg__gen" data-pg-gen>Generate 4 variants <span class="i" aria-hidden="true">›</span></button>
            <span class="cat-illus">Illustrative</span>
          </div>
        </form>

        <div class="cat-pg__vars" style="--ar:4/5;--arn:.8">
          <div class="cat-pg__tracebox" aria-hidden="true"><ol class="cat-pg__trace" data-pg-trace>
            <li><b>gen</b><span>4 variants · tuned model v4.2 · seed locked · 6.1s</span></li>
            <li><b>check</b><span>A pass 0.91 · B pass 0.94</span></li>
            <li><b>check</b><span>C clear space 62% of rule ✕ · returned with fix</span></li>
            <li><b>check</b><span>D blocked before render · reference rights unclear</span></li>
            <li><b>review</b><span>B approved by Brand lead · A held as alternate</span></li>
            <li><b>pub</b><span>54 assets · 6 formats × 9 markets · credentials signed</span></li>
          </ol></div>
          <!-- PLACEHOLDER: reference photography (Unsplash) standing in for generated output — confirm before launch -->
          <?php foreach ($cat_vars as $cat_vi => $cat_v): $cat_pass = array_sum($cat_v[3]) === 4; ?>
            <article class="cat-pg__var<?= $cat_pass ? ' is-pass' : ' is-fail' ?><?= $cat_v[0] === 'B' ? ' is-picked' : '' ?>" data-var="<?= e($cat_v[0]) ?>" style="--i:<?= $cat_vi ?>">
              <div class="cat-pg__frame<?= $cat_v[3][1] ? '' : ' is-tight' ?>" aria-hidden="true">
                <?php if ($cat_v[1]): ?>
                  <img src="<?= xe_url('assets/imgs/brand/brand-ai-tools/' . $cat_v[1]) ?>" alt="" width="750" height="1000" loading="lazy" decoding="async" style="object-position:<?= e($cat_v[2]) ?>">
                <?php else: ?>
                  <span class="cat-pg__blocked">render blocked<br>reference rights unclear</span>
                <?php endif; ?>
                <span class="cat-pg__copy"><b>Your brand</b><em data-pg-line>Quietly made.</em></span>
                <span class="cat-pg__cs"></span>
                <span class="cat-pg__scan"></span>
              </div>
              <div class="cat-pg__vhead">
                <h4 class="cat-pg__vt">Variant <?= e($cat_v[0]) ?></h4>
                <span class="cat-pg__verdict"><?= e($cat_v[4]) ?></span>
              </div>
              <ul class="cat-pg__checks">
                <?php foreach ($cat_checks as $cat_ci => $cat_ck): ?>
                  <li class="<?= $cat_v[3][$cat_ci] ? 'is-ok' : 'is-no' ?>" style="--k:<?= $cat_ci ?>"><span><?= e($cat_ck) ?></span><b aria-label="<?= $cat_v[3][$cat_ci] ? 'pass' : 'fail' ?>"></b></li>
                <?php endforeach; ?>
              </ul>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="cat-pg__bottom">
        <div class="cat-pg__review" aria-labelledby="pg-review-t">
          <h3 class="cat-pg__h" id="pg-review-t">Review queue <span class="cat-mono">Brand lead</span></h3>
          <p class="cat-pg__note">Only variants that pass the check reach a person. Failures go back with the reason attached.</p>
          <ul class="cat-pg__queue">
            <?php foreach ($cat_vars as $cat_v): if (array_sum($cat_v[3]) !== 4) continue; ?>
              <li><span class="cat-pg__qid">Variant <?= e($cat_v[0]) ?></span><span class="cat-pg__qs"><?= e($cat_v[4]) ?></span>
                <button type="button" class="cat-pg__ok" data-pg-approve="<?= e($cat_v[0]) ?>" aria-pressed="<?= $cat_v[0] === 'B' ? 'true' : 'false' ?>">Approve</button></li>
            <?php endforeach; ?>
            <li class="is-back"><span class="cat-pg__qid">C · D</span><span class="cat-pg__qs">Returned to generation</span></li>
          </ul>
        </div>

        <div class="cat-pg__pub" aria-labelledby="pg-pub-t">
          <h3 class="cat-pg__h" id="pg-pub-t">Publish <span class="cat-mono" data-pg-count>54 of 54 live</span></h3>
          <div class="cat-pg__matrix" aria-hidden="true" style="--cols:<?= count($cat_pub_f) ?>">
            <span></span><?php foreach ($cat_pub_f as $cat_pf): ?><span class="cat-pg__fh"><i class="cat-pg__ratio" style="aspect-ratio:<?= e(str_replace(':', '/', $cat_pf)) ?>"></i><?= e($cat_pf) ?></span><?php endforeach; ?>
            <?php for ($cat_m = 1; $cat_m <= $cat_pub_m; $cat_m++): ?>
              <span class="cat-pg__mh">M<?= sprintf('%02d', $cat_m) ?></span><?php foreach ($cat_pub_f as $cat_pi => $cat_pf): ?><i class="is-on" style="--d:<?= $cat_m + $cat_pi ?>"></i><?php endforeach; ?>
            <?php endfor; ?>
          </div>
          <p class="cat-pg__status" data-pg-status aria-live="polite">Variant B approved by Brand lead · published to 6 formats × 9 markets · credentials signed</p>
          <button type="button" class="cat-pg__again" data-pg-reset>Run again</button>
        </div>
      </div>
    </div>
  </div>
</section>
