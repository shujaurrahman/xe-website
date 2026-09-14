<?php /* DRAFT COPY — review before launch */
/* Hero — the brand system, live. Text left; right, an unbranded place with an AI brand-check
   layer over it. The HTML is the finished state (all checks passed); hero.js animates it. */
$hero_checks = ['Colour tokens', 'Clearspace', 'Type scale', 'Contrast AA', 'Tone of voice'];
?>
<section class="bdh-hero" id="top" aria-labelledby="hero-t" data-bdh-live>
  <div class="bdh-hero__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="bdh-hero__grain"></span>
  </div>

  <div class="wrap bdh-hero__in">
    <div class="bdh-hero__text">
      <p class="lbl lbl--blue bdh-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($BRAND['n']) ?> · <?= e($BRAND['name']) ?></p>
      <h1 class="bdh-hero__h bdh-hero__up" id="hero-t" style="--i:1"><span class="g">Brands that hold together</span> at enterprise scale.</h1>
      <p class="lead bdh-hero__lead bdh-hero__up" style="--i:2"><?= e($BRAND['intro']) ?></p>
      <div class="bdh-hero__act bdh-hero__up" style="--i:3">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Start a brand brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#journey">See how a programme runs <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="bdh-hero__proof bdh-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= count($BRAND['caps']) ?></dd></div>
        <div><dt>Stages</dt><dd>Inception → rollout</dd></div>
        <div><dt>Operations</dt><dd>AI-native</dd></div>
      </dl>
    </div>

    <div class="bdh-hero__vis" aria-hidden="true" data-bdh-in>
      <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
      <figure class="bdh-img bdh-img--xl bdh-hero__photo">
        <img src="<?= xe_url('assets/imgs/brand/hub/hero/atrium.jpg') ?>" alt="" width="1080" height="1920" fetchpriority="high" decoding="async">
      </figure>

      <span class="bdh-hero__frame"><i></i><i></i><i></i><i></i></span>
      <span class="bdh-hero__tag">Surface · wayfinding · detected</span>
      <span class="bdh-hero__pill"><i class="bdh-pulse"></i>Brand system v3.2 · live</span>
      <span class="bdh-hero__tokens"><i></i><i></i><i></i>tokens · locked</span>

      <div class="bdh-hero__check">
        <p class="bdh-hero__ch"><span>Brand check</span><span class="bdh-hero__run">Agent · live</span></p>
        <ul>
          <?php foreach ($hero_checks as $hero_c): ?>
            <li class="is-ok"><span><?= e($hero_c) ?></span><b></b></li>
          <?php endforeach; ?>
        </ul>
        <p class="bdh-hero__cf"><?= count($hero_checks) ?> of <?= count($hero_checks) ?> pass · approved by Brand reviewer</p>
      </div>

      <div class="bdh-hero__variant">
        <div class="bdh-hero__asset">
          <figure class="bdh-img bdh-hero__vimg">
            <img src="<?= xe_url('assets/imgs/brand/hub/hero/phone-hand.jpg') ?>" alt="" width="1200" height="1011" loading="lazy" decoding="async">
          </figure>
          <div class="bdh-hero__vbody">
            <b class="bdh-hero__vbrand">Your brand</b>
            <i></i><i class="is-s"></i>
            <span class="bdh-hero__vbtn">Explore</span>
          </div>
        </div>
        <div class="bdh-hero__vmeta">
          <span class="bdh-hero__vlbl">Variant · Market <b>03</b> · 4:5</span>
          <span class="bdh-hero__vbar"><i></i></span>
        </div>
      </div>
    </div>
  </div>
</section>
