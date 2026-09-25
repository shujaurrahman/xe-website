<?php
/**
 * The closing band, reused at the foot of every inner page.
 *
 * The button used to read "Book a discovery call" and go to the contact form. Now that
 * /book carries the real scheduler, it goes there instead — except on /book itself,
 * where it would self-link, so that page gets the written-brief route as its primary.
 */
$cta_book = ($page['key'] ?? '') !== 'book';
?>
<section class="band band--ink s22" aria-labelledby="cta-t">
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
        <h2 class="h2 s22__h" id="cta-t">Let’s build what happens next.</h2>
        <p class="lead s22__sub">Tell us what you’re building. We’ll answer straight.</p>
      </div>
      <a class="btn btn--white btn--lg s22__go" href="<?= xe_url($cta_book ? 'book.php' : 'contact.php') ?>">
        <?= $cta_book ? 'Book a discovery call' : 'Send a written brief' ?><span class="i" aria-hidden="true">›</span>
      </a>
    </div>

    <div class="s22__links" data-rv data-rv-d="90">
      <?php /* the route the button is not taking, so both are always one click away */ ?>
      <?php if ($cta_book): ?>
        <a href="<?= xe_url('contact.php') ?>"><span>Send a written brief</span><i aria-hidden="true">›</i></a>
      <?php endif; ?>
      <a href="<?= xe_url('work.php') ?>"><span>See the work</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('services/') ?>"><span>Explore our services</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('approach.php') ?>"><span>Read our approach</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('industries.php') ?>"><span>Industries we serve</span><i aria-hidden="true">›</i></a>
      <a href="<?= xe_url('careers.php') ?>"><span>Join the team</span><i aria-hidden="true">›</i></a>
      <a href="mailto:<?= e($SITE['company']['email']) ?>"><span>Email us</span><i aria-hidden="true">›</i></a>
    </div>
  </div>
</section>
