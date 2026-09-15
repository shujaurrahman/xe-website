<?php /* DRAFT COPY — review before launch */
/* 05 Guardrails as a test runner. Left: the guardrail suite executing (ticks, one failure that
   expands to its diff and fix, then passes on re-run). Right: the policy the tests enforce.
   HTML = the finished suite (all passing, the fixed test marked). guardrails.js replays it. */
$cat_suite = [   // group => [[test name, ms, fails first?]]
    'palette' => [['uses palette v7 tokens only · ΔE ≤ 2.0', 12, false], ['keeps text contrast at AA or above', 9, false]],
    'logo'    => [['keeps clear space ≥ 1× mark height', 14, false], ['never recolours or stretches the lockup', 8, false]],
    'voice'   => [['never uses a never-say term in a headline', 21, true], ['reads at tone score ≥ 0.80', 33, false]],
    'rights'  => [['uses only references with cleared rights', 11, false], ['blocks the likeness of a real person', 17, false]],
    'review'  => [['sends regulated claims to a person', 6, false], ['sends pricing and apologies to a person', 6, false]],
    'log'     => [['records who, what, when and model version', 4, false]],
];
$cat_tests = 0; foreach ($cat_suite as $cat_g) { $cat_tests += count($cat_g); }
?>
<section class="band cat-paper cat-gr" id="guardrails" aria-labelledby="guardrails-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl test ./guardrails</b> <span>runs on every model version and every output</span></p>
        <h2 class="h2" id="guardrails-t"><span class="g">Guardrails written as tests,</span> not hopes.</h2>
      </div>
      <p class="lead">Before anything is generated, the rules are written as tests that can fail. When one does, you see exactly what broke, what changed to fix it and who signed the fix off. The same suite runs again on every new model version.</p>
    </div>

    <div class="cat-gr__ui" data-rv>
      <div class="cat-gr__run" data-gr-stage="done">
        <div class="cat-gr__bar">
          <p class="cat-gr__file"><span class="cat-led cat-led--pulse"></span>guardrails.spec <span><?= $cat_tests ?> tests</span></p>
          <p class="cat-gr__sum" aria-live="polite" data-gr-sum><b><?= $cat_tests ?></b> passed (1 after a fix) · 0 failing</p>
          <button type="button" class="cat-gr__btn" data-gr-run>Run suite</button>
        </div>
        <span class="cat-gr__prog" aria-hidden="true"><i data-gr-prog style="--p:1"></i></span>

        <ol class="cat-gr__groups">
          <?php $cat_n = 0; foreach ($cat_suite as $cat_gname => $cat_g): ?>
            <li class="cat-gr__group">
              <p class="cat-gr__desc">describe <b><?= e($cat_gname) ?></b></p>
              <ul>
                <?php foreach ($cat_g as $cat_t): $cat_n++; ?>
                  <li class="cat-gr__t is-pass<?= $cat_t[2] ? ' is-fixed' : '' ?>" data-gr-fail="<?= $cat_t[2] ? '1' : '0' ?>">
                    <?php if ($cat_t[2]): ?>
                      <button type="button" class="cat-gr__row" aria-expanded="false" aria-controls="gr-diff"><span class="cat-gr__ic" aria-hidden="true"></span><span class="cat-gr__name"><?= e($cat_t[0]) ?></span><span class="cat-gr__ms"><?= $cat_t[1] ?>ms</span><span class="cat-gr__more" aria-hidden="true"></span></button>
                      <div class="cat-gr__diff" id="gr-diff" hidden>
                        <p class="cat-gr__dl"><span>expected</span> headline contains 0 never-say terms</p>
                        <p class="cat-gr__dl"><span>received</span> “A revolutionary way to start the day” · 1 term</p>
                        <pre class="cat-gr__code"><code><span class="is-del">- prompt-set v3.0 · lexicon: 41 never-say terms</span>
<span class="is-add">+ prompt-set v3.1 · lexicon: 42 never-say terms (+ revolutionary)</span>
<span class="is-add">+ copy assistant regenerated · eval re-run 0.91</span></code></pre>
                        <p class="cat-gr__fix"><span>Fix</span> Term added to the lexicon, the copy assistant regenerated and the suite run again. Signed off by the Copy lead.</p>
                        <button type="button" class="cat-gr__apply" data-gr-fix>Apply fix and re-run</button>
                      </div>
                    <?php else: ?>
                      <p class="cat-gr__row"><span class="cat-gr__ic" aria-hidden="true"></span><span class="cat-gr__name"><?= e($cat_t[0]) ?></span><span class="cat-gr__ms"><?= $cat_t[1] ?>ms</span></p>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <aside class="cat-gr__policy" aria-labelledby="gr-policy-t">
        <h3 class="cat-gr__h" id="gr-policy-t">The policy the tests enforce</h3>
        <p class="cat-gr__lead"><?= e($CAT['offer'][5][1]) ?></p>
        <!-- PLACEHOLDER: illustrative policy — agree the real thresholds and owners before launch -->
        <pre class="cat-gr__yaml" aria-label="Policy file"><code><i># policy.yaml · your-brand</i>
<b>automatic:</b>
  - variants from an approved source
  - sizes and market versions
  - copy drafts inside the lexicon
<b>needs_a_person:</b>
  - regulated claims
  - people, pricing, apologies
  - anything flagged twice
<b>never:</b>
  - a likeness without consent
  - references with unclear rights
<b>log:</b> every output · who · what · when · model</code></pre>
        <p class="cat-gr__foot"><span class="cat-illus">Illustrative</span> Ships as: <?= e($CAT['deliver'][5][0]) ?> · <?= e($CAT['deliver'][5][1]) ?></p>
      </aside>
    </div>
  </div>
</section>
