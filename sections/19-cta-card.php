<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 19 — the hinge between the brief builder above (25, "Continue to contact") and the booking
   widget below (20, #book). A compact solid-blue strip, not a third full-height CTA: it sits
   close under 25 and hands the reader down to 20. Solid --blue field; the only texture is a
   token-coloured SVG dot matrix faded out with a mask (no gradient fill anywhere). */
?>
<section class="band band--tight s19" id="cta" aria-labelledby="s19-t">
  <div class="wrap">
    <div class="s19__card" data-rv data-rv-d="40">
      <svg class="s19__tex" aria-hidden="true" focusable="false">
        <defs>
          <pattern id="s19-dots" width="14" height="14" patternUnits="userSpaceOnUse">
            <circle cx="2" cy="2" r="1.2"/>
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#s19-dots)"/>
      </svg>

      <div class="s19__say">
        <h2 class="h2 s19__h" id="s19-t">What are we building?</h2>
        <p class="s19__sub">Brand, product, campaign, or the intelligence underneath it.</p>
      </div>

      <div class="s19__act">
        <a class="btn btn--white btn--lg s19__go" href="#book">Pick a time to talk <span class="i" aria-hidden="true">›</span></a>
        <!-- PLACEHOLDER: confirm the one-working-day response time before launch -->
        <p class="s19__meta">
          <span>Reply within one working day</span>
          <i aria-hidden="true">·</i>
          <span>New Delhi <i aria-hidden="true">·</i> Ludhiana</span>
        </p>
      </div>
    </div>
  </div>
</section>
