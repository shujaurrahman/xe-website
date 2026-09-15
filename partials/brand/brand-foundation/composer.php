<?php /* DRAFT COPY — review before launch */
/* §4 SIGNATURE — Positioning composer. Pick an option for each blank; an agent stress-tests the
   statement (distinct · credible · ownable) and a person signs it off. HTML = the finished, signed
   state (computed here); composer.js autoplays a composition from a weak draft until touched. */
$cbf_cmp_slots = [   // key => [label, [[text, distinct, credible, ownable, weakness note], …]]
    'aud' => ['Audience', [
        ['everyone who manages money',                  -2, 0, -1, 'the audience is too broad to be distinct.'],
        ['finance teams at mid-sized firms',              1, 1,  0, 'a sound segment, but a crowded one.'],
        ['finance leads closing the month under pressure', 2, 1, 1, ''],
    ]],
    'need' => ['Need', [
        ['want better software',          -2, 0, -1, 'every competitor answers this need.'],
        ['need numbers they can defend',   1, 1,  1, ''],
        ['need to close faster',           0, 1, -1, 'speed is claimed across the category.'],
    ]],
    'frame' => ['Frame', [
        ['the leading platform',     -2, -1, -2, '“leading” is unproven and widely claimed.'],
        ['the operations partner',    1,  0,  1, ''],
        ['the finance record',        2,  0,  1, ''],
    ]],
    'ben' => ['Benefit', [
        ['saves time',                   -1,  1, -1, 'time saved is a category promise.'],
        ['makes every figure traceable',  2,  1,  1, ''],
        ['delivers peace of mind',       -1, -1, -1, 'hard to evidence and easy to copy.'],
    ]],
    'why' => ['Reason', [
        ['it uses AI',                                 -2, -1, -2, 'a tool is not a reason; any rival can say it.'],
        ['every entry links to its source document',     1,  2,  2, ''],
        ['it has served the sector for decades',         0,  2,  0, 'true, but it proves longevity rather than the benefit.'],
    ]],
];
$cbf_cmp_checks = [   // key => [label, question, pass rationale]
    'd' => ['Distinct', 'Would it read differently from the category?', 'Frame and benefit differ from the category statements scanned.'],
    'c' => ['Credible', 'Can every claim be evidenced?',                'The reason can be shown from product data and interviews.'],
    'o' => ['Ownable',  'Could a rival say it tomorrow?',               'A rival could not repeat this without changing what it does.'],
];
$cbf_cmp_final = ['aud' => 2, 'need' => 1, 'frame' => 2, 'ben' => 1, 'why' => 1];
$cbf_cmp_json  = json_encode(['slots' => $cbf_cmp_slots, 'checks' => $cbf_cmp_checks, 'pass' => 3, 'weak' => ['aud' => 0, 'need' => 0, 'frame' => 0, 'ben' => 0, 'why' => 0], 'best' => $cbf_cmp_final], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
$cbf_cmp_txt   = fn (string $k): string => $cbf_cmp_slots[$k][1][$cbf_cmp_final[$k]][0];
$cbf_cmp_part  = function (string $k) use ($cbf_cmp_slots, $cbf_cmp_final): string {
    return '<button type="button" class="cbf-cmp__slot" data-slot="' . $k . '" aria-pressed="' . ($k === 'aud' ? 'true' : 'false') . '" aria-controls="composer-tray"><span class="bdh-sr">' . e($cbf_cmp_slots[$k][0]) . ': </span><span class="cbf-cmp__val">' . e($cbf_cmp_slots[$k][1][$cbf_cmp_final[$k]][0]) . '</span></button>';
};
?>
<section class="band band--alt cbf-cmp" id="composer" aria-labelledby="composer-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 04</b>Composer</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="composer-t"><span class="g">Compose a positioning.</span> Then let it be argued with.</h2>
        <p class="lead"><?= e($CAP['offer'][1][1]) ?> Here, an agent stress-tests every draft on three checks, and a person decides whether it is signed.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: illustrative statement, options and check rules — confirm before launch -->
    <div class="cbf-cmp__desk" data-cbf-cmp='<?= $cbf_cmp_json ?>'>
      <p class="bdh-sr">Interactive demo. Choose an option for each part of the positioning statement; three automated checks update, and the statement can be signed off once all three pass.</p>
      <header class="cbf-cmp__bar">
        <span class="cbf-mono">§ 1.2 · Positioning statement · working draft</span>
        <span class="cbf-cmp__bar-r"><span class="cbf-ill">Illustrative</span><span class="cbf-mono cbf-cmp__auto" data-cmp-auto>Composing…</span></span>
      </header>

      <div class="cbf-cmp__body">
        <div class="cbf-cmp__draft">
          <p class="cbf-cmp__stmt">For <?= $cbf_cmp_part('aud') ?> who <?= $cbf_cmp_part('need') ?>, Your brand is <?= $cbf_cmp_part('frame') ?> that <?= $cbf_cmp_part('ben') ?>, because <?= $cbf_cmp_part('why') ?>.</p>

          <div class="cbf-cmp__overlap">
            <p class="cbf-mono">Agent · category scan <span aria-hidden="true">—</span> phrases shared with competitors</p>
            <p class="cbf-cmp__struck" data-cmp-overlap><span class="cbf-cmp__none">None of these parts repeats the category statements scanned.</span></p>
          </div>

          <fieldset class="cbf-cmp__tray" id="composer-tray">
            <legend class="cbf-cmp__legend"><span class="cbf-mono">Editing</span> <b data-cmp-legend><?= e($cbf_cmp_slots['aud'][0]) ?></b><span class="cbf-cmp__mini" data-cmp-mini aria-hidden="true">Agent · 3 of 3 pass</span></legend>
            <div class="cbf-cmp__opts" data-cmp-opts>
              <?php foreach ($cbf_cmp_slots['aud'][1] as $cbf_oi => $cbf_o): ?>
                <label class="cbf-cmp__opt"><input type="radio" name="composer-opt" value="<?= $cbf_oi ?>"<?= $cbf_oi === $cbf_cmp_final['aud'] ? ' checked' : '' ?>><span><?= e($cbf_o[0]) ?></span></label>
              <?php endforeach; ?>
            </div>
          </fieldset>
        </div>

        <aside class="cbf-cmp__test" aria-labelledby="composer-test-t">
          <p class="cbf-cmp__who"><span class="cbf-cmp__pip" aria-hidden="true"></span><span id="composer-test-t">Agent · stress test</span><span class="cbf-mono" data-cmp-run>3 checks run</span></p>
          <ul class="cbf-cmp__checks" aria-live="polite">
            <?php foreach ($cbf_cmp_checks as $cbf_ck => $cbf_c): ?>
              <li class="cbf-cmp__check is-pass" data-check="<?= $cbf_ck ?>">
                <span class="cbf-cmp__mark" aria-hidden="true"></span>
                <div>
                  <p class="cbf-cmp__ct"><?= e($cbf_c[0]) ?> <span class="cbf-cmp__res" data-res>Pass</span></p>
                  <p class="cbf-cmp__cq"><?= e($cbf_c[1]) ?></p>
                  <p class="cbf-cmp__why" data-why><?= e($cbf_c[2]) ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>

          <div class="cbf-cmp__sign is-signed">
            <p class="cbf-cmp__sl"><span class="cbf-mono">Decision · people only</span></p>
            <div class="cbf-cmp__line">
              <svg class="cbf-cmp__sig" viewBox="0 0 220 48" aria-hidden="true"><path d="M6 34c10-18 18-26 22-20s-8 22-2 20 14-24 20-22-4 20 2 20 10-12 16-14 4 10 10 10 12-16 20-16-2 14 6 14 20-8 30-10 24 2 38-2 26-6 40-8"/></svg>
              <span class="cbf-mono cbf-cmp__stamp" data-cmp-stamp>Signed · Executive team · v1.0</span>
            </div>
            <div class="cbf-cmp__acts">
              <button type="button" class="btn btn--dark btn--sm cbf-cmp__go" data-cmp-sign aria-pressed="true">Signed off</button>
              <button type="button" class="btn btn--out btn--sm" data-cmp-redraft>Redraft</button>
            </div>
            <p class="cbf-cmp__rule">The agent can only flag. Signing is a leadership decision and is recorded with the version.</p>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
