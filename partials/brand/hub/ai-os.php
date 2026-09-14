<?php /* DRAFT COPY — review before launch */
/* The AI brand operating system — the ink showpiece. A working mock app: Check (three sample assets,
   each with one real issue, a suggested fix and a human approval), Generate, Guidelines and Log.
   The markup is the finished state (asset 01 fixed and approved); ai-os.js plays the demo. */
$os_checks = ['Colour tokens', 'Clearspace', 'Type scale', 'Contrast · WCAG AA', 'Tone of voice', 'Claims & disclosures'];
$os_assets = [
    // [label, format, flagged check index, issue, rule, before, after]
    ['Market 03 · social',  '4:5',  3, 'Call-to-action contrast is 3.4:1', 'Needs 4.5:1. Switch the label to ink on paper.', 'White label on pale blue', 'Ink label on paper'],
    ['Partner · web banner', '16:9', 1, 'Partner lockup clearspace is 0.4×', 'Needs 1×. Move the partner lockup right.', 'Lockups 0.4× apart', 'Lockups 1× apart'],
    ['Retail · window poster', '4:5', 5, 'Unsubstantiated claim', 'Use a specific, evidenced claim from the claims library.', '“The greenest choice on the shelf.”', '“Carton made with recycled board.”'],
];
$os_rails = ['Palette locked', 'Approved photography style', 'Brand type scale only', 'Claims from the approved library', 'Released imagery only'];
$os_outs = [['gen-1.jpg', 900, 600, 'Pass'], ['gen-2.jpg', 900, 506, 'Pass'], ['gen-3.jpg', 900, 601, 'Review · crop hides product'], ['gen-4.jpg', 900, 600, 'Pass']];
$os_log = [
    ['10:42', 'Market 03 · social',   'Contrast fixed by agent',        'Approved', 'Shipped'],
    ['10:31', 'Partner · web banner', 'Clearspace flagged',             'Sent to reviewer', 'In review'],
    ['10:18', 'Market 07 · email',    'Localised variant generated',    'Signed off in-market', 'Shipped'],
    ['09:56', 'Retail · poster',      'Claim flagged · rewrite proposed','Rewritten by copy lead', 'Shipped'],
    ['09:40', 'Guidelines',           'Rule update proposed (v3.2)',     'Approved by Brand owner', 'Released'],
];
$os_strip = [
    ['Research synthesis',          'Interviews, reviews and market signals turned into themes with sources attached.'],
    ['Generation within guardrails', 'Variants produced from approved parts only.'],
    ['Automated brand check',       'Every asset checked before it ships, not after.'],
    ['Localisation at scale',       'Market versions drafted, then signed off in-market.'],
    ['Drift monitoring',            'Live channels watched; the brand owner sees what slipped.'],
];
$os_tabs = [['Check', '3 assets'], ['Generate', '4 outputs'], ['Guidelines', 'v3.2'], ['Log', count($os_log) . ' today']];
$os_img = fn (string $f) => xe_url('assets/imgs/brand/hub/ai-os/' . $f);
?>
<section class="band band--ink bdh-ai-os" id="ai-os" aria-labelledby="ai-os-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>AI-native brand operations</p>
      <h2 class="h2" id="ai-os-t"><span class="g">Your brand, as software.</span> Guidelines that check, generate and keep current.</h2>
      <p class="lead">We turn the brand into machine-readable rules, then build agents that apply them: checking every asset, generating within guardrails and keeping guidelines current. People set the rules and make the calls.</p>
    </div>

    <p class="bdh-sr">An interactive demonstration of a brand operating system. In the Check tab an agent scans three sample assets, flags one issue in each (low contrast, tight clearspace, an unsubstantiated claim), proposes a fix, and a person approves it, which is written to the log. The Generate, Guidelines and Log tabs show generation within guardrails, a guidelines answer with its changelog, and the audit log.</p>

    <!-- PLACEHOLDER: reference photography (Unsplash) inside the sample assets — replace before launch -->
    <div class="bdh-ui bdh-ui--ink bdh-os" data-rv data-rv-d="100" data-bdh-live>
      <div class="bdh-ui__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="bdh-os__title">Brand OS · Your brand · workspace</span>
        <span class="bdh-os__status"><i class="bdh-pulse" aria-hidden="true"></i>Agent online</span>
      </div>

      <div class="bdh-os__body">
        <div class="bdh-os__side">
          <div class="bdh-tabs bdh-os__tabs" role="tablist" aria-label="Brand OS views" aria-orientation="vertical">
            <?php foreach ($os_tabs as $os_i => $os_t): ?>
              <button type="button" role="tab" id="ai-os-t<?= $os_i ?>" aria-controls="ai-os-p<?= $os_i ?>" aria-selected="<?= $os_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $os_i === 0 ? '0' : '-1' ?>">
                <span><?= e($os_t[0]) ?></span><small><?= e($os_t[1]) ?></small>
              </button>
            <?php endforeach; ?>
          </div>
          <div class="bdh-os__rules" aria-hidden="true"><span>Rules loaded</span><b>v3.2 · 148 rules</b><span>Owner · Brand council</span></div>
        </div>

        <div class="bdh-os__main bdh-panes">
          <!-- CHECK -->
          <div class="bdh-pane bdh-os__pane is-on" id="ai-os-p0" role="tabpanel" aria-labelledby="ai-os-t0">
            <div class="bdh-os__assets" role="group" aria-label="Sample assets">
              <?php foreach ($os_assets as $os_i => $os_a): ?>
                <button class="bdh-os__asset" type="button" data-asset="<?= $os_i ?>" aria-pressed="<?= $os_i === 0 ? 'true' : 'false' ?>"><?= e($os_a[0]) ?><small><?= e($os_a[1]) ?></small></button>
              <?php endforeach; ?>
            </div>

            <div class="bdh-os__stage" data-asset="0" data-state="fixed">
              <div class="bdh-os__canvas" aria-hidden="true">
                <span class="bdh-os__scan"></span>

                <div class="bdh-os__af bdh-os__af--0">
                  <div class="bdh-os__art bdh-os__art--social">
                    <img src="<?= $os_img('social-b.jpg') ?>" alt="" width="900" height="596" loading="lazy" decoding="async">
                    <b class="bdh-os__wm">Your brand</b>
                    <p class="bdh-os__hl">Made for the way you move.</p>
                    <span class="bdh-os__cta bdh-os__mark" data-note="Contrast 3.4:1">Shop the range</span>
                  </div>
                </div>

                <div class="bdh-os__af bdh-os__af--1">
                  <div class="bdh-os__art bdh-os__art--banner">
                    <div class="bdh-os__bcopy">
                      <span class="bdh-os__lock bdh-os__mark" data-note="Clearspace 0.4×"><b>Your brand</b><i></i><b>Partner</b></span>
                      <p class="bdh-os__bh">Better together, in every market.</p>
                      <span class="bdh-os__bbtn">Learn more</span>
                    </div>
                    <span class="bdh-os__bimg"><img src="<?= $os_img('gen-1.jpg') ?>" alt="" width="900" height="600" loading="lazy" decoding="async"></span>
                  </div>
                </div>

                <div class="bdh-os__af bdh-os__af--2">
                  <div class="bdh-os__art bdh-os__art--poster">
                    <span class="bdh-os__pimg"><img src="<?= $os_img('retail-shelf.jpg') ?>" alt="" width="900" height="600" loading="lazy" decoding="async"></span>
                    <div class="bdh-os__pcopy">
                      <b class="bdh-os__wm bdh-os__wm--ink">Your brand</b>
                      <p class="bdh-os__claim bdh-os__mark" data-note="Unsubstantiated"><span class="is-before">The greenest choice on the shelf.</span><span class="is-after">Carton made with recycled board.</span></p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="bdh-os__insp">
                <p class="bdh-os__ih"><span>Brand check</span><span class="bdh-os__score"><?= count($os_checks) ?> / <?= count($os_checks) ?> pass</span></p>
                <ul class="bdh-os__checks">
                  <?php foreach ($os_checks as $os_c): ?><li class="is-ok"><span><?= e($os_c) ?></span><b aria-hidden="true"></b></li><?php endforeach; ?>
                </ul>

                <div class="bdh-os__fix" aria-live="polite">
                  <p class="bdh-os__fk"><span class="bdh-flag" aria-hidden="true">!</span>Suggested fix</p>
                  <?php foreach ($os_assets as $os_i => $os_a): ?>
                    <div class="bdh-os__fc bdh-os__fc--<?= $os_i ?>">
                      <p class="bdh-os__ft"><?= e($os_a[3]) ?></p>
                      <p class="bdh-os__fn"><?= e($os_a[4]) ?></p>
                      <p class="bdh-os__diff"><del><?= e($os_a[5]) ?></del><ins><?= e($os_a[6]) ?></ins></p>
                    </div>
                  <?php endforeach; ?>
                  <div class="bdh-os__fa">
                    <button class="btn btn--white btn--sm bdh-os__apply" type="button">Apply fix</button>
                    <button class="bdh-os__send" type="button">Send to reviewer</button>
                  </div>
                  <p class="bdh-os__done"><b class="bdh-ok" aria-hidden="true">✓</b><span class="bdh-os__donet">Approved by Brand reviewer · logged</span></p>
                </div>
              </div>
            </div>
          </div>

          <!-- GENERATE -->
          <div class="bdh-pane bdh-os__pane bdh-os__gen" id="ai-os-p1" role="tabpanel" aria-labelledby="ai-os-t1">
            <p class="bdh-os__k">Prompt</p>
            <p class="bdh-os__prompt"><span class="bdh-os__typed" data-text="Launch visual for Market 03, 4:5, product in use, calm light">Launch visual for Market 03, 4:5, product in use, calm light</span><span class="bdh-caret" aria-hidden="true"></span></p>
            <p class="bdh-os__k">Guardrails</p>
            <ul class="bdh-os__rails">
              <?php foreach ($os_rails as $os_i => $os_r): ?><li style="--i:<?= $os_i ?>"><b class="bdh-ok" aria-hidden="true">✓</b><?= e($os_r) ?></li><?php endforeach; ?>
            </ul>
            <ul class="bdh-os__outs">
              <?php foreach ($os_outs as $os_i => $os_o): $os_rev = $os_o[3] !== 'Pass'; ?>
                <li style="--i:<?= $os_i ?>">
                  <span class="bdh-os__oimg"><img src="<?= $os_img($os_o[0]) ?>" alt="Generated output <?= $os_i + 1 ?>" width="<?= $os_o[1] ?>" height="<?= $os_o[2] ?>" loading="lazy" decoding="async"></span>
                  <span class="bdh-os__badge<?= $os_rev ? ' is-review' : '' ?>"><?= $os_rev ? '!' : '✓' ?> <?= e($os_o[3]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- GUIDELINES -->
          <div class="bdh-pane bdh-os__pane bdh-os__guide" id="ai-os-p2" role="tabpanel" aria-labelledby="ai-os-t2">
            <p class="bdh-os__search"><span aria-hidden="true">⌕</span><span class="bdh-os__typed" data-text="Can a partner place our logo on a dark background?">Can a partner place our logo on a dark background?</span><span class="bdh-caret" aria-hidden="true"></span></p>
            <div class="bdh-os__answer">
              <p class="bdh-os__k">Answer · from the living guidelines</p>
              <p class="bdh-os__at">Yes. Use the reversed lockup with 1× clearspace, on a background from the approved dark palette.</p>
              <p class="bdh-os__cite"><span class="bdh-tag">4.2 Co-branding</span><span class="bdh-tag">2.1 Clearspace</span></p>
            </div>
            <p class="bdh-os__k">Changelog</p>
            <ul class="bdh-os__changes">
              <li><b>v3.2</b><span>Small-text contrast rule tightened; affected templates updated</span><small>Approved by Brand owner</small></li>
              <li><b>v3.1</b><span>Market 07 added to the localisation set</span><small>Approved by Brand council</small></li>
              <li><b>v3.0</b><span>Motion principles published</span><small>Approved by Brand owner</small></li>
            </ul>
          </div>

          <!-- LOG -->
          <div class="bdh-pane bdh-os__pane bdh-os__logp" id="ai-os-p3" role="tabpanel" aria-labelledby="ai-os-t3">
            <div class="bdh-os__tablewrap">
              <table class="bdh-os__log">
                <thead><tr><th scope="col">Time</th><th scope="col">Asset</th><th scope="col">Agent action</th><th scope="col">Human decision</th><th scope="col">Status</th></tr></thead>
                <tbody>
                  <?php foreach ($os_log as $os_l): ?>
                    <tr><td><?= e($os_l[0]) ?></td><td><?= e($os_l[1]) ?></td><td><?= e($os_l[2]) ?></td><td><?= e($os_l[3]) ?></td><td><span class="bdh-os__st"><?= e($os_l[4]) ?></span></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <ol class="bdh-os__strip" data-rv-s data-rv-step="80">
      <?php foreach ($os_strip as $os_i => $os_s): ?>
        <li><span class="bdh-idx"><?= str_pad((string) ($os_i + 1), 2, '0', STR_PAD_LEFT) ?></span><h3 class="bdh-t bdh-t--s"><?= e($os_s[0]) ?></h3><p class="bdh-d"><?= e($os_s[1]) ?></p></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
