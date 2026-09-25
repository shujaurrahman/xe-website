<?php /* DRAFT COPY — review before launch */
/* Split — the signature comparison: one asset wall, drawn twice. The control is a real radio group
   (Before · Split · After) and the reveal is pure CSS off :checked, so it works with JavaScript
   disabled and with a keyboard alone. split.js only adds the drag handle on top of it. */
$wrk_assets = [
    ['Launch poster',  'A3',      'type −2%',           'built from master'],
    ['Product page',   'web',     'blue not the token', 'token blue'],
    ['Pack front',     '120 ml',  'claim unverified',   'claim from library'],
    ['Email header',   '600 px',  'logo scaled 108%',   'lockup locked'],
    ['Social 1:1',     '1080',    'crop off safe area', 'safe area held'],
    ['OOH 6-sheet',    '6-sheet', 'margin 14 px',       'margin from rule'],
    ['Deck cover',     '16:9',    'second typeface',    'one typeface'],
    ['In-store card',  'A5',      'ok',                 'built from master'],
];
$wrk_flags = 0;
foreach ($wrk_assets as $wrk_a) if ($wrk_a[2] !== 'ok') $wrk_flags++;
?>
<section class="band wrk-split-s" id="before-after" aria-labelledby="before-after-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Before / after</p>
        <h2 class="h2" id="before-after-t"><span class="g">The visible change</span> is the drift disappearing.</h2>
      </div>
      <div>
        <p class="lead">Most of what a brand or platform programme changes is invisible in a single asset and obvious across a wall of them. Drag the divider, or use the control, to see the same eight assets before and after the system.</p>
      </div>
    </div>

    <div class="wrk-split__grid">

      <div class="wrk-split__say">
        <dl class="wrk-split__stats">
          <div><dt class="bdh-ro">Before</dt><dd><span class="wrk-split__fig"><?= $wrk_flags ?></span>drift flags across 8 assets · 3 reviewers, no single owner</dd></div>
          <div><dt class="bdh-ro">After</dt><dd><span class="wrk-split__fig">0</span>drift flags · one approver, every decision logged</dd></div>
        </dl>
        <p class="p">Drift is not carelessness. It is what happens when the rule lives in a PDF and the deadline lives in a calendar. Moving the rule into the template — and the check in front of the reviewer — is the whole of the work.</p>
        <!-- PLACEHOLDER: reference photograph (assets/imgs/work/CREDITS.md) — replace with own project photography -->
        <?= wrk_img(['file' => 'split-shelves.jpg', 'alt' => 'Unbranded products arranged on shop shelving', 'w' => 900, 'h' => 1200, 'pos' => '50% 50%'], [
            'ratio' => 'r43', 'class' => 'wrk-split__ph',
            'inner' => '<span class="bdh-cap-chip wrk-split__cap"><b>Where drift shows</b>Side by side on a shelf, not one at a time in a review</span>']) ?>
      </div>

      <div class="wrk-split" data-wrk-split>
        <p class="sr" id="wrk-split-help">Choose how much of the asset wall to show before the system, and how much after it.</p>
        <input class="sr wrk-split__r" type="radio" name="wrk-split" id="wrk-split-b" value="100" aria-describedby="wrk-split-help">
        <input class="sr wrk-split__r" type="radio" name="wrk-split" id="wrk-split-s" value="50" checked aria-describedby="wrk-split-help">
        <input class="sr wrk-split__r" type="radio" name="wrk-split" id="wrk-split-a" value="0" aria-describedby="wrk-split-help">

        <div class="wrk-split__bar">
          <p class="bdh-ro wrk-split__ttl"><span class="bdh-pulse"></span>Your brand · asset wall<b class="bdh-ill">Illustrative</b></p>
          <div class="bdh-seg wrk-split__seg">
            <label for="wrk-split-b">Before</label><label for="wrk-split-s">Split</label><label for="wrk-split-a">After</label>
          </div>
        </div>

        <div class="wrk-split__stage">
          <p class="bdh-sr">The same eight assets are drawn twice. Before the system, five of the eight carry a drift flag: type at minus two per cent, a blue that is not the token, an unverified claim, a logo scaled to 108 per cent, a crop outside the safe area, a hand-set margin and a second typeface. After the system, all eight are built from the master and every check passes.</p>

          <div class="wrk-split__pane wrk-split__pane--after" aria-hidden="true">
            <ul class="wrk-wall">
              <?php foreach ($wrk_assets as $wrk_i => $wrk_a): ?>
              <li style="--i:<?= $wrk_i ?>"><span class="wrk-wall__k bdh-ro"><?= e($wrk_a[1]) ?></span><span class="wrk-wall__n"><?= e($wrk_a[0]) ?></span><span class="wrk-wall__s wrk-wall__s--ok bdh-ro">✓ <?= e($wrk_a[3]) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <p class="wrk-split__foot bdh-ro"><span>8 assets · 0 flags</span><span>1 approver · logged</span></p>
          </div>

          <div class="wrk-split__pane wrk-split__pane--before" aria-hidden="true">
            <ul class="wrk-wall wrk-wall--pre">
              <?php foreach ($wrk_assets as $wrk_i => $wrk_a): $wrk_bad = $wrk_a[2] !== 'ok'; ?>
              <li style="--i:<?= $wrk_i ?>"><span class="wrk-wall__k bdh-ro"><?= e($wrk_a[1]) ?></span><span class="wrk-wall__n"><?= e($wrk_a[0]) ?></span><span class="wrk-wall__s<?= $wrk_bad ? ' wrk-wall__s--bad' : '' ?> bdh-ro"><?= $wrk_bad ? '!&nbsp;' . e($wrk_a[2]) : '✓ ok' ?></span></li>
              <?php endforeach; ?>
            </ul>
            <p class="wrk-split__foot bdh-ro"><span>8 assets · <?= $wrk_flags ?> flags</span><span>3 reviewers · no owner</span></p>
          </div>

          <span class="wrk-split__line" aria-hidden="true"><i></i></span>
          <button class="wrk-split__grab" type="button" data-wrk-grab aria-label="Drag to compare before and after" hidden><span aria-hidden="true">‹ ›</span></button>
        </div>
      </div>

    </div>
  </div>
</section>
