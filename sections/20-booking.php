<!--
  BOOKING — the route to the real scheduler.

  This used to hold a front-end mock calendar: it invented its own availability
  (weekdays, 09:00–17:30), and picking a slot composed an email that reserved
  nothing. Once /book carried the real Cal.com scheduler, the site was offering a
  fake calendar here and a real one there, with two different sets of "open"
  times. So the invented calendar is gone and this section sends people to the
  real one.

  Kept exactly as it was: the section, its id="book" (every #book anchor on this
  page still lands here), the heading, and the discovery-call panel and its copy.
-->
<section class="band band--alt band--rules s20" id="book" aria-labelledby="s20-t">
  <div class="wrap">
    <div class="s20__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Book a call</p>
      <h2 class="h2" id="s20-t">Thirty minutes, and a straight answer.</h2>
    </div>

    <div class="s20__box" data-s20 data-rv data-rv-d="70">

      <!-- who -->
      <div class="s20__who">
        <span class="s20__mark" aria-hidden="true">
          <?= xe_svg('xe-mark') ?>
        </span>
        <p class="s20__org">Xterra Edze</p>
        <h3 class="h3 s20__title">Discovery call</h3>
        <p class="s20__blurb">Tell us what you're building and we'll tell you straight whether we're
          the right team for it. No deck, no discovery theatre.</p>
        <ul class="s20__meta">
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.2" stroke="currentColor" stroke-width="1.3"/><path d="M8 4.6V8l2.4 1.4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            30 min
          </li>
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><rect x="1.6" y="3.6" width="9" height="8.8" rx="1.6" stroke="currentColor" stroke-width="1.3"/><path d="m10.6 7.4 3.8-2.2v5.6l-3.8-2.2z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
            Google Meet
          </li>
          <li>
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.2" stroke="currentColor" stroke-width="1.3"/><path d="M1.9 8h12.2M8 1.8c1.7 1.8 2.6 4 2.6 6.2S9.7 12.4 8 14.2C6.3 12.4 5.4 10.2 5.4 8S6.3 3.6 8 1.8Z" stroke="currentColor" stroke-width="1.3"/></svg>
            <span data-s20-tz>Your local time</span>
          </li>
        </ul>
        <p class="s20__note">We reply to every brief within one working day.</p>
      </div>

      <!-- the route to the real calendar -->
      <div class="s20__route">
        <p class="s20__rk">Live calendar</p>
        <p class="s20__rt">Pick a time on our real calendar. It shows the times that are
          actually open, in your own time zone.</p>

        <ol class="s20__steps">
          <li><span class="s20__sn" aria-hidden="true">01</span><span>Choose a day and a time that suits you.</span></li>
          <li><span class="s20__sn" aria-hidden="true">02</span><span>Add a line about what you're building.</span></li>
          <li><span class="s20__sn" aria-hidden="true">03</span><span>The invite arrives in your inbox.</span></li>
        </ol>

        <div class="s20__acts">
          <a class="btn btn--ink" href="<?= xe_url('book.php') ?>">Pick a time <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="<?= xe_url('contact.php') ?>">Or send a written brief <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

    </div>
  </div>
</section>
