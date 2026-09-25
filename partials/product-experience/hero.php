<?php /* DRAFT COPY — review before launch */
/* Hero — "the fidelity lens": one product screen drawn twice, as a wireframe and as the shipped interface,
   with a seam between them. The seam sweeps only while on screen (.is-live); without JS or with reduced
   motion it rests at the midpoint, which is the finished state. */
$pxh_hero_plans = [['Starter', '1 workspace', 0], ['Team', '10 workspaces', 1], ['Scale', 'Unlimited', 0]];
?>
<section class="band pxh-hero" id="top" aria-labelledby="pxh-hero-t">
  <div class="dots" aria-hidden="true"></div>
  <div class="wrap pxh-hero__g">
    <div class="pxh-hero__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="d1" id="pxh-hero-t"><span class="g">Every screen is a claim about people.</span> We test it before you build it.</h1>
      <p class="lead"><?= e($DISC['intro']) ?> Research, strategy, interaction design and front-end engineering in one loop, so what gets built is what people can actually use.</p>
      <div class="pxh-hero__cta">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, 'product-experience')) ?>">Start with one question <span class="i" aria-hidden="true"></span></a>
        <a class="btn btn--out btn--lg" href="#signal">Follow an idea to release <span class="i" aria-hidden="true"></span></a>
      </div>
      <dl class="pxh-hero__meta">
        <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
        <div><dt>Loop</dt><dd>Signal → shipped</dd></div>
        <div><dt>Default bar</dt><dd>WCAG 2.2 AA</dd></div>
      </dl>
    </div>

    <div class="pxh-hero__vis" data-bdh-live>
      <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/product-experience/CREDITS.md) — replace with own research photography before launch -->
      <figure class="bdh-img bdh-img--r45 bdh-img--xl pxh-hero__photo" aria-hidden="true"><img src="<?= e($BASE . 'assets/imgs/product-experience/hero-research-wall.jpg') ?>" alt="" width="1200" height="1500" fetchpriority="high" decoding="async"></figure>
      <div class="pxh-lens" aria-hidden="true">
        <div class="pxh-lens__bar"><span class="pxh-lens__dot"></span>Your platform · Change plan · v3</div>
        <div class="pxh-lens__stage">
          <?php foreach (['wire', 'ui'] as $pxh_layer): ?>
          <div class="pxh-lens__l pxh-lens__l--<?= $pxh_layer ?>">
            <div class="pxh-lens__h"><span class="t">Choose the plan that fits</span><span class="s">Change any time. No call needed.</span></div>
            <div class="pxh-lens__plans">
              <?php foreach ($pxh_hero_plans as $pxh_p): ?>
              <div class="pxh-lens__plan<?= $pxh_p[2] ? ' is-cur' : '' ?>">
                <span class="n"><?= e($pxh_p[0]) ?></span><span class="m"><?= e($pxh_p[1]) ?></span>
                <span class="ln"></span><span class="ln ln--s"></span>
                <span class="b"><?= $pxh_p[2] ? 'Current plan' : 'Switch' ?></span>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="pxh-lens__row"><span class="ln"></span><span class="cta">Review change</span></div>
          </div>
          <?php endforeach; ?>
          <div class="pxh-lens__seam"><span>Wireframe</span><span>Shipped</span></div>
        </div>
      </div>
      <div class="pxh-hero__chip pxh-hero__chip--a" aria-hidden="true">
        <span class="pxh-mono">Signal</span><b>“Called support just to downgrade.”</b><span class="pxh-mono">Interview 07 · tagged</span>
      </div>
      <div class="pxh-hero__chip pxh-hero__chip--b" aria-hidden="true">
        <span class="pxh-mono">Usability · task 3</span>
        <span class="pxh-hero__ticks"><i class="ok"></i><i class="ok"></i><i class="ok"></i><i class="ok"></i><i class="ok"></i><i></i></span>
        <span class="pxh-mono">5 of 6 completed unaided</span>
      </div>
      <p class="bdh-sr">Illustration: a plan-change screen for “Your platform”, drawn half as a grey wireframe and half as the finished interface, with an interview quote that started the idea and a usability result of five of six participants completing the task unaided.</p>
    </div>
  </div>
</section>
