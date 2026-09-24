<?php /* DRAFT COPY — review before launch */
/* Hero: the headline, then one customer's week drawn as a channel tape — every signal, every message, every
   message that was held or never sent, and why. Positions are computed here (hours from Monday 00:00 over 168). */
$mth_h_days  = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$mth_h_lanes = ['sig' => 'Signals', 'email' => 'Email', 'wa' => 'WhatsApp', 'sms' => 'SMS', 'push' => 'Push · in-app'];
/* [lane, day 0–6, hour, label, state: ok|hold|stop|sig|goal, label to the left] */
$mth_h_marks = [
    ['sig',   0, 10.2, 'Account created',         'sig',  0],
    ['email', 0, 10.3, 'Welcome · sent',          'ok',   0],
    ['sig',   1, 15.0, 'Viewed pricing',          'sig',  0],
    ['push',  1, 15.2, 'Setup tip · in-app',      'ok',   0],
    ['sig',   2, 22.1, 'Cart abandoned',          'sig',  0],
    ['wa',    2, 22.2, 'Held · quiet hours',      'hold', 1],
    ['wa',    3,  9.0, 'Cart reminder · sent',    'ok',   0],
    ['sig',   3, 18.5, 'Purchased · goal met',    'goal', 0],
    ['sms',   5, 10.0, 'Not sent · no SMS consent','stop', 1],
    ['email', 6, 18.0, 'Getting started · sent',  'ok',   1],
];
$mth_h_x = fn (int $mth_d, float $mth_hr): string => number_format((($mth_d * 24) + $mth_hr) / 168 * 100, 2, '.', '');
$mth_h_cap = $CAPS['ai-driven-marketing-automation'];
?>
<section class="band mth-hero" id="top" aria-labelledby="hero-t">
  <div class="wrap">
    <div class="mth-hero__top">
      <p class="lbl lbl--blue"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="d1" id="hero-t"><span class="g">Marketing that keeps working</span> between campaigns.</h1>
    </div>
    <div class="mth-hero__row">
      <p class="lead mth-hero__lead"><?= e($DISC['intro']) ?></p>
      <div class="mth-hero__act">
        <div class="mth-hero__btns">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'marketing-technology')) ?>">Start a martech brief <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out" href="#engine">Run the engine <span class="i" aria-hidden="true">›</span></a>
        </div>
        <dl class="mth-hero__meta">
          <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
          <div><dt>Channels</dt><dd>Email · SMS · WhatsApp · push · in-app</dd></div>
          <div><dt>Built to</dt><dd>DPDP Act 2023 · GDPR</dd></div>
        </dl>
      </div>
    </div>

    <figure class="mth-tape" data-bdh-live>
      <div class="mth-tape__bar" aria-hidden="true">
        <span class="bdh-pulse"></span><span>One customer · 7 days · every channel</span>
        <span class="mth-tape__sum"><span class="mth-chip mth-chip--ok">4 sent</span><span class="mth-chip mth-chip--hold">1 held</span><span class="mth-chip mth-chip--stop">1 not sent</span></span>
      </div>
      <div class="mth-tape__scroll bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="One customer's week across channels">
        <div class="mth-tape__plot" aria-hidden="true">
          <div class="mth-tape__days">
            <?php foreach ($mth_h_days as $mth_hd): ?><span><?= $mth_hd ?></span><?php endforeach; ?>
          </div>
          <?php foreach ($mth_h_lanes as $mth_hk => $mth_hl): ?>
          <div class="mth-tape__lane mth-tape__lane--<?= $mth_hk ?>">
            <span class="mth-tape__ln"><?= e($mth_hl) ?></span>
            <div class="mth-tape__track">
              <?php for ($mth_hq = 0; $mth_hq < 7; $mth_hq++): /* quiet hours 21:00–09:00, drawn as the night each day ends in */ ?>
              <i class="mth-tape__quiet" style="left:<?= $mth_h_x($mth_hq, 21) ?>%;width:<?= number_format(12 / 168 * 100, 2, '.', '') ?>%"></i>
              <?php endfor; ?>
              <?php foreach ($mth_h_marks as $mth_hi => $mth_hm): if ($mth_hm[0] !== $mth_hk) continue; ?>
              <span class="mth-tape__m mth-tape__m--<?= $mth_hm[4] ?><?= $mth_hm[5] ? ' mth-tape__m--r' : '' ?>" style="left:<?= $mth_h_x($mth_hm[1], $mth_hm[2]) ?>%;--mth-i:<?= $mth_hi ?>"><b></b><em><?= e($mth_hm[3]) ?></em></span>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <i class="mth-tape__now"></i>
        </div>
      </div>
      <p class="bdh-sr">An illustrative week for one customer: an account is created on Monday and a welcome email is sent; on Wednesday at 22:06 the cart is abandoned and the WhatsApp reminder is held for quiet hours until 09:00 on Thursday; the customer buys on Thursday evening and leaves the journey; a Saturday SMS is not sent because there is no SMS consent.</p>
      <figcaption class="mth-tape__cap">Illustrative. Shaded bands are quiet hours, 21:00–09:00 local. Every message is checked against consent, frequency and quiet hours at the moment it would be sent.</figcaption>
    </figure>
  </div>
</section>
