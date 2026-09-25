<?php /* DRAFT COPY — review before launch */
/**
 * Book · scheduler — the real Cal.com booker, framed to sit inside the site's design language.
 *
 * THREE STATES, and the shipped HTML is the one that always works:
 *   1. as delivered (and with JavaScript off, and with cal.com blocked) — .bk-sch__fb is on screen
 *      with a plain <a href="https://cal.com/shujaurrahman/30min" target="_blank" rel="noopener">,
 *      plus the same link in the frame head, so a working route to the calendar is visible in
 *      every state of this section.
 *   2. embedding — assets/js/book/scheduler.js adds .is-embed, which reveals the mount and a
 *      BOUNDED wait bar (one pass, exactly as long as the script's timeout, no loop).
 *   3. settled — .is-ready (the embed reported linkReady) or .is-blocked (it failed or the wait ran
 *      out), which puts the fallback back with the warning line above it.
 *
 * Cal.com's embed script is the only third-party code on this page. No analytics, no other embeds.
 * Requires $BK (book.php). Locals are prefixed sch_.
 */
$sch_facts = [
    ['Length', $BK['mins'] . ' minutes', 'Long enough to be useful, short enough to be honest.'],
    // PLACEHOLDER: confirm the video platform and whether the link is sent by Cal.com before launch.
    ['Format', 'Video call', 'The joining link is in the calendar invitation.'],
    // PLACEHOLDER: confirm the languages discovery calls are offered in before launch.
    ['Language', 'English, or Hindi', 'Say which you prefer when you book.'],
    ['Time zone', 'Yours', null],
    ['Cost', 'None', 'There is nothing to sign and no obligation either way.'],
];
?>
<section class="band bk-sch" id="scheduler" aria-labelledby="scheduler-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The calendar</p>
        <h2 class="h2" id="scheduler-t"><span class="g">Pick a time.</span> That is the whole form.</h2>
      </div>
      <div>
        <p class="lead">This is our real calendar, not a request form. The times you can see are the
          times that are genuinely free, and the invitation is issued the moment you confirm.</p>
        <a class="tl" href="#agenda">See what the thirty minutes cover <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="bdh-grid bk-sch__grid">

      <!-- the event, stated once, so nothing in the embed has to be taken on trust -->
      <aside class="bdh-c4 bk-sch__rail" aria-labelledby="scheduler-ev" data-rv>
        <div class="bk-sch__card bdh-sticky">
          <p class="bk-k">Xterra Edze</p>
          <h3 class="bk-sch__evt" id="scheduler-ev">Discovery call</h3>
          <p class="bk-sch__evp">Tell us what you are building. We will tell you straight whether we are
            the right team for it, and what we would do first if we are.</p>

          <!-- PLACEHOLDER: confirm the video platform, the languages offered and that the call is free of charge before launch -->
          <dl class="bk-dl bk-sch__facts">
            <?php foreach ($sch_facts as $sch_f): ?>
              <div>
                <dt><?= e($sch_f[0]) ?></dt>
                <dd><?= e($sch_f[1]) ?><?php if ($sch_f[0] === 'Time zone'): ?><small><span data-bk-tz>The scheduler reads it from your browser.</span></small><?php elseif ($sch_f[2]): ?><small><?= e($sch_f[2]) ?></small><?php endif; ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>

          <p class="bk-note bk-note--blue bk-sch__held">
            <b>Confirmed by email</b>
            The slot is yours once the confirmation lands in your inbox. Until then, treat it as
            requested rather than held — and if nothing arrives within a few minutes, check the
            spam folder before booking again.
          </p>
        </div>
      </aside>

      <!-- the booker -->
      <div class="bdh-c8 bk-sch__main" data-bk-sch data-bk-cal="<?= e($BK['cal_link']) ?>" data-bk-origin="https://cal.com" data-rv data-rv-d="70">
        <div class="bk-sch__frame">
          <div class="bk-sch__head">
            <span class="bk-k">Scheduler</span>
            <a class="bk-ext bk-ext--sm bk-sch__src" href="<?= e($BK['cal_url']) ?>" target="_blank" rel="noopener">
              <span class="bk-ext__t">cal.com/<?= e($BK['cal_link']) ?></span> <i aria-hidden="true">&#8599;</i>
              <span class="sr">— opens the scheduler on cal.com in a new tab</span>
            </a>
          </div>

          <div class="bk-sch__body">
            <!-- Cal.com's element embed is mounted here. Empty on purpose: it holds nothing that
                 has to be readable, and it stays display:none until the script is actually running. -->
            <div class="bk-sch__mount" id="bk-cal-mount" data-bk-mount></div>

            <p class="bk-sch__wait" data-bk-wait hidden>
              <span class="bk-sch__waitbar" aria-hidden="true"><i></i></span>
              <span class="bk-sch__waitt">Loading the calendar from cal.com. If it has not appeared by the
                time this bar finishes, the direct link comes back.</span>
            </p>

            <div class="bk-sch__fb" data-bk-fb>
              <p class="bk-sch__warn" data-bk-warn hidden>
                The embedded calendar did not load. A browser extension, a corporate network or a
                content blocker will do that to a third-party embed. The link below is unaffected.
              </p>
              <span class="bk-sch__fbico" aria-hidden="true"><?= xt_icon('calendar') ?></span>
              <h3 class="bk-sch__fbt">Open the scheduler on cal.com</h3>
              <p class="bk-sch__fbp">Our calendar lives on Cal.com. It loads inside this frame when the
                embed is available; either way you are booking the same <?= (int) $BK['mins'] ?> minutes, with the
                same confirmation email.</p>
              <a class="btn btn--ink btn--lg" href="<?= e($BK['cal_url']) ?>" target="_blank" rel="noopener">
                Pick a time <span class="bk-x" aria-hidden="true">&#8599;</span>
                <span class="sr">(opens cal.com in a new tab)</span>
              </a>
              <p class="bk-sch__fbalt">Rather not use a scheduler?
                <a href="mailto:<?= e($BK['email']) ?>?subject=<?= rawurlencode('Discovery call') ?>">Email us</a> or
                <a href="<?= xe_url('contact.php') ?>">send a written brief</a>.</p>
            </div>
          </div>
        </div>

        <p class="bk-sch__meta">
          <span>Third-party embed</span>
          <span>Cal.com only</span>
          <span>No analytics on this page</span>
        </p>
        <p class="sr" aria-live="polite" data-bk-live></p>
      </div>

    </div>
  </div>
</section>
