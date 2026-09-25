<?php /* DRAFT COPY — review before launch */
/* Hero — the customer record. Text on paper, left. Right: an ink panel that bleeds to the viewport edge and
   holds one customer profile being resolved from four source systems, its consent states, its segments and
   the next action chosen for it. The HTML is the finished state: every row is already resolved and every
   readout is at its value. hero.js types the event feed and pulses the match rows while the panel is on
   screen. Reduced motion keeps the static panel.
   Every value shown is illustrative, not a client result, and the panel says so. */
$hero_sources = [
    // [system, what it knows, match type, flag style]
    ['Commerce',     'sha256(email) · order_id',      'Deterministic', ''],
    ['CRM',          'sha256(email) · sha256(phone)', 'Deterministic', ''],
    ['Support desk', 'requester_id · sha256(email)',  'Deterministic', ''],
    ['Web & app',    'device_id → login event',       'Stitched',      ' mth-flag--wait'],
];
$hero_consent = [
    // [channel, state class, basis]
    ['Email',              'on',   'Consent · preference centre'],
    ['WhatsApp',           'on',   'Opt-in · template approved'],
    ['SMS',                'wait', 'Not asked yet'],
    ['Ad personalisation', 'off',  'Denied · consent mode'],
];
$hero_segments = ['High value', 'Lapsing · 64 days', 'Service-first'];
$hero_nba = [
    ['Channel',    'WhatsApp'],
    ['Offer',      'Service reminder · no discount'],
    ['Moment',     '19:10 IST · quiet hours respected'],
    ['Confidence', '0.71 · threshold 0.60'],
    ['Fallback',   'Rule path · email at 09:00'],
];
/* the loop's own event feed: one line at a time, typed by hero.js (illustrative) */
$hero_feed = [
    ['09:14:02', 'collect',  'evt.order_placed · consent state attached at source'],
    ['09:14:02', 'resolve',  'prf_8f21c · 4 sources → 1 profile · 0 duplicates'],
    ['09:14:03', 'decide',   'segment high-value / lapsing · next best action 0.71'],
    ['09:14:03', 'consent',  'ad_personalization denied → audience push skipped'],
    ['09:14:04', 'produce',  'template svc_reminder · en-IN · brand check pass'],
    ['09:14:04', 'activate', 'whatsapp queued 19:10 IST · frequency cap 1 / 7d ok'],
    ['09:14:05', 'measure',  'holdout B · 10% held back · incremental revenue tracked'],
    ['09:14:06', 'approve',  'campaign send waiting on a named approver'],
];
// PLACEHOLDER: the readouts below are illustrative figures for a page mock — confirm or remove before launch
$hero_status = [
    ['profiles', 'Profiles per person', '1',      'unified'],
    ['consent',  'Consent enforced',    'At send', 'not at list build'],
    ['journeys', 'Journeys live',       '14',     'each with a holdout'],
    ['holdout',  'Holdout',            '10%',    'of every audience'],
];
?>
<section class="mth-hero" id="top" aria-labelledby="hero-t">
  <div class="mth-hero__bg" aria-hidden="true"><span class="mth-hero__grid dots"></span></div>

  <div class="wrap mth-hero__in">
    <div class="mth-hero__text">
      <p class="lbl lbl--blue mth-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="mth-hero__h mth-hero__up" id="hero-t" style="--i:1"><span class="g">One consented customer record.</span> Every channel acting on it.</h1>
      <p class="lead mth-hero__lead mth-hero__up" style="--i:2"><?= e($DISC['intro']) ?></p>
      <div class="mth-hero__act mth-hero__up" style="--i:3">
        <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'marketing-technology')) ?>">Start a marketing technology brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#studio">Open the Journey Studio <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="mth-hero__proof mth-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
        <div><dt>Scope</dt><dd>Data → activation → proof</dd></div>
        <div><dt>Delivery</dt><dd>AI-native</dd></div>
      </dl>
    </div>

    <div class="mth-hero__vis">
      <p class="bdh-sr">A mock of one customer profile inside the customer system. It is resolved from four source systems on hashed identifiers, carries a consent state per channel — email and WhatsApp granted, SMS not yet asked, ad personalisation denied — sits in the segments high value, lapsing for 64 days and service-first, and has one next action chosen for it: a WhatsApp service reminder at 19:10 India time, confidence 0.71 against a threshold of 0.60, with an email fallback. Every figure is illustrative.</p>

      <div class="mth-hero__panel mth-on-ink" aria-hidden="true" data-bdh-in data-bdh-live>
        <div class="mth-hero__bar">
          <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
          <span class="mth-hero__title">customer-system <i>/</i> your-brand</span>
          <span class="mth-hero__env">prod · in-region</span>
          <span class="bdh-ill">Illustrative</span>
          <span class="mth-live"><i class="bdh-pulse"></i>Live</span>
        </div>

        <div class="mth-hero__grid2">
          <div class="mth-hero__col">
            <p class="mth-k mth-hero__ck">Resolve · sources</p>
            <ul class="mth-hero__srcs">
              <?php foreach ($hero_sources as $hero_i => $hero_s): ?>
                <li class="mth-hero__src" style="--i:<?= $hero_i ?>">
                  <span class="mth-hero__sn"><?= e($hero_s[0]) ?></span>
                  <span class="mth-hero__sk"><?= e($hero_s[1]) ?></span>
                  <span class="mth-flag<?= e($hero_s[3]) ?>"><?= e($hero_s[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
            <p class="mth-hero__prof">
              <span class="mth-k">Profile</span>
              <b>prf_8f21c</b>
              <span class="mth-hero__pm">4 sources → 1 profile · 0 duplicates</span>
            </p>
            <p class="mth-k mth-hero__ck">Segments</p>
            <span class="bdh-tags mth-hero__segs"><?php foreach ($hero_segments as $hero_g): ?><span class="bdh-tag"><?= e($hero_g) ?></span><?php endforeach; ?></span>
          </div>

          <div class="mth-hero__col">
            <p class="mth-k mth-hero__ck">Consent · per channel</p>
            <ul class="mth-hero__cons">
              <?php foreach ($hero_consent as $hero_c2): ?>
                <li>
                  <span class="mth-hero__cn"><?= e($hero_c2[0]) ?></span>
                  <span class="mth-flag mth-flag--<?= e($hero_c2[1]) ?>"><?= $hero_c2[1] === 'on' ? 'Granted' : ($hero_c2[1] === 'off' ? 'Denied' : 'Unknown') ?></span>
                  <span class="mth-hero__cb"><?= e($hero_c2[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
            <p class="mth-k mth-hero__ck">Next best action</p>
            <dl class="mth-hero__nba">
              <?php foreach ($hero_nba as $hero_n): ?>
                <div><dt><?= e($hero_n[0]) ?></dt><dd><?= e($hero_n[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        </div>

        <p class="mth-hero__feed" data-feed="<?= e(json_encode($hero_feed, JSON_UNESCAPED_UNICODE)) ?>">
          <span class="mth-hero__fp">›</span><span class="mth-hero__ft"><?= e($hero_feed[0][0]) ?></span><span class="mth-hero__fs"><?= e($hero_feed[0][1]) ?></span><span class="mth-hero__fx"><span class="mth-hero__fxt"><?= e($hero_feed[0][2]) ?></span><span class="bdh-caret"></span></span>
        </p>

        <dl class="mth-hero__status">
          <?php foreach ($hero_status as $hero_st): ?>
            <div><dt><?= e($hero_st[1]) ?></dt><dd><b><?= e($hero_st[2]) ?></b> <?= e($hero_st[3]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
