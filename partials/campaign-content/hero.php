<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Hero: one idea at the top, the same key visual re-cut for five channels beneath it. */
$cch_img = xe_url('assets/imgs/campaign-content/crowd.jpg');
$cch_frames = [   // [modifier, ratio, channel, object-position, headline]
    ['r169', '16:9', 'YouTube · 6s bumper', '50% 38%', 'Win the first ten minutes.'],
    ['r45',  '4:5',  'Meta · feed',         '50% 60%', 'Win the first ten minutes.'],
    ['r916', '9:16', 'Reels · Shorts',      '40% 50%', 'The first ten minutes.'],
    ['r11',  '1:1',  'LinkedIn · feed',     '60% 30%', 'Ten minutes.'],
    ['r31',  '3:1',  'Out of home · 48-sheet', '50% 70%', 'Win the first ten minutes.'],
];
?>
<section class="band cch-hero" id="top" aria-labelledby="top-t">
  <div class="wrap cch-hero__g">
    <div class="cch-hero__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="d1" id="top-t"><span class="g">One idea.</span> Every frame it needs to live in.</h1>
      <p class="lead cch-hero__lead"><?= e($DISC['intro']) ?> We carry a single idea from insight to key visual, into every channel's format, onto a flighting plan and back as a measured result.</p>
      <div class="cch-hero__cta">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, 'campaign-content')) ?>">Start a campaign brief <span class="i"></span></a>
        <a class="btn btn--out btn--lg" href="#board">Open the campaign board <span class="i"></span></a>
      </div>
      <dl class="cch-hero__meta">
        <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
        <div><dt>Media</dt><dd>Paid · earned · shared · owned</dd></div>
        <div><dt>Measured</dt><dd>Incrementality</dd></div>
      </dl>
    </div>

    <div class="cch-hero__art" aria-hidden="true">
      <div class="cch-hero__idea bdh-up" data-bdh-in>
        <span class="bdh-ro">Idea · v1 · approved</span>
        <strong>Win the first ten minutes.</strong>
        <span class="bdh-ro cch-hero__ins">Insight — people judge a whole day by how it starts.</span>
      </div>
      <div class="cch-hero__fan" data-bdh-stagger data-bdh-in>
        <?php foreach ($cch_frames as $cch_i => $cch_f): ?>
        <figure class="cch-frame cch-frame--<?= $cch_f[0] ?> cch-hero__f<?= $cch_i + 1 ?> bdh-up">
          <img src="<?= e($cch_img) ?>" alt="" width="800" height="1200" loading="eager" decoding="async" style="object-position:<?= $cch_f[3] ?>">
          <figcaption class="cch-frame__hl"><?= e($cch_f[4]) ?></figcaption>
          <span class="cch-frame__tag"><?= e($cch_f[1]) ?> · <?= e($cch_f[2]) ?></span>
        </figure>
        <?php endforeach; ?>
      </div>
      <div class="cch-hero__bar bdh-ro">
        <span><i class="cch-dot"></i>1 idea → 42 executions</span>
        <span>6 channels</span>
        <span class="cch-hero__ok">Brand check 42/42</span>
      </div>
    </div>
    <p class="bdh-sr">Illustration: a single campaign idea, “Win the first ten minutes”, shown above the same key visual re-cut for a 16:9 video bumper, a 4:5 feed post, a 9:16 vertical story, a 1:1 post and a 3:1 billboard.</p>
  </div>
</section>
