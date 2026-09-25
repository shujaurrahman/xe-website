<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Accessibility Statement body. COUNSEL: whether the Rights of Persons with Disabilities Act 2016 accessibility rules
   apply to a private company website; wording of the conformance claim ("partially conformant" until audited). */ ?>
<?php lgl_sec('standard'); ?>
  <p>We build to the <strong>Web Content Accessibility Guidelines (WCAG) 2.2, Level AA</strong>, published by the W3C. It is the standard referenced by India's Guidelines for Indian Government Websites (GIGW 3.0) and by the European standard EN 301 549.</p>
</section>

<?php lgl_sec('measures'); ?>
  <ul class="lgl-conf">
    <li><?= xt_icon('accessibility') ?><h3>Semantic structure</h3><p>One heading hierarchy per page, landmarks, labelled regions, a skip link, and tables with header cells.</p></li>
    <li><?= xt_icon('eye') ?><h3>Contrast and type</h3><p>Text colours drawn from a token set chosen for AA contrast; no text below 11px; layouts that reflow at 320px and 200% zoom.</p></li>
    <li><?= xt_icon('code') ?><h3>Keyboard and focus</h3><p>Every control is a real button or link, operable by keyboard, with a visible focus ring; tabs follow the ARIA pattern.</p></li>
    <li><?= xt_icon('bolt') ?><h3>Motion and JavaScript</h3><p>Reduced-motion preferences show finished states without loops; every page is complete and readable with JavaScript off.</p></li>
    <li><?= xt_icon('chat') ?><h3>Alternatives</h3><p>Images carry text alternatives; decorative interface mock-ups are hidden from screen readers and described in a sentence instead.</p></li>
    <li><?= xt_icon('mobile') ?><h3>Touch targets</h3><p>Tap targets are at least 44 by 44 pixels, above WCAG 2.2's 24-pixel minimum (2.5.8).</p></li>
  </ul>
</section>

<?php lgl_sec('status'); ?>
  <!-- PLACEHOLDER: conformance status — replace with the audit result before launch. -->
  <p>This website is <strong>partially conformant</strong> with WCAG 2.2 AA: we build and test to it, but some content may not yet fully conform, and it has not been independently audited.</p>
  <div class="lgl-tw mask-x" tabindex="0" role="region" aria-label="Testing status, scrolls sideways on small screens">
    <table class="lgl-tbl">
      <thead><tr><th scope="col">Check</th><th scope="col">How</th><th scope="col">Status</th></tr></thead>
      <tbody>
        <tr><th scope="row">Automated checks</th><td>Browser tooling on every page before release</td><td><span class="lgl-st lgl-st--ok">In place</span></td></tr>
        <tr><th scope="row">Keyboard-only use</th><td>Manual pass on every template</td><td><span class="lgl-st lgl-st--ok">In place</span></td></tr>
        <tr><th scope="row">Screen readers</th><td>NVDA, VoiceOver on a sample of pages</td><td><span class="lgl-st lgl-st--gap">Partial</span></td></tr>
        <tr><th scope="row">Independent audit</th><td>Third-party WCAG 2.2 AA audit</td><td><span class="lgl-st lgl-st--off">Planned</span></td></tr>
      </tbody>
    </table>
  </div>
</section>

<?php lgl_sec('limits'); ?>
  <p>These are the limitations we know about. We list them so you are not surprised by them.</p>
  <ul>
    <li><strong>Animated demonstrations.</strong> Some service pages show looping interface mock-ups. They pause off-screen and stop under reduced motion, but there is not yet a pause control on every one (WCAG 2.2.2).</li>
    <li><strong>Wide tables and diagrams.</strong> On phones some scroll sideways inside their own box rather than reflowing.</li>
    <li><strong>Documents we link to.</strong> Third-party pages and any PDFs we did not produce may not meet the standard.</li>
    <li><strong>Language.</strong> The site is in English only; we do not yet offer Hindi or Punjabi versions.</li>
  </ul>
</section>

<?php lgl_sec('report'); ?>
  <p>If anything on this site is hard to use, tell us. Fill in what you can — the button opens your email app with the report written. Without it, email <a href="<?= e(lgl_mail('Accessibility barrier report')) ?>"><?= e($SITE['company']['email']) ?></a>.</p>
  <form class="lgl-rep" data-lgl-rep aria-labelledby="lgl-rep-t">
    <h3 id="lgl-rep-t">Report a barrier</h3>
    <p>Nothing here is sent to our server; it only writes the email.</p>
    <div class="lgl-rep__g">
      <label>Page or address<input name="page" type="text" autocomplete="off" placeholder="e.g. /contact"></label>
      <label>Your assistive technology or browser<input name="at" type="text" autocomplete="off" placeholder="e.g. NVDA with Firefox"></label>
      <label class="lgl-rep__full">What happened<textarea name="what" placeholder="What you were trying to do, and what got in the way"></textarea></label>
      <label>Best way to reply<select name="reply"><option>Email</option><option>Phone call</option><option>No reply needed</option></select></label>
    </div>
    <div class="lgl-rep__out">
      <a class="btn btn--white" href="<?= e(lgl_mail('Accessibility barrier report')) ?>" data-lgl-rep-go>Write the email <span class="i" aria-hidden="true">›</span></a>
      <!-- PLACEHOLDER: response time — confirm before launch. -->
      <p class="lgl-rep__hint">We aim to reply within <span>[5] working days</span>.</p>
    </div>
  </form>
  <p>If you need content from this site in another format — large print, plain text, or read aloud on a call — ask and we will provide it.</p>
</section>

<?php lgl_sec('review'); ?>
  <p>This statement was prepared on 24 September 2026 from our own testing. We will review it at every major release and at least every six months.</p>
  <!-- PLACEHOLDER: review date — confirm before launch. -->
  <dl class="lgl-dl"><dt>Next review</dt><dd><span class="lgl-ph">March 2027</span></dd><dt>Method</dt><dd>Self-assessment; independent audit planned</dd></dl>
</section>
