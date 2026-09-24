<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 10 — global content production, laid out as two contact-sheet strips. Every tile
   keeps its native aspect ratio (fixed row height, width from the ratio), so nothing
   is cropped mid-word, and each carries a mono slate: index · format · ratio.
   Videos ship with a poster frame and load only while the section is on screen. */
$s10_rows = [
  ['dir' => 'l', 'tiles' => [
    ['img' => 'assets/imgs/80af393a_creative-video-poster.webp', 'w' => 504, 'h' => 900, 'fmt' => 'UGC · Reel', 'ar' => '9:16'],
    ['vid' => 'assets/animation/1d5d8449_de-serum-ugc.mp4', 'poster' => 'assets/animation/1d5d8449_de-serum-ugc-poster.jpg', 'w' => 360, 'h' => 640, 'fmt' => 'UGC · Video', 'ar' => '9:16'],
    ['img' => 'assets/imgs/112a8859_fedab9950685d079.jpg', 'w' => 332, 'h' => 662, 'fmt' => 'Film · Poster', 'ar' => '1:2'],
    ['img' => 'assets/imgs/bd83f418_4pkRC1qbVbaQaDhl6hxwYbnR3M.png', 'w' => 1575, 'h' => 1800, 'fmt' => 'Product UI', 'ar' => '7:8', 'ui' => true],
    ['img' => 'assets/imgs/0713d126_962143a38444fcca.jpg', 'w' => 1023, 'h' => 662, 'fmt' => 'Retail · Web', 'ar' => '3:2'],
    ['img' => 'assets/imgs/ce74ecca_L8Dz2251src41HfKaTB8ynwCI.jpg', 'w' => 360, 'h' => 450, 'fmt' => 'Product · Still', 'ar' => '4:5'],
    ['img' => 'assets/imgs/a8057f35_rKcI0supToKMKRlcKeai8HLis.jpg', 'w' => 2048, 'h' => 1280, 'fmt' => 'Brand · Web', 'ar' => '16:10'],
  ]],
  ['dir' => 'r', 'tiles' => [
    ['img' => 'assets/imgs/eb2cc44e_JPAhMTAPSO3541ukhwlZ5mA68U.png', 'w' => 1575, 'h' => 1800, 'fmt' => 'Product UI', 'ar' => '7:8', 'ui' => true],
    ['vid' => 'assets/animation/2152213c_I5EermuEJ3ajQbEhyzQGZjChJ7k.mp4', 'poster' => 'assets/animation/2152213c_I5EermuEJ3ajQbEhyzQGZjChJ7k-poster.jpg', 'w' => 1200, 'h' => 1080, 'fmt' => 'Product UI · Video', 'ar' => '10:9', 'ui' => true],
    ['img' => 'assets/imgs/329577d8_6lgwc6zBcLzD1v0rv9ciG2YO6ZY.png', 'w' => 1575, 'h' => 1800, 'fmt' => 'Product UI', 'ar' => '7:8', 'ui' => true],
    ['img' => 'assets/imgs/32873c56_0K4ULhcovO1vIB5S1Q26riqxkhE.png', 'w' => 1024, 'h' => 683, 'fmt' => 'Lifestyle · Still', 'ar' => '3:2'],
    ['img' => 'assets/imgs/7550c3de_V4nZoa0B1ZgOTXlpCU65Drx7Ws.png', 'w' => 1575, 'h' => 1800, 'fmt' => 'Product UI', 'ar' => '7:8', 'ui' => true],
    ['img' => 'assets/imgs/3a76af1b_07df48dc565f922c.jpg', 'w' => 1036, 'h' => 662, 'fmt' => 'B2B · Web', 'ar' => '3:2'],
    ['img' => 'assets/imgs/bd8b7367_vQVIWBVwvM8wzpTvk0VJ1mKJto.webp', 'w' => 1600, 'h' => 1067, 'fmt' => 'Product · Still', 'ar' => '3:2'],
  ]],
];
$s10_i = 0;
?>
<section class="band band--rules bdh s10" id="production" aria-labelledby="s10-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row s10__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Global content production</p>
        <h2 class="h2" id="s10-t"><span class="g">Original work,</span> at scale</h2>
      </div>
      <div>
        <p class="lead s10__lead">Through a global network of creators — one campaign system, shot and
          cut for every market it lands in.</p>
        <button class="s10__pause" type="button" data-s10-pause aria-pressed="false" hidden>
          <span class="s10__pi" aria-hidden="true">
            <svg class="s10__ico-pause" viewBox="0 0 16 16" fill="none"><path d="M5.5 3.5v9M10.5 3.5v9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            <svg class="s10__ico-play" viewBox="0 0 16 16" fill="none"><path d="M5 3.2v9.6L12.6 8z" fill="currentColor"/></svg>
          </span>
          <span class="s10__pl">Pause motion</span>
        </button>
      </div>
    </div>
  </div>

  <!-- PLACEHOLDER: reference imagery. Replace with Xterra Edze production stills before launch. -->
  <!-- PLACEHOLDER: owner decision before launch — these reference frames show third-party names and marks
       (e.g. "MILANO", "SUPERMOON", "galway", "GIGAFINANCE GROUP", "BLUEPRINT NO. 7"). Shown in full
       colour and uncropped since the 2026-09 polish; replace or license them before launch. -->
  <p class="bdh-sr">Two moving strips of campaign work in many formats: vertical social reels and UGC video, a film poster, product stills, product UI frames and web hero layouts.</p>
  <div class="s10__rows" aria-hidden="true">
<?php foreach ($s10_rows as $s10_r): ?>
    <div class="s10__row mask-x" data-s10-row data-dir="<?= $s10_r['dir'] ?>">
      <div class="s10__track" data-s10-track>
<?php foreach ($s10_r['tiles'] as $s10_t): $s10_i++; ?>
        <figure class="s10__c<?= isset($s10_t['vid']) ? ' s10__c--v' : '' ?><?= !empty($s10_t['ui']) ? ' s10__c--ui' : '' ?>" style="--ar:<?= $s10_t['w'] ?>/<?= $s10_t['h'] ?>">
          <div class="s10__frame">
<?php if (isset($s10_t['vid'])): ?>
            <video src="<?= $s10_t['vid'] ?>" poster="<?= $s10_t['poster'] ?>" width="<?= $s10_t['w'] ?>" height="<?= $s10_t['h'] ?>" muted loop playsinline preload="none" data-s10-v></video>
            <span class="s10__rec"><i></i>Video</span>
<?php else: ?>
            <img src="<?= $s10_t['img'] ?>" alt="" width="<?= $s10_t['w'] ?>" height="<?= $s10_t['h'] ?>" loading="lazy" decoding="async">
<?php endif; ?>
          </div>
          <figcaption class="s10__slate"><b><?= sprintf('%02d', $s10_i) ?></b><span><?= $s10_t['fmt'] ?></span><em><?= $s10_t['ar'] ?></em></figcaption>
        </figure>
<?php endforeach; ?>
      </div>
    </div>
<?php endforeach; ?>
  </div>
</section>
