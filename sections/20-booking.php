<!--
  BOOKING — this is a front-end request form, not a live calendar. Selecting a slot and
  submitting composes an email to hello@xterraedze.com; nothing is reserved. Wire the
  three marked hooks in 20-booking.js to the real calendar (Cal.com / Google) before launch.
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

      <!-- when -->
      <div class="s20__cal">
        <div class="s20__calhead">
          <p class="s20__month" data-s20-month>—</p>
          <div class="s20__navs">
            <button class="s20__nav" type="button" data-s20-prevm aria-label="Previous month">
              <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button class="s20__nav" type="button" data-s20-nextm aria-label="Next month">
              <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </div>
        <div class="s20__dow" aria-hidden="true">
          <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
        </div>
        <div class="s20__days" role="grid" aria-label="Choose a day" data-s20-days></div>
      </div>

      <!-- slots / confirm -->
      <div class="s20__slots">
        <div class="s20__slotshead">
          <p class="s20__day" data-s20-daylabel>Pick a day</p>
          <div class="s20__fmt" role="radiogroup" aria-label="Time format">
            <button class="s20__fmtb is-on" type="button" role="radio" aria-checked="true" data-s20-fmt="12">12h</button>
            <button class="s20__fmtb" type="button" role="radio" aria-checked="false" data-s20-fmt="24">24h</button>
          </div>
        </div>

        <div class="s20__times" data-s20-times></div>

        <form class="s20__form" data-s20-form hidden novalidate>
          <p class="s20__picked" data-s20-picked></p>
          <label class="s20__field">
            <span>Name</span>
            <input type="text" name="name" autocomplete="name" data-book-first required>
          </label>
          <label class="s20__field">
            <span>Work email</span>
            <input type="email" name="email" autocomplete="email" required>
          </label>
          <label class="s20__field">
            <span>Company</span>
            <input type="text" name="company" autocomplete="organization">
          </label>
          <label class="s20__field">
            <span>What are you building?</span>
            <textarea id="book-brief" name="brief" rows="3" required></textarea>
          </label>
          <p class="s20__err" data-s20-err hidden></p>
          <div class="s20__actions">
            <button class="s20__back" type="button" data-s20-back>Back</button>
            <button class="btn btn--ink" type="submit">Request this time <span class="i" aria-hidden="true">›</span></button>
          </div>
        </form>

        <div class="s20__done" data-s20-done hidden>
          <span class="s20__tick" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
          </span>
          <p class="s20__donet">Request sent</p>
          <p class="s20__donep" data-s20-donep></p>
          <p class="s20__donen">Nothing is reserved yet — we'll confirm by email within one working day.</p>
        </div>

        <p class="sr" aria-live="polite" data-s20-live></p>
      </div>

    </div>
  </div>
</section>
