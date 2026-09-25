<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--ink s22" id="cta-final" aria-labelledby="s22-t">
  <span class="s22__dots dots-ink" aria-hidden="true"></span>
  <span class="s22__glow" aria-hidden="true"></span>
  <span class="s22__mark" aria-hidden="true"><?= xe_svg('xe-mark') ?></span>

  <svg class="s22__orbits" viewBox="0 0 520 520" fill="none" aria-hidden="true" preserveAspectRatio="xMidYMid meet">
    <g class="s22__rings">
      <circle cx="520" cy="260" r="130"/>
      <circle cx="520" cy="260" r="202"/>
      <circle cx="520" cy="260" r="278"/>
      <circle cx="520" cy="260" r="360"/>
    </g>
    <g class="s22__o s22__o--1"><circle cx="318" cy="260" r="3"/></g>
    <g class="s22__o s22__o--2"><circle cx="160" cy="260" r="2.2"/></g>
  </svg>

  <div class="wrap s22__wrap">
    <div class="s22__top" data-rv>
      <div class="s22__say">
        <h2 class="h2 s22__h" id="s22-t">Let’s build what happens next.</h2>
        <p class="lead s22__sub">Tell us what you’re building. We’ll answer straight.</p>
      </div>
      <a class="btn btn--white btn--lg s22__go" href="#book">
        Book a discovery call<span class="i" aria-hidden="true">›</span>
      </a>
    </div>

    <div class="s22__links" data-rv data-rv-d="90">
      <a href="<?= xe_url('work.php') ?>"><span>See the work</span><i aria-hidden="true">›</i></a>
      <a href="#disciplines"><span>Explore our services</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('approach.php') ?>"><span>Read our approach</span><i aria-hidden="true">›</i></a>
      <!-- PLACEHOLDER: no news or ideas page exists yet — link this when one does. Until then it is shown, not linked. -->
      <a class="s22__soon" aria-disabled="true"><span>Latest ideas &amp; news</span> <small class="s22__tag">Soon</small></a>
      <a href="#operation"><span>About Xterra Edze</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('careers.php') ?>"><span>Join the team</span><i aria-hidden="true">›</i></a>
    </div>
  </div>
</section>
