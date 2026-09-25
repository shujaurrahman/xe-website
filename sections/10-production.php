<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 10 — global content production, laid out as two contact-sheet strips. Every tile
   keeps its native aspect ratio (fixed row height, width from the ratio), so nothing
   is cropped mid-word, and each carries a mono slate: index · format · ratio.
   The strip is currently all stills (credited placeholder photos, see sections/CREDITS.md); the video branch below stays for real footage. */
$s10_rows = [
  ['dir' => 'l', 'tiles' => [
    ['img' => 'assets/imgs/brand/hub/ai-os/social-b.jpg', 'w' => 900, 'h' => 596, 'fmt' => 'Social · Still', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/capabilities/architecture.jpg', 'w' => 1200, 'h' => 800, 'fmt' => 'Brand · System', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/global/crowd.jpg', 'w' => 800, 'h' => 1200, 'fmt' => 'Campaign · Poster', 'ar' => '2:3'],
    ['img' => 'assets/imgs/brand/hub/touchpoints/app.jpg', 'w' => 1200, 'h' => 1011, 'fmt' => 'Product UI', 'ar' => '6:5', 'ui' => true],
    ['img' => 'assets/imgs/brand/hub/ai-os/retail-shelf.jpg', 'w' => 900, 'h' => 600, 'fmt' => 'Retail · Shelf', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/touchpoints/cup.jpg', 'w' => 1200, 'h' => 800, 'fmt' => 'Product · Still', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/capabilities/growth.jpg', 'w' => 1200, 'h' => 802, 'fmt' => 'Brand · Web', 'ar' => '3:2'],
  ]],
  ['dir' => 'r', 'tiles' => [
    ['img' => 'assets/imgs/brand/hub/touchpoints/stationery.jpg', 'w' => 1200, 'h' => 800, 'fmt' => 'Print · Stationery', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/industries/retail.jpg', 'w' => 800, 'h' => 1200, 'fmt' => 'Retail · Poster', 'ar' => '2:3'],
    ['img' => 'assets/imgs/brand/hub/ai-os/gen-3.jpg', 'w' => 900, 'h' => 601, 'fmt' => 'Product · Still', 'ar' => '3:2', 'ui' => true],
    ['img' => 'assets/imgs/brand/hub/touchpoints/tote.jpg', 'w' => 1200, 'h' => 800, 'fmt' => 'Merch · Still', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/ai-os/gen-4.jpg', 'w' => 900, 'h' => 600, 'fmt' => 'Lifestyle · Still', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/touchpoints/wayfinding.jpg', 'w' => 1600, 'h' => 1066, 'fmt' => 'Environment · Signage', 'ar' => '3:2'],
    ['img' => 'assets/imgs/brand/hub/industries/technology.jpg', 'w' => 1200, 'h' => 900, 'fmt' => 'B2B · Web', 'ar' => '4:3', 'ui' => true],
  ]],
];
$s10_i = 0;
?>
<section class="band band--alt band--rules bdh s10" id="production" aria-labelledby="s10-t">
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

  <!-- PLACEHOLDER: credited Unsplash placeholder photos (sections/CREDITS.md). Replace with Xterra Edze production stills before launch. -->
  <p class="bdh-sr">Two moving strips of campaign work in many formats: social stills, a campaign poster, packaging and product stills, print, merchandise, signage and product screens.</p>
  <div class="s10__rows" aria-hidden="true">
<?php foreach ($s10_rows as $s10_r): ?>
    <div class="s10__row mask-x" data-s10-row data-dir="<?= $s10_r['dir'] ?>">
      <div class="s10__track" data-s10-track>
<?php foreach ($s10_r['tiles'] as $s10_t): $s10_i++; ?>
        <figure class="s10__c<?= isset($s10_t['vid']) ? ' s10__c--v' : '' ?><?= !empty($s10_t['ui']) ? ' s10__c--ui' : '' ?>" style="--ar:<?= $s10_t['w'] ?>/<?= $s10_t['h'] ?>">
          <div class="s10__frame">
<?php if (!empty($s10_t['ui'])): ?>
            <span class="s10__chrome"><i></i><i></i><i></i><span>Your platform</span></span>
            <span class="s10__screen">
<?php endif; ?>
<?php if (isset($s10_t['vid'])): ?>
            <video src="<?= $s10_t['vid'] ?>" poster="<?= $s10_t['poster'] ?>" width="<?= $s10_t['w'] ?>" height="<?= $s10_t['h'] ?>" muted loop playsinline preload="none" data-s10-v></video>
            <span class="s10__rec"><i></i>Video</span>
<?php else: ?>
            <img src="<?= $s10_t['img'] ?>" alt="" width="<?= $s10_t['w'] ?>" height="<?= $s10_t['h'] ?>" loading="lazy" decoding="async">
<?php endif; ?>
<?php if (!empty($s10_t['ui'])): ?>
            </span>
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
