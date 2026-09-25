<?php /* DRAFT COPY — review before launch */
/**
 * Book · other — the three routes that are not a calendar, then one last way back to it.
 *
 * Reuses the page-layer .bk-seats primitive rather than inventing a fourth card style, and reuses
 * .bk-ext for the one external link, so every cal.com link on the page looks and behaves the same:
 * new tab, rel="noopener", and its own screen-reader suffix.
 *
 * Requires $BK (book.php). Locals are prefixed ot_.
 */
$ot_paths = [
    [
        'ico'   => 'chat',
        'h'     => 'Email us',
        'p'     => 'Best for a short question, a document, or an NDA you want signed before anything else happens. A person reads it; nothing is auto-replied.',
        'label' => $BK['email'],
        'href'  => 'mailto:' . $BK['email'],
        'ext'   => false,
        // PLACEHOLDER: confirm the email response time before launch
        'foot'  => 'Typically answered within one working day.',
    ],
    [
        'ico'   => 'doc',
        'h'     => 'Send a written brief',
        'p'     => 'The brief form asks for the shape of the work — which disciplines, which services, what is already in place — and reaches the same lead as a call.',
        'label' => 'Open the brief form',
        'href'  => xe_url('contact.php'),
        'ext'   => false,
        'foot'  => 'Better than a call if you already know what you want built.',
    ],
    [
        'ico'   => 'calendar',
        'h'     => 'Already booked',
        'p'     => 'Your confirmation email carries reschedule and cancel links. Use those rather than writing in, and the slot frees up for someone else straight away.',
        'label' => 'cal.com/' . $BK['cal_link'],
        'href'  => $BK['cal_url'],
        'ext'   => true,
        'foot'  => 'The same link books a second call for a colleague.',
    ],
];
?>
<section class="band bk-ot" id="other" aria-labelledby="other-t">
  <div class="wrap">

    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Other ways in</p>
      <h2 class="h2" id="other-t"><span class="g">If a call is not the first step,</span> there are three others.</h2>
    </div>

    <!-- PLACEHOLDER: confirm the email response time before launch (stated as typical below) -->
    <div class="bk-seats bk-seats--3 bk-ot__paths" data-rv data-rv-d="60">
      <?php foreach ($ot_paths as $ot_p): ?>
        <article class="bk-seat bk-ot__path">
          <span class="bk-seat__ico" aria-hidden="true"><?= xt_icon($ot_p['ico']) ?></span>
          <h3><?= e($ot_p['h']) ?></h3>
          <p><?= e($ot_p['p']) ?></p>
          <div class="bk-seat__foot bk-ot__foot">
            <?php if ($ot_p['ext']): ?>
              <a class="bk-ext bk-ext--sm" href="<?= e($ot_p['href']) ?>" target="_blank" rel="noopener">
                <span class="bk-ext__t"><?= e($ot_p['label']) ?></span> <i aria-hidden="true">&#8599;</i><span class="sr">— opens cal.com in a new tab</span>
              </a>
            <?php else: ?>
              <a class="tl" href="<?= e($ot_p['href']) ?>"><?= e($ot_p['label']) ?> <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
            <p class="bk-ot__note"><?= e($ot_p['foot']) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="bk-ot__back" data-rv data-rv-d="100">
      <div class="bk-ot__backt">
        <p class="bk-k">Still the fastest route</p>
        <p class="bk-ot__backp">All three land with the same people, so nothing above means starting
          again. A time on the calendar is simply the shortest path to an answer.</p>
      </div>
      <div class="bk-ot__backa">
        <a class="btn btn--ink" href="#scheduler">Back to the calendar <span class="i" aria-hidden="true">›</span></a>
        <a class="bk-ext bk-ext--sm" href="<?= e($BK['cal_url']) ?>" target="_blank" rel="noopener">
          <span class="bk-ext__t">Or open it on cal.com</span> <i aria-hidden="true">&#8599;</i><span class="sr">— opens in a new tab</span>
        </a>
      </div>
    </div>

  </div>
</section>
