<?php /* DRAFT COPY — review before launch */
/* Hero — the promise, and beside it the record every generated asset carries before a person approves it.
   The record is a decorative mock (aria-hidden) with a .bdh-sr sentence. hero.js only pulses the pending row. */
$aih_hero_meta = [
    ['Capabilities', (string) count($DISC['caps'])],
    ['Models',       'Chosen per task, by eval'],
    ['Every output', 'Approved by a named person'],
];
?>
<section class="band aih-hero" id="hero" aria-labelledby="hero-t">
  <div class="wrap aih-hero__grid">
    <div class="aih-hero__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · AI Design</p>
      <h1 class="d1" id="hero-t"><span class="g">Experiences that could not exist before AI.</span> Designed to be trusted.</h1>
      <p class="lead"><?= e($DISC['intro']) ?></p>
      <div class="aih-hero__cta">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, 'ai-design')) ?>">Start an AI brief <span class="i" aria-hidden="true"></span></a>
        <a class="btn btn--out btn--lg" href="#studio">Watch a request run <span class="i" aria-hidden="true"></span></a>
      </div>
      <dl class="aih-hero__meta">
        <?php foreach ($aih_hero_meta as $aih_m): ?>
          <div><dt><?= e($aih_m[0]) ?></dt><dd><?= e($aih_m[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

    <div class="aih-hero__vis" data-bdh-live>
      <p class="bdh-sr">Illustration: a studio photograph behind a generation record for one image. The record lists the request, the brand-tuned model that produced it, a brand score of 0.93 against a 0.85 threshold, cleared rights, no personal data detected, and an approval step still waiting for a named creative director.</p>
      <div aria-hidden="true">
        <figure class="aih-hero__photo">
          <img src="<?= e(xe_url('assets/imgs/ai-design/hub/hero-studio.jpg')) ?>" width="640" height="800" alt="" fetchpriority="high">
          <span class="aih-hero__tag"><span class="bdh-pulse"></span>Request R-0412 · 4 models</span>
        </figure>
        <div class="aih-hero__card">
          <div class="aih-hero__card-h">
            <span>Generation record</span><span class="aih-hero__lane">Image lane</span>
          </div>
          <div class="aih-hero__out">
            <img src="<?= e(xe_url('assets/imgs/ai-design/hub/studio-vase.jpg')) ?>" width="600" height="450" alt="" loading="lazy">
            <div>
              <p class="aih-hero__brief">“Spring launch hero, still life, warm clay, four markets.”</p>
              <p class="aih-hero__mdl">brand-tuned image model · v4</p>
            </div>
          </div>
          <dl class="aih-rec">
            <dt>Brand score</dt><dd><span class="ok">0.93</span> · floor 0.85</dd>
            <dt>Rights</dt><dd>Inputs cleared · credentials attached</dd>
            <dt>Personal data</dt><dd>None detected</dd>
            <dt>Approver</dt><dd class="aih-hero__wait">Creative director · waiting</dd>
          </dl>
          <div class="aih-hero__act"><span class="aih-hero__btn">Request changes</span><span class="aih-hero__btn aih-hero__btn--go">Approve</span></div>
        </div>
      </div>
    </div>
  </div>
</section>
