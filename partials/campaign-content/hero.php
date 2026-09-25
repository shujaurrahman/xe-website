<?php /* DRAFT COPY — review before launch */
/* Hero — the always-on board. Text on paper, left. Right: an ink panel that bleeds to the viewport edge and
   holds one week of "Your brand" publishing across six surfaces, with an event feed and four readouts.
   The HTML is the finished state (every cell placed, every readout at its value); hero.js sweeps a day
   marker across the week, types the feed and ticks the readouts while the panel is on screen. Reduced
   motion keeps the static board. */
$hero_days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
/* [row label, kind, cells] — 'grid' rows carry one entry per lit day, 'run' rows are continuous */
$hero_rows = [
    ['Owned',     'grid', [0 => 'Guide', 2 => 'FAQ page', 4 => 'Cluster 02']],
    ['Social',    'grid', [0 => 'Reel', 1 => 'Carousel', 2 => 'Still', 3 => 'Reel', 4 => 'Thread']],
    ['Press',     'grid', [1 => 'Briefing', 3 => 'Byline']],
    ['Creators',  'grid', [2 => 'Creator 01', 5 => 'Creator 02']],
    ['Paid',      'run',  'Always-on · four concepts in test'],
    ['Replies',   'run',  'Moderation and escalation · agreed times'],
];
/* PLACEHOLDER: illustrative readouts, not client results — confirm the framing before launch */
$hero_reads = [
    ['sov',   'Share of voice',    '18',    '% of category'],
    ['saves', 'Saves & shares',    '2,140', 'this week'],
    ['cited', 'Named in answers',  '3 / 4', 'answer engines'],
    ['cpc',   'Cost per customer', '−18',   '% vs baseline'],
];
/* the board's event feed: one line at a time, typed by hero.js (illustrative) */
$hero_feed = [
    ['09:12', 'editorial', 'cluster 02 · "how to choose" published · 4 internal links added'],
    ['09:40', 'social',    'reel 07 scheduled · three cut-downs from one shoot'],
    ['10:05', 'press',     'briefing confirmed · embargo Thursday 14:00 IST'],
    ['10:22', 'creators',  'creator 01 draft approved · paid-partnership label set'],
    ['10:48', 'paid',      'concept C beats control · budget shifted, holdout untouched'],
    ['11:03', 'community', 'complaint escalated to support · tone guide applied'],
    ['11:19', 'newsroom',  'fact page updated · structured data re-published'],
    ['11:34', 'measure',   'weekly read · one definition per metric, no new numbers'],
];
$hero_caps_n = count($CAPS);
?>
<section class="cch-hero" id="top" aria-labelledby="hero-t">
  <span class="cch-hero__bg" aria-hidden="true"><span class="cch-hero__grid dots"></span></span>

  <div class="wrap cch-hero__in">
    <div class="cch-hero__text">
      <p class="lbl lbl--blue cch-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="cch-hero__h cch-hero__up" id="hero-t" style="--i:1"><span class="g">Campaigns that earn attention.</span> Systems that keep it.</h1>
      <p class="lead cch-hero__lead cch-hero__up" style="--i:2"><?= e($DISC['intro']) ?></p>

      <div class="cch-hero__act cch-hero__up" style="--i:3">
        <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'campaign-content')) ?>">Start a campaign brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#adapt">Open the adaptation engine <span class="i" aria-hidden="true">›</span></a>
      </div>

      <dl class="cch-hero__proof cch-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= $hero_caps_n ?></dd></div>
        <div><dt>Scope</dt><dd>Strategy → production → media</dd></div>
        <div><dt>The loop</dt><dd>Decide · Build · Publish · Reach</dd></div>
      </dl>

      <p class="cch-hero__loop cch-hero__up" style="--i:5">
        <span class="cch-k">Read the loop</span>
        <?php foreach ($CCH['stages'] as $hero_k => $hero_s): ?>
          <a class="cch-hero__lk" href="#loop"><b><?= e($hero_s['code']) ?></b><?= e($hero_s['name']) ?></a>
        <?php endforeach; ?>
      </p>
    </div>

    <div class="cch-hero__vis">
      <p class="bdh-sr">An illustrative week on the always-on board for Your brand. Six surfaces publish across seven days: owned pages on Monday, Wednesday and Friday; social on five days; a press briefing on Tuesday and a byline on Thursday; two creator posts; paid media running all week with four concepts in test; and moderation and escalation running all week against agreed response times. Four illustrative readouts report share of voice, saves and shares, how many answer engines name the brand, and cost per customer against baseline.</p>

      <div class="cch-hero__panel cch-on-ink" aria-hidden="true" data-bdh-in data-bdh-live>
        <div class="cch-hero__bar">
          <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
          <span class="cch-hero__title">always-on board <i>/</i> your brand</span>
          <span class="cch-hero__env">week 32 · in market</span>
          <span class="cch-ill">Illustrative</span>
          <span class="cch-live"><i class="bdh-pulse"></i>Live</span>
        </div>

        <div class="cch-hero__board">
          <p class="cch-hero__days">
            <span class="cch-hero__rk"></span>
            <?php foreach ($hero_days as $hero_di => $hero_d): ?>
              <span class="cch-hero__day" data-col="<?= $hero_di ?>"><?= e($hero_d) ?></span>
            <?php endforeach; ?>
          </p>

          <?php foreach ($hero_rows as $hero_ri => $hero_r): ?>
            <p class="cch-hero__row<?= $hero_r[1] === 'run' ? ' is-run' : '' ?>" style="--i:<?= $hero_ri ?>">
              <span class="cch-hero__rk"><?= e($hero_r[0]) ?></span>
              <?php if ($hero_r[1] === 'run'): ?>
                <span class="cch-hero__bar-run"><i></i><?= e($hero_r[2]) ?></span>
              <?php else: ?>
                <?php foreach ($hero_days as $hero_di => $hero_d): ?>
                  <?php if (isset($hero_r[2][$hero_di])): ?>
                    <span class="cch-hero__cell is-on" data-col="<?= $hero_di ?>"><?= e($hero_r[2][$hero_di]) ?></span>
                  <?php else: ?>
                    <span class="cch-hero__cell" data-col="<?= $hero_di ?>"></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </p>
          <?php endforeach; ?>

          <span class="cch-hero__mark" style="--col:2"></span>
        </div>

        <p class="cch-hero__feed" data-feed="<?= e(json_encode($hero_feed, JSON_UNESCAPED_UNICODE)) ?>">
          <span class="cch-hero__fp">›</span><span class="cch-hero__ft"><?= e($hero_feed[0][0]) ?></span><span class="cch-hero__fs"><?= e($hero_feed[0][1]) ?></span><span class="cch-hero__fx"><span class="cch-hero__fxt"><?= e($hero_feed[0][2]) ?></span><span class="bdh-caret"></span></span>
        </p>

        <dl class="cch-hero__reads">
          <?php foreach ($hero_reads as $hero_rd): ?>
            <div><dt><?= e($hero_rd[1]) ?></dt><dd><b data-k="<?= e($hero_rd[0]) ?>"><?= e($hero_rd[2]) ?></b> <?= e($hero_rd[3]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
