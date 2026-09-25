<?php /* DRAFT COPY — review before launch */
/* Mix — the data-viz idiom. Two charts and a chain. Left: budget split by the job each part of the
   mix does, with three scenarios behind a tablist, because a budget model is only useful if it
   survives the budget changing. Right: what the platforms report against what a geo holdout says was
   incremental. Below: the consented measurement layer that has to exist before either number can be
   trusted. Bars are .cch-bar, the shared figure idiom; every fill grows with .bdh-grow and the
   noscript rule in partials/head.php leaves them full width without JavaScript.
   PLACEHOLDER: every figure on this page is illustrative, drawn to show the shape of the decision. */
$mx_scenes = [
    [
        'k' => 'flat', 'tab' => 'Same budget', 'lead' => 'Held steady, the split follows the job each part of the mix does rather than last quarter\'s habit.',
        'rows' => [
            ['Brand · future demand',   40, 'Reach people who are not in market yet'],
            ['Demand capture · now',    45, 'Meet the people already searching and comparing'],
            ['Retention · already ours',15, 'Keep and grow the customers you have'],
        ],
    ],
    [
        'k' => 'down', 'tab' => 'Cut by 20%', 'lead' => 'Under a cut, capture and retention are protected first, and brand is reduced rather than stopped, because restarting it costs more than continuing.',
        'rows' => [
            ['Brand · future demand',   30, 'Reduced, not switched off'],
            ['Demand capture · now',    52, 'Protected: it is the shortest path to revenue'],
            ['Retention · already ours',18, 'Protected: the cheapest revenue you have'],
        ],
    ],
    [
        'k' => 'up', 'tab' => 'Up by 30%', 'lead' => 'With more to spend, the extra goes where the holdout tests say there is still headroom, not evenly across everything.',
        'rows' => [
            ['Brand · future demand',   48, 'Where the tests show unmet reach'],
            ['Demand capture · now',    38, 'Already near the efficient frontier'],
            ['Retention · already ours',14, 'Grown with programmes, not with media'],
        ],
    ],
];
$mx_lift = [
    ['Platform-reported conversions', 100, 'What the ad platforms claim, each counting its own touch', 'q'],
    ['Incremental, from a geo holdout', 62, 'What stopped happening when the spend stopped', ''],
];
$mx_chain = [
    ['Consent captured',        'Choices recorded once and passed to every tag that fires'],
    ['Server-side tagging',     'Events sent from your server, so a browser setting cannot silently drop them'],
    ['Conversion APIs',         'Outcomes returned to each platform, so it optimises towards customers'],
    ['Offline and CRM imports', 'Closed-won deals and refunds sent back, so the platforms learn what was real'],
    ['One metric layer',        'Warehouse definitions that marketing, sales and finance all read the same way'],
];
?>
<section class="band cch-mix" id="mix" aria-labelledby="mix-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The mix and the lift</p>
        <h2 class="h2" id="mix-t"><span class="g">Every channel claims the sale.</span> Arithmetic decides the budget.</h2>
      </div>
      <div>
        <p class="lead">Spend is split by the job each part of the mix does, modelled against a larger and a smaller budget, and corrected by tests that show what the media actually added. Last-click reports are a diagnostic, not a decision.</p>
      </div>
    </div>

    <div class="cch-mx__grid">
      <div class="cch-mx__card cch-mx__card--split" data-rv data-rv-d="60">
        <p class="cch-mx__ch">
          <span class="cch-k">Budget by the job it does</span>
          <span class="cch-ill">Illustrative</span>
        </p>
        <div class="bdh-seg cch-mx__seg" role="tablist" aria-label="Budget scenario">
          <?php foreach ($mx_scenes as $mx_i => $mx_s): ?>
            <button type="button" role="tab" id="mix-t<?= $mx_i ?>" aria-controls="mix-p<?= $mx_i ?>"
                    aria-selected="<?= $mx_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $mx_i === 0 ? '0' : '-1' ?>"><?= e($mx_s['tab']) ?></button>
          <?php endforeach; ?>
        </div>

        <div class="bdh-panes cch-mx__panes">
          <?php foreach ($mx_scenes as $mx_i => $mx_s): ?>
            <div class="bdh-pane cch-mx__pane<?= $mx_i === 0 ? ' is-on' : '' ?>" id="mix-p<?= $mx_i ?>" role="tabpanel" aria-labelledby="mix-t<?= $mx_i ?>" tabindex="0">
              <div class="cch-bars cch-mx__bars">
                <?php foreach ($mx_s['rows'] as $mx_ri => $mx_r): ?>
                  <p class="cch-bar">
                    <span class="cch-bar__n"><?= e($mx_r[0]) ?></span>
                    <span class="cch-bar__v"><?= (int) $mx_r[1] ?>%</span>
                    <span class="cch-bar__t"><i class="cch-bar__f bdh-grow" style="--w:<?= (int) $mx_r[1] ?>%;--i:<?= $mx_ri ?>"></i></span>
                    <span class="cch-bar__s"><?= e($mx_r[2]) ?></span>
                  </p>
                <?php endforeach; ?>
              </div>
              <p class="cch-mx__lead"><?= e($mx_s['lead']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="cch-mx__card" data-rv data-rv-d="100">
        <p class="cch-mx__ch">
          <span class="cch-k">Reported against incremental</span>
          <span class="cch-ill">Illustrative</span>
        </p>
        <div class="cch-bars cch-mx__bars">
          <?php foreach ($mx_lift as $mx_li => $mx_l): ?>
            <p class="cch-bar">
              <span class="cch-bar__n"><?= e($mx_l[0]) ?></span>
              <span class="cch-bar__v"><?= (int) $mx_l[1] ?></span>
              <span class="cch-bar__t"><i class="cch-bar__f<?= $mx_l[3] === 'q' ? ' cch-bar__f--q' : '' ?> bdh-grow" style="--w:<?= (int) $mx_l[1] ?>%;--i:<?= $mx_li ?>"></i></span>
              <span class="cch-bar__s"><?= e($mx_l[2]) ?></span>
            </p>
          <?php endforeach; ?>
        </div>
        <p class="cch-mx__gap">
          <b>The gap is not fraud.</b> It is demand that would have arrived anyway, counted twice because every platform claims the touch it saw. Knowing the size of the gap is what turns the budget conversation into arithmetic.
        </p>
        <ul class="cch-mx__how" role="list">
          <li><b>Geo holdout</b> · matched regions with the spend switched off, run long enough to read</li>
          <li><b>Matched-market test</b> · where geography will not hold still, a comparable market is used</li>
          <li><b>Media-mix read</b> · added once there is enough history to model, never before</li>
        </ul>
      </div>
    </div>

    <div class="cch-mx__layer" data-rv data-rv-d="60">
      <div class="cch-mx__lh">
        <h3 class="cch-mx__lt">Neither number is worth having until this exists</h3>
        <p class="cch-mx__ld">Consent mode, server-side tagging, conversion APIs and offline imports now carry what third-party cookies used to. We build the consented path first and treat anything that depends on cookies as temporary.</p>
      </div>
      <ol class="cch-mx__chain">
        <?php foreach ($mx_chain as $mx_ci => $mx_c): ?>
          <li class="cch-mx__link">
            <span class="cch-mx__ln"><?= str_pad((string) ($mx_ci + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <b><?= e($mx_c[0]) ?></b>
            <span><?= e($mx_c[1]) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="cch-mx__foot" data-rv data-rv-d="60">
      <p class="cch-note">Figures on this page are illustrative and show the shape of the decision, not a result. Every engagement sets its own baseline in the first weeks, and the holdout is designed before any spend moves.</p>
      <p class="cch-capls">
        <a class="cch-capl" href="#performance-marketing"><b><?= e($CAPS['performance-marketing']['n']) ?></b><?= e($CAPS['performance-marketing']['short']) ?><i aria-hidden="true">›</i></a>
        <a class="cch-capl" href="#omnichannel-marketing-strategy"><b><?= e($CAPS['omnichannel-marketing-strategy']['n']) ?></b><?= e($CAPS['omnichannel-marketing-strategy']['short']) ?><i aria-hidden="true">›</i></a>
      </p>
    </div>
  </div>
</section>
